@extends('layouts/master')
@section('content')

  <!-- breadcumb Start-->
		<div class="breadcumb-area text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 p-0">
							<div class="breadcumb-img">
								<img src="{{ asset('public/assets/images/breadcumb.jpg') }}" alt="about thumb">
							</div>
							<div class="breadcumb-list">
								<ul class="list-inline">
									<li class="list-inline-item"><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right" aria-hidden="true"></i></li>
									@for($i = 0; $i <= count(Request::segments()); $i++)
									<li class="list-inline-item">
									  <a href="">{{Request::segment($i)}}</a>
									  @if($i < count(Request::segments()) & $i > 0)
										{!!'<i class="fa fa-angle-right"></i>'!!}
									  @endif
									  </li>
									@endfor
								</ul>
							</div>
                        </div>
                    </div>
                </div>
            </div>
  <!-- breadcumb End-->

	<section class="inner-pg p-5">
		<div class="container">
			<div class="row">
			<div class="col-md-7 m-auto">
				<div class="Searchbar">
			<form action="#" method="POST" enctype="multipart/form-data">
					<div class="input-group">	
						<input type="hidden" name="_token" value="#">		
						<div class="input-group-btn search-panel">
						<select class="dropdown-toggle" role="menu" name="category_name">
							<option>Category Search </option>
										<option value="Timber &amp; Carcassing">Timber &amp; Carcassing</option>
										<option value="Landscaping &amp; Fencing">Landscaping &amp; Fencing</option>
										<option value="Doors &amp; Windows">Doors &amp; Windows</option>
										<option value="Garden &amp; Waste Disposal">Garden &amp; Waste Disposal</option>
										<option value="Tools &amp; Fixings">Tools &amp; Fixings</option>
										<option value="Sheet Materials">Sheet Materials</option>
										<option value="Phenolic Resin">Phenolic Resin</option>
							</select>
						
						</div>
						<input type="hidden" name="search_param" value="all" id="search_param">         
						<input type="text" class="form-control" name="keyword" placeholder="Search term...">
						<span class="input-group-btn searchbtn">
							<input class="btn btn-default" value="Search" type="submit">
						</span>	
					</div>
				</form>					
			</div>
			</div>
		</div>
	</div>
</section>		

@endsection