@extends('layouts/master')
@section('content')

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
	<section class="inner-pg p-5">
		<div class="container">
			<div class="row">
					<!--<div class="mainHeading text-uppercase text-center">Site Map</div>-->
					<div class="col-md-11 m-auto site-map">
  <nav class="sitemap">
    <ul class="first">
      <li><a href="#">Home</a>
			 <ul class="second">
			  <li><a href="#">About Us</a></li>
			  <li><a href="#">Delivery Information</a></li>
			  <li><a href="#">Ordering Tracking</a></li>
			  <li><a href="#">Recruitment</a></li>
			  <li><a href="#">Contact Us</a></li>
			</ul></li>
		</ul>
<ul class="first">
      <li><a href="#">Category</a>
        <ul class="second">
          <li><a href="#">Sheet Materials</a>
            <ul class="third">
              <li><a href="#">Phenolic Resin</a>
			  <ul class="third">
              <li><a href="#">Anti Slip Hardwood</a></li>
              <li><a href="#">Phenolic Resin</a></li>
              <li><a href="#">Phenolic Birch</a></li>
            </ul></li>
              
            </ul>
          </li>
          <li><a href="#">WBP Plywood</a>
            <ul class="third">
              <li><a href="#">Shuttering Plywood</a></li>
              <li><a href="#">Hardwood Plywood</a></li>
              <li><a href="#">Marine Plywood</a></li>
            </ul>
          </li>
          <li><a href="#">MDF Sections</a>
            <ul class="third">
              <li><a href="#">White Faced MDF</a></li>
              <li><a href="#">Black Faced MDF</a></li>
              <li><a href="#">Oak Veneer</a></li>
			  <li><a href="#">Standard MDF</a></li>
            </ul>
          </li>
          <li><a href="#">Flooring</a>
            <ul class="third">
              <li><a href="#">Softwood Flooring</a></li>
              <li><a href="#">OSB Flooring</a></li>
            </ul>
          </li>
          <li><a href="#">Decorative Panels</a>
		   <ul class="third">
              <li><a href="#">MDF Primed Wall Panels</a></li>
              <li><a href="#">Radiator Covers</a></li>
            </ul></li>
        </ul>
      </li>
    </ul>
  </nav>
 
					</div>
			</div>
		</div>
	</section>


@endsection