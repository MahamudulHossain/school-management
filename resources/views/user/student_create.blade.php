@extends('layouts.al4_main')
@section('student_mo','menu-open')
@section('student','active')
@section('add_student','active')
@section('title','Add Student')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('student')}}" class="nav-link">Student</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Admit Student</a>
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
                    <h3 class="card-title">Student Admission</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                {{-- {!! Form::open(['url' => 'user', 'class' => 'form-horizontal','id'=>'saveForm']) !!} --}}
                <form id="saveForm" method="POST" action="{{ url('user') }}" class="form-horizontal">
                {{ csrf_field() }}

                <div class="card-body">

                    <div class="form-group row mb-3{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label for="first_name" class="col-md-4 control-label text-md-right">First Name
                            : <span class="required"> * </span></label>
                        <div class="col-md-6">
                            <input id="first_name" type="text" class="form-control input-circle" name="first_name"
                                    value="{{ old('first_name') }}" placeholder="Enter First Name" required>
                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-3{{ $errors->has('middle_name') ? ' has-error' : '' }}">
                        <label for="middle_name" class="col-md-4 control-label text-md-right">Middle Name
                            : </label>
                        <div class="col-md-6">
                            <input id="middle_name" type="text" class="form-control input-circle" name="middle_name"
                                    value="{{ old('middle_name') }}" placeholder="Enter Middle Name">
                            @if ($errors->has('middle_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('middle_name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-3{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label for="last_name" class="col-md-4 control-label text-md-right">Last Name
                            : </label>
                        <div class="col-md-6">
                            <input id="last_name" type="text" class="form-control input-circle" name="last_name"
                                    value="{{ old('last_name') }}" placeholder="Enter Last Name">
                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    {{-- <div class="form-group row mb-3{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label text-right">
                            Password : <span class="required"> * </span>
                        </label>
                        <div class="col-md-6 position-relative">
                            <input id="password" type="password" class="form-control" name="password"
                                placeholder="Password" required autocomplete="off">

                            <!-- Eye Icon -->
                            <span class="position-absolute"
                                style="right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;"
                                onclick="togglePassword()">
                                <i id="togglePasswordIcon" class="fa fa-eye"></i>
                            </span>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> --}}

                    <input type="hidden" name="user_type" value="2">

                    <div class="form-group row mb-3{{ $errors->has('roles') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 text-right">Select Roles:
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-6">
                            <select name="roles[]" class="form-control select2" id="roles" required multiple="multiple">
                                <option value="">Select User type</option>
                                @foreach($roles as $id => $role)
                                    <option value="{{$role->id}}" {{ $role->id == 4 ? 'selected':'' }}>{{$role->title}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('roles'))
                                <span class="help-block">
                                <strong>{{ $errors->first('roles') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-3{{ $errors->has('guardian_id') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 text-right">Attach Parents:
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-4">
                            <select name="guardian_id" class="form-control select2" id="guardian_id">
                                <option value="" disabled selected>Select Parents</option>
                                @foreach($guardians as $guardian)
                                    <option value="{{$guardian->id}}">{{$guardian->user->email ? $guardian->user->email : $guardian->user->cell_phone}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('guardian_id'))
                                <span class="help-block">
                                <strong>{{ $errors->first('guardian_id') }}</strong>
                            </span>
                            @endif
                        </div>
                        OR
                        <div class="col-md-2">
                            <input type="button" class="btn btn-sm btn-info" value="Create New" onclick="addNewParents()">
                        </div>
                    </div>

                    <div class="form-group row mb-3" id="newParentsRow">
                        @if(old('guardian_email') || old('guardian_cell_phone'))
                            <div id="parentRow_1" class="form-group row">
                                <label for="guardian_cell_phone_1" class="col-md-4 control-label text-right">
                                    Guardian's Mobile: <span class="required"> * </span>
                                </label>
                                <div class="col-md-5">
                                    <input id="guardian_cell_phone_1" type="text" class="form-control" name="guardian_cell_phone"
                                        pattern="^\+?[1-9][0-9]{6,14}$" maxlength="14"
                                        value="{{ is_array(old('guardian_cell_phone')) ? '' : old('guardian_cell_phone') }}"
                                        onfocus="if (this.hasAttribute('readonly')) {
                                            this.removeAttribute('readonly');
                                            this.blur();
                                            this.focus();
                                        }"/>
                                    {{-- Format indication message --}}
                                    <span class="help-block">
                                        <strong>Country code is a must (e.g: +8801xxxxxxxxx)</strong>
                                    </span>
                                    @if ($errors->has('guardian_cell_phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('guardian_cell_phone') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label for="guardian_email_1" class="col-md-4 control-label text-right mb-3">
                                    Guardian's Email: <span class="required"> * </span>
                                </label>
                                <div class="col-md-5">
                                    <input id="guardian_email_1" type="email" class="form-control" name="guardian_email"
                                        value="{{ is_array(old('guardian_email')) ? '' : old('guardian_email') }}"
                                        onfocus="if (this.hasAttribute('readonly')) {
                                            this.removeAttribute('readonly');
                                            this.blur();
                                            this.focus();
                                        }"/>
                                    @if ($errors->has('guardian_email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('guardian_email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-1">
                                    <input type="button" class="btn btn-sm btn-danger" value="Delete"
                                        onclick="deleteRow('parentRow_1')">
                                </div>
                                <span class="help-block"><strong>** Mobile Number or Email any one is required</strong></span>

                            </div>
                        @endif
                    </div>

                    <div class="form-group row mb-3{{ $errors->has('attendant_id') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 text-right">Attach Attendant: </label>
                        <div class="col-md-4">
                            <select name="attendant_id" class="form-control select2" id="attendant_id">
                                <option value="" disabled selected>Select Attendant</option>
                                @foreach($attendants as $attendant)
                                    <option value="{{$attendant->id}}">{{$attendant->name}} ({{$attendant->contact_no}})</option>
                                @endforeach
                            </select>
                            @if ($errors->has('attendant_id'))
                                <span class="help-block">
                                <strong>{{ $errors->first('attendant_id') }}</strong>
                            </span>
                            @endif
                        </div>
                        OR
                        <div class="col-md-2">
                            <input type="button" class="btn btn-sm btn-info" value="Create New" onclick="addNewAttendant()">
                        </div>
                    </div>

                    <div class="form-group row mb-3" id="newAttendantRow">
                        @if(old('attendant_name') || old('attendant_cell_phone'))
                            <div id="parentRow_1" class="form-group row">
                                <label for="attendant_name_1" class="col-md-4 control-label text-right mb-3">
                                    Attendant's Name: <span class="required"> * </span>
                                </label>
                                <div class="col-md-5">
                                    <input id="attendant_name_1" type="text" class="form-control" name="attendant_name"
                                        value="{{ is_array(old('attendant_name')) ? '' : old('attendant_name') }}"/>
                                    @if ($errors->has('attendant_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('attendant_name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label for="attendant_cell_phone_1" class="col-md-4 control-label text-right">
                                    Attendant's Mobile: <span class="required"> * </span>
                                </label>
                                <div class="col-md-5">
                                    <input id="attendant_cell_phone_1" type="text" class="form-control" name="attendant_cell_phone"
                                        pattern="^\+?[1-9][0-9]{6,14}$" maxlength="14"
                                        value="{{ is_array(old('attendant_cell_phone')) ? '' : old('attendant_cell_phone') }}"/>
                                    {{-- Format indication message --}}
                                    <span class="help-block">
                                        <strong>Country code is a must (e.g: +8801xxxxxxxxx)</strong>
                                    </span>
                                    @if ($errors->has('attendant_cell_phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('attendant_cell_phone') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-1">
                                    <input type="button" class="btn btn-sm btn-danger" value="Delete"
                                        onclick="deleteAttendantRow('attendantRow_1')">
                                </div>

                            </div>
                        @endif
                    </div>

                    <div class="form-group row mb-3{{ $errors->has('academic_year_id') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 text-right">Academic Year:
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-6">
                            <select name="academic_year_id" class="form-control" id="academic_year_id" required>
                                <option value="">Select Academic Year</option>
                                @foreach($academic_years as $id => $academic_year)
                                    <option value="{{$id}}" {{ $sessionAcademicYear ==  $id ? 'selected':''}} {{ old('academic_year_id') == $id ? 'selected' : '' }}>{{$academic_year}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('academic_year_id'))
                                <span class="help-block">
                                <strong>{{ $errors->first('academic_year_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-3{{ $errors->has('school_class_id') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 text-right">Class:
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-6">
                            <select name="school_class_id" class="form-control" id="school_class_id" required>
                                <option value="">Select Class</option>
                                @foreach($school_classes as $id => $school_class)
                                    <option value="{{$id}}" {{ old('school_class_id') == $id ? 'selected' : '' }}>{{$school_class}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('school_class_id'))
                                <span class="help-block">
                                <strong>{{ $errors->first('school_class_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-3{{ $errors->has('school_section_id') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 text-right">Section:
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-6">
                            <select name="school_section_id" class="form-control" id="school_section_id" required>
                                <option value="">Select Section</option>
                                @foreach($school_sections as $id => $school_section)
                                    <option value="{{$id}}" {{ old('school_section_id') == $id ? 'selected' : '' }}>{{$school_section}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('school_section_id'))
                                <span class="help-block">
                                <strong>{{ $errors->first('school_section_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-3{{ $errors->has('roll') ? ' has-error' : '' }}">
                        <label for="stu_r" class="col-md-4 control-label text-right">Roll No: <span
                                    class="required"> * </span></label>
                        <div class="col-md-6">
                            <input id="stu_r" type="number" min="1" class="form-control" name="roll"
                                   placeholder="Insert Roll No" required autocomplete="off" value="{{ old('roll') }}">
                            @if ($errors->has('roll'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('roll') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="roll_suggestion" class="col-md-4 control-label text-right">Rolls Already Been Inserted: </label>
                        <div class="col-md-6">
                            <textarea type="text" style="overflow: auto;" class="form-control" id="roll_suggestion" disabled>

                            </textarea>
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

                    {{-- <div class="form-group row mb-3">
                        <label class="col-md-4 control-label text-right">Web Access:<span
                                    class="required"> * </span></label>
                        <div class="col-md-6 mt-radio-inline">
                            <label class="mt-radio">
                                <input type="radio" name="web_access" value="1">Yes
                                <span></span>
                            </label>
                            <label class="mt-radio">
                                <input type="radio" name="web_access" value="0" checked>No
                                <span></span>
                            </label>
                        </div>
                    </div> --}}

                    <div class="form-group row mb-3{{ $errors->has('joining_date') ? ' has-error' : '' }}">
                        <label class="col-md-4 col-form-label text-md-right">
                            Admission Date : <span class="required"> * </span>
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
    function addNewParents(){
        var uniqueId = Date.now();
        var html = `<div id="parentRow_${uniqueId}" class="form-group row">

                            <label for="guardian_cell_phone_${uniqueId}" class="col-md-4 control-label text-right">
                                Guardian's Mobile: <span class="required"> ** </span>
                            </label>
                            <div class="col-md-5 mb-3">
                                <input id="guardian_cell_phone_${uniqueId}" type="text" class="form-control" name="guardian_cell_phone"
                                    value="{{ is_array(old('guardian_cell_phone')) ? '' : old('guardian_cell_phone') }}" pattern="^\+?[1-9][0-9]{6,14}$" maxlength="14"
                                    onfocus="if (this.hasAttribute('readonly')) {
                                        this.removeAttribute('readonly');
                                        this.blur();
                                        this.focus();
                                    }"/>
                                <span class="help-block">
                                    <strong>Country code is a must (e.g: +8801xxxxxxxxx)</strong>
                                </span>
                                @if ($errors->has('guardian_cell_phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('guardian_cell_phone') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <label for="guardian_email_${uniqueId}" class="col-md-4 control-label text-right">
                                Guardian's Email: <span class="required"> ** </span>
                            </label>
                            <div class="col-md-5">
                                <input id="guardian_email_${uniqueId}" type="email" class="form-control" name="guardian_email"
                                    value="{{ is_array(old('guardian_email')) ? '' : old('guardian_email') }}"
                                    onfocus="if (this.hasAttribute('readonly')) {
                                        this.removeAttribute('readonly');
                                        this.blur();
                                        this.focus();
                                    }"/>
                                @if ($errors->has('guardian_email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('guardian_email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-1">
                                <input type="button" class="btn btn-sm btn-danger" value="Delete"
                                    onclick="deleteRow('parentRow_${uniqueId}')">
                            </div>
                            <span class="help-block"><strong>** Mobile Number or Email any one is required</strong></span>
                    </div>`;

        $("#newParentsRow").html(html);
    }

    function deleteRow(rowId) {
        $("#" + rowId).remove();
    }
</script>

<script>
    function addNewAttendant(){
        var uniqueId = Date.now() + 1;
        var html = `<div id="attendant_${uniqueId}" class="form-group row">

                            <label for="attendant_name_${uniqueId}" class="col-md-4 control-label text-right">
                                Attendant's Name: <span class="required"> * </span>
                            </label>
                            <div class="col-md-5 mb-3">
                                <input id="attendant_name_${uniqueId}" type="text" class="form-control" name="attendant_name"
                                    value="{{ old('attendant_name') ? '' : old('attendant_name') }}" />
                                @if ($errors->has('attendant_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('attendant_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <label for="attendant_cell_phone_${uniqueId}" class="col-md-4 control-label text-right">
                                Attendant's Mobile: <span class="required"> * </span>
                            </label>
                            <div class="col-md-5 mb-3">
                                <input id="attendant_cell_phone_${uniqueId}" type="text" class="form-control" name="attendant_cell_phone"
                                    value="{{ is_array(old('attendant_cell_phone')) ? '' : old('attendant_cell_phone') }}" pattern="^\+?[1-9][0-9]{6,14}$" maxlength="14"/>
                                <span class="help-block">
                                    <strong>Country code is a must (e.g: +8801xxxxxxxxx)</strong>
                                </span>
                                @if ($errors->has('attendant_cell_phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('attendant_cell_phone') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-1">
                                <input type="button" class="btn btn-sm btn-danger" value="Delete"
                                    onclick="deleteAttendantRow('attendant_${uniqueId}')">
                            </div>
                    </div>`;

        $("#newAttendantRow").html(html);
    }

    function deleteAttendantRow(rowId) {
        $("#" + rowId).remove();
    }
</script>

<script>
    $("select[name='school_section_id']").change(function () {
        var academic_year_id = $("#academic_year_id").val();
        var school_class_id = $("#school_class_id").val();
        var school_section_id = $(this).val();

        $.ajax({
            url: siteURL + '/get-inserted-rolls',
            method: 'POST',
            dataType: "json",
            data: {
                academic_year_id: academic_year_id,
                school_class_id: school_class_id,
                school_section_id: school_section_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                // console.log(data)

                if (!$.trim(data)) {
                    var rollsuggestion = "No result Found";
                    $("#roll_suggestion").val(rollsuggestion);
                }
                else
                    var rollsuggestion = data;
                $("#roll_suggestion").val(rollsuggestion);

            }
        });
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
