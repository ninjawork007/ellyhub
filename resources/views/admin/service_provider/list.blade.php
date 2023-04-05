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
												<th>Name</th>
												<th>Location</th>
												<th>Category</th>
												<th>Date</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td>
													<a href="#">
														<img class="rounded service-img mr-1" src="{{url('public/assets/admin/img/services/service-01.jpg')}}" alt=""> Toughened Glass Fitting Services
													</a>
												</td>
												<td>Wayne, New Jersey</td>
												<td>Cleaning</td>
												<td>13 Sep 2020</td>
												<td>
													<div class="status-toggle">
														<input id="service_1" class="check" type="checkbox">
														<label for="service_1" class="checktoggle">checkbox</label>
													</div>
												</td>
												<td>
													<a href="#" class="btn btn-sm bg-info-light">
														<i class="far fa-envelope mr-1"></i> 
													</a>
													<a href="{{route('edit_service_provider')}}" class="btn btn-sm bg-info-light">
														<i class="fa fa-edit mr-1"></i> 
													</a>
													<a href="#" class="btn btn-sm bg-danger-light">
														<i class="fa fa-trash mr-1"></i> 
													</a>
												</td>
											</tr>
											<tr>
												<td>2</td>
												<td>
													<a href="#">
														<img class="rounded service-img mr-1" src="{{url('public/assets/admin/img/services/service-02.jpg')}}" alt=""> Car Repair Services
													</a>
												</td>
												<td>Hanover, Maryland</td>
												<td>Automobile</td>
												<td>12 Sep 2020</td>
												<td>
													<div class="status-toggle">
														<input id="service_2" class="check" type="checkbox" checked>
														<label for="service_2" class="checktoggle">checkbox</label>
													</div>
												</td>
												<td>
													<a href="#" class="btn btn-sm bg-info-light">
														<i class="far fa-envelope mr-1"></i> 
													</a>
													<a href="{{route('edit_service_provider')}}" class="btn btn-sm bg-info-light">
														<i class="fa fa-edit mr-1"></i> 
													</a>
													<a href="#" class="btn btn-sm bg-danger-light">
														<i class="fa fa-trash mr-1"></i> 
													</a>
												</td>
											</tr>
											<tr>
												<td>3</td>
												<td>
													<a href="#">
														<img class="rounded service-img mr-1" src="{{url('public/assets/admin/img/services/service-03.jpg')}}" alt=""> Electric Panel Repairing Service
													</a>
												</td>
												<td>Kalispell, Montana</td>
												<td>Electrical</td>
												<td>11 Sep 2020</td>
												<td>
													<div class="status-toggle">
														<input id="service_3" class="check" type="checkbox">
														<label for="service_3" class="checktoggle">checkbox</label>
													</div>
												</td>
												<td>
													<a href="#" class="btn btn-sm bg-info-light">
														<i class="far fa-envelope mr-1"></i> 
													</a>
													<a href="{{route('edit_service_provider')}}" class="btn btn-sm bg-info-light">
														<i class="fa fa-edit mr-1"></i> 
													</a>
													<a href="#" class="btn btn-sm bg-danger-light">
														<i class="fa fa-trash mr-1"></i> 
													</a>
												</td>
											</tr>
											<tr>
												<td>4</td>
												<td>
													<a href="#">
														<img class="rounded service-img mr-1" src="{{url('public/assets/admin/img/services/service-04.jpg')}}" alt=""> Steam Car Wash
													</a>
												</td>
												<td>Electra, Texas</td>
												<td>Car Wash</td>
												<td>10 Sep 2020</td>
												<td>
													<div class="status-toggle">
														<input id="service_4" class="check" type="checkbox" checked>
														<label for="service_4" class="checktoggle">checkbox</label>
													</div>
												</td>
												<td>
													<a href="#" class="btn btn-sm bg-info-light">
														<i class="far fa-envelope mr-1"></i> 
													</a>
													<a href="{{route('edit_service_provider')}}" class="btn btn-sm bg-info-light">
														<i class="fa fa-edit mr-1"></i> 
													</a>
													<a href="#" class="btn btn-sm bg-danger-light">
														<i class="fa fa-trash mr-1"></i> 
													</a>
												</td>
											</tr>
											<tr>
												<td>5</td>
												<td>
													<a href="#">
														<img class="rounded service-img mr-1" src="{{url('public/assets/admin/img/services/service-05.jpg')}}" alt=""> House Cleaning Service
													</a>
												</td>
												<td>Sylvester, Georgia</td>
												<td>Cleaning</td>
												<td>9 Sep 2020</td>
												<td>
													<div class="status-toggle">
														<input id="service_5" class="check" type="checkbox" checked>
														<label for="service_5" class="checktoggle">checkbox</label>
													</div>
												</td>
												<td>
													<a href="#" class="btn btn-sm bg-info-light">
														<i class="far fa-envelope mr-1"></i> 
													</a>
													<a href="{{route('edit_service_provider')}}" class="btn btn-sm bg-info-light">
														<i class="fa fa-edit mr-1"></i> 
													</a>
													<a href="#" class="btn btn-sm bg-danger-light">
														<i class="fa fa-trash mr-1"></i> 
													</a>
												</td>
											</tr>
											<tr>
												<td>6</td>
												<td>
													<a href="#">
														<img class="rounded service-img mr-1" src="{{url('public/assets/admin/img/services/service-06.jpg')}}" alt=""> Computer & Server AMC Service
													</a>
												</td>
												<td>Los Angeles, California</td>
												<td>Computer</td>
												<td>8 Sep 2020</td>
												<td>
													<div class="status-toggle">
														<input id="service_6" class="check" type="checkbox">
														<label for="service_6" class="checktoggle">checkbox</label>
													</div>
												</td>
												<td>
													<a href="#" class="btn btn-sm bg-info-light">
														<i class="far fa-envelope mr-1"></i> 
													</a>
													<a href="{{route('edit_service_provider')}}" class="btn btn-sm bg-info-light">
														<i class="fa fa-edit mr-1"></i> 
													</a>
													<a href="#" class="btn btn-sm bg-danger-light">
														<i class="fa fa-trash mr-1"></i> 
													</a>
												</td>
											</tr>
											<tr>
												<td>7</td>
												<td>
													<a href="#">
														<img class="rounded service-img mr-1" src="{{url('public/assets/admin/img/services/service-07.jpg')}}" alt=""> Interior Designing
													</a>
												</td>
												<td>Hanover, Maryland</td>
												<td>Interior</td>
												<td>7 Sep 2020</td>
												<td>
													<div class="status-toggle">
														<input id="service_7" class="check" type="checkbox" checked>
														<label for="service_7" class="checktoggle">checkbox</label>
													</div>
												</td>
												<td>
													<a href="#" class="btn btn-sm bg-info-light">
														<i class="far fa-envelope mr-1"></i> 
													</a>
													<a href="{{route('edit_service_provider')}}" class="btn btn-sm bg-info-light">
														<i class="fa fa-edit mr-1"></i> 
													</a>
													<a href="#" class="btn btn-sm bg-danger-light">
														<i class="fa fa-trash mr-1"></i> 
													</a>
												</td>
											</tr>
											<tr>
												<td>8</td>
												<td>
													<a href="#">
														<img class="rounded service-img mr-1" src="{{url('public/assets/admin/img/services/service-08.jpg')}}" alt=""> Building Construction Services
													</a>
												</td>
												<td>Burr Ridge, Illinois</td>
												<td>Construction</td>
												<td>6 Sep 2020</td>
												<td>
													<div class="status-toggle">
														<input id="service_8" class="check" type="checkbox" checked>
														<label for="service_8" class="checktoggle">checkbox</label>
													</div>
												</td>
												<td>
													<a href="#" class="btn btn-sm bg-info-light">
														<i class="far fa-envelope mr-1"></i> 
													</a>
													<a href="{{route('edit_service_provider')}}" class="btn btn-sm bg-info-light">
														<i class="fa fa-edit mr-1"></i> 
													</a>
													<a href="#" class="btn btn-sm bg-danger-light">
														<i class="fa fa-trash mr-1"></i> 
													</a>
												</td>
											</tr>
											<tr>
												<td>9</td>
												<td>
													<a href="#">
														<img class="rounded service-img mr-1" src="{{url('public/assets/admin/img/services/service-09.jpg')}}" alt=""> Commercial Painting Services
													</a>
												</td>
												<td>Huntsville, Alabama</td>
												<td>Painting</td>
												<td>5 Sep 2020</td>
												<td>
													<div class="status-toggle">
														<input id="service_9" class="check" type="checkbox" checked>
														<label for="service_9" class="checktoggle">checkbox</label>
													</div>
												</td>
												<td>
													<a href="#" class="btn btn-sm bg-info-light">
														<i class="far fa-envelope mr-1"></i> 
													</a>
													<a href="{{route('edit_service_provider')}}" class="btn btn-sm bg-info-light">
														<i class="fa fa-edit mr-1"></i> 
													</a>
													<a href="#" class="btn btn-sm bg-danger-light">
														<i class="fa fa-trash mr-1"></i> 
													</a>
												</td>
											</tr>
											<tr>
												<td>10</td>
												<td>
													<a href="#">
														<img class="rounded service-img mr-1" src="{{url('public/assets/admin/img/services/service-10.jpg')}}" alt=""> Plumbing Services
													</a>
												</td>
												<td>Richmond, Virginia</td>
												<td>Plumbing</td>
												<td>4 Sep 2020</td>
												<td>
													<div class="status-toggle">
														<input id="service_10" class="check" type="checkbox" checked>
														<label for="service_10" class="checktoggle">checkbox</label>
													</div>
												</td>
												<td>
													<a href="#" class="btn btn-sm bg-info-light">
														<i class="far fa-envelope mr-1"></i> 
													</a>
													<a href="{{route('edit_service_provider')}}" class="btn btn-sm bg-info-light">
														<i class="fa fa-edit mr-1"></i> 
													</a>
													<a href="#" class="btn btn-sm bg-danger-light">
														<i class="fa fa-trash mr-1"></i> 
													</a>
												</td>
											</tr>
											<tr>
												<td>11</td>
												<td>
													<a href="#">
														<img class="rounded service-img mr-1" src="{{url('public/assets/admin/img/services/service-11.jpg')}}" alt=""> Wooden Carpentry Work
													</a>
												</td>
												<td>Columbus, Alabama</td>
												<td>Carpentry</td>
												<td>3 Sep 2020</td>
												<td>
													<div class="status-toggle">
														<input id="service_11" class="check" type="checkbox" checked>
														<label for="service_11" class="checktoggle">checkbox</label>
													</div>
												</td>
												<td>
													<a href="#" class="btn btn-sm bg-info-light">
														<i class="far fa-envelope mr-1"></i> 
													</a>
													<a href="{{route('edit_service_provider')}}" class="btn btn-sm bg-info-light">
														<i class="fa fa-edit mr-1"></i> 
													</a>
													<a href="#" class="btn btn-sm bg-danger-light">
														<i class="fa fa-trash mr-1"></i> 
													</a>
												</td>
											</tr>
											<tr>
												<td>12</td>
												<td>
													<a href="#">
														<img class="rounded service-img mr-1" src="{{url('public/assets/admin/img/services/service-12.jpg')}}" alt=""> Air Conditioner Service
													</a>
												</td>
												<td>Vancouver, Washington</td>
												<td>Appliance</td>
												<td>2 Sep 2020</td>
												<td>
													<div class="status-toggle">
														<input id="service_12" class="check" type="checkbox" checked>
														<label for="service_12" class="checktoggle">checkbox</label>
													</div>
												</td>
												<td>
													<a href="#" class="btn btn-sm bg-info-light">
														<i class="far fa-envelope mr-1"></i> 
													</a>
													<a href="{{route('edit_service_provider')}}" class="btn btn-sm bg-info-light">
														<i class="fa fa-edit mr-1"></i> 
													</a>
													<a href="#" class="btn btn-sm bg-danger-light">
														<i class="fa fa-trash mr-1"></i> 
													</a>
												</td>
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
	$('.far.fa-envelope').on('click',function(){
		$('#exampleModalCenter').modal('show');
	});
</script>
@endsection
