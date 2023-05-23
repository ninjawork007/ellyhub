@extends('layouts/master')
@section('title')
Checkout
@endsection
@section('content')
 <!-- Slider Area Start-->  
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
 @php $user = auth()->user(); @endphp
	<div class="checkout-section">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <!-- Checkout Area Start -->
                            <div class="checkout-area ptb--60">
								  <form class="form" action="{{ route('order.submit') }}" method="POST">
                                                {{ csrf_field() }}
								 <div class="row">
                                    <div class="col-lg-7">
                                        @if (Session::get('cart'))
                                         <div class="custom-title">
                                            <h2>Billing Details</h2>
                                        </div>
                                        @if (Session::has('success'))
                                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('success') }}</p>
                                        @endif                                        
                                        <div class="checkout-form">
                                          
                                                <div class="form-row mb--30">
												
                                                    <div class="zeref-form-group col-md-6">
                                                        @auth  
														<?php   $user_name = Auth::user()->name;
															   $frst_name = explode(" ", $user_name, 2);
														?>														
                                                        <input type="text" name="fname" class="zeref-input-form" placeholder="First Name *" value="{{$frst_name[0]}}">
                                                        @else
                                                        <input type="text" name="fname" class="zeref-input-form" placeholder="First Name *" value="{{ old('fname') }}">
                                                        @endauth
                                                        @if ($errors->has('fname'))
                                                            <span class="help-block">
                                                              <p>{{ $errors->first('fname') }}</p>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="zeref-form-group col-md-6">
                                                       
														@auth  
														<?php   
															$username = Auth::user()->name.' ';
															$lst_name = explode(" ", $username, 2);
														?>														
                                                         <input type="text" name="lname" class="zeref-input-form" placeholder="Last Name *" value="{{$lst_name[1]}}">
                                                        @else
                                                        <input type="text" name="lname" class="zeref-input-form" placeholder="Last Name *" value="{{ old('lname') }}">
                                                        @endauth
                                                        @if ($errors->has('lname'))
                                                            <span class="help-block">
                                                              <p>{{ $errors->first('lname') }}</p>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-row mb--30">
                                                    <div class="zeref-form-group col-md-12">
                                                        <input type="text" name="company" class="zeref-input-form" placeholder="Company" value="{{ old('company') }}">
                                                        @if ($errors->has('company'))
                                                            <span class="help-block">
                                                              <p>{{ $errors->first('company') }}</p>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-row mb--30">
                                                    
                                                    <div class="zeref-form-group col-md-12">
                                                        
                                                        @auth   
                                                        <input type="email" name="email" id="email" class="zeref-input-form" placeholder="Email Address *" value="{{ $user->email}}">
                                                        @else
                                                        <input type="email" name="email" id="bill_email" class="zeref-input-form" placeholder="Email Address *" value="{{ old('email') }}">
                                                        @endauth
                                                        @if ($errors->has('email'))
                                                            <span class="help-block">
                                                              <p>{{ $errors->first('email') }}</p>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                              
                                                <div class="form-row mb--30">
                                                    <div class="zeref-form-group col-12">
                                                        @auth
                                                        <input type="text" name="street_address" class="zeref-input-form" placeholder="Address" value="{{ $user->address}}">
                                                        @else
                                                        <input type="text" name="street_address" class="zeref-input-form" placeholder="Address" value="{{ old('street_address') }}">
                                                        @endauth
                                                        
                                                        @if ($errors->has('street_address'))
                                                            <span class="help-block">
                                                              <p>{{ $errors->first('street_address') }}</p>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
												  <div class="form-row mb--30">
												  <div class="zeref-form-group col-md-6">
                                                        <input type="text" name="city" class="zeref-input-form" placeholder="City *" value="{{ old('city') }}">
                                                        @if ($errors->has('city'))
                                                            <span class="help-block">
                                                              <p>{{ $errors->first('city') }}</p>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="zeref-form-group col-md-6">
                                                        <input type="text" name="postcode" id="zip" class="zeref-input-form" placeholder="Postal Code *" value="{{ old('postcode') }}">
                                                        @if ($errors->has('postcode'))
                                                            <span class="help-block">
                                                              <p>{{ $errors->first('postcode') }}</p>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-row mb--30">
												<div class="zeref-form-group col-md-6">
                                                        <input type="text" class="form-control" name="country" value="" placeholder="Enter country" value="{{ old('country') }}">
                                                        @if ($errors->has('country'))
                                                            <span class="help-block">
                                                              <p>{{ $errors->first('country') }}</p>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="zeref-form-group col-md-6">
                                                        @auth
                                                        <input type="text" name="phone" class="zeref-input-form" placeholder="Telephone" value="{{$user->phone}}"> 
                                                        @else
                                                        <input type="text" name="phone" class="zeref-input-form" placeholder="Telephone" value="{{ old('phone') }}">
                                                        @endauth
                                                        @if ($errors->has('phone'))
                                                            <span class="help-block">
                                                              <p>{{ $errors->first('phone') }}</p>
                                                            </span>
                                                        @endif
                                                    </div>
                                                   
                                                </div>
                                                <div class="form-row">
                                                    <div class="zeref-form-group col-12">
                                                        <textarea class="zeref-input-form zeref-input-form--textarea" id="orderNotes" name="orderNotes" placeholder="Notes about your order, e.g. special notes for delivery.">{{ old('orderNotes') }}</textarea>
                                                        @if ($errors->has('orderNotes'))
                                                            <span class="help-block">
                                                              <p>{{ $errors->first('orderNotes') }}</p>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                           
                                        </div>
                                    </div>
                                    <div class="col-lg-5 mt-md--30">
                                        <div class="custom-title">
                                            <h2>Your Order</h2>
                                        </div>
                                        <div class="order-details mb--30">
                                            <table class="order-table">
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                 @php $total = 0; @endphp
                                    @foreach (session::get('cart') as $item)
                                                <tbody>
                                                    <tr>
                                                    <td>@php echo $item['title']; @endphp * @php echo $item['qty']; @endphp
													@if($item['variation'] != ' ')
														<ul class="nav flex-column">
														<li class="nav-item">Variations - 
														@foreach($item['variation'] as $key => $variate)
														<span class="cart_option">{{$key }} - {{ $variate }}</span>
														@endforeach
														</li>
														</ul>
													@endif</td>
													
                                                    <td>@php $item_price =  $item['price'];
                                                    $item_quenty = $item['qty'];
                                                    $product_price =$item_price*$item_quenty;
                                                    @endphp 
                                                    @php  echo '£'. number_format($product_price,2);
                                                    @endphp </td>
                                                    </tr>
                                                </tbody>
									@php $total += $item['price'] * $item['qty']; @endphp
                                    @endforeach
                                                <tfoot>
                                                    
                                                    <!--tr class="cart-subtotal">
                                                        <td>Shipping</td>
                                                        <td>$00.00</td>
                                                    </tr--->
                                                    <tr class="order-total">
                                                        <td>Order Total</td>
                                                        <td>                                                      
														
														<?php if (session()->get('alltotal')) {
															echo ' <input type="hidden" name="total_price" value="'.session()->get('alltotal').'">';
															echo '£' . number_format(session()->get('alltotal'),2);
														
														} else {
															echo ' <input type="hidden" name="total_price" value="'.$total.'">';
															echo '£' . number_format($total,2);
														}?>
                                                     </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="checkout-payment">
                                                <div class="form-row">
                                                     <div class="zeref-form-group row">
                                                       <div class="custom-radio col-md-5">
                                                            <input type="radio" name="payment_method" id="cashdelivery" class="zeref-radio-input" value="Stripe">
                                                            <label for="cashdelivery" class="zeref-radio-label"> <span></span> Stripe Payment</label>
                                                        </div>
														<div class="col-md-7">
                                                        <p class="zeref-payment-info">Pay via Stripe. You can pay with your credit card.</p>
														</div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                     <div class="zeref-form-group row">
                                                        <div class="custom-radio col-md-5">
                                                            <input type="radio" name="payment_method" id="paypal" class="zeref-radio-input" value="paypal">
                                                            <label for="paypal" class="zeref-radio-label"> <span></span> PayPal Express Checkout</label>
                                                        </div>
														<div class="col-md-7">
                                                        <p class="zeref-payment-info">Pay via PayPal. You can pay with your credit card if you don’t have a PayPal account.</p>
														</div>
                                                    </div>
                                                </div>
                                                @if ($errors->has('payment_method'))
                                                    <span class="help-block">
                                                      <p>{{ $errors->first('payment_method') }}</p>
                                                    </span>
                                                @endif
                                           
                                                <div class="col-md-12 form-group">
                                                  <div class="form-details checkbox">
                                                    <input class="form-check-input" type="checkbox" id="acept_terms" name="terms_conditions" value="1"> 
                                                    <label for="acept_terms">I accept the <a target="_blank" href="{{ url('/terms-and-conditions') }}">Terms and conditions</a></label>
                                                  </div>
                                                   @if ($errors->has('terms_conditions'))
                                                    <span class="help-block">
                                                      <p>{{ $errors->first('terms_conditions') }}</p>
                                                    </span>
                                                  @endif
                                               </div>
                                                <div class="form-row">
                                                    <div class="zeref-form-group col-12">
                                                         <button class="btn btn-style-3 btn--fullwidth" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Place Order</button>
                                                    </div>
                                                </div>
                                           
                                        </div>
                                        </div>
                                        </div>
										
										 </form>
                                         @else
                                        <h3>You have no items in your shopping cart</h3>
                                        <a href="{{ url('/categories') }}" class="btn btn-primary btn-lg">Continue Shopping</a>
                                        @endif
                                </div>
                            </div>
                            <!-- Checkout Area End -->
                        </div>
                    </div> 
                </div>     
                </div>     
                </div>     
                </div>     

@endsection
