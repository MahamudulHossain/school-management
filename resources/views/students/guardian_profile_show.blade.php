<div class="tab-pane" id="guardian">

    <div class="card-body">

        <div class="form-group row mb-3{{ $errors->has('g_email') ? ' has-error' : '' }}">
            <label for="g_email" class="col-md-4 control-label text-md-right">Guardian's Email
                : </label>
            <div class="col-md-6">
                <input id="g_email" type="text" class="form-control input-circle" value="{{ $attachedGuardian->guardian->user->email ?? '' }}" readonly>
            </div>
        </div>

         <div class="form-group row mb-3{{ $errors->has('g_cell_phone') ? ' has-error' : '' }}">
            <label for="g_cell_phone" class="col-md-4 control-label text-md-right">Guardian's Cell No
                : </label>
            <div class="col-md-6">
                <input id="g_cell_phone" type="text" class="form-control input-circle" value="{{ $attachedGuardian->guardian->user->cell_phone ?? '' }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('father_first_name') ? ' has-error' : '' }}">
            <label for="father_first_name" class="col-md-4 control-label text-md-right">Father's First Name
                : </label>
            <div class="col-md-6">
                <input id="father_first_name" type="text" class="form-control input-circle" name="father_first_name"
                        value="{{ $user->student->guardian->first()->father_first_name }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('father_middle_name') ? ' has-error' : '' }}">
            <label for="father_middle_name" class="col-md-4 control-label text-md-right">Father's Middle Name
                : </label>
            <div class="col-md-6">
                <input id="father_middle_name" type="text" class="form-control input-circle" name="father_middle_name"
                        value="{{ $user->student->guardian->first()->father_middle_name }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('father_last_name') ? ' has-error' : '' }}">
            <label for="father_last_name" class="col-md-4 control-label text-md-right">Father's Last Name
                : </label>
            <div class="col-md-6">
                <input id="father_last_name" type="text" class="form-control input-circle" name="father_last_name"
                        value="{{ $user->student->guardian->first()->father_last_name }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label class="col-md-4 control-label text-right">Father's Phone:</label>
            <div class="col-md-6">
                <input id="father_phone" type="text" class="form-control input-circle" name="father_phone"
                    value="{{ $user->student->guardian->first()->father_phone }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('father_nid') ? ' has-error' : '' }}">
            <label for="father_nid" class="col-md-4 control-label text-md-right">Father's NID
                : </label>
            <div class="col-md-6">
                <input id="father_nid" type="text" class="form-control input-circle" name="father_nid"
                        value="{{ $user->student->guardian->first()->father_nid }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('mother_first_name') ? ' has-error' : '' }}">
            <label for="mother_first_name" class="col-md-4 control-label text-md-right">Mother's First Name
                : </label>
            <div class="col-md-6">
                <input id="mother_first_name" type="text" class="form-control input-circle" name="mother_first_name"
                        value="{{ $user->student->guardian->first()->mother_first_name }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('mother_middle_name') ? ' has-error' : '' }}">
            <label for="mother_middle_name" class="col-md-4 control-label text-md-right">Mother's Middle Name
                : </label>
            <div class="col-md-6">
                <input id="mother_middle_name" type="text" class="form-control input-circle" name="mother_middle_name"
                        value="{{ $user->student->guardian->first()->mother_middle_name }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('mother_last_name') ? ' has-error' : '' }}">
            <label for="mother_last_name" class="col-md-4 control-label text-md-right">Mother's Last Name
                : </label>
            <div class="col-md-6">
                <input id="mother_last_name" type="text" class="form-control input-circle" name="mother_last_name"
                        value="{{ $user->student->guardian->first()->mother_last_name }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label class="col-md-4 control-label text-right">Mother's Phone:</label>
            <div class="col-md-6">
                <input id="mother_phone" type="text" class="form-control input-circle" name="mother_phone"
                    value="{{ $user->student->guardian->first()->mother_phone }}" readonly>
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('mother_nid') ? ' has-error' : '' }}">
            <label for="mother_nid" class="col-md-4 control-label text-md-right">Mother's NID
                : </label>
            <div class="col-md-6">
                <input id="mother_nid" type="text" class="form-control input-circle" name="mother_nid"
                        value="{{ $user->student->guardian->first()->mother_nid }}" readonly>
            </div>
        </div>

    </div>

</div>
