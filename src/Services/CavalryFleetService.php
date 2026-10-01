<?php

namespace Chadvangaalen\Seat\Cavalry\Services;

use Chadvangaalen\Seat\Cavalry\Data\FleetEntry;
use Illuminate\Support\Collection;
use Seat\Eveapi\Models\Assets\CharacterAsset;
use Seat\Eveapi\Models\Assets\CorporationAsset;
use Seat\Eveapi\Models\Character\CharacterAffiliation;
use Seat\Eveapi\Models\Character\CharacterInfo;
use Seat\Eveapi\Models\Location\CharacterLocation;
use Seat\Eveapi\Models\Location\CharacterShip;
use Seat\Eveapi\Models\Sde\InvType;

class CavalryFleetService
{
    public function __construct(
        private readonly JumpCapableGroups $groups,
        private readonly LocationResolver $locations,
    ) {
    }

    /**
     * Build the fleet inventory for a corporation.
     *
     * @param  array{system_id?: int|null, group_ids?: int[], active_only?: bool}  $filters
     * @return array{
     *     entries: Collection<int, FleetEntry>,
     *     summary: array<string, array{key: string, label: string, icon: string, color: string, count: int}>,
     *     by_type: Collection,
     *     by_character: Collection,
     *     by_location: Collection,
     *     location_snapshot: Collection
     * }
     */
    public function forCorporation(int $corporationId, array $filters = []): array
    {
        $groupIds = $this->groups->ids();
        $typeIds = InvType::query()
            ->whereIn('groupID', $groupIds)
            ->pluck('typeID');

        $memberIds = CharacterAffiliation::query()
            ->where('corporation_id', $corporationId)
            ->pluck('character_id');

        $entries = collect()
            ->merge($this->characterHangarEntries($memberIds, $typeIds))
            ->merge($this->corporationHangarEntries($corporationId, $typeIds))
            ->merge($this->activeShipEntries($memberIds, $typeIds));

        $entries = $this->deduplicate($entries);
        $entries = $this->applyFilters($entries, $filters);

        return [
            'entries' => $entries->values(),
            'summary' => $this->buildSummary($entries),
            'by_type' => $this->groupByType($entries),
            'by_character' => $this->groupByCharacter($entries),
            'by_location' => $this->groupByLocation($entries),
            'location_snapshot' => $this->locationSnapshot($entries),
        ];
    }

    /**
     * @param  Collection<int, int>  $memberIds
     * @param  Collection<int, int>  $typeIds
     * @return Collection<int, FleetEntry>
     */
    private function characterHangarEntries(Collection $memberIds, Collection $typeIds): Collection
    {
        if ($memberIds->isEmpty() || $typeIds->isEmpty()) {
            return collect();
        }

        $assets = CharacterAsset::query()
            ->whereIn('character_id', $memberIds)
            ->whereIn('type_id', $typeIds)
            ->get();

        $assets = $this->locations->eagerLoadCharacterAssets($assets);

        return $assets->map(function (CharacterAsset $asset) {
            $groupId = (int) ($asset->type?->groupID ?? 0);
            $meta = $this->groups->meta($groupId);
            if (! $meta) {
                return null;
            }

            $location = $this->locations->fromCharacterAsset($asset);

            return new FleetEntry(
                item_id: (int) $asset->item_id,
                type_id: (int) $asset->type_id,
                type_name: $asset->type?->typeName ?? trans('web::seat.unknown'),
                group_id: $groupId,
                group_key: $meta['key'],
                group_label: $meta['label'],
                source: 'hangar',
                character_id: (int) $asset->character_id,
                character_name: $asset->character?->name,
                is_corporation: false,
                system_id: $location['system_id'],
                system_name: $location['system_name'],
                region_name: $location['region_name'],
                structure_id: $location['structure_id'],
                structure_name: $location['structure_name'],
                location_label: $location['location_label'],
                ship_name: $asset->name ?: null,
            );
        })->filter();
    }

    /**
     * @param  Collection<int, int>  $typeIds
     * @return Collection<int, FleetEntry>
     */
    private function corporationHangarEntries(int $corporationId, Collection $typeIds): Collection
    {
        if ($typeIds->isEmpty()) {
            return collect();
        }

        $assets = CorporationAsset::query()
            ->where('corporation_id', $corporationId)
            ->whereIn('type_id', $typeIds)
            ->get();

        $assets = $this->locations->eagerLoadCorporationAssets($assets);

        return $assets->map(function (CorporationAsset $asset) {
            $groupId = (int) ($asset->type?->groupID ?? 0);
            $meta = $this->groups->meta($groupId);
            if (! $meta) {
                return null;
            }

            $location = $this->locations->fromCorporationAsset($asset);

            return new FleetEntry(
                item_id: (int) $asset->item_id,
                type_id: (int) $asset->type_id,
                type_name: $asset->type?->typeName ?? trans('web::seat.unknown'),
                group_id: $groupId,
                group_key: $meta['key'],
                group_label: $meta['label'],
                source: 'corp',
                character_id: null,
                character_name: null,
                is_corporation: true,
                system_id: $location['system_id'],
                system_name: $location['system_name'],
                region_name: $location['region_name'],
                structure_id: $location['structure_id'],
                structure_name: $location['structure_name'],
                location_label: $location['location_label'],
                ship_name: $asset->name ?: null,
            );
        })->filter();
    }

    /**
     * @param  Collection<int, int>  $memberIds
     * @param  Collection<int, int>  $typeIds
     * @return Collection<int, FleetEntry>
     */
    private function activeShipEntries(Collection $memberIds, Collection $typeIds): Collection
    {
        if ($memberIds->isEmpty() || $typeIds->isEmpty()) {
            return collect();
        }

        $ships = CharacterShip::query()
            ->whereIn('character_id', $memberIds)
            ->whereIn('ship_type_id', $typeIds)
            ->with(['type', 'type.group'])
            ->get();

        $locations = CharacterLocation::query()
            ->whereIn('character_id', $memberIds)
            ->with(['solar_system', 'solar_system.region', 'station', 'structure'])
            ->get()
            ->keyBy('character_id');

        $characters = CharacterInfo::query()
            ->whereIn('character_id', $ships->pluck('character_id'))
            ->get()
            ->keyBy('character_id');

        return $ships->map(function (CharacterShip $ship) use ($locations, $characters) {
            $groupId = (int) ($ship->type?->groupID ?? 0);
            $meta = $this->groups->meta($groupId);
            if (! $meta) {
                return null;
            }

            $location = $this->locations->fromCharacterLocation(
                $locations->get($ship->character_id)
            );

            $character = $characters->get($ship->character_id);

            return new FleetEntry(
                item_id: (int) ($ship->ship_item_id ?? $ship->character_id),
                type_id: (int) $ship->ship_type_id,
                type_name: $ship->type?->typeName ?? trans('web::seat.unknown'),
                group_id: $groupId,
                group_key: $meta['key'],
                group_label: $meta['label'],
                source: 'active',
                character_id: (int) $ship->character_id,
                character_name: $character?->name,
                is_corporation: false,
                system_id: $location['system_id'],
                system_name: $location['system_name'],
                region_name: $location['region_name'],
                structure_id: $location['structure_id'],
                structure_name: $location['structure_name'],
                location_label: $location['location_label'],
                ship_name: $ship->ship_name ?? null,
            );
        })->filter();
    }

    /**
     * Prefer Active over Hangar when the same hull item appears in both.
     *
     * @param  Collection<int, FleetEntry>  $entries
     * @return Collection<int, FleetEntry>
     */
    private function deduplicate(Collection $entries): Collection
    {
        $priority = ['active' => 3, 'hangar' => 2, 'corp' => 1];

        return $entries
            ->groupBy(fn (FleetEntry $entry) => $entry->item_id)
            ->map(function (Collection $group) use ($priority) {
                return $group->sortByDesc(
                    fn (FleetEntry $entry) => $priority[$entry->source] ?? 0
                )->first();
            })
            ->values();
    }

    /**
     * @param  Collection<int, FleetEntry>  $entries
     * @param  array{system_id?: int|null, group_ids?: int[], active_only?: bool}  $filters
     * @return Collection<int, FleetEntry>
     */
    private function applyFilters(Collection $entries, array $filters): Collection
    {
        if (! empty($filters['active_only'])) {
            $entries = $entries->where('source', 'active');
        }

        if (! empty($filters['system_id'])) {
            $systemId = (int) $filters['system_id'];
            $entries = $entries->where('system_id', $systemId);
        }

        if (! empty($filters['group_ids']) && is_array($filters['group_ids'])) {
            $ids = array_map('intval', $filters['group_ids']);
            $entries = $entries->whereIn('group_id', $ids);
        }

        return $entries->values();
    }

    /**
     * @param  Collection<int, FleetEntry>  $entries
     * @return array<string, array{key: string, label: string, icon: string, color: string, count: int}>
     */
    private function buildSummary(Collection $entries): array
    {
        $counts = $entries->countBy(fn (FleetEntry $entry) => $entry->group_id);

        $summary = [];
        foreach ($this->groups->all() as $groupId => $meta) {
            $summary[$meta['key']] = [
                'key' => $meta['key'],
                'label' => $meta['label'],
                'icon' => $meta['icon'],
                'color' => $meta['color'],
                'count' => (int) ($counts[$groupId] ?? 0),
                'group_id' => (int) $groupId,
            ];
        }

        return $summary;
    }

    /**
     * @param  Collection<int, FleetEntry>  $entries
     */
    private function groupByType(Collection $entries): Collection
    {
        $orderedKeys = array_column(array_values($this->groups->all()), 'key');

        return $entries
            ->groupBy(fn (FleetEntry $entry) => $entry->group_key)
            ->sortBy(fn ($group, $key) => array_search($key, $orderedKeys, true))
            ->map(function (Collection $group) {
                return [
                    'label' => $group->first()->group_label,
                    'key' => $group->first()->group_key,
                    'count' => $group->count(),
                    'entries' => $group->sortBy('type_name')->values(),
                ];
            });
    }

    /**
     * Characters without capitals/blops are omitted.
     *
     * @param  Collection<int, FleetEntry>  $entries
     */
    private function groupByCharacter(Collection $entries): Collection
    {
        return $entries
            ->filter(fn (FleetEntry $entry) => ! $entry->is_corporation)
            ->groupBy(fn (FleetEntry $entry) => $entry->character_id ?? 0)
            ->map(function (Collection $group) {
                /** @var FleetEntry $first */
                $first = $group->first();

                return [
                    'character_id' => $first->character_id,
                    'character_name' => $first->character_name ?? trans('web::seat.unknown'),
                    'count' => $group->count(),
                    'entries' => $group->sortBy('type_name')->values(),
                ];
            })
            ->sortByDesc('count')
            ->values()
            ->concat(
                $entries
                    ->filter(fn (FleetEntry $entry) => $entry->is_corporation)
                    ->pipe(function (Collection $corpEntries) {
                        if ($corpEntries->isEmpty()) {
                            return collect();
                        }

                        return collect([[
                            'character_id' => null,
                            'character_name' => trans('cavalry::seat.corporation_hangar'),
                            'count' => $corpEntries->count(),
                            'entries' => $corpEntries->sortBy('type_name')->values(),
                        ]]);
                    })
            );
    }

    /**
     * @param  Collection<int, FleetEntry>  $entries
     */
    private function groupByLocation(Collection $entries): Collection
    {
        return $entries
            ->groupBy(fn (FleetEntry $entry) => $entry->locationKey())
            ->map(function (Collection $systemGroup) {
                /** @var FleetEntry $first */
                $first = $systemGroup->first();

                $structures = $systemGroup
                    ->groupBy(fn (FleetEntry $entry) => $entry->structureKey())
                    ->map(function (Collection $structureGroup) {
                        /** @var FleetEntry $entry */
                        $entry = $structureGroup->first();
                        $label = $entry->structure_name
                            ?? ($entry->system_id
                                ? trans('cavalry::seat.undocked')
                                : trans('cavalry::seat.unknown_location'));

                        return [
                            'key' => $entry->structureKey(),
                            'label' => $label,
                            'count' => $structureGroup->count(),
                            'entries' => $structureGroup->sortBy('type_name')->values(),
                        ];
                    })
                    ->sortByDesc('count')
                    ->values();

                return [
                    'system_id' => $first->system_id,
                    'system_name' => $first->system_name ?? trans('cavalry::seat.unknown_location'),
                    'region_name' => $first->region_name,
                    'count' => $systemGroup->count(),
                    'structures' => $structures,
                ];
            })
            ->sortByDesc('count')
            ->values();
    }

    /**
     * @param  Collection<int, FleetEntry>  $entries
     */
    private function locationSnapshot(Collection $entries): Collection
    {
        return $entries
            ->groupBy(fn (FleetEntry $entry) => $entry->locationKey())
            ->map(function (Collection $group) {
                /** @var FleetEntry $first */
                $first = $group->first();

                return [
                    'system_id' => $first->system_id,
                    'system_name' => $first->system_name ?? trans('cavalry::seat.unknown_location'),
                    'count' => $group->count(),
                ];
            })
            ->sortByDesc('count')
            ->values()
            ->take(8);
    }
}
