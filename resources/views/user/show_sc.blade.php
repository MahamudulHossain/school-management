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
                                <li class="nav-item"><a class="nav-link active" href="#about"
                                                        data-toggle="tab">About</a></li>
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

<!-- Tempusdominus Bootstrap 4 -->
{{--<script--}}
        {{--src="{!! asset('alte305/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')!!}"></script>--}}
<script src={!! asset('supporting/bootstrap-fileinput/bootstrap-fileinput.js')!!} type="text/javascript"></script>
<script src="{{ asset('supporting/dataTables/bs4/datatables.min.js')}}"></script>
<script src="{{ asset('supporting/dataTables/dataTables.fixedHeader.min.js')}}"></script>

@endpush
