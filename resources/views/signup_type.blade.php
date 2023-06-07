@extends('layouts.web')
@section('content')
	<!--title-bar start-->
	<section class="title-bar">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="left-title-text">
					<h3>Partner with us</h3>
					</div>
				</div>
				<div class="col-md-6">
					<div class="right-title-text">  
						<ul>
							<li class="breadcrumb-item"><a href="index.html">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">Partner with us</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--title-bar end-->
<!--partner-with-us start-->
	<section class="how-to-orders">			
		<div class="container">		
			<div class="row">	
				<div class="col-md-12">
					<div class="new-heading">
						<h1> Partner With Us</h1>
					</div>						
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-lg-6 col-md-6">
					<div class="about-text1">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam tristique non est semper commodo. Cras semper nibh nibh.</p>
					</div>						
				</div>
			</div>
			<div class="order-steps">
				<div class="row justify-content-md-center">
					<div class="col-lg-4 col-md-6 col-12">
						<div class="for-restaurant">
							<img src="{{url('assets/icons/advisor.svg')}}" alt="Adviser">
							<h4>For Advisors</h4>
							<p>Praesent rhoncus urna nec justo suscipit, id congue justo dictum.</p>
							<a href="{{url('signup/advisor')}}" class="partner-btn1 btn-link">Signup</a>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-12">
						<div class="for-restaurant">
							<img src="{{url('assets/icons/users.svg')}}" alt="user">
							<h4>For Users</h4>
							<p>Praesent rhoncus urna nec justo suscipit, id congue justo dictum.</p>
							<a href="{{url('signup/user')}}" class="partner-btn1 btn-link">Signup</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--partner-with-us end-->	
@endsection
