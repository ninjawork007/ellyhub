@extends('layouts/master')
@section('title')
	@for($i = 0; $i <= count(Request::segments()); $i++)
		{{ ucfirst(Request::segment($i)) }}									 
	@endfor
@endsection

@section('content')
 <!-- Slider Area Start-->	
  <!-- breadcumb Start-->
		<div class="breadcumb-area text-center">
                <div class="container">
                    <div class="row">
                         <div class="col-md-12 p-0">
							<div class="breadcumb-img">
								<img src="{{ asset('public/assets/images/breadcumb.jpg') }}" alt="about thumb">
							</div>
							<div class="breadcumb-list">
								<ul class="list-inline">
									<li class="list-inline-item"><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right" aria-hidden="true"></i></li>
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
            </div>
  <!-- breadcumb End-->

  <!-- Ctaegory area Start-->
	<div class="shop_area cat-area">
        <div class="container">
            <div class="row">				
	<div class="col-lg-12 order-lg-2 order-1">		
			<section class="shop-wrap-layout2">
            <div class="container">
                <div class="product-box-wrap-layout1">
                    <div class="row">
                        @foreach($all_categories as $categories)
                        <div class="col-lg-3 col-md-6">
                            <div class="product-box-layout1">
                                <div class="item-img">
                                    <img src="{{ url('/public/images/category_images'). '/' .$categories->image}}" alt="{{$categories->title}}">
                                    <div class="item-btn-wrap">
                                        <a href="{{ url('/'). '/categories/' .$categories->slug}}" class="item-btn">View More</a>
                                    </div>
                                </div>
                                <div class="item-content text-center">
                                    <h4 class="item-title">
                                    <a href="{{ url('/'). '/categories/' .$categories->slug}}">{{$categories->title}}</a></h4>
                                </div>
                            </div>
                        </div> 
                       @endforeach
                    </div>
                </div>
                <div class="pagination-layout2 d-flex justify-content-center">
                   {{ $all_categories->links() }}

                </div> 
            </div>
        </section>
			
			</div>
			</div>
		</div>
	</div>
			
  <!-- Ctaegory area End-->
			

			
 @endsection
 
 