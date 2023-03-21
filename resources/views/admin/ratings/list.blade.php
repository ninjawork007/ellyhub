@extends('layouts.admin')
@section('content')
<div class="page-wrapper">
			<div class="content container-fluid">
			
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col">
							<h3 class="page-title">Ratings</h3>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-hover table-center mb-0 datatable">
										<thead>
											<tr>
												<th>#</th>
												<th>Date</th>
												<th>User</th>
												<th>Provider</th>
												<th>Service</th>
												<th>Type Name</th>
												<th>Ratings</th>
												<th>Comments</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td>13 Sep 2020</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/customer/user-04.jpg')}}">
														</a>
														<a href="javascript:void(0);">Ricardo Lung</a>
													</span>
												</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/provider/provider-04.jpg')}}">
														</a>
														<a href="javascript:void(0);">Ricardo Flemings</a>
													</span>
												</td>
												<td>Steam Car Wash</td>
												<td>Normal</td>
												<td>4.0</td>
												<td>Good Work</td>
											</tr>
											<tr>
												<td>2</td>
												<td>12 Sep 2020</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/customer/user-05.jpg')}}">
														</a>
														<a href="javascript:void(0);">Annette Silva</a>
													</span>
												</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/provider/provider-05.jpg')}}">
														</a>
														<a href="javascript:void(0);">Maritza Wasson</a>
													</span>
												</td>
												<td>House Cleaning Services</td>
												<td>Excellent</td>
												<td>5.0</td>
												<td>Best Work</td>
											</tr>
											<tr>
												<td>3</td>
												<td>11 Sep 2020</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/customer/user-06.jpg')}}">
														</a>
														<a href="javascript:void(0);">Stephen Wilson</a>
													</span>
												</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/provider/provider-06.jpg')}}">
														</a>
														<a href="javascript:void(0);">Marya Ruiz</a>
													</span>
												</td>
												<td>Computer & Server AMC Service</td>
												<td>Excellent</td>
												<td>5.0</td>
												<td>Excellent Service</td>
											</tr>
											<tr>
												<td>4</td>
												<td>10 Sep 2020</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/customer/user-07.jpg')}}">
														</a>
														<a href="javascript:void(0);">Ryan Rodriguez</a>
													</span>
												</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/provider/provider-07.jpg')}}">
														</a>
														<a href="javascript:void(0);">Richard Hughes</a>
													</span>
												</td>
												<td>Interior Designing</td>
												<td>Excellent</td>
												<td>5.0</td>
												<td>Thanks</td>
											</tr>
											<tr>
												<td>5</td>
												<td>9 Sep 2020</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/customer/user-08.jpg')}}">
														</a>
														<a href="javascript:void(0);">Lucile Devera</a>
													</span>
												</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/provider/provider-08.jpg')}}">
														</a>
														<a href="javascript:void(0);">Nina Wilson</a>
													</span>
												</td>
												<td>Building Construction Services</td>
												<td>Excellent</td>
												<td>5.0</td>
												<td>Amazing</td>
											</tr>
											<tr>
												<td>6</td>
												<td>8 Sep 2020</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/customer/user-09.jpg')}}">
														</a>
														<a href="javascript:void(0);">Roland Storey</a>
													</span>
												</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/provider/provider-09.jpg')}}">
														</a>
														<a href="javascript:void(0);">David Morrison</a>
													</span>
												</td>
												<td>Commercial Painting Services</td>
												<td>Normal</td>
												<td>4.0</td>
												<td>Great!</td>
											</tr>
											<tr>
												<td>7</td>
												<td>7 Sep 2020</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/customer/user-10.jpg')}}">
														</a>
														<a href="javascript:void(0);">Lindsey Parmley</a>
													</span>
												</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/provider/provider-10.jpg')}}">
														</a>
														<a href="javascript:void(0);">Linda Brooks</a>
													</span>
												</td>
												<td>Plumbing Services</td>
												<td>Good</td>
												<td>5.0</td>
												<td>Good Support</td>
											</tr>
											<tr>
												<td>8</td>
												<td>6 Sep 2020</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/customer/user-01.jpg')}}">
														</a>
														<a href="javascript:void(0);">Jeffrey Akridge</a>
													</span>
												</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/provider/provider-01.jpg')}}">
														</a>
														<a href="javascript:void(0);">Thomas Herzberg</a>
													</span>
												</td>
												<td>Toughened Glass Fitting Services</td>
												<td>Good</td>
												<td>4.0</td>
												<td>Goooodddd!!</td>
											</tr>
											<tr>
												<td>9</td>
												<td>5 Sep 2020</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/customer/user-02.jpg')}}">
														</a>
														<a href="javascript:void(0);">Nancy Olson</a>
													</span>
												</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/provider/provider-02.jpg')}}">
														</a>
														<a href="javascript:void(0);">Matthew Garcia</a>
													</span>
												</td>
												<td>Car Repair Services</td>
												<td>Excellent</td>
												<td>5.0</td>
												<td>Good</td>
											</tr>
											<tr>
												<td>10</td>
												<td>4 Sep 2020</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/customer/user-03.jpg')}}">
														</a>
														<a href="javascript:void(0);">Ramona Kingsley</a>
													</span>
												</td>
												<td>
													<span class="table-avatar">
														<a href="#" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" alt="" src="{{url('public/assets/admin/img/provider/provider-03.jpg')}}">
														</a>
														<a href="javascript:void(0);">Yolanda Potter</a>
													</span>
												</td>
												<td>Electric Panel Repairing Service</td>
												<td>Nice Work</td>
												<td>4.0</td>
												<td>-</td>
											
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
<script src="{{url('public/assets/admin/js/moment.min.js')}}"></script>
<script src="{{url('public/assets/admin/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{url('public/assets/admin/plugins/datatables/datatables.min.js')}}"></script>
@endsection
