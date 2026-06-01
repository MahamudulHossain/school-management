@extends('layouts.al4_main')
@section('notice_mo','menu-open')
@section('notice','active')
@section('list_notice','active')
@section('title','Notice Update')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('notice')}}" class="nav-link">Notices</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Update Notice</a>
    </li>
@endsection
@push('css')
@endpush
@section('maincontent')

    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Update Notice</h3>
                </div>
                <form action="{{ route('notice.update', $notice->id) }}" method="POST" id="saveForm" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="card-body">

                        <div class="form-group row mb-3 {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label for="title" class="col-md-2 control-label text-md-right">
                                Notice Title :<span class="required">*</span>
                            </label>
                            <div class="col-md-8">
                                <input type="text" id="title" name="title" class="form-control" autofocus
                                    value="{{ old('title', isset($notice) ? $notice->title : '') }}" required>
                                @if($errors->has('title'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('title') }}
                                    </em>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('details') ? 'has-error' : '' }}">
                            <label for="details" class="col-md-2 control-label text-md-right">
                                Details :
                            </label>
                            <div class="col-md-8">
                                <input type="file" id="details" name="details" class="form-control" accept=".pdf">

                                @if($errors->has('details'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('details') }}
                                    </em>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="callout callout-warning">
                                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
                                <p>
                                    <span> Prefered size is not more then 2MB. Supported file type should be pdf. </span>
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
