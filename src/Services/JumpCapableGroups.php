<?php

namespace Chadvangaalen\Seat\Cavalry\Services;

class JumpCapableGroups
{
    /**
     * @return array<int, array{key: string, label: string, icon: string, color: string}>
     */
    public function all(): array
    {
        return config('cavalry.ships.groups', []);
    }

    /**
     * @return int[]
     */
    public function ids(): array
    {
        return array_map('intval', array_keys($this->all()));
    }

    public function meta(int $groupId): ?array
    {
        return $this->all()[$groupId] ?? null;
    }

    public function key(int $groupId): string
    {
        return $this->meta($groupId)['key'] ?? 'unknown';
    }

    public function label(int $groupId): string
    {
        return $this->meta($groupId)['label'] ?? 'Unknown';
    }
}
