<div class="tab-pane" id="attendant">
    <form action="{{ route('student.attendant_profile.update', $user->student->id) }}" method="POST" class="saveForm">
    @method('PATCH')
    @csrf
    <div class="card-body">

        <div class="form-group row mb-3{{ $errors->has('attendant_id') ? ' has-error' : '' }}">
            <label for="attendant_id" class="col-md-4 control-label text-md-right">Attendant Info
                : </label>
            <div class="col-md-6">
                <select name="attendant_id" id="attendant_id" class="form-control" {{ Auth::user()->can('ManageAttendant') ? '':'disabled' }}>
                    <option value="" disabled selected>Select Attendant</option>
                    @foreach ($attendants as $attendant)
                        <option value="{{ $attendant->id }}" {{ $attendantInfo && $attendant->id == $attendantInfo->id ? 'selected':'' }}>{{ $attendant->name }} {{ $attendant->contact_no }}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>

    {{--<div class="card-footer">--}}
    <a href="{{ url()->previous() }}" class="btn btn-outline-primary"><i
                class="fa fa-arrow-left"
                aria-hidden="true"></i>{{ __('all_settings.Back') }}</a>
    @can('ManageAttendant')
    <button type="submit" class="btn btn-success float-right" id="saveButton"><i
                class="fa fa-save"
                aria-hidden="true"></i> Update
    </button>
    @endcan
    {{--</div>--}}
    </form>

</div>
