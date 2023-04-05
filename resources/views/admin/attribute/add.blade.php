@extends('layouts.admin')
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Add Attribute
		   </br>
		          @if($type == 'category')
					Category :	 {{ App\Http\Controllers\CommonController::getCategoryName($id) }}
				  @elseif($type == 'sub_category')
					Sub Category :	{{ App\Http\Controllers\CommonController::getSubCategoryName($id) }}
				  @else
					 Child Category :  {{ App\Http\Controllers\CommonController::getChildCategoryName($id) }}
				  @endif 
		  </h4>
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <form class="form-sample" method="post" action="{{route('save_attribute')}}" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="value" value="1" id="value">
                    <input type="hidden" name="type" value="{{$type}}">
                    <input type="hidden" name="id" value="{{$id}}">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Title</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" id="title" name="name">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Option</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" id="title" name="option[]">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <a href="javascript:;" class="btn btn-outline-primary btn_add"><i class="fa fa-plus"></i></a>
                      </div>
                    </div>
                    <div class="row add_div"></div>
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
        $('.btn_add').click(function(){
          var val = parseInt($('#value').val()) + 1;
          var html = '<div class="col-md-6" id="removediv'+val+'"><div class="form-group row"><label class="col-sm-3 col-form-label">Option</label><div class="col-sm-9"><input type="text" class="form-control" required="" id="title" name="option[]"></div></div></div><div class="col-md-2" id="removebtndiv'+val+'"><a href="javascript:;" class="btn btn-outline-danger btn_remove" data-id="'+val+'"><i class="fa fa-minus"></i></a></div>';
          $('.add_div').append(html);
          console.log(val);
          $('#value').val(val);
        });

        $('body').on('click','.btn_remove',function(){
          $('#removediv'+$(this).attr('data-id')).remove();
          $('#removebtndiv'+$(this).attr('data-id')).remove();
        });
      </script>
@endsection