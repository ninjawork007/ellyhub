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
.radio-input label {padding: 4px 24px;}
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

          <h4 class="card-title">Edit Product</h4>

		 <a href="{{route('products')}}" class="btn btn-outline-info btn-sm"><i class="fa fa-arrow-left"></i></a>

		 <a href="{{route('products')}}" class="btn btn-outline-info btn-sm"><i class="fa fa-eye"></i></a>

          <div class="row">

            <div class="col-md-12 col-xl-12 grid-margin stretch-card d-none d-md-flex">

              <div class="card">

                <div class="card-body">

                  <h4>{{$product->name}}</h4>

                  <hr>

				  

				  

				  <form class="form-sample" method="post" action="{{route('update_product')}}" data-parsley-validate="" enctype="multipart/form-data">

                    @csrf

					<input type="hidden" value="{{$product->id}}" name="id">

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

                                <div class="col-md-12">

								<div class="form-group row">

								  <label class="col-sm-3 col-form-label">Name<span>*</span></label>

								  <div class="col-sm-9">

									<input type="text" class="form-control" value="{{$product->name}}" required="" id="title" name="name">

								  </div>

								</div>

							  </div>

							   

							  <div class="col-md-12">

								<div class="form-group row">

								  <label class="col-sm-3 col-form-label">Slug<span>*</span></label>

								  <div class="col-sm-9">

									<input type="text" class="form-control readonly" value="{{$product->slug}}"  required="" id="slug" name="slug">

								  </div>

								</div>

							  </div>

							  <div class="col-md-12">

								<div class="form-group row">

								  <label class="col-sm-3 col-form-label">SKU<span>*</span></label>

								  <div class="col-sm-9">

									<input type="text" class="form-control" value="{{$product->sku}}"  required="" name="sku">

								  </div>

								</div>

							  </div>

							  

								<div class="col-md-12">

								<div class="form-group row">

								  <label class="col-sm-3 col-form-label">HSN<span>*</span></label>

								  <div class="col-sm-9">

									<input type="text" class="form-control" required=""  value="{{$product->hsn}}" name="hsn">

								  </div>

								</div>

							  </div>

							  

							  <div class="col-md-12">

								<div class="form-group row">

								  <label class="col-sm-3 col-form-label">Brand </label>

								  <div class="col-sm-9">

									<select class="form-control"  name="brand">

										  <option value="">Select Brand</option>

										    @if(count($brand)) @foreach($brand as $key)  

										       <option value="{{$key->id}}" {{ ($product->brand == $key->id) ? 'selected' : '' }}>{{$key->title}}</option>

										    @endforeach  @endif

									</select>

								  </div>

								</div>

							  </div>

							  

							  <div class="col-md-12">

								<div class="form-group row">

								  <label class="col-sm-3 col-form-label">Tags</label>

								  <div class="col-sm-9">

									<input type="text" id="tags" class="form-control"   value="{{$product->tags}}"    name="tags">

									<small>Add tag with comma separated value.</small>

								  </div>

								</div>

							  </div>

							   

							  <div class="col-md-12">

								<div class="form-group row">

								  <label class="col-sm-3 col-form-label">Unit<span>*</span></label>

								  <div class="col-sm-9">

									<input type="text" class="form-control" placeholder="Kg/Pc/Packet etc.." value="{{$product->unit}}"  required="" name="unit">

								  </div>

								</div>

							  </div>

							  

							  

							  

							    

									  <div class="col-md-12">

										<div class="form-group row">

										  <label class="col-sm-3 col-form-label">Short Description<span>*</span></label>

										  <div class="col-sm-9">

											<textarea class="form-control" name="short_description">{{$product->short_description}}</textarea>

										  </div>

										</div>

									  </div>

								 

									

									

							     

									  <div class="col-md-12">

										<div class="form-group row">

										  <label class="col-sm-3 col-form-label">Product Description<span>*</span></label>

										  <div class="col-sm-9">

											<textarea class="form-control" name="description">{{$product->description}}</textarea>

										  </div>

										</div>

									  </div>

									 

									

									

									

									 

									  <div class="col-md-12">

										<div class="form-group row">

										  <label class="col-sm-3 col-form-label">Product Buy/Return Policy<span>*</span></label>

										  <div class="col-sm-9">

											<textarea class="form-control" name="buy_rent_policy">{{$product->policy}}</textarea>

										  </div>

										</div>

									  </div>

									  

									

									  <div class="col-md-12">

										<div class="form-group row">

										  <label class="col-sm-3 col-form-label">Youtube Video URL</label>

										  <div class="col-sm-9">

											<input type="text" name="video_url"   value="{{$product->video_url}}" class="form-control"  placeholder="Paste youtube url here">

										  </div>

										</div>

									  </div>

									  

									  

									   <div class="col-md-12">

										<div class="form-group row">

										  <label class="col-sm-3 col-form-label">Seo Title</label>

										  <div class="col-sm-9">

											<input type="text" name="seo_title"   value="{{$product->seo_title}}" class="form-control"  placeholder="Paste Seo Title here">

										  </div>

										</div>

									  </div>

									  

									  

									   <div class="col-md-12">

										<div class="form-group row">

										  <label class="col-sm-3 col-form-label">Seo Description </label>

										  <div class="col-sm-9">

											<input type="text" name="seo_description"   value="{{$product->seo_description}}" class="form-control"  placeholder="Paste Seo Description here">

										  </div>

										</div>

									  </div>

									  

									  

									   <div class="col-md-12">

										<div class="form-group row">

										  <label class="col-sm-3 col-form-label">Seo Tags</label>

										  <div class="col-sm-9">

											<input type="text" name="seo_tags"   value="{{$product->seo_tags}}" class="form-control"  placeholder="Paste Seo Tags here">

										  </div>

										</div>

									  </div>
									  <div class="col-md-12">
									  	<button class="btn btn-primary" id="home_next_btn" type="button">Next</button>
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

									  <div class="col-sm-6">

										<input type="file" class="form-control"    <?php   if($product->image == "")  { echo ''; }  ?>  accept="image/x-jpg,image/jpeg,image/png"   name="image" accept="image/*" onchange="loadFile(event)">

											 

									  </div>

									  <div class="col-sm-3">

										 @if(!empty($product->image))

											<img src="{{url('public/'.$product->image)}}" id="product_img" alt="image" class="edit_img " />

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

										<input type="file" class="form-control"  id="gallery-photo-add"   name="gallery[]" accept="image/x-jpg,image/jpeg,image/png"   multiple="">

										<small>Upload multiple images. you can click ctrl buton and select multiple images.</small>

										</div>

										 <label class="col-sm-3"></label>

										 <div class="col-sm-9">

										   @if($product_gallery)

												@foreach($product_gallery as $key)

													<label id="gall_{{$key->id}}">

														<img src="{{url('public/'.$key->images)}}" class="edit_img" /> 

														<i class="fa fa-trash delete_gallery" onclick="delete_gallery({{$key->id}})" ></i>

													</label>

												@endforeach

										  @endif

										  <label class="gallery_upload">  	 </label>

									  </div>

									</div>

								  </div>
								  <div class="row col-md-12">
										<button class="btn btn-primary" id="back_to_price" type="button">Back</button>
										<button class="btn btn-primary" id="next_to_attribute" type="button">Next</button>
									</div>
 

							  

							  

                            </div>

                          </div>

                        </div>

					    

                       <div class="tab-pane fade" id="v-pills-category" role="tabpanel" aria-labelledby="v-pills-category-tab">

                          <div class="media">

                             <div class="media-body">

                                <div class="row" id="cat_row">

								  <div class="col-md-12">

									<div class="form-group row">

									  <label class="col-sm-3 col-form-label">Category<span>*</span></label>

									  <div class="col-sm-9">

										<select class="form-control" required="" name="category">

										  <option value="">Select Category</option>

										  @if(count($category)) @foreach($category as $key)

										  <option value="{{$key->id}}" {{ ($product->category_id == $key->id) ? 'selected' : '' }}>{{$key->name}}</option>

										  @endforeach @endif

										</select>

									  </div>

									</div>

								  </div>

								</div>

								

								  <div class="row" id="sub_category">

											<label class="col-sm-3 col-form-label">Sub Category<span>*</span></label>

											<div class="col-md-9" id="attributes">

												<select class="form-control" id="sub_category" name="sub_category">

												  <option value="">Select Category</option>

												  @if(count($subcategory)) @foreach($subcategory as $key)

												  <option value="{{$key->id}}" {{ ($product->sub_category_id == $key->id) ? 'selected' : '' }}>{{$key->title}}</option>

												  @endforeach @endif

												</select>

 

											</div>

								 </div>

								 <div class="row mt-5" id="child_category">

								 	@if(count($child_category))

								 	<label class="col-sm-3 col-form-label">Child Category</label>

								 	<div class="col-md-9" id="attributes">

												<select class="form-control" id="sub_category" name="sub_category">

												  <option value="">Select Child Category</option>

												  @foreach($child_category as $key)

												  <option value="{{$key->id}}" {{ ($product->child_category_id == $key->id) ? 'selected' : '' }}>{{$key->name}}</option>

												  @endforeach

												</select>

 

											</div>

								 	@endif

								 </div>
								<div class="row col-md-12">
									<button class="btn btn-primary" id="back_to_home" type="button">Back</button>
									<button class="btn btn-primary" id="next_to_pricenext" type="button">Next</button>
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
																			<label for="new"><input id="new" type="radio" class="form-check-input" name="product_type" value="new" <?php if($product->product_type=='new'){ echo 'checked';}?> >New</label>
																			<label for="used"><input id="used" type="radio" class="form-check-input" name="product_type" value="used" <?php if($product->product_type=='used'){ echo 'checked';}?> >Used</label>
																			<label for="parts"><input id="parts" type="radio" class="form-check-input" name="product_type" value="parts" <?php if($product->product_type=='parts'){ echo 'checked';}?> >Parts & Repair</label>
																		</div>
																	</div>
																</div>
															</div>

                               <div class="row" >

							  <div class="col-md-12">

								<div class="form-group row">

								  <label class="col-sm-3 col-form-label">Allow Estimated Shipping Time</label>

								  <div class="col-sm-9">

    <input type="checkbox" class="form-check-input" name="is_estimatetime" id="is_estimatetime" value="{{$product->shipping_time}}" {{ ($product->shipping_time) == 'yes' ? 'checked' : '' }} >

								  </div>

								 

								 <label class="col-sm-3"></label>

									 <div class="col-sm-9" id="estimatetime"  >

										<input type="text" class="form-control" name="estimate_time" value="{{$product->estimate_time}}" placeholder="Product Estimated Shipping Time">

										

								   </div>

								</div> 

								</div>

							  </div>

					  

					  <hr>



								<div class="row" >

								  <div class="col-md-12">

									<div class="form-group row">

									  <label class="col-sm-3 col-form-label">Allow Product Sizes</label>

									  <div class="col-sm-9">

									  

										<input type="checkbox" class="form-check-input" <?php if($product_size) { echo 'checked';  } ?> name="is_prod_size" id="is_prod_size" value="no">

									  </div>

									 

										<label class="col-sm-3"></label>

										 <div class="col-sm-9" >

											   <div class="row prod_size" >

			 

												  <table>

												  @if(count($product_size))

													  <?php $psize = 1 ; ?>

													  @foreach($product_size as $key)

													  <tr>

													  <td>

															<label>Size Name :</label>

															 <?php  if($psize == 1){ ?>  <small>(eg. S,M,L,XL,XXL,3XL,4XL)</small><?php } ?>

															<input type="text" class="form-control" value="{{$key->name}}" name="size_name[]">

													  </td>

													  <td>

															<label>Size Qty :</label> 

															 <?php  if($psize == 1){ ?> <small>(Quantity of size)</small><?php } ?>

															<input type="text" class="form-control" value="{{$key->quantity}}" name="size_quantity[]">

													  </td>

													  <td>

															<label>Size Price :</label>

															 <?php  if($psize == 1){ ?> <small>(With Base price)</small><?php } ?>

															<input type="text" class="form-control" value="{{$key->price}}" name="size_price[]">

													  </td>

													 <?php  if($psize == 1){ ?> 

													 <td> 

													  <span class="btn btn-outline-primary btn-sm prod_size"  id="add_more_size" style="margin-top:26px;"><i class="fa fa-plus"></i></span>

													  </td>

													 <?php } else{ ?>

													  <td class="delete_attribute"><span class="btn  btn-sm btn-outline-danger " style="margin-top:26px;"><i class="fa fa-minus"></i></span></td>

													 <?php } ?>

													   </tr>

													  

											 <?php $psize++ ; ?>

												  @endforeach

												  @else

												   <tr>

													  <td>

															<label>Size Name :</label>

															  <small>(eg. S,M,L,XL,XXL,3XL,4XL)</small>

															<input type="text" class="form-control" value="" name="size_name[]">

													  </td>

													  <td>

															<label>Size Qty :</label> 

															 <small>(Quantity of size)</small>

															<input type="text" class="form-control" value="" name="size_quantity[]">

													  </td>

													  <td>

															<label>Size Price :</label>

															 <small>(With Base price)</small>

															<input type="text" class="form-control" value="" name="size_price[]">

													  </td>

													 

													 <td> 

													  <span class="btn btn-outline-primary btn-sm prod_size"  id="add_more_size" style="margin-top:26px;"><i class="fa fa-plus"></i></span>

													  </td>

													 

													   </tr>

												  

												  @endif

												  <tbody id="append_prodsize" > </tbody>

												  

												  </table>

												  

											  </div>

											 

											

									   </div>

									</div> 

									</div>

								  </div>

					  

					   

							<hr> 

 

								  <div class="row" >

								  <div class="col-md-12">

									<div class="form-group row">

									  <label class="col-sm-3 col-form-label">Allow Product Colors<span>*</span></label>

									  <div class="col-sm-9">

									   <input type="checkbox" class="form-check-input"  <?php if($product_colors) { echo 'checked';  } ?> name="is_prod_color" id="is_prod_color" value="no">

									  </div>

									   <label class="col-sm-3"></label>

									  <div class="col-sm-9">

										   <div class="row prod_color" id="append_color">

												 @if(count($product_colors))

													 @foreach($product_colors as $key)

														<div class="col-md-3" style="padding: 10px;">

																<input type="color" value="{{$key->color_code}}" class="form-control" name="prod_color[]"  >

																 <span class="remove color-remove"><i class="fas fa-times"></i></span> 

														 </div>

													  @endforeach

												  @endif

											</div>

											<div class="row prod_color">

											  <button class="btn btn-outline-primary" type="button" id="add_more_color"><i class="fa fa-plus"></i> Add More color</button>

										   </div>

									 </div>

									</div> 

									</div>

								  </div>
                                  
                                 <!------------------ ebay start here--------------->
                                  <div class="row" id="cat_row">

								  <div class="col-md-12">

									<div class="form-group row">

									  <label class="col-sm-3 col-form-label">Category<span>*</span></label>

									  <div class="col-sm-9">

										<select class="form-control" required="" name="ebay_category_id">

										  <option value="">Select eBay Category</option>

										  @if(count($ebay_category)) @foreach($ebay_category as $key)

										  <option value="{{$key->category_id}}" {{ ($product->ebay_category_id == $key->category_id) ? 'selected' : '' }}>{{$key->name}}</option>

										  @endforeach @endif

										</select>

									  </div>

									</div>

								  </div>

								</div>
                                
                                <div class="row">
                                        <div class="form-group col-lg-4 col-md-6">
                                            <label class="form-label">eBay Payment Policy <span class="text-danger">*</span></label>
                                            <select name="payment_policy_id" id="edit_payment_policy_id" class="form-control">
                                                @foreach($ebay_payment_policies as $policy)
                                                    <option value="{{ $policy->id }}" {{ ($product->payment_policy_id == $policy->id) ? 'selected' : '' }}>{{ $policy->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6">
                                            <label class="form-label">eBay Shipping Policy <span class="text-danger">*</span></label>
                                            <select name="shipping_policy_id" id="edit_shipping_policy_id" class="form-control">
                                                @foreach($ebay_shipping_policies as $policy)
                                                    <option value="{{ $policy->id }}" {{ ($product->shipping_policy_id == $policy->id) ? 'selected' : '' }}>{{ $policy->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6">
                                            <label class="form-label">Return Policy <span class="text-danger">*</span></label>
                                            <select name="return_policy_id" id="edit_return_policy_id" class="form-control">
                                                @foreach($ebay_return_policies as $policy)
                                                    <option value="{{ $policy->id }}" {{ ($product->return_policy_id == $policy->id) ? 'selected' : '' }}>{{ $policy->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                
                                <div class="row">
                                        <div class="form-group col-lg-4 col-md-6">
                                            <label class="form-label">Package Type <span class="text-danger">*</span></label>
                                            <select name="package_type" id="edit_package_type" class="form-control">
                                                <option value="BulkyGoods">Bulky goods</option>
                                                <option value="Caravan">Caravan</option>
                                                <option value="Cars">Cars</option>
                                                <option value="CustomCode">Reserved for internal or future use.</option>
                                                <option value="Europallet">Europallet</option>
                                                <option value="ExpandableToughBags">Expandable Tough Bags</option>
                                                <option value="ExtraLargePack">Extra Large Package/Oversize 3</option>
                                                <option value="Furniture">Furniture</option>
                                                <option value="IndustryVehicles">Industry vehicles</option>
                                                <option value="LargeCanadaPostBox">Large Canada Post Box</option>
                                                <option value="LargeCanadaPostBubbleMailer">Large Canada Post Bubble Mailer</option>
                                                <option value="LargeEnvelope">LargeEnvelope</option>
                                                <option value="Letter" selected>Letter</option>
                                                <option value="MailingBoxes">Mailing Boxes</option>
                                                <option value="MediumCanadaPostBox">Medium Canada Post Box</option>
                                                <option value="MediumCanadaPostBubbleMailer">Medium Canada Post Bubble Mailer</option>
                                                <option value="Motorbikes">Motorbikes</option>
                                                <option value="None">None</option>
                                                <option value="OneWayPallet">Onewaypallet</option>
                                                <option value="PackageThickEnvelope">Package/thick envelope</option>
                                                <option value="PaddedBags">Padded Bags</option>
                                                <option value="ParcelOrPaddedEnvelope">Parcel or padded Envelope</option>
                                                <option value="Roll">Roll</option>
                                                <option value="SmallCanadaPostBox">Small Canada Post Box</option>
                                                <option value="SmallCanadaPostBubbleMailer">Small Canada Post Bubble Mailer</option>
                                                <option value="ToughBags">Tough Bags</option>
                                                <option value="UPSLetter">UPS Letter</option>
                                                <option value="USPSFlatRateEnvelope">USPS Flat Rate Envelope</option>
                                                <option value="USPSLargePack">USPS Large Package/Oversize 1</option>
                                                <option value="VeryLargePack">Very Large Package/Oversize 2</option>
                                                <option value="Winepak">Winepak</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6">
                                            <label class="form-label">Package Weight (lbs)<span class="text-danger">*</span></label>
                                            <input type="number" class="form-control text-center" id="edit_package_weight" value="{{ $product->package_weight }}" name="package_weight" maxlength="190" min="0" step=".01" autocomplete="off"/>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-md-6">
                                            <label class="form-label">Dimension Length <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control text-center" id="edit_package_dimensions_length" value="{{ $product->package_dimensions_length }}" name="package_dimensions_length" maxlength="190" min="0" step=".01" autocomplete="off"/>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6">
                                            <label class="form-label">Dimension Width <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control text-center" id="edit_package_dimensions_width" value="{{ $product->package_dimensions_width }}" name="package_dimensions_width" maxlength="190" min="0" step=".01" autocomplete="off"/>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6">
                                            <label class="form-label">Dimension Height <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control text-center" id="edit_package_dimensions_height" value="{{ $product->package_dimensions_height }}" name="package_dimensions_height" maxlength="190" min="0" step=".01" autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-md-6">
                                            <label class="form-label">Country <span class="text-danger">*</span></label>
                                            <select name="country" id="edit_country" class="form-control">
                                                <option value="US" selected="selected">United States</option>
                                               
                                                <option {{ ($product->country =='CA') ? 'selected' : '' }} value="CA">Canada</option>
                                                <option {{ ($product->country =='UK') ? 'selected' : '' }} value="UK">United Kingdom</option>
                                                 <option {{ ($product->country =='US') ? 'selected' : '' }} value="UK">United States</option>
                                                 <option {{ ($product->country =='IT') ? 'selected' : '' }} value="UK">Italy</option>
                                               
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6">
                                            <label class="form-label">City, State <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="edit_city_or_state" value="{{ $product->city_or_state }}" name="city_or_state" placeholder="City, State" autocomplete="off"/>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6">
                                            <label class="form-label">Zip Code <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="edit_zip_code" value="{{ $product->zip_code }}" name="zip_code" autocomplete="off"/>
                                        </div>
                                    </div>
                                
                              <!--  ebay end here-->
                                  
                                  
                                  
								  <div class="row col-md-12">
									
									<button class="btn btn-primary" id="back_to_gallery" type="button">Back</button>
									<button class="btn btn-primary"  type="submit">Update</button>
								</div>
                  

								<hr>

                            </div>

                          </div>

                        </div>



						

						<div class="tab-pane fade" id="v-pills-price" role="tabpanel" aria-labelledby="v-pills-price-tab">

                          <div class="media">

                             <div class="media-body">

							       	

					

									<div class="row" >

									  <div class="col-md-12">

										<div class="form-group row">

										  <label class="col-sm-3 col-form-label">Product MRP<span>*</span></label>

										  <div class="col-sm-9">

											 <input type="text" class="form-control" required="" value="{{$product->mrp_price}}" id="mrp_price" name="mrp_price">

										  </div>

										</div>

									  </div>

									</div>

									

									<div class="row">

									  <div class="col-md-12">

										<div class="form-group row">

										  <label class="col-sm-3 col-form-label">Product  Discount</label>

										  <div class="col-sm-6">

											 <input type="text" class="form-control"   maxlength="3"  value="{{$product->discount}}"  id="discount" name="discount">

										  </div>

										  <div class="col-sm-3">

											  <select name="discount_type" id="discount_type" class="form-control">

												<option  disabled> Select Discount Type</option> 

												<option value="flat"  {{ ($product->discount_type) == 'flat' ? 'selected' : '' }}>Flat Rate</option>

												<option value="percentage"  {{ ($product->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage</option>

											  </select>

											  <small> Products Discount Type</small>

										  </div>

										</div>

									  </div>

									</div> 

					

									<div class="row"  >

									  <div class="col-md-12">

										<div class="form-group row">

										  <label class="col-sm-3 col-form-label">Product  Price</label>

										  <div class="col-sm-9">

											 <input type="text" class="form-control" readonly  value="{{$product->product_price}}"  id="regular_price" value="" name="product_price">

											 <small>(Product Price will be calculated automatically)</small>

										  </div>

										</div>

									  </div>

									</div> 

					

					

									<div class="row"  >

										<div class="col-md-12">

											<div class="form-group row">

											  <label class="col-sm-3 col-form-label">GST<span>*</span></label>

											  <div class="col-sm-9">

												<input type="text" class="form-control" maxlength="2" value="{{$product->gst}}" id="gst" required="" name="gst" data-parsley-type="digits">

												<small>GST will be in Percentage.</small>

											 </div>

											</div>

										  </div>

									 </div>
									<div class="row">

									  <div class="col-md-12">

										<div class="form-group row">

										  <label class="col-sm-3 col-form-label">GST for product</label>

										  <div class="col-sm-9">

										  	<input type="text" class="form-control"  readonly id="gst_pric"  value="{{$product->gst_amount}}" name="gst_price">
											 <small>(GST price for this product)</small>

										  </div>

										</div>

									  </div>

									  <div class="col-md-12">

										<div class="form-group row">

										  <label class="col-sm-3 col-form-label">Commission</label>
										  <div class="col-sm-9">
											 <input type="text" class="form-control" id="commission"   value="{{$product->comission}}" name="commission">
											 <small>(Commission in %)</small>
										  </div>

										</div>

									  </div>
									  <div class="col-md-12">
										<div class="form-group row">
										  <label class="col-sm-3 col-form-label">Shipping Charges</label>
										  <div class="col-sm-9">
											 <input type="text" class="form-control" id="shipping_charges"   value="{{$product->shipping_charges}}" name="shipping_charges">
										  </div>
										</div>
									  </div>

									</div> 

									  

									  

									

									

									  

									<div class="row" id="stock">

									  <div class="col-md-12">

										<div class="form-group row">

										  <label class="col-sm-3 col-form-label">Stock<span>*</span></label>

										  <div class="col-sm-9">

											<input type="text" class="form-control"   value="{{$product->stock}}" id="stock_value" name="stock">

										  </div>

										</div>

									  </div>

									</div>
<div class="row col-md-12">
									<button class="btn btn-primary" id="back_to_category" type="button">Back</button>
									<button class="btn btn-primary" id="next_to_gallery" type="button">Next</button>
								</div>
					

					

							 

						 </div>

						</div>

						</div>

						

                     



                    <div class="row col-md-12">

                      <input type="submit" class="btn btn-outline-primary btn-fw pull-right" value="Update" id="submit_button">

                    </div>

					

					

					 </div>

                    </div>

					

                  </div>

				  

				   </form>

                </div>

              </div>

            </div>

			

			

				  

                    

                 

            

          </div>

        </div>

        <!-- content-wrapper ends -->

        <!-- partial:partials/_footer.html -->

        

      </div>

	    

					 

 <script>

					$(function() {
$('#submit_button').hide();
							// Multiple images preview in browser

							

							var imagesPreview = function(input, placeToInsertImagePreview) {

								

								if (input.files) {

									var filesAmount = input.files.length;

									var g = 1;

									for (i = 0; i < filesAmount; i++) {

										var reader = new FileReader();

										reader.onload = function(event) {

											$($.parseHTML('<img class="edit_img  del_'+g+' "> <i class="fa fa-trash delete_gallery del_'+g+' " onclick="del_gallery('+g+')"></i>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);

										}

										reader.readAsDataURL(input.files[i]);

									g++;

									}

								}

								

								};

							$('#gallery-photo-add').on('change', function() {

								imagesPreview(this, 'label.gallery_upload');

							});

					 		 

						}); 

					 var del_gallery = function(id) {

						$(this).fadeOut(1200).css({'background-color':'#f2dede'});

				    };

                    

					 </script>

  

 <script>
const calculateSale = (listPrice, discount) => {
  listPrice = parseFloat(listPrice);
  discount  = parseFloat(discount);
  var total =  (( listPrice * discount / 100 )).toFixed(2); // Sale price
  return (total-listPrice).toFixed(2);
}
    $('body').on('click','.tox-icon',function(){

	  // alert("asd");

	});

	/*Code For Show file After Load */

	var loadFile = function(event) {

	var reader = new FileReader();

	reader.onload = function(){

	  var output =  document.getElementById('product_img');

	  output.src = reader.result;

	};

	reader.readAsDataURL(event.target.files[0]);

	}; 



	/* delete_product_gallery*/

	var delete_gallery = function(id) {

	swal({

			title: "Are you sure?",

			text: "Once deleted, you will not be able to recover data!",

			icon: "warning",

			buttons: true,

			dangerMode: true,

		 })	

	  .then((willDelete) => {

		if (willDelete) {

		  $.ajax({

			url:'{{route("delete_product_gallery")}}',

			data:{id:id},

			cache:false,

			success:function(res){

			  if (res) {

				$('#gall_'+id+'').fadeOut(1200).css({'background-color':'#f2dede'});

			  }

			}

		  });

		} 

	  });											 

	};

	 

/////////////////////////////////////////////////* Price Calculate    */////////////////////////////////////

	final_price(); 
	$("#mrp_price").keyup(function (event) { 
	final_price(); 	
	 var mrp_price = $("#mrp_price").val();
	});

	$("#discount").keyup(function (event) { 
	final_price();  
	});

	$("#discount_type").change(function (event) { 
	final_price();
	}); 



	$("#regular_price").keyup(function (event) {
	final_price(); 
	});



	$("#gst").keyup(function (event) {

	  var gst = $("#gst").val();

	if(gst >100){

		alert("Maximum gst will be 18% only/-");

		 var gst = $("#gst").val('18');

		 final_price();

		return false();

	}

	final_price();

	});



	$("#sale_price").keyup(function (event) {

	final_price();

	});

	function  final_price(){

	  var mrp_price =   $("#mrp_price").val(); 

	  var discount = $("#discount").val();

	  var discount_type =   $("#discount_type").find(":selected").val(); 

	  var regular_price = $("#regular_price").val();

	  var gst = $("#gst").val();

	  var sale_price = $("#sale_price").val();
	  

	if(discount_type == "flat"){
			 var final_price = parseFloat(mrp_price) - parseFloat(discount);
			  var  regular_price = parseFloat(final_price) || parseFloat(mrp_price);
			  var discount = $("#regular_price").val(regular_price);
		} else if(discount_type == "percentage"){
				  var discou =  mrp_price*discount;
				  var discount_price =  discou/100;
				  var discount_price =  discount_price.toFixed(1);
				  var regprice = parseFloat(mrp_price) - parseFloat(discount_price);
				  var regular_price = parseFloat(regprice) || parseFloat(mrp_price);
				  var discount = $("#regular_price").val(regular_price);
		} 

								  


	  if(gst){  
	  	
		  var gst_slav =  (parseInt(gst)+100);
		  var gst_price = ((mrp_price/gst_slav)*100).toFixed(2);
		  $('#gst_pric').val((mrp_price-gst_price).toFixed(2));
		  //$('#gst_pric').val(calculateSale(regular_price,gst_slav));
		  // var gst_price =  gst_val/100;
		  // var gst_price =  gst_price.toFixed(0);

		  saleprice = parseFloat(regular_price) + parseFloat(gst_price);
		  //var discount = $("#sale_price").val(saleprice);
		  var discount = $("#sale_price").val(gst_price);
		  $("#final_price").val(saleprice);
	  }

		

	}



//////////////////////////////////////* Price Calculate End    *//////////////////////////////////////

					

	 

        $('#title').change(function(e) {

          $('#slug').val(convertToSlug($(this).val()));

        });



        function convertToSlug(Text){

            return Text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');

        }



        $('select[name="category"]').trigger("select");

        $('select[name="category"]').change(function(){

          if ($(this).val()=='') {

            alert("Please select Category");

            $('#attributes').html('');

            $('#sub_category').html('');

            $('#child_category').html('');

            return false;

          }

          $.ajax({

            url:"{{route('get_sub_category')}}",

            data:{id:$(this).val(),datatype:'html'},

            cache:false,

            success:function(response){

              var ress = JSON.parse(response);

              $('#sub_category').html(ress.data);

            }

          });

        });



        $('body').on('change','#sub_category',function(){

          if ($(this).val()=='') {

            $('.sub_cat_attribute').remove();

            return false;

          }

          var category_id = $('select[name="category"]').val();

          $.ajax({

            url:"{{route('get_child_category')}}",

            data:{sub_cat_id:$(this).val(),datatype:'html',cat_id:category_id},

            cache:false,

            success:function(response){

              var ress = JSON.parse(response);

              $('#child_category').html(ress.data);

              //$('#attributes').append(ress.attribute);



            }

          });

        });

       

		<?php if($product->shipping_time != 'yes'){ ?>    

		 $('#estimatetime').hide();

		<?php } ?>

        $('body').on('click','#is_estimatetime',function(){

          if ($(this).is(':checked')) {

            $('#estimatetime').show();

            $('#is_estimatetime').val('yes');

          }else{

            $('#estimatetime').hide();

            $('#is_estimatetime').val('no');

          }

        });



       

		<?php if(empty($product_size)){ ?>  

		  $('.prod_size').hide();

		<?php } ?>

		 

        $('body').on('click','#is_prod_size',function(){

          if ($(this).is(':checked')) {

            $('#stock').hide();

            $('.prod_size').show();

            $('#is_prod_size').val('yes');

          }else{

            $('#stock').show();

            $('.prod_size').hide();

            $('#is_prod_size').val('no');

          }

        });



        $('body').on('click','#add_more_size',function(){

          $('#append_prodsize').append('<tr><td><label>Size Name :</label> <input type="text" class="form-control" name="size_name[]"></td><td><label>Size Qty :</label> <input type="text" class="form-control" name="size_quantity[]"></td><td><label>Size Price :</label><input type="text" class="form-control" name="size_price[]"></td><td class="delete_attribute"><span class="btn  btn-sm btn-outline-danger " style="margin-top:26px;"><i class="fa fa-minus"></i></span></td></tr>');

        });

      //  

	  

	  $(document).on('click', '.delete_attribute' ,function() {

			  swal({

					title: "Are you sure?",

					text: "Once deleted, you will not be able to recover data!",

					icon: "warning",

					buttons: true,

					dangerMode: true,

				 })	

			  .then((willDelete) => {

				if (willDelete) {

				   $(this).parent().remove();

				} 

			  });

	  

       });

		  

  

	   <?php if(empty($product_colors)){ ?>  

		  $('.prod_color').hide();

		<?php } ?>

        $('body').on('click','#is_prod_color',function(){

          if ($(this).is(':checked')) {

            $('.prod_color').show();

            $('#is_prod_color').val('yes');

          }else{

            $('.prod_color').hide();

            $('#is_prod_color').val('no');

          }

        });

        

		

		/* Add and Delete Color */

        $('body').on('click','#add_more_color',function(){ 

         $('#append_color').append('<div class="col-md-3" style="padding: 10px;"><input type="color" class="form-control" name="prod_color[]" value=""> <span class="remove color-remove"><i class="fas fa-times"></i></span></div>');

        });

 

		  

		$(document).on('click', '.color-remove' ,function() {

			 swal({

					title: "Are you sure?",

					text: "Once deleted, you will not be able to recover data!",

					icon: "warning",

					buttons: true,

					dangerMode: true,

				 })	

			  .then((willDelete) => {

				if (willDelete) {

				   $(this).parent().remove();

				} 

			  });



		});

  

      $("#regular_price,#sale_price,#discount,#stock_value,#gst,#mrp_price").keydown(function (event) {

        if (event.shiftKey == true) {

            event.preventDefault();

        }

        if ((event.keyCode >= 48 && event.keyCode <= 57) || 

            (event.keyCode >= 96 && event.keyCode <= 105) || 

            event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||

            event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

        } else {

            event.preventDefault();

        }

        if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)

            event.preventDefault(); 

    });


// step form functions
$('#home_next_btn').click(function(){
	$('.nav-link').removeClass('active');
	$('#v-pills-category-tab').addClass('active');
	$('.tab-pane.fade').removeClass('active show');
	$('#v-pills-category').addClass('active show');
	$("html, body").animate({ scrollTop: 0 }, "slow");
});
$('#next_to_pricenext').click(function(){
	$('.nav-link').removeClass('active');
	$('.tab-pane.fade').removeClass('active show');
	$('#v-pills-price-tab').addClass('active');
	$('#v-pills-price').addClass('active show');
	$("html, body").animate({ scrollTop: 0 }, "slow");
});

$('#back_to_home').click(function(){
	$('.nav-link').removeClass('active');
	$('.tab-pane.fade').removeClass('active show');
	$('#v-pills-home-tab').addClass('active');
	$('#v-pills-home').addClass('active show');
	$("html, body").animate({ scrollTop: 0 }, "slow");
});

$('#next_to_gallery').click(function(){
	$('.nav-link').removeClass('active');
	$('.tab-pane.fade').removeClass('active show');
	$('#v-pills-gallery-tab').addClass('active');
	$('#v-pills-gallery').addClass('active show');
	$("html, body").animate({ scrollTop: 0 }, "slow");
});

$('#back_to_category').click(function(){
	$('.nav-link').removeClass('active');
	$('.tab-pane.fade').removeClass('active show');
	$('#v-pills-category-tab').addClass('active');
	$('#v-pills-category').addClass('active show');
	$("html, body").animate({ scrollTop: 0 }, "slow");
});

$('#next_to_attribute').click(function(){
	$('.nav-link').removeClass('active');
	$('.tab-pane.fade').removeClass('active show');
	$('#v-pills-attributes-tab').addClass('active');
	$('#v-pills-attributes').addClass('active show');
	$("html, body").animate({ scrollTop: 0 }, "slow");
});
$('#back_to_price').click(function(){
	$('.nav-link').removeClass('active');
	$('.tab-pane.fade').removeClass('active show');
	$('#v-pills-price-tab').addClass('active');
	$('#v-pills-price').addClass('active show');
	$("html, body").animate({ scrollTop: 0 }, "slow");
});

$('#back_to_gallery').click(function(){
	$('.nav-link').removeClass('active');
	$('.tab-pane.fade').removeClass('active show');
	$('#v-pills-gallery-tab').addClass('active');
	$('#v-pills-gallery').addClass('active show');
	$("html, body").animate({ scrollTop: 0 }, "slow");
});
      </script>

@endsection