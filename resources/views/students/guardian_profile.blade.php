<div class="tab-pane" id="guardian">
    <form action="{{ route('student.guardian_profile.update', $user->student->guardian->first()->id) }}" method="POST" class="saveForm">
    @method('PATCH')
    @csrf
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
                        value="{{ $user->student->guardian->first()->father_first_name }}" placeholder="Enter Father's First Name">
                @if ($errors->has('father_first_name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('father_first_name') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('father_middle_name') ? ' has-error' : '' }}">
            <label for="father_middle_name" class="col-md-4 control-label text-md-right">Father's Middle Name
                : </label>
            <div class="col-md-6">
                <input id="father_middle_name" type="text" class="form-control input-circle" name="father_middle_name"
                        value="{{ $user->student->guardian->first()->father_middle_name }}" placeholder="Enter Father's Middle Name">
                @if ($errors->has('father_middle_name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('father_middle_name') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('father_last_name') ? ' has-error' : '' }}">
            <label for="father_last_name" class="col-md-4 control-label text-md-right">Father's Last Name
                : </label>
            <div class="col-md-6">
                <input id="father_last_name" type="text" class="form-control input-circle" name="father_last_name"
                        value="{{ $user->student->guardian->first()->father_last_name }}" placeholder="Enter Father's Last Name">
                @if ($errors->has('father_last_name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('father_last_name') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3">
            <label class="col-md-4 control-label text-right">Father's Phone:</label>
            <div class="col-md-6">
                <input id="father_phone" type="text" class="form-control input-circle" name="father_phone"
                    value="{{ $user->student->guardian->first()->father_phone }}" placeholder="Enter Father's Phone">
                @if ($errors->has('father_phone'))
                    <span class="help-block">
                    <strong>{{ $errors->first('father_phone') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('father_nid') ? ' has-error' : '' }}">
            <label for="father_nid" class="col-md-4 control-label text-md-right">Father's NID
                : </label>
            <div class="col-md-6">
                <input id="father_nid" type="text" class="form-control input-circle" name="father_nid"
                        value="{{ $user->student->guardian->first()->father_nid }}" placeholder="Enter Father's NID">
                @if ($errors->has('father_nid'))
                    <span class="help-block">
                    <strong>{{ $errors->first('father_nid') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('mother_first_name') ? ' has-error' : '' }}">
            <label for="mother_first_name" class="col-md-4 control-label text-md-right">Mother's First Name
                : </label>
            <div class="col-md-6">
                <input id="mother_first_name" type="text" class="form-control input-circle" name="mother_first_name"
                        value="{{ $user->student->guardian->first()->mother_first_name }}" placeholder="Enter Mother's First Name">
                @if ($errors->has('mother_first_name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('mother_first_name') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('mother_middle_name') ? ' has-error' : '' }}">
            <label for="mother_middle_name" class="col-md-4 control-label text-md-right">Mother's Middle Name
                : </label>
            <div class="col-md-6">
                <input id="mother_middle_name" type="text" class="form-control input-circle" name="mother_middle_name"
                        value="{{ $user->student->guardian->first()->mother_middle_name }}" placeholder="Enter Mother's Middle Name">
                @if ($errors->has('mother_middle_name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('mother_middle_name') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('mother_last_name') ? ' has-error' : '' }}">
            <label for="mother_last_name" class="col-md-4 control-label text-md-right">Mother's Last Name
                : </label>
            <div class="col-md-6">
                <input id="mother_last_name" type="text" class="form-control input-circle" name="mother_last_name"
                        value="{{ $user->student->guardian->first()->mother_last_name }}" placeholder="Enter Mother's Last Name">
                @if ($errors->has('mother_last_name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('mother_last_name') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3">
            <label class="col-md-4 control-label text-right">Mother's Phone:</label>
            <div class="col-md-6">
                <input id="mother_phone" type="text" class="form-control input-circle" name="mother_phone"
                    value="{{ $user->student->guardian->first()->mother_phone }}" placeholder="Enter Mother's Phone">
                @if ($errors->has('mother_phone'))
                    <span class="help-block">
                    <strong>{{ $errors->first('mother_phone') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('mother_nid') ? ' has-error' : '' }}">
            <label for="mother_nid" class="col-md-4 control-label text-md-right">Mother's NID
                : </label>
            <div class="col-md-6">
                <input id="mother_nid" type="text" class="form-control input-circle" name="mother_nid"
                        value="{{ $user->student->guardian->first()->mother_nid }}" placeholder="Enter Mother's NID">
                @if ($errors->has('mother_nid'))
                    <span class="help-block">
                    <strong>{{ $errors->first('mother_nid') }}</strong>
                </span>
                @endif
            </div>
        </div>

        {{-- <div class="form-group row mb-3{{ $errors->has('guardian_type') ? ' has-error' : '' }}">
            <label for="guardian_type" class="col-md-4 control-label text-md-right">Guardian Type
                : </label>
            <div class="col-md-6">
                <input id="guardian_type" type="text" class="form-control input-circle" name="guardian_type"
                        value="{{ $user->student->guardian->first()->guardian_type }}" placeholder="Enter Guardian Type">
                @if ($errors->has('guardian_type'))
                    <span class="help-block">
                    <strong>{{ $errors->first('guardian_type') }}</strong>
                </span>
                @endif
            </div>
        </div> --}}

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
