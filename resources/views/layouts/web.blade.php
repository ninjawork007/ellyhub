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
   <meta name="description" content="@yield('pagetitle')">
   <meta name="title" content="@yield('pagetitle') " />
   <title>@yield('pagetitle')</title>
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
   <link rel="stylesheet" href="{{url('public/assets/web/css/style.css')}}" media="all" />
   <link rel="stylesheet" href="{{url('public/assets/web/css/amr-style.css')}}" media="all" />
   <link rel="stylesheet" href="{{url('public/assets/web/css/website-colors.css')}}" media="all" />
   <link rel="stylesheet" href="{{url('public/assets/web/css/dropzone.min.css')}}" media="all" />
   <script type="text/javascript" src="{{url('public/assets/web/js/jquery.min.js')}}"></script>
</head>
<body class="@yield('pagebodyclass')">
   <script type="text/javascript">
      $.ajax({
       url: "{{route('check_login')}}"
   });
</script>
<div class="siteurl" data-url="{{url('/')}}"></div>
<header class="header-area">
    <div class="top-bar d-none">
        <div class="col-full">
            <ul id="menu-top-bar-left" class="nav menu-top-bar-left">
                <li class="menu-item"><a href="javascript:;" data-toggle="modal" data-target="#pincode_verify"><i class="fa fa-map-marker"></i><span id="pincode_selected">Select your address</span></a></li>
            </ul>
            <ul id="menu-top-bar-right" class="nav menu-top-bar-right">
                <li class="hidden-sm-down menu-item">
                    <a title="Track Your Order" href="{{url('track')}}">
                        <i class="icon amr-order-tracking"></i>Track Your Order
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="header-main-area">
        <div class="header_main">           
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5 col-md-2 col-2">
                        <div class="main-menu-btn"><a href="javascript:;" ><i class="icon amr-departments-thin"></i><span>menu</span></a></div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-4">
                        <div class="logo site-branding">
                            <a href="{{url('/')}}" class="custom-logo-link" rel="home">
                                <img class="main-logo" src="{{url('public/'.$setting[0]->logo)}}" alt="">
                                <!-- <img class="sticky-logo"src="{{url('public/'.$setting[0]->logo)}}"> -->
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-7 col-6">
                        <ul class="nav header-customer-area justify-content-end">
                        @guest
                        <li class="menu-item become-vendor-link"><a title="My Account" href="{{url('vendor/register')}}">Become A Vendor</a></li>
                        <li class="menu-item my-profile-menu"><a title="My Account" href="{{url('user/login_register')}}"><span>Sign in </span><img src="{{url('public/assets/web/images/user-icon-dark.png')}}" alt="My Profile"></a></li>
                        <!-- <li class="menu-item"><a title="My Account" href="{{url('user/register')}}"><i class="icon amr-login-register"></i>User Register</a></li> -->
                        @else
                        <li class="dropdown">
                            <a class="open-location-popup" href="#" role="button">Locate me ?</a>
                            <div class="dropdown-menu px-3 pt-3 pb-2 main-popup">
                                <div class="location-popup">
                                    <h3 class="text-center font-bold">Location</h3>

                                    <h6 class="text-black">Distance</h6>
                                    <input type="hidden" name="distance" id="radiusAmount">
                                    <div class="wrap-slider">
                                        <div id="slider-custom" class="position-relative"></div>
                                    </div>

                                    <h6 class="text-black font-bold">ZIP Code</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="#" class="open-div text-black" data-close="location-popup" data-target="zip-popup">Brawley, CA 92227</a>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <a href="#" data-close="location-popup" data-target="zip-popup" class="open-div text-black justify-content-end"><h5><i class="fa fa-angle-right"></i></h5></a>
                                        </div>
                                    </div>

                                    <h6 class="text-black font-bold">Delivery Method</h6>
                                    <p>Shipping to continental 48 states, excluding Arkansas</p>
                                    <label class="form-control border-0"><input type="radio" name="shipping_type" class="" value="local_shipping"> Local + Shipping</label>
                                    <label class="form-control border-0"><input type="radio" name="shipping_type" class="" value="local"> Local</label>
                                    <label class="form-control border-0"><input type="radio" name="shipping_type" class="" value="shipping"> Shipping</label>

                                    <div class="pt-3">
                                        <button type="submit" class="btn btn-aqua form-control">See Listings</button>
                                    </div>
                                </div>
                                <div class="zip-popup" style="display:none">
                                    <div class="row justify-content-center">
                                        <div class="col-md-2">
                                            <a href="#" data-close="zip-popup" data-target="location-popup" class="open-div"><h5 class="text-black"><i class="fa fa-angle-left"></i></h5></a>
                                        </div>
                                        <div class="col-md-8 text-center">
                                            <h3>ZIP Code</h3>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="#" data-close="main-popup" class="open-div"><h5 class="text-black"><i class="fa fa-times font-normal"></i></h5></a>
                                        </div>

                                        <h6 class="text-center text-black">Where are you searching?</h6>
                                        <a href="#" class="btn btn-location"><i class="fa fa-map-marker"></i>&nbsp;Get my location</a>

                                        <p class="my-2 text-black font-bold text-center">Or</p>

                                        <div class="col-md-6 mx-auto">
                                            <input type="text" name="zip_code" value="" class="form-control" placeholder="Enter zip code">
                                        </div>

                                        <p class="mb-2 mt-1 text-black font-bold text-center">Brawley, CA</p>

                                        <div class="pt-5 mt-5">
                                            <button type="submit" class="btn btn-aqua form-control">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="icon-menu user-hover background-transparent"> <a href="{{route('user_account')}}" style="background-color: transparent;padding:10px;"><img src="http://localhost/ellyhub_personal/public/assets/web/images/user-icon-dark.png" alt="My Profile"></a>
                            <ul class="dropdown-list">
                                <li class="user-info">
                                    <div class="user-img">
                                        @if(Auth::user()->image)
                                        <img src="{{url('public/'.Auth::user()->image)}}" class="rounded">
                                        @else
                                        <img src="{{url('public/no-image.png')}}" class="rounded">
                                        @endif
                                    </div>
                                    <h3 class="user-name">{{Auth::user()->name}}</h3>
                                </li>
                                @if(Auth::user()->user_type=='customer')
                                <li><a href="{{route('user_account')}}"><i  class="icon amr-free-return"></i>Account Setting</a></li>
                                <li><a href="{{route('orders')}}"><i class="icon amr-listing"></i>Orders</a></li>
                                <li><a href="{{route('wishlist')}}"><i class="icon amr-favorites"></i>Wishlist</a></li> 
                                <li><a href="{{route('shipping_address')}}"><i class="icon amr-map-marker"></i>Shipping Address</a></li>
                                <!-- <li class="vendor-link"><a href="{{url('vendor/register')}}" class="btn">Become a Vendor</a></li> -->
                                @else
                                <li><a href="{{url('admin/dashboard')}}"><i class="icon amr-login-register"></i>Dasdboard</a></li>
                                @endif 
                                @if(Auth::user()->user_type=='customer')
                                <li class="logout-link"><a class="account-logout" href="{{url('logout')}}">Log out</a></li>
                                @else
                                <li class="logout-link"><a class="account-logout" href="{{url('admin/logout')}}">Log out</a></li>
                                @endif
                            </ul>
                        </li>
                        @endguest
                        <li class="icon-menu">
                            <a href="{{url('/wishlist')}}"> <img src="{{url('public/assets/web/images/heart-icon.png')}}" alt="My Wishlist">
                                <div class="notification" id="top-cart-wishlist-count">0</div>
                            </a>
                        </li>
                        <li class="icon-menu position-relative">
                            <a href="javascript:;" class="minicart-btn"> <img src="{{url('public/assets/web/images/cart-icon.png')}}" alt="My Cart">
                                <div class="notification count">0</div>
                            </a>
                            <div class="show-mini-cart-v2 p-3 border" style="right:30px;top:100%;z-index:999;position: absolute;display:none;background-color:#fff;height:300px;width:400px;overflow-y:scroll">

                            </div>
                        </li>
                    </ul>
                    </div>
                </div>
            </div>
            <nav class="navbar navbar-expand-lg header-search">
                <div class="container">
                    <a class="navbar-brand" href="#">&nbsp;</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                        <ul class="navbar-nav mb-2 mb-lg-0 justify-content-center text-center">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">HOME</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">MESSAGES</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('purchases')}}">PURCHASES</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">WATCHING</a>
                                <div class="dropdown-menu px-3 pt-1 pb-2">
                                    <a href="#" ><span>View your saved seller list</span> &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></a><br>
                                    <a href="{{url('wishlist')}}" class="font-normal"><span>View all items you are watching</span> &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></a>

                                    <div class="append-wishlist">
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">SELLER HUB</a>
                                <div class="dropdown-menu saller-hub-div" style="min-width:200px;">
                                    <div class="border-bottom ps-2"><a href="#" class="saller-hub-links" >Orders</a></div>
                                    <div class="border-bottom ps-2"><a href="#" class="saller-hub-links">Active Listings</a></div>
                                    <div class="border-bottom ps-2"><a href="#" class="saller-hub-links">Draft</a></div>
                                    <div class="border-bottom ps-2"><a href="#" class="saller-hub-links">Unsold</a></div>
                                    <div class="border-bottom ps-2"><a href="#" class="saller-hub-links">Feedback</a></div>
                                    <div class="ps-2"><a href="#" class="saller-hub-links">Assistance</a></div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">NOTIFICATIONS</a>
                                <div class="dropdown-menu notifications">
                                    <div class="append-notifications">
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">PAYMENTS</a>
                                <div class="dropdown-menu saller-hub-div ps-2" style="min-width:200px;">
                                    <div class="w-100"><a href="#" class="saller-hub-links" style="font-style: normal">Summary</a></div>
                                    <div class="w-100"><a href="#" class="saller-hub-links" style="font-style: normal">All transactions</a></div>
                                    <div class="w-100"><a href="#" class="saller-hub-links" style="font-style: normal">Payouts</a></div>
                                    <div class="w-100"><a href="{{url('reports-taxes')}}" class="saller-hub-links" style="font-style: normal">Taxes and Reports</a></div>
                                </div>
                            </li>
                            <!--<li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Dropdown
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </li>-->
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="header-search mt-0">
                <div class="container">
                    <div class="navbar-search">
                        <label class="search-input-label" for="search">
                            <img class="search-icon " src="{{url('public/assets/web/images/search-icon.png')}}">
                            <div class="search-text">What product can we help you find?</div>
                        </label>
                        <div class="search-popup">
                            <form method="get" action="{{route('find_product')}}">
                                <div class="input-group">
                                        <input type="text" id="search" class="form-control search-field product-search-field" dir="ltr" value="{{@$_GET['keyword']}}" name="keyword" autocomplete="off">
                                    <div class="d-flex align-items-center search-by">
                                        <label class="custom-checkbox"><input type="checkbox" value="new"> <span>New</span></label>
                                        <label class="custom-checkbox"><input type="checkbox" value="used"> <span>Used</span></label>
                                        <label class="custom-checkbox"><input type="checkbox" value="parts"> <span>Parts & Repair</span></label>
                                    </div>
                                    <div>
                                        <a href="javascript:;" class="search-close"><img class="search-icon " src="{{url('public/assets/web/images/close-icon.svg')}}"></a>
                                        <button type="submit" class="search-btn"><img class="search-icon " src="{{url('public/assets/web/images/search-icon-mian-color.svg')}}"></button>
                                    </div>
                                </div>
                            </form>
                            <div class="search-quick-links">
                                <h6><b>Quick Links</b></h6>
                                <ul>
                                    @if(count($all_main_categories))
                                    @foreach($all_main_categories as $key)
                                    <li><a href="{{url('category/')}}/{{preg_replace('/[^a-zA-Z0-9]+/','-', strtolower($key->name))}}-{{$key->id}}">{{ $key->name}}</a></li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav id="navbar-primary" class="navbar-primary desktop-only" aria-label="Navbar Primary" data-nav="flex-menu">
        <div class="container">
            <div id="menu-navbar-primary" class="row nav yamm d-flex">
                @if(count($top_cat))
                <?php
                $count = 1;
                ?>
                @foreach($top_cat as $key)
               
                <?php
                if ($count%4 == 1){  
                    echo "<div class='col-md-3'><div class='header-category'>";
                }
                echo '<a class="nav-link active" href="'.route('category_details',[$key->id]).'">'.$key->name.'</a>';
                if ($count%4 == 0){
                    echo "</div></div>";
                }
                
                $count++;
                ?>
                @endforeach
                <?php
                if ($count%4 != 1) echo "</div>";
                ?>
                @endif
                <?php
                ?>
                <a class="see-more-category" href="javascript:;">More</a>
            </div>

        </div>
    </nav>
    <div class="load-more-category">
      <a href="javascript:;" class="bounce load-arow"><i class="fa fa-solid fa-angle-down"></i></a>
    </div>
</header>
<aside class="off-canvas-wrapper">
    <div class="off-canvas-overlay"></div>
    <div class="off-canvas-inner-content">
        <div class="btn-close-off-canvas"> <i class="pe-7s-close"></i> </div>
        @guest
        <a class="mb-customer-profile-link" title="My Account" href="{{route('user_login')}}">
            <div class="mb-customer-profile">
                <img src="{{url('public/assets/web/images/user-icon.svg')}}" alt="My Profile">
                <span>Sign in </span>
            </div>
        </a>
        @else
        <a class="mb-customer-profile-link" title="My Account" href="{{route('user_account')}}">
            <div class="mb-customer-profile">
                <img src="{{url('public/assets/web/images/user-check-solid-white.svg')}}" alt="My Profile">
                <span>{{Auth::user()->name}}</span>
            </div>
        </a>
        @endguest
        <div class="off-canvas-inner">
            <div class="mobile-navigation">
                <ul class="mobile-menu mobile-menu-translateX">
                    <li><div class="heading">Shop By Category</div></li>
                    @if(count($all_main_categories))
                    @foreach($all_main_categories as $key)
                    <li class="mobile-menu-main-category-link">
                        <!-- <a href="{{route('category_details',[$key->id])}}">{{ $key->name}}</a> -->
                        <a data-category="Mcategory{{$key->id}}">{{ $key->name}}</a>
                    </li>
                    @endforeach
                    @endif
                    <li class="mb-menu-separator"></li>
                    <li><div class="heading">Help & Settings</div></li>
                    <li><a href="{{url('/blogs')}}">Blog</a> </li>
                    <li><a href="{{url('/pages/shipping')}}">shipping</a></li>
                    <li><a href="{{url('/pages/return-policy')}}">Return Policy</a></li>
                    <li><a href="{{url('/pages/about-us')}}">About Us</a></li>
                    <li><a href="{{url('/pages/terms-and-conditions')}}">Terms And Conditions</a></li>
                    <li><a href="{{url('/pages/privacy-policy')}}">Privacy Policy</a></li>
                    <li><a href="{{url('/vendor/register')}}">Become a Vendor</a></li>
                    <li><a href="{{url('/contact-us')}}">Contact Us</a></li>
                    <li><a href="{{url('/track')}}">Track Your Order</a></li>
                    <li class="mb-menu-separator"></li>
                    @guest
                    <li class="menu-item my-profile-menu"><a title="My Account" href="{{route('user_login')}}"><span>Sign in </span></a></li>
                    @else
                    @if(Auth::user()->user_type=='customer')
                    <li><a href="{{route('user_account')}}">Account Setting</a></li>
                    <li><a href="{{route('orders')}}">Orders</a></li>
                    <li><a href="{{route('wishlist')}}">My Wishlist</a></li> 
                    <li><a href="{{url('/cart')}}">My Cart</a></li>
                    <li><a href="{{route('shipping_address')}}">Shipping Address</a></li>
                    @else
                    <li><a href="{{url('admin/dashboard')}}">Dasdboard</a></li>
                    @endif
                    @if(Auth::user()->user_type=='customer')
                    <li><a class="account-logout" href="{{url('logout')}}">Log out</a></li>
                    @else
                    <li><a class="account-logout" href="{{url('admin/logout')}}">Log out</a></li>
                    @endif
                    @endguest
                </ul>
                @if(count($all_main_categories))
                @foreach($all_main_categories as $key)
                <div class="sub-categories-div mobile-menu-translateX-right" id="Mcategory{{$key->id}}">
                    <a class="back-menu-link"><img src="{{url('public/assets/web/images/back-arrow.svg')}}" alt=""> <span class="heading">Main Menu</span></a>
                    <ul>
                        <li class="sub-categories-div-heading">
                            <div class="heading">{{ App\Http\Controllers\CommonController::getCategoryName($key->id) }}</div>
                            <a href="{{url('category/')}}/{{preg_replace('/[^a-zA-Z0-9]+/','-', strtolower($key->name))}}-{{$key->id}}" class="cat-btn">See All</a>
                        </li>
                        @if(count($all_sub_categories))
                        @foreach($all_sub_categories as $key1)
                        @if($key1->category_id == $key->id)
                        <li class="mega-menu-sub-category-link" >
                            <a href="{{url('category/')}}/{{preg_replace('/[^a-zA-Z0-9]+/','-',strtolower($key->name))}}/{{preg_replace('/[^a-zA-Z0-9]+/','-',strtolower($key1->title))}}-{{ $key1->id}}">
                                {{ $key1->title}}
                            </a>
                            @if(count($all_child_categories))
                            <ul class="child-categories">
                                @foreach($all_child_categories as $key2)
                                @if($key1->id == $key2->sub_category_id)
                                <li class="mega-menu-child-category-link" data-childcategory="child_category_{{$key2->id}}">
                                    <a href="{{url('category/')}}/{{preg_replace('/[^a-zA-Z0-9]+/','-',strtolower($key->name))}}/{{preg_replace('/[^a-zA-Z0-9]+/','-',strtolower($key1->title))}}/{{preg_replace('/[^a-zA-Z0-9]+/','-',strtolower($key2->name))}}-{{ $key2->id}}">
                                        {{ $key2->name}}
                                    </a>
                                </li>
                                @endif
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endif
                        @endforeach
                        @endif
                    </ul>
                </div>
                @endforeach
                @endif 
            </div>
        </div>
    </div>
</aside>
<div class="site-mini-cart">
    <div class="site-mini-cart-header">
        <div class="d-inline-block main-cart-title">My Cart <span class="title-item-count"></span></div>
        <a class="close-mini-cart"><i class="amr-close"></i></a>
    </div>
    <div class="mini-cart-content">
        <ul class="list-cart"> </ul>
        <div class="mini-cart-bottom">
            <p class="mini-cart-total">
                <strong>Subtotal:</strong>
                <span class="total">{{$setting[0]->currency_sign}}</span>
            </p>
            <p class="mini-cart-buttons">
                <a href="{{route('cart')}}" class="button wc-forward">View cart</a>
                <a href="{{route('checkout')}}" class="button checkout wc-forward">Checkout</a>
            </p>
        </div>
    </div>
</div>
@yield('content')
<footer class="site-footer">
    <div class="col-full">
        <div class="before-footer-wrap">
            <div class="col-full">
                <div class="footer-newsletter">
                    <div class="media">
                        <i class="footer-newsletter-icon icon amr-newsletter"></i>
                        <div class="media-body">
                            <div class="clearfix">
                                <div class="newsletter-header">
                                    <h5 class="newsletter-title">Sign up to Newsletter</h5>
                                   
                                </div>
                                <div class="newsletter-body">
                                    <form class="newsletter-form">
                                        <input type="text" placeholder="Enter your email address">
                                        <button class="button" type="button">Sign up</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-social-icons">
                    <ul class="social-icons nav">
                        <li class="nav-item">
                            <a class="sm-icon-label-link nav-link" href="https://www.facebook.com/amrkart/" target="_blank">
                                <i class="fa fa-facebook"></i> Facebook
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="sm-icon-label-link nav-link" href="https://www.instagram.com/official_amrkart/" target="_blank">
                                <i class="fa fa-instagram"></i> Instagram
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="sm-icon-label-link nav-link" href="https://t.me/bazarhat" target="_blank">
                                <i class="fa fa-telegram"></i> Telegram
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="sm-icon-label-link nav-link" href="https://www.youtube.com/channel/UCW1bQJsjZQH1yllUiIiYCNg" target="_blank">
                                <i class="fa fa-youtube"></i> Youtube
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-widgets-block">
            <div class="row">
                <div class="col-md-4">
                    <div class="footer-contact">
                        <div class="footer-logo">
                                <img src="{{url('public/'.$setting[0]->footer_logo)}}">
                        </div>
                        <div class="contact-payment-wrap">
                            <div class="footer-contact-info">
                                <div class="media d-none">
                                    <span class="media-left icon media-middle">
                                        <i class="icon amr-call-us-footer"></i>
                                    </span>
                                    <div class="media-body">
                                        <span class="call-us-title">Got Questions ? Call us (10am to 5pm)</span>
                                        <span class="call-us-text">+91-7087-521988</span>
                                        <p> <b>Email us: <a href="mailto:hello@amrsoftec.com" class="">hello@amrsoftec.com</a></b></p>
                                        <address class="footer-contact-address"><b>Web Development Company AMR Softec.</b><br>
                                        D-151, Third Floor Phase 8, Industrial Area, Sahibzada Ajit Singh Nagar, Punjab 160055, India</address>
                                        <a href="https://www.google.com/maps/dir/30.7128009,76.7078951/amr+softec/@30.7181164,76.7020883,15z/data=!3m1!4b1!4m9!4m8!1m1!4e1!1m5!1m1!1s0x390fefc2f5429dc5:0xc66d53eca804612!2m2!1d76.7076877!2d30.7264178" target="_blank" class="footer-address-map-link">
                                            <i class="icon amr-map-marker"></i>Find us on map
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="footer-payment-info">
                                <div class="media">
                                    <span class="media-left icon media-middle">
                                        <i class="icon amr-safe-payments"></i>
                                    </span>
                                    <div class="media-body">
                                        <h5 class="footer-payment-info-title">We are using safe payments</h5>
                                        <div class="footer-payment-icons">
                                            <ul class="list-payment-icons nav">
                                                <li class="nav-item">
                                                    <img class="payment-icon-image" src="{{url('public/assets/web/images/mastercard.svg')}}" alt="mastercard" />
                                                </li>
                                                <li class="nav-item">
                                                    <img class="payment-icon-image" src="{{url('public/assets/web/images/visa.svg')}}" alt="visa" />
                                                </li>
                                                <li class="nav-item">
                                                    <img class="payment-icon-image" src="{{url('public/assets/web/images/paypal.svg')}}" alt="paypal" />
                                                </li>
                                                <li class="nav-item">
                                                    <img class="payment-icon-image" src="{{url('public/assets/web/images/maestro.svg')}}" alt="maestro" />
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="footer-secure-by-info">
                                            <h6 class="footer-secured-by-title">Secured by:</h6>
                                            <ul class="footer-secured-by-icons">
                                                <li class="nav-item">
                                                    <img class="secure-icons-image" src="{{url('public/assets/web/images/norton.svg')}}" alt="norton" />
                                                </li>
                                                <li class="nav-item">
                                                    <img class="secure-icons-image" src="{{url('public/assets/web/images/mcafee.svg')}}" alt="mcafee" />
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="footer-widgets">
                        <div class="columns">
                            <aside class="widget widget_nav_menu clearfix">
                                <div class="body">
                                    <h4 class="widget-title">Help & Info</h4>
                                    <?php $pages = App\Http\Controllers\CommonController::get_pages(); if($pages->count()){ ?>
                                        <div class="menu-footer-menu-1-container">
                                            <ul id="menu-footer-menu-1" class="menu">
                                                @foreach($pages as $key)
                                                <li class="menu-item"> <a href="{{url('pages/'.$key->link)}}">{{$key->type}}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    <?php } ?>
                                </div>
                            </aside>
                        </div>
                        <div class="columns">
                            <aside class="widget widget_nav_menu clearfix">
                                <div class="body">
                                    <h4 class="widget-title">&nbsp;</h4>
                                    <div class="menu-footer-menu-2-container">
                                        <ul id="menu-footer-menu-2" class="menu">
                                            <li class="menu-item">
                                                <a href="{{url('vendor/register')}}">Become a Vendor</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="{{url('contact-us')}}">Contact Us</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </aside>
                        </div>
                        <div class="columns">
                            <aside class="widget widget_nav_menu clearfix">
                                <div class="body">
                                    <h4 class="widget-title">Customer Care</h4>
                                    <div class="menu-footer-menu-3-container">
                                        <ul id="menu-footer-menu-3" class="menu">
                                            <li class="menu-item">
                                                <a href="{{route('user_login')}}">My Account</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="#">Track Order</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="{{route('wishlist')}}">Wishlist</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="faq.html">FAQs</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="site-info">
            <div class="col-full">
                <div class="copyright">Copyright &copy; 2021 <a href="{{url('/')}}">{{$setting[0]->site_title}}</a>. All rights reserved.</div>
                <div class="credit">Made with <a href="https://www.amrsoftec.com" target="_blank"><i class="fa fa-heart"></i> Web Development Company AMR Softec.</a></div>
            </div>
        </div>
    </div>
</footer>
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
<div class="modal fade" id="pincode_verify" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Address Verification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-inline" id="verify_address">
                    <div class="form-group mx-sm-3 mb-2">
                        <input type="text" class="form-control" id="pincode" placeholder="Enter your pincode" required="">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Verify</button>
                </form>
                <span class="text-danger" id="error_message"></span>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
 function add_wishlist(id, table) {
     event.preventDefault();
  $.ajax({
   url: '{{route("add_wishlist")}}',
   data: {
    id: id,
    table: table
},
cache: false,
success: function(response) {
    var ress = JSON.parse(response);
    if (ress.success) {
         @if(Route::currentRouteName() != 'product_details')
         alert("Added to wishlist.");
        window.location.reload();
         @endif
         $('.badge.bg-warning.wishlist').html(ress.count);
        if($('.change-icon').hasClass('fa-heart-o')){
            $('.change-icon').removeClass('fa-heart-o');
            $('.change-icon').addClass('fa-heart');
        }
        else{
            $('.change-icon').removeClass('fa-heart');
            $('.change-icon').addClass('fa-heart-o');
        }
        event.preventDefault();
    }
}
});
}
 function remove_watchlist(id) {

     if (confirm('Do you want to remove from wishlist?')) {

         $.ajax({

             url: '<?php echo e(url("/remove_from_wishlist")); ?>',

             data: {id: id},

             cache: false,

             success: function (res) {

                 if (res) {

                     window.location.reload();

                     // /$('#cartrow'+id+'').fadeOut(1200).css({'background-color':'#f2dede'});

                 }

             }

         });

     } else {
         event.preventDefault();
         return false;

     }
 }

$('#verify_address').submit(function(e){
 e.preventDefault();
 var pincode = $.trim($('#pincode').val());
 if (pincode=='') {
  alert("Please enter pincode.");
  return false;
}

$.ajax({
  url:"{{route('verify_pincode')}}",
  data:{pincode:pincode},
  cache:false,
  success:function(response){
   var ress = JSON.parse(response);
   if (ress.success) {
    $('#pincode_selected').html(pincode);
    $('#pincode_verify').modal('hide');
}else{
    $('#error_message').html(ress.message);
}
}
});
});

 $(function() {
     var valMap = [5, 10, 20, 30, 50];

     $("#slider-custom").slider({
         max: valMap.length - 1,
         slide: function(event, ui) {
             $("#radiusAmount").val(valMap[ui.value]);

             var opt = $(this).data().uiSlider.options;

             var vals = opt.max - opt.min;

             var arrayLength = valMap.length;

             var el = (ui.value / vals * 100);

             showVal(el);
         }
     })
     .each(function() {

         var opt = $(this).data().uiSlider.options;

         var vals = opt.max - opt.min;


         var arrayLength = valMap.length;
         for (var i = 0; i < arrayLength; i++) {
             if(i == 0){
                 var el = $('<label>' + (valMap[i]) + '</label>').css('left', (i / vals * 100) + '%');

                 $("#slider-custom").append(el);
             }
             else{
                 var el = $('<label>' + (valMap[i]) + '</label>').css('left', (i / vals * 100 - 5) + '%');
             }

             $("#slider-custom").append(el);

         }

     });
 });

 function showVal(newVal){
     $("#slider-custom").css('background', `linear-gradient(90deg, rgba(12,172,132,1) ${newVal}%, rgba(0,0,0,0.1) ${newVal}%)`);
     //document.getElementById("valBox").innerHTML=newVal;
 }
</script>

<script>var site_url = '{{url('/')}}';</script>
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
<script type="text/javascript" src="//unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- custom code-->
<script type="text/javascript" src="{{url('public/assets/web/js/scripts.js')}}"></script>
@if(Route::currentRouteName()!='product_details' && Route::currentRouteName()!='cart')
<script type="text/javascript" src="{{url('public/assets/web/js/dropzone.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/assets/web/js/custom-script.js')}}"></script>
<script type="text/javascript">
  jQuery(window).ready(function() {

   jQuery(".shop-by-category-menu").click(function() {
    jQuery('body').toggleClass("shop-by-category-menu-open");
    jQuery('.shop-by-category-menu').toggleClass("active");
});
   jQuery('.categories-mega-menus .sub-categories li:has(ul.child-categories li)').addClass('has-child');
   jQuery('.categories-mega-menus .mega-menus.main-categories ul li:first-child').addClass("active");
   jQuery(".categories-mega-menus .mega-menus.main-categories ul li").click(function() {
    jQuery('.categories-mega-menus .mega-menus.main-categories ul li').removeClass("active");
    jQuery(this).addClass("active");
    jQuery('.sub-categories .sub-categories-div').hide();
    var id = jQuery(this).attr('data-category');
    jQuery('#' + id).show();
});

});

</script>
@endif
<script type="text/javascript">
  $(document).ready(function() {
    $("a:contains('eBay Motors')").text('Motors');
  })
  //search
  jQuery("#search").keyup(function(){
    $('.search-quick-links').html('<p>Please wait...</p>');
    var searchIDs = [];
    searchIDs = $(".custom-checkbox input:checkbox:checked").map(function(){
      return $(this).val();
    }).get();
    var search = $(this).val();
    var len =  search.length;
    if(len != 0){
            $.ajax({
            url: "{{url('search')}}",
            data: {
                    search: search,
                    type:searchIDs
            },
            cache: false,
            success: function(response) {
             $('.search-quick-links').html(response);
             // console.log(response);
            }
         });
    } else{
        $('.search-quick-links').html('');
    }
  });
  jQuery(".custom-checkbox input").click(function(){
    var searchIDs = [];
    searchIDs = $(".custom-checkbox input:checkbox:checked").map(function(){
      return $(this).val();
    }).get();
    var search = jQuery("#search").val();
    var len =  search.length;
    if(len != 0){
            $.ajax({
            url: "{{url('search')}}",
            data: {
                    search: search,
                    type:searchIDs
            },
            cache: false,
            success: function(response) {
             $('.search-quick-links').html(response);
             // console.log(response);
            }
         });
    } else{
        $('.search-quick-links').html('');
    }
  });
$('#image').click(function() {
  $('#foo').addClass('myClass');
});

$('body').on('click','.bounce.load-arow',function () {
    $(this).hide();
    $('#navbar-primary').css('height','100%');
});
$('body').on('click','.see-more-category',function () {
    $('.off-canvas-wrapper').addClass('open');
});

  $('.open-location-popup').click(function(e){
      e.preventDefault();
      $(this).parent().find('.dropdown-menu').css('top', '50px').toggle();
  });

  $('.open-div').click(function(e){
      e.preventDefault();
      var target = $(this).data('target');
      var close = $(this).data('close');
      $('.'+target).fadeIn();
      $('.'+close).fadeOut();
  });

  $(document).ready(function(){
      $.ajax({
          url: site_url+"/get_notifications_ajax",
          cache: false,
          success: function(response) {
              var ress = jQuery.parseJSON(response);
              if (ress.success) {
                  $('.append-notifications').html(ress.html);
              } else {
                  //console.log(response);
              }
          }
      });
  });

/*get_wishlist();

function get_wishlist() {
  $.ajax({
      url: site_url+"/get_wishlist_ajax",
      cache: false,
      success: function(response) {
          var ress = jQuery.parseJSON(response);
          console.log(ress);
          if (ress.success) {
              $('#top-cart-wishlist-count').html(ress.count);
              $('.append-wishlist').html(ress.html);
          } else {
              //console.log(response);
          }
      }
  });

}*/

</script>
</body>
</html>