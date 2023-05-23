@extends('layouts/master')
@section('title')
CREDIT ACCOUNT AND TRADE ACCOUNT
@endsection
@section('description')
CREDIT ACCOUNT AND TRADE ACCOUNT description
@endsection
@section('keywords')
account
@endsection
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
    
    <!-- About Us Start-->
		<section class="account-sec sec-padding">
            <div class="container">
				<div class="row align-items-center m-auto">
						<div class="col-lg-12 mainHeading text-uppercase text-center mb-3">
							CREDIT ACCOUNT AND TRADE ACCOUNT
						</div>
                    <div class="col-lg-6 m-auto pt-4">
						<div class="row">
							<div class="col-lg-6 col-sm-6">
								<div class="featured-box text-center left-acc">
									<div class="box-content">
										<i class="fa fa-id-card-o" aria-hidden="true"></i>
										<h3>Trade Card Account</h3>
										<p class="px-3">Trade Card Account Application Online Form.</p>
										<p><a href="#">Click Here<i class="fa fa-angle-right"></i></a></p>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-sm-6">
								<div class="featured-box text-center right-acc">
									<div class="box-content">
										<i class="fa fa-id-card-o" aria-hidden="true"></i>
										<h3>Credit Account</h3>
										<p class="px-3">Credit Account Application Form.</p>
										<p><a href="#">Click Here<i class="fa fa-angle-right"></i></a></p>
									</div>
								</div>
							</div>
						</div>
                   </div>
				</div>
           </div>
		</section>

  <!-- About Us End-->

@endsection