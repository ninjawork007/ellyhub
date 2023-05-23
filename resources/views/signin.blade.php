@extends('layouts.web')

@section('content')

<!--title-bar start-->

	<section class="title-bar">

		<div class="container">

			<div class="row">

				<div class="col-md-6">

					<div class="left-title-text">

					<h3>Login Now</h3>

					</div>

				</div>

				<div class="col-md-6">

					<div class="right-title-text">  

						<ul>

							<li class="breadcrumb-item"><a href="index.html">Home</a></li>

							<li class="breadcrumb-item active" aria-current="page">Login User</li>

						</ul>

					</div>

				</div>

			</div>

		</div>

	</section>

	<!--title-bar end-->	

	<!--login-and-register start-->

	<section class="login_register">			

		<div class="container">					

			<div class="row justify-content-center">

				<div class="col-lg-6 col-md-6 col-12">

					<h1>Login</h1>

					<div class="login-container">

						<div class="row">			

							<div class="col-lg-12 col-md-12 col-12">

								<form>	

									<div class="login-form">	

										<div class="login-logo w-100">									

											<a href="{{url('/')}}"><img src="{{url('public/assets/images/logo.PNG')}}" alt="" class="w-50"></a>

										</div>
										<div class="form-group">

											<input type="email" class="video-form" id="emailAddress" placeholder="Email Address">							

										</div>

										<div class="form-group">

											<input type="password" class="video-form" id="password1" placeholder="Password">							

										</div>
										

										<button type="submit" class="login-btn btn-link">Login</button>

										<div class="forgot-password">	

											<p>Don't have account?<a href="{{url('signup')}}"><span style="color:#ffa803;"> - Register Now</span></a></p>

										</div>										

									</div>	

								</form>		

							</div>

						</div>						

					</div>						

				</div>				

			</div>			

		</div>

	</section>

	<!--login-and-register end-->

@endsection

