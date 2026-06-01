@extends('layouts.al4_main')
@section('frontend_mo','menu-open')
@section('frontend','active')
@section('carousel_mo','menu-open')
@section('carousel','active')
@section('manage_carousel','active')
@section('title','Edit Carousel')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Edit Carousel</a>
    </li>
@endsection
@push('css')
@endpush
@section('maincontent')

    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Carousel</h3>
                </div>
                <form action="{{ route("carousel.update", $frontCarousel->id) }}" method="POST" id="saveForm" enctype="multipart/form-data">
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
                                <img src="{{ asset('storage/front/carousel/'.$frontCarousel->image) }}" alt="Carousel Image" width="200px">
                                <input type="hidden" name="old_image" value="{{ $frontCarousel->image }}">
                            </div>

                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('serial') ? 'has-error' : '' }}">
                            <label for="serial" class="col-md-4 control-label text-md-right">
                                Serial No:<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="number" name="serial" class="form-control" min="1" value="{{ $frontCarousel->serial }}" required />
                                @if($errors->has('serial'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('serial') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-4 control-label text-right">Status:<span
                                        class="required"> * </span></label>
                            <div class="col-md-6 mt-radio-inline">
                                <label class="mt-radio">
                                    <input type="radio" name="status"
                                        value="active" {{ $frontCarousel->status == 'active' ? 'checked' : '' }}>Active
                                    <span></span>
                                </label>
                                <label class="mt-radio">
                                    <input type="radio" name="status"
                                        value="inactive" {{ $frontCarousel->status == 'inactive' ? 'checked' : '' }}>Inactive
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="callout callout-warning">
                                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
                                <p>
                                    <span> Prefered image size is 1982x954 & not more then 1MB. Supported image type should be jpeg, jpj, png and bmp. Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
                                </p>
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
