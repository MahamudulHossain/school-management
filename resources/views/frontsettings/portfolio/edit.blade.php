@extends('layouts.al4_main')
@section('frontend_mo','menu-open')
@section('frontend','active')
@section('portfolio_mo','menu-open')
@section('portfolio','active')
@section('manage_portfolio','active')
@section('title','Edit Portfolio')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Edit Portfolio</a>
    </li>
@endsection
@push('css')
@endpush
@section('maincontent')

    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Portfolio</h3>
                </div>
                <form action="{{ route("portfolio.update", $portfolio->id) }}" method="POST" id="saveForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                        <div class="form-group row mb-3 {{ $errors->has('image') ? 'has-error' : '' }}">
                            <label for="image" class="col-md-4 control-label text-md-right">
                                Image :<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="file" name="image" class="form-control" required />
                                <img src="{!! asset( 'storage/front/portfolio/'. $portfolio->image. '?'. 'time='. time()) !!}" class="img-fluid" alt="User Image" width="150px" height="50px">
                                @if($errors->has('image'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('image') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label text-md-right">
                                Title:<span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <select name="portfolio_tag_id" id="portfolio_tag_id" class="form-control">
                                    <option value="">Select Title</option>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}" {{ $tag->id == $portfolio->portfolio_tag_id ? 'selected' : '' }}>{{ $tag->title }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('title'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('title') }}
                                    </em>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="callout callout-warning">
                                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
                                <p>
                                    <span> Prefered image size is 800x600 & not more then 1MB. Supported image type should be jpeg, jpj, png and bmp. Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
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
