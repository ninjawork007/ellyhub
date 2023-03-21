@extends('layouts.web')
@section('pagebodyclass')
full-width @endsection
@section('content')
<nav class="amrcart-breadcrumb">
    <a href="{{url('/')}}">Home</a>
    <span class="delimiter">
        <i class="icon amr-breadcrumbs-arrow-right"></i>
    </span> Products
</nav>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <h4 class="title"><span class="main-color">{{$products->count()}}</span> Product Found</h4>
        <div class="category-products-list columns-5">
            <div class="products">
                @if($products->count())
                @foreach($products as $key)
                <div class="product">
                    <div class="amr-add-to-wishlist">
                        <a onclick="add_wishlist('{{$key->id}}','wishlist')" href="JavaScript:void(0);" rel="nofollow"
                            class="add_to_wishlist"> Add to Wishlist</a>
                    </div>
                    <a class="amr-LoopProduct-link" href="{{route('product_details',[$key->id])}}">
                        @if($key->discount_type)
                        <span class="onsale">
                            @if($key->discount)
                            <span class="amr-Price-amount amount">
                                @if($key->discount_type=='flat')
                                {{'Rs '. $key->discount}} off
                                @else
                                {{$key->discount}}% off
                                @endif
                            </span>
                            @endif
                        </span>
                        @endif
                        <div class="amr-product-img">
                            @if($key->is_uploaded)
                                <?php
                                $image_array = explode(',',$key->image);

                                ?>
                                <img src="{{$image_array[0]}}" alt="">
                            @else
                                <img src="{{url('public/'.$key->image)}}" alt="{{$key->name}}">
                            @endif
                        </div>
                        <div class="pro-info">
                            <h2 class="amr-loop-product-title">{{$key->name}}</h2>
                            <span class="price">
                                <ins>
                                    <span class="amount"> ₹{{ $key->sale_price }}</span>
                                </ins>
                                @if($key->sale_price != $key->mrp_price)
                                <del>
                                    <span class="amount">₹{{ $key->mrp_price}}</span>
                                </del>
                                @endif
                                <span class="amount"></span>
                            </span>
                            <!-- <div>{{$key->vendor_name}}</div> -->
                        </div>

                    </a>
                    <div class="hover-area">
                        <a class="button add_to_cart_button" href="{{url('product',[$key->id])}}" rel="nofollow">View
                            Product</a>
                        @if($key->shipping_time == 'yes')
                        <p class="amr-shipping-estimate">
                            <i class="icon amr-order-tracking"></i> Delivery - {{ $key->estimate_time}}
                        </p>
                        @endif
                    </div>
                </div>
                @endforeach
                @endif
            </div>

        </div>
        <div class="row pagination">
            {!! $products->links() !!}
        </div>
    </main>
</div>

@endsection