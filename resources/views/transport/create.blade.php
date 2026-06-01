@extends('layouts.al4_main')
@section('transport_mo','menu-open')
@section('transport','active')
@section('manage_transport','active')
@section('title','Add Transport')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Add Transport</a>
    </li>
@endsection
@push('css')
@endpush
@section('maincontent')

    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add Transport Info</h3>
                </div>
                <form action="{{ route("transport.store") }}" method="POST" id="saveForm">
                    @csrf
                    <div class="card-body">

                        <div class="form-group row mb-3 {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label text-md-right">
                                Title:<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required />
                                @if($errors->has('title'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('title') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('route_info') ? 'has-error' : '' }}">
                            <label for="route_info" class="col-md-4 control-label text-md-right">
                                Route Info:<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" name="route_info" class="form-control" value="{{ old('route_info') }}" required />
                                @if($errors->has('route_info'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('route_info') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('vehicle_info') ? 'has-error' : '' }}">
                            <label for="vehicle_info" class="col-md-4 control-label text-md-right">
                                Vehicle Info:<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" name="vehicle_info" class="form-control" value="{{ old('vehicle_info') }}" required />
                                @if($errors->has('vehicle_info'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('vehicle_info') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('driver_info') ? 'has-error' : '' }}">
                            <label for="driver_info" class="col-md-4 control-label text-md-right">
                                Driver Info:<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" name="driver_info" class="form-control" value="{{ old('driver_info') }}" required />
                                @if($errors->has('driver_info'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('driver_info') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('fare') ? 'has-error' : '' }}">
                            <label for="fare" class="col-md-4 control-label text-md-right">
                                Fare:<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="number" name="fare" class="form-control" value="{{ old('fare') }}" required />
                                @if($errors->has('fare'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('fare') }}
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

<script>
    $('#saveForm').submit(function () {
        $("#saveButton", this)
            .html("Please Wait...")
            .attr('disabled', 'disabled');
        return true;
    });
</script>
@endpush
