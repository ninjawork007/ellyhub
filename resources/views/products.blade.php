@extends('layouts.web')
@section('pagebodyclass')
full-width @endsection
@section('content')
<div id="primary" class="content-area">
    <main id="main" class="site-main container-fluid">
        <div class="filters container-fluid my-5">
            <ul class="all-filter">
                <li><a class="remove-filter" href="#">Used <i class="fa fa-times"></i> </a></li>
            </ul>
            <ul class="all-filter">
                <li><a class="remove-filter show-filters" data-target="ram-size" href="#">RAM Size <i class="fa fa-angle-down"></i></a>
                    <div class="all-filters" id="ram-size" style="display:none;">
                        <h6 class="text-black font-bold">RAM Size</h6>
                        <ul>
                            <li><label class="text-black"> <input type="checkbox" value="16"> 16 GB <span>(52, 558)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="8"> 8 GB <span>(62, 249)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="4"> 4 GB <span>(38, 632)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="32"> 32 GB <span>(15, 569)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="64"> 64 GB <span>(8, 783)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="512"> 512 GB <span>(3, 907)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="256"> 256 GB <span>(5, 400)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="2"> 2 GB <span>(5, 394)</span></label></li>
                        </ul>
                    </div>
                </li>
                <li><a class="remove-filter show-filters" data-target="screen-size" href="#">Screen Size <i class="fa fa-angle-down"></i></a>
                    <div class="all-filters" id="screen-size" style="display:none;">
                        <h6 class="text-black font-bold">RAM Size</h6>
                        <ul>
                            <li><label class="text-black"> <input type="checkbox" value="16"> 16 GB <span>(52, 558)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="8"> 8 GB <span>(62, 249)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="4"> 4 GB <span>(38, 632)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="32"> 32 GB <span>(15, 569)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="64"> 64 GB <span>(8, 783)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="512"> 512 GB <span>(3, 907)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="256"> 256 GB <span>(5, 400)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="2"> 2 GB <span>(5, 394)</span></label></li>
                        </ul>
                    </div>
                </li>
                <li><a class="remove-filter show-filters" data-target="processor" href="#">Processor <i class="fa fa-angle-down"></i></a>
                    <div class="all-filters" id="processor" style="display:none;">
                        <h6 class="text-black font-bold">RAM Size</h6>
                        <ul>
                            <li><label class="text-black"> <input type="checkbox" value="16"> 16 GB <span>(52, 558)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="8"> 8 GB <span>(62, 249)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="4"> 4 GB <span>(38, 632)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="32"> 32 GB <span>(15, 569)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="64"> 64 GB <span>(8, 783)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="512"> 512 GB <span>(3, 907)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="256"> 256 GB <span>(5, 400)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="2"> 2 GB <span>(5, 394)</span></label></li>
                        </ul>
                    </div>
                </li>
                <li><a class="remove-filter show-filters" data-target="os" href="#">Operating System <i class="fa fa-angle-down"></i></a>
                    <div class="all-filters" id="os" style="display:none;">
                        <h6 class="text-black font-bold">RAM Size</h6>
                        <ul>
                            <li><label class="text-black"> <input type="checkbox" value="16"> 16 GB <span>(52, 558)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="8"> 8 GB <span>(62, 249)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="4"> 4 GB <span>(38, 632)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="32"> 32 GB <span>(15, 569)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="64"> 64 GB <span>(8, 783)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="512"> 512 GB <span>(3, 907)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="256"> 256 GB <span>(5, 400)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="2"> 2 GB <span>(5, 394)</span></label></li>
                        </ul>
                    </div>
                </li>
                <li><a class="remove-filter show-filters" data-target="storage-type" href="#">Storage Type <i class="fa fa-angle-down"></i></a>
                    <div class="all-filters" id="storage-type" style="display:none;">
                        <h6 class="text-black font-bold">RAM Size</h6>
                        <ul>
                            <li><label class="text-black"> <input type="checkbox" value="16"> 16 GB <span>(52, 558)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="8"> 8 GB <span>(62, 249)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="4"> 4 GB <span>(38, 632)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="32"> 32 GB <span>(15, 569)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="64"> 64 GB <span>(8, 783)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="512"> 512 GB <span>(3, 907)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="256"> 256 GB <span>(5, 400)</span></label></li>
                            <li><label class="text-black"> <input type="checkbox" value="2"> 2 GB <span>(5, 394)</span></label></li>
                        </ul>
                    </div>
                </li>
            </ul>
            <ul class="all-filter">
                <li><a class="remove-filter show-filters" data-target="condition" href="#">Condition <i class="fa fa-angle-down"></i></a>
                    <div class="all-filters" id="condition" style="display:none;">
                        <h6 class="text-black font-bold">Condition</h6>
                        <ul>
                            <li><label class="text-black"> <input type="checkbox" value="16"> Tested for parts, No returns accepted</label></li>
                            <li><label class="text-black"> <input type="checkbox" value="16"> Untested Condition unknown, No returns accepted</label></li>
                            <li><label class="text-black"> <input type="checkbox" value="16"> Tested, 30 day warranty</label></li>
                            <li><label class="text-black"> <input type="checkbox" value="16"> New, 30 day warranty</label></li>
                            <li><label class="text-black"> <input type="checkbox" value="16"> Open Box, 30 day warranty</label></li>
                        </ul>
                    </div>
                </li>
                <li><a class="remove-filter show-filters" data-target="show_only" href="#">Show Only <i class="fa fa-angle-down"></i></a>
                    <div class="all-filters" id="show_only" style="display:none;">
                        <ul>
                            <li><label class="text-black"> <input type="checkbox" value="16"> Free Returns</label></li>
                            <li><label class="text-black"> <input type="checkbox" value="16"> Returns Accepted</label></li>
                            <li><label class="text-black"> <input type="checkbox" value="16"> Local Pickup</label></li>
                            <li><label class="text-black"> <input type="checkbox" value="16"> Free Shipping</label></li>
                            <li><label class="text-black"> <input type="checkbox" value="16"> Sold Items</label></li>
                        </ul>
                    </div>
                </li>
                <li><a class="remove-filter show-filters" data-target="sort" href="#">Sort: Best Match <i class="fa fa-angle-down"></i></a>
                    <div class="all-filters last-filter" id="sort" style="display:none;width:200px;">
                        <ul>
                            <li><label class="text-black"> <input type="radio" name="sort" value="best_match"> Best Match <i class="fa fa-check" style="display:none;"></i></label></li>
                            <li><label class="text-black"> <input type="radio" name="sort" value="returns_accepted"> Returns Accepted <i class="fa fa-check" style="display:none;"></i></label></li>
                            <li><label class="text-black"> <input type="radio" name="sort" value="local_pickup"> Local Pickup <i class="fa fa-check" style="display:none;"></i></label></li>
                            <li><label class="text-black"> <input type="radio" name="sort" value="free_shipping"> Free Shipping <i class="fa fa-check" style="display:none;"></i></label></li>
                            <li><label class="text-black"> <input type="radio" name="sort" value="sold_items"> Sold Items <i class="fa fa-check" style="display:none;"></i></label></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        @include('common.alerts')
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
<script>
    $('.show-filters').click(function(){
        var target = $(this).data('target');
        $('.all-filters').fadeOut();
        $('#'+target).fadeIn();
    });

    $(document).mouseup(function(e){
        var container = $(".all-filters");

        // If the target of the click isn't the container
        if(!container.is(e.target) && container.has(e.target).length === 0){
            $('.all-filters').fadeOut();
        }
    });

    $('.last-filter input[type="radio"]').click(function(){
        $('.last-filter').find('i').hide();
        $(this).parent().find('i').show();
    });
</script>
@endsection