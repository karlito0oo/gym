<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Robust admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, robust admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('template/robust/app-assets/images/ico/apple-icon-60.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('template/robust/app-assets/images/ico/apple-icon-76.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('template/robust/app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('template/robust/app-assets/images/ico/apple-icon-152.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('template/Images/logo.ico') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('template/robust/app-assets/css/bootstrap.css') }}">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="{{ asset('template/robust/app-assets/fonts/icomoon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template/robust/app-assets/fonts/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template/robust/app-assets/vendors/css/extensions/pace.css') }}">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('template/robust/app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template/robust/app-assets/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template/robust/app-assets/css/colors.css') }}">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('template/robust/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template/robust/app-assets/css/core/menu/menu-types/vertical-overlay-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template/robust/app-assets/css/core/colors/palette-gradient.css') }}">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('template/robust/assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
    <!-- END Custom CSS-->
    <style>
        .floatingBtn{
            position:fixed;
            width:60px;
            height:60px;
            bottom:40px;
            right:40px;
            background-color:#0C9;
            color:#FFF;
            border-radius:50px;
            text-align:center;
            box-shadow: 2px 2px 3px #999;
        }

        .MyFloatingBtn{
            margin-top:22px;
        }
    </style>
  </head>
  <body data-open="click" data-menu="vertical-menu" data-col="2-columns" class="vertical-layout vertical-menu 2-columns  fixed-navbar">
    <div id="app">
        <!-- navbar-fixed-top-->
        <nav class="header-navbar navbar navbar-with-menu navbar-fixed-top navbar-semi-dark navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-header">
            <ul class="nav navbar-nav">
                <li class="nav-item mobile-menu hidden-md-up float-xs-left"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5 font-large-1"></i></a></li>
                <li class="nav-item"><a href="{{ url('/home') }}" class="navbar-brand nav-link">
                    <center><span style="color:white; font-weight:bold;">SOUTH FITNESS GYM</span></center>
                </a></li>
                <li class="nav-item hidden-md-up float-xs-right"><a data-toggle="collapse" data-target="#navbar-mobile" class="nav-link open-navbar-container"><i class="icon-ellipsis pe-2x icon-icon-rotate-right-right"></i></a></li>
            </ul>
            </div>
            <div class="navbar-container content container-fluid">
            <div id="navbar-mobile" class="collapse navbar-toggleable-sm">
                <ul class="nav navbar-nav">
                <li class="nav-item hidden-sm-down"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5">         </i></a></li>
                </ul>
                <ul class="nav navbar-nav float-xs-right">
                
                <!-- <li class="dropdown dropdown-notification nav-item"><a href="#" data-toggle="dropdown" class="nav-link nav-link-label"><i class="ficon icon-bell4"></i><span class="tag tag-pill tag-default tag-danger tag-default tag-up">5</span></a>
                    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                    <li class="dropdown-menu-header">
                        <h6 class="dropdown-header m-0"><span class="grey darken-2">Notifications</span><span class="notification-tag tag tag-default tag-danger float-xs-right m-0">5 New</span></h6>
                    </li>
                    <li class="list-group scrollable-container"><a href="javascript:void(0)" class="list-group-item">
                        <div class="media">
                            <div class="media-left valign-middle"><i class="icon-cart3 icon-bg-circle bg-cyan"></i></div>
                            <div class="media-body">
                            <h6 class="media-heading">You have new order!</h6>
                            <p class="notification-text font-small-3 text-muted">Lorem ipsum dolor sit amet, consectetuer elit.</p><small>
                                <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">30 minutes ago</time></small>
                            </div>
                        </div></a><a href="javascript:void(0)" class="list-group-item">
                        <div class="media">
                            <div class="media-left valign-middle"><i class="icon-monitor3 icon-bg-circle bg-red bg-darken-1"></i></div>
                            <div class="media-body">
                            <h6 class="media-heading red darken-1">99% Server load</h6>
                            <p class="notification-text font-small-3 text-muted">Aliquam tincidunt mauris eu risus.</p><small>
                                <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Five hour ago</time></small>
                            </div>
                        </div></a><a href="javascript:void(0)" class="list-group-item">
                        <div class="media">
                            <div class="media-left valign-middle"><i class="icon-server2 icon-bg-circle bg-yellow bg-darken-3"></i></div>
                            <div class="media-body">
                            <h6 class="media-heading yellow darken-3">Warning notifixation</h6>
                            <p class="notification-text font-small-3 text-muted">Vestibulum auctor dapibus neque.</p><small>
                                <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Today</time></small>
                            </div>
                        </div></a><a href="javascript:void(0)" class="list-group-item">
                        <div class="media">
                            <div class="media-left valign-middle"><i class="icon-check2 icon-bg-circle bg-green bg-accent-3"></i></div>
                            <div class="media-body">
                            <h6 class="media-heading">Complete the task</h6><small>
                                <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Last week</time></small>
                            </div>
                        </div></a><a href="javascript:void(0)" class="list-group-item">
                        <div class="media">
                            <div class="media-left valign-middle"><i class="icon-bar-graph-2 icon-bg-circle bg-teal"></i></div>
                            <div class="media-body">
                            <h6 class="media-heading">Generate monthly report</h6><small>
                                <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Last month</time></small>
                            </div>
                        </div></a></li>
                    <li class="dropdown-menu-footer"><a href="javascript:void(0)" class="dropdown-item text-muted text-xs-center">Read all notifications</a></li>
                    </ul>
                </li>
                <li class="dropdown dropdown-notification nav-item"><a href="#" data-toggle="dropdown" class="nav-link nav-link-label"><i class="ficon icon-mail6"></i><span class="tag tag-pill tag-default tag-info tag-default tag-up">8</span></a>
                    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                    <li class="dropdown-menu-header">
                        <h6 class="dropdown-header m-0"><span class="grey darken-2">Messages</span><span class="notification-tag tag tag-default tag-info float-xs-right m-0">4 New</span></h6>
                    </li>
                    <li class="list-group scrollable-container"><a href="javascript:void(0)" class="list-group-item">
                        <div class="media">
                            <div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="{{ asset('template/robust/app-assets/images/portrait/small/avatar-s-1.png') }}" alt="avatar"><i></i></span></div>
                            <div class="media-body">
                            <h6 class="media-heading">Margaret Govan</h6>
                            <p class="notification-text font-small-3 text-muted">I like your portfolio, let's start the project.</p><small>
                                <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Today</time></small>
                            </div>
                        </div></a><a href="javascript:void(0)" class="list-group-item">
                        <div class="media">
                            <div class="media-left"><span class="avatar avatar-sm avatar-busy rounded-circle"><img src="{{ asset('template/robust/app-assets/images/portrait/small/avatar-s-2.png') }}" alt="avatar"><i></i></span></div>
                            <div class="media-body">
                            <h6 class="media-heading">Bret Lezama</h6>
                            <p class="notification-text font-small-3 text-muted">I have seen your work, there is</p><small>
                                <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Tuesday</time></small>
                            </div>
                        </div></a><a href="javascript:void(0)" class="list-group-item">
                        <div class="media">
                            <div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="{{ asset('template/robust/app-assets/images/portrait/small/avatar-s-3.png') }}" alt="avatar"><i></i></span></div>
                            <div class="media-body">
                            <h6 class="media-heading">Carie Berra</h6>
                            <p class="notification-text font-small-3 text-muted">Can we have call in this week ?</p><small>
                                <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Friday</time></small>
                            </div>
                        </div></a><a href="javascript:void(0)" class="list-group-item">
                        <div class="media">
                            <div class="media-left"><span class="avatar avatar-sm avatar-away rounded-circle"><img src="{{ asset('template/robust/app-assets/images/portrait/small/avatar-s-6.png') }}" alt="avatar"><i></i></span></div>
                            <div class="media-body">
                            <h6 class="media-heading">Eric Alsobrook</h6>
                            <p class="notification-text font-small-3 text-muted">We have project party this saturday night.</p><small>
                                <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">last month</time></small>
                            </div>
                        </div></a></li>
                    <li class="dropdown-menu-footer"><a href="javascript:void(0)" class="dropdown-item text-muted text-xs-center">Read all messages</a></li>
                    </ul>
                </li> -->
                <li class="dropdown dropdown-user nav-item"><a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link"><span class="avatar avatar-online"><img src="{{ (Auth::user() && Auth::user()->profilePicture ? asset('/images/studentImage/' . Auth::user()->profilePicture) : asset('/images/defaultuser.png'))  }}" alt="avatar"><i></i></span><span class="user-name">{{ Auth::user()->name . ' ' . Auth::user()->lname }}</span></a>
                    <div class="dropdown-menu dropdown-menu-right"><a href="{{ url('/home/user/settings') }}" class="dropdown-item"><i class="icon-head"></i> Edit Profile</a>
                    <div class="dropdown-divider"></div><a  href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="dropdown-item"><i class="icon-power3"></i> Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                    </div>
                </li>
                </ul>
            </div>
            </div>
        </div>
        </nav>

        <!-- ////////////////////////////////////////////////////////////////////////////-->


        <!-- main menu-->
        <div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
        <!-- main menu header-->
        <div class="main-menu-header">
            <input type="text" placeholder="Search" class="menu-search form-control round"/>
        </div>
        <!-- / main menu header-->
        <!-- main menu content-->
        <div class="main-menu-content">
            <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
            
            
            <li class="nav-item {{ collect(request()->segments())->last() == 'home' ? 'active' : ''}}"><a href="{{ url('/home') }}"><i class="icon-home"></i><span data-i18n="nav.form_layouts.form_layout_basic" class="menu-title">{{ (Auth::user() && Auth::user()->role->name == 'admin') ? "Dashboard" : "Home" }}</span></a>
            <li class="nav-item {{ collect(request()->segments())->last() == 'food-supplements' ? 'active' : ''}}"><a href="{{ url('/home/food-supplements') }}"><i class="icon-heartbeat"></i><span data-i18n="nav.form_layouts.form_layout_basic" class="menu-title">Food Supplements</span></a>
            <li class="nav-item {{ collect(request()->segments())->last() == 'equipments' ? 'active' : ''}}"><a href="{{ url('/home/equipments') }}"><i class="icon-bicycle"></i><span data-i18n="nav.form_layouts.form_layout_basic" class="menu-title">Equipments</span></a>
            @if(Auth::user() && Auth::user()->role->name == 'member')
            <li class="nav-item {{ collect(request()->segments())->last() == 'attendances' ? 'active' : ''}}"><a href="{{ url('/home/attendances') }}"><i class="icon-clock-o"></i><span data-i18n="nav.form_layouts.form_layout_basic" class="menu-title">Attendances</span></a>
            @endif
            <li class="nav-item {{ collect(request()->segments())->last() == 'schedules' ? 'active' : ''}}"><a href="{{ url('/home/schedules') }}"><i class="icon-ios-calendar"></i><span data-i18n="nav.form_layouts.form_layout_basic" class="menu-title">Schedules</span></a>
            @if(Auth::user() && Auth::user()->role->name == 'admin')
            <li class="nav-item {{ collect(request()->segments())->last() == 'members' ? 'active' : ''}}"><a href="{{ url('/home/members') }}"><i class="icon-ios-people"></i><span data-i18n="nav.form_layouts.form_layout_basic" class="menu-title">Users</span></a>
            @endif
            </ul>
        </div>
        <!-- /main menu content-->
        <!-- main menu footer-->
        <!-- include includes/menu-footer-->
        <!-- main menu footer-->
        </div>
        <!-- / main menu-->

        <div class="app-content content container-fluid">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body"><!-- stats -->

            @yield('content')

            </div>
        </div>
        </div>
        <!-- ////////////////////////////////////////////////////////////////////////////-->

        <bmi-component></bmi-component>

        <footer class="footer footer-static footer-light navbar-border customFooter">
        (C) 2021 SOUTH FITNESS GYM
        </footer>
    </div>
        <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
        <script src="{{ asset('js/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/app.js') }}"></script>
    <!-- BEGIN VENDOR JS-->
    <script src="{{ asset('template/robust/app-assets/js/scripts/tooltip/tooltip.js') }}" type="text/javascript"></script>
        <script src="{{ asset('template/robust/app-assets/js/core/libraries/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('template/robust/app-assets/vendors/js/ui/tether.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('template/robust/app-assets/js/core/libraries/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('template/robust/app-assets/vendors/js/ui/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('template/robust/app-assets/vendors/js/ui/unison.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('template/robust/app-assets/vendors/js/ui/blockUI.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('template/robust/app-assets/vendors/js/ui/jquery.matchHeight-min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('template/robust/app-assets/vendors/js/ui/screenfull.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('template/robust/app-assets/vendors/js/extensions/pace.min.js') }}" type="text/javascript"></script>
        <!-- BEGIN VENDOR JS-->
        <!-- BEGIN PAGE VENDOR JS-->
        <script src="{{ asset('template/robust/app-assets/vendors/js/charts/chart.min.js') }}" type="text/javascript"></script>
        <!-- END PAGE VENDOR JS-->
        <!-- BEGIN ROBUST JS-->
        <script src="{{ asset('template/robust/app-assets/js/core/app-menu.js') }}" type="text/javascript"></script>
        <script src="{{ asset('template/robust/app-assets/js/core/app.js') }}" type="text/javascript"></script>
        <!-- END ROBUST JS-->
        <!-- BEGIN PAGE LEVEL JS-->
        <script src="{{ asset('template/robust/app-assets/js/scripts/pages/dashboard-lite.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL JS-->

        <script src="{{ asset('template/robust/app-assets/js/scripts/charts/chartjs/line/line.js') }}" type="text/javascript"></script>
  </body>
</html>
