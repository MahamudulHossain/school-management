<div class="tab-pane" id="personal">
    <div class="card-body">

        <div class="form-group row mb-3{{ $errors->has('first_name') ? ' has-error' : '' }}">
            <label for="first_name" class="col-md-4 control-label text-md-right">First Name
                : </label>
            <div class="col-md-6">
                <input id="first_name" type="text" class="form-control input-circle" name="first_name"
                        value="{{ $user->employee->first_name }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('middle_name') ? ' has-error' : '' }}">
            <label for="middle_name" class="col-md-4 control-label text-md-right">Middle Name
                : </label>
            <div class="col-md-6">
                <input id="middle_name" type="text" class="form-control input-circle" name="middle_name"
                        value="{{ $user->employee->middle_name }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('last_name') ? ' has-error' : '' }}">
            <label for="last_name" class="col-md-4 control-label text-md-right">Last Name
                : </label>
            <div class="col-md-6">
                <input id="last_name" type="text" class="form-control input-circle" name="last_name"
                        value="{{ $user->employee->last_name }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label class="col-md-4 control-label text-right">Card No:</label>
            <div class="col-md-6">
                <input id="card_number" type="text" class="form-control input-circle" name="card_number"
                    value="{{ $user->employee->card_number }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label class="col-md-4 control-label text-right">Personnel ID:</label>
            <div class="col-md-6">
                <input id="personnel_id" type="text" class="form-control input-circle" name="personnel_id"
                    value="{{ $user->personnel_id }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('emergency_contact') ? ' has-error' : '' }}">
            <label for="emergency_contact" class="col-md-4 control-label text-md-right">Emergency Contact
                : </label>
            <div class="col-md-6">
                <input id="emergency_contact" type="text" class="form-control input-circle" name="emergency_contact"
                        value="{{ $user->employee->emergency_contact }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('designation') ? ' has-error' : '' }}">
            <label for="designation" class="col-md-4 control-label text-md-right">Designation
                : </label>
            <div class="col-md-6">
                <input id="designation" type="text" class="form-control input-circle" name="designation"
                        value="{{ $user->employee->designation }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('father_name') ? ' has-error' : '' }}">
            <label for="father_name" class="col-md-4 control-label text-md-right">Father Name
                : </label>
            <div class="col-md-6">
                <input id="father_name" type="text" class="form-control input-circle" name="father_name"
                        value="{{ $user->employee->father_name }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('father_phone') ? ' has-error' : '' }}">
            <label for="father_phone" class="col-md-4 control-label text-md-right">Father Phone
                : </label>
            <div class="col-md-6">
                <input id="father_phone" type="text" class="form-control input-circle" name="father_phone"
                        value="{{ $user->employee->father_phone }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('father_email') ? ' has-error' : '' }}">
            <label for="father_email" class="col-md-4 control-label text-md-right">Father Email
                : </label>
            <div class="col-md-6">
                <input id="father_email" type="email" class="form-control input-circle" name="father_email"
                        value="{{ $user->employee->father_email }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('father_nid') ? ' has-error' : '' }}">
            <label for="father_nid" class="col-md-4 control-label text-md-right">Father NID
                : </label>
            <div class="col-md-6">
                <input id="father_nid" type="text" class="form-control input-circle" name="father_nid"
                        value="{{ $user->employee->father_nid }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('mother_name') ? ' has-error' : '' }}">
            <label for="mother_name" class="col-md-4 control-label text-md-right">Mother Name
                : </label>
            <div class="col-md-6">
                <input id="mother_name" type="text" class="form-control input-circle" name="mother_name"
                        value="{{ $user->employee->mother_name }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('mother_phone') ? ' has-error' : '' }}">
            <label for="mother_phone" class="col-md-4 control-label text-md-right">Mother Phone
                : </label>
            <div class="col-md-6">
                <input id="mother_phone" type="text" class="form-control input-circle" name="mother_phone"
                        value="{{ $user->employee->mother_phone }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('mother_email') ? ' has-error' : '' }}">
            <label for="mother_email" class="col-md-4 control-label text-md-right">Mother Email
                : </label>
            <div class="col-md-6">
                <input id="mother_email" type="email" class="form-control input-circle" name="mother_email"
                        value="{{ $user->employee->mother_email }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('mother_nid') ? ' has-error' : '' }}">
            <label for="mother_nid" class="col-md-4 control-label text-md-right">Mother NID
                : </label>
            <div class="col-md-6">
                <input id="mother_nid" type="text" class="form-control input-circle" name="mother_nid"
                        value="{{ $user->employee->mother_nid }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('blood_group') ? ' has-error' : '' }}">
            <label for="blood_group" class="col-md-4 control-label text-md-right">Blood Group
                : </label>
            <div class="col-md-6">
                <input type="text" class="form-control input-circle" value="{{ $user->employee->blood_group }}" readonly>
            </div>
        </div>


        <div class="form-group row mb-3{{ $errors->has('religion') ? ' has-error' : '' }}">
            <label for="religion" class="col-md-4 control-label text-md-right">Religion: </label>
            <div class="col-md-6">
                <input type="text" class="form-control input-circle" value="{{ $user->employee->religion }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('marital_status') ? ' has-error' : '' }}">
            <label for="marital_status" class="col-md-4 control-label text-md-right">Marital Status: </label>
            <div class="col-md-6">
                <input type="text" class="form-control input-circle" value="{{ $user->employee->marital_status }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('spouse_name') ? ' has-error' : '' }}">
            <label for="spouse_name" class="col-md-4 control-label text-md-right">Spouse Name: </label>
            <div class="col-md-6">
                <input type="text" class="form-control input-circle" value="{{ $user->employee->spouse_name }}" readonly>
            </div>
        </div>

    </div>
</div>
