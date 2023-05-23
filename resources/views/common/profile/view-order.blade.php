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

	<section class="view-order">
		<div class="container">
			<div class="row">
				<div class="col-md-6 m-auto order-box">
			<p>Order <mark class="order-number">#1027</mark> was placed on <mark class="order-date">July 3, 2019</mark> and is currently On <mark class="order-status">hold.</p>
				<h4>Order Details</h4>
					<table class="table table-striped table-hover">
								<thead>
								  <tr>
									<th>Product</th>
									<th>Total</th>
								 </tr>
								</thead>
								<tbody>
								  <tr>
									<td><a href="#">Accumsan eli</a> <strong class="product-quantity">× 1</strong></td>
									<td>$100.00</td>
								  </tr>
								  <tr>
									<td>Subtotal:</td>
									<td>$100.00</td>
								  </tr>
								   <tr>
									<td>Shipping:</td>
									<td>Free Shipping</td>
								  </tr>
								   <tr>
									<td>Payment method:</td>
									<td>Direct bank transfer</td>
								  </tr>
								   <tr>
									<td>Total:</td>
									<td>$100.00</td>
								  </tr>
								   <tr>
									<td>Note:</td>
									<td>This is test message</td>
								  </tr>
								</tbody>
							</table>

					<div class="row pt-5 address-box">
						<div class="col-md-6"> 
								<div class="customer-address p-3"> 
									<header class="customer-address-title">
										<h4>Billing address</h4> 
										<a href="#" class="edit">Edit</a> 
									</header> 
									<address>test test<br>test<br>test<br>test<br>test<br>test<br>175035<br>American Samoa</address>
								</div>
							</div>
							<div class="col-md-6"> 
								<div class="customer-address p-3"> 
									<header class="customer-address-title">
										<h4>Shipping address</h4> 
										<a href="#" class="edit">Edit</a> 
									</header> 
									<address>test test<br>test<br>test<br>test<br>test<br>test<br>175035<br>American Samoa</address>
								</div>
							</div>
					</div>							
				</div>
			</div>
		</div>
	</section>

@endsection