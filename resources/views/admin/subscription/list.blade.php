@extends('layouts.admin')
@section('content')
<div class="page-wrapper">
			<div class="content container-fluid">
			
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col">
							<h3 class="page-title">Subscriptions</h3>
						</div>
						<div class="col-auto text-right">
							<a href="{{route('add_membership')}}" class="btn btn-primary add-button">
								<i class="fas fa-plus"></i>
							</a>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<div class="row pricing-box">
					@if(!$locations->isEmpty())
					@foreach($locations as $key)
					<div class="col-md-6 col-lg-4 col-xl-3">
						<div class="card">
							<div class="card-body">
								<div class="pricing-header">
									<h2>{{$key->title}}</h2>
									<p>Monthly Price</p>
								</div>
								<div class="pricing-card-price">
									<h3 class="heading2 price">${{$key->price}}</h3>
									<p>Duration: <span>1 {{$key->duration}}</span></p>
								</div>
								<ul class="pricing-options">
									{!! $key->description !!}
								</ul>
								<a href="#" class="btn btn-primary btn-block">Edit</a>
							</div>
						</div>
					</div>
					@endforeach
					@endif
				</div>
			</div>
		</div>
<script src="{{url('public/assets/admin/js/moment.min.js')}}"></script>
<script src="{{url('public/assets/admin/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{url('public/assets/admin/plugins/datatables/datatables.min.js')}}"></script>
@endsection
