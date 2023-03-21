@extends('layouts/master')
@section('title')
Contact Us
@endsection
@section('description')
Contact Us description
@endsection
@section('keywords')
Contact
@endsection
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
  
  <div class="contact-info pt-5">
	<div class="container">
		<div class="contact-info-wrapper clearfix">
			<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="contact-item-wrapper">
					<h4>Address</h4>
				<div class="info">
					<div class="icon">
					<i class="fa fa-map-marker" aria-hidden="true"></i>
					</div>
					<p>Builders Marketplace Ltd,<br> Merchant House, 44 Berth, Port of<br> Tilbury, Essex, RM18 7HP | 11513927</p>
				</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="contact-item-wrapper">
					<h4>Phone</h4>
				<div class="info">
					<div class="icon">
					<i class="fa fa-mobile" aria-hidden="true"></i>
					</div>
					<p><a href="tel:020 8617 8979">020 8617 8979</a> </p>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="contact-item-wrapper">
					<h4>E-mail</h4>
				<div class="info">
					<div class="icon">
					<i class="fa fa-envelope" aria-hidden="true"></i>
					</div>
					<p><a href="mailto:sales@buildersmerchant.com">sales@buildersmerchant.com</a></p>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<div class="contact-form" id="contact_form">
		<div class="col-md-6 m-auto">
					<div class="header-wrap text-center">
						<div class="mainHeading text-uppercase text-center mb-3">Got a Question?</div>
						<p class="description">Call us today or complete the enquiry form below:</p>
					</div>
					@if (Session::has('success'))
	                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('success') }}</p>
	              	@endif	
                    <form method="POST" class="login-form" action="{{ route('common.contactus.store') }}">
                    	  {{ csrf_field() }}
						<div class="row">
						<div class="form-group col-md-12">
						   <input id="name" type="name" class="form-control" name="name" placeholder="Name">  
						   @if ($errors->has('name'))
                        <span class="help-block">
                          <p>{{ $errors->first('name') }}</p>
                        </span>
                      @endif                              
                        </div>
                        <div class="form-group col-md-12">
                            <input id="email" type="email" class="form-control" name="email" value="" placeholder="E-Mail Address">
                            @if ($errors->has('email'))
                        <span class="help-block">
                          <p>{{ $errors->first('email') }}</p>
                        </span>
                      @endif
                        </div>
						<div class="form-group col-md-12">
							<input id="tel" type="tel" class="form-control" name="tel" placeholder="Phone Number">                                
                        </div>
						<div class="form-group col-md-12">
							<textarea id="message" type="text" class="form-control" name="message" placeholder="Message"></textarea>  
							@if ($errors->has('message'))
                        <span class="help-block">
                          <p>{{ $errors->first('message') }}</p>
                        </span>
                      @endif                           
                        </div>
						<div class="form-group col-md-5 m-auto">
                             <button type="submit" class="form-control btn btn-primary loginButton">Send</button>
							
                             </div> 
                        </div>
                    </form>
         
		</div>
	</div>
	<div class="col-md-12 contact-map p-0">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2485.6341436131506!2d0.34328131530657907!3d51.46487332163337!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47d8b6399e420c8f%3A0xf2371e99f9c941a!2sBuilders+Marketplace!5e0!3m2!1sen!2sin!4v1561460541607!5m2!1sen!2sin" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
			</div>
</div>
  @endsection