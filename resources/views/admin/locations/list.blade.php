@extends('layouts.admin')
@section('content')

<div class="page-wrapper">
			<div class="content container-fluid">
			
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col">
							<h3 class="page-title">Services Provider</h3>
						</div>
						<div class="col-auto text-right">
							<a class="btn btn-white filter-btn" href="javascript:void(0);" id="filter_search">
								<i class="fas fa-filter"></i>
							</a>
							<a href="{{route('add_location')}}" class="btn btn-primary add-button">
								<i class="fas fa-plus"></i>
							</a>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				
				<!-- Search Filter -->
				<form action="#" method="post" id="filter_inputs">
					<div class="card filter-card">
						<div class="card-body pb-0">
							<div class="row filter-row">
								<div class="col-sm-6 col-md-8">
									<div class="form-group">
										<label>Service</label>
										<input class="form-control" type="text">
									</div>
								</div>
								
								<div class="col-sm-6 col-md-4">
									<div class="form-group">
										<button class="btn btn-primary btn-block" type="submit">Submit</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
				<!-- /Search Filter -->
				
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-hover table-center mb-0 datatable">
										<thead>
											<tr>
												<th>#</th>
												<th>City</th>
												<th>State</th>
												<th>Country</th>
												<th>Zip</th>
												<th>Date</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											@if(!$locations->isEmpty())
											@foreach($locations as $key)
											<tr>
												<td>1</td>
												<td>{{$key->city}}</td>
												<td>{{$key->state}}</td>
												<td>{{$key->country}}</td>
												<td>{{$key->zip_code}}</td>
												<td>{{date('M d, Y',strtotime($key->created_at))}}</td>
												<td>
													<a href="{{route('edit_location',[$key->id])}}" class="btn btn-sm bg-info-light">
														<i class="far fa-edit mr-1"></i> Edit
													</a>
												</td>
											</tr>
											@endforeach

											@endif
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<script src="{{url('public/assets/admin/js/moment.min.js')}}"></script>
<script src="{{url('public/assets/admin/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{url('public/assets/admin/plugins/datatables/datatables.min.js')}}"></script>
@endsection
