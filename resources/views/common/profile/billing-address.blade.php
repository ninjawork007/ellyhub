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
  <section class="billing-address">
		<div class="mainHeading text-uppercase text-center mb-3">Billing-Address</div>
						<div class="col-md-6 m-auto">
							<form class="" action="" method="post">
									<div class="row form-group">
										<div class="col-md-6">
											<label for="">First name</label> 
											<input type="text" class="form-control" name="name" id="name" value="">
										</div>
										<div class="col-md-6">
											<label for="">Last name</label> 
											<input type="text" class="form-control" name="name" id="name" value="">
										</div>
										<div class="col-md-12">
											<label for="">Company name</label> 
											<input type="text" class="form-control" name="name" id="name" value="">
										</div>
										<div class="col-md-12">
											<h4>Street address</h4>
											<label for="">House number and street name</label> 
											<input type="text" class="form-control" name="name" id="name" value="">
										</div>
										<div class="col-md-12">
											<label for="">Apartment, suite, unit etc. (optional)</label> 
											<input type="text" class="form-control" name="name" id="name" value="">
										</div>
										<div class="col-md-4">
											<label for="">Town / City</label> 
											<input type="text" class="form-control" name="name" id="name" value="">
										</div>
										<div class="col-md-4">
											<label for="">State / County</label> 
											<input type="text" class="form-control" name="name" id="name" value="">
										</div>
										<div class="col-md-4">
											<label for="">Postcode / ZIP</label> 
											<input type="number" class="form-control" name="name" id="name" value="">
										</div>
										<div class="col-md-6">
											<label for="">Phone</label> 
											<input type="number" class="form-control" name="name" id="name" value="">
										</div>
										<div class="col-md-6">
											<label for="">Email Address</label> 
											<input type="email" class="form-control" name="name" id="name" value="">
										</div>
									</div>
								<button type="submit" class="customer-Button button" name="save_account_details" value="Save changes">Save changes</button>
							</form>
                        </div>
		</section>
  
  
@endsection