@extends('layouts.web')

@section('content')

<!--title-bar start-->

	<section class="title-bar">

		<div class="container">

			<div class="row">

				<div class="col-md-6">

					<div class="left-title-text">

					<h3>Signup Now</h3>

					</div>

				</div>

				<div class="col-md-6">

					<div class="right-title-text">  

						<ul>

							<li class="breadcrumb-item"><a href="index.html">Home</a></li>

							<li class="breadcrumb-item active" aria-current="page">Signup User</li>

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

					<h1>Register Now</h1>

					<div class="login-container">

						<div class="row">			

							<div class="col-lg-12 col-md-12 col-12">

								<form>	

									<div class="login-form">	

										<div class="login-logo w-100">									

											<a href="{{url('/')}}"><img src="{{url('assets/images/logo.PNG')}}" alt="" class="w-50"></a>

										</div>

										<div class="create-text"><h4>Create Your Account</h4></div>										

										<div class="form-group">

											<input type="text" class="video-form" id="fullName" placeholder="Full Name">							

										</div>

										<div class="form-group">

											<input type="email" class="video-form" id="emailAddress" placeholder="Email Address">							

										</div>

										<div class="form-group">

											<input type="password" class="video-form" id="password1" placeholder="Password">							

										</div>

										<div class="signup-checkbox text-left">

											  <input type="checkbox" id="c1" name="cb">

											  <label for="c1" onclick="go_to_url()">  By clicking “Sign Up” or “Sign in with Facebook” <span>I acknowledge and agree to the terms
of use and  </span> and <span> privacy policy</span>.</label>

										</div>

										<button type="submit" class="login-btn btn-link">Register Now</button>

										<div class="forgot-password">	

											<p>If you have an account?<a href="{{url('signin')}}"><span style="color:#ffa803;"> - Login Now</span></a></p>

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
<script type="text/javascript">
	function go_to_url() {
		base_url = "{{url('policy')}}";
		window.open(base_url,'_blank');
	}
</script>
@endsection

