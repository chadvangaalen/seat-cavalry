@php
    $showOwner = $show_owner ?? true;
    $showGroup = $show_group ?? false;
    $showLocation = $show_location ?? true;
@endphp

<div class="table-responsive">
    <table class="table table-sm table-striped table-hover mb-0 cavalry-ship-table">
        <thead>
        <tr>
            <th>{{ trans('cavalry::seat.hull') }}</th>
            @if($showGroup)
                <th>{{ trans('cavalry::seat.group') }}</th>
            @endif
            @if($showOwner)
                <th>{{ trans('cavalry::seat.owner') }}</th>
            @endif
            @if($showLocation)
                <th>{{ trans('cavalry::seat.location') }}</th>
            @endif
            <th>{{ trans('cavalry::seat.status') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($entries as $entry)
            <tr>
                <td>
                    {!! img('types', 'icon', $entry->type_id, 32, ['class' => 'img-circle eve-icon small-icon']) !!}
                    <strong>{{ $entry->type_name }}</strong>
                    @if($entry->ship_name)
                        <span class="text-muted">({{ $entry->ship_name }})</span>
                    @endif
                </td>
                @if($showGroup)
                    <td>{{ $entry->group_label }}</td>
                @endif
                @if($showOwner)
                    <td>
                        @if($entry->character_id)
                            {!! img('characters', 'portrait', $entry->character_id, 32, ['class' => 'img-circle eve-icon small-icon']) !!}
                        @endif
                        {{ $entry->ownerLabel() }}
                    </td>
                @endif
                @if($showLocation)
                    <td>{{ $entry->location_label }}</td>
                @endif
                <td>
                    <span class="badge {{ $entry->statusBadgeClass() }}">{{ $entry->statusLabel() }}</span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
