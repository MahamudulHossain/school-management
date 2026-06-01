@extends('layouts.al4_main')
@section('frontend_mo','menu-open')
@section('frontend','active')
@section('about_us_mo','menu-open')
@section('about_us','active')
@section('manage_about_us','active')
@section('title','Edit About Us')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Edit About Us</a>
    </li>
@endsection
@push('css')
@endpush
@section('maincontent')

    <div class="row justify-content-center ">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit About Us</h3>
                </div>
                <form action="{{ route("about-us.update", $data->id) }}" method="POST" id="saveForm" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="card-body">

                        <div class="form-group row mb-3 {{ $errors->has('image') ? 'has-error' : '' }}">
                            <label for="image" class="col-md-4 control-label text-md-right">
                                Image :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="file" name="image" class="form-control" />
                                @if($errors->has('image'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('image') }}
                                    </em>
                                @endif
                            </div>
                            <div class="col-md-6 offset-md-4 mt-2">
                                <img src="{{ asset('storage/front/aboutus/'.$data->image) }}" alt="About Us Image" width="200px">
                                <input type="hidden" name="old_image" value="{{ $data->image }}">
                            </div>

                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('description') ? 'has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label text-md-right">
                                Description :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <textarea id="description" name="description" class="form-control"
                                          >{{ old('description', isset($data) ? $data->description : '') }}</textarea>
                                @if($errors->has('description'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('description') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('mission') ? 'has-error' : '' }}">
                            <label for="mission" class="col-md-4 control-label text-md-right">
                                Mission :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <textarea name="mission" class="form-control" rows="5" required>{{ $data->mission }}</textarea>
                                @if($errors->has('mission'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('mission') }}
                                    </em>
                                @endif
                            </div>

                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('vision') ? 'has-error' : '' }}">
                            <label for="vision" class="col-md-4 control-label text-md-right">
                                Vision :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <textarea name="vision" class="form-control" rows="5" required>{{ $data->vision }}</textarea>
                                @if($errors->has('vision'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('vision') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('goal') ? 'has-error' : '' }}">
                            <label for="goal" class="col-md-4 control-label text-md-right">
                                Goal :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <textarea name="goal" class="form-control" rows="5" required>{{ $data->goal }}</textarea>
                                @if($errors->has('goal'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('goal') }}
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
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        CKEDITOR.replace('description');
    });
</script>
@endpush
