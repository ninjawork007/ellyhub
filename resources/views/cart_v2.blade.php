@extends('layouts.web')
@section('pagebodyclass')
    single-product full-width normal
@endsection
@section('content')

    <section id="primary" class="section content-area">
        <div id="main" class="container cart_v2">
            @include('common.alerts')
            @if(!$cart->isEmpty())
                <div class="row pb-3">
                    <div class="col-md-6">
                        <h2 class="heading"><i class="fa fa-shopping-cart"></i> &nbsp;{{$cart->count()}} Items in your cart</h2>
                    </div>
                    <div class="col-md-6 text-end">
                        <h4 class="heading-shopping">Keep Shopping &nbsp;<i class="fa fa-arrow-right"></i></h4>
                    </div>
                </div>
                <hr class="mb-4" style="background-color: #2f2f2f;"/>

                <div class="radio_cart">
                    <div class="row border mb-4 align-items-center p-3 active">
                        <div class="col-md-6">
                            <label class="text-black"><input type="radio" checked name="type" value="debit"> Debit or Credit Card</label>
                        </div>
                        <div class="col-md-6 text-end">
                            <img src="{{url('public/assets/web/images/cards.png')}}" class="img-fluid">
                        </div>
                    </div>
                    <div class="row border mb-4 align-items-center p-3">
                        <div class="col-md-6">
                            <label class="text-black"><input type="radio" name="type" value="paypal"> Your Paypal Account</label>
                        </div>
                        <div class="col-md-6 text-end">
                            <img src="{{url('public/assets/web/images/paypal.png')}}" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="cart_listing mt-5">
                    <h3 class="heading">items listed in $USD</h3>

                    <div class="border p-3 mt-4" style="border-radius: 10px;">
                        @foreach($cart as $key)
                            <div class="row">
                                <div class="col-md-2 my-auto">
                                    <div class="cart-img">
                                    @if($key->is_uploaded)
                                        <?php $image_array = explode(',',$key->image); ?>
                                        <img src="{{$image_array[0]}}" class="img-fluid">
                                    @else
                                        <img src="{{url('public/'.$key->image)}}" class="img-fluid">
                                    @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{url('/product/'.$key->product_id)}}" class="text-black font-weight-bolder">{{$key->product_name}}</a>

                                    <p class="text-black pt-3 font-bold mb-0">SOLD BY <br><a href="#" class="text-blue">{{$key->name}}</a></p>
                                    <p class="text-black pt-3 font-bold mb-0">{{$key->complete_address}}</p>
                                    <?php
                                    $stock = $key->quantity;
                                    ?>
                                    <div class="col-md-2">
                                        <select class="form-control" name="quantity" id="detail_input{{$key->id}}">
                                            <?php
                                            for ($i = 1; $i <= $key->stock; $i++){
                                                $selected = ($key->quantity == $i) ? "selected" : "";
                                                echo '<option value="' . $i . '" '.$selected.'>' . $i . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="mt-3">
                                        <a href="javascript:;" onclick="add_wishlist('{{$key->id}}','wishlist')" class="text-black"><i class="fa fa-heart" aria-hidden="true"></i> Move to Watch List</a> &nbsp;&nbsp;&nbsp;
                                        <a href="javascript:;" onclick="remove_cart_item({{$key->id}})" class="text-black" data-id="{{$key->id}}"><i class="fa fa-times" aria-hidden="true"></i> Remove</a>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <a href="#" class="text-blue">Pay only this seller</a>
                                </div>
                                <div class="col-md-2 text-end">
                                    <p class="text-black mb-0 font-bold">${{$key->sale_price}}</p>
                                    <p class="text-shipping mb-0">+ {{(empty($key->shipping_charges)) ? "+ $".$key->shipping_charges : "Free Shipping"}}</p>
                                    <p class="text-tax">+ applicable tax</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="cart_total p-4 background-silver text-md-end text-lg-end text-center text-black">
                        <p class="text-shipping mb-0">Item + Shipping Subtotal <span class="text-black font-bold">${{number_format($total, 2)}}</span></p>
                        <button type="submit" style="background-color: transparent"><img src="{{url('public/assets/web/images/paypal_submit.png')}}" class="img-fluid"></button>or
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{url('checkout')}}" class="btn btn-dark font-bold">Proceed to Checkout &nbsp;&nbsp;<i class="fa fa-arrow-right"></i></a><br>
                        <img src="{{url('public/assets/web/images/cards_transparent.png')}}" class="img-fluid" style="">
                    </div>
                </div>
                <!--<div class="cart-wrapper">
                    <div class="amr-cart-form">
                        <table class="shop_table shop_table_responsive cart">
                            <thead>
                            <tr>
                                <th class="product-remove">&nbsp;</th>
                                <th class="product-thumbnail">&nbsp;</th>
                                <th class="product-name">Product</th>
                                <th class="product-price">Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-subtotal">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cart as $key)
                                <tr>
                                    <td class="product-remove">
                                        <a class="remove" href="javascript:;" id="{{$key->id}}">×</a>
                                    </td>
                                    <td class="product-thumbnail">
                                        <a href="#">
                                            <img width="180" height="180" alt="" class="wp-post-image"
                                                 src="{{url('public/'.$key->image)}}">
                                        </a>
                                    </td>
                                    <td data-title="Product" class="product-name">
                                        <div class="media cart-item-product-detail">
                                            <a href="#">
                                                <img width="180" height="180" alt="" class="wp-post-image"
                                                     src="{{url('public/'.$key->image)}}">
                                            </a>
                                            <div class="media-body align-self-center">
                                                <a href="#">{{$key->product_name}}</a>
                                                <p class="ps-product__soldby">Sold by <span>{{$key->name}}</span>
                                                </p>
                                                <?php
                                                $array = json_decode($key->product_info);
                                                if (isset($array->size)) {
                                                ?>
                                                <p class="ps-product__soldby">Size<span> {{$array->size}}</span></p>
                                                <?php } ?>
                                                <?php if(isset($array->color)){?>
                                                <div class="ps-product__shopping color">

                                                    <ul id="menu">
                                                        <li class="color-list" data-value="{{$array->color}}">
                                                            <div class="color-col">Color:</div>
                                                            <div class="color-col"
                                                                 style="background-color: {{$array->color}}"></div>
                                                        </li>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-title="Price" class="product-price">
                                        &#x20B9;{{$key->sale_price}}
                                    </td>
                                    <td class="product-quantity" data-title="Quantity">
                                        <div class="quantity">
                                            <label for="quantity-input-1">Quantity</label>
                                            (X{{$key->product_quantity}})
                                            <div class="def-number-input number-input safari_only">
                                                <button class="minus"
                                                        onclick="this.parentNode.querySelector('input[type=number]').stepDown()" data-id="{{$key->product_id}}" data-amenity="{{$key->product_info}}">-</button>
                                                <input class="quantity" min="0" name="quantity"
                                                       value="{{$key->product_quantity}}" type="number" id="cart_input{{$key->product_id}}" />
                                                <button class="plus"
                                                        onclick="this.parentNode.querySelector('input[type=number]').stepUp()" data-id="{{$key->product_id}}" data-amenity="{{$key->product_info}}">+</button>

                                            </div>
                                        </div>
                                    </td>
                                    <td data-title="Total" class="product-subtotal">
                                        &#x20B9;{{$key->total_price}}
                                        <a title="Remove this item icon-trash2 cart" class="remove" data-id="{{$key->id}}"
                                           href="#">×</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="cart-collaterals">
                        <div class="cart_totals">
                            <h2>Cart totals</h2>
                            <table class="shop_table shop_table_responsive">
                                <tbody>
                                <tr class="cart-subtotal">
                                    <th>Subtotal</th>
                                    <td data-title="Subtotal">
                                        &#x20B9;{{$total}}
                                    </td>
                                </tr>
                                <tr class="shipping">
                                    <th>Shipping</th>
                                    <td data-title="Shipping">Flat rate</td>
                                </tr>
                                <tr class="order-total">
                                    <th>Total</th>
                                    <td data-title="Total">
                                        <strong>
                                            &#x20B9;{{$total}}
                                        </strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="wc-proceed-to-checkout">
                                <a class="checkout-button button alt wc-forward" href="{{route('checkout')}}">Proceed to
                                    checkout</a>
                                <a class="back-to-shopping" href="{{url('/')}}">Back to Shopping</a>
                            </div>
                        </div>
                    </div>
                </div>-->
            @else

                <div class="row m-0">
                    <div class="col-md-12 notfound text-center">
                        <img src="{{url('public/emptycart.png')}}" width="200px">
                        <br>
                        <a class="btn" href="{{url('/')}}">Shop Now</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <script type="text/javascript">

        $('.radio_cart .border').click(function(){
            $('.radio_cart .border').removeClass('active');
            $(this).addClass('active');
            $('.radio_cart input').prop('checked',false);
            $(this).find('input').prop('checked',true);
        });
        var currency = "{{$setting[0]->currency_sign}}";
        $('.minus').click(function() {
            id = $(this).attr('data-id');
            amenity = $(this).attr('data-amenity');
            quantity = $('#cart_input' + id).val();
            $.ajax({
                url: "/add_to_cart_ajax",
                data: {
                    product_id: id,
                    quantity: quantity,
                    amenties:amenity
                },
                cache: false,
                success: function(response) {
                    var ress = jQuery.parseJSON(response);
                    console.log(ress);
                    if (ress.success) {
                        window.location.reload(true);
                    } else {
                        console.log(response);
                    }
                }
            });
        });

        $('.plus').click(function() {
            id = $(this).attr('data-id');
            amenity = $(this).attr('data-amenity');
            quantity = $('#cart_input' + id).val();
            $.ajax({
                url: "/add_to_cart_ajax",
                data: {
                    product_id: id,
                    quantity: quantity,
                    amenties:amenity
                },
                cache: false,
                success: function(response) {
                    var ress = jQuery.parseJSON(response);
                    console.log(ress);
                    if (ress.success) {
                        window.location.reload(true);
                    } else {
                        console.log(response);
                    }
                }
            });
        });

        $('.remove').click(function() {
            if (confirm("Are you sure item remove from cart?")) {
                id = $(this).attr('data-id');
                url = "{{url('/remove_from_cart')}}?cartid="+id;
                window.location.href=url;
            }else{
                return false;
            }

        });

        function remove_cart_item(id){
            swal({
                text: " Do you want to remove item from cart?",
                icon: "warning",
                buttons: true,
                successMode: false,
            })
                    .then((willWishlist) => {
                if (willWishlist) {
                $.ajax({
                    url:'/remove_from_cart_ajax',
                    data:{cartid:id},
                    cache:false,
                    success:function(res){
                        var ress = JSON.parse(res);
                        if (ress.success) {
                            $('#cart_remove'+id+'').fadeOut(1200).css({'background-color':'#f2dede'});
                            get_cart();
                            $('.total').html(currency+ress.total);
                            $('.count').html(ress.count);
                            if (ress.count=='0') {
                                $('body').removeClass('show-mini-cart');
                            }
                        }else{
                            alert("error");
                        }
                    }
                });
            }
        });
        }
    </script>
@endsection