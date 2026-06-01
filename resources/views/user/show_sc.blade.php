@extends('layouts.al4_main')
@section('user_mo','menu-open')
@section('user','active')
@section('manage_'.$user_type,'active')
@section('title','Manage '.$user_type)

@push('css')
{{--<link rel="stylesheet"--}}
      {{--href="{{ asset('alte305/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">--}}
<link href="{!! asset('supporting/bootstrap-fileinput/bootstrap-fileinput.css')!!}" rel="stylesheet"
      type="text/css"/>
<link rel="stylesheet" href="{{ asset('supporting/dataTables/bs4/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('supporting/dataTables/fixedHeader.dataTables.min.css') }}">

@endpush
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('user')}}" class="nav-link">User</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Show User</a>
    </li>
@endsection

@section('maincontent')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
            @include('user.show_basicInfo')
            <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#about" data-toggle="tab">About</a></li>
                                @if(in_array($user->user_type_id, [2,3,4]))
                                <li class="nav-item"><a class="nav-link" href="#personal" data-toggle="tab">Personal Info</a></li>
                                @endif
                                @if($user->user_type_id == 2)
                                <li class="nav-item"><a class="nav-link" href="#academic" data-toggle="tab">Academic</a></li>
                                <li class="nav-item"><a class="nav-link" href="#guardian" data-toggle="tab">Guardian</a></li>
                                <li class="nav-item"><a class="nav-link" href="#attendant" data-toggle="tab">Attendant</a></li>
                                <li class="nav-item"><a class="nav-link" href="#routine" data-toggle="tab">Routine</a></li>
                                <li class="nav-item"><a class="nav-link" href="#ledger" data-toggle="tab">Ledger</a></li>
                                @endif
                                @if ($user->user_type_id == 5)
                                    <li class="nav-item"><a class="nav-link" href="#dependents" data-toggle="tab">Dependents</a></li>
                                @endif
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">

                                <div class="active tab-pane" id="about">

                                    <div class="card-body">
                                        <strong><i class="fas fa-book mr-1"></i> Info</strong>
                                        <address>
                                            <strong>NID:</strong> {{$user->profile->nid}}<br/>
                                            <strong>Joining:</strong> {{Carbon\Carbon::parse(date('Y-m-d', strtotime($user->profile->joining_date)))->format('d-M-Y')}}
                                            <br/>
                                            <strong>DOB:</strong> {{($user->profile->date_of_birth==null)?'':Carbon\Carbon::parse(date('Y-m-d', strtotime($user->profile->date_of_birth)))->format('d-M-Y')}}
                                            <br/>
                                            <strong>Gender:</strong> {{$user->profile->gender}}<br/>
                                        </address>
                                        <hr>
                                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>
                                        <p class="text-muted">{{$user->profile->address}}</p>
                                        <address>
                                            Contact-1 : {{ $user->profile->contact_no1}}<br/>
                                            Contact-2 : {{ $user->profile->contact_no2}}
                                        </address>
                                        <hr>
                                    </div>
                                </div>

                                @if($user->user_type_id == 2) {{-- Student --}}
                                    @include('students.personal_profile_show')
                                    @include('students.academic_info_show')
                                    @include('students.guardian_profile_show')
                                    @include('students.attendant_profile_show')
                                    @include('students.routine')
                                    @include('students.ledger')
                                @endif

                                @if($user->user_type_id == 3) {{-- Teacher --}}
                                    @include('teachers.personal_profile_show')
                                @endif

                                @if($user->user_type_id == 4) {{-- Employee --}}
                                    @include('employees.personal_profile_show')
                                @endif

                                @if($user->user_type_id == 5) {{-- Guardian --}}
                                    @include('guardians.dependents')
                                @endif

                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection
@push('js')
<!-- InputMask for Date picker-->
<script src="{!! asset('alte4/plugins/inputmask/min/jquery.inputmask.bundle.min.js')!!}"></script>
<script src={!! asset('supporting/bootstrap-fileinput/bootstrap-fileinput.js')!!} type="text/javascript"></script>
<script src="{{ asset('supporting/dataTables/bs4/datatables.min.js')}}"></script>
<script src="{{ asset('supporting/dataTables/dataTables.fixedHeader.min.js')}}"></script>

@endpush
