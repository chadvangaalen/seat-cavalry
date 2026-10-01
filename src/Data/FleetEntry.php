<?php

namespace Chadvangaalen\Seat\Cavalry\Data;

class FleetEntry
{
    public function __construct(
        public readonly int $item_id,
        public readonly int $type_id,
        public readonly string $type_name,
        public readonly int $group_id,
        public readonly string $group_key,
        public readonly string $group_label,
        public readonly string $source,
        public readonly ?int $character_id,
        public readonly ?string $character_name,
        public readonly bool $is_corporation,
        public readonly ?int $system_id,
        public readonly ?string $system_name,
        public readonly ?string $region_name,
        public readonly ?int $structure_id,
        public readonly ?string $structure_name,
        public readonly string $location_label,
        public readonly ?string $ship_name = null,
    ) {
    }

    public function ownerLabel(): string
    {
        if ($this->is_corporation) {
            return trans('cavalry::seat.corporation_hangar');
        }

        return $this->character_name ?? trans('web::seat.unknown');
    }

    public function statusLabel(): string
    {
        return match ($this->source) {
            'active' => trans('cavalry::seat.status_active'),
            'corp' => trans('cavalry::seat.status_corp'),
            default => trans('cavalry::seat.status_hangar'),
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->source) {
            'active' => 'badge-success',
            'corp' => 'badge-info',
            default => 'badge-secondary',
        };
    }

    public function locationKey(): string
    {
        if ($this->system_id) {
            return (string) $this->system_id;
        }

        return 'unknown';
    }

    public function structureKey(): string
    {
        if ($this->structure_id) {
            return 's:' . $this->structure_id;
        }

        if ($this->structure_name) {
            return 'n:' . $this->structure_name;
        }

        if ($this->system_id) {
            return 'space';
        }

        return 'unknown';
    }
}
