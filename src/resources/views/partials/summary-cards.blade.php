<div class="row cavalry-metrics">
    @foreach($summary as $card)
        @php
            $groupId = (int) $card['group_id'];
            $activeGroupIds = array_map('intval', $filters['group_ids'] ?? []);
            $isActive = count($activeGroupIds) === 1 && $activeGroupIds[0] === $groupId;
            $query = request()->except(['group_ids']);
            if (! $isActive) {
                $query['group_ids'] = [$groupId];
            }
            $href = route('cavalry::corporation', ['corporation' => $corporation->corporation_id]);
            if (! empty($query)) {
                $href .= '?' . http_build_query($query);
            }
        @endphp
        <div class="col-md-3 col-sm-6 col-12">
            <a href="{{ $href }}"
               class="info-box cavalry-metric {{ $isActive ? 'is-active' : '' }}"
               @if($isActive) aria-pressed="true" @endif>
                <span class="info-box-icon cavalry-metric-icon cavalry-metric-icon--{{ $card['accent'] }}">
                    <i class="{{ $card['icon'] }}"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ $card['label'] }}</span>
                    <span class="info-box-number">{{ number_format($card['count']) }}</span>
                </div>
            </a>
        </div>
    @endforeach
</div>
