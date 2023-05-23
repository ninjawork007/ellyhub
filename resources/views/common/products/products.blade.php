@extends('layouts/master')
@section('title')
{{ $category_slug[0]->title }}
@endsection

@section('content')
 <!-- Slider Area Start-->	
  <!-- breadcumb Start-->
		<div class="breadcumb-area product-bread">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 p-0">
								<ul class="list-inline">
								   <li class="list-inline-item"><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right" aria-hidden="true"></i></li>
									@for($i = 0; $i <= count(Request::segments()); $i++)
									<li class="list-inline-item">
									  <a href="{{url('/').'/'.Request::segment($i)}}">{{Request::segment($i)}}</a>
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
  <div class="sidepanel d-lg-none">
   <button class="openbtn" onclick="openNav()"><i class="fa fa-toggle-on" aria-hidden="true"></i></button>  
   </div>
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
            <aside class="sidebar shop-sidebar sidepanel" id="myySidepanel">
			 <a href="javascript:void(0)" class="closebtn d-lg-none" onclick="closeNav()">×</a>
               @include('common/products/product-sidebar')
            </aside>
            <!-- Sidebar End -->
      </div>
			
	<div class="col-lg-9 order-lg-2 order-1">		
			<section class="shop-wrap-layout2">
            <div class="container">
                <div class="banner_sec">
				 <div class="row">
                    @if($category_slug)
				<div class="col-lg-4 p-0 banner_left">	
                    <img src="{{ url('/public/images/category_images'). '/' .$category_slug[0]->image}}"></div>
                   <div class="col-lg-8 p-0 banner_right">
				   <div class="b-img"><img src="{{ url('/public/images/category_images'). '/' .$category_slug[0]->banner}}"></div>
				   <div class="b-title"><h2>{{ $category_slug[0]->title }}</h2></div>
				   </div>
                    @endif
                </div>
                </div>
				 </div>
        </section>
        <section class="sub_categories service">
				  <div class="container">
            @if(count($sub_categories) > 0)
            <div class="row">
		          <div id="owl-carousel5" class="owl-carousel owl-theme">
                 @foreach($sub_categories as $sub_category)						
                    <div class="item">
                       <a href="{{ url('/'). '/categories/' . $sub_category->slug }}">
        								<div class="service-img"><img src="{{ url('/public/images/category_images'). '/' .$sub_category->image}}" alt="service"></div>
        								<div class="service-title">{{$sub_category->title}}</div>
                      </a>
                    </div>					
                 @endforeach
		          </div>
            </div>
           @else
           <div>
               
           </div>
           @endif
          </div>
        </section>	
        @if(count($products) > 0)		
			<section class="product-filter-wrap">
          <div class="product-filter-wrap-layout1">
              <form class="product-filter-box">
                  <div class="row gutters-10 d-flex align-items-center">
                      <div class="col-xl-6 col-4 form-group">
                          <h3 class="item-title">Showing {{ count($products) }} of {{ count($products_all) }} results</h3>
                      </div>
                      <div class="col-xl-3 col-lg-12 col-sm-12 col-4 form-group">					 
						  <a class="grid btn active" href="#" title="Grid view"><span class="fa fa-th-large" aria-hidden="true"></span></a>  
						  <a class="list btn" href="#" title="List view"><span class="fa fa-th-list" aria-hidden="true"></span></a>
					  </div>
                      <div class="col-xl-3 col-lg-12 col-sm-12 col-4 text-right form-group">
                          <select class="select-full-width" id="price_sort">
                              <option data-display="Default Sorting">Default Sorting</option>
                              <option data-catid="{{ $category_slug[0]->id }}" value="high">Price High-Low</option>
                              <option data-catid="{{ $category_slug[0]->id }}" value="low">Price Low-High</option>
                          </select>
                      </div>
                  </div>
              </form>
          </div>
          <div class="product-box-wrap-layout1" id="product_hide"> 
            <div class="row">            
              @foreach($products as $product)
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
          <div id="search_results"></div>
          <div id="sort_results"></div>
          <div class="pagination-layout2 d-flex justify-content-center">
            {{ $products->links() }}
          </div> 
      </section>
			
			</div>
			</div>
		</div>
	</div>
  <!-- Ctaegory area End-->
@endsection