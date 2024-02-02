@extends('layouts.web')
@section('pagetitle')
Buy {{$product->name}}
@endsection
@section('pagebodyclass')
single-product full-width normal light-bg
@endsection
@section('content')

<?php
$onestar = 0;
$twostar = 0;
$threestar=0;
$fourstar=0;
$fivestar=0;
foreach($reviews as $key){
    if ($key->rating==1) {
        $onestar++;
    }
    if ($key->rating==2) {
        $twostar++;
    }
    if ($key->rating==3) {
        $threestar++;
    }
    if ($key->rating==4) {
        $fourstar++;
    }
    if ($key->rating==5) {
        $fivestar++;
    }
}
?>
<div class="breadcrumb-section" style="display:none">
    <div class="container">
        <ul class="breadcrumb" aria-label="breadcrumb">
            <li class="breadcrumb-item "><a href="{{url('/')}}">Home</a></li>
            @if($product->category_id)  
            <li class="breadcrumb-item"><a href="{{url('/')}}">{{ App\Http\Controllers\CommonController::getCategoryName($product->category_id) }}</a></li>
            @endif
            @if($product->sub_category_id)
            <li class="breadcrumb-item"><a href="{{url('/')}}">{{ App\Http\Controllers\CommonController::getSubCategoryName($product->sub_category_id) }}</a></li>
            @endif
            @if($product->child_category_id)
            <li class="breadcrumb-item"><a href="{{url('/')}}">{{ App\Http\Controllers\CommonController::getChildCategoryName($product->child_category_id) }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page"> {{$product->name}}</li>
        </ul>
    </div>
</div>
                                
<div class="product-detail-page light-grey-bg">
<section class="section padding-0">
    <div class="container">
        <div class="product-detail-section">
            <div class="product-detail-left">
                <div class="detail-box">
                    <div class="detail-box-inner">
                        <a class="add-to-wishlist {{($wishlist)?'wishlist-selected':''}}" onclick="add_wishlist('{{$product->id}}','wishlist')" href="JavaScript:void(0);"><i class="change-icon fa fa-heart-o"></i></a>
                        <div class="product-images-wrapper detail-box">
                            <div id="amr-single-product-gallery" class="amr-single-product-gallery amr-single-product-gallery--with-images amr-single-product-gallery--columns-4 images" data-columns="4">
                                <div class="amr-single-product-gallery-images" data-ride="amr-slick-carousel" data-wrap=".amrcart-product-gallery__wrapper" data-slick="{&quot;infinite&quot;:false,&quot;slidesToShow&quot;:1,&quot;slidesToScroll&quot;:1,&quot;dots&quot;:false,&quot;arrows&quot;:false,&quot;asNavFor&quot;:&quot;#amr-single-product-gallery .amr-single-product-gallery-thumbnails__wrapper&quot;}">
                                    <div class="amrcart-product-gallery amrcart-product-gallery--with-images amrcart-product-gallery--columns-4 images" data-columns="4">
                                        <figure class="amrcart-product-gallery__wrapper ">
                                            @php
                                            $image_array = explode(',',$product->image);    
                                            @endphp
                                            
                                            @for($i=0; $i < count($image_array); $i++)
                                            
                                            <div data-thumb="{{$image_array[$i]}}" class="amrcart-product-gallery__image else">
                                                <a href="{{$image_array[$i]}}" tabindex="0" data-fancybox="product-image">

                                                    <img width="600" height="600" src="{{$image_array[$i]}}" class="attachment-shop_single size-shop_single wp-post-image" alt="">
                                                </a>
                                            </div>
                                            @endfor


                                            @foreach($product_gallery as $key)
                                            <div data-thumb="{{ $key->images}}')}}" class="amrcart-product-gallery__image if">
                                                <a href="{{ $key->images}}" tabindex="0" data-fancybox="product-image">
                                                    <img width="600" height="600" src="{{ $key->images}}" class="attachment-shop_single size-shop_single wp-post-image" alt="">
                                                </a>
                                            </div>
                                            @endforeach
                                        </figure>
                                    </div>
                                    <!-- .amrcart-product-gallery -->
                                </div>
                                
                                <!-- .amr-single-product-gallery-images -->
                                <div class="amr-single-product-gallery-thumbnails" data-ride="amr-slick-carousel"
                                    data-wrap=".amr-single-product-gallery-thumbnails__wrapper"
                                    data-slick="{&quot;infinite&quot;:false,&quot;slidesToShow&quot;:4,&quot;slidesToScroll&quot;:1,&quot;dots&quot;:false,&quot;arrows&quot;:true,&quot;vertical&quot;:true,&quot;verticalSwiping&quot;:true,&quot;focusOnSelect&quot;:true,&quot;touchMove&quot;:true,&quot;prevArrow&quot;:&quot;&lt;a href=\&quot;#\&quot;&gt;&lt;i class=\&quot;icon amr-arrow-up\&quot;&gt;&lt;\/i&gt;&lt;\/a&gt;&quot;,&quot;nextArrow&quot;:&quot;&lt;a href=\&quot;#\&quot;&gt;&lt;i class=\&quot;icon amr-arrow-down\&quot;&gt;&lt;\/i&gt;&lt;\/a&gt;&quot;,&quot;asNavFor&quot;:&quot;#amr-single-product-gallery .amrcart-product-gallery__wrapper&quot;,&quot;responsive&quot;:[{&quot;breakpoint&quot;:765,&quot;settings&quot;:{&quot;vertical&quot;:false,&quot;horizontal&quot;:true,&quot;verticalSwiping&quot;:false,&quot;slidesToShow&quot;:4}}]}">
                                    <figure class="amr-single-product-gallery-thumbnails__wrapper">
                                    
                                        <?php
                                            $image_array = explode(',',$product->image);
                                        ?>
                                        @for($j=0; $j < count($image_array); $j++)
                                        <figure data-thumb="{{$image_array[$j]}}" class="amr-wc-product-gallery__image">
                                            <img width="180" height="180" src="{{$image_array[$j]}}"
                                                class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" alt="">
                                        </figure>
                                        @endfor
                                    
                                        @if(count($product_gallery))
                                        @foreach($product_gallery as $key)
                                        <figure data-thumb="{{ $key->images}}" class="amr-wc-product-gallery__image">
                                            <img width="180" height="180" src="{{ $key->images}}"
                                                class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" alt="">
                                        </figure>
                                        @endforeach
                                        @endif
                                    </figure>
                                    <!-- .amr-single-product-gallery-thumbnails__wrapper -->
                                </div>
                                <!-- .amr-single-product-gallery-thumbnails -->
                             </div>
                            <!-- .amr-single-product-gallery -->
                        </div>
                    </div>
                </div>
                <div class="detail-box product-description">
                    <div class="detail-box-inner">
                        <h2>Description</h2>
                        {!!$product->description!!}
                    </div>
                </div>
                 @if($product->policy)
                <div class="detail-box product-description">
                    <div class="detail-box-inner">
                        <h2>Terms and Conditions</h2>
                        {!!$product->policy!!}
                    </div>
                </div>
                @endif
            </div>
            <div class="product-detail-right">
                <div class="sticky">
                    <div class="product-detail-col">
                        <h1 class="product_title">{{$product->name}}</h1>
                        <!-- <div class="product-sku"> SKU <b>5487FB8/11</b></div> -->
                        @if($product->brand)
                        <div class="product-brand">
                            Brand <b><a href="{{url('brand/')}}/{{$product->brand}}">{{ App\Http\Controllers\CommonController::getBrandName($product->brand) }}</a></b>
                        </div>
                        @endif 

                        <div class="amrcart-product-rating">
                            <div class="star-rating">
                                <?php
                                if ($sum_of_review[0]->rating<=1){
                                    $product_rating = 20;
                                }else if($sum_of_review[0]->rating>1 && $sum_of_review[0]->rating<=2){
                                    $product_rating = 40;
                                }else if($sum_of_review[0]->rating>2 && $sum_of_review[0]->rating<=3){
                                    $product_rating = 60;
                                }else if($sum_of_review[0]->rating>3 && $sum_of_review[0]->rating<=4){
                                    $product_rating = 80;
                                }else if($sum_of_review[0]->rating>4 && $sum_of_review[0]->rating<=5){
                                    $product_rating = 100;
                                }
                                ?>
                                @if($reviews->count());
                                <span style="width:<?= $product_rating;?>%">Rated <strong class="rating">{{number_format($sum_of_review[0]->rating/$reviews->count())}}</strong> out of 5 based on <span class="rating">{{$reviews->count()}}</span> customer rating</span>
                                @endif
                            </div>
                            <a rel="nofollow" class="amrcart-review-link" href="#productReviews">(<span class="review-count">{{$reviews->count()}}</span> customer review)</a>
                        </div>
                        <div class="product-price">
                            @if($product->discount)
                            <del>{{$setting[0]->currency_sign}}{{ $product->mrp_price}}</del>
                            @endif
                            <ins>
                                {{$setting[0]->currency_sign}}{{ $product->sale_price}}
                            </ins>
                        </div>

                        @if($product->discount) @if($product->discount_type=='flat')
                            <div class="product-discount">{{$setting[0]->currency_sign}}{{ $product->discount}} Off</div>
                        @else
                            <div class="product-discount">{{ $product->discount}}% Off</div>
                        @endif
                        @endif

                        @if(count($product_size))
                        <div class="amr-product-size">
                            <label class="a-form-label">Size:</label>
                            <select class="form-control" id="product_size" name="product_size" onchange="change_product_size('{{$product->id}}')">
                                @foreach($product_size as $key)
                                <option value="{{$key->name}}" data-value="{{$key->price}}">{{$key->name}} - {{$setting[0]->currency_sign}}{{$key->price}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        @if(count($product_colors))
                        <div class="amr-product-color">
                            <ul id="menu">
                                @foreach($product_colors as $key)
                                <li class="color-list" data-value="{{$key->color_code}}">
                                    <div class="color-col" style="background-color: {{$key->color_code}}">
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        @endif

                        <?php
                            $stock = 0;
                            if (count($product_size)) {
                                foreach ($product_size as $key) {
                                    $stock += $key->quantity;
                                }
                            }
                            ?>
                        
                        <div class="amr-product-quantity main_qiantity">
                            <label>Quantity: </label>
                            <select class="form-control" name="quantity" id="detail_input{{$product->id}}">
                                    <option value="">Select</option>
                                    <?php
                                        for ($i = 1; $i <= $product->stock; $i++){
                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                        }
                                        ?>
                                </select>

                            <div class="amr-product-avai text-{{($product->stock)?'success':'error'}}">
                                {{ ($product->stock)? $product->stock.' in stock': 'Out of Stock'}}
                            </div>
                        </div>

                        <div class="product-actions">
                            <button class="single_add_to_cart_button button alt" data-id="{{$product->id}}" name="add-to-cart">Add to cart</button>
                        </div>


                    </div>
                    @if($product->shipping_time)
                    <div class="product-detail-col">
                        <div class="shipping-col">
                            <i class="icon amr-order-tracking"></i> Shipping <b>{{$product->estimate_time}}</b>
                        </div>
                    </div>
                    @endif
                    @if($product->vendor_id)
                        <div class="product-detail-col">
                            <div class="sold-by">
                                Sold by <b><a href="{{url('vendor/')}}/{{$product->vendor_id}}">{{ App\Http\Controllers\CommonController::getVendorName($product->vendor_id) }}</a></b>
                            </div>
                        </div>
                    @endif  
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section related-products">
    <div class="container">
        <div class="section-title">
            <h2 class="title">Related Products</h2>
        </div>
        <div class="row all-products"></div>
    </div>
</section>
<section class="section reviews-section" id="ProductReviews">
    <div class="container">
        <div class="row">
            @if($reviews->count() > 0)
            <div class="col-md-12">
                <div class="sticky-div">
                    <div class="detail-box">
                        <div class="detail-box-inner">
                            <div class="section-title">
                                <div class="d-flex align-items-center">
                                    <h2 class="title">Customers reviews</h2>
                                    <div class="star-reviews">
                                        <div class="rating-present" style="width:85%"></div>
                                        
                                        
                                    </div>
                                </div>
                                @if($reviews->count())
                                <div class="rating-average">{{number_format($sum_of_review[0]->rating/$reviews->count())}} average based on {{$reviews->count()}} reviews.</div>
                                @endif
                            </div>
                            <div class="reviews-ratting-section">
                                <?php
                                $fivestar_percent = $fivestar/$reviews->count()*100;
                                ?>
                                <div class="reviews-row d-flex align-items-center">
                                    <div class="side">5 star</div>
                                    <div class="middle">
                                        <div class="reviews-bar" style="width: {{number_format($fivestar_percent)}}%;"></div>
                                    </div>
                                    <div class="side right">{{number_format($fivestar_percent)}}%</div>
                                </div>
                                <?php
                                $fourstar_percent = $fourstar/$reviews->count()*100;
                                ?>
                                <div class="reviews-row d-flex align-items-center">
                                    <div class="side">4 star</div>
                                    <div class="middle">
                                        <div class="reviews-bar" style="width: {{$fourstar_percent}}%;"></div>
                                    </div>
                                    <div class="side right">{{$fourstar_percent}}%</div>
                                </div>
                                <?php
                                $threestar_percent = $threestar/$reviews->count()*100;
                                ?>
                                <div class="reviews-row d-flex align-items-center">
                                    <div class="side">3 star</div>
                                    <div class="middle">
                                        <div class="reviews-bar" style="width: {{$threestar_percent}}%;"></div>
                                    </div>
                                    <div class="side right">{{$threestar_percent}}%</div>
                                </div>
                                <?php
                                $twostar_percent = $twostar/$reviews->count()*100;
                                ?>
                                <div class="reviews-row d-flex align-items-center">
                                    <div class="side">2 star</div>
                                    <div class="middle">
                                        <div class="reviews-bar" style="width: {{$twostar_percent}}%;"></div>
                                    </div>
                                    <div class="side right">{{$twostar_percent}}%</div>
                                </div>
                                <?php
                                $onestar_percent = $onestar/$reviews->count()*100;
                                ?>
                                <div class="reviews-row d-flex align-items-center">
                                    <div class="side">1 star</div>
                                    <div class="middle">
                                        <div class="reviews-bar" style="width: {{$onestar_percent}}%;"></div>
                                    </div>
                                    <div class="side right">{{$onestar_percent}}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="write-review-col text-right"> <a href="{{url('orders')}}" class="btn">WRITE A REVIEW</a></div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="reviews-list">
                    <div class="headings mb-3">
                        <h4>Total comments({{$reviews->count()}})</h4>
                    </div>
                    @foreach($reviews as $review)
                    <div class="review-col card p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="reviewer-header d-flex flex-row align-items-center">
                                <img src="{{url('public/'.$review->image)}}" width="30" class="reviewer-img rounded-circle mr-2">
                                <div>
                                    <div class="reviewer-name">{{$review->name}}</div>
                                </div>
                            </div>
                            <div>
                                <div class="review-date">{{$common->time_elapsed_string($review->created_at)}}</div>                                      
                                <div class="icons align-items-center">
                                    @for($i=0; $i < $review->rating; $i++)
                                    <i class="fa fa-star text-warning"></i>
                                    @endfor
                                    
                                </div>
                            </div>
                        </div>
                        <div class="reviews-comments mt-2">
                            {{$review->comment}}
                        </div>
                    </div>
                    @endforeach
                    
                </div>
            </div>
            @else
            <div class="col-md-5">
                <div class="sticky-div">
                    <div class="detail-box">
                        <div class="detail-box-inner">
                            <div class="section-title">
                                <div class="d-flex align-items-center">
                                    <h2 class="title">No Review Yet.</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<section class="section questions-answers-section" id="ProductQuestionsAnswers">
    <div class="container">
        <div class="detail-box description">
            <div class="detail-box-inner">
                <div class="section-title">
                    <h2 class="title">Questions & Answers</h2>
                </div>
                <ul class="questions-answers">
                    <li class="qa">
                        <div class="question-col"><span>Q1.</span> How deep are the drawers front to back?</div>
                        <div class="answer-col">Bootstrap is a platform for web development based on a front-end framework. It is used to create exceptional responsive designs using HTML, and CSS. These templates are used for forms, tables, buttons, typography, models, tables, navigation, carousels and images. Bootstrap also has Javascript plugins, which are optional. Bootstrap is mostly preferred for developing mobile web applications.</div>
                    </li>
                    <li class="qa">
                        <div class="question-col"><span>Q2.</span> How deep are the drawers front to back?</div>
                        <div class="answer-col">Bootstrap is a platform for web development based on a front-end framework. It is used to create exceptional responsive designs using HTML, and CSS. These templates are used for forms, tables, buttons, typography, models, tables, navigation, carousels and images. Bootstrap also has Javascript plugins, which are optional. Bootstrap is mostly preferred for developing mobile web applications.</div>
                    </li>
                    <li class="qa">
                        <div class="question-col"><span>Q3.</span> How deep are the drawers front to back?</div>
                        <div class="answer-col">Bootstrap is a platform for web development based on a front-end framework. It is used to create exceptional responsive designs using HTML, and CSS. These templates are used for forms, tables, buttons, typography, models, tables, navigation, carousels and images. Bootstrap also has Javascript plugins, which are optional. Bootstrap is mostly preferred for developing mobile web applications.</div>
                    </li>
                    <li class="qa">
                        <div class="question-col"><span>Q4.</span> How deep are the drawers front to back?</div>
                        <div class="answer-col">Bootstrap is a platform for web development based on a front-end framework. It is used to create exceptional responsive designs using HTML, and CSS. These templates are used for forms, tables, buttons, typography, models, tables, navigation, carousels and images. Bootstrap also has Javascript plugins, which are optional. Bootstrap is mostly preferred for developing mobile web applications.</div>
                    </li>
                    <li class="qa">
                        <div class="question-col"><span>Q5.</span> How deep are the drawers front to back?</div>
                        <div class="answer-col">Bootstrap is a platform for web development based on a front-end framework. It is used to create exceptional responsive designs using HTML, and CSS. These templates are used for forms, tables, buttons, typography, models, tables, navigation, carousels and images. Bootstrap also has Javascript plugins, which are optional. Bootstrap is mostly preferred for developing mobile web applications.</div>
                    </li>
                    <li class="qa">
                        <div class="question-col"><span>Q6.</span> How deep are the drawers front to back?</div>
                        <div class="answer-col">Bootstrap is a platform for web development based on a front-end framework. It is used to create exceptional responsive designs using HTML, and CSS. These templates are used for forms, tables, buttons, typography, models, tables, navigation, carousels and images. Bootstrap also has Javascript plugins, which are optional. Bootstrap is mostly preferred for developing mobile web applications.</div>
                    </li>
                    <li class="qa">
                        <div class="question-col"><span>Q7.</span> How deep are the drawers front to back?</div>
                        <div class="answer-col">Bootstrap is a platform for web development based on a front-end framework. It is used to create exceptional responsive designs using HTML, and CSS. These templates are used for forms, tables, buttons, typography, models, tables, navigation, carousels and images. Bootstrap also has Javascript plugins, which are optional. Bootstrap is mostly preferred for developing mobile web applications.</div>
                    </li>
                    <li class="qa">
                        <div class="question-col"><span>Q8.</span> How deep are the drawers front to back?</div>
                        <div class="answer-col">Bootstrap is a platform for web development based on a front-end framework. It is used to create exceptional responsive designs using HTML, and CSS. These templates are used for forms, tables, buttons, typography, models, tables, navigation, carousels and images. Bootstrap also has Javascript plugins, which are optional. Bootstrap is mostly preferred for developing mobile web applications.</div>
                    </li>
                    <li class="qa">
                        <div class="question-col"><span>Q9.</span> How deep are the drawers front to back?</div>
                        <div class="answer-col">Bootstrap is a platform for web development based on a front-end framework. It is used to create exceptional responsive designs using HTML, and CSS. These templates are used for forms, tables, buttons, typography, models, tables, navigation, carousels and images. Bootstrap also has Javascript plugins, which are optional. Bootstrap is mostly preferred for developing mobile web applications.</div>
                    </li>
                    <li class="qa">
                        <div class="question-col"><span>Q10.</span> How deep are the drawers front to back?</div>
                        <div class="answer-col">Bootstrap is a platform for web development based on a front-end framework. It is used to create exceptional responsive designs using HTML, and CSS. These templates are used for forms, tables, buttons, typography, models, tables, navigation, carousels and images. Bootstrap also has Javascript plugins, which are optional. Bootstrap is mostly preferred for developing mobile web applications.</div>
                    </li>
                </ul>
                <div class="loadMore text-center">
                    <a href="javascript:;">More Frequently Asked Questions Answers <span class="down-arrow"></span></a></div>
            </div>
        </div>
    </div>
</section>
</div>

    <input type="hidden" id="is_size" value="<?=(count($product_size)) ? true : false?>">
    <input type="hidden" id="size" value="">
    <input type="hidden" id="is_color" value="{{(count($product_colors))?true:false}}">
    <input type="hidden" value="{{$product->stock}}" id="stock">
    <input type="hidden" id="color" value="">




            <script>
var site_url = $('.siteurl').data('url');
var currency = "{{$setting[0]->currency_sign}}";
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
            url:site_url+'/remove_from_cart_ajax',
            data:{cartid:id},
            cache:false,
            success:function(res){
                var ress = JSON.parse(res);
                if (ress.success) {
                    $('#cart_remove'+id+'').fadeOut(1200).css({'background-color':'#f2dede'});
                    get_cart();
                    $('.total').html(currency+ress.total);
                    $('.count').html(ress.count);
                    $('.title-item-count').html('('+ress.count+' Items)');
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
$('.minus.button.detail').click(function() {
    id = $(this).attr('data-id');
    quantity = $('#detail_input' + id).val();
    $.ajax({
        url: site_url+"/add_to_cart_ajax",
        data: {
            product_id: id,
            quantity: quantity
        },
        cache: false,
        success: function(response) {
            var ress = jQuery.parseJSON(response);
            if (ress.success) {
                $('.mini-cart').addClass('open');
                $('.list-cart').html(ress.data);
                $('.count').html(ress.count);
                $('.total').html(currency + ress.total);
                $('.title-item-count').html('('+ress.count+' Items)');
            } else {
                console.log(response);
            }
        }
    });
});

$('.single_add_to_cart_button').click(function() {
    amenties = {}
    id = $(this).attr('data-id');
    quantity = $('#detail_input' + id).val();
    if (quantity=='') {
        swal("Please select Quantity.");
        return false;
    }

    var stock = $('#stock').val();
    if ($('#is_size').val()) {
        if ($('#product_size').val() == '') {
            alert("Please select size.");
            return false;
        } else {
            amenties["size"] = $('#product_size').val();
        }
    }

    if ($('#is_color').val()) {
        if ($('#color').val() == '') {
            alert("Please select color.");
            return false;
        } else {
            amenties["color"] = $('#color').val();
        }
    }

    // if (quantity > $('#stock').val()) {
    //  alert("Only "+$('#stock').val()+" product available.");
    //  $('#detail_input'+id).val(0);
    //  return false;
    // }
    var jsonstr = JSON.stringify(amenties);

    $.ajax({
        url: site_url+"/add_to_cart_ajax",
        data: {
            product_id: id,
            quantity: quantity,
            amenties: jsonstr
        },
        cache: false,
        success: function(response) {
            var ress = jQuery.parseJSON(response);
            if (ress.success) {
                $('body').addClass('show-mini-cart');
                $('.list-cart').html(ress.data);
                $('.count').html(ress.count);
                $('.total').html(currency + ress.total);
                $('.title-item-count').html('('+ress.count+' Items)');
            }
        }
    });
});


            $('.color-list').on('click', function() {
                $('.color-list').removeClass('active');
                $(this).addClass('active');
                console.log($(this).attr('data-value'));
                $('#color').val($(this).attr('data-value'));
            });

            $('#product_size').change(function() {
                var value = $(this).val();
                var product_id = "{{$product->id}}";
                $('#size').val(value);
            });
            get_cart();

            function get_cart() {
                $.ajax({
                    url: site_url+"/get_cart_ajax",
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
            function change_product_size(productid){
                var size = $('#product_size').val();
                if (size=='') {
                    window.location.reload(true);
                }
                $('body').addClass('loader-show');
                $('body').removeClass('loader-hide');
                $.ajax({
                    url:"{{route('change_product_size')}}",
                    data:{productid:productid,size:size},
                    cache:false,
                    success:function(response){
                        var ress = JSON.parse(response);
                        $('body').addClass('loader-hide');
                        $('body').removeClass('loader-show');
                        console.log(ress);
                        if (ress.success) {
                            $('.price').html(ress.data.price);
                            $('.quantity_div').html(ress.data.product_count);
                            if (!ress.data.is_count) {
                                $('.amr-product-avai.alert').addClass('alert-error');
                                $('.amr-product-avai.alert').removeClass('alert-success');
                                $('.amr-product-avai.alert').html('Out of stock');
                                $('.main_qiantity').hide();
                            }else{
                                $('.amr-product-avai.alert').removeClass('alert-error');
                                $('.amr-product-avai.alert').addClass('alert-success');
                                $('.amr-product-avai.alert').html(ress.data.is_count+' in stock');
                                $('.main_qiantity').show();
                            }
                        }
                    }
                });
            }
$(function(){
    var size = $('#product_size').val();
    var productid = "{{$product->id}}";
     $.ajax({
        url:"{{route('change_product_size')}}",
        data:{productid:productid,size:size},
        cache:false,
        success:function(response){
            var ress = JSON.parse(response);
            $('body').addClass('loader-hide');
            $('body').removeClass('loader-show');
            console.log(ress);
            if (ress.success) {
                $('.price').html(ress.data.price);
                $('.quantity_div').html(ress.data.product_count);
                if (!ress.data.is_count) {
                    $('.amr-product-avai.alert').addClass('alert-error');
                    $('.amr-product-avai.alert').removeClass('alert-success');
                    $('.amr-product-avai.alert').html('Out of stock');
                    $('.main_qiantity').hide();
                }else{
                    $('.amr-product-avai.alert').removeClass('alert-error');
                    $('.amr-product-avai.alert').addClass('alert-success');
                    $('.amr-product-avai.alert').html(ress.data.is_count+' in stock');
                    $('.main_qiantity').show();
                }
            }
        }
    });
});
            </script>

            @endsection