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
									<h3 class="page-title">Update User Detail</h3>
								</div>
							</div>
						</div>
						<!-- /Page Header -->
						<div class="card">
							<div class="card-body">
							@include('common.alerts')
								<!-- Form -->
								<form action="{{route('save_location')}}" method="post" data-parsley-validate="">
									@csrf
									<div class="form-group">
										<label>Name</label>
										<input class="form-control" type="text" name="city" required="">
									</div>
									<div class="form-group">
										<label>Email</label>
										<input class="form-control" type="text" name="city" required="">
									</div>
									<div class="form-group">
										<label>Mobile</label>
										<input class="form-control" type="text" name="city" required="">
									</div>
									<div class="form-group">
										<label>Image</label>
										<input class="form-control" type="file" required="">
									</div>
									<div class="form-group">
										<label>Password</label>
										<input class="form-control" type="password" name="zip" required="">
									</div>
									<div class="mt-4">
										<button class="btn btn-primary" type="submit">Update</button>
										<a href="{{url('admin/user')}}" class="btn btn-link">Cancel</a>
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
