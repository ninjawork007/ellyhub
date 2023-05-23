@extends('layouts/master')
@section('title')
Cart
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


<div class="cart-section">
                <div class="container">
                    <div class="row">
                        @if(session('success'))
                            <div class="alert alert-success col-md-7 m-auto">
                                {{ session('success') }}
                            </div>
                        @endif
                         <?php $total = 0 ?>
                                  @if (Session::get('cart'))
                        <div class="col-12 cart-tab">
                                <div class="table-content table-responsive">
                                      <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="plantmore-product-thumbnail">Images</th>
                                                <th class="cart-product-name">Product</th>
                                                <th class="plantmore-product-price">Price</th>
                                                <th class="plantmore-product-quantity">Quantity</th>
                                                <th class="plantmore-product-subtotal">Total</th>
                                                <th class="plantmore-product-remove">remove</th>
                                            </tr>
                                        </thead>
                                                     
                                        @foreach(Session::get('cart') as $details) 
                                        <?php // echo '<pre>'; print_r($details); die;
                                        $total += $details['price'] * $details['qty'] ?>
									
                                    <tbody>                               
                                            <tr>
                                                <td class="plantmore-product-thumbnail">
                                                    <a href="#">
                                                    <img src="{{ url('/public/images/product_images') . '/' . $details['image'] }}" alt="">
                                                    </a>
                                                </td>
                                                <td class="plantmore-product-name">{{ $details['title'] }}
													@if($details['variation'] != ' ')
														<ul class="nav flex-column">
														<li class="nav-item">Variations - 
														@foreach($details['variation'] as $key => $variate)
														<span class="cart_option">{{$key }} - {{ $variate }}</span>
														@endforeach
														</li>
														</ul>
													@endif
												</td>
                                                <td class="plantmore-product-price"><span class="amount">£{{ $details['price'] }}</span>
                                                </td>
                                                <td class="plantmore-product-quantity">
                                                 <input type="number" name="qty" value="{{ $details['qty'] }}" class="form-control quantity" />
                                                </td>
                                                <td class="product-subtotal"><span class="amount">£{{ number_format($details['price'] * $details['qty'], 2) }}</span></td>  
												<td><ul class="list-inline d-flex justify-content-center">
													<li class="list-inline-item plantmore-product-update update-cart" data-id="{{ $details['id'] }}"><a href="#"><i class="fa fa-refresh"></i></a></li>
													<li class="list-inline-item plantmore-product-remove remove-from-cart" data-id="{{ $details['id'] }}"><a href="#"><i class="fa fa-times"></i></a></li>
												    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                            
                                    </tbody>
                                    </table>
                                </div> 
                                <!---div class="row">
                                    <div class="col-12">
                                        <div class="coupon-all">
                                            <div class="coupon">
                                                <input id="coupon_code" class="input-text" name="coupon_code" value="" placeholder="Coupon code" type="text">
                                                <input class="button" name="apply_coupon" value="Apply coupon" type="submit">
                                            </div>
                                        </div>
                                    </div>
                                </div--->
                                <div class="row">
                                    <div class="col-md-5 total-cart">
                                        {{ cart_total()}}
                                       <!--  <div class="cart-page-total">
                                            <h2>Cart totals</h2>
                                            <ul>

                                        <?php //echo '<pre>'; print_r($details);die; ?>
                                                <li>Subtotal <span>${{ $total }}</span></li>
                                                <li>Shipping <span>${{ $total }}</span></li>
                                                <li>Total <span>${{ $total }}</span></li>
                                            </ul>
                                            <a href="{{ url('/checkout') }}">Proceed to checkout</a>
                                        </div> -->
                                    </div>
                               </div>  
                    
                </div>
                 @else
                        <div class="col-md-7 m-auto">
							<h3>You have no items in your shopping cart</h3>
							<a href="{{ url('/categories') }}" class="btn btn-primary btn-lg">Continue Shopping</a>
						</div>
                @endif
                    </div>
                </div>
            </div>
       



<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script type="text/javascript">
$( document ).ready(function() {
        $(".update-cart").click(function (e) {
           e.preventDefault();
           var ele = $(this);
           
            $.ajax({
               url: '{{ url('update-cart') }}',
               method: "patch",
               data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), qty: ele.parents("tr").find(".quantity").val()},
               success: function (response) {
                 window.location.reload();
               }
            });
        });

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);

            if(confirm("Are you sure")) {
                $.ajax({
                    url: '{{ url('remove-from-cart') }}',
                     headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                    method: "DELETE",
                    data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                    success: function (response) {
                         console.log("it Work");
                            if(response==true){
                                swal("Deleted!", "Your imaginary file has been deleted.", "success");
                            }
                        window.location.reload();
                    }
                });
            }
        });
});
    </script>
@endsection