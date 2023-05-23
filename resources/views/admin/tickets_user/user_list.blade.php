@extends('layouts.admin')
@section('content')
<div class="page-wrapper">
			<div class="content container-fluid">
			
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col">
							<h3 class="page-title">Booking List</h3>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				
				<ul class="nav nav-tabs menu-tabs">
					<li class="nav-item active">
						<a class="nav-link" href="{{route('tickets_user')}}">User Message</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{route('tickets_salon')}}">Salon Message</a>
					</li>
				</ul>
				
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-hover table-center mb-0 datatable">
										<thead>
											<tr>
												<th>#</th>
												<th>User</th>
												<th>Message</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/customer/user-01.jpg')}}">
														</a>
														<a href="javascript:void(0);">Jeffrey Akridge</a>
													</span>
												</td>
												<td>Lorem Ipsum is simply dummy text of the</td>
												<td>
													<a href="#" class="btn btn-sm bg-info-light">
														<i class="fa fa-reply mr-1"></i> 
													</a>
													<a href="#" class="btn btn-sm bg-danger-light">
														<i class="fa fa-check mr-1"></i> 
													</a>
												</td>
											</tr>
											<tr>
												<td>2</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/customer/user-01.jpg')}}">
														</a>
														<a href="javascript:void(0);">Jeffrey Akridge</a>
													</span>
												</td>
												<td>Lorem Ipsum is simply dummy text of </td>
												<td><a href="#" class="btn btn-sm bg-info-light">
														<i class="fa fa-reply mr-1"></i> 
													</a>
													<a href="#" class="btn btn-sm bg-danger-light">
														<i class="fa fa-check mr-1"></i> 
													</a></td>
											</tr>
											<tr>
												<td>3</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/customer/user-01.jpg')}}">
														</a>
														<a href="javascript:void(0);">Jeffrey Akridge</a>
													</span>
												</td>
												<td>Lorem Ipsum is simply dummy text of</td>
												<td><a href="#" class="btn btn-sm bg-info-light">
														<i class="fa fa-reply mr-1"></i> 
													</a>
													<a href="#" class="btn btn-sm bg-danger-light">
														<i class="fa fa-check mr-1"></i> 
													</a></td>
											</tr>
											<tr>
												<td>4</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/customer/user-01.jpg')}}">
														</a>
														<a href="javascript:void(0);">Jeffrey Akridge</a>
													</span>
												</td>
												<td>Lorem Ipsum is simply dummy text </td>
												<td><a href="#" class="btn btn-sm bg-info-light">
														<i class="fa fa-reply mr-1"></i> 
													</a>
													<a href="#" class="btn btn-sm bg-danger-light">
														<i class="fa fa-check mr-1"></i> 
													</a></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Send Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <textarea placeholder="Please write message here..." class="form-control"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send</button>
      </div>
    </div>
  </div>
</div>
<script src="{{url('public/assets/admin/js/moment.min.js')}}"></script>
<script src="{{url('public/assets/admin/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{url('public/assets/admin/plugins/datatables/datatables.min.js')}}"></script>
<script type="text/javascript">
	$('.fa.fa-reply').on('click',function(){
		$('#exampleModalCenter').modal('show');
	});
</script>
@endsection
