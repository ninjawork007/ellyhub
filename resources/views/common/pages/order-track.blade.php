@extends('layouts/master')
@section('title')
ORDER TRACK
@endsection
@section('description')
ORDER TRACK desc

@endsection
@section('keywords')
order
@endsection
@section('content')
  <!-- breadcumb Start-->
		<div class="breadcumb-area text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
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
					<div class="mainHeading text-uppercase text-center m-auto">Order Tracking</div>
						<p class="text-center p-5">Let the rest look at you with starry eyes, as you show off your love for fashion by carrying this grey handbag from Inc.5. Featuring a sophisticated gusseted design and delicate laser cut details all over, this handbag is a cut above the rest. It also has twin grab</p>
				<div class="col-md-7 m-auto order-track">
						<form class="" action="" method="post">
									<div class="row form-group">
										<div class="col-md-12">
											<label for="">Order ID</label> 
											<input type="text" class="form-control" name="name" id="name" value="" placeholder="Found in your order confirmation email.">
										</div>
										<div class="col-md-12">
											<label for="">Billing Email</label> 
											<input type="text" class="form-control" name="name" id="name" value="" placeholder="Email you used during checkout.">
										</div>
								
									</div>
								<button type="submit" class="customer-Button button" name="save_account_details" value="Save changes">Save changes</button>
						</form>
				</div>
			</div>
		</div>
	</section>


@endsection