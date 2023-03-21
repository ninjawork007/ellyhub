@extends('layouts.web')

@section('content')
<main class="no-main">
        <nav class="amrcart-breadcrumb">
    <a href="{{url('/')}}">Home</a>
    <span class="delimiter">
        <i class="icon amr-breadcrumbs-arrow-right"></i>
        
    </span>Contact Us
   
</nav>
        <section class="section--contact">
            <div class="container">
                <h2 class="page__title">Contact Us</h2>
                <div class="contact__content">
                    <div class="row">
                        <div class="col-12 col-lg-7">
                            <div class="row">
                                <div class="col-12">
                                    <div class="contact__map">
                                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29099.895304502938!2d92.13435148869519!3d24.259717973830202!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3751f32e1d3f7f61%3A0x9ff16415aefcf6c7!2sPanisagar%2C%20Tripura%20799260!5e0!3m2!1sen!2sin!4v1620966146175!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                    </div>
                                </div>
                               
                               
                            </div>
                        </div>
                        <div class="col-12 col-lg-5">
                        	@include('alerts')
                            <form method="post" data-parsley-validate="" action="{{route('save_contactus')}}">
                            	@csrf
                                <div class="contact__form">
                                    <h3 class="contact__title">Contact Form</h3>
                                    <p>please send us a message by filling out the form below and we will get back with you shortly.</p>
                                    <div class="form-row">
                                        <div class="col-12 form-group--block">
                                            <label>Name: <span>*</span></label>
                                            <input class="form-control" type="text" required name="name">
                                        </div>
                                        <div class="col-12 form-group--block">
                                            <label>Email: <span>*</span></label>
                                            <input class="form-control" type="text" required name="email">
                                        </div>
                                        <div class="col-12 form-group--block">
                                            <label>Subject (optional): </label>
                                            <input class="form-control" type="text" name="subject" required="">
                                        </div>
                                        <div class="col-12 form-group--block">
                                            <label>Message: <span>*</span></label>
                                            <textarea class="form-control" name="message"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn ps-button contact__send">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>		
@endsection

