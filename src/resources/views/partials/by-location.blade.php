<div class="accordion" id="cavalry-by-location">
    @forelse($locations as $location)
        @php
            $sid = $location['system_id'] ?? 'unknown';
        @endphp
        <div class="card">
            <div class="card-header" id="heading-loc-{{ $sid }}">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left"
                            type="button"
                            data-toggle="collapse"
                            data-target="#collapse-loc-{{ $sid }}"
                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                        <strong>{{ $location['system_name'] }}</strong>
                        ({{ $location['count'] }})
                        @if(!empty($location['region_name']))
                            <span class="text-muted">— {{ $location['region_name'] }}</span>
                        @endif
                    </button>
                </h2>
            </div>
            <div id="collapse-loc-{{ $sid }}"
                 class="collapse {{ $loop->first ? 'show' : '' }}"
                 data-parent="#cavalry-by-location">
                <div class="card-body">
                    @foreach($location['structures'] as $structure)
                        <h5 class="mt-2 mb-2">
                            {{ $structure['label'] }}
                            <span class="badge badge-secondary">{{ $structure['count'] }}</span>
                        </h5>
                        @include('cavalry::partials.ship-table', [
                            'entries' => $structure['entries'],
                            'show_location' => false,
                            'show_group' => true,
                        ])
                    @endforeach
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted mb-0">{{ trans('cavalry::seat.no_ships') }}</p>
    @endforelse
</div>
