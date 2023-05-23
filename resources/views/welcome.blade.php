@extends('layouts.web')
@section('pagebodyclass')
homepage-template
@endsection
@section('content')
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="home-slider-section">
    <div class="container">
            <div class="slider-block">
                <div class="home-slider">
                    @if(count($home_banner))
                    @foreach($home_banner as $key)
                    <div class="amr-banner">
                        <img class="mobile-only" src="{{url('public/')}}/{{ $key->m_banner}}" alt="alt" />
                        <img class="desktop-only" src="{{url('public/')}}/{{ $key->banner}}" alt="alt" />
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        </div>
        @if(count($home_top_banner))
        <div class="banners">
    <div class="container">
            <div class="row">
                @foreach($home_top_banner as $key)
                <div class="banner banner-short">
                    <a href="{{ $key->url}}">
                        <img src="{{url('public/')}}/{{ $key->banner}}" alt="alt" />
                    </a>
                </div>
                @endforeach
            </div>
            </div>
        </div>
        @endif

        <section class="section-top-categories section-categories-carousel" style="display: none;">
    <div class="container">
            <header class="section-header">
                <h4 class="pre-title">Featured</h4>
                <h2 class="section-title">Top categories
                    <br>this week
                </h2>
                <nav class="custom-slick-nav">
                    <a href="#" class="slick-arrow" style=""><i class="icon amr-arrow-left"></i></a>
                    <a href="#" class="slick-arrow" style=""><i class="icon amr-arrow-right"></i></a>
                </nav>
                <!-- .custom-slick-nav -->
                <a class="readmore-link" href="#">View all</a>
            </header>
            <div class="product-categories-1 product-categories-carousel">
                <div class="woocommerce columns-5">
                    <div class="products">
                        <div class="featured--content">

                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>

        <section class="section-products-carousel" id="products-carousel-1">
    <div class="container">
            <header class="section-header">
                <h2 class="section-title">Latest Products</h2>
                <nav class="custom-slick-nav"></nav>
                <!-- .custom-slick-nav -->
            </header>
            <!-- .section-header -->
            <div class="products-carousel" id="recent-products-carousel" data-ride="amr-slick-carousel"
                data-wrap=".recent-products"
                data-slick='{"infinite": false, "slidesToShow": 6, "slidesToScroll": 1, "dots": true, "arrows": true,"prevArrow":"<a href=\"#\"><i class=\"icon amr-arrow-left\"><\/i><\/a>","nextArrow":"<a href=\"#\"><i class=\"icon amr-arrow-right\"><\/i><\/a>", "appendArrows":"#products-carousel-1 .custom-slick-nav", "responsive": [{"breakpoint":650,"settings":{"slidesToShow":2,"slidesToScroll":2}},{"breakpoint":780,"settings":{"slidesToShow":3,"slidesToScroll":3}},{"breakpoint":1200,"settings":{"slidesToShow":4,"slidesToScroll":4}},{"breakpoint":1400,"settings":{"slidesToShow":6,"slidesToScroll":6}}]}'>
                <div class="container-fluid">
                    @if(count($product))
                    <div class="recent-products products">
                        @foreach($product as $key)
                        <div class="product">
                            <div class="amr-add-to-wishlist">
                                <a onclick="add_wishlist({{ $key->id}},'wishlist')" href="JavaScript:void(0);"
                                    rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                            </div>
                            <a class="amr-LoopProduct-link" href="{{route('product_details',[$key->id])}}">
                                @if($key->discount)
                                <span class="onsale">
                                    <span class="amr-Price-amount amount">
                                        @if($key->discount_type=='flat')
                                        {{$setting[0]->currency_sign}}{{$key->discount}} off
                                        @else
                                        {{$key->discount}}% off
                                        @endif
                                    </span>
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
                                <h2 class="amr-loop-product-title">{{$key->name}}</h2>
                                <span class="price">
                                    <ins>
                                        <span class="amount"> {{$setting[0]->currency_sign}}{{ $key->sale_price }}</span>
                                    </ins>
                                    @if($key->sale_price != $key->mrp_price)
                                    <del>
                                        <span class="amount">{{$setting[0]->currency_sign}}{{ $key->mrp_price}}</span>
                                    </del>
                                    @endif
                                    <span class="amount"> </span>
                                </span>

                            </a>
                            <div class="hover-area">
                                <a class="button add_to_cart_button" href="{{route('product_details',[$key->id])}}"
                                    rel="nofollow">View Product</a>
                                @if($key->shipping_time == 'yes')
                                <p class="amr-shipping-estimate">
                                    <i class="icon amr-order-tracking"></i> Delivery - {{ $key->estimate_time}}
                                </p>
                                @endif
                            </div>
                        </div>
                        @endforeach

                    </div>
                    @endif
                </div>
            </div>
            </div>
        </section>
        <!-- //////////////////////// -->
        @if(count($floating_categories))
        @php
        $i = 1;
        @endphp
        @foreach ($floating_categories as $key => $data)
        @php
        $i++;
        @endphp
        <section class="section-products-carousel" id="products-carousel-{{$i}}">
    <div class="container">
            <header class="section-header">
                <h2 class="section-title">{{ $floating_categories[$key]['name'] }}</h2>
                <nav class="custom-slick-nav"></nav>
                <!-- .custom-slick-nav -->
            </header>
            <!-- .section-header -->
            <div class="products-carousel" id="recent-products-carousel" data-ride="amr-slick-carousel"
                data-wrap=".recent-products"
                data-slick='{"infinite": false, "slidesToShow": 6, "slidesToScroll": 1, "dots": true, "arrows": true,"prevArrow":"<a href=\"#\"><i class=\"icon amr-arrow-left\"><\/i><\/a>","nextArrow":"<a href=\"#\"><i class=\"icon amr-arrow-right\"><\/i><\/a>", "appendArrows":"#products-carousel-{{$i}} .custom-slick-nav", "responsive": [{"breakpoint":650,"settings":{"slidesToShow":2,"slidesToScroll":2}},{"breakpoint":780,"settings":{"slidesToShow":3,"slidesToScroll":3}},{"breakpoint":1200,"settings":{"slidesToShow":4,"slidesToScroll":4}},{"breakpoint":1400,"settings":{"slidesToShow":6,"slidesToScroll":6}}]}'>
                <div class="container-fluid">

                    <div class="recent-products products">
                        @if(count($floating_categories[$key]['products']))

                        @foreach ($floating_categories[$key]['products'] as $key3 => $prodct)

                        @php
                        $product_id = $floating_categories[$key]['products'][$key3]['id'];
                        @endphp
                        <div class="product">
                            <div class="amr-add-to-wishlist">
                                <a onclick="add_wishlist({{ $product_id}},'wishlist')" href="JavaScript:void(0);"
                                    rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                            </div>
                            <a class="amr-LoopProduct-link" href="{{route('product_details',[$product_id])}}">
                                @if($floating_categories[$key]['products'][$key3]['discount'])
                                <span class="onsale">
                                    <span class="amr-Price-amount amount">
                                        @if($floating_categories[$key]['products'][$key3]['discount_type']=='flat')
                                        {{'Rs '. $floating_categories[$key]['products'][$key3]['discount']}} off
                                        @else
                                        {{$floating_categories[$key]['products'][$key3]['discount']}}% off
                                        @endif
                                    </span>
                                </span>
                                @endif
                                <div class="amr-product-img">
                                    @if($floating_categories[$key]['products'][$key3]['is_uploaded'])
                                    <?php
                                    $image_array = explode(',',$floating_categories[$key]['products'][$key3]['image']);

                                    ?>
                                    <img src="{{$image_array[0]}}" alt="">
                                    @else
                                    <img src="{{url('public')}}/{{ $floating_categories[$key]['products'][$key3]['image']}}"
                                        alt="{{ $floating_categories[$key]['products'][$key3]['name']}}">
                                    @endif
                                </div>
                                <h2 class="amr-loop-product-title">
                                    {{ $floating_categories[$key]['products'][$key3]['name']}}</h2>
                                <span class="price">
                                    <ins>
                                        <span class="amount">
                                            {{$setting[0]->currency_sign}}{{ $floating_categories[$key]['products'][$key3]['sale_price']}}</span>
                                    </ins>
                                    @if($floating_categories[$key]['products'][$key3]['sale_price'] !=
                                    $floating_categories[$key]['products'][$key3]['mrp_price'])
                                    <del>
                                        <span
                                            class="amount">{{$setting[0]->currency_sign}}{{ $floating_categories[$key]['products'][$key3]['mrp_price']}}</span>
                                    </del>
                                    @endif
                                    <span class="amount"> </span>
                                </span>

                            </a>
                            <div class="hover-area">
                                <a class="button add_to_cart_button" href="{{route('product_details',[$product_id])}}"
                                    rel="nofollow">View Product</a>
                                @if($floating_categories[$key]['products'][$key3]['shipping_time'] == 'yes')
                                <p class="amr-shipping-estimate">
                                    <i class="icon amr-order-tracking"></i> Delivery -
                                    {{ $floating_categories[$key]['products'][$key3]['estimate_time']}}
                                </p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        @else

                        <strong> Best deals coming soon...... </strong>
                        @endif

                    </div>
                </div>
            </div>
            </div>
        </section>
        @endforeach
        @endif



        <!-- ///////////////// -->



        @if(count($home_bottom_banner))
        <div class="banners">
    <div class="container">
            <div class="row">
                @foreach($home_bottom_banner as $key)
                <div class="banner banner-short">
                    <a href="{{ $key->url}}">
                        <img src="{{url('public/')}}/{{ $key->banner}}" alt="alt" />
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        </div>
        @endif

        @if(count($brand))
        <section class="brands-carousel">
    <div class="container">
            <h2 class="sr-only">Brands Carousel</h2>
            <div class="col-full" data-ride="amr-slick-carousel" data-wrap=".brands"
			data-slick='{"infinite": false, "slidesToShow": 8, "slidesToScroll": 8, "dots": true, "arrows": true, "responsive": [{"breakpoint":650,"settings":{"slidesToShow":2,"slidesToScroll":2}},{"breakpoint":780,"settings":{"slidesToShow":3,"slidesToScroll":3}},{"breakpoint":1200,"settings":{"slidesToShow":4,"slidesToScroll":4}},{"breakpoint":1400,"settings":{"slidesToShow":6,"slidesToScroll":6}}]}'>
                <div class="brands">
                    @foreach($brand as $key)
                    <div class="item">
                        <figure>
                            <figcaption class="text-overlay">
                                <div class="info">
                                    <h4>{{ $key->title}}</h4>
                                </div>
                                <!-- /.info -->
                            </figcaption>
                            <img width="145" height="50" class="img-responsive desaturate" alt="{{ $key->title}}" src="{{url('public/')}}/{{ $key->banner}}">
                        </figure>
                    </div>
                    @endforeach
                </div>
                </div>
        </section>
        @endif
    </main>
</div>

<script type="text/javascript">
$.ajax({
    url: "{{route('get_featured_category')}}",
    cache: false,
    success: function(response) {
        //console.log(response);
        $('.featured--content').html(response);
    }
});
// $.ajax({
//     url:"{{route('get_product_ajax')}}",
//     cache:false,
//     success:function(response){
//         console.log(response);
//         $('.flashdeal-content').html(response);
//     }
// });
</script>
@endsection