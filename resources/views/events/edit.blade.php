@extends('layouts.al4_main')
@section('event_mo','menu-open')
@section('event','active')
@section('manage_event','active')
@section('title','Event Update')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('event-holiday')}}" class="nav-link">Manage Events</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Update Event</a>
    </li>
@endsection
@push('css')
@endpush
@section('maincontent')

    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Update Event</h3>
                </div>
                <form action="{{ route('event-holiday.update', $event->id) }}" method="POST" id="saveForm">
                    @method('PATCH')
                    @csrf
                    <div class="card-body">

                        <div class="form-group row mb-3 {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label text-md-right">
                                Title :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" id="title" name="title" class="form-control" autofocus
                                    value="{{ old('title', isset($event) ? $event->title : '') }}" required>
                                @if($errors->has('title'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('title') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('start_date') ? 'has-error' : '' }}">
                            <label for="start_date" class="col-md-4 control-label text-md-right">
                                Start date & time :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="datetime-local" id="start_date" name="start_date" class="form-control"
                                       value="{{ old('start_date', isset($event) ? $event->start_date : '') }}" required>
                                @if($errors->has('start_date'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('start_date') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('end_date') ? 'has-error' : '' }}">
                            <label for="end_date" class="col-md-4 control-label text-md-right">
                                End date & time :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="datetime-local" id="end_date" name="end_date" class="form-control"
                                       value="{{ old('end_date', isset($event) ? $event->end_date : '') }}" required>
                                @if($errors->has('end_date'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('end_date') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('type') ? 'has-error' : '' }}">
                            <label for="type" class="col-md-4 control-label text-md-right">
                                Type :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <select name="type" id="type" class="form-control" required>
                                    <option value="holiday" {{ old('type', isset($event) ? $event->type : '') == 'holiday' ? 'selected' : '' }}>Holiday</option>
                                    <option value="non-holiday" {{ old('type', isset($event) ? $event->type : '') == 'non-holiday' ? 'selected' : '' }}>Non-Holiday</option>
                                </select>
                                @if($errors->has('type'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('type') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-primary"><i
                                    class="fa fa-arrow-left"
                                    aria-hidden="true"></i>{{ __('all_settings.Back') }}</a>
                        <button type="submit" class="btn btn-success float-right" id="saveButton"><i
                                    class="fa fa-save"
                                    aria-hidden="true"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')

{{--prevent multiple form submits (Jquery needed)--}}
<script>
    $('#saveForm').submit(function () {
        $("#saveButton", this)
            .html("Please Wait...")
            .attr('disabled', 'disabled');
        return true;
    });
</script>
@endpush
