<div class="tab-pane" id="attendant">

    <div class="card-body">
        <div class="form-group row mb-3{{ $errors->has('attendant_id') ? ' has-error' : '' }}">
            <label for="attendant_id" class="col-md-4 control-label text-md-right">Attendant Info
                : </label>
            <div class="col-md-6">
                <select name="attendant_id" id="attendant_id" class="form-control" disabled>
                    <option value="" disabled selected>No Attendant Attached</option>
                    @foreach ($attendants as $attendant)
                        <option value="{{ $attendant->id }}" {{ $attendantInfo && $attendant->id == $attendantInfo->id ? 'selected':'' }}>{{ $attendant->name }} {{ $attendant->contact_no }}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>
</div>
