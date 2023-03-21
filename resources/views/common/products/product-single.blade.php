@extends('layouts/master')
@section('title')
{{ $products['seo_title'] }}
@endsection
@section('description')
{{ $products['seo_desc'] }}@endsection
@section('keywords')
{{ $products['seo_key'] }}@endsection
@section('content')
 <!-- Slider Area Start-->  
  <!-- breadcumb Start-->
  	<div class="breadcumb-area product-bread">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 p-0">
								<ul class="list-inline">
								   <li class="list-inline-item"><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right" aria-hidden="true"></i></li>
									@for($i = 0; $i <= count(Request::segments()); $i++)
									<li class="list-inline-item">
									  <a href="">{{Request::segment($i)}}</a>
									  @if($i < count(Request::segments()) & $i > 0)
										{!!'<i class="fa fa-angle-right"></i>'!!}
									  @endif
									  </li>
									@endfor
								</ul>
                        </div>
                    </div>
                </div>
            </div>

  <!-- breadcumb End-->
             <!-- product details wrapper start -->
        <div class="product-details-wrapper">
            <div class="container">
                <div class="row">
                   @if(session('success'))
                        <div class="alert alert-success m-auto">
                            {{ session('success') }}
                        </div>
                    @endif  
                    <div class="col-lg-12 pt-5">
                        <!-- product details inner end -->
                        <div class="product-details-inner">
                            <div class="row">
                                <div class="col-lg-6 justify-content-center">
						<div id="sidebar">
							<div class="sidebar__inner">
                                <!-- fancy start -->
							<div class="app-figure" id="zoom-fig">
								<a id="Zoom-1" class="MagicZoom" title=""
									href="{{ url('/public/images/product_images'). '/' .$products['image']}}"
								>
									<img src="{{ url('/public/images/product_images'). '/' .$products['image']}}" alt=""/>
								</a>
								<div class="selectors">
								 @foreach($products['media'] as $gallery)
								   <a
										data-zoom-id="Zoom-1"
										href="{{ url('/public/images/product_images'). '/' . $gallery['media'] }}"
										data-image="{{ url('/public/images/product_images'). '/' .$gallery['media']}}"
									>
										<img srcset="{{ url('/public/images/product_images'). '/' .$gallery['media']}}" src="{{ url('/public/images/product_images'). '/' .$gallery['media']}}"/>
									</a>
								
									 @endforeach    
								</div>
							</div>
						</div>
					</div>

                                </div>
                                <div class="col-lg-6">
                               <div id="content"> 
                                 <div class="product-details-des mt-md-34 mt-sm-34">
                                        <h3>{{ $products['title'] }}</h3>
                                      
                                        <!--<div class="ratings">
                                            <span class="good"><i class="fa fa-star"></i></span>
                                            <span class="good"><i class="fa fa-star"></i></span>
                                            <span class="good"><i class="fa fa-star"></i></span>
                                            <span class="good"><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <div class="pro-review">
                                                <span>1 review(s)</span>
                                            </div>
                                        </div>
                                        <div class="customer-rev">
                                            <a href="#">(1 customer review)</a>
                                        </div>-->
										 <div class="pricebox">
                                            <span class="regular-price">
											@if($products['type'] == 'variable')
												From £{{ number_format($all_attributes[0]->variantprice,2)}}	(inc. VAT)
											@else
												£{{number_format($products['price'],2)}} (inc. VAT)
											@endif 
										
											</span>
                                        </div>
										 <p>{{ $products['short_description'] }}</p>
										
                                       
										
										<!---div class="variations-box d-flex align-items-center pb-3 form-group">
										<form name="variate_option" class="variateOption" method="POST" action="{{ route('variate.submit.product') }}">
										 {{ csrf_field() }}  
											<?php
											// if($finalAttr){
												// foreach($finalAttr as $fak => $fav){
													// echo '<div class="form-control col-md-12">';
													// echo '<label>'.$attr[$fak].':</label>';
													// echo '<select class="variation_option" name="variate_value['.$attr[$fak].']">';
													// echo '<option>Choose '.$attr[$fak].'</option>';
													// $fav = array_unique($fav, SORT_REGULAR);
													// foreach($fav as $ov){
														// echo '<option name="'.$option[$ov].'">'.$option[$ov].'</option>';
													// }
													// echo '</select>';
													// echo '</div>';
												// }
											// }
											?>
											
										<input type="hidden" name="slug" value="{{$products['slug'] }}">
										</form>
										</div---->
										<div class="variations-box d-flex align-items-center pb-3 form-group">
										<form name="variate_option" class="variateOption" method="POST" action="{{ route('variate.submit.product') }}">
										 {{ csrf_field() }}  
											<?php
											
											if($Finalvariations){
												foreach($Finalvariations as $fav){
													echo '<div class="form-control col-md-12">';
													echo '<label>'.$fav->option.':</label>';
													echo '<select class="variation_option" name="variate_value['.$fav->option.']">';
													echo '<option>Choose '.$fav->option.'</option>';
													foreach($Finalattribute_Option as $faq){
														if($fav->option == $faq->option){
														echo '<option name="'.$faq->options.'">'.$faq->options.'</option>';
														}
													}
													echo '</select>';
													echo '</div>';
													
												}
												
												
											}
												
											?>
											
										<input type="hidden" name="slug" value="{{$products['slug'] }}">
										</form>
										</div>
										<div id="price"></div>
                                        <div class="quantity-cart-box d-flex align-items-center pb-3">
                                            <div class="quantity">
                                                <div class="pro-qty"><input type="number" value="1" name="qty" class="qtyy"></div>
                                            </div>
                                            <div class="action_link">
                                               												
												<?php if($products['price'] == Null && $all_attributes[0]->variantprice){ ?>
												 <a class="buy-btn disable" href="{{ url('add-to-cart/'.$products['id']) }}/1">add to cart<i class="fa fa-shopping-cart"></i></a>
												<?php } elseif($products['price'] == Null) { ?>
												<span class="out_stock">Product is unavailable</span>
												<?php } else { ?>
													 <a class="buy-btn" href="{{ url('add-to-cart/'.$products['id']) }}/1">add to cart<i class="fa fa-shopping-cart"></i></a>
												<?php } ?>
                                            </div>
											<input type="hidden" class="productID" value="{{ $products['id'] }}">
											<input type="hidden" class="productURL" value="{{ url('/') }}">
                                        </div>
                                        
										<div class="postcode aftr_cart">
                                            <h5>SKU:<span>{{$products['sku']}}</span></h5> 
                                        </div>
										<div class="cat-pro aftr_cart">
                                            <h5>Category: <span>                                               
                                                @foreach($category_name as $cat)
                                                <a href="{{ url('/categories/').'/'.$cat->slug }}">{{ $cat->title.',' }}</a>
                                                @endforeach
                                            </span></h5>
                                        </div>
                                        <div class="availability mt-10 aftr_cart">
                                            <h5>Availability:<span>{{$products['stock']}}</span></h5>
                                        </div>
                                        
                                        <div class="share-icon mt-20 social-buttons aftr_cart">
										<?php $url = request()->fullUrl(); ?>
										 <h5>Follow us: </h5>
                                            <a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}"
                                               target="_blank">
                                               <i class="fa fa-facebook"></i>
                                            </a>
                                            <a class="twitter" href="https://twitter.com/intent/tweet?url={{ urlencode($url) }}"
                                               target="_blank">
                                                <i class="fa fa-twitter"></i>
                                            </a>
                                            <a class="google" href="https://plus.google.com/share?url={{ urlencode($url) }}"
                                               target="_blank">
                                               <i class="fa fa-google-plus"></i>
                                            </a>
                                        </div>
                                        <!--p>{{ Str::substr($products['short_description'], 0, 150) }}</p-->
                                    </div>
									<div class="product-description">
										<div class="row">
											<div class="col-lg-12 pt-5">
											<h3>Description</h3>
											<p>{!! $products['description']!!}</p>
											</div>
										</div>
									</div>
									<div class="additoanl-infor">
										<div class="row">
											<div class="col-lg-12 pt-5">
											<h3>Additional Information</h3>																	
											
											<div class="options">
											<?php $option_name =[];
													foreach($product_options as $option){		
														 $option_name[] =  $option->option;
													}
											?>
											<div class="product_options">
												
													<?php	$option_title = array_unique($option_name, SORT_REGULAR);
															
															foreach($option_title as $title){
																echo '<span>Other '.$title .' available:</span>';
																echo "<ul class='list-inline'>";
																	foreach($product_options as $option){
																		if($title == $option->option){
																			echo '<li class="list-inline-item">'. $option->options.'</li>';
																		}
																	}														
																echo "</ul>";												
															}
													?>
																									
											</div>
											</div>
											
											
											</div>
										</div>
									</div>
                                    <div class="product-description">
                                        <div class="row">
                                            <div class="col-lg-12 pt-5">
                                            <h3>Reviews</h3>
                                            <p>No reviews yet</p>
                                            </div>
                                        </div>
                                         
                                    </div>
									                          <!-- Slider Area End-->  
                                    </div>
                                </div>
                            </div>
                        </div>
					
						
                        <!-- product details inner end -->

                        <!-- product details reviews start -->
<!--                        <div class="product-details-reviews pt-5">
                            <div class="row">
                                <div class="col-lg-10 m-auto">
                                    <div class="product-review-info">
                                        <ul class="nav review-tab">
                                            <li>
                                                <a class="active" data-toggle="tab" href="#tab_one">description</a>
                                            </li>
                                            <li>
                                                <a data-toggle="tab" href="#tab_two">information</a>
                                            </li>
                                            <li>
                                                <a data-toggle="tab" href="#tab_three">reviews</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content reviews-tab">
                                            <div class="tab-pane fade show active" id="tab_one">
                                                <div class="tab-one">
                                                    <p>{{ $products['description'] }}</p>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab_two">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td>color</td>
                                                            <td>black, blue, red</td>
                                                        </tr>
                                                        <tr>
                                                            <td>size</td>
                                                            <td>L, M, S</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="tab_three">
                                                <form action="#" class="review-form">
                                                    <h5>1 review for Simple product 12</h5>
                                                    <div class="total-reviews">
                                                        <div class="rev-avatar">
                                                            <img src="assets/img/about/avatar.jpg" alt="">
                                                        </div>
                                                        <div class="review-box">
                                                            <div class="ratings">
                                                                <span class="good"><i class="fa fa-star"></i></span>
                                                                <span class="good"><i class="fa fa-star"></i></span>
                                                                <span class="good"><i class="fa fa-star"></i></span>
                                                                <span class="good"><i class="fa fa-star"></i></span>
                                                                <span><i class="fa fa-star"></i></span>
                                                            </div>
                                                            <div class="post-author">
                                                                <p><span>admin -</span> 30 Nov, 2018</p>
                                                            </div>
                                                            <p>Aliquam fringilla euismod risus ac bibendum. Sed sit amet sem varius ante feugiat lacinia. Nunc ipsum nulla, vulputate ut venenatis vitae, malesuada ut mi. Quisque iaculis, dui congue placerat pretium, augue erat accumsan lacus</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col">
                                                            <label class="col-form-label"><span class="text-danger">*</span> Your Name</label>
                                                            <input type="text" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col">
                                                            <label class="col-form-label"><span class="text-danger">*</span> Your Email</label>
                                                            <input type="email" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col">
                                                            <label class="col-form-label"><span class="text-danger">*</span> Your Review</label>
                                                            <textarea class="form-control" required></textarea>
                                                            <div class="help-block pt-10"><span class="text-danger">Note:</span> HTML is not translated!</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col">
                                                            <label class="col-form-label"><span class="text-danger">*</span> Rating</label>
                                                            &nbsp;&nbsp;&nbsp; Bad&nbsp;
                                                            <input type="radio" value="1" name="rating">
                                                            &nbsp;
                                                            <input type="radio" value="2" name="rating">
                                                            &nbsp;
                                                            <input type="radio" value="3" name="rating">
                                                            &nbsp;
                                                            <input type="radio" value="4" name="rating">
                                                            &nbsp;
                                                            <input type="radio" value="5" name="rating" checked>
                                                            &nbsp;Good
                                                        </div>
                                                    </div>
                                                    <div class="buttons">
                                                        <button class="sqr-btn" type="submit">Continue</button>
                                                    </div>
                                                </form>  end of review-form 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!-- product details reviews end --> 
                    

                    </div>
                </div>
            </div>
        </div>
        <!-- product details wrapper end -->
    <section class="sub-service service-top">
        <div class="container"> 
        <div class="mainHeading text-uppercase text-center mb-3">Related Products</div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="service-in">
<div id="owl-carousel6" class="owl-carousel owl-theme">
                            @foreach($product_name as $product_data)

                           <div class="item">
                                <div class="img_wrp">
                                 <img src="{{ url('/public/images/product_images/product_thumbnail'). '/' .$product_data[0]['image']}}" alt="Marine Plywood">
                                    <div class="img_text">
                                        <h5 class="title">{{ $product_data[0]['title'] }}</h5>
                                        <div class="price">£{{ $product_data[0]['price'] }}<span class="vat">(ex. VAT)</span></div>
                                        <a class="cart-btn d-flex justify-content-center" href="{{ url('add-to-cart/'.$product_data[0]['id']) }}">Add To Cart</a>
                                    </div>
                                </div>

                            </div>
                            @endforeach
                         </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
          
  <!-- Ctaegory area End-->
  <script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
<script>

    var popupSize = {
        width: 780,
        height: 550
    };

    $(document).on('click', '.social-buttons > a', function(e){

        var
            verticalPos = Math.floor(($(window).width() - popupSize.width) / 2),
            horisontalPos = Math.floor(($(window).height() - popupSize.height) / 2);

        var popup = window.open($(this).prop('href'), 'social',
            'width='+popupSize.width+',height='+popupSize.height+
            ',left='+verticalPos+',top='+horisontalPos+
            ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

        if (popup) {
            popup.focus();
            e.preventDefault();
        }

    }); 
	
	//quantity change
		$(document).on('click', '.qtyy', function(e){	
			var qty_val = $(this).val();
			var productID = $(".productID").val();
			var productURL = $(".productURL").val();
			
            var oldUrl = $('.buy-btn').attr('href');// Get current url			
            var newUrl = productURL+'/add-to-cart/'+productID+'/'+qty_val;
			
            $('.buy-btn').attr("href", newUrl); // Set herf value
			
    });  
</script>
@endsection