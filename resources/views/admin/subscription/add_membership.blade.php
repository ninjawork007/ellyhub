@extends('layouts.admin')
@section('content')
<script src="https://cdn.tiny.cloud/1/c2qcxj5f1jt89kcmq754gz0psi44pl01zjx6zehocfgeeq4j/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: '#description',
      plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      toolbar_mode: 'floating',
   });
  </script>
<div class="page-wrapper">
			<div class="content container-fluid">
				<div class="row">
					<div class="col-xl-8 offset-xl-2">
					
						<!-- Page Header -->
						<div class="page-header">
							<div class="row">
								<div class="col-sm-12">
									<h3 class="page-title">Add Membership</h3>
								</div>
							</div>
						</div>
						<!-- /Page Header -->
						
						<div class="card">
							<div class="card-body">
							@include('common.alerts')
								<!-- Form -->
								<form action="{{route('save_membership')}}" method="post" data-parsley-validate="">
									@csrf
									<div class="form-group">
										<label>Title</label>
										<input class="form-control" type="text" name="title" required="">
									</div>
									<div class="form-group">
										<label>Price</label>
										<input class="form-control" type="number" name="price" required="">
									</div>
									<div class="form-group">
										<label>Interval</label>
										<select class="form-control" required="" name="interval">
											<option value="">Select Interval</option>
											<option value="day">Day</option>
											<option value="week">Week</option>
											<option value="month">Month</option>
											<option value="year">Year</option>
										</select>
									</div>
									<div class="form-group">
										<label>Description</label>
										<textarea class="form-control" name="description" id="description"></textarea>
									</div>
									<div class="mt-4">
										<button class="btn btn-primary" type="submit">Submit</button>
										<a href="{{route('locations_list')}}" class="btn btn-link">Cancel</a>
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
