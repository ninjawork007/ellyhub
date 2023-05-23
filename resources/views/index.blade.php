@extends('layouts.web') @section('content')
<!--banner start-->
<style type="text/css">
    .image-grid-item {
        margin-bottom: 30px;
    }
    
    .recipe-item img {
        max-height: 175px;
    }
    
    a#accountDropdown {
        margin-left: 15px;
    }
    
    .item a img {
        max-height: 190px;
        min-height: 190px;
        object-fit: cover;
    }
    
    .resto-img img {
        max-width: 57px;
        min-width: 57px;
        border-radius: 7px;
    }
    
    @media only screen and (max-width: 770px) {
        .resto-img img {
            max-width: 100%;
            min-width: 100%;
            border-radius: 7px;
        }
    }
</style>
<!--banner start-->
<section class="block-preview">
    <div class="cover-banner" style="background-image: url({{url('public/assets/images/beauty1.jpg')}})"></div>
    
    
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-6 col-sm-12 text-center">
                <div class="left-text-b center"> 
                    <h2 class="title">Get Inspired</h2>
                    <h2 class="title">Find Beauty Advisors</h2>
                    <button class="search-btn btn-link" type="button" onclick="window.location.href='signup'">Signup with email</button>
                </div>
            </div>
            </div>
    </div>
    </div>
</section>
<!--banner end-->
<!--how-to-work start-->
<section class="how-to-work custom-form">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <form class="col-md-12 form-box  col-sm-12 ">
                    
                    <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fas fa-map-marker-alt"></i></div>
                    </div>
                    <input class="find-address skills" name="search" type="text" placeholder="Choose your location" />
                    
                    
                    <div class="input-group-prepend">
                        <div class="input-group-text-1"><i class="fas fa-caret-down"></i></div>
                    </div>
                    
				  <input class="find-resto skills" name="search" type="text" placeholder="Select Category" />
                    <button class="search-btn btn-link" type="button">Search </button> </form>
            </div>
        </div>
    </div>
</section>
<!--how-to-work end-->
<!--discover-new-restaurants-&-book-now start-->
<section class="new-restaurants-book-now">
    <div class="container">
        <Div class="row">
            <div class="col-md-12">
                <div class="new-heading">
                    <h2> Discover new, inspiring looks </h2>
                    <p>Browse Photos from our community</p>
                    <p class="exeption">Find your own beauty consultant easily and quickly and book your appointment</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="new-resto">
                    <div class="large-12 columns">
                        <div class="owl-carousel dis-owl owl-theme">
                            <div class="item">
                                <a href="#"><img src="{{url('public/assets/looks/hairs.jpg')}}" alt="Hair">Hair</a>
                            </div>
                            <div class="item">
                                <a href="#"><img src="{{url('public/assets/looks/men.jpg')}}" alt="">Men</a>
                            </div>
                            <div class="item">
                                <a href="#"><img src="{{url('public/assets/looks/plastic.jpg')}}" alt="">Plastic Surgery</a>
                            </div>
                            <div class="item">
                                <a href="#"><img src="{{url('public/assets/looks/skin.jpg')}}" alt="">Skin</a>
                            </div>
                            <div class="item">
                                <a href="#"><img src="{{url('public/assets/looks/spa.jpg')}}" alt="">Spa</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--discover-new-restaurants-&-book-now end-->
<!--order-food-online-in-your-area start-->
<section class="order-food-online mb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="new-heading">
                    <h1> Trending Photos </h1> </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                <div class="all-meal">
                    <div class="top">
                        <a href="{{url('my-profile')}}">
                            <div class="bg-gradient"></div>
                        </a>
                        <div class="top-img"> <img src="{{url('public/assets/profiles/profiles1.jpg')}}" alt=""> </div>
                        <div class="logo-img"> <img src="{{url('public/assets/images/homepage/meals/logo-1.jpg')}}" alt=""> </div>
                        <div class="top-text">
                            <div class="heading">
                                <h4><a href="#">Bonn Burgur</a></h4></div>
                            <div class="sub-heading">
                                <h5><a href="#">Rooster</a></h5>
                                <p>77.7K</p>
                            </div>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="bottom-text">
                            <div class="delivery"><i class="fas fa-map"></i>New york</div>
                            <div class="star"> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <span>4.5</span>
                                <div class="comments"><a href="#"><i class="fas fa-comment-alt"></i>05</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                <div class="all-meal">
                    <div class="top">
                        <a href="{{url('my-profile')}}">
                            <div class="bg-gradient"></div>
                        </a>
                        <div class="top-img"> <img src="{{url('public/assets/profiles/profiles2.jpg')}}" alt=""> </div>
                        <div class="logo-img"> <img src="{{url('public/assets/images/homepage/meals/logo-1.jpg')}}" alt=""> </div>
                        <div class="top-text">
                            <div class="heading">
                                <h4><a href="meal_detail.html">Bonn Burgur</a></h4></div>
                            <div class="sub-heading">
                                <h5><a href="#">Rooster</a></h5>
                                <p>122.7K</p>
                            </div>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="bottom-text">
                            <div class="delivery"><i class="fas fa-map"></i>California</div>
                            <div class="star"> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <span>4.5</span>
                                <div class="comments"><a href="#"><i class="fas fa-comment-alt"></i>05</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                <div class="all-meal">
                    <div class="top">
                        <a href="{{url('my-profile')}}">
                            <div class="bg-gradient"></div>
                        </a>
                        <div class="top-img"> <img src="{{url('public/assets/profiles/profiles3.jpg')}}" alt=""> </div>
                        <div class="logo-img"> <img src="{{url('public/assets/images/homepage/meals/logo-1.jpg')}}" alt=""> </div>
                        <div class="top-text">
                            <div class="heading">
                                <h4><a href="meal_detail.html">Bonn Burgur</a></h4></div>
                            <div class="sub-heading">
                                <h5><a href="#">Rooster</a></h5>
                                <p>323K</p>
                            </div>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="bottom-text">
                            <div class="delivery"><i class="fas fa-map"></i>Washigton Dc</div>
                            <div class="star"> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <span>4.5</span>
                                <div class="comments"><a href="#"><i class="fas fa-comment-alt"></i>05</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                <div class="all-meal">
                    <div class="top">
                        <a href="{{url('my-profile')}}">
                            <div class="bg-gradient"></div>
                        </a>
                        <div class="top-img"> <img src="{{url('public/assets/profiles/profiles4.jpg')}}" alt=""> </div>
                        <div class="logo-img"> <img src="{{url('public/assets/images/homepage/meals/logo-1.jpg')}}" alt=""> </div>
                        <div class="top-text">
                            <div class="heading">
                                <h4><a href="meal_detail.html">Bonn Burgur</a></h4></div>
                            <div class="sub-heading">
                                <h5><a href="#">Rooster</a></h5>
                                <p>12K</p>
                            </div>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="bottom-text">
                            <div class="delivery"><i class="fas fa-map"></i>New york</div>
                            <div class="star"> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <span>4.5</span>
                                <div class="comments"><a href="#"><i class="fas fa-comment-alt"></i>05</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                <div class="all-meal">
                    <div class="top">
                        <a href="{{url('my-profile')}}">
                            <div class="bg-gradient"></div>
                        </a>
                        <div class="top-img"> <img src="{{url('public/assets/profiles/profiles1.jpg')}}" alt=""> </div>
                        <div class="logo-img"> <img src="{{url('public/assets/images/homepage/meals/logo-1.jpg')}}" alt=""> </div>
                        <div class="top-text">
                            <div class="heading">
                                <h4><a href="#">Bonn Burgur</a></h4></div>
                            <div class="sub-heading">
                                <h5><a href="#">Rooster</a></h5>
                                <p>77.7K</p>
                            </div>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="bottom-text">
                            <div class="delivery"><i class="fas fa-map"></i>New york</div>
                            <div class="star"> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <span>4.5</span>
                                <div class="comments"><a href="#"><i class="fas fa-comment-alt"></i>05</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                <div class="all-meal">
                    <div class="top">
                        <a href="{{url('my-profile')}}">
                            <div class="bg-gradient"></div>
                        </a>
                        <div class="top-img"> <img src="{{url('public/assets/profiles/profiles2.jpg')}}" alt=""> </div>
                        <div class="logo-img"> <img src="{{url('public/assets/images/homepage/meals/logo-1.jpg')}}" alt=""> </div>
                        <div class="top-text">
                            <div class="heading">
                                <h4><a href="meal_detail.html">Bonn Burgur</a></h4></div>
                            <div class="sub-heading">
                                <h5><a href="#">Rooster</a></h5>
                                <p>122.7K</p>
                            </div>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="bottom-text">
                            <div class="delivery"><i class="fas fa-map"></i>California</div>
                            <div class="star"> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <span>4.5</span>
                                <div class="comments"><a href="#"><i class="fas fa-comment-alt"></i>05</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                <div class="all-meal">
                    <div class="top">
                        <a href="{{url('my-profile')}}">
                            <div class="bg-gradient"></div>
                        </a>
                        <div class="top-img"> <img src="{{url('public/assets/profiles/profiles3.jpg')}}" alt=""> </div>
                        <div class="logo-img"> <img src="{{url('public/assets/images/homepage/meals/logo-1.jpg')}}" alt=""> </div>
                        <div class="top-text">
                            <div class="heading">
                                <h4><a href="meal_detail.html">Bonn Burgur</a></h4></div>
                            <div class="sub-heading">
                                <h5><a href="#">Rooster</a></h5>
                                <p>323K</p>
                            </div>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="bottom-text">
                            <div class="delivery"><i class="fas fa-map"></i>Washigton Dc</div>
                            <div class="star"> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <span>4.5</span>
                                <div class="comments"><a href="#"><i class="fas fa-comment-alt"></i>05</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                <div class="all-meal">
                    <div class="top">
                        <a href="{{url('my-profile')}}">
                            <div class="bg-gradient"></div>
                        </a>
                        <div class="top-img"> <img src="{{url('public/assets/profiles/profiles4.jpg')}}" alt=""> </div>
                        <div class="logo-img"> <img src="{{url('public/assets/images/homepage/meals/logo-1.jpg')}}" alt=""> </div>
                        <div class="top-text">
                            <div class="heading">
                                <h4><a href="meal_detail.html">Bonn Burgur</a></h4></div>
                            <div class="sub-heading">
                                <h5><a href="#">Rooster</a></h5>
                                <p>12K</p>
                            </div>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="bottom-text">
                            <div class="delivery"><i class="fas fa-map"></i>New york</div>
                            <div class="star"> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <span>4.5</span>
                                <div class="comments"><a href="#"><i class="fas fa-comment-alt"></i>05</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 meal-btn"> <a href="#" class="m-btn btn-link">Show All</a> </div>
        </div>
</section>
<!--order-food-online-in-your-area end-->
<!--featured-restaurants start-->
<!--<section class="featured-restaurants mb-5">-->
<!--	<div class="container">				-->
<!--		<div class="row">									-->
<!--			<div class="col-lg-12">-->
<!--				<div class="new-heading">-->
<!--				    <style>-->
<!--                    h1 {text-align: center;}-->
<!--                        </style>-->
<!--				<c>	<h1> Featured Beauty Advisors </h1></c> -->
<!--				</div>-->
<!--				<div class ="bg-resto">-->
<!--					<div class="resto-item">	-->
<!--						<div class="row">	-->
<!--							<div class="col-md-4 col-sm-12">-->
<!--								<div class="resto-img">-->
<!--									<img src="{{url('public/assets/profiles/profiles4.jpg')}}" alt="">-->
<!--									<div class="resto-name">-->
<!--										<h4><a href="#"> ANN Gor. </a></h4>-->
<!--									</div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<div class="col-md-4 col-sm-12">															-->
<!--								<div class="resto-location">-->
<!--									<span><i class="fas fa-map-marker-alt"></i></span>New York City,1569  -->
<!--								</div>						-->
<!--							</div>	-->
<!--							<div class="col-md-4 col-sm-12">															-->
<!--								<div class="menu-btn">-->
<!--									<a class="mn-btn btn-link" href="#"> View Detail</a>  -->
<!--								</div>						-->
<!--							</div>-->
<!--						</div>						-->
<!--					</div>-->
<!--					<div class="resto-item">	-->
<!--						<div class="row">	-->
<!--							<div class="col-md-4 col-sm-12">-->
<!--								<div class="resto-img">-->
<!--									<img src="{{url('public/assets/profiles/profiles1.jpg')}}" alt="">-->
<!--									<div class="resto-name">-->
<!--										<h4><a href="#"> Omar Borkan</a></h4>-->
<!--									</div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<div class="col-md-4 col-sm-12">															-->
<!--								<div class="resto-location">-->
<!--									<span><i class="fas fa-map-marker-alt"></i></span>New York City,1569  -->
<!--								</div>						-->
<!--							</div>	-->
<!--							<div class="col-md-4 col-sm-12">															-->
<!--								<div class="menu-btn">-->
<!--									<a class="mn-btn btn-link" href="#"> View Detail</a>  -->
<!--								</div>						-->
<!--							</div>-->
<!--						</div>						-->
<!--					</div>-->
<!--					<div class="resto-item">	-->
<!--						<div class="row">	-->
<!--							<div class="col-md-4 col-sm-12">-->
<!--								<div class="resto-img">-->
<!--									<img src="{{url('public/assets/profiles/profiles4.jpg')}}" alt="">-->
<!--									<div class="resto-name">-->
<!--										<h4><a href="#"> ANN Gor. </a></h4>-->
<!--									</div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<div class="col-md-4 col-sm-12">															-->
<!--								<div class="resto-location">-->
<!--									<span><i class="fas fa-map-marker-alt"></i></span>New York City,1569  -->
<!--								</div>						-->
<!--							</div>	-->
<!--							<div class="col-md-4 col-sm-12">															-->
<!--								<div class="menu-btn">-->
<!--									<a class="mn-btn btn-link" href="#"> View Detail</a>  -->
<!--								</div>						-->
<!--							</div>-->
<!--						</div>						-->
<!--					</div>-->
<!--					<div class="resto-item">	-->
<!--						<div class="row">	-->
<!--							<div class="col-md-4 col-sm-12">-->
<!--								<div class="resto-img">-->
<!--									<img src="{{url('public/assets/profiles/profiles1.jpg')}}" alt="">-->
<!--									<div class="resto-name">-->
<!--										<h4><a href="#"> Omar Borkan</a></h4>-->
<!--									</div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<div class="col-md-4 col-sm-12">															-->
<!--								<div class="resto-location">-->
<!--									<span><i class="fas fa-map-marker-alt"></i></span>New York City,1569  -->
<!--								</div>						-->
<!--							</div>	-->
<!--							<div class="col-md-4 col-sm-12">															-->
<!--								<div class="menu-btn">-->
<!--									<a class="mn-btn btn-link" href="#"> View Detail</a>  -->
<!--								</div>						-->
<!--							</div>-->
<!--						</div>						-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>	-->
<!--	</div>-->
<!--</section>-->
<!--featured restaurants end-->@endsection