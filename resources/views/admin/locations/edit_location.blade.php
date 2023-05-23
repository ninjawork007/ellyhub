@extends('layouts.admin')
@section('content')

<div class="page-wrapper">
			<div class="content container-fluid">
				<div class="row">
					<div class="col-xl-8 offset-xl-2">
					
						<!-- Page Header -->
						<div class="page-header">
							<div class="row">
								<div class="col-sm-12">
									<h3 class="page-title">Edit Location</h3>
								</div>
							</div>
						</div>
						<!-- /Page Header -->
						
						<div class="card">
							<div class="card-body">
							@include('common.alerts')
								<!-- Form -->
								<form action="{{route('update_location')}}" method="post" data-parsley-validate="">
									@csrf
									<input type="hidden" name="id" value="{{$location->id}}">
									<div class="form-group">
										<label>City</label>
										<input class="form-control" type="text" name="city" required="" value="{{$location->city}}">
									</div>
									<div class="form-group">
										<label>State</label>
										<input class="form-control" type="text" name="state" required="" value="{{$location->state}}">
									</div>
									<div class="form-group">
										<label>Country</label>
										<input class="form-control" type="text" name="country" required="" value="{{$location->country}}">
									</div>
									<div class="form-group">
										<label>Zip</label>
										<input class="form-control" type="text" name="zip" required="" value="{{$location->zip_code}}">
									</div>
									<div class="mt-4">
										<button class="btn btn-primary" type="submit">Update</button>
										<a href="{{route('locations_list')}}" class="btn btn-link">Back</a>
									</div>
								</form>
								<!-- /Form -->
								
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
