<div class="tab-pane" id="personal">
    <div class="card-body">

        <div class="form-group row mb-3{{ $errors->has('first_name') ? ' has-error' : '' }}">
            <label for="first_name" class="col-md-4 control-label text-md-right">First Name
                : </label>
            <div class="col-md-6">
                <input id="first_name" type="text" class="form-control input-circle" name="first_name"
                        value="{{ $user->student->first_name }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('middle_name') ? ' has-error' : '' }}">
            <label for="middle_name" class="col-md-4 control-label text-md-right">Middle Name
                : </label>
            <div class="col-md-6">
                <input id="middle_name" type="text" class="form-control input-circle" name="middle_name"
                        value="{{ $user->student->middle_name }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('last_name') ? ' has-error' : '' }}">
            <label for="last_name" class="col-md-4 control-label text-md-right">Last Name
                : </label>
            <div class="col-md-6">
                <input id="last_name" type="text" class="form-control input-circle" name="last_name"
                        value="{{ $user->student->last_name }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label class="col-md-4 control-label text-right">Card No:</label>
            <div class="col-md-6">
                <input id="card_number" type="text" class="form-control input-circle" name="card_number"
                    value="{{ $user->student->card_number }}" readonly>
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
                        value="{{ $user->student->emergency_contact }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('blood_group') ? ' has-error' : '' }}">
            <label for="blood_group" class="col-md-4 control-label text-md-right">Blood Group
                : </label>
            <div class="col-md-6">
                <input type="text" class="form-control input-circle" value="{{ $user->student->blood_group }}" readonly>
            </div>
        </div>


        <div class="form-group row mb-3{{ $errors->has('religion') ? ' has-error' : '' }}">
            <label for="religion" class="col-md-4 control-label text-md-right">Religion: </label>
            <div class="col-md-6">
                <input type="text" class="form-control input-circle" value="{{ $user->student->religion }}" readonly>
            </div>
        </div>

    </div>
</div>
