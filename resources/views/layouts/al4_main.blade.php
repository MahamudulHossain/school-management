<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') | {{ config('app.name', 'EIS') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">

{{--<link rel="stylesheet" href="https://cdn.usebootstrap.com/bootstrap/4.1.1/css/bootstrap.min.css">--}}
<!-- Font Awesome Icons -->
    {{--        <link rel="stylesheet" href="{!! asset('AdminLTE-3.0.5/plugins/fontawesome-free/css/all.min.css')!!}">--}}
    <link rel="stylesheet" href="{!! asset('alte4/plugins/fontawesome-free/css/all.min.css')!!}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{!! asset('custom/css/custom.css')!!}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
      media="print"
      onload="this.media='all'"
    />

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />
    <!-- jsvectormap -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
      integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
      crossorigin="anonymous"
    />

    <link rel="shortcut icon" href="{!! asset('/favicon.ico')!!}" type="image/x-icon">
    <link rel="icon" href="{!! asset('/favicon.ico')!!}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('supporting/toastr/toastr.min.css') }}">

    @stack('css')
    <link rel="stylesheet" href="{!! asset('alte4/dist/css/adminlte.min.css')!!}">

</head>
<body onload="startTime();setdate()" class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
<!-- Site wrapper -->
<div class="app-wrapper">
    <!-- Navbar -->
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="bi bi-list"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{url('home')}}" class="nav-link">{{ __('all_settings.breadcrumb_home') }}</a>
                </li>
                @yield('breadcrumb')
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item" style="color: green">
                    <strong><span class="mr-3 d-md-inline " id="today"></span> <span id="time"></span></strong>
                </li>

            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ms-auto">

            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                @if(Auth::user()->imageprofile->image=='default_image.png' )
                    <img src="{!! asset( 'storage/image_profile/dummy-avatar-300x300'.'.jpg'. '?'. 'time='. time()) !!}"
                        class="user-image rounded-circle elevation-2">
                @else
                    <img src="{!! asset( 'storage/image_profile/'. Auth::user()->imageprofile->image. '?'. 'time='. time()) !!}"
                        class="user-image rounded-circle elevation-2" alt="User Image">
                @endif
                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <!--begin::User Image-->
                <li class="user-header" style="background-color: #d9d9d9;">
                  @if(Auth::user()->imageprofile->image=='default_image.png' )
                    <img src="{!! asset( 'storage/image_profile/dummy-avatar-300x300'.'.jpg'. '?'. 'time='. time()) !!}"
                        class="user-image rounded-circle elevation-2">
                @else
                    <img src="{!! asset( 'storage/image_profile/'. Auth::user()->imageprofile->image. '?'. 'time='. time()) !!}"
                        class="user-image rounded-circle elevation-2" alt="User Image">
                @endif
                <p>
                    {{ Auth::user()->name.' - '.Auth::user()->user_type->title }}
                    <small>Member
                        since {{ Carbon\Carbon::parse(Auth::user()->created_at)->format('d-M-Y') }}</small>
                </p>
                <li class="user-footer">
                    <a href="{{ url('myprofile') }}" class="btn btn-default btn-flat">Profile</a>
                    {{--                            <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-right">Sign out</a>--}}
                    <a class="btn btn-default btn-flat float-end" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                        style="display: none;">
                        @csrf
                    </form>
                </li>
                <!--end::Menu Footer-->
              </ul>
            </li>
            <!--end::User Menu Dropdown-->
          </ul>

        </div>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
@if(Auth::user()->user_type_id<=2)
    @include('layouts.sidebar')
@else
    @include('layouts.sidebar_sc')
@endif


    <main class="app-main" id="main" tabindex="-1">
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
        @yield('maincontent')
            </div>
            <!--end::Container-->
        </div>
    </main>
    <!-- /.content-wrapper -->

    <footer class="app-footer">
        <div class="float-right d-none d-sm-inline">
            <b>Powered By : </b><a href="https://www.hossainn.com" target="_blank">Hossainn</a>
        </div>
        <strong>Copyright &copy; 2020-<?php echo date('Y'); ?> <a href="#">{{ config('app.name', 'HOSSAINN') }} </a> .
        </strong> All rights
        reserved.
    </footer>

</div>
<!-- ./wrapper -->
<script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
      crossorigin="anonymous"
    ></script>

<!-- jQuery -->
<script src="{!! asset('alte4/plugins/jquery/jquery.min.js')!!}" type="text/javascript"></script>
<!-- Bootstrap 4 -->
<script src="{!! asset('alte4/plugins/bootstrap/js/bootstrap.bundle.min.js')!!}" type="text/javascript"></script>
{{--<script src="https://cdn.usebootstrap.com/bootstrap/4.1.1/js/bootstrap.min.js" type="text/javascript"></script>--}}
{{--<script src="https://cdn.usebootstrap.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js" type="text/javascript"></script>--}}
<!-- AdminLTE App -->
<script src="{!! asset('alte4/dist/js/adminlte.min.js')!!}" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->

<script type="text/javascript" src="{{ asset('supporting/toastr/toastr.min.js') }}"></script>


@stack('js')

@if (Session::has('flash_success'))
    <script>
        toastr.success('{{ Session::get('flash_success') }}', 'Success Alert', {timeOut: 7000, closeButton: true});
    </script>
@endif
@if (Session::has('flash_error'))
    <script>
        toastr.error('{{ Session::get('flash_error') }}', 'Error Alert', {timeOut: 19500, closeButton: true});
    </script>
@endif
@if (Session::has('error'))
    <script>
        toastr.error('{{ Session::get('error') }}', 'Error Alert', {timeOut: 19500, closeButton: true});
    </script>
@endif
@if (Session::has('flash_message'))
    <script>
        toastr.success('{{ Session::get('flash_message') }}', 'Success Alert', {timeOut: 7000, closeButton: true});
    </script>
@endif

<script>
    function setdate() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        today = dd + '-' + mm + '-' + yyyy;
        document.getElementById("today").innerHTML = today;
    }

    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var c = ((h > 12) ? 'PM' : 'AM');
        h = h % 12;
        if (h == 0) {
            h = 12;
        }
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('time').innerHTML =
            h + ":" + m + ":" + s + " " + c;
        var t = setTimeout(startTime, 1000);
    }
    function checkTime(i) {
        if (i < 10) {
            i = "0" + i
        }
        ;  // add zero in front of numbers < 10
        return i;
    }

</script>
<script>
    var siteURL = "{{url('')}}";
</script>

<script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>



</body>
</html>
