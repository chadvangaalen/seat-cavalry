<?php

namespace Chadvangaalen\Seat\Cavalry\Http\Controllers;

use Chadvangaalen\Seat\Cavalry\Services\CavalryFleetService;
use Chadvangaalen\Seat\Cavalry\Services\JumpCapableGroups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Seat\Eveapi\Models\Corporation\CorporationInfo;
use Seat\Eveapi\Models\Sde\SolarSystem;
use Seat\Web\Http\Controllers\Controller;

class CavalryController extends Controller
{
    public function __construct(
        private readonly CavalryFleetService $fleet,
        private readonly JumpCapableGroups $groups,
    ) {
    }

    public function index(Request $request)
    {
        $corporations = $this->accessibleCorporations();

        if ($corporations->isEmpty()) {
            return view('cavalry::overview', [
                'corporations' => $corporations,
                'corporation' => null,
                'fleet' => null,
                'groups' => $this->groups->all(),
                'filters' => $this->filtersFromRequest($request),
                'systems' => collect(),
            ]);
        }

        $corporationId = $request->filled('corporation_id')
            ? (int) $request->input('corporation_id')
            : $this->defaultCorporationId($corporations);

        $corporation = $corporations->firstWhere('corporation_id', $corporationId)
            ?? $corporations->first();

        return $this->renderOverview($request, $corporation, $corporations);
    }

    /**
     * Prefer the logged-in user's main character corporation when it is accessible.
     */
    private function defaultCorporationId($corporations): int
    {
        $userCorpId = auth()->user()->main_character?->affiliation?->corporation_id;

        if ($userCorpId && $corporations->contains('corporation_id', (int) $userCorpId)) {
            return (int) $userCorpId;
        }

        return (int) $corporations->first()->corporation_id;
    }

    public function show(Request $request, CorporationInfo $corporation)
    {
        $corporations = $this->accessibleCorporations();

        if (! $corporations->contains('corporation_id', $corporation->corporation_id)) {
            return redirect()->route('seatcore::auth.unauthorized');
        }

        return $this->renderOverview($request, $corporation, $corporations);
    }

    private function renderOverview(Request $request, CorporationInfo $corporation, $corporations)
    {
        $filters = $this->filtersFromRequest($request);
        $fleet = $this->fleet->forCorporation((int) $corporation->corporation_id, $filters);

        return view('cavalry::overview', [
            'corporations' => $corporations,
            'corporation' => $corporation,
            'fleet' => $fleet,
            'groups' => $this->groups->all(),
            'filters' => $filters,
            'systems' => $this->systemsForSelect($fleet['entries']),
        ]);
    }

    /**
     * Corporations the viewer may inspect: admins see all; others need
     * corporation.summary or corporation.asset (or director/CEO via those policies).
     */
    private function accessibleCorporations()
    {
        $query = CorporationInfo::query()->orderBy('name');

        if (auth()->user()->isAdmin()) {
            return $query->get();
        }

        return $query->get()
            ->filter(function (CorporationInfo $corporation) {
                return Gate::allows('corporation.summary', $corporation)
                    || Gate::allows('corporation.asset', $corporation);
            })
            ->values();
    }

    /**
     * @return array{system_id: ?int, group_ids: int[], active_only: bool}
     */
    private function filtersFromRequest(Request $request): array
    {
        $groupIds = $request->input('group_ids', []);
        if (! is_array($groupIds)) {
            $groupIds = [];
        }

        return [
            'system_id' => $request->filled('system_id') ? (int) $request->input('system_id') : null,
            'group_ids' => array_map('intval', $groupIds),
            'active_only' => $request->boolean('active_only'),
        ];
    }

    private function systemsForSelect($entries)
    {
        $systemIds = $entries
            ->pluck('system_id')
            ->filter()
            ->unique()
            ->values();

        if ($systemIds->isEmpty()) {
            return collect();
        }

        return SolarSystem::query()
            ->whereIn('system_id', $systemIds)
            ->orderBy('name')
            ->get(['system_id', 'name']);
    }
}
