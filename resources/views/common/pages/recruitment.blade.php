@extends('layouts/master')
@section('title')
{{ $data[0]['seo_title'] }}
@endsection
@section('description')
{{ $data[0]['seo_desc'] }}@endsection
@section('keywords')
{{ $data[0]['seo_key'] }}@endsection
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
  
  <section class="inner-sec sec-padding">
            <div class="container">
					<div class="row align-items-center m-auto">
						<div class="col-lg-12 mainHeading text-uppercase text-center mb-3">
							{{ $data[0]['title'] }}
						</div>
                    <div class="col-lg-10 m-auto pt-4">
						<div class="row">
						{!! $data[0]['description'] !!}

						</div>
                   </div>
				</div>
				</div>
           </div>
		</section>
  @endsection