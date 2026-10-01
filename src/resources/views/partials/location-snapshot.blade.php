@if($snapshot->isNotEmpty())
    <div class="card cavalry-card mb-3">
        <div class="card-header">
            <h3 class="card-title">{{ trans('cavalry::seat.location_snapshot') }}</h3>
        </div>
        <div class="card-body py-2">
            @foreach($snapshot as $item)
                <span class="cavalry-chip {{ $loop->first ? 'is-lead' : '' }}">
                    {{ $item['system_name'] }}
                    <strong>{{ $item['count'] }}</strong>
                </span>
            @endforeach
        </div>
    </div>
@endif
