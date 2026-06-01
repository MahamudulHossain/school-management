<div class="tab-pane active" id="g_guardian">
    <form action="{{ route('guardian.personal_profile.update', $user->guardian->user_id) }}" method="POST" class="saveForm">
    @method('PATCH')
    @csrf
    <div class="card-body">

        <div class="form-group row mb-3{{ $errors->has('pre_house') ? ' has-error' : '' }}">
            <label for="pre_house" class="col-md-4 control-label text-md-right">Present House
                : </label>
            <div class="col-md-6">
                <input id="pre_house" type="text" class="form-control input-circle" name="pre_house"
                        value="{{ $user->contact->pre_house }}" placeholder="Enter Present House">
                @if ($errors->has('pre_house'))
                    <span class="help-block">
                    <strong>{{ $errors->first('pre_house') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('pre_road') ? ' has-error' : '' }}">
            <label for="pre_road" class="col-md-4 control-label text-md-right">Present Road
                : </label>
            <div class="col-md-6">
                <input id="pre_road" type="text" class="form-control input-circle" name="pre_road"
                        value="{{ $user->contact->pre_road }}" placeholder="Enter Present Road">
                @if ($errors->has('pre_road'))
                    <span class="help-block">
                    <strong>{{ $errors->first('pre_road') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('pre_state') ? ' has-error' : '' }}">
            <label for="pre_state" class="col-md-4 control-label text-md-right">Present State
                : </label>
            <div class="col-md-6">
                <input id="pre_state" type="text" class="form-control input-circle" name="pre_state"
                        value="{{ $user->contact->pre_state }}" placeholder="Enter Present State">
                @if ($errors->has('pre_state'))
                    <span class="help-block">
                    <strong>{{ $errors->first('pre_state') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('pre_post') ? ' has-error' : '' }}">
            <label for="pre_post" class="col-md-4 control-label text-md-right">Present Postal Address
                : </label>
            <div class="col-md-6">
                <input id="pre_post" type="text" class="form-control input-circle" name="pre_post"
                        value="{{ $user->contact->pre_post }}" placeholder="Enter Present Postal Address">
                @if ($errors->has('pre_post'))
                    <span class="help-block">
                    <strong>{{ $errors->first('pre_post') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('pre_thana') ? ' has-error' : '' }}">
            <label for="pre_thana" class="col-md-4 control-label text-md-right">Present Thana
                : </label>
            <div class="col-md-6">
                <input id="pre_thana" type="text" class="form-control input-circle" name="pre_thana"
                        value="{{ $user->contact->pre_thana }}" placeholder="Enter Present Thana">
                @if ($errors->has('pre_thana'))
                    <span class="help-block">
                    <strong>{{ $errors->first('pre_thana') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('pre_district') ? ' has-error' : '' }}">
            <label for="pre_district" class="col-md-4 control-label text-md-right">Present District
                : </label>
            <div class="col-md-6">
                <input id="pre_district" type="text" class="form-control input-circle" name="pre_district"
                        value="{{ $user->contact->pre_district }}" placeholder="Enter Present District">
                @if ($errors->has('pre_district'))
                    <span class="help-block">
                    <strong>{{ $errors->first('pre_district') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('pre_division') ? ' has-error' : '' }}">
            <label for="pre_division" class="col-md-4 control-label text-md-right">Present Division
                : </label>
            <div class="col-md-6">
                <input id="pre_division" type="text" class="form-control input-circle" name="pre_division"
                        value="{{ $user->contact->pre_division }}" placeholder="Enter Present Division">
                @if ($errors->has('pre_division'))
                    <span class="help-block">
                    <strong>{{ $errors->first('pre_division') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('pre_country') ? ' has-error' : '' }}">
            <label for="pre_country" class="col-md-4 control-label text-md-right">Present Country
                : </label>
            <div class="col-md-6">
                <input id="pre_country" type="text" class="form-control input-circle" name="pre_country"
                        value="{{ $user->contact->pre_country }}" placeholder="Enter Present Country">
                @if ($errors->has('pre_country'))
                    <span class="help-block">
                    <strong>{{ $errors->first('pre_country') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-3{{ $errors->has('pre_country') ? ' has-error' : '' }}">
            <div class="col-md-6">
                <input type="checkbox" id="present_permanent" name="present_permanent" value="1" {{ $user->contact->present_permanent ? 'checked' : '' }}>
                    <b>Permanent address is same as present address</b>
            </div>
        </div>

        <div id="permanent_address" {{ $user->contact->present_permanent ? 'style=display:none' : '' }}>
            <div class="form-group row mb-3{{ $errors->has('per_house') ? ' has-error' : '' }}">
                <label for="per_house" class="col-md-4 control-label text-md-right">Permanent House
                    : </label>
                <div class="col-md-6">
                    <input id="per_house" type="text" class="form-control input-circle" name="per_house"
                            value="{{ $user->contact->per_house }}" placeholder="Enter Permanent House">
                    @if ($errors->has('per_house'))
                        <span class="help-block">
                        <strong>{{ $errors->first('per_house') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group row mb-3{{ $errors->has('per_road') ? ' has-error' : '' }}">
                <label for="per_road" class="col-md-4 control-label text-md-right">Permanent Road
                    : </label>
                <div class="col-md-6">
                    <input id="per_road" type="text" class="form-control input-circle" name="per_road"
                            value="{{ $user->contact->per_road }}" placeholder="Enter Permanent Road">
                    @if ($errors->has('per_road'))
                        <span class="help-block">
                        <strong>{{ $errors->first('per_road') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group row mb-3{{ $errors->has('per_state') ? ' has-error' : '' }}">
                <label for="per_state" class="col-md-4 control-label text-md-right">Permanent State
                    : </label>
                <div class="col-md-6">
                    <input id="per_state" type="text" class="form-control input-circle" name="per_state"
                            value="{{ $user->contact->per_state }}" placeholder="Enter Permanent State">
                    @if ($errors->has('per_state'))
                        <span class="help-block">
                        <strong>{{ $errors->first('per_state') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group row mb-3{{ $errors->has('per_post') ? ' has-error' : '' }}">
                <label for="per_post" class="col-md-4 control-label text-md-right">Permanent Postal Address
                    : </label>
                <div class="col-md-6">
                    <input id="per_post" type="text" class="form-control input-circle" name="per_post"
                            value="{{ $user->contact->per_post }}" placeholder="Enter Permanent Postal Address">
                    @if ($errors->has('per_post'))
                        <span class="help-block">
                        <strong>{{ $errors->first('per_post') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group row mb-3{{ $errors->has('per_thana') ? ' has-error' : '' }}">
                <label for="per_thana" class="col-md-4 control-label text-md-right">Permanent Thana
                    : </label>
                <div class="col-md-6">
                    <input id="per_thana" type="text" class="form-control input-circle" name="per_thana"
                            value="{{ $user->contact->per_thana }}" placeholder="Enter Permanent Thana">
                    @if ($errors->has('per_thana'))
                        <span class="help-block">
                        <strong>{{ $errors->first('per_thana') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group row mb-3{{ $errors->has('per_district') ? ' has-error' : '' }}">
                <label for="per_district" class="col-md-4 control-label text-md-right">Permanent District
                    : </label>
                <div class="col-md-6">
                    <input id="per_district" type="text" class="form-control input-circle" name="per_district"
                            value="{{ $user->contact->per_district }}" placeholder="Enter Permanent District">
                    @if ($errors->has('per_district'))
                        <span class="help-block">
                        <strong>{{ $errors->first('per_district') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group row mb-3{{ $errors->has('per_division') ? ' has-error' : '' }}">
                <label for="per_division" class="col-md-4 control-label text-md-right">Permanent Division
                    : </label>
                <div class="col-md-6">
                    <input id="per_division" type="text" class="form-control input-circle" name="per_division"
                            value="{{ $user->contact->per_division }}" placeholder="Enter Permanent Division">
                    @if ($errors->has('per_division'))
                        <span class="help-block">
                        <strong>{{ $errors->first('per_division') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group row mb-3{{ $errors->has('per_country') ? ' has-error' : '' }}">
                <label for="per_country" class="col-md-4 control-label text-md-right">Permanent Country
                    : </label>
                <div class="col-md-6">
                    <input id="per_country" type="text" class="form-control input-circle" name="per_country"
                            value="{{ $user->contact->per_country }}" placeholder="Enter Permanent Country">
                    @if ($errors->has('per_country'))
                        <span class="help-block">
                        <strong>{{ $errors->first('per_country') }}</strong>
                    </span>
                    @endif
                </div>
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
@push('js')
    <script>
        $(document).ready(function() {
            $('#present_permanent').change(function() {
                if ($(this).is(':checked')) {
                    $('#permanent_address').hide();
                } else {
                    $('#permanent_address').show();
                }
            });
        });
    </script>
@endpush
