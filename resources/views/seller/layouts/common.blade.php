<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="apple-touch-icon.png" rel="apple-touch-icon">
    <!-- <link href="" rel="icon"> -->
    <meta name="author" content="">
    @if(View::hasSection('pagetitle'))
        <meta name="description" content="{{$current_name}}">
        <meta name="title" content="{{$current_name}}" />
        <title>{{$current_name}}</title>
    @else
        <title>{{$setting[0]->site_title}}</title>
    @endif

    <link rel="apple-touch-icon" sizes="57x57" href="{{url('public/'.$setting[0]->icon)}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{url('public/'.$setting[0]->icon)}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{url('public/'.$setting[0]->icon)}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('public/'.$setting[0]->icon)}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{url('public/'.$setting[0]->icon)}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{url('public/'.$setting[0]->icon)}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{url('public/'.$setting[0]->icon)}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{url('public/'.$setting[0]->icon)}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{url('public/'.$setting[0]->icon)}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{url('public/'.$setting[0]->icon)}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{url('public/'.$setting[0]->icon)}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{url('public/'.$setting[0]->icon)}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('public/'.$setting[0]->icon)}}">
    <link rel="manifest" href="{{url('public/assets/web/images/favicon/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100;200,300,400,500,600,700,900">
    <link rel="stylesheet" href="{{url('public/assets/web/bootstrap/css/bootstrap.min.css')}}" media="all" />
    <link rel="stylesheet" href="{{url('public/assets/web/font-awesome/css/font-awesome.css')}}" media="all" />
    <link rel="stylesheet" href="{{url('public/assets/web/bootstrap/css/bootstrap-grid.min.css')}}" media="all" />
    <link rel="stylesheet" href="{{url('public/assets/web/bootstrap/css/bootstrap-reboot.min.css')}}" media="all" />
    <link rel="stylesheet" href="{{url('public/assets/web/fancybox/jquery.fancybox.min.css')}}" media="all" />
    <link rel="stylesheet" href="{{url('public/assets/web/amricons/css/amricons.css')}}" media="all" />
    <link rel="stylesheet" href="{{url('public/assets/web/pe-icon/css/pe-icon-7-stroke.css')}}" media="all" />
    <link rel="stylesheet" href="{{url('public/assets/web/slick/slick.css')}}" media="all" />
    <!-- <link rel="stylesheet" href="{{url('public/assets/web/slick/slick-theme.css')}}" media="all" /> -->
    <link rel="stylesheet" href="{{url('public/assets/web/slick/slick-style.css')}}" media="all" />
    <link rel="stylesheet" href="{{url('public/assets/web/css/animate.min.css')}}" media="all" />
    <link rel="stylesheet" href="{{url('public/assets/parsley/parsley.css')}}" />
    <link rel="stylesheet" href="{{url('public/assets/adminn/vendors/datatables/dataTables.bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{url('public/assets/web/css/style.css')}}" media="all" />
    <link rel="stylesheet" href="{{url('public/assets/web/css/amr-style.css')}}" media="all" />
    <link rel="stylesheet" href="{{url('public/assets/web/css/seller.css')}}" media="all" />
</head>
<body class="@yield('pagebodyclass')" style="background-color:#F4F4F8">
<div class="siteurl" data-url="{{url('/')}}"></div>
<div class="container-fluid mt-3">
    <header class="header-area" style="border-radius: 10px;">
        <div class="header-main-area">
            <div class="header_main py-3">
                <div class="row align-items-center px-3">
                    <div class="col-lg-5 col-md-2 col-2">
                        <h3 class="fst-italic mb-0 text-silver">{{$current_name}}</h3>
                    </div>
                    <div class="col-lg-2 col-md-3 col-4">
                        <div class="logo site-branding">
                            <a href="{{url('/')}}" class="custom-logo-link" rel="home">
                                <img class="main-logo" src="{{url('public/'.$setting[0]->logo)}}" alt="">
                                <!-- <img class="sticky-logo"src="{{url('public/'.$setting[0]->logo)}}"> -->
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-7 col-6 text-end">
                        <a href="#" class="open-menu text-silver">{{(empty(Auth::user()->name) ? Auth::user()->first_name : Auth::user()->name)}}
                            @php
                            $profile_image = (!empty(Auth::user()->image)) ? Auth::user()->image : 'no-image.png';
                            @endphp
                            <i class="fa fa-caret-down"></i>
                        </a>
                        <span class="profile-image">
                            <img src="{{url('public/'.$profile_image)}}">
                        </span>

                        <div class="show-menu-div position-absolute" style="display: none;right:0;width:20%;">
                            <div style="background-color: #fff;padding:20px;border-radius: 20px;">
                                <div class="row align-items-center">
                                    <div class="col-md-5 text-start ps-0">
                                        <span class="profile-image w-50">
                                            <img src="{{url('public/'.$profile_image)}}">
                                        </span>
                                    </div>
                                    <div class="col-md-7">
                                        <p class="mb-0 text-black">{{(empty(Auth::user()->name) ? Auth::user()->first_name : Auth::user()->name)}}</p>
                                        <p class="mb-0 text-silver text-decoration-underline">{{(empty(Auth::user()->name) ? Auth::user()->first_name : Auth::user()->name)}}</p>
                                    </div>
                                </div>

                                <div class="mt-4 text-start">
                                    <ul>
                                        <li class="mb-2"><a href="#" class="text-black">Account settings</a></li>
                                        <li><a href="#" class="text-black">Sign out</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="nav-bar-custom mt-4">
        <ul class="text-uppercase border-bottom d-flex">
            <li class="{{(Request::is('seller/dashboard')) ? 'active' : ''}}"><a href="{{url('/seller/dashboard')}}">overview</a></li>
            <li class="{{(Request::is('seller/orders') || Request::is('seller/orders/*')) ? 'active' : ''}}"><a href="{{url('/seller/orders')}}">orders</a></li>
            <li class="{{(Request::is('seller/listings')) ? 'active' : ''}}"><a href="{{url('/seller/listings')}}">listings</a></li>
            <li class="{{(Request::is('seller/messages')) ? 'active' : ''}}"><a href="{{url('/seller/messages')}}">messages</a></li>
            <li class="{{(Request::is('seller/purchase_history')) ? 'active' : ''}}"><a href="{{url('/seller/purchase_history')}}">purchase history</a></li>
            <li class="{{(Request::is('seller/watching')) ? 'active' : ''}}"><a href="{{url('/seller/watching')}}">watching</a></li>
            <li class="{{(Request::is('seller/recently_viewed')) ? 'active' : ''}}"><a href="{{url('/seller/recently_viewed')}}">recently viewed</a></li>
            <li class="{{(Request::is('seller/noifications')) ? 'active' : ''}}"><a href="{{url('/seller/noifications')}}">noifications</a></li>
        </ul>
    </div>
</div>
@yield('content')

<script>var site_url = '{{url('/')}}';</script>
<script type="text/javascript" src="{{url('public/assets/web/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/assets/web/bootstrap/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/assets/web/bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/assets/web/js/jquery-migrate.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/assets/web/js/hidemaxlistitem.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/assets/web/js/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/assets/web/js/hidemaxlistitem.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/assets/web/js/jquery.easing.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/assets/web/fancybox/jquery.fancybox.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/assets/web/js/scrollup.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/assets/web/js/jquery.waypoints.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/assets/web/js/waypoints-sticky.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/assets/web/js/pace.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/assets/web/slick/slick.min.js')}}"></script>
<script src="{{url('public/assets/parsley/parsley.js')}}"></script>
<script src="{{url('public/assets/adminn/vendors/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{url('public/assets/adminn/vendors/datatables/dataTables.bootstrap.min.js')}}"></script>
<script type="text/javascript" src="//unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- custom code-->
<script type="text/javascript" src="{{url('public/assets/web/js/scripts.js')}}"></script>
<script>
    $('.open-menu').on('hover', function(){
        $('.show-menu-div').fadeIn();
    });

    $('.show-menu-div').mouseleave(function(){
        $('.show-menu-div').fadeOut();
    });
</script>
@yield('scripts');
</body>
</html>