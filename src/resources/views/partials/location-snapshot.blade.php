@if($snapshot->isNotEmpty())
    <div class="card cavalry-card mb-3">
        <div class="card-header">
            <h3 class="card-title">{{ trans('cavalry::seat.location_snapshot') }}</h3>
        </div>
        <div class="card-body py-2">
            @foreach($snapshot as $item)
                @php
                    $chipSystemId = $item['system_id'] ?? null;
                    $isActive = $chipSystemId && ($filters['system_id'] ?? null) == $chipSystemId;
                    $chipClasses = 'cavalry-chip'
                        . ($loop->first && empty($filters['system_id']) ? ' is-lead' : '')
                        . ($isActive ? ' is-active' : '');
                @endphp
                @if($chipSystemId)
                    @php
                        $query = request()->except(['system_id']);
                        if (! $isActive) {
                            $query['system_id'] = $chipSystemId;
                        }
                        $href = route('cavalry::corporation', ['corporation' => $corporation->corporation_id]);
                        if (! empty($query)) {
                            $href .= '?' . http_build_query($query);
                        }
                    @endphp
                    <a href="{{ $href }}"
                       class="{{ $chipClasses }}"
                       @if($isActive) aria-pressed="true" @endif>
                        {{ $item['system_name'] }}
                        <strong>{{ $item['count'] }}</strong>
                    </a>
                @else
                    <span class="{{ $chipClasses }}">
                        {{ $item['system_name'] }}
                        <strong>{{ $item['count'] }}</strong>
                    </span>
                @endif
            @endforeach
        </div>
    </div>
@endif
