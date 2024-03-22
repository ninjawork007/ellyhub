@extends('layouts.web')
@section('pagebodyclass')
full-width white-bg @endsection
@section('content')
<style type="text/css">
.forms ul li {
    padding: 5px;
    float: left;
    width: 100%;
}
li {
    list-style: none;
}
.forms .creadit-card-detail {
    background: #FAFAFA;
    border: 1px solid #CECECE;
    float: left;
    width: 100%;
    border-radius: 5px 5px 0 0;
}
.forms .creadit-card-detail .heading {
    background: #fff;
    border-radius: 5px 5px 0 0;
    border-bottom: 1px solid #CECECE;
    padding: 10px 25px;
    display: flex;
    justify-content: space-between;
}
.forms .creadit-card-detail ul {
    padding: 5px 10px;
}
.form-input, div.cs-selector {
    background: #FFFFFF;
    border: 1px solid #CECECE;
    box-sizing: border-box;
    border-radius: 5px;
    font-size: 16px;
    line-height: 22px;
    height: 50px;
    padding: 10px 25px;
    width: 100%;
}
</style>
<section class="section">
    <div class="container">
<nav class="amrcart-breadcrumb">
    <a href="{{url('/')}}">Home</a>
    <span class="delimiter">
        <i class="icon amr-breadcrumbs-arrow-right"></i>
    </span> Checkout
</nav>
<div class="content-area" id="primary">
    <main class="site-main" id="main">
        <div class="amrcart">
            @include('common.alerts')
            @if(!$cart->isEmpty())
            @if(!Auth::user())
            <div class="amrcart-info">
                Returning customer? <a data-toggle="collapse" href="#login-form" aria-expanded="false"
                    aria-controls="login-form" class="showlogin collapsed">Click here to login</a>
            </div>
            @endif
            <div class="amrcart-info">
                Have a coupon? <a data-toggle="collapse" href="#checkoutCouponForm" aria-expanded="true"
                    aria-controls="checkoutCouponForm" class="showlogin">Click here to enter your code</a>
            </div>
            <div class="collapse" id="checkoutCouponForm">
                <form class="checkout_coupon">
                    <p class="form-row form-row-first"><input class="input-text" type="text" id="coupen_code"
                            placeholder="Enter coupen code"></p>
                    <p class="form-row form-row-last"><input type="submit" value="Apply coupon"
                            class="button checkout__order" onclick="apply_coupen()"></p>
                </form>
            </div>
            <form method="post" class="amr-checkout checkout forms" action="{{route('make_payment')}}" data-parsley-validate=""
                id="order_form">

                @csrf

                <input type="hidden" name="userid" id="userid" value="{{session('userid')}}">

                <input type="hidden" name="is_coupen" id="is_coupen" value="no">
                <input type="hidden" name="is_wallet" id="is_wallet" value="no">
                <input type="hidden" name="apply_code" id="apply_code">

                <input type="hidden" name="shipping_amount" id="shipping_amount"
                    value="{{($shipping_amount)?$shipping_amount:0}}">

                <input type="hidden" name="payment_type" id="payment_type" value="cash">

                <input type="hidden" name="order_total_before" id="order_total_before"
                    value="{{$total+$shipping_amount}}">

                <input type="hidden" name="order_total" id="order_total" value="{{$total+$shipping_amount}}">

                <input type="hidden" name="rzp_id" id="rzp_id">
                <input type="hidden" id="wallet_balance" name="wallet_balance"
                    value="{{(Auth::user())?Auth::user()->balance:0}}">
                <input type="hidden" id="remain_wallet" name="remain_wallet" value="">
                <input type="hidden" id="wallet_balance_used" name="wallet_balance_used" value="">
                <div class="col2-set" id="maindiv">
                    <div class="col-1">
                        <h3 class="checkout__title">Billing Details</h3>
                        <div class="checkout__form" id="checkout_form">
                            <div class="form-row row">
                                <div class="col-12 col-lg-6 form-group--block">
                                    <label>Name: <span>*</span></label>
                                    <input class="form-control" type="text" required name="name"
                                        value="{{@Auth::user()->name}}">
                                </div>
                                <div class="col-12 col-lg-6 form-group--block">
                                    <label>Phone: <span>*</span></label>
                                    <input class="form-control" type="text" required name="phone"
                                        value="{{@Auth::user()->mobile}}">
                                </div>
                                <div class="col-12 form-group--block">
                                    <label>Email address: <span>*</span></label>
                                    <input class="form-control" type="email" required name="email"
                                        value="{{@Auth::user()->email}}">
                                </div>
                                @if(!$address->isEmpty())
                                <div class="col-12 form-group--block">
                                    <div class="slider address-items">
                                        @foreach($address as $key)
                                        <div id="{{$key->id}}" class="address_">
                                            <label class="address-col">

                                                <div class="address-name">{{ucfirst($key->address_type)}}</div>

                                                <address>{{$key->street}}</address>

                                            </label>

                                        </div>

                                        @endforeach

                                    </div>

                                </div>

                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-row row">
                            <div class="col-12 form-group--block">
                                <h3 class="checkout__title">Shipping Address</h3>
                            </div>
                            <div class="col-12 form-group--block" id="scroll">

                                <label>House no./ Street address: <span>*</span></label>

                                <input class="form-control" type="text" placeholder="type address here." name="street_address" id="type_address" required="">

                            </div>

                            <div class="col-12 form-group--block">

                                <label>Postcode/ ZIP </label>

                                <input class="form-control" type="text" name="zip" id="zip" required="" >
                                <small class="text-danger zip_error"></small>
                                <!-- <datalist id="zipcode">
                                    @if(count($zipcodes))
                                    @foreach($zipcodes as $key)
                                    <option value="{{$key->pincode}}">
                                        @endforeach
                                        @endif

                                </datalist> -->

                            </div>

                            <div class="col-12 form-group--block">

                                <label>Town/ City: <span>*</span></label>

                                <input class="form-control" type="text" required name="city" id="city">

                            </div>

                            <div class="col-12 form-group--block">

                                <label>State: <span>*</span></label>

                                <input class="form-control" type="text" required name="state" id="state">
                                <input type="hidden" name="state_short" id="state_short">
                            </div>

                            <div class="col-12 form-group--block">

                                <label>Country: <span>*</span></label>

                                <input class="form-control" type="text" required name="country" id="country">
                                <input type="hidden" name="country_short" id="country_short">
                            </div>

                            <div class="col-12 form-group--block <?php if(!Auth::user()){ echo 'd-none';}?>">

                                <input id="save_address" class="form-check-input" type="checkbox" name="save_address">

                                <label for="save_address" class="label-checkbox">Do you want to save this
                                    address?</label>

                            </div>

                            @if(!Auth::user())

                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-row row">
                            <div class="col-12 form-group--block d-flex">

                                <input id="create_account" class="form-check-input" type="checkbox"
                                    name="create_account" style="width:18px">

                                <label for="create_account" class="label-checkbox">Create an
                                    account?</label>

                            </div>

                            @endif

                            <div class="col-12 form-group--block">

                                <label>Order notes (optional)</label>

                                <textarea class="form-control"
                                    placeholder="Note about your orders, e.g special notes for delivery."
                                    name="notes"></textarea>

                            </div>

                        </div>

                    </div>

                </div>



                <div class="amrcart-checkout-review-order">
                    <div class="order-review-wrapper">
                        <h3 class="order_review_heading">Your Order</h3>
                        <table class="shop_table amr-checkout-review-order-table">
                            <thead>
                                <tr>
                                    <th class="product-name">Product</th>
                                    <th class="product-total">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $key)
                                <tr class="cart_item">
                                    <td class="product-name">
                                        <strong class="product-quantity">{{$key->product_quantity}} ×</strong>
                                        {{$key->product_name}}
                                    </td>
                                    <td class="product-total">
                                       {{$setting[0]->currency_sign}}{{$key->total_price}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="cart-subtotal">
                                    <th>Subtotal</th>
                                    <td>
                                        {{$setting[0]->currency_sign}}{{$total}}
                                    </td>
                                </tr>
                                <tr class="order-discount d-none">
                                    <th class="text-green">Discount</th>
                                    <td>
                                        {{$setting[0]->currency_sign}}{{$shipping_amount}}
                                    </td>
                                </tr>
                                <tr class="order-Shipping">
                                    <th>Shipping</th>
                                    <td>
                                        +{{$setting[0]->currency_sign}}{{$shipping_amount}}
                                    </td>
                                </tr>
                                <tr class="order-wallet d-none">
                                    <th>Wallet</th>
                                    <td class="order_wallet">
                                        -{{$setting[0]->currency_sign}}{{$shipping_amount}}
                                    </td>
                                </tr>

                                <tr class="order-total">
                                    <th>Total</th>
                                    <td>
                                        <strong class="final_amount">
                                            {{$setting[0]->currency_sign}}{{$total+$shipping_amount}}
                                        </strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="amrcart-checkout-payment" id="payment">
                            <div class="">
                                <ul>
                                    <li>
                                        <div class="creadit-card-detail">
                                            <div class="heading">Credit/Debit Card
                                                <div class="payment-icon">
                                                    <img src="https://launchright.co.uk/public/assets/images/payment-img-2.png" alt="">
                                                    <img src="https://launchright.co.uk/public/assets/images/payment-img-3.png" alt="">
                                                    <img src="https://launchright.co.uk/public/assets/images/payment-img-4.png" alt="">
                                                    <img src="https://launchright.co.uk/public/assets/images/payment-img-5.png" alt="">
                                                </div>
                                            </div>
                                            <ul>
                                                <li>
                                                    <input type="tel" class="form-input" placeholder="Card number" name="card" maxlength="19" required="">
                                                </li>
                                                <li>
                                                    <input type="tel" class="form-input" placeholder="Name on card" name="name_on_card" required="">
                                                </li>
                                                <li class="p-60">
                                                    <input type="tel" class="form-input" placeholder="Expiration Date (MM /YY)" name="expiry" maxlength="5" data-parsley-pattern="/^(0[1-9]|1[0-2])\/?([0-9]{2}|[0-9]{2})$/mg" required="" data-parsley-trigger="change">
                                                </li>
                                                <li class="p-40">
                                                    <input type="tel" class="form-input" placeholder="Security code" name="cvv" maxlength="3" required="">
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                              </div>
                            
                            <!-- <div class="form-row place-order"> -->
                                <div class="place-order">
                                <p class="form-row terms amr-terms-and-conditions">
                                    <label class="amrcart-form__label amrcart-form__label-for-checkbox checkbox"
                                        for="checkboxAgree">
                                        <input type="checkbox" id="checkboxAgree" value="agree" required=""
                                            class="amrcart-form__input amrcart-form__input-checkbox input-checkbox">
                                        <span>I’ve read and accept the
                                            <a href="#" class="text-success">terms and conditions </a>
                                        </span>
                                        <span class="required">*</span></label>
                                </p>
                                <button class="button amr-forward text-center" type="submit">Place an order</button>
                            </div>
                        </div>

                    </div>
            </form>
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
    </main>
</div>
</div>
</section>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBv3FYZuLZJR8mOlONc6hMGqh-Taeo7-7g&libraries=places"></script>
<script>
    var currency = "{{$setting[0]->currency_sign}}";
    $("input[name='card']").keypress(function(e) {   
        value = cc_format($(this).val());
        $(this).val(value);
    });

    $("input[name='expiry']").keyup(function(e) {
        var key = event.keyCode || event.charCode;
        if (key==8) {
            return false;
        }
        value = expiry_month_validation($(this).val());
        $(this).val(value);
    });
    $("input[name='cvv']").keyup(function(e) {   
        value = cvv_format($(this).val());
        $(this).val(value);
      });
    function cc_format(value) {
      var v = value.replace(/\s+/g, '').replace(/[^0-9]/gi, '')
      var matches = v.match(/\d{4,16}/g);
      var match = matches && matches[0] || ''
      var parts = []
      for (i=0, len=match.length; i<len; i+=4) {
        parts.push(match.substring(i, i+4))
      }
      if (parts.length) {
        return parts.join(' ')
      } else {
        return value
      }
        
    }

    function expiry_month_validation(value) {

    var key = event.keyCode || event.charCode;
    if (key==192 || key==188 || key==190 || key==191 || key==186 || key==222 || key==219 || key==221 || key==111 || key==106 || key==109 || key==107 || key==110 || key==187 || key==189 ) {
        str = value.slice(0, -1);
        return str;
    }
    var regExp = /[a-zA-Z]/g;
    var testString = value;
      if (regExp.test(testString)) {
        return '';
      }
      if (value.length==2) {
        return value+'/';
      }
      return value;
      
    }

    function cvv_format(value){
        var regExp = /[a-zA-Z]/g;
        var testString = value;
        if (regExp.test(testString)) {
            str = value.slice(0, -1);
            return str;
        }
        return value;
    }
</script>
<script type="text/javascript">
function datalistValidator(modelname) {
    var obj = $("#zipcode").find("option[value='" + modelname + "']");
    if (obj != null && obj.length > 0) {
        return true
    }
    return false;
}
jQuery(document).ready(function() {

    jQuery('.address-items').slick({

        infinite: true,

        slidesToShow: 3,

        slidesToScroll: 1

    });

    jQuery('.address-items label.address-col').click(function() {

        jQuery('.address-items label.address-col').removeClass("active");

        jQuery(this).addClass("active");

    });

});



function show_coupen_div() {

    $('.coupen.d-none').removeClass('d-none');

}



function apply_coupen() {

    if ($.trim($('#coupen_code').val()) == '') {

        $('.error_couen').html('Please enter coupen code.');

        return false;

    }

    $('.error_couen').html('');

    $('.checkout__order').attr('disabled',true);

    $('.checkout__order').html('Please wait...');

    $.ajax({

        url: "{{url('apply_coupen')}}",

        data: {
            coupen: $.trim($('#coupen_code').val()),
            userid: $('#userid').val()
        },

        cache: false,

        success: function(response) {

            var ress = JSON.parse(response);

            if (ress.success) {

                $('.final_amount').html(currency + ress.data.final_price);

                $('.row.discount').removeClass('d-none');

                $('.checkout__label.discount').html('- '+currency + ress.data.total_discount);

                $('html, body').animate({

                    scrollTop: $("#maindiv").offset().top

                }, 2000);

                $('#is_coupen').val('yes');

                $('#apply_code').val($('#coupen_code').val());

                $('#order_total').val(ress.data.final_price);

            } else {

                $('.error_couen').html(ress.message);

            }

        }

    });

}



$('input[name="payment_type"]').click(function() {

    $('#payment_type').val($(this).val());

});



$('#order_form').submit(function(e) {

    e.preventDefault();
    var modelname = $('#zip').val();
    // if (!datalistValidator(modelname)) {
    //     alert("We are not serving in this area.");
    //     $('#zip').addClass('error');
    //     $('html, body').animate({
    //         scrollTop: $("#scroll").offset().top
    //     }, 1000);
    //     return false;
    // }

    var totalAmount = $('#order_total').val();
    if (!$('#order_form').parsley().validate()) {
        return false;
    }

    if (!totalAmount) {
        $('#order_form')[0].submit();
        return false;
    }

    var order_total = $('#order_total').val();
    var wallet_balance = $('#wallet_balance_used').val();

    if (order_total > wallet_balance) {
        var after_discount = order_total - wallet_balance;
    } else {
        var after_discount = 0;
    }
    if (!after_discount) {
        $('#order_form')[0].submit();
        return false;
    }

    var final_amount_paid = totalAmount - $('#wallet_balance_used').val();
    final_amount_paid = final_amount_paid.toFixed(2);

    var product_id = 'BH123';

    $('#order_form')[0].submit();

});
$(document).on('click', '.address_', function() {
    addressid = $(this).attr('id');
    $.ajax({
        url: "{{route('get_address')}}",
        data: {
            id: addressid
        },
        cache: false,
        success: function(response) {
            var ress = JSON.parse(response);
            $('input[name="street_address"]').val(ress.data.street);
            $('input[name="zip"]').val(ress.data.zip);
            $('input[name="city"]').val(ress.data.town);
            $('input[name="country"]').val(ress.data.country);
        }
    });
});

$(function() {
    apply_wallet();
});

function apply_wallet() {
    var order_total = parseInt($('#order_total').val());
    var wallet_balance = parseInt($('#wallet_balance').val());

    if (wallet_balance == '0') {
        console.log("no wallet balance");
        return false;
    }
    $('#is_wallet').val('yes');
    if (order_total < wallet_balance) {
        var after_discount = 0;
        var after_dicount_remain_wallet = wallet_balance - order_total;
        var wallet_used = wallet_balance-after_dicount_remain_wallet;
        alert(wallet_balance);
    } else {
        var after_discount = order_total-wallet_balance;
        var after_dicount_remain_wallet = after_discount;
        var wallet_used = wallet_balance;
    }

    //$('#order_total').val(after_discount);
    $('.order-wallet').removeClass('d-none');
    $('#wallet_balance').val(after_dicount_remain_wallet);
    $('.final_amount').html(currency + after_discount.toFixed(2));
    $('.order_wallet').html('- '+currency+wallet_used);
    if (!wallet_balance) {
        $('.checkout__payment').hide();
    }

    if (!after_discount) {
        $('.checkout__payment').hide();
    }

    //$('#payment_type').val('wallet');
    $('#wallet_balance_used').val(wallet_used);
    $('#remain_wallet').val(after_dicount_remain_wallet);
}
</script>
<script type="text/javascript">
 function initialize() {
        var input = document.getElementById('type_address');
        var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.setComponentRestrictions({'country': ['us']});
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
             var place = autocomplete.getPlace();
       var lat = place.geometry.location.lat();
       var log = place.geometry.location.lng();
       console.log(lat);
       console.log(log);
             curent_address(lat,log);    
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize); 
  
  
  
function curent_address(lat,log) {
 
    var geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(lat, log);
 
    geocoder.geocode({'latLng': latlng}, 
  
  function (results, status) {
    console.log(results);
            if (status == google.maps.GeocoderStatus.OK) {
                for (var i = 0; i < results[0].address_components.length; i++) {
                for (var j = 0; j < results[0].address_components[i].types.length; j++) {
        
                  // document.getElementById('city').value = '';
                  if (results[0].address_components[i].types[j] == "postal_code") {
                    $('#zip').val(results[0].address_components[i].long_name);
                     
                  }
                  if (results[0].address_components[i].types[j] == "country") {
                    document.getElementById('country_short').value = results[0].address_components[i].short_name;
                    document.getElementById('country').value = results[0].address_components[i].long_name;
                  }
                  if (results[0].address_components[i].types[j]=="administrative_area_level_1") {
                     document.getElementById('state').value = results[0].address_components[i].long_name;
                     document.getElementById('state_short').value = results[0].address_components[i].short_name;
                  }
                  if (results[0].address_components[i].types[j]=="administrative_area_level_2") {

                     document.getElementById('city').value = results[0].address_components[i].long_name;
                  }
        
         }
       }
            } else {
                alert('Geocoder failed due to: ' + status);
            }
        });
}
</script>
@endsection