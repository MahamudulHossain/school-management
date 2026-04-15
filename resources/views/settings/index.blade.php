@extends('layouts.al4_main')
@section('settings_mo','menu-open')
@section('settings','active')
@section('manage_setting','active')
@section('title','Settings')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Settings</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">General Settings</a>
    </li>
@endsection
@push('css')
@endpush
@section('maincontent')
    <div class="row justify-content-center ">
        <div class="col-md-8">

            <div class="card card-success card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                               href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                               aria-selected="true"> Settings View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                               href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                               aria-selected="false">Settings Update</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                             aria-labelledby="custom-tabs-one-home-tab">
                            <div class="form-group row mb-3">
                                <label class="col-md-6 control-label text-md-right"><strong>Org Name : </strong></label>
                                <div class="col-md-6">
                                    <div class="form-control-static"> {{$settings->org_name}}</div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-6 control-label text-md-right"><strong>Org Slogan
                                        : </strong></label>
                                <div class="col-md-6">
                                    <div class="form-control-static"> {{$settings->org_slogan}}</div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-6 control-label text-md-right"><strong>Address Line-1
                                        : </strong></label>
                                <div class="col-md-6">
                                    <div class="form-control-static"> {{$settings->address_line1}}</div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-6 control-label text-md-right"><strong>Address Line-2
                                        : </strong></label>
                                <div class="col-md-6">
                                    <div class="form-control-static"> {{$settings->address_line2}}</div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-6 control-label text-md-right"><strong>Contact No-1
                                        : </strong></label>
                                <div class="col-md-6">
                                    <div class="form-control-static"> {{$settings->contact_no1}}</div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-6 control-label text-md-right"><strong>Contact No-2
                                        : </strong></label>
                                <div class="col-md-6">
                                    <div class="form-control-static"> {{$settings->contact_no2}}</div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-6 control-label text-md-right"><strong>Email : </strong></label>
                                <div class="col-md-6">
                                    <div class="form-control-static"> {{$settings->email}}</div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-6 control-label text-md-right"><strong>Web : </strong></label>
                                <div class="col-md-6">
                                    <div class="form-control-static"> {{$settings->web}}</div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-6 control-label text-md-right"><strong>Price Format : </strong></label>
                                <div class="col-md-6">
                                    <div class="form-control-static">  {{$settings->price_formats}}</div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-6 control-label text-md-right"><strong>Country : </strong></label>
                                <div class="col-md-6">
                                    <div class="form-control-static"> {{$settings->country->country_title}} </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                             aria-labelledby="custom-tabs-one-profile-tab">
                            <form action="{{ route('setting.update', $settings->id) }}" method="POST" class="form-horizontal">
                                @csrf
                                @method('PATCH')
                            <div class="form-group row mb-3 {{ $errors->has('org_name') ? ' has-error' : '' }}">
                                <label class="control-label col-md-5 text-md-right">Org Name: <span
                                            class="required"> * </span></label>
                                <div class=" col-md-7">
                                    <input type="text" name="org_name" class="form-control input-circle" placeholder="Please Enter Org Name" value="{{ $settings->org_name }}" required>
                                    @if ($errors->has('org_name'))
                                        <span class="help-block"><strong>{{ $errors->first('org_name') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-3 {{ $errors->has('org_slogan') ? ' has-error' : '' }}">
                                <label class="control-label col-md-5 text-md-right">Org Slogan: </label>
                                <div class=" col-md-7">
                                    <input type="text" name="org_slogan" class="form-control input-circle" placeholder="Please Enter Org Slogan" value="{{ $settings->org_slogan }}">
                                    @if ($errors->has('org_slogan'))
                                        <span class="help-block"><strong>{{ $errors->first('org_slogan') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-3 {{ $errors->has('address_line1') ? ' has-error' : '' }}">
                                <label class="control-label col-md-5 text-md-right">Address Line1: <span
                                            class="required"> * </span></label>
                                <div class=" col-md-7">
                                    <input type="text" name="address_line1" class="form-control input-circle" placeholder="Please Enter Address" value="{{ $settings->address_line1 }}" required>
                                    @if ($errors->has('address_line1'))
                                        <span class="help-block"><strong>{{ $errors->first('address_line1') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-3 {{ $errors->has('address_line2') ? ' has-error' : '' }}">
                                <label class="control-label col-md-5 text-md-right">Address Line2: </label>
                                <div class=" col-md-7">
                                    <input type="text" name="address_line2" class="form-control input-circle" placeholder="Please Enter Address" value="{{ $settings->address_line2 }}">
                                    @if ($errors->has('address_line2'))
                                        <span class="help-block"><strong>{{ $errors->first('address_line2') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-3 {{ $errors->has('contact_no1') ? ' has-error' : '' }}">
                                <label class="control-label col-md-5 text-md-right">Contact No-1: <span
                                            class="required"> * </span></label>
                                <div class=" col-md-7">
                                    <input id="contact_no1" type="text" class="form-control" name="contact_no1"
                                   value="{{ $settings->contact_no1 }}" placeholder="Mobile Number"
                                   pattern="^\+?[1-9][0-9]{6,14}$" maxlength="14"
                                   onfocus="if (this.hasAttribute('readonly')) { this.removeAttribute('readonly');
                                   this.blur(); this.focus();  }" required />
                                    @if ($errors->has('contact_no1'))
                                        <span class="help-block"><strong>{{ $errors->first('contact_no1') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-3 {{ $errors->has('contact_no2') ? ' has-error' : '' }}">
                                <label class="control-label col-md-5 text-md-right">Contact No-2: </label>
                                <div class=" col-md-7">
                                    <input type="text" name="contact_no2" class="form-control input-circle" placeholder="Please Enter Contact" value="{{ $settings->contact_no2 }}">
                                    @if ($errors->has('contact_no2'))
                                        <span class="help-block"><strong>{{ $errors->first('contact_no2') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-3 {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="control-label col-md-5 text-md-right">Email: </label>
                                <div class=" col-md-7">
                                    <input type="text" name="email" class="form-control input-circle" placeholder="Please Enter Email" value="{{ $settings->email }}">
                                    @if ($errors->has('email'))
                                        <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-3 {{ $errors->has('web') ? ' has-error' : '' }}">
                                <label class="control-label col-md-5 text-md-right">Web: </label>
                                <div class=" col-md-7">
                                    <input type="text" name="web" class="form-control input-circle" placeholder="Please Enter web" value="{{ $settings->web }}">
                                    @if ($errors->has('web'))
                                        <span class="help-block"><strong>{{ $errors->first('web') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-3 {{ $errors->has('country_id') ? ' has-error' : '' }}">
                                <label class="control-label col-md-5 text-right">Country :<span
                                            class="required"> * </span></label>
                                <div class="col-md-7">
                                    <select name="country_id" id="country_id" class="form-control select2" required>
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ $settings->country_id == $country->id ? 'selected' : '' }}>{{ $country->country_title }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('country_id'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('country_id') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-3 {{ $errors->has('price_formats') ? ' has-error' : '' }}">
                                <label class="control-label col-md-5 text-md-right">Price Format: </label>
                                <div class=" col-md-7">
                                    <input type="radio" name="price_formats" value="One Decimal" {{ $settings->price_formats == 'One Decimal' ? 'checked': '' }}>One Decimal
                                    <input type="radio" name="price_formats" value="Two Decimal" {{ $settings->price_formats == 'Two Decimal' ? 'checked': '' }}>Two Decimal
                                    <input type="radio" name="price_formats" value="Round" {{ $settings->price_formats == 'Round' ? 'checked': '' }}>Round
                                    <input type="radio" name="price_formats" value="Plain" {{ $settings->price_formats == 'Plain' ? 'checked': '' }}>Plain
                                    @if ($errors->has('vat_reg_no'))
                                        <span class="help-block"><strong>{{ $errors->first('price_formats') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <div class="card-footer">
                                {{--<button type="submit" class="btn btn-outline-dark">{{ __('all_settings.Back') }}</button>--}}
                                <a href="{{ url()->previous() }}" class="btn btn-outline-dark"><i
                                            class="fa fa-arrow-left"
                                            aria-hidden="true"></i> {{ __('all_settings.Back') }}</a>

                                <button type="submit" class="btn btn-info float-right" id="saveButton"><i
                                            class="fa fa-save"
                                            aria-hidden="true"></i> Save
                                </button>
                            </div>
                            <!-- /.card-footer -->
                            </form>
                            {{-- {!! Form::close() !!} --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
