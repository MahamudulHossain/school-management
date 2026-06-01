<!doctype html>
<html lang="en-gb" class="no-js">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>SMS|Website</title>
    <meta name="description" content="">
    <link rel="stylesheet" href="{!! asset('website/css/bootstrap.min.css')!!}" />
    <link rel="stylesheet" type="text/css" href="{!! asset('website/css/isotope.css')!!}" media="screen" />
    <link rel="stylesheet" href="{!! asset('website/js/fancybox/jquery.fancybox.css')!!}" type="text/css" media="screen" />
    <link href="{!! asset('website/css/animate.css')!!}" rel="stylesheet" media="screen">
    <!-- Owl Carousel Assets -->
    <link href="{!! asset('website/js/owl-carousel/owl.carousel.css')!!}" rel="stylesheet">
    <link rel="stylesheet" href="{!! asset('website/css/styles.css')!!}" />
    <!-- Font Awesome -->
    <link href="{!! asset('website/font/css/font-awesome.min.css')!!}" rel="stylesheet">
    {{--Event Calendar--}}
    <script src="{!! asset('alte4/plugins/moment/moment.min.js')!!}" type="text/javascript"></script>
    <script src="{!! asset('alte4/plugins/jquery/jquery-3.3.1.min.js')!!}"></script>
    <script src="{!! asset('alte4/plugins/jquery/jquery-migrate-1.4.1.min.js')!!}"></script>
    <style>
        .nav-tabs {
            border-bottom: 1px solid #e5e5e5;
        }
        #myTab .nav-link {
            border-radius: 3px 3px 0px 0px;
        }
        .news-section .nav-tabs .nav-link.active {
            border: 1px solid #035abc;
        }
        .news-section .nav-link.active {
            background: #035abc;
            color: #ffffff;
        }
        .news-section .nav-tabs .nav-link {
            font-size: 16px;
            font-weight: 500;
            padding: 8px 18px;
            border-radius: 0;
        }
        .news-section .nav-tabs .nav-link {
            font-size: 16px;
            font-weight: 500;
            padding: 8px 18px;
            border-radius: 0;
        }
        .nav-link {
            display: block;
            padding: .5rem 1rem;
        }
        a {
            /* color: #333; */
            color: #025bbc;
            transition: color 0.2s;
        }
    </style>
</head>

<body>
<header class="header">
    <div class="container">
        <nav class="navbar navbar-inverse" role="navigation">
            <div class="navbar-header">
                <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <br/>

            <h3 style="color: lightyellow; ">মডেল পাইলট উচ্চ বিদ্যালয় ও কলেজ</h3><br/>
                <span style="color: lightyellow; ">ইআইআইএন-১২৫৩৭৬, কোড-২৬০১৩</span></div>
            <!--/.navbar-header-->
            <div id="main-nav" class="collapse navbar-collapse">
                <ul class="nav navbar-nav" id="mainNav">
                    <li class="active" id="firstLink"><a href="#home" class="scroll-link">Home</a></li>
                    <li><a href="#aboutUs" class="scroll-link">About Us</a></li>
                    <li><a href="#work" class="scroll-link">Gallery</a></li>
                    <li><a href="#team" class="scroll-link">Management</a></li>
                    <li><a href="#notice" class="scroll-link">Notice</a></li>
                    <li><a href="#event" class="scroll-link">Events</a></li>
                    <li><a href="#contactUs" class="scroll-link">Contact Us</a></li>
                    <li>
                        @if (Auth::guest())
                            <a href="{{ url('/login') }}">Software Login</a>
                        @elseif(in_array(Auth::user()->user_type_id,[1,2,3,4,5]) )
                            <a href="{{ url('/home') }}">Software Dashboard</a>
                        @endif
                    </li>
                </ul>
            </div>
            <!--/.navbar-collapse-->
        </nav>
        <!--/.navbar-->
    </div>
    <!--/.container-->
</header>
<!--/.header-->


<div id="#top"></div>
<section id="home">
    <div class="banner-container">
        <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach($carousels as $key=>$carousel)
                <li data-target="#carousel" data-slide-to="{{ $key }}" class="{{ $key==0 ? 'active' : '' }}"></li>
                @endforeach
            </ol>
            <!-- Carousel items -->
            <div class="carousel-inner">
                @foreach($carousels as $key=>$carousel)
                <div class="item {{ $key==0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/front/carousel/'.$carousel->image) }}" alt="Banner 1" />
                </div>
                @endforeach
            </div>
            <!-- Carousel nav -->
            <a class="carousel-control left" href="#carousel" data-slide="prev">&lsaquo;</a>
            <a class="carousel-control right" href="#carousel" data-slide="next">&rsaquo;</a>
        </div>

    </div>

    <div class="container hero-text2">
        <div class="col-md-9">
            <h2>Why our School?</h2>
            <p>Students have been receiving high quality educational programming at our school for over 100 years.  We have a highlight diverse population of learners from across the World, and all over our great province.</p>
        </div>
        <div class="col-md-3">
            <a class="btn btn-apply" href="javascript:void(0)"><i class="fa fa-play-circle"></i>Apply Now</a>
        </div>
    </div>
</section>

<section id="aboutUs">
    <div class="container">
        <div class="heading text-center">
            <h2>About Us</h2>
        </div>
        <div class="row feature design">
            <div class="area1 columns left">
                <h3>Welcome to the School of Education</h3>
                <p>{!! $aboutUs->description !!}</p>
            </div>

            <div class="area2 columns feature-media right"> <img src="{!! asset( 'storage/front/images/about-img.jpg') !!}" alt="" width="100%"> </div>
        </div>
        <div class="row dataTxt">
            <div class="col-md-4 col-sm-6">
                <h3>Our Mission</h3>
                <p>{!! $aboutUs->mission !!}</p>

                <br>
            </div>

            <div class="col-md-4 col-sm-6">

                <h3>Our Vision
                </h3>
                <p>{!! $aboutUs->vision !!}</p>
            </div>

            <div class="col-md-4 col-sm-6">
                <h3>Goal</h3>
                <p>{!! $aboutUs->goal !!}</p>
            </div>

        </div>
    </div>
</section>
<section id="work" class="page-section page">
    <div class="container text-center">
        <div class="heading">
            <h2>Gallery</h2>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="portfolio">
                    <ul class="filters list-inline">
                        <li> <a class="active" data-filter="*" href="#">All</a> </li>
                        @foreach ($portfolio_tags as $portfolio_tag)
                            <li> <a data-filter=".{{ $portfolio_tag->tag }}" href="#">{{ $portfolio_tag->title }}</a> </li>
                        @endforeach
                    </ul>
                    <ul class="items list-unstyled clearfix animated fadeInRight showing" data-animation="fadeInRight" style="position: relative; height: 438px;">
                        @foreach ($portfolios as $portfolio)
                            <li class="item {{ $portfolio->tag->tag }}" style="position: absolute; left: 0px; top: 0px;">

                                <figure class="effect-bubba">
                                    <img src="{!! asset( 'storage/front/portfolio/'.$portfolio->image) !!}" alt="img02"/>
                                    <figcaption>
                                        <h2>{{ $portfolio->tag->title }}</h2>
                                        <a href="{!! asset( 'storage/front/portfolio/'.$portfolio->image) !!}" class="fancybox">View more</a>
                                    </figcaption>
                                </figure>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="team" class="page-section">
    <div class="container">
        <div class="heading text-center">
            <h2>Teachers</h2>
        </div>
        <!-- Team Member's Details -->
        <div class="team-content">
            <div class="row">
                @foreach($users as $key=>$user)
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <!-- Team Member -->
                    <div class="team-member pDark">
                        <!-- Image Hover Block -->
                        <div class="member-img">
                            <!-- Image  -->
                            @if($user->imageprofile->image=='default_image.png' && $user->profile->gender=='Male')
                                <img src="{!! asset( 'storage/images/avatar_male'.'.jpg'. '?'. 'time='. time()) !!}"
                                    class="profile-user-img img-fluid img-circle">
                            @elseif($user->imageprofile->image=='default_image.png' && $user->profile->gender=='Female')
                                <img
                                        src="{!! asset( 'storage/images/avatar_female'.'.jpg'. '?'. 'time='. time()) !!}"
                                        class="profile-user-img img-fluid img-circle">
                            @elseif($user->imageprofile->image=='default_image.png' && Auth::user()->profile->gender==null)
                                <img src="{!! asset('storage/images/avatar_male.jpg')!!}"
                                    class="profile-user-img img-fluid img-circle" alt="User Image">
                            @elseif ($user->imageprofile->image=='default_image.png')
                                <img src="{!! asset( 'storage/images/avatar_male'.'.jpg'. '?'. 'time='. time()) !!}"
                                    class="profile-user-img img-fluid img-circle">
                            @else
                                <img
                                        src="{!! asset( 'storage/image_profile/'. $user->imageprofile->image. '?'. 'time='. time()) !!}"
                                        class="profile-user-img img-fluid img-circle" alt="User Image">
                            @endif

                        </div>
                        <!-- Member Details -->
                        <div class="team-title">
                            <h4>{{$user->teacher->first_name.' '.$user->teacher->middle_name.' '.$user->teacher->last_name}}</h4>
                            <!-- Designation -->
                            <span class="pos">{{$user->teacher->designation}}</span>
                        </div>
                        <div class="team-socials"> <a href="#"><i class="fa fa-facebook"></i></a> <a href="#"><i class="fa fa-google-plus"></i></a> <a href="#"><i class="fa fa-twitter"></i></a> <a href="#"><i class="fa fa-dribbble"></i></a> <a href="#"><i class="fa fa-github"></i></a> </div>
                    </div>
                </div>
                    @endforeach
            </div>
        </div>
    </div>
    <!--/.container-->
</section>
<section id="notice" class="page-section news-section">
    <div class="container">
        <div class="heading text-center">
            <!-- Heading -->
            <h2>Notice Board</h2>
        </div>
        <div class="row dataTxt">
            <div class="col-md-12 col-sm-8">
                <div class="card card-outline card-primary">
                    <div class="card-body card-body-scroll p-0">
                        <div class="table-responsive">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link  active " id="Notices-tab" data-toggle="tab" href="#Notices" role="tab" aria-controls="Notices" aria-selected="false"><i class="fa fa-book"></i> Notices</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " id="Office Order-tab" data-toggle="tab" href="#Office Order" role="tab" aria-controls="Office Order" aria-selected="false"><i class="fa fa-book"></i> Office Order</a>
                                </li>
                            </ul>
                            <table class="table table-striped table-bordered">

                                <tbody>
                                    @foreach($notice as $stu)
                                        <tr>
                                            <td style="padding: 15px">
                                                <a href="{{ asset('storage/pdf/' . $stu->details) }}" title="Details View" style="text-decoration: none">
                                                    {{ $stu->title }}
                                                </a><br>
                                                <i class="fa fa-clock-o" aria-hidden="true"></i> {{ \Carbon\Carbon::parse($stu->created_at)->format('M d, Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="event" class="page-section">
    <div class="container">
        <div class="heading text-center">
            <!-- Heading -->
            <h2>Events and Holiday</h2>
        </div>
        <div class="row dataTxt">
            <div class="col-md-8 col-sm-12">
                <div class="portlet light calendar bordered">
                    <div class="card-body" id="calendar-body">
                        {{-- Calendar --}}
                        <div id="calendar"></div>
                    </div>
                </div>
                <br>
            </div>

            <div class="col-md-4 col-sm-6">

                <h3>Up Coming Holiday of {{date('Y')}}</h3>
                <ul  class="list3">
                    @foreach($holiday as $hday)
                        <li>{{$hday->title.' : '.\Carbon\Carbon::parse($hday->start_date)->format('d-M-Y').' to '.\Carbon\Carbon::parse($hday->end_date)->format('d-M-Y')}}</li>
                    @endforeach
                </ul>
                <h3>Recent Holiday of {{date('Y')}}</h3>
                <ul  class="list3">
                    @foreach($recent_holiday as $hday)
                        <li>{{$hday->title.' : '.\Carbon\Carbon::parse($hday->start_date)->format('d-M-Y').' to '.\Carbon\Carbon::parse($hday->end_date)->format('d-M-Y')}}</li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</section>
<section id="contactUs" class="contact-parlex">
    <div class="parlex-back">
        <div class="container">
            <div class="heading text-center">
                <h2>Contact Us</h2>
            </div>
            {{--</div>--}}
            <div class="row mrgn30">
                <form name="sentMessage" id="contactForm"  novalidate>
                    {{--<h3>Contact Form</h3>--}}
                    <div class="control-group">
                        <div class="controls">
                            <input type="text" class="form-control"
                                   placeholder="Full Name" id="name" required
                                   data-validation-required-message="Please enter your name" />
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <input type="email" class="form-control" placeholder="Email"
                                   id="email" required
                                   data-validation-required-message="Please enter your email" />
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
		<textarea rows="10" cols="100" class="form-control"
                  placeholder="Message" id="message" required
                  data-validation-required-message="Please enter your message" minlength="5"
                  data-validation-minlength-message="Min 5 characters"
                  maxlength="999" style="resize:none"></textarea>
                        </div>
                    </div>
                    <div id="success"> </div> <!-- For success/fail messages -->
                    <button type="submit" class="btn btn-primary pull-right">Send</button><br />
                </form>
            </div>
        </div>
        <!--/.container-->
    </div>
</section>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="col">
                    <h4>Contact us</h4>
                    <ul>
                        <li>House#360, Bornomala School Road</li>
                        <li>Dakshinkhan, Dhaka-1230</li>
                        <li>Email: <a href="mailto:info@eidyict.com" title="Email Us">info@eidyict.com</a></li>
                        <li>Web Site: <a href="http://www.eidyict.com" target="_blank">www.eidyict.com</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-3">
                <div class="col">
                    <h4>Mailing list</h4>
                    <p>Lorem ipsum dolor sit amet, ea eum labitur scsstie percipitoleat.</p>
                    <form class="form-inline">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Your email address...">
                            <span class="input-group-btn">
                                <button class="btn" type="button">Go!</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-3">
                <div class="col col-social-icons">
                    <h4>Follow us</h4>
                    <a href="https://www.facebook.com/Chatmohar.govRCNandBSN.pilothigh.school/?ref=page_internal"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-youtube-play"></i></a>
                    <a href="#"><i class="fa fa-linkedin"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="col">
                    <h4>Latest News</h4>
                    <p>
                        Lorem ipsum dolor labitur scsstie per sit amet, ea eum labitur scsstie percipitoleat.
                        <br><br>
                        <a href="#" class="btn">Get Mores!</a>
                    </p>
                </div>
            </div>
        </div>

    </div>

</footer>
<!--/.page-section-->
<section class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center"> Copyright 2022 | All Rights Reserved: মডেল পাইলট উচ্চ বিদ্যালয় ও কলেজ | Powered by: <a href="http://www.eidyict.com"> Eidy ICT Solutions Ltd.</a> </div>
        </div>
        <!-- / .row -->
    </div>
</section>
<a href="#top" class="topHome"><i class="fa fa-chevron-up fa-2x"></i></a>

<script src="{!! asset('website/js/modernizr-latest.js')!!}"></script>
<script src="{!! asset('website/js/bootstrap.min.js')!!}" type="text/javascript"></script>
<script src="{!! asset('website/js/jquery.isotope.min.js')!!}" type="text/javascript"></script>
<script src="{!! asset('website/js/fancybox/jquery.fancybox.pack.js')!!}" type="text/javascript"></script>
<script src="{!! asset('website/js/jquery.nav.js')!!}" type="text/javascript"></script>
<script src="{!! asset('website/js/jquery.fittext.js')!!}"></script>
<script src="{!! asset('website/js/waypoints.js')!!}"></script>
<script src="{!! asset('website/contact/jqBootstrapValidation.js')!!}"></script>
<script src="{!! asset('website/contact/contact_me.js')!!}"></script>
<script src="{!! asset('website/js/custom.js')!!}" type="text/javascript"></script>
<script src="{!! asset('website/js/owl-carousel/owl.carousel.js')!!}"></script>

<script src="{{ asset('alte4/dist/js/full_calendar.min.js') }}"></script>

    <script>
        var siteURL = "{{url('')}}";
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: siteURL + '/get-events',
        eventColor: '#28a745',
        eventTextColor: '#fff',
        });
        calendar.render();
    });
    </script>

</body>
</html>
