<div class="accordion" id="cavalry-by-character">
    @forelse($characters as $character)
        @php
            $cid = $character['character_id'] ?? 'corp';
        @endphp
        <div class="card">
            <div class="card-header" id="heading-char-{{ $cid }}">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left"
                            type="button"
                            data-toggle="collapse"
                            data-target="#collapse-char-{{ $cid }}"
                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                        @if($character['character_id'])
                            {!! img('characters', 'portrait', $character['character_id'], 32, ['class' => 'img-circle eve-icon small-icon mr-1']) !!}
                        @endif
                        {{ $character['character_name'] }} ({{ $character['count'] }})
                    </button>
                </h2>
            </div>
            <div id="collapse-char-{{ $cid }}"
                 class="collapse {{ $loop->first ? 'show' : '' }}"
                 data-parent="#cavalry-by-character">
                <div class="card-body p-0">
                    @include('cavalry::partials.ship-table', ['entries' => $character['entries'], 'show_owner' => false, 'show_group' => true])
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted mb-0">{{ trans('cavalry::seat.no_ships') }}</p>
    @endforelse
</div>
