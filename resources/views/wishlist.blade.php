@extends('layouts.web')



@section('content')

<nav class="amrcart-breadcrumb">
    <a href="https://bazarhat99.com">Home</a>
    <span class="delimiter">
        <i class="icon amr-breadcrumbs-arrow-right"></i>
    </span> Watch List
</nav>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <div class="container">

            <h2 class="page__title text-black font-bolder">Watch List</h2>

            <main id="main" class="site-main wishlist">
                <div class="category-products-list columns-7">
                    <div class="products">
                        @if($wishlist->count())
                            @foreach($wishlist as $key)
                                <div class="product border-0">
                                    <a href="{{url('/product/'.$key->product_id)}}">
                                        <div class="watch-list-img">
                                            <img onclick="remove_watchlist('{{$key->id}}','wishlist')" src="{{url('public/assets/web/images/closed-eye.png')}}">
                                        </div>
                                        <div class="amr-product-img">
                                            @if($key->is_uploaded)
                                                <?php $image_array = explode(',',$key->image); ?>
                                                <div class="border h-100">
                                                    <div style="background-image: url('{{$image_array[0]}}');"></div>
                                                </div>
                                            @else
                                                <div class="border h-100">
                                                    <div style="background-image: url('{{url('public/'.$key->image)}}');"></div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="pro-info">
                                            <div class="desc  text-start">
                                                <h2 class="amr-loop-product-title text-start font-bold">{{\Illuminate\Support\Str::limit(strip_tags($key->name), 30, $end='...')}}</h2>
                                                <h2 class="amr-loop-product-type text-start">{{($key->product_type!='new')?"Used - Excellent":"Brand New"}}</h2>
                                                <span class="product-price">
                                                    <ins>
                                                        <span class="amount"> ${{ $key->sale_price }}</span>
                                                    </ins>
                                                    @if($key->sale_price != $key->mrp_price)
                                                        <del>
                                                            <span class="amount">${{ $key->mrp_price}}</span>
                                                        </del>
                                                    @endif
                                                    <span class="amount"></span>
                                                </span>
                                                <p class="shipping-charges text-start">{{(empty($key->shipping_charges)) ? "+ $".$key->shipping_charges : "Free Shipping"}}</p>
                                                <div class="product-actions">
                                                    <button class="single_add_to_cart_button cart_button" data-id="{{$key->product_id}}" name="add-to-cart">Add to cart</button>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>

                </div>
            </main>

            {{--<div class="wishlist__content">

                <div class="wishlist__product">

                    <div class="wishlist__product--desktop">

                        @if(count($wishlist))

                        <table class="shop_table shop_table_responsive cart">

                            <thead>

                                <tr>

                                    <th scope="col">Product</th>

                                    <th scope="col">Price</th>

                                    <th scope="col">Date</th>

                                    <th scope="col">Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($wishlist as $key)

                                <tr id="{{$key->id}}">

                                    <td data-title="Product" class="product-name">

                                        <a href="{{url('/product/'.$key->product_id)}}">

                                            <img src="{{url('public/'.$key->image)}}" style="max-width: 100px;">

                                            {{$key->name}}

                                        </a>

                                    </td>

                                    <td data-title="Price" class="product-price">₹{{$key->sale_price}}</td>

                                    <td data-title="Date" class="product-price">{{date('d F, Y',strtotime($key->created_at))}}</td>

                                    <td data-title="Remove" class="product-price"><div class="wishlist__trash wishlist" data-id="{{$key->id}}"><a title="Remove this item icon-trash2 wishlist" class="remove"
                                href="#">×</a></div></td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                        @else

                        <div class="text-center">

                            <img src="{{url('/public/not-found.jpg')}}">

                            <p>No Wishlist Found.</p>

                        </div>

                        @endif

                    </div>

                </div>

            </div>--}}

        </div>
    </main>
</div>



<script type="text/javascript">

    $('.wishlist__trash.wishlist').click(function(){

        id = $(this).attr('data-id');

        if (confirm('Do you want to remove from wishlist?')) {

            $.ajax({

            url:'{{url('/remove_from_wishlist')}}',

            data:{id:id},

            cache:false,

            success:function(res){

              if (res) {

                window.location.reload();

                // /$('#cartrow'+id+'').fadeOut(1200).css({'background-color':'#f2dede'});

              }

            }

          }); 

        }else{

            return false;

        }

    });

    $('body').on('click', '.single_add_to_cart_button', function(e) {
        e.preventDefault();
        amenties = {}
        id = $(this).attr('data-id');

        $.ajax({
            url: site_url+"/add_to_cart_ajax",
            data: {
                product_id: id,
                quantity: 1,
            },
            cache: false,
            success: function(response) {
                var ress = jQuery.parseJSON(response);
                if (ress.success) {
                    $('.show-mini-cart-v2').show();
                    $('.list-cart').html(ress.data);
                    $('.count').html(ress.count);
                    $('.total').html(currency + ress.total);
                    $('.title-item-count').html('('+ress.count+' Items)');
                }
            }
        });
    });

</script>

@endsection



