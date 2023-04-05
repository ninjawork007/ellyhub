@extends('layouts.admin')

@section('content')

<div class="main-panel">

        <div class="content-wrapper">

          <h4 class="card-title">Banner</h4>

          <div class="row">

            <div class="col-lg-12 grid-margin stretch-card">



              <div class="card">

                @include('alerts')

				<div class="error"></div>

                <div class="card-body">

                  <div class="col-md-12">

                    <a href="{{route('add_banner')}}" class="btn btn-outline-secondary btn-fw text-right"><i class="fa fa-plus"></i></a>

                  </div>

                  <div class="table-responsive">



                    <table class="table table-hover">

                      <thead>

                        <tr>

                          <th>Image</th>

                          <th>Name</th>

                          <th>URL</th>

                          <th>Status </th>

                          <th>Location </th>

                          <th>Action</th>

                        </tr>

                      </thead>

                      <tbody>

                        @if(!$banner->isEmpty()) @foreach($banner as $key)

                        <tr id="{{$key->id}}">

                          <td>  

						  <?php if($key->banner){?>  <img src="{{url('public/'.$key->banner)}}" alt="image" class="bg-light" /><?php }?>

							</td>

                           <td> {{$key->title}}</td>

                           <td> {{$key->url}}</td>

							<td> 

						       <select class="form-control"  name="status" id="status">

									    <option value="yes"  data-id="{{$key->id}}" {{ ($key->status) == 'yes' ? 'selected' : '' }} >Active</option>

										<option value="no" data-id="{{$key->id}}" {{ ($key->status) == 'no' ? 'selected' : '' }} >Inactive</option>

							   </select>

							  </td>

                           <td>

   						           <label class="btn btn-outline-info btn-sm ">

									   {{ ($key->banner_type) == '1' ? 'Home Banner' : '' }} 

								       {{ ($key->banner_type) == '2' ? 'Top Banner' : '' }} 

									   {{ ($key->banner_type) == '3' ? 'Bottom Banner' : '' }}

								   </label>

                          </td>

                          <td>

						  

                           <div>

                               <a href="{{route('view_banner',[$key->id])}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i></a>

                               <a href="{{route('edit_banner',[$key->id])}}" class="btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i></a>

                               <a href="javascript:;" class="btn btn-outline-danger btn-sm" onclick="delete_row('{{$key->id}}','banner')"><i class="fa fa-trash"></i></a>

                            </div>

                          </td>

                        </tr>

                        @endforeach

                        @endif

                      </tbody>

                    </table>
                    {!! $banner->links() !!}
                  </div>

                </div>

              </div>

            </div>

          </div>

        </div>

 

      </div>

	   <script>

	  // $( "body" ).addClass('sidebar-icon-only');

	  </script> 

	  

	  <script>

	    $('body').on('change','select',function(){

		   $('.error').html('');

           var id =  $(this).find(':selected').data('id');

           var value =  $(this).find(':selected').val();

           var name =  $(this);

		  $.ajax({

			url:"{{route('banner_status')}}",

			data:{id:id,value:value},

			cache:false,

			success:function(response){

				if(response == 1){

				     $('.error').html('<div class="alert alert-info alert-dismissible fade show" role="alert">Status update successfully.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

				} else {

			         $('.error').html('<div class="alert alert-error alert-dismissible fade show" role="alert">We can use only Three Home Category !!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

			          $(name).prop('selectedIndex',0);

			  }

			}

		  });

});  

	  </script>

@endsection