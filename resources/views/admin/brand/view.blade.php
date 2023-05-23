@extends('layouts.admin')
@section('content')
<style>
body .brand-img {
    width: auto;
    max-width: -webkit-fill-available;
    border: 2px solid gray;
    padding: 5px;
	max-height: 200px;
}
</style>
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">
				 
			</h4>						   
				
		   <a href="{{route('brand_list')}}" class="btn btn-outline-info btn-sm"><i class="fa fa-arrow-left"></i></a></h4>
		   <a href="{{route('edit_brand',[$brand->id])}}" class="btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i></a>  </label>
 
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                    <div class="row">
					<div class="col-md-9">
							<?php if($brand->banner){?>
							<label class="col-form-label">  Image</label><br>
								<img src="{{url('public/'.$brand->banner)}}"    class="brand-img"/>
							<?php }?>
							 
                           
                        </div>
                       <div class="col-md-3">
							<label class="col-sm-12 col-form-label">Title :  {{$brand->title}} </label>
							<label class="col-sm-12 col-form-label">Status : 
							  @if($brand->status  == 'yes' ) 
								 <label class="btn btn-outline-primary btn-sm "> Active </label>
							 @else
								 <label class="btn btn-outline-danger btn-sm "> Inactive </label>
							 @endif 
						   </label>
                        </div>
                      </div>
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
@endsection