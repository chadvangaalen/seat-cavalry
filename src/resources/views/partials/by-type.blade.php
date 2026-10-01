<div class="accordion cavalry-accordion" id="cavalry-by-type">
    @forelse($groups as $group)
        <div class="card">
            <div class="card-header" id="heading-type-{{ $group['key'] }}">
                <h2 class="mb-0">
                    <button class="cavalry-accordion-toggle"
                            type="button"
                            data-toggle="collapse"
                            data-target="#collapse-type-{{ $group['key'] }}"
                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                        {{ $group['label'] }} ({{ $group['count'] }})
                    </button>
                </h2>
            </div>
            <div id="collapse-type-{{ $group['key'] }}"
                 class="collapse {{ $loop->first ? 'show' : '' }}"
                 data-parent="#cavalry-by-type">
                <div class="card-body p-0">
                    @include('cavalry::partials.ship-table', ['entries' => $group['entries'], 'show_group' => false])
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted mb-0">{{ trans('cavalry::seat.no_ships') }}</p>
    @endforelse
</div>
