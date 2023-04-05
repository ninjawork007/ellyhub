@extends('layouts.admin')
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Add Child Category</h4>
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <form class="form-sample" method="post" action="{{route('save_child_category')}}" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
					
                      <div class="col-md-12" >
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Category</label>
                          <div class="col-sm-9">
                            <select class="form-control" required=""  name="category">
                              <option value="">Select category</option>
                              @foreach($category as $key)
                              <option value="{{$key->id}}" >{{$key->name}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
					
					 <div class="row" id="subcategory">
                         <div class="col-md-12" >
						 <div class="form-group row">
							 <label class="col-sm-3 col-form-label">
							 Sub Category<span>*</span>	 </label>
							 <div class="col-sm-9">
							 <select class="form-control" required="" name="sub_category" id="sub_category">
							 <option value="">Select Sub Category</option> 
							 </select>
							 </div>
						   </div>
					      </div>
					 </div>
					
					<div class="row">
					  <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required=""  placeholder="Child Category Name" name="name">
                          </div>
                        </div>
                      </div>
                       
 
                    <div class="row col-md-12">
                      <input type="submit" class="btn btn-outline-primary btn-fw pull-right" value="Submit">
                    </div>
                    </div>
					
				 
					
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © {{date('Y')}} <a href="javascript:;" target="_blank">openinvite</a>. All rights reserved.</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <script>
        $('#title').change(function(e) {
          $('#slug').val(convertToSlug($(this).val()));
        });

        function convertToSlug(Text){
            return Text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
        }
		
				/* On Change Status of Category*/
        $('select[name="category"]').change(function(){
          if ($(this).val()=='') {
            alert("Please select Category");
            return false;
          }
          $.ajax({
            url:"{{route('get_sub_category')}}",
            data:{id:$(this).val()},
            cache:false,
            success:function(response){
              var ress = JSON.parse(response);
			         $('#subcategory').html(ress.data);
				 //$('#subcategory').html("<div class='col-md-12' ><div class='form-group row'><label class='col-sm-3 col-form-label'>Sub Category<span>*</span>	 </label><div class='col-sm-9'><select class='form-control' required="" name='sub_category' id='sub_category'><option value="">Select Sub Category</option> </select></div></div></div>");
              
		    }
          });
        });
		
		
      </script>
@endsection