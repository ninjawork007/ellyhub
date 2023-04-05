@extends('layouts.admin')
@section('content')
 
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Attribute List
		 
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
            <div class="col-lg-12 grid-margin stretch-card">

              <div class="card">
                @include('alerts')
                <div class="card-body">
                  <div class="col-md-12">
                    <a href="{{route('add_attribute',[$type,$id])}}" class="btn btn-outline-secondary btn-fw text-right"><i class="fa fa-plus"></i></a>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  
                  <div class="table-responsive">
 
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Value</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                          @if($attribute) 
						  @foreach($attribute as $key=>$value)
							<tr id="del_{{$value['id']}}">
							  <td>{{$value['title']}}</td>
							  <td>
								<ul class="attribute-list"> @if($value['options']) 
						                   @foreach($value['options'] as $key1=>$value1)
										      <li> {{$value1->title}}</li>
										    @endforeach
                                     @endif
								</ul>
							  </td>
							  <td>
								<div>
								  <a href="{{route('attribute_edit',$value['id'])}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i></a>
								  <a href="javascript:;" class="btn btn-outline-danger btn-sm" onclick="delete_attributes({{$value['id']}})"><i class="fa fa-trash"></i></a>
								</div>
							  </td>
							</tr>
                        @endforeach
                        @endif
                      </tbody>
                    </table>
                  
 
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
	   <script>
	  $( "body" ).addClass('sidebar-icon-only');
	  </script>
	  <script>
	  	/* delete_product_gallery*/
	var delete_attributes = function(id) {
	swal({
			title: "Are you sure?",
			text: "Once deleted, you will not be able to recover data!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		 })	
	  .then((willDelete) => {
		if (willDelete) {
		  $.ajax({
			url:'{{route("delete_attributes")}}',
			data:{id:id},
			cache:false,
			success:function(res){
			  if (res) {
				$('#del_'+id+'').fadeOut(1200).css({'background-color':'#f2dede'});
			  }
			}
		  });
		} 
	  });											 
	};
	  </script>
@endsection