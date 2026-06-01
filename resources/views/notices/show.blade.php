@extends('layouts.al4_main')
@section('notice_mo','menu-open')
@section('notice','active')
@section('list_notice','active')
@section('title','Notice Show')
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('notice')}}" class="nav-link">Notice</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0)" class="nav-link">Show Notice</a>
    </li>
@endsection
@push('css')
@endpush
@section('maincontent')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Show Notice</h3>
        </div>

        <div class="card-body" id="print_this0">
            <div>
                <div><h3>{!! $notice->title !!}</h3></div>
                <p>
                    <span>Attached File:</span>
                    <a href="{{ asset('storage/pdf/' . $notice->details) }}" target="_blank" class="btn btn-info btn-sm">View PDF</a>
                <hr>
                {{'Notice by: '}} {!! $notice->user->name !!} </br>
                {{'Date: '}} {!! $notice->created_at !!}</br>

                </p>
            </div>
        </div>

        <div class="card-footer">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm"><i
                        class="fa fa-arrow-left"
                        aria-hidden="true"></i>{{ __('all_settings.Back') }}</a>
            <a type="button" id="pbutton0" class="btn btn-warning btn-sm pull-right"><i
                                class="fa fa-print"> Print</i></a>
            {{--                    @can('geo_location-access')--}}
            <form method="POST" action="{{ url('notice/' . $notice->id) }}" style="display:inline">
                @csrf
                @method('DELETE')

                <button type="submit"
                    class="btn btn-danger btn-sm fa-pull-right"
                    title="Delete"
                    onclick="return confirm('Confirm delete?')">
                    <span class="far fa-trash-alt" aria-hidden="true" title="Delete"></span>
                </button>
            </form>
            <a href="{{ url('notice/' . $notice->id . '/edit') }}"
               class="btn btn-info btn-sm fa-pull-right" title="Edit" style="margin-right: 10px"><span
                        class="far fa-edit"
                        aria-hidden="true"></span></a>

        </div>
    </div>

@endsection
@push('js')
    <script src="{!! asset('alte4/dist/js/printthis.js')!!}" type="text/javascript"></script>
    <script type="text/javascript">
        //    console.log(id);
        $('#pbutton0').on('click', function () {
//    $('.printt').on('click', function(){
            $("#print_this0").printThis({
                debug: false,
                importCSS: true,
                importStyle: true,
                printContainer: true,
//            loadCSS: "../../../public/tf/global/plugins/bootstrap/css/bootstrap.min.css",
                pageTitle: "",
                removeInline: false,
                printDelay: 333,
                header: null,
                footer: null,
                base: false,
//            formValues: true,
                canvas: false,
//            doctypeString: "...",
                removeScripts: false,
                copyTagClasses: false
            });
        });
        $('#pbutton2').on('click', function () {
            $("#print_this2").printThis({
                debug: false,
                importCSS: true,
                importStyle: true,
                printContainer: true,
//            loadCSS: "../../../public/tf/global/plugins/bootstrap/css/bootstrap.min.css",
                pageTitle: "",
                removeInline: false,
                printDelay: 333,
                header: null,
                footer: null,
                base: false,
//            formValues: true,
                canvas: false,
//            doctypeString: "...",
                removeScripts: false,
                copyTagClasses: false
            });
        });


    </script>
@endpush
