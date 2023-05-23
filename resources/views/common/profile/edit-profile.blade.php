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
    <!-- About Us Start-->
	<section class="edit-customer p-5">
        <div class="container">
			<div class="row edit-menu">
			<div class="col-md-3 mb-3 p-0">
				<ul class="nav nav-pills flex-column m-0" id="myTab" role="tablist">
				  <li class="nav-item">
					<a class="nav-link active" id="dashboard-tab" data-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="true">Dashboard</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false">Orders</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="false">Address</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" id="account-tab" data-toggle="tab" href="#account" role="tab" aria-controls="account" aria-selected="false">Account Detail</a>
				  </li>
				  <li class="nav-item">
				  	<a class="nav-link" id="logout-tab" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-forms').submit();">Log Out</a>
				   <a class="nav-link dropdown-item logout"></a>
				   <form id="logout-forms" action="{{ route('logout') }}" method="POST" style="display: none;">
					{{ csrf_field() }}
					</form>
					
				  </li>
				</ul>
			</div>
    <!-- /.col-md-2 -->
    @php $user = Auth::user(); @endphp
        <div class="col-md-9 m-auto">
			  <div class="tab-content" id="myTabContent">
				  <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
						<div class="mainHeading text-uppercase text-center mb-3">My Account</div>
						<div class="row p-5">
							<div class="myaccount-content">
								<p>Hello <strong>{{ $user->name }}</strong> (not <strong>{{ $user->email }}</strong>? 
 								   <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-formm').submit();">Log Out</a>
								   <a class="nav-link dropdown-item logout"></a>
								   <form id="logout-formm" action="{{ route('logout') }}" method="POST" style="display: none;">
									{{ csrf_field() }}
									</form>)
								</p>
								<p>From your account dashboard you can view your <a href="#">recent orders</a>, manage your <a href="#">shipping and billing addresses</a>, and <a href="#">edit your password and account details</a>.</p>
							</div>
						</div>
				  </div>
				  <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
					<div class="mainHeading text-uppercase text-center mb-3">Orders</div>
						<div class="row p-5">
							<table class="table table-striped table-hover">
								<thead>
								  <tr>
									<th>Order</th>
									<th>Date</th>
									<th>Status</th>
									<th>Total</th>
									<th>Action</th>
								 </tr>
								</thead>
								<tbody>
								@php @endphp
								@foreach($order as $orders)
								  <tr>
									<td>#{{ $orders->order_id }}</td>
									<td>{{ Carbon\Carbon::parse($orders->created_at)->format('d/m/Y') }}</td>
									<td>{{ $orders->order_status }}</td>
									<td>${{ $orders->order_total }} for {{ $orders->order_item_qty}} item</td>
									<td><a class="cust-btn" href="#">View</a></td>                 
								  </tr>
								@endforeach
								</tbody>
							</table>
						 </div>
				  </div>
				  <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
					<div class="mainHeading text-uppercase text-center mb-3">Addresses</div>
					<div class="row p-5 address-box">
						<div class="col-md-6"> 
								<div class="customer-address p-3"> 
									<header class="customer-address-title">
										<h4>Billing address</h4> 
										<a href="#" class="edit">Edit</a> 
									</header> 
									<address>{{ $order[0]->street_address }}<br>{{ $order[0]->city }}<br>{{ $order[0]->postcode }}<br>{{ $order[0]->country }}</address>
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
				  	  <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
					  <div class="mainHeading text-uppercase text-center mb-3">Account details</div>
					     <div class="row p-5">
								<form class="" action="" method="post">
									<div class="row form-group">
										<div class="col-md-6">
											@php $string = $order[0]->display_name;
												 $Firstsubstring = substr($string, 0, strpos($string, ' ')); 
												 $Lastsubstring = substr($string, strpos($string, " ") + 1);; 
											@endphp
											<label for="">First name</label> 
											<input type="text" class="form-control" name="name" id="name" value="{{ $Firstsubstring }}">
										</div>
										<div class="col-md-6">
											<label for="">Last name</label> 
											<input type="text" class="form-control" name="name" id="name" value="{{ $Lastsubstring }}">
										</div>
										<div class="col-md-6">
											<label for="">Display name</label> 
											<input type="text" class="form-control" name="name" id="name" value="{{ $order[0]->display_name }}">
										</div>
										<div class="col-md-6">
											<label for="">Email Address</label> 
											<input type="email" class="form-control" name="name" id="name" value="{{ $order[0]->email }}">
										</div>
										<div class="col-md-12">
											<h4>Password change</h4>
											<label for="">Current password (leave blank to leave unchanged)</label> 
											<input type="password" class="form-control" name="name" id="name" value="">
										</div>
										<div class="col-md-12">
											<label for="">New password (leave blank to leave unchanged)</label> 
											<input type="password" class="form-control" name="name" id="name" value="">
										</div>
										<div class="col-md-12">
											<label for="">Confirm new password</label> 
											<input type="password" class="form-control" name="name" id="name" value="">
										</div>
										
									</div>
								<button type="submit" class="customer-Button button" name="save_account_details" value="Save changes">Save changes</button>
							</form>
                        </div>
				  </div>
				
			</div>
			
		</div>
    <!-- /.col-md-10 -->
  </div>
           </div>
		</section>

  <!-- About Us End-->


@endsection