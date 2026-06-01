<div class="tab-pane active" id="personal">
    <form action="{{ route('student.personal_profile.update', $user->student->id) }}" method="POST" class="saveForm">
    @method('PATCH')
    @csrf
    <div class="card-body">

        <div class="form-group row mb-3{{ $errors->has('first_name') ? ' has-error' : '' }}">
            <label for="first_name" class="col-md-4 control-label text-md-right">First Name
                : </label>
            <div class="col-md-6">
                <input id="first_name" type="text" class="form-control input-circle" name="first_name"
                        value="{{ $user->student->first_name }}" placeholder="Enter First Name">
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
                        value="{{ $user->student->middle_name }}" placeholder="Enter Middle Name">
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
                        value="{{ $user->student->last_name }}" placeholder="Enter Last Name">
                @if ($errors->has('last_name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('last_name') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3">
            <label class="col-md-4 control-label text-right">Personnel ID:</label>
            <div class="col-md-6">
                <input id="personnel_id" type="text" class="form-control input-circle" name="personnel_id"
                    value="{{ $user->personnel_id }}" placeholder="Enter Personnel ID" {{ Auth::user()->user_type_id == 1 ? '' : 'readonly disabled' }}>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label class="col-md-4 control-label text-right">Card No:</label>
            <div class="col-md-6">
                <input id="card_number" type="text" class="form-control input-circle" name="card_number"
                    value="{{ $user->student->card_number }}" placeholder="Enter Card Number" {{ Auth::user()->user_type_id == 1 ? '' : 'readonly disabled' }}>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('personal_phone') ? ' has-error' : '' }}">
            <label for="personal_phone" class="col-md-4 control-label text-md-right">Personal Contact
                : </label>
            <div class="col-md-6">
                <input id="personal_phone" type="text" class="form-control input-circle" name="personal_phone"
                        value="{{ $user->student->personal_phone }}" placeholder="Enter Personal Contact">
                @if ($errors->has('personal_phone'))
                    <span class="help-block">
                    <strong>{{ $errors->first('personal_phone') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('emergency_contact') ? ' has-error' : '' }}">
            <label for="emergency_contact" class="col-md-4 control-label text-md-right">Emergency Contact
                : </label>
            <div class="col-md-6">
                <input id="emergency_contact" type="text" class="form-control input-circle" name="emergency_contact"
                        value="{{ $user->student->emergency_contact }}" placeholder="Enter Emergency Contact">
                @if ($errors->has('emergency_contact'))
                    <span class="help-block">
                    <strong>{{ $errors->first('emergency_contact') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('blood_group') ? ' has-error' : '' }}">
            <label for="blood_group" class="col-md-4 control-label text-md-right">Blood Group
                : </label>
            <div class="col-md-6">
                <select class="form-control input-circle" name="blood_group">
                    <option value="">Select Blood Group</option>
                    @foreach ($blood_groups as $group)
                        <option value="{{ $group }}" {{ $user->student->blood_group == $group ? 'selected' : '' }}>{{ $group }}</option>
                    @endforeach
                </select>
                @if ($errors->has('blood_group'))
                    <span class="help-block">
                    <strong>{{ $errors->first('blood_group') }}</strong>
                </span>
                @endif
            </div>
        </div>


        <div class="form-group row mb-3{{ $errors->has('religion') ? ' has-error' : '' }}">
            <label for="religion" class="col-md-4 control-label text-md-right">Religion: </label>
            <div class="col-md-6">
                <select class="form-control input-circle" name="religion">
                    <option value="">Select Religion</option>
                    @foreach ($religions as $religion)
                        <option value="{{ $religion }}" {{ $user->student->religion == $religion ? 'selected' : '' }}>{{ $religion }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if(Auth()->user()->user_type_id == 1)
            <div class="form-group row mb-3">
                <label class="col-md-4 control-label text-right">Status:<span
                            class="required"> * </span></label>
                <div class="mt-radio-inline col-md-6">
                    <label class="mt-radio">
                        <input type="radio" name="status"
                            value="1" {{ ($user->student->status=="active")? "checked" : "" }} >Active
                        <span></span>
                    </label>
                    <label class="mt-radio">
                        <input type="radio" name="status"
                            value="0" {{ ($user->student->status=="inactive")? "checked" : "" }} >Inactive
                        <span></span>
                    </label>
                </div>
            </div>
        @endif

    </div>

    {{--<div class="card-footer">--}}
    <a href="{{ url()->previous() }}" class="btn btn-outline-primary"><i
                class="fa fa-arrow-left"
                aria-hidden="true"></i>{{ __('all_settings.Back') }}</a>
    <button type="submit" class="btn btn-success float-right" id="saveButton"><i
                class="fa fa-save"
                aria-hidden="true"></i> Save
    </button>
    {{--</div>--}}
    </form>

</div>
