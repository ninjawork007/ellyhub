@extends('layouts.master')

@section('content')

 <!-- Slider Area Start-->	
		<section class="slider">
			<div class="container-fluid">		
			<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			  <ol class="carousel-indicators">
				<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
			  </ol>
			  <div class="carousel-inner">
			  	@php $active = 0; @endphp
			  	@foreach($slider_categories as $categories)
				  	@php
				  	if($categories->banner){
				  		$bg_img = $categories->banner;
				  	}
				  	else{
				  		 $bg_img = 'slider.jpg';		  	
				  	}
				  	@endphp
				<div class="carousel-item @if($active == 0) {{ 'active' }}  @endif" style="background-image:url('{{ url('/public/images/category_images'). '/' . $bg_img }}')">
					<div class="carousel-caption d-md-block">
						@php 												
						$str = $categories->title;
						if (strpos($str, '&') !== false) {
						    $strfinal = explode(" & ",$str);
						    $strtop =  $strfinal[0].' &';
						    $strbottom =  $strfinal[1];
						}else{
						    $strfinal = explode(" ",$str);
						    $strtop =  $strfinal[0];
						    unset($strfinal[0]);
						    $strbottom =  implode(' ',$strfinal);
						}								
						@endphp	
						<h3>@php echo $strtop; @endphp</h3>
						<h4>@php echo $strbottom; @endphp</h4>
						<p>{{ Str::substr($categories->description, 0, 100, '...') }}</p>
						<a href="{{ url('/'). '/categories/' .$categories->slug}}">View Products</a>
					</div>
				</div>
				@php $active++; @endphp
				@endforeach
			  </div>
			  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			  </a>
			  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			  </a>
			</div>
			</div>
		</section>
    <!-- Slider Area End-->	
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
	<section class="service">
		<div class="container">	
			<div class="row">
				<div id="owl-carousel4" class="owl-carousel owl-theme">
                      <?php echo  home_categories(); ?>         
                  	<div class="item">
                       <a href="#">
						<div class="service-img"><img src="{{ asset('public/assets/images/icon7.svg') }}" alt="service"></div>
						<div class="service-title">Calculators & Tools</div></a>
                    </div>
                </div>
			</div>
		</div>
	</section>
	
	
	   <!-- service Area End-->	
<!--	<section class="service">
		<div class="container">	
			<div class="row">	
				<ul class="list-inline d-flex justify-content-center">
					<li class="list-inline-item"><a href="#">
						<div class="service-img"><img src="{{ asset('public/assets/images/icon1.svg') }}" alt="service"></div>
						<div class="service-title">Sheet Materials</div></a>
					</li>
					<li class="list-inline-item"><a href="#">
						<div class="service-img"><img src="{{ asset('public/assets/images/icon2.svg') }}" alt="service"></div>
						<div class="service-title">Timber & Carcassing</div></a>
					</li>
					<li class="list-inline-item"><a href="#">
						<div class="service-img"><img src="{{ asset('public/assets/images/icon3.svg') }}" alt="service"></div>
						<div class="service-title">Landscaping & Fencing</div></a>
					</li>
					<li class="list-inline-item"><a href="#">
						<div class="service-img"><img src="{{ asset('public/assets/images/icon4.svg') }}" alt="service"></div>
						<div class="service-title">Doors & Windows</div></a>
					</li>
					<li class="list-inline-item"><a href="#">
						<div class="service-img"><img src="{{ asset('public/assets/images/icon5.png') }}" alt="service"></div>
						<div class="service-title">Garden & Waste Disposal</div></a>
					</li>
					<li class="list-inline-item"><a href="#">
						<div class="service-img"><img src="{{ asset('public/assets/images/icon6.svg') }}" alt="service"></div>
						<div class="service-img">Tools & Fixings</div></a>
					</li>
					<li class="list-inline-item"><a href="#">
						<div class="service-img"><img src="{{ asset('public/assets/images/icon7.svg') }}" alt="service"></div>
						<div class="service-img">Calculators & Tools</div></a>
					</li>
				</ul>
			</div>
		</div>
	</section>-->
	
	<section class="sub-service service-top">
		<div class="container">	
		<div class="heading d-flex justify-content-center">Sheet Materials </div>
				<div class="Sub-heading d-flex justify-content-center">
					<img src="{{ asset('public/assets/images/square.png') }}" />
					<a href="{{ url('/categories/sheet-materials')}}">View All Products</a></div>
            <div class="row">
			<div class="col-lg-3">
				<div class="single-service d-flex align-items-center">
                         <div class="service_text">
						 <img src="{{ asset('public/assets/images/service1.png') }}" alt="">
                              <h5 class="title">Sheet Materials</h5>
							<a class="service-btn" href="{{ url('/categories/sheet-materials')}}">View All Products</a>
                           </div>
                       </div>
				</div>
                <div class="col-lg-9">
                    <div class="service-in">
                        <div id="owl-carousel" class="owl-carousel owl-theme">
                        	@foreach($sheet_category_products as $products)
                            <div class="item">
                        	<a href="{{ url('product/'.$products->slug) }}">
                                <div class="img_wrp">
								 <img src="{{ url('/public/images/product_images/product_thumbnail'). '/' .$products->image}}" alt="{{ $products->title}}">
                                    <div class="img_text pt-5">
                                        <h5 class="title">{{ $products->title}}</h5>
										<div class="price">@if($products->type == 'variable')From @endif £{{$products->price}}<span class="vat">(ex. VAT)</span></div>
										@if($products->type == 'variable')
											<a class="cart-btn d-flex justify-content-center" href="{{ url('product/'.$products->slug) }}">Add To Cart</a>
										@else
											<a class="cart-btn d-flex justify-content-center" href="{{ url('add-to-cart/'.$products->id) }}">Add To Cart</a>
										@endif
										
                                    </div>
                                </div>
                        	</a>
                            </div>
							@endforeach
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</section>
	<section class="sub-service service1">
		<div class="container">	
		<div class="heading d-flex justify-content-center">Timber & Carcassing</div>
					<div class="Sub-heading d-flex justify-content-center">
					<img src="{{ asset('public/assets/images/square.png') }}" />
					<a href="{{ url('/categories/timber-carcassing')}}">View All Products</a></div>
            <div class="row">
			<div class="col-lg-3">
					<div class="single-service d-flex align-items-center">
                         <div class="service_text">
						 	<img src="{{ asset('public/assets/images/service2.png') }}" alt="">
                              <h5 class="title">Timber & Carcassing</h5>
							<a class="service-btn" href="{{ url('/categories/timber-carcassing')}}">View All Products</a>
                           </div>
                       </div>
				</div>
                <div class="col-lg-9">
                    <div class="service-in">
                        <div id="owl-carousel1" class="owl-carousel owl-theme">
                            @foreach($timber_category_products as $products)
                            <div class="item">
                            	<a href="{{ url('product/'.$products->slug) }}">
                                <div class="img_wrp">
								 <img src="{{ url('/public/images/product_images/product_thumbnail'). '/' .$products->image}}" alt="{{ $products->title}}">
                                    <div class="img_text pt-5">
                                        <h5 class="title">{{ $products->title}}</h5>
										<div class="price">@if($products->type == 'variable')From @endif £{{$products->price}}<span class="vat">(ex. VAT)</span></div>
										@if($products->type == 'variable')
											<a class="cart-btn d-flex justify-content-center" href="{{ url('product/'.$products->slug) }}">Add To Cart</a>
										@else
											<a class="cart-btn d-flex justify-content-center" href="{{ url('add-to-cart/'.$products->id) }}">Add To Cart</a>
										@endif
                                    </div>
                                </div>
                                </a>
                            </div>
							@endforeach
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</section>
		<section class="sub-service service2">
		<div class="container">	
		<div class="heading d-flex justify-content-center">Landscaping & Fencing</div>
					<div class="Sub-heading d-flex justify-content-center">
					<img src="{{ asset('public/assets/images/square.png') }}" />
					<a href="{{ url('/categories/landscaping-fencing')}}">View All Products</a></div>
            <div class="row">
			<div class="col-lg-3">
				<div class="single-service d-flex align-items-center">
                         <div class="service_text">
						 	<img src="{{ asset('public/assets/images/service3.png') }}" alt="">
                              <h5 class="title">Landscaping & Fencing</h5>
							<a class="service-btn" href="{{ url('/categories/landscaping-fencing')}}">View All Products</a>
                           </div>
                       </div>
				</div>
                <div class="col-lg-9">
                    <div class="service-in">
                        <div id="owl-carousel2" class="owl-carousel owl-theme">
                          @foreach($Landscaping_category_products as $products)
                            <div class="item">
                            	<a href="{{ url('product/'.$products->slug) }}">
                                <div class="img_wrp">
								 <img src="{{ url('/public/images/product_images/product_thumbnail'). '/' .$products->image}}" alt="{{ $products->title}}">
                                    <div class="img_text pt-5">
                                        <h5 class="title">{{ $products->title}}</h5>
										<div class="price">@if($products->type == 'variable')From @endif £{{$products->price}}<span class="vat">(ex. VAT)</span></div>
										@if($products->type == 'variable')
											<a class="cart-btn d-flex justify-content-center" href="{{ url('product/'.$products->slug) }}">Add To Cart</a>
										@else
											<a class="cart-btn d-flex justify-content-center" href="{{ url('add-to-cart/'.$products->id) }}">Add To Cart</a>
										@endif
                                    </div>
                                </div>
                            	</a>
                            </div>
							@endforeach
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</section>
		<section class="sub-service service3">
		<div class="container">	
		<div class="heading d-flex justify-content-center">Doors & Windows</div>
					<div class="Sub-heading d-flex justify-content-center">
					<img src="{{ asset('public/assets/images/square.png') }}" />
					<a href="{{ url('/categories/doors-windows')}}">View All Products</a></div>
            <div class="row">
			<div class="col-lg-3">
				<div class="single-service d-flex align-items-center">
                         <div class="service_text">
						 <img src="{{ asset('public/assets/images/service4.png') }}" alt="">
                              <h5 class="title">Doors & Windows</h5>
							<a class="service-btn" href="{{ url('/categories/doors-windows')}}">View All Products</a>
                           </div>
                       </div>
				</div>
                <div class="col-lg-9">
                    <div class="service-in">
                        <div id="owl-carousel3" class="owl-carousel owl-theme">
                            @foreach($Doors_category_products as $products)
                            <div class="item">
                            	<a href="{{ url('product/'.$products->slug) }}">
                                <div class="img_wrp">
								 <img src="{{ url('/public/images/product_images/product_thumbnail'). '/' .$products->image}}" alt="{{ $products->title}}">
                                    <div class="img_text pt-5">
                                        <h5 class="title">{{ $products->title}}</h5>
										<div class="price">@if($products->type == 'variable')From @endif £{{$products->price}}<span class="vat">(ex. VAT)</span></div>
										@if($products->type == 'variable')
											<a class="cart-btn d-flex justify-content-center" href="{{ url('product/'.$products->slug) }}">Add To Cart</a>
										@else
											<a class="cart-btn d-flex justify-content-center" href="{{ url('add-to-cart/'.$products->id) }}">Add To Cart</a>
										@endif
                                    </div>
                                </div>
                            	</a>
                            </div>
							@endforeach
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</section>
	
	<section class="delivery-sec">
		<div class="container">	
			<div class="row">
				<div class="col-lg-6 delivery1">
				<a href="{{ url('/delivery-information') }}">
					<img src="{{ asset('public/assets/images/delivery.png') }}" alt="" class="img-responsive" />
					<div class="carousel-caption">
						<h3>NEXT DAY<br> DELIVERY<br> AVAILABLE</h3>
					</div>
				</a>
				</div>
				<div class="col-lg-3 delivery2">
				<img src="{{ asset('public/assets/images/delivery1.png') }}" alt="" class="img-responsive" />
					<div class="carousel-caption">
						<h3>TOOLS & <br>CALCULATOR</h3>
						<a href="{{ url('/calculator') }}">Click Here<i class="fa fa-angle-right" aria-hidden="true"></i></a>
					</div>
				</div>
				<div class="col-lg-3 delivery3">
					<img src="{{ asset('public/assets/images/delivery2.png') }}" alt="" class="img-responsive" />
						<div class="carousel-caption">
							<h3>Support</h3>
							<a href="{{ url('/contact-us') }}">Contact Us<i class="fa fa-angle-right" aria-hidden="true"></i></a>
						</div>
					</div>
				</div>
		</div>
	</section>
	<section class="signup-sec" id="signup-sec">
		<div class="container">	
			<div class="row">
				<div class="col-lg-6">
				<h3><i class="fa fa-paper-plane-o" aria-hidden="true"></i>Sign up to NewsletteR AND BEST OFFERS </h3>
				</div>
				<div class="col-lg-6 single">
				<div class="input-group">
					 @include('common/newsletter')
				</div>
				</div>
			</div>
		</div>
	</section>
@endsection