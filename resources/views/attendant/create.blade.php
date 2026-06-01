@extends('layouts.al4_main')
@section('attendant_mo','menu-open')
@section('attendant','active')
@section('add_attendant','active')
@section('title','Create Attendant')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('attendant') }}" class="nav-link">Attendant</a>
    </li>
@endsection
@push('css')

<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet"
      href="{{ asset('alte4/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('alte4/plugins/select2/css/select2.min.css') }}">

@endpush
@section('maincontent')
    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add Attendant</h3>
                </div>
                <form id="saveForm" method="POST" action="{{ url('attendant') }}" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="card-body">

                    <div class="form-group row mb-3{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label text-md-right">Full Name :
                            <span class="required"> * </span></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name"
                                   value="{{ old('name') }}" autocomplete="false" autofocus
                                   placeholder="Full Name" required onfocus="true">
                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row mb-3{{ $errors->has('contact_no') ? ' has-error' : '' }}">
                        <label for="contact_no" class="col-md-4 control-label text-right">Mobile Number :
                            <span class="required"> * </span></label>
                        <div class="col-md-6">
                            <input id="contact_no" type="text" class="form-control" name="contact_no"
                                   value="{{ old('contact_no') }}" placeholder="Mobile Number"
                                   pattern="^\+?[1-9][0-9]{6,14}$" maxlength="14" />

                            @if ($errors->has('contact_no'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('contact_no') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-3{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email"
                               class="col-md-4 control-label text-right">Email :</label>
                        <div class="col-md-6">
                            <input id="email" type="email"  class="form-control" name="email" value="{{ old('email') }}"/>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-3{{ $errors->has('nid') ? ' has-error' : '' }}">
                        <label for="nid"
                               class="col-md-4 control-label text-right">NID :</label>
                        <div class="col-md-6">
                            <input id="nid" type="number"  class="form-control" name="nid" value="{{ old('nid') }}"/>
                            @if ($errors->has('nid'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('nid') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-3{{ $errors->has('address') ? ' has-error' : '' }}">
                        <label for="address"
                               class="col-md-4 control-label text-right">Address :</label>
                        <div class="col-md-6">
                            <textarea name="address" id="address" cols="30" rows="5" class="form-control">{{ old('address') }}</textarea>
                            @if ($errors->has('address'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-3{{ $errors->has('gender') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label text-md-right">Gender : <span
                                    class="required"> * </span></label>
                        <div class=" col-md-6 mt-radio-inline">
                            <label class="mt-radio">
                                <input type="radio" name="gender" value="Male" checked> Male
                                <span></span>
                            </label>
                            <label class="mt-radio">
                                <input type="radio" name="gender" value="Female"> Female
                                <span></span>
                            </label>
                            <label class="mt-radio">
                                <input type="radio" name="gender" value="Others"> Others
                                <span></span>
                            </label>
                        </div>

                        @if ($errors->has('gender'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div class="form-group row mb-3{{ $errors->has('image') ? ' has-error' : '' }}">
                        <label for="image"
                               class="col-md-4 control-label text-right">Image :</label>
                        <div class="col-md-6">
                            <input type="file" name="image" class="form-control">
                            @if ($errors->has('image'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="row mt-2">
                            <div class="callout callout-warning">
                                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
                                <p>
                                    <span> Prefered image size for Avatar is 300X300 & not more then 1MB. Supported image type should be jpeg, jpj, png and bmp. Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
                                </p>
                            </div>
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
<!-- InputMask for Date picker-->
<script src="{!! asset('alte4/plugins/moment/moment.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/inputmask/min/jquery.inputmask.bundle.min.js')!!}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{!! asset('alte4/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')!!}"></script>
<script src="{!! asset('alte4/plugins/select2/js/select2.full.min.js')!!}"></script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
</script>


<script>
    $(function () {
        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd-mm-yyyy', {'placeholder': 'dd-mm-yyyy'})
        //Date range picker
        $('#joining_date').datetimepicker({
            date: moment(),
            format: 'DD-MM-Y'
        });
    })

</script>
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
