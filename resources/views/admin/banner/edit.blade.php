@extends('layouts.admin')
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Edit Banner  </h4>
		  <a href="{{route('banner_list')}}" class="btn btn-outline-info btn-sm"><i class="fa fa-arrow-left"></i></a></h4>
          <a href="{{route('view_banner',[$banner->id])}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i></a>
		          
		 <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <form class="form-sample" method="post" action="{{route('update_banner')}}" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
					<input type="hidden" value="{{$banner->id}}" name="id">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Title</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" id="title"  value="{{$banner->title}}" name="title">
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Banner Type</label>
                          <div class="col-sm-9">
							<select  name="banner_type"  required="" id="banner_type"  class="form-control">
								<option  disabled >Select Type</option>
								<option value="1"  {{ ($banner->banner_type) == '1' ? 'selected' : '' }}>Home Banner</option>
								<option value="2"  {{ ($banner->banner_type) == '2' ? 'selected' : '' }}>Top Banner</option>
								<option value="3"  {{ ($banner->banner_type) == '3' ? 'selected' : '' }}>Bottom Banner</option>
							</select>
							 
							   
                          </div>
                        </div>
                      </div>
                    </div> 
					
					<div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">URL</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" id="url"  value="{{$banner->url}}"  name="url">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Status  </label>
                          <div class="col-sm-9">
                            <div class="bs-example">
								<div class="btn-group btn-group-toggle" data-toggle="buttons">
									<label class="btn btn-rounded btn-outline-primary btn-sm  {{ ($banner->status) == 'yes' ? 'active' : '' }}">
										<input type="radio" name="status" value="yes" autocomplete="off"  {{ ($banner->status) == 'yes' ? 'checked' : '' }} > Active
									</label>
									<label class="btn btn-rounded btn-outline-danger btn-sm {{ ($banner->status) == 'no' ? 'active' : '' }}">
										<input type="radio" name="status" value="no" autocomplete="off"  {{ ($banner->status) == 'no' ? 'checked' : '' }}>  Inactive
									</label>
								</div>
							</div>
                          </div>
                        </div>
                      </div>

                    </div>
					
					<div class="row">
                      
                      
                       <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">  Web Image</label>
                          <div class="col-sm-6">
                            <input class="form-control" type="file"  accept="image/x-jpg,image/jpeg,image/png" name="banner">
                            <small> only JPG, JPEG , PNG images are allowed</small>
                          </div>
						  <div class="col-sm-3">
                             <?php if($banner->banner){?><img src="{{url(''.$banner->banner)}}"  id="product_img" class="edit_img" /><?php }?>
                          </div>
						  
						  
                        </div>
                      </div>
					  
					   <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">  Mobile Image</label>
                          <div class="col-sm-6">
                            <input class="form-control" type="file"  accept="image/x-jpg,image/jpeg,image/png" name="m_banner">
                            <small> only JPG, JPEG , PNG images are allowed</small>
						  </div>
						  <div class="col-sm-3">
                           <?php if($banner->m_banner){?><img src="{{url(''.$banner->m_banner)}}"  id="banner_img" class="edit_img" /><?php }?>
                          </div>
                        </div>
                      </div>
					  
                    </div>
 
                    <div class="row col-md-12">
                      <input type="submit" class="btn btn-outline-primary btn-fw pull-right" value="Update">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        <script>
	  $( "body" ).addClass('sidebar-icon-only');
	  </script>
@endsection