@extends('layouts.al4_main')
@section('settings_mo','menu-open')
@section('settings','active')
@section('manage_portfolio_tag','active')
@section('title','Edit Portfolio Tag')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Edit Portfolio Tag</a>
    </li>
@endsection
@push('css')

@endpush
@section('maincontent')
    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Portfolio Tag</h3>
                </div>
                <form action="{{ route("portfolio-tag.update", $data->id) }}" method="POST" id="saveForm">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                        <div class="form-group row mb-3 {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label text-md-right">
                                Title :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" id="title" name="title" class="form-control" autofocus
                                    value="{{ old('title', $data->title) }}" required>
                                @if($errors->has('title'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('title') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label text-md-right">Status : <span
                                        class="required"> * </span></label>
                            <div class="col-md-6 mt-radio-inline">
                                <label class="mt-radio">
                                    <input type="radio" name="status" value="active" {{ $data->status == 'active' ? 'checked' : '' }}> Active
                                    <span></span>
                                </label>
                                <label class="mt-radio">
                                    <input type="radio" name="status" value="inactive" {{ $data->status == 'inactive' ? 'checked' : '' }}> Inactive
                                    <span></span>
                                </label>
                            </div>

                            @if ($errors->has('status'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('status') }}</strong>
                                </span>
                            @endif
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

@endpush
