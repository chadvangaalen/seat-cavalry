@if($snapshot->isNotEmpty())
    <div class="card card-outline card-secondary mb-3">
        <div class="card-header">
            <h3 class="card-title">{{ trans('cavalry::seat.location_snapshot') }}</h3>
        </div>
        <div class="card-body py-2">
            @foreach($snapshot as $item)
                <span class="badge badge-{{ $loop->first ? 'primary' : 'secondary' }} p-2 mr-1 mb-1">
                    {{ $item['system_name'] }}
                    <strong>{{ $item['count'] }}</strong>
                </span>
            @endforeach
        </div>
    </div>
@endif
