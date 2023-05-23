@extends('layouts/master')
@section('content')
 <!-- Slider Area Start-->  
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
  <section class="dashboard-counts section-padding p-5">
      <div class="container">
  <div class="content-box">
      <div class="row">
         <div class="col-md-7 m-auto order-track">
			       <div class="card-body">   
            
                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
                    <?php $total = 0;
                        foreach (session::get('cart') as $item){
                         
                            $item_price =  $item['price'];
                            $item_quenty = $item['qty'];
                            $product_price =$item_price*$item_quenty;
                             $total += $product_price;
                        }
                    
                   ?>
				   
                        <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation"
                                                     data-cc-on-file="false"
                                                    data-stripe-publishable-key="pk_test_DgdUCjmRXobZkGz4EulhHLNJ00xowCHlpn"
                                                    id="payment-form">
                        @csrf
  
                        <div class='form-group row'>
                            <div class='col-xs-12 col-md-6 form-group required'>
                                <label class='control-label'>Name on Card</label> 
								<input class='form-control' size='4' type='text'>
                            </div>
                       
                            <div class='col-xs-12 col-md-6 form-group card required'>
                                <label class='control-label'>Card Number</label> <input
                                    autocomplete='off' class='form-control card-number' size='20'
                                    type='text'>
                            </div>
                     
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVC</label> 
								<input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Month</label> <input
                                    class='form-control card-expiry-month' placeholder='MM' size='2'
                                    type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Year</label> <input
                                    class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                    type='text'>
                            </div>
                        </div>
                        
                        <div class='form-group row'>
                            <div class='col-md-12 error form-group hide'>
                                <div class='alert-danger alert'>Please correct the errors and try
                                    again.</div>
                            </div>
                        </div>
  
                        <div class='form-group row order-s-btn'>
                        <div class='col-xs-12 col-md-4'>
                          <input type="hidden" class='form-control' name="order_id" value="<?php echo $lastId; ?>">
							<?php if (session()->get('alltotal')) {				
									$total = session()->get('alltotal');
								} else {
									$total;
								}?>
                        <button class='btn btn-primary btn-lg btn-block' type='submit'>Pay Now 	£<?php echo number_format($total, 2); ?></button>
                        </div>
                        </div>                          
                    </form>
       
              </div>
          </div>
      </div>
  </div>                 
  </div>  
</section>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>  
<script type="text/javascript">
$(function() {
    var $form  = $(".require-validation");
  $('form.require-validation').bind('submit', function(e) {
    var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('hide');
 
        $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
      var $input = $(el);
      if ($input.val() === '') {
        $input.parent().addClass('has-error');
        $errorMessage.removeClass('hide');
        e.preventDefault();
      }
    });
  
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
      }, stripeResponseHandler);
    }
  
  });
  
  function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
  
});
</script>  
@endsection
