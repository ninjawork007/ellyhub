@extends('layouts.web')
@section('bodyclass')

@endsection
@section('content')
<section class="section">
    <div class="container">
    <div class="row">
        <div id="secondary" class="col-sm-3 shop-sidebar" role="complementary">
            <div id="techmarket_products_filter-3" class="widget widget_techmarket_products_filter">
                <span class="gamma widget-title">Filters</span>
                <!-- .amrcart widget_layered_nav -->
                <div class="widget amrcart widget_layered_nav maxlist-more" id="amrcart_layered_nav-3">
                    <span class="gamma widget-title">All Categories</span>
                    <ul>

                    @if(count($top_cat))
                    @foreach($top_cat as $key)
                    <li>
                        <div class="form-check">
                            <label id="{{ $key->id}}" value="{{ $key->id}}" onclick="make_filter('category','{{$key->id}}')">
                            <input name="categories" class="categories" type="checkbox" id="{{ $key->id}}" value="{{ $key->id}}" <?php if(@in_array($key->id,$cat_array)){echo 'checked';}?>> {{ $key->name}}<span>(0)</span></label>
                        </div>
                    </li>
                    @endforeach
                    @endif
                    </ul>
                    <p class="maxlist-more"><a href="#">+ Show more</a></p>
                </div>
                <!-- .amrcart widget_layered_nav -->
                <div class="widget amrcart widget_layered_nav maxlist-more" id="amrcart_layered_nav-2">
                    <span class="gamma widget-title">Brands</span>
                    <ul>
                        @if(count($top_brand))
                        @foreach($top_brand as $key)
                        <li>
                            <div class="form-check">
                                <label id="{{ $key->id}}" value="{{ $key->id}}" onclick="make_filter('brand','{{$key->id}}')">
                                <input name="brand" type="checkbox" id="{{ $key->id}}" class="brand" value="{{ $key->id}}" <?php if(@in_array($key->id,$brand_array)){echo 'checked';}?>> {{ $key->title}}<span>(0)</span></label>
                            </div>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                    <p class="maxlist-more"><a href="#">+ Show more</a></p>
                </div>
                
            </div>
            
        </div>
<div id="primary" class="col-sm-7 content-area">
        <div class="shop-control-bar" style="display: none;">
            <div class="handheld-sidebar-toggle">
                <button type="button" class="btn sidebar-toggler">
                    <i class="fa fa-sliders"></i>
                    <span>Filters</span>
                </button>
            </div>
            <!-- .handheld-sidebar-toggle -->
            <h1 class="amrcart-products-header__title page-title">{{$product->count()}} <span>Product Found</span>
            </h1>
            <ul role="tablist" class="shop-view-switcher nav nav-tabs">
                <li class="nav-item">
                    <a href="#grid" title="Grid View" data-toggle="tab" class="nav-link active">
                        <i class="icon amr-grid-small"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#grid-extended" title="Grid Extended View" data-toggle="tab" class="nav-link ">
                        <i class="icon amr-grid"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#list-view-large" title="List View Large" data-toggle="tab" class="nav-link ">
                        <i class="icon amr-listing-large"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#list-view" title="List View" data-toggle="tab" class="nav-link ">
                        <i class="icon amr-listing"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#list-view-small" title="List View Small" data-toggle="tab" class="nav-link ">
                        <i class="icon amr-listing-small"></i>
                    </a>
                </li>
            </ul>
            <!-- .shop-view-switcher -->
            <form class="form-amr-wc-ppp" method="POST">
                <select class="amr-wc-wppp-select c-select" onchange="this.form.submit()" name="ppp">
                    <option value="20">Show 20</option>
                    <option value="40">Show 40</option>
                    <option value="-1">Show All</option>
                </select>
                <input type="hidden" value="5" name="shop_columns">
                <input type="hidden" value="15" name="shop_per_page">
                <input type="hidden" value="right-sidebar" name="shop_layout">
            </form>
            <!-- .form-amr-wc-ppp -->
            <form method="get" class="amrcart-ordering">
                <select class="orderby" name="orderby">
                    <option value="popularity">Sort by popularity</option>
                    <option value="rating">Sort by average rating</option>
                    <option selected="selected" value="date">Sort by newness</option>
                    <option value="price">Sort by price: low to high</option>
                    <option value="price-desc">Sort by price: high to low</option>
                </select>
                <input type="hidden" value="5" name="shop_columns">
                <input type="hidden" value="15" name="shop_per_page">
                <input type="hidden" value="right-sidebar" name="shop_layout">
            </form>
            <!-- .amrcart-ordering -->
            <nav class="amr-advanced-pagination">
                <form class="form-adv-pagination" method="post">
                    <input type="number" value="1" class="form-control" step="1" max="5" min="1" size="2"
                        id="goto-page">
                </form> of 5<a href="#" class="next page-numbers">→</a>
            </nav>
            <!-- .amr-advanced-pagination -->
        </div>
        <div class="category-products-list columns-4">
            @if($product->count())
            <div class="products">
                @foreach($product as $key)
                <div class="product">
                    <div class="amr-add-to-wishlist">
                        <a onclick="add_wishlist({{ $key->id}},'wishlist')" href="JavaScript:void(0);" rel="nofollow"
                            class="add_to_wishlist"> Add to Wishlist</a>
                    </div>
                    <a class="amr-LoopProduct-link" href="{{route('product_details',[$key->id])}}">
                        @if($key->discount_type)
                        <span class="onsale">
                            @if($key->discount)
                            <span class="amr-Price-amount amount">
                                @if($key->discount_type=='flat')
                                {{$setting[0]->currency_sign. $key->discount}} off
                                @else
                                {{$key->discount}}% off
                                @endif
                            </span>
                            @endif
                        </span>
                        @endif
                        <div class="amr-product-img">
                            <img src="{{$key->image}}" alt="{{$key->name}}">
                        </div>
                        <div class="pro-info">
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
                            <span class="amount"></span>
                        </span>
                        <!-- <div>{{$key->vendor_name}}</div> -->
                        </div>

                    </a>
                    <div class="hover-area">
                        <a class="button add_to_cart_button" href="{{route('product_details',[$key->id])}}"
                            rel="nofollow">View Product</a>
                        @if(@$key->shipping_time == 'yes')
                        <p class="amr-shipping-estimate">
                            <i class="icon amr-order-tracking"></i> Delivery - {{@$key->estimate_time}}
                        </p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="products row justify-content-center">
                <img src="{{url('not-found.jpg')}}" style="max-width:50% !important;">
            </div>
            @endif

            <div class="text-center pagination-col">
                       {{ $product->appends(request()->query())->links() }}
            </div>

        </div>
</div>


</div>
</section>
<script type="text/javascript">
    function make_filter(type,id) {
        cat_array = '';
        brand_array = '';

        var brand_array = jQuery.map($('.brand:checkbox:checked'), function (n, i) {
            return n.value;
        }).join(',');
        var cat_array = jQuery.map($('.categories:checkbox:checked'), function (n, i) {
            return n.value;
        }).join(',');
        baseurl = "{{url('filter?')}}";
        if (cat_array!='') {
            cat = '&category='+cat_array;
        }else{
            cat = '';
        }

        if (brand_array!='') {
            brand = 'brand='+brand_array;
        }else{
            brand = '';
        }

        window.location.href=baseurl+brand+cat;
    }
</script>
@endsection