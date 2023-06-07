@extends('layouts.admin')
@section('content')
<style type="text/css">
.form-control.readonly {
    background-color: #eaeaea;
    pointer-events: none;
}
hr {
    border-top: 1px solid #eaeaea;
}
input[type="checkbox"] {
    zoom: 2;
    margin-left: -4px;
}
.nav-pills.nav-pills-vertical {
    flex-direction: unset !important;
}

</style>
<script src="https://cdn.tiny.cloud/1/c2qcxj5f1jt89kcmq754gz0psi44pl01zjx6zehocfgeeq4j/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      toolbar_mode: 'floating',
   });
  
  </script>

<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">View Product</h4>
		 <a href="{{route('products')}}" class="btn btn-outline-info btn-sm"><i class="fa fa-arrow-left"></i></a>
		 <div class="row">
             <div class="col-md-12 col-xl-12 grid-margin stretch-card d-none d-md-flex">
              <div class="card">
                <div class="card-body">
                  <h4>{{$product->name}}</h4>
                  <hr>
				  
				  
				 
                  <div class="row">
                    <div class="col-12">
					 
				  
				  
                      <ul class="nav nav-pills nav-pills-primary" id="pills-tab" role="tablist" aria-orientation="vertical">
                        
						<li class="nav-item">
                          <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                            <i class="fa fa-list-alt menu-icon"></i>
                            Basic Info
                          </a>                          
                        </li>
						
						<li class="nav-item">
                          <a class="nav-link" id="v-pills-category-tab" data-toggle="pill" href="#v-pills-category" role="tab" aria-controls="v-pills-category" aria-selected="false">
                            <i class="fa fa-list-alt menu-icon"></i>
                            Category
                          </a>                          
                        </li>
						<li class="nav-item">
                          <a class="nav-link" id="v-pills-price-tab" data-toggle="pill" href="#v-pills-price" role="tab" aria-controls="v-pills-price" aria-selected="false">
                            <i class="fa fa-list-alt menu-icon"></i>
                            Price
                          </a>                          
                        </li>
						
                        <li class="nav-item">
                          <a class="nav-link" id="v-pills-gallery-tab" data-toggle="pill" href="#v-pills-gallery" role="tab" aria-controls="v-pills-gallery" aria-selected="false">
                            <i class="fa fa-list-alt menu-icon"></i>
                            Gallery
                          </a>                          
                        </li>
						
						
						
                        <li class="nav-item">
                          <a class="nav-link" id="v-pills-attributes-tab" data-toggle="pill" href="#v-pills-attributes" role="tab" aria-controls="v-pills-attributes" aria-selected="false">
                           <i class="fa fa-list-alt menu-icon"></i>
                            Attributes
                          </a>                          
                        </li>
						
						
						
						
						
                      </ul>
                    </div>
                    <div class="col-12">
                      <div class="tab-content tab-content-vertical" id="v-pills-tabContent">
                      
					  <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                          <div class="media">
                            <div class="media-body">
							
							 <div class="row">
								   <label class="col-sm-3 col-form-label">Name<span>*</span></label>
								   <div class="col-sm-9"> 	{{$product->name}} </div>
							  </div>
							  
							  <div class="row">
								   <label class="col-sm-3 col-form-label">Slug<span>*</span></label>
								   <div class="col-sm-9"> 	{{$product->slug}} </div>
							  </div>
 
							 <div class="row">
								  <label class="col-sm-3 col-form-label">SKU<span>*</span></label>
								  <div class="col-sm-9"> 	{{$product->sku}}  </div>
							  </div>
							  
								<div class="row">
								  <label class="col-sm-3 col-form-label">HSN<span>*</span></label>
								  <div class="col-sm-9">
								{{$product->hsn}}
								  </div>
							  </div>
							  
							    <div class="row">
								  <label class="col-sm-3 col-form-label">Brand </label>
								  <div class="col-sm-9">
								   {{ App\Http\Controllers\CommonController::getBrandName($product->brand) }}
								  </div>
								</div>
							  
 
							  <div class="row">
								  <label class="col-sm-3 col-form-label">Tags</label>
								  <div class="col-sm-9">
									 {{$product->tags}} 
								  </div>
								</div>
							   
							   
							  <div class="row">
								  <label class="col-sm-3 col-form-label">Unit<span>*</span></label>
								  <div class="col-sm-9">
									 {{$product->unit}} 
								  </div>
								</div>
							   
							  <div class="row">
								  <label class="col-sm-3 col-form-label">Short Description<span>*</span></label>
								  <div class="col-sm-9">
									 {!!$product->short_description!!} 
								  </div>
								</div>
									    
							  <div class="row">
								  <label class="col-sm-3 col-form-label">Product Description<span>*</span></label>
								  <div class="col-sm-9">
									 {!!$product->description!!} 
								  </div>
								</div>
									   
							 <div class="row">
								  <label class="col-sm-3 col-form-label">Product Buy/Return Policy<span>*</span></label>
								  <div class="col-sm-9">
									 {!!$product->policy!!} 
								  </div>
								</div>
									 
							   <div class="row">
								  <label class="col-sm-3 col-form-label">Youtube Video URL<span>*</span></label>
								  <div class="col-sm-9">
									   {{$product->video_url}} 
								  </div>
								</div>
							  
							  
							  
							  <div class="row">
								  <label class="col-sm-3 col-form-label">Seo Title</label>
								  <div class="col-sm-9">
									 {{$product->seo_title}} 
								  </div>
								</div>
							  
							  
							  
							   <div class="row">
								  <label class="col-sm-3 col-form-label">Seo Description </label>
								  <div class="col-sm-9">
									 {{$product->seo_description}} 
								  </div>
								</div>
							  
							  
							  
							  <div class="row">
								  <label class="col-sm-3 col-form-label">Seo Tags</label>
								  <div class="col-sm-9">
									 {{$product->seo_tags}} 
								  </div>
								</div>
							 
									 
					  
                            </div>
                          </div>
                        </div>
						
						
                        <div class="tab-pane fade" id="v-pills-gallery" role="tabpanel" aria-labelledby="v-pills-gallery-tab">
                          <div class="media">
                             <div class="media-body">
							 
                                 <div class="col-md-12">
									<div class="form-group row">
									  <label class="col-sm-3 col-form-label">Product image<span>*</span></label>
									  <div class="col-sm-9">
										 @if(!empty($product->image))
											<img src="{{$product->image}}" id="product_img" alt="image" class="edit_img " />
									  	 @else
										    <img src="" id="product_img"  class="edit_img " />
										@endif
									   
									  </div>
									</div>
								  </div>
					  
								  <div class="col-md-12">
									<div class="form-group row">
									  <label class="col-sm-3 col-form-label">Product Gallery<span>*</span></label>
									     <div class="col-sm-9">
										   @if($product_gallery)
												@foreach($product_gallery as $key)
													<label id="gall_{{$key->id}}">
														<img src="{{$key->images}}" class="edit_img" /> 
													</label>
												@endforeach
										  @endif
										 
									  </div>
									</div>
								  </div>
 
							  
							  
                            </div>
                          </div>
                        </div>
					    
                       <div class="tab-pane fade" id="v-pills-category" role="tabpanel" aria-labelledby="v-pills-category-tab">
                          <div class="media">
                             <div class="media-body">
							 
                                <div class="row">
									  <label class="col-sm-3 col-form-label">Category<span>*</span></label>
									  <div class="col-sm-9">
									   {{ App\Http\Controllers\CommonController::getCategoryName($product->category_id) }}
									  </div>
								</div>
								
								  <div class="row">
											<label class="col-sm-3 col-form-label">Sub Category<span>*</span></label>
											<div class="col-md-9">
                                              {{ App\Http\Controllers\CommonController::getSubCategoryName($product->sub_category_id) }}
											</div>
								 </div>
								 
								 <div class="row">
											<label class="col-sm-3 col-form-label">Child Category<span>*</span></label>
											<div class="col-md-9">
                                              {{ App\Http\Controllers\CommonController::getChildCategoryName($product->child_category_id) }}
											</div>
								 </div>
								 
								 
					
					
                            </div>
                          </div>
                        </div>

						
                        <div class="tab-pane fade" id="v-pills-attributes" role="tabpanel" aria-labelledby="v-pills-attributes-tab">
                          <div class="media">
                             <div class="media-body">

                             	<div class="row">
																<div class="col-md-12">
																	<div class="form-group row">
																		<label class="col-sm-3 col-form-label">Product Type</label>
																		<div class="col-sm-9 radio-input d-flex">
																			<?php echo $product->product_type;?>
																		</div>
																	</div>
																</div>
															</div>
							 
                               <div class="row" >
								  <label class="col-sm-3 col-form-label"> Shipping Time</label>
								  <div class="col-sm-9">
									 <button class=" btn btn-outline-info btn-sm">
									 <?php if($product->shipping_time == 'yes') { echo 'Yes';  } else {  echo "No"; } ?></button>
								     <?php if($product->shipping_time == 'yes') { echo $product->estimate_time;  }   ?>
								   </div>
							  </div>
					  
					  <hr>

								<div class="row" >
									  <label class="col-sm-3 col-form-label">Allow Product Sizes</label>
									  <div class="col-sm-9">
										<button class=" btn btn-outline-info btn-sm"> <?php if($product_size) { echo 'Yes';  } ?> </button>
									  
											   <table>
												  @if(count($product_size))
													  <?php $psize = 1 ; ?>
													  @foreach($product_size as $key)
													  <tr>
													  <td>
															<label> Name :</label>
															 {{$key->name}} 
													  </td>
													  <td>
															<label> Qty :</label> 
															 {{$key->quantity}} 
													  </td>
													  <td>
															<label> Price :</label>
															 {{$key->price}} 
													  </td>
											 <?php $psize++ ; ?>
												  @endforeach
												  @endif
												  </table>
											 
											 
									   </div>
									
								  </div>
					  
					   
							<hr> 
 
								  <div class="row" >
									  <label class="col-sm-3 col-form-label">Allow Product Colors<span>*</span></label>
									  <div class="col-sm-9">
									    <button class=" btn btn-outline-info btn-sm"> <?php if($product_colors) { echo 'Yes';  } ?> </button>
									   
										   <div class="row prod_color" id="append_color">
												 @if(count($product_colors))
													 @foreach($product_colors as $key)
														<div class="col-md-3" style="padding: 10px;">
														    <input type="color"  class="form-control" value="{{$key->color_code}}" readonly>
														</div>
													  @endforeach
												  @endif
											</div>
									 </div>
								  </div>
                  
								<hr>
                            </div>
                          </div>
                        </div>
 
						
						<div class="tab-pane fade" id="v-pills-price" role="tabpanel" aria-labelledby="v-pills-price-tab">
                          <div class="media">
                             <div class="media-body">
							       	
					
									<div class="row" >
										  <label class="col-sm-3 col-form-label">Product MRP<span>*</span></label>
										  <div class="col-sm-9"> ₹:{{$product->mrp_price}}/-  </div>
									</div>
									
									<div class="row">
										  <label class="col-sm-3 col-form-label">Product  Discount</label>
										  <div class="col-sm-9">
											  <?php  if ($product->discount_type == 'flat')  { echo   '₹:'. $product->discount.'/-'; } ?>
											  <?php  if ($product->discount_type == 'percentage')  { echo   $product->discount.'%'; } ?>
										  </div>
									</div> 
					
									<div class="row"  >
									      <label class="col-sm-3 col-form-label">Product  Price</label>
										  <div class="col-sm-9"> ₹:{{$product->product_price}}/-  </div> 
									</div> 
					
					
									<div class="row"  >
											  <label class="col-sm-3 col-form-label">GST<span>*</span></label>
											  <div class="col-sm-9"> {{$product->gst}}% </div>
									 </div>
									 
									  
									<div class="row"  >
									<label class="col-sm-3 col-form-label">Sale Price</label>
										  <div class="col-sm-9">	 ₹:{{$product->sale_price}}/-  </div>
									</div> 
									   
									  
									<div class="row" id="stock">
									    <label class="col-sm-3 col-form-label">Stock<span>*</span></label>
										  <div class="col-sm-9">	{{$product->stock}} </div>
									</div>
					
					
							 
						 </div>
						</div>
						</div>
						
                      
					
					 </div>
                    </div>
					
                  </div>
				  
				   
                </div>
              </div>
            </div>
  
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        
      </div>
	    
					 
  
@endsection