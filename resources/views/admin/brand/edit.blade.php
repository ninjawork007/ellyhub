@extends('layouts.admin')
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Edit Brand  </h4>
		  <a href="{{route('brand_list')}}" class="btn btn-outline-info btn-sm"><i class="fa fa-arrow-left"></i></a></h4>
          <a href="{{route('view_brand',[$brand->id])}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i></a>
		          
		 <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <form class="form-sample" method="post" action="{{route('update_brand')}}" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
					<input type="hidden" value="{{$brand->id}}" name="id">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Title</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" id="title"  value="{{$brand->title}}" name="title">
                            
                          </div>
                        </div>
                      </div>
                       
                    </div> 
					
					<div class="row">
                       
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Status  </label>
                          <div class="col-sm-9">
                            <div class="bs-example">
								<div class="btn-group btn-group-toggle" data-toggle="buttons">
									<label class="btn btn-rounded btn-outline-primary btn-sm  {{ ($brand->status) == 'yes' ? 'active' : '' }}">
										<input type="radio" name="status" value="yes" autocomplete="off"  {{ ($brand->status) == 'yes' ? 'checked' : '' }} > Active
									</label>
									<label class="btn btn-rounded btn-outline-danger btn-sm {{ ($brand->status) == 'no' ? 'active' : '' }}">
										<input type="radio" name="status" value="no" autocomplete="off"  {{ ($brand->status) == 'no' ? 'checked' : '' }}>  Inactive
									</label>
								</div>
							</div>
                          </div>
                        </div>
                      </div>

                    </div>
					
					<div class="row"> 
					   <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label"> Image</label>
                          <div class="col-sm-6">
                            <input class="form-control" type="file" onchange="readURL(this);"   accept="image/x-jpg,image/jpeg,image/png" name="banner">
                            <small> only JPG, JPEG , PNG images are allowed</small>
						  </div>
						  <div class="col-sm-3">
                           <?php if($brand->banner){?>
						        <img src="{{url('public/'.$brand->banner)}}"  id="show_img" class="edit_img" />
						   <?php }  ?>
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