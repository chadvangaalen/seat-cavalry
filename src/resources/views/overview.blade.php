@extends('web::layouts.grids.12')

@section('title', trans('cavalry::seat.page_title'))
@section('page_header', trans('cavalry::seat.page_title'))
@section('page_description', trans('cavalry::seat.page_description'))

@section('full')

    @if($corporations->isEmpty() || is_null($corporation))
        <div class="alert alert-warning">
            {{ trans('cavalry::seat.no_corporation') }}
        </div>
    @else
        <div class="mb-3">
            <form method="get" action="{{ route('cavalry::corporation', ['corporation' => $corporation->corporation_id]) }}" class="form-inline" id="cavalry-corp-form">
                <label class="mr-2" for="corporation_id">{{ trans('cavalry::seat.select_corporation') }}</label>
                <select name="corporation_id" id="corporation_id" class="form-control form-control-sm select2" style="min-width: 260px;">
                    @foreach($corporations as $corp)
                        <option value="{{ $corp->corporation_id }}" @selected($corp->corporation_id == $corporation->corporation_id)>
                            {{ $corp->name }} [{{ $corp->ticker }}]
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        @include('cavalry::partials.summary-cards', ['summary' => $fleet['summary']])

        @include('cavalry::partials.location-snapshot', ['snapshot' => $fleet['location_snapshot']])

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">{{ trans('cavalry::seat.filters') }}</h3>
            </div>
            <div class="card-body">
                <form method="get" action="{{ route('cavalry::corporation', ['corporation' => $corporation->corporation_id]) }}" id="cavalry-filter-form">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="system_id">{{ trans('cavalry::seat.filter_system') }}</label>
                                <select name="system_id" id="system_id" class="form-control select2">
                                    <option value="">—</option>
                                    @foreach($systems as $system)
                                        <option value="{{ $system->system_id }}" @selected(($filters['system_id'] ?? null) == $system->system_id)>
                                            {{ $system->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="group_ids">{{ trans('cavalry::seat.filter_groups') }}</label>
                                <select name="group_ids[]" id="group_ids" class="form-control select2" multiple>
                                    @foreach($groups as $groupId => $meta)
                                        <option value="{{ $groupId }}" @selected(in_array($groupId, $filters['group_ids'] ?? [], true))>
                                            {{ $meta['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="d-block">&nbsp;</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="active_only" name="active_only" value="1" @checked(!empty($filters['active_only']))>
                                    <label class="custom-control-label" for="active_only">{{ trans('cavalry::seat.filter_active_only') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">{{ trans('cavalry::seat.apply_filters') }}</button>
                    <a href="{{ route('cavalry::corporation', ['corporation' => $corporation->corporation_id]) }}" class="btn btn-default btn-sm">{{ trans('cavalry::seat.clear_filters') }}</a>
                </form>
            </div>
        </div>

        @if($fleet['entries']->isEmpty())
            <div class="alert alert-info">
                {{ trans('cavalry::seat.no_ships') }}
            </div>
        @else
            <div class="card card-primary card-outline card-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="cavalry-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="by-type-tab" data-toggle="pill" href="#by-type" role="tab">
                                {{ trans('cavalry::seat.tab_by_type') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="by-character-tab" data-toggle="pill" href="#by-character" role="tab">
                                {{ trans('cavalry::seat.tab_by_character') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="by-location-tab" data-toggle="pill" href="#by-location" role="tab">
                                {{ trans('cavalry::seat.tab_by_location') }}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="cavalry-tabs-content">
                        <div class="tab-pane fade show active" id="by-type" role="tabpanel">
                            @include('cavalry::partials.by-type', ['groups' => $fleet['by_type']])
                        </div>
                        <div class="tab-pane fade" id="by-character" role="tabpanel">
                            @include('cavalry::partials.by-character', ['characters' => $fleet['by_character']])
                        </div>
                        <div class="tab-pane fade" id="by-location" role="tabpanel">
                            @include('cavalry::partials.by-location', ['locations' => $fleet['by_location']])
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif

@stop

@push('javascript')
<script>
    $(function () {
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%'
        });

        $('#corporation_id').on('change', function () {
            var id = $(this).val();
            window.location = '{{ url('/cavalry/corporation') }}/' + id;
        });
    });
</script>
@endpush
