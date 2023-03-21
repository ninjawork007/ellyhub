
@extends('layouts.admin')
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Add Sub Category</h4>
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <form class="form-sample" method="post" action="{{route('update_sub_category')}}" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$sub_category->id}}">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Category</label>
                          <div class="col-sm-9">
                            <select class="form-control" required=""  name="category">
                              <option value="">Select category</option>
                              @foreach($category as $key)
                              <option value="{{$key->id}}" <?php if($sub_category->category_id==$key->id){ echo 'selected';}?>>{{$key->name}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" id="title" name="name" value="{{$sub_category->title}}">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row"> 
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Category Banner</label>
                          <div class="col-sm-6">
                            <input class="form-control" type="file" accept="image/x-jpg,image/jpeg" name="banner">
                            <small> only JPG, JPEG images are allowed</small>
                          </div>
						   <div class="col-sm-3">
                             <?php if($sub_category->banner){?><img src="{{url('public/'.$sub_category->banner)}}"  id="banner_img" class="edit_img" /><?php }?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row col-md-12">
                      <input type="submit" class="btn btn-outline-primary btn-fw pull-right" value="Submit">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
       
        <!-- partial -->
      </div>
	   <script>
	  $( "body" ).addClass('sidebar-icon-only');
	  </script>
	  
      <script>
        $('#title').change(function(e) {
          $('#slug').val(convertToSlug($(this).val()));
        });

        function convertToSlug(Text){
            return Text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
        }
      </script>
@endsection