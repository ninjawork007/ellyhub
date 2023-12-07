@extends('layouts.admin')
@section('content')
<style>
body .banner-img {
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
				{{ ($banner->banner_type) == '1' ? 'Home Banner' : '' }} 
				{{ ($banner->banner_type) == '2' ? 'Top Banner' : '' }} 
				{{ ($banner->banner_type) == '3' ? 'Bottom Banner' : '' }} 
			</h4>						   
				
		   <a href="{{route('banner_list')}}" class="btn btn-outline-info btn-sm"><i class="fa fa-arrow-left"></i></a></h4>
		   <a href="{{route('edit_banner',[$banner->id])}}" class="btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i></a>  </label>
							
		  
		   
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                    <div class="row">
					<div class="col-md-9">
							<?php if($banner->banner){?>
							<label class="col-form-label">Web Image</label><br>
								<img src="{{url('public/'.$banner->banner)}}"    class="banner-img"/>
							<?php }?>
							<?php if($banner->m_banner){?>
							<label class="col-form-label">Mobile Image</label><br>
								<img src="{{url('public/'.$banner->m_banner)}}"    class="banner-img"/>
							<?php }?>
                           
                        </div>
                       <div class="col-md-3">
							<label class="col-sm-12 col-form-label">Details :  
							<label class="col-sm-12 col-form-label">Title :  {{$banner->title}} </label>
							<label class="col-sm-12 col-form-label"> Type :
							           {{ ($banner->banner_type) == '1' ? 'Home Banner' : '' }} 
								       {{ ($banner->banner_type) == '2' ? 'Top Banner' : '' }} 
									   {{ ($banner->banner_type) == '3' ? 'Bottom Banner' : '' }} </label>
							<label class="col-sm-12 col-form-label">URL :  {{$banner->url}} </label>
							<label class="col-sm-12 col-form-label">Status : 
												 @if($banner->status  == 'yes' ) 
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