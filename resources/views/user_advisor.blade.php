@extends('layouts.web')

@section('content')

	<!--title-bar start-->
	<section class="title-bar">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="left-title-text">
					<h3>Register Advisor</h3>
					</div>
				</div>
				<div class="col-md-6">
					<div class="right-title-text">  
						<ul>
							<li class="breadcrumb-item"><a href="index.html">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">Register Advisor</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--title-bar end-->	
	<!--add-restaurant start-->
	<section class="add-restaurant">			
	<form>	
		<div class="container">					
			<div class="row justify-content-between">
				<div class="col-lg-10 col-md-10 col-10 offset-1">
					<div class="basic-info">
						<h4>Tell Us Abount Your Business</h4>
						<div class="form-group">
							<label for="nameRestaurant">Business Name*</label>
							<input type="text" class="video-form" id="nameRestaurant" placeholder="Enter Restaurant Name">							
						</div>

						<div class="form-group">
							<label for="searchCity">Category*</label>
							<select class="form-control selectpicker" tabindex="-98">
										<option value="0">Makeup Artist</option>
										<option value="1">Nail Artist</option>
										<option value="2">Hair Artist</option>		  
							</select>						
						</div>
						<div class="form-group">
							<label for="emailAddress">Email Address*</label>
							<input type="email" class="video-form" id="emailAddress" placeholder="Restaurant Email Address">							
						</div>
						<div class="form-group">
							<label for="emailAddress">Profile Photo*</label>
							<input type="file" class="video-form" >							
						</div>
					</div>
					<div class="basic-info">
						<h4>Business Detail</h4>
						<div class="form-group">
							<label for="emailAddress">Website or Blog*</label>
							<input type="email" class="video-form" id="emailAddress" placeholder="Restaurant Email Address">							
						</div>
						<div class="form-group">
							<label for="telNumber1">Certification/ Award*</label>
							<input type="tel" class="video-form" id="telNumber1" placeholder="Owner / Manager Phone Number">							
						</div>
						<div class="form-group">
							<label for="telNumber2">Service Provider*</label>
							<input type="tel" class="video-form" id="telNumber2" placeholder="Restaurant Phone Number">							
						</div>
						<div class="form-group">
							<label for="webSite">Business Description</label>
							<textarea class="form-control" rows="4"></textarea>						
						</div>
					</div>
					<button type="submit" class="add-resto-btn1 btn-link"><a href="https://professionaler.com/beauty_advisor/advisor-images">Register</a></button>
				</div>
			</div>							
		</div>
	</form>
	</section>
	<!--add-restaurant end-->
@endsection

