<div class="tab-pane active" id="personal">
    <form action="{{ route('teacher.personal_profile.update', $user->teacher->id) }}" method="POST" class="saveForm">
    @method('PATCH')
    @csrf
    <div class="card-body">

        <div class="form-group row mb-3{{ $errors->has('first_name') ? ' has-error' : '' }}">
            <label for="first_name" class="col-md-4 control-label text-md-right">First Name
                : </label>
            <div class="col-md-6">
                <input id="first_name" type="text" class="form-control input-circle" name="first_name"
                        value="{{ $user->teacher->first_name }}" placeholder="Enter First Name">
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
                        value="{{ $user->teacher->middle_name }}" placeholder="Enter Middle Name">
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
                        value="{{ $user->teacher->last_name }}" placeholder="Enter Last Name">
                @if ($errors->has('last_name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('last_name') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3">
            <label class="col-md-4 control-label text-right">Card No:</label>
            <div class="col-md-6">
                <input id="card_number" type="text" class="form-control input-circle" name="card_number"
                    value="{{ $user->teacher->card_number }}" placeholder="Enter Card Number" {{ Auth::user()->user_type_id == 1 ? '' : 'readonly disabled' }}>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label class="col-md-4 control-label text-right">Personnel ID:</label>
            <div class="col-md-6">
                <input id="personnel_id" type="text" class="form-control input-circle" name="personnel_id"
                    value="{{ $user->personnel_id }}" placeholder="Enter Personnel ID" disabled>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('emergency_contact') ? ' has-error' : '' }}">
            <label for="emergency_contact" class="col-md-4 control-label text-md-right">Emergency Contact
                : </label>
            <div class="col-md-6">
                <input id="emergency_contact" type="text" class="form-control input-circle" name="emergency_contact"
                        value="{{ $user->teacher->emergency_contact }}" placeholder="Enter Emergency Contact">
                @if ($errors->has('emergency_contact'))
                    <span class="help-block">
                    <strong>{{ $errors->first('emergency_contact') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('designation') ? ' has-error' : '' }}">
            <label for="designation" class="col-md-4 control-label text-md-right">Designation
                : </label>
            <div class="col-md-6">
                <input id="designation" type="text" class="form-control input-circle" name="designation"
                        value="{{ $user->teacher->designation }}" placeholder="Enter Designation">
                @if ($errors->has('designation'))
                    <span class="help-block">
                    <strong>{{ $errors->first('designation') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('father_name') ? ' has-error' : '' }}">
            <label for="father_name" class="col-md-4 control-label text-md-right">Father Name
                : </label>
            <div class="col-md-6">
                <input id="father_name" type="text" class="form-control input-circle" name="father_name"
                        value="{{ $user->teacher->father_name }}" placeholder="Enter Father Name">
                @if ($errors->has('father_name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('father_name') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('father_phone') ? ' has-error' : '' }}">
            <label for="father_phone" class="col-md-4 control-label text-md-right">Father Phone
                : </label>
            <div class="col-md-6">
                <input id="father_phone" type="text" class="form-control input-circle" name="father_phone"
                        value="{{ $user->teacher->father_phone }}" placeholder="Enter Father Phone">
                @if ($errors->has('father_phone'))
                    <span class="help-block">
                    <strong>{{ $errors->first('father_phone') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('father_email') ? ' has-error' : '' }}">
            <label for="father_email" class="col-md-4 control-label text-md-right">Father Email
                : </label>
            <div class="col-md-6">
                <input id="father_email" type="email" class="form-control input-circle" name="father_email"
                        value="{{ $user->teacher->father_email }}" placeholder="Enter Father Email">
                @if ($errors->has('father_email'))
                    <span class="help-block">
                    <strong>{{ $errors->first('father_email') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('father_nid') ? ' has-error' : '' }}">
            <label for="father_nid" class="col-md-4 control-label text-md-right">Father NID
                : </label>
            <div class="col-md-6">
                <input id="father_nid" type="text" class="form-control input-circle" name="father_nid"
                        value="{{ $user->teacher->father_nid }}" placeholder="Enter Father NID">
                @if ($errors->has('father_nid'))
                    <span class="help-block">
                    <strong>{{ $errors->first('father_nid') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('mother_name') ? ' has-error' : '' }}">
            <label for="mother_name" class="col-md-4 control-label text-md-right">Mother Name
                : </label>
            <div class="col-md-6">
                <input id="mother_name" type="text" class="form-control input-circle" name="mother_name"
                        value="{{ $user->teacher->mother_name }}" placeholder="Enter Mother Name">
                @if ($errors->has('mother_name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('mother_name') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('mother_phone') ? ' has-error' : '' }}">
            <label for="mother_phone" class="col-md-4 control-label text-md-right">Mother Phone
                : </label>
            <div class="col-md-6">
                <input id="mother_phone" type="text" class="form-control input-circle" name="mother_phone"
                        value="{{ $user->teacher->mother_phone }}" placeholder="Enter Mother Phone">
                @if ($errors->has('mother_phone'))
                    <span class="help-block">
                    <strong>{{ $errors->first('mother_phone') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('mother_email') ? ' has-error' : '' }}">
            <label for="mother_email" class="col-md-4 control-label text-md-right">Mother Email
                : </label>
            <div class="col-md-6">
                <input id="mother_email" type="email" class="form-control input-circle" name="mother_email"
                        value="{{ $user->teacher->mother_email }}" placeholder="Enter Mother Email">
                @if ($errors->has('mother_email'))
                    <span class="help-block">
                    <strong>{{ $errors->first('mother_email') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('mother_nid') ? ' has-error' : '' }}">
            <label for="mother_nid" class="col-md-4 control-label text-md-right">Mother NID
                : </label>
            <div class="col-md-6">
                <input id="mother_nid" type="text" class="form-control input-circle" name="mother_nid"
                        value="{{ $user->teacher->mother_nid }}" placeholder="Enter Mother NID">
                @if ($errors->has('mother_nid'))
                    <span class="help-block">
                    <strong>{{ $errors->first('mother_nid') }}</strong>
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
                        <option value="{{ $group }}" {{ $user->teacher->blood_group == $group ? 'selected' : '' }}>{{ $group }}</option>
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
                        <option value="{{ $religion }}" {{ $user->teacher->religion == $religion ? 'selected' : '' }}>{{ $religion }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('marital_status') ? ' has-error' : '' }}">
            <label for="marital_status" class="col-md-4 control-label text-md-right">Marital Status: </label>
            <div class="col-md-6">
                <select class="form-control input-circle" name="marital_status">
                    <option value="">Select Marital Status</option>
                    @foreach ($maritial_statuses as $status)
                        <option value="{{ $status }}" {{ $user->teacher->marital_status == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('spouse_name') ? ' has-error' : '' }}">
            <label for="spouse_name" class="col-md-4 control-label text-md-right">Spouse Name: </label>
            <div class="col-md-6">
                <input type="text" class="form-control input-circle" name="spouse_name" value="{{ $user->teacher->spouse_name }}" placeholder="Enter Spouse Name">
                @if ($errors->has('spouse_name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('spouse_name') }}</strong>
                </span>
                @endif
            </div>
        </div>

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
