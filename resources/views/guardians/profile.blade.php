<div class="tab-pane" id="guardian_profile">
    <form action="{{ route('profile.update', $user->profile->id) }}" method="POST" class="saveForm">
    @method('PATCH')
    @csrf
    <div class="card-body">
        <div class="form-group row mb-3">
            <label class="col-md-4 control-label text-right">Personnel ID:</label>
            <div class="col-md-6">
                <input id="personnel_id" type="text" class="form-control input-circle" name="personnel_id"
                    value="{{ $user->personnel_id }}" placeholder="Enter Personnel ID" disabled>
            </div>
        </div>
        <div
                class="form-group row mb-3{{ $errors->has('joining_date') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label text-md-right">Joining Date : <span
                        class="required"> * </span></label>
            <div class="col-md-6 input-group date" id="joining_date"
                data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input"
                    name="joining_date"
                    value="{{ Carbon\Carbon::parse($user->profile->joining_date)->format('d-m-Y') }}"
                    data-target="#joining_date"/>
                <div class="input-group-append" data-target="#joining_date"
                    data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
            @if ($errors->has('joining_date'))
                <span class="help-block">
        <strong>{{ $errors->first('joining_date') }}</strong>
                </span>
            @endif

        </div>
        <div
                class="form-group row mb-3{{ $errors->has('date_of_birth') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label text-md-right">Date of Birth : </label>
            <div class="col-md-6 input-group date" id="date_of_birth"
                data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input"
                    name="date_of_birth"
                    value="{{ ($user->profile->date_of_birth!=null)? Carbon\Carbon::parse($user->profile->date_of_birth)->format('d-m-Y'):'' }}"
                    data-target="#date_of_birth"/>
                <div class="input-group-append" data-target="#date_of_birth"
                    data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
            @if ($errors->has('date_of_birth'))
                <span class="help-block">
        <strong>{{ $errors->first('date_of_birth') }}</strong>
    </span>
            @endif
        </div>
        <div class="form-group row mb-3{{ $errors->has('gender') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label text-md-right">Gender:<span
                        class="required"> * </span></label>
            <div class=" col-md-6 mt-radio-inline">
                <label class="mt-radio">
                    <input type="radio" name="gender"
                        value="Male" {{ ($user->profile->gender=="Male")? "checked" : "" }} >Male
                    <span> </span>
                </label>
                <label class="mt-radio">
                    <input type="radio" name="gender"
                        value="Female" {{ ($user->profile->gender=="Female")? "checked" : "" }} >Female
                    <span> </span>
                </label>
                <label class="mt-radio">
                    <input type="radio" name="gender"
                        value="Others" {{ ($user->profile->gender=="Others")? "checked" : "" }} >Others
                    <span> </span>
                </label>
            </div>
            @if ($errors->has('gender'))
                <span class="help-block">
        <strong>{{ $errors->first('gender') }}</strong>
    </span>
            @endif
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
