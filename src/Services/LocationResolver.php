<?php

namespace Chadvangaalen\Seat\Cavalry\Services;

use Illuminate\Support\Collection;
use Seat\Eveapi\Models\Assets\CharacterAsset;
use Seat\Eveapi\Models\Assets\CorporationAsset;
use Seat\Eveapi\Models\Location\CharacterLocation;
use Seat\Eveapi\Models\Sde\SolarSystem;
use Seat\Eveapi\Models\Universe\UniverseStation;
use Seat\Eveapi\Models\Universe\UniverseStructure;

class LocationResolver
{
    private const MAX_DEPTH = 8;

    /**
     * Resolve a character asset (including nested hangars) to a location payload.
     *
     * @return array{
     *     system_id: ?int,
     *     system_name: ?string,
     *     region_name: ?string,
     *     structure_id: ?int,
     *     structure_name: ?string,
     *     location_label: string
     * }
     */
    public function fromCharacterAsset(CharacterAsset $asset): array
    {
        $current = $asset;
        $depth = 0;

        while ($depth < self::MAX_DEPTH && $current) {
            $resolved = $this->resolveByLocationFields(
                $current->location_type ?? null,
                (int) $current->location_id,
                $current->map_name ?? null,
            );

            if ($resolved['system_id'] || $resolved['structure_name']) {
                return $resolved;
            }

            // Walk up into the parent container when location is another asset.
            if ($current->relationLoaded('container') && $current->container?->item_id) {
                $current = $current->container;
                $depth++;
                continue;
            }

            $parent = CharacterAsset::query()
                ->with(['station', 'structure', 'solar_system', 'container'])
                ->find($current->location_id);

            if (! $parent) {
                break;
            }

            $current = $parent;
            $depth++;
        }

        return $this->unknown();
    }

    /**
     * Resolve a corporation asset (including office / division nesting).
     *
     * @return array{
     *     system_id: ?int,
     *     system_name: ?string,
     *     region_name: ?string,
     *     structure_id: ?int,
     *     structure_name: ?string,
     *     location_label: string
     * }
     */
    public function fromCorporationAsset(CorporationAsset $asset): array
    {
        $current = $asset;
        $depth = 0;

        while ($depth < self::MAX_DEPTH && $current) {
            $resolved = $this->resolveByLocationFields(
                $current->location_type ?? null,
                (int) $current->location_id,
                $current->name ?? null,
            );

            if ($resolved['system_id'] || $resolved['structure_name']) {
                return $resolved;
            }

            if ($current->relationLoaded('container') && $current->container?->item_id) {
                $current = $current->container;
                $depth++;
                continue;
            }

            $parent = CorporationAsset::query()
                ->with(['station', 'structure', 'solar_system', 'container'])
                ->find($current->location_id);

            if (! $parent) {
                break;
            }

            $current = $parent;
            $depth++;
        }

        return $this->unknown();
    }

    /**
     * Resolve an active character location.
     *
     * @return array{
     *     system_id: ?int,
     *     system_name: ?string,
     *     region_name: ?string,
     *     structure_id: ?int,
     *     structure_name: ?string,
     *     location_label: string
     * }
     */
    public function fromCharacterLocation(?CharacterLocation $location): array
    {
        if (! $location) {
            return $this->unknown();
        }

        $systemId = $location->solar_system_id ? (int) $location->solar_system_id : null;
        $system = $systemId
            ? SolarSystem::query()->with('region')->find($systemId)
            : ($location->relationLoaded('solar_system') ? $location->solar_system : null);

        $structureName = null;
        $structureId = null;

        if ($location->station_id) {
            $structureId = (int) $location->station_id;
            $structureName = $location->station?->name
                ?? UniverseStation::query()->find($structureId)?->name;
        } elseif ($location->structure_id) {
            $structureId = (int) $location->structure_id;
            $structureName = $location->structure?->name
                ?? UniverseStructure::query()->find($structureId)?->name;
        }

        $systemName = $system?->name;
        $regionName = $system?->region?->name ?? $system?->region_id;

        if (is_numeric($regionName)) {
            $regionName = null;
        }

        return $this->pack(
            $systemId,
            $systemName,
            is_string($regionName) ? $regionName : null,
            $structureId,
            $structureName,
        );
    }

    /**
     * @return array{
     *     system_id: ?int,
     *     system_name: ?string,
     *     region_name: ?string,
     *     structure_id: ?int,
     *     structure_name: ?string,
     *     location_label: string
     * }
     */
    private function resolveByLocationFields(?string $locationType, int $locationId, ?string $fallbackName = null): array
    {
        if ($locationType === 'station' || ($locationId >= 60000000 && $locationId < 64000000)) {
            $station = UniverseStation::query()->with('solar_system.region')->find($locationId);
            if ($station) {
                return $this->pack(
                    $station->system_id ? (int) $station->system_id : null,
                    $station->solar_system?->name,
                    $station->solar_system?->region?->name,
                    (int) $station->station_id,
                    $station->name,
                );
            }
        }

        if ($locationType === 'solar_system' || ($locationId >= 30000000 && $locationId < 32000000)) {
            $system = SolarSystem::query()->with('region')->find($locationId);
            if ($system) {
                return $this->pack(
                    (int) $system->system_id,
                    $system->name,
                    $system->region?->name,
                    null,
                    $fallbackName,
                );
            }
        }

        // Structures / items often use "other" / "item" location types.
        $structure = UniverseStructure::query()->with('solar_system.region')->find($locationId);
        if ($structure) {
            return $this->pack(
                $structure->solar_system_id ? (int) $structure->solar_system_id : null,
                $structure->solar_system?->name,
                $structure->solar_system?->region?->name,
                (int) $structure->structure_id,
                $structure->name,
            );
        }

        $station = UniverseStation::query()->with('solar_system.region')->find($locationId);
        if ($station) {
            return $this->pack(
                $station->system_id ? (int) $station->system_id : null,
                $station->solar_system?->name,
                $station->solar_system?->region?->name,
                (int) $station->station_id,
                $station->name,
            );
        }

        $system = SolarSystem::query()->with('region')->find($locationId);
        if ($system) {
            return $this->pack(
                (int) $system->system_id,
                $system->name,
                $system->region?->name,
                null,
                $fallbackName,
            );
        }

        return $this->unknown();
    }

    /**
     * @return array{
     *     system_id: ?int,
     *     system_name: ?string,
     *     region_name: ?string,
     *     structure_id: ?int,
     *     structure_name: ?string,
     *     location_label: string
     * }
     */
    private function pack(
        ?int $systemId,
        ?string $systemName,
        ?string $regionName,
        ?int $structureId,
        ?string $structureName,
    ): array {
        $parts = array_filter([$systemName, $structureName]);

        return [
            'system_id' => $systemId,
            'system_name' => $systemName,
            'region_name' => $regionName,
            'structure_id' => $structureId,
            'structure_name' => $structureName,
            'location_label' => $parts
                ? implode(' / ', $parts)
                : trans('cavalry::seat.unknown_location'),
        ];
    }

    /**
     * @return array{
     *     system_id: ?int,
     *     system_name: ?string,
     *     region_name: ?string,
     *     structure_id: ?int,
     *     structure_name: ?string,
     *     location_label: string
     * }
     */
    private function unknown(): array
    {
        return [
            'system_id' => null,
            'system_name' => null,
            'region_name' => null,
            'structure_id' => null,
            'structure_name' => null,
            'location_label' => trans('cavalry::seat.unknown_location'),
        ];
    }

    /**
     * Prefetch related models for a collection of assets to reduce N+1 lookups.
     */
    public function eagerLoadCharacterAssets(Collection $assets): Collection
    {
        return $assets->loadMissing([
            'type',
            'type.group',
            'character',
            'station',
            'structure',
            'solar_system',
            'solar_system.region',
            'container',
            'container.station',
            'container.structure',
            'container.solar_system',
            'container.container',
            'container.container.station',
            'container.container.structure',
            'container.container.solar_system',
        ]);
    }

    public function eagerLoadCorporationAssets(Collection $assets): Collection
    {
        return $assets->loadMissing([
            'type',
            'type.group',
            'station',
            'structure',
            'solar_system',
            'solar_system.region',
            'container',
            'container.station',
            'container.structure',
            'container.solar_system',
            'container.container',
            'container.container.station',
            'container.container.structure',
            'container.container.solar_system',
        ]);
    }
}
