@extends('layouts.web')
@section('pagebodyclass')
full-width @endsection
@section('content')
<div id="primary" class="content-area">
    <main id="main" class="site-main container-fluid">
        <div class="category-products-list columns-7">
            <div class="products">
                @if($products->count())
                @foreach($products as $key)
                <div class="product border-0">
                    <a href="{{url('/product/'.$key->id)}}">
                        <div class="watch-list-img">
                            @if(in_array($key->id,$wishlists))
                                <img onclick="remove_watchlist('{{array_search($key->id,$wishlists)}}','wishlist')" src="{{url('public/assets/web/images/open-eye.png')}}">
                            @else
                                <img onclick="add_wishlist('{{$key->id}}','wishlist')" src="{{url('public/assets/web/images/closed-eye.png')}}">
                            @endif
                        </div>
                        <div class="amr-product-img">
                            @if($key->is_uploaded)
                                <?php $image_array = explode(',',$key->image); ?>
                                <div class="border" >
                                    <div style="background-image: url('{{$image_array[0]}}');"></div>
                                </div>
                            @else
                                <div class="border" >
                                    <div style="background-image: url('{{url('public/'.$key->image)}}');"></div>
                                </div>
                            @endif
                        </div>
                        <?php
                        $dateToCheck = new DateTime($key->created_at);

                        $currentDate = new DateTime();

                        $timeDifference = $currentDate->diff($dateToCheck);
                        if ($timeDifference->days < 1) {
                            $listingText = "NEW LISTING";
                        } else {
                            $listingText = "";
                        }
                        ?>
                        <div class="pro-info">
                            <div class="desc  text-start">
                                <h2 class="amr-loop-product-title text-start font-bold">{{strip_tags($key->name)}}</h2>
                                <h2 class="amr-loop-product-type text-start">{{($key->product_type!='new')?"Pre-Owned":"New"}}  {{$key->brand}}</h2>
                                <h2 class="amr-loop-product-title text-start">{{$listingText}}</h2>
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
                                <h2 class="amr-loop-product-type text-start">Buy It Now</h2>
                                <h2 class="amr-loop-product-type text-start">{{(empty($key->shipping_charges)) ? "+ $".$key->shipping_charges : "Free Shipping"}}</h2>
                            </div>
                        </div>
                    </a>
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