@extends('layouts.web')
@section('pagebodyclass')
single-product full-width normal
@endsection
@section('content')

<section id="primary" class="section content-area">
    <div id="main" class="container">
        @include('common.alerts')
        @if(!$cart->isEmpty())
        <div class="cart-wrapper">
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
                    <!-- .shop_table shop_table_responsive -->
                    <div class="wc-proceed-to-checkout">
                        <!-- .wc-proceed-to-checkout -->
                        <a class="checkout-button button alt wc-forward" href="{{route('checkout')}}">Proceed to
                            checkout</a>
                        <a class="back-to-shopping" href="{{url('/')}}">Back to Shopping</a>
                    </div>
                    <!-- .wc-proceed-to-checkout -->
                </div>
                <!-- .cart_totals -->
            </div>
        </div>
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
get_cart();

            function get_cart() {
                $.ajax({
                    url: "/get_cart_ajax",
                    cache: false,
                    success: function(response) {
                        var ress = jQuery.parseJSON(response);
                        if (ress.success) {
                            $('.list-cart').html(ress.data);
                            $('.count').html(ress.count);
                            $('.total').html(currency + ress.total);
                            $('.title-item-count').html('('+ress.count+' Items)');
                        } else {
                            //console.log(response);
                            $('.title-item-count').html('('+ress.count+' Items)');
                        }
                    }
                });
            }

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