@extends('layouts.al4_main')
@section('employee_mo','menu-open')
@section('employee','active')
@section('add_employee','active')
@section('title','Add Employee')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('employee')}}" class="nav-link">Employee</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Add Employee</a>
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
                    <h3 class="card-title">Add Employee</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                {{-- {!! Form::open(['url' => 'user', 'class' => 'form-horizontal','id'=>'saveForm']) !!} --}}
                <form id="saveForm" method="POST" action="{{ url('user') }}" class="form-horizontal">
                {{ csrf_field() }}

                <div class="card-body">

                    <div class="form-group row mb-3{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email"
                               class="col-md-4 control-label text-right">Email : <span
                                    class="required"> ** </span></label>
                        <div class="col-md-6">
                            <input id="email" readonly type="email"  class="form-control" name="email" value="{{ old('email') }}"
                                   onfocus="if (this.hasAttribute('readonly')) { this.removeAttribute('readonly');
                                    this.blur();    this.focus();  }"/>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-3{{ $errors->has('cell_phone') ? ' has-error' : '' }}">
                        <label for="cell_phone" class="col-md-4 control-label text-right">Mobile Number :
                            <span class="required"> ** </span></label>
                        <div class="col-md-6">
                            <input id="cell_phone" type="text" class="form-control" name="cell_phone"
                                   value="{{ old('cell_phone') }}" placeholder="Mobile Number"
                                   pattern="^\+?[1-9][0-9]{6,14}$" maxlength="14"
                                   onfocus="if (this.hasAttribute('readonly')) { this.removeAttribute('readonly');
                                   this.blur();    this.focus();  }"/>
                            {{-- Format indication message --}}
                            <span class="help-block">
                                <strong>Country code is a must (e.g: +8801xxxxxxxxx)</strong>
                            </span>
                            @if ($errors->has('cell_phone'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('cell_phone') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-md-4 control-label text-right"></label>
                        <div class="col-md-6">
                            <span class="help-block"><strong>** Mobile Number or Email any one is required</strong></span>
                        </div>
                    </div>

                    <div class="form-group row mb-3{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label text-right">Password : <span
                                    class="required"> * </span></label>
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password"
                                   placeholder="Password" required autocomplete="off">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <input type="hidden" name="user_type" value="4">
                    <div class="form-group row mb-3{{ $errors->has('roles') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 text-right">Select Roles:
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-6">
                            <select name="roles[]" class="form-control select2" id="roles" required multiple="multiple">
                                <option value="">Select User type</option>
                                @foreach($roles as $id => $role)
                                    {{--<option value="{{$user_type->id}}">{{$user_type->title}}</option>--}}
                                    <option value="{{$role->id}}">{{$role->title}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('roles'))
                                <span class="help-block">
                                <strong>{{ $errors->first('roles') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-md-4 control-label text-right">Gender:<span
                                    class="required"> * </span></label>
                        <div class="col-md-6 mt-radio-inline">
                            <label class="mt-radio">
                                <input type="radio" name="gender" value="Male" checked>Male
                                <span></span>
                            </label>
                            <label class="mt-radio">
                                <input type="radio" name="gender" value="Female">Female
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-md-4 control-label text-right">Web Access:<span
                                    class="required"> * </span></label>
                        <div class="col-md-6 mt-radio-inline">
                            <label class="mt-radio">
                                <input type="radio" name="web_access"
                                       value="1">Yes
                                <span></span>
                            </label>
                            <label class="mt-radio">
                                <input type="radio" name="web_access"
                                       value="0" checked>No
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group row mb-3{{ $errors->has('joining_date') ? ' has-error' : '' }}">
                        <label class="col-md-4 col-form-label text-md-right">
                            Joining Date : <span class="required"> * </span>
                        </label>
                        <div class="col-md-6">
                            <div class="input-group date" id="joining_date" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input"
                                       name="joining_date"
                                       data-target="#joining_date"/>
                                <div class="input-group-append" data-target="#joining_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            @if ($errors->has('joining_date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('joining_date') }}</strong>
                                </span>
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
<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('togglePasswordIcon');

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
}
</script>


@endpush
