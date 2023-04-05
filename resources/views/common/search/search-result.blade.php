@extends('layouts/master')
@section('content')
 <!-- Slider Area Start-->	
  <!-- breadcumb Start-->
		<div class="breadcumb-area text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="list-inline">
                               <li class="list-inline-item"><a href="{{url('/')}}">Home</a> <span>/</span></li>
                                @for($i = 0; $i <= count(Request::segments()); $i++)
                                <li class="list-inline-item">
                                  <a href="">{{Request::segment($i)}}</a>
                                  @if($i < count(Request::segments()) & $i > 0)
                                    {!!'<i class="fa fa-angle-right"></i>'!!}
                                  @endif
                                  </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
  <!-- breadcumb End-->

  <!-- Ctaegory area Start-->
	<div class="shop_area">
        <div class="container">
           
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif	
             <div class="row">		
			<div class="col-lg-3 order-lg-1 order-2">
                                <!-- Sidebar Start -->
                                <aside class="sidebar shop-sidebar">
                                    <div class="search-filter">

                                        <!-- Category Search filter Start -->
                                        <div class="filter-box">
                                            <div class="filter-title">
                                                <h2>Product categories</h2>
                                            </div>
                                            <ul class="search-filter-list list-unstyled">
                                                <li class="custom-checkbox">
                                                    <input type="checkbox" name="bookandboardgame" id="cat" class="sadia-checkbox">
                                                    <label for="cat" class="sadia-checkbox-label">Sheet Materials</label>
                                                </li>
                                                <li class="custom-checkbox">
                                                    <input type="checkbox" name="babydols" id="1" class="sadia-checkbox">
                                                    <label for="1" class="sadia-checkbox-label">Timber & Carcassing</label>
                                                </li>
                                                <li class="custom-checkbox">
                                                    <input type="checkbox" name="babydols" id="2" class="sadia-checkbox">
                                                    <label for="2" class="sadia-checkbox-label">Landscaping & Fencing</label>
                                                </li>
                                                <li class="custom-checkbox">
                                                    <input type="checkbox" name="babydols" id="3" class="sadia-checkbox">
                                                    <label for="3" class="sadia-checkbox-label">Doors & Windows</label>
                                                </li>
                                                <li class="custom-checkbox">
                                                    <input type="checkbox" name="babydols" id="4" class="sadia-checkbox">
                                                    <label for="4" class="sadia-checkbox-label">Garden & Waste Disposal</label>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- Category Search filter End -->

                                        <!-- Price Search filter Start -->
                                        <div class="filter-box">
                                            <div class="filter-title">
                                                <h2>Filter by price</h2>
                                            </div>
                                            <ul class="search-filter-list list-unstyled">
                                                <li class="custom-radio">
                                                    <input type="radio" name="price" id="sixtentoeighteen" class="sadia-radio-input">
                                                    <label for="sixtentoeighteen" class="sadia-radio-label"><span></span> $10.00 - $15.00 (5) </label>
                                                </li>
                                                <li class="custom-radio">
                                                    <input type="radio" name="price" id="twentyfivetothirtytwo" class="sadia-radio-input">
                                                    <label for="twentyfivetothirtytwo" class="sadia-radio-label"><span></span> $16.00 - $25.00 (22)</label>
                                                </li>
                                                <li class="custom-radio">
                                                    <input type="radio" name="price" id="fiftytofiftythree" class="sadia-radio-input">
                                                    <label for="fiftytofiftythree" class="sadia-radio-label"><span></span> $26.00 - $35.00 (53)</label>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- Price Search filter End -->

                                        <!-- Recent Post Widget Start -->
										
										<div class="recent-post-widget filter-box">
                                        <div class="filter-title">
                                            <h2>Recent Products</h2>
                                        </div>
                                        <div class="single-recent-post">
                                            <a href="#" class="single-post-thumb">
                                                <img src="http://157.230.149.187/marketplace/public/assets/images/product1.jpg" alt="Blog Thumb">
                                            </a>
                                            <div class="single-post-content">
                                                <a href="#" class="single-post-title">Awesome Dress</a>
                                                <a href="#" class="single-post-date">12 February, 2020</a>
                                            </div>
                                        </div>
                                        <div class="single-recent-post">
                                            <a href="#" class="single-post-thumb">
                                                <img src="http://157.230.149.187/marketplace/public/assets/images/product1.jpg" alt="Blog Thumb">
                                            </a>
                                            <div class="single-post-content">
                                                <a href="#" class="single-post-title">Awesome Dress</a>
                                                <a href="#" class="single-post-date">12 February, 2020</a>
                                            </div>
                                        </div>
                                        <div class="single-recent-post">
                                            <a href="#" class="single-post-thumb">
                                                <img src="http://157.230.149.187/marketplace/public/assets/images/product1.jpg" alt="Blog Thumb">
                                            </a>
                                            <div class="single-post-content">
                                                <a href="#" class="single-post-title">Awesome Dress</a>
                                                <a href="#" class="single-post-date">12 February, 2020</a>
                                            </div>
                                        </div>
                                        <div class="single-recent-post">
                                            <a href="#" class="single-post-thumb">
                                                <img src="http://157.230.149.187/marketplace/public/assets/images/product1.jpg" alt="Blog Thumb">
                                            </a>
                                            <div class="single-post-content">
                                                <a href="#" class="single-post-title">Awesome Dress</a>
                                                <a href="#" class="single-post-date">12 February, 2020</a>
                                            </div>
                                        </div>
                                    </div>
                                      
                                        <!-- Recent Post Widget End -->
                                    </div>
                                </aside>
                                <!-- Sidebar End -->
                            </div>
			
	<div class="col-lg-9 order-lg-2 order-1">		
		
        
            @if(count($result) > 0)		
			<section class="product-filter-wrap">
                <div class="product-filter-wrap-layout1">
                    <form class="product-filter-box">
                        <div class="row gutters-10 d-flex align-items-center">
                            <div class="col-xl-6 col-12 form-group">
                            </div>
                            <div class="col-xl-6 col-lg-12 col-sm-12 text-right form-group">
                                <select class="select-full-width" id="price_sort">
                                    <option data-display="Default Sorting">Default Sorting</option>
                                     <option  value="high">Price High-Low</option>
                              <option value="low">Price Low-High</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="product-box-wrap-layout1">
           
                    
                    <div class="row">
                         @foreach($result as $product)
                          <div class="col-lg-3 col-md-6 col-6">
                  <div class="product-box-layout1">
					<a href="{{ url('product/'.$product->slug) }}">
                      <div class="item-img">
                         <img src="{{ url('/public/images/product_images/product_thumbnail'). '/' .$product->image}}" alt="{{$product->title}}">
                          <div class="item-btn-wrap">
							@if($product->type == 'variable')
								<a href="{{ url('product/'.$product->slug) }}" class="item-btn">Add To Cart</a>
							@else
								<a href="{{ url('add-to-cart/'.$product->id) }}" class="item-btn">Add To Cart</a>
							@endif
                          </div>
                      </div>
                      <div class="item-content">
                          <h4 class="item-title"><a href="{{ url('product/'.$product->slug) }}">{{$product->title}}</a></h4>
                          <div class="item-price">@if($product->type == 'variable')From @endif £{{$product->price}} (inc. VAT)</div>
                      </div>
					</a>
                  </div>
                </div>
                         @endforeach
                    </div>
                   @else
				<div class="container">
                    <div class="row">
                        Sorry, no products
                    </div>
				</div>
                   @endif
                </div>
           </section>
			
			</div>
			</div>
		</div>
	</div>
			
  <!-- Ctaegory area End-->
@endsection