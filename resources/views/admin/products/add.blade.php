@extends('layouts.admin')
@section('content')
<script src="https://cdn.tiny.cloud/1/c2qcxj5f1jt89kcmq754gz0psi44pl01zjx6zehocfgeeq4j/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
	tinymce.init({
		selector: 'textarea',
		plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
		toolbar_mode: 'floating',
	});
</script>
<style type="text/css">
	.radio-input label {
		padding: 4px 24px;
	}
</style>
<div class="page-header no-gutters">
	<div class="d-md-flex m-b-15 align-items-center justify-content-between">
		<div class="align-items-center">
			<h2 class="header-title">Add Product</h2>
		</div>
		<div class="align-items-center">
			<div class="d-md-flex align-items-center justify-content-between">
				<a href="{{route('products')}}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
			</div>
		</div>
	</div>
</div>
<form class="form-sample" id="form" method="post" action="{{route('save_product')}}" data-parsley-validate="" enctype="multipart/form-data">
	@csrf
	<ul class="nav nav-tabs nav-justified" id="addProductTab" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" id="add-product-home-tab" data-toggle="tab" href="#add-product-home" role="tab" aria-controls="add-product-home" aria-selected="true">Basic Info</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="add-product-category-tab" data-toggle="tab" href="#add-product-category" role="tab" aria-controls="add-product-category" aria-selected="false">Category</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="add-product-price-tab" data-toggle="tab" href="#add-product-price" role="tab" aria-controls="add-product-price" aria-selected="false">Price</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="add-product-gallery-tab" data-toggle="tab" href="#add-product-gallery" role="tab" aria-controls="add-product-gallery" aria-selected="false">Gallery</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="add-product-attributes-tab" data-toggle="tab" href="#add-product-attributes" role="tab" aria-controls="add-product-attributes" aria-selected="false">Attributes</a>
		</li>
	</ul>
	<div class="container m-t-30">
		<div class="card">
			<div class="card-body">
				<div class="tab-content m-t-15" id="addProductTab">
					<div class="tab-pane fade show active" id="add-product-home" role="tabpanel" aria-labelledby="add-product-home-tab">
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Name<span>*</span></label>
							<div class="col-sm-9">
								<input type="text" class="form-control" value="" required="" id="title" name="name">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Slug<span>*</span></label>
							<div class="col-sm-9">
								<input type="text" class="form-control readonly" value="" required="" id="slug" name="slug">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">SKU<span>*</span></label>
							<div class="col-sm-9">
								<input type="text" class="form-control" value="" required="" name="sku">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">HSN<span>*</span></label>
							<div class="col-sm-9">
								<input type="text" class="form-control" required="" value="" name="hsn">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Brand </label>
							<div class="col-sm-9">
								<select class="form-control" name="brand">
									<option value="">Select Brand</option>
									@if(count($brand)) @foreach($brand as $key)
									<option value="{{$key->id}}">{{$key->title}}</option>
									@endforeach @endif
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Tags</label>
							<div class="col-sm-9">
								<input type="text" id="tags" class="form-control" value="" name="tags">
								<small>Add tag with comma separated value.</small>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Unit<span>*</span></label>
							<div class="col-sm-9">
								<input type="text" class="form-control" placeholder="Kg/Pc/Packet etc.." value="" name="unit">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Short Description<span>*</span></label>
							<div class="col-sm-9">
								<textarea class="form-control" name="short_description"> </textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Product Description<span>*</span></label>
							<div class="col-sm-9">
								<textarea class="form-control" name="description"> </textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Product Buy/Return Policy<span>*</span></label>
							<div class="col-sm-9">
								<textarea class="form-control" name="buy_rent_policy"> </textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Youtube Video URL</label>
							<div class="col-sm-9">
								<input type="text" name="video_url" value="" class="form-control" placeholder="Paste youtube url here">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Seo Title</label>
							<div class="col-sm-9">
								<input type="text" name="seo_title" value="" class="form-control" placeholder="Paste Seo Title here">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Seo Description </label>
							<div class="col-sm-9">
								<input type="text" name="seo_description" value="" class="form-control" placeholder="Paste Seo Description here">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Seo Tags</label>
							<div class="col-sm-9">
								<input type="text" name="seo_tags" value="" class="form-control" placeholder="Paste Seo Tags here">
							</div>
						</div>
						<div class="d-flex justify-content-between">
							<button class="btn btn-primary" id="home_next_btn" type="button">Next</button>
							<button class="btn btn-danger Save for later-btn" type="button">Save for later</button>
						</div>
					</div>
					<div class="tab-pane fade" id="add-product-gallery" role="tabpanel" aria-labelledby="add-product-gallery-tab">
						<div class="media">
							<div class="media-body">
								<div class="col-md-12">
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Product image<span>*</span></label>
										<div class="col-sm-6">
											<input type="file" class="form-control" required accept="image/x-jpg,image/jpeg,image/png" name="image" accept="image/*" onchange="loadFile(event)">
										</div>
										<div class="col-sm-3">
											<img src="" id="product_img" class="edit_img" />
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Product Gallery<span>*</span></label>
										<div class="col-sm-9">
											<input type="file" class="form-control" id="gallery-photo-add" name="gallery[]" accept="image/x-jpg,image/jpeg,image/png" multiple="">
											<small>Upload multiple images. you can click ctrl buton and select multiple images.</small>
										</div>
										<label class="col-sm-3"></label>
										<div class="col-sm-9">
											<label class="gallery_upload"> </label>
										</div>
									</div>
								</div>
								<div class="d-flex">
									<button class="btn btn-primary" id="back_to_price" type="button">Back</button>
									<button class="btn btn-primary" id="next_to_attribute" type="button">Next</button>
									<button class="btn ml-auto btn-danger Save for later-btn" type="button">Save for later</button>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="add-product-category" role="tabpanel" aria-labelledby="add-product-category-tab">
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
													<option value="{{$key->id}}">{{$key->name}}</option>
													@endforeach @endif
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="row" id="sub_category">
								</div>
								<div class="row" id="child_category">
								</div>
								<div class="d-flex">
									<button class="btn btn-primary" id="back_to_home" type="button">Back</button>
									<button class="btn btn-primary" id="next_to_pricenext" type="button">Next</button>
									<button class="btn btn-danger ml-auto Save for later-btn" type="button">Save for later</button>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="add-product-attributes" role="tabpanel" aria-labelledby="add-product-attributes-tab">
						<div class="media">
							<div class="media-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Product Type</label>
											<div class="col-sm-9 radio-input d-flex">
												<label for="new"><input id="new" type="radio" class="form-check-input" name="product_type" value="new" checked>New</label>
												<label for="used"><input id="used" type="radio" class="form-check-input" name="product_type" value="used">Used</label>
												<label for="parts"><input id="parts" type="radio" class="form-check-input" name="product_type" value="parts">Parts & Repair</label>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Allow Estimated Shipping Time</label>
											<div class="col-sm-9">
												<input type="checkbox" class="form-check-input" name="is_estimatetime" id="is_estimatetime" value="">
											</div>
											<label class="col-sm-3"></label>
											<div class="col-sm-9" id="estimatetime">
												<input type="text" class="form-control" name="estimate_time" value="" placeholder="Product Estimated Shipping Time">
											</div>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Allow Product Sizes</label>
											<div class="col-sm-9">
												<input type="checkbox" class="form-check-input" name="is_prod_size" id="is_prod_size" value="no">
											</div>
											<label class="col-sm-3"></label>
											<div class="col-sm-9">
												<div class="row prod_size">
													<table>
														<tr>
															<td>
																<label>Size Name :</label>
																<small>(eg. S,M,L,XL,XXL,3XL,4XL)</small>
																<input type="text" class="form-control" value="" name="size_name[]">
															</td>
															<td>
																<label>Size Qty :</label>
																<small>(Quantity of size)</small>
																<input type="number" class="form-control" value="" name="size_quantity[]">
															</td>
															<td>
																<label>Size Price :</label>
																<small>(With Base price)</small>
																<input type="number" class="form-control" value="" name="size_price[]">
															</td>
															<td>
																<span class="btn btn-outline-primary btn-sm prod_size" id="add_more_size" style="margin-top:26px;"><i class="fa fa-plus"></i></span>
															</td>
														</tr>
														<tbody id="append_prodsize"> </tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Allow Product Colors<span>*</span></label>
											<div class="col-sm-9">
												<input type="checkbox" class="form-check-input" name="is_prod_color" id="is_prod_color" value="no">
											</div>
											<label class="col-sm-3"></label>
											<div class="col-sm-9">
												<div class="row prod_color" id="append_color">
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

												<select class="form-control" required="" name="ebay_category_id" onchange="GetCustomFields(this)">

													<option value="">Select eBay Category</option>

													@if(count($ebay_category)) @foreach($ebay_category as $key)

													<option data-custom="{{$key->custom_fields}}" value="{{$key->category_id}}">{{$key->name}}</option>

													@endforeach @endif

												</select>

											</div>

										</div>

									</div>

								</div>

								<div class="row" id="LoadCustomFields">
								</div>

								<div class="row">
									<div class="form-group col-lg-4 col-md-6">
										<label class="form-label">eBay Payment Policy <span class="text-danger">*</span></label>
										<select name="payment_policy_id" id="edit_payment_policy_id" class="form-control">
											@foreach($ebay_payment_policies as $policy)
											<option value="{{ $policy->id }}">{{ $policy->name }}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group col-lg-4 col-md-6">
										<label class="form-label">eBay Shipping Policy <span class="text-danger">*</span></label>
										<select name="shipping_policy_id" id="edit_shipping_policy_id" class="form-control">
											@foreach($ebay_shipping_policies as $policy)
											<option value="{{ $policy->id }}">{{ $policy->name }}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group col-lg-4 col-md-6">
										<label class="form-label">Return Policy <span class="text-danger">*</span></label>
										<select name="return_policy_id" id="edit_return_policy_id" class="form-control">
											@foreach($ebay_return_policies as $policy)
											<option value="{{ $policy->id }}">{{ $policy->name }}</option>
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
										<input type="number" class="form-control text-center" id="edit_package_weight" name="package_weight" maxlength="190" min="0" step=".01" autocomplete="off" />
									</div>

								</div>
								<div class="row">
									<div class="form-group col-lg-4 col-md-6">
										<label class="form-label">Dimension Length <span class="text-danger">*</span></label>
										<input type="number" class="form-control text-center" id="edit_package_dimensions_length" name="package_dimensions_length" maxlength="190" min="0" step=".01" autocomplete="off" />

									</div>
									<div class="form-group col-lg-4 col-md-6">
										<label class="form-label">Dimension Width <span class="text-danger">*</span></label>
										<input type="number" class="form-control text-center" id="edit_package_dimensions_width" name="package_dimensions_width" maxlength="190" min="0" step=".01" autocomplete="off" />
									</div>
									<div class="form-group col-lg-4 col-md-6">
										<label class="form-label">Dimension Height <span class="text-danger">*</span></label>
										<input type="number" class="form-control text-center" id="edit_package_dimensions_height" name="package_dimensions_height" maxlength="190" min="0" step=".01" autocomplete="off" />
									</div>
								</div>
								<div class="row">
									<div class="form-group col-lg-4 col-md-6">
										<label class="form-label">Country <span class="text-danger">*</span></label>
										<select name="country" id="edit_country" class="form-control">
											<option value="US" selected="selected">United States</option>

											<option value="CA">Canada</option>
											<option value="UK">United Kingdom</option>

										</select>
									</div>
									<div class="form-group col-lg-4 col-md-6">
										<label class="form-label">City, State <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="edit_city_or_state" name="city_or_state" placeholder="City, State" autocomplete="off" />
									</div>
									<div class="form-group col-lg-4 col-md-6">
										<label class="form-label">Zip Code <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="edit_zip_code" name="zip_code" autocomplete="off" />
									</div>
								</div>

								<!--  ebay end here-->


								<div class="d-flex">
									<button class="btn mr-auto btn-primary" id="back_to_gallery" type="button">Back</button>
									<button class="btn btn-primary" type="submit">Submit</button>
									<button class="btn btn-danger Save for later-btn" type="button">Save for later</button>
								</div>
								<hr>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="add-product-price" role="tabpanel" aria-labelledby="add-product-price-tab">
						<div class="media">
							<div class="media-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Product MRP<span>*</span></label>
											<div class="col-sm-9">
												<input type="text" class="form-control" required="" value="" id="mrp_price" name="mrp_price">
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Product Discount</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" maxlength="3" value="" id="discount" name="discount">
											</div>
											<div class="col-sm-3">
												<select name="discount_type" id="discount_type" class="form-control">
													<option disabled> Select Discount Type</option>
													<option value="flat">Flat Rate</option>
													<option value="percentage">Percentage</option>
												</select>
												<small> Products Discount Type</small>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Product Price</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" readonly value="" id="regular_price" value="" name="product_price">
												<small>(Product Price will be calculated automatically)</small>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">GST<span>*</span></label>
											<div class="col-sm-9">
												<input type="text" class="form-control" maxlength="2" value="" id="gst" required="" name="gst" data-parsley-type="digits">
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
												<input type="text" class="form-control" readonly id="gst_pric" value="" name="gst_price">
												<small>(GST price for this product)</small>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Commission</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="commission" value="" name="commission">
												<small>(Commission in %)</small>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Shipping Charges</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="shipping_charges" value="" name="shipping_charges">
											</div>
										</div>
									</div>
								</div>
								<div class="row" id="stock">
									<div class="col-md-12">
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Stock<span>*</span></label>
											<div class="col-sm-9">
												<input type="text" class="form-control" value="" id="stock_value" name="stock">
												<input type="hidden" class="form-control" value="1" id="save_state" name="save_state">
											</div>
										</div>
									</div>
								</div>
								<div class="row col-md-12">
									<button class="btn btn-primary" id="back_to_category" type="button">Back</button>
									<button class="btn btn-primary" id="next_to_gallery" type="button">Next</button>
									<button class="btn ml-auto btn-danger Save for later-btn" type="button">Save for later</button>
								</div>
							</div>
						</div>
					</div>
					<div class="row col-md-12 " id="submit_button">
						<input type="submit" class="btn btn-outline-primary btn-fw pull-right" value="Save">
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
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
						$($.parseHTML('<img class="edit_img  del_' + g + ' "> <i class="fa fa-trash delete_gallery del_' + g + ' " onclick="del_gallery(' + g + ')"></i>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
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
		$(this).fadeOut(1200).css({
			'background-color': '#f2dede'
		});
	};
</script>
<script>
	
	/**
	 * save to draft product
	 * 2023-06-11
	 * Author - Ilia
	 */
	$('body').on('click', '.Save', function(e) {
		e.preventDefault();
		$("#save_state").val(0);
		$('.form-control').prop('required',false);
		$('#submit_button input[type="submit"]').trigger('click');
	});
	/*Code For Show file After Load */
	var loadFile = function(event) {
		var reader = new FileReader();
		reader.onload = function() {
			var output = document.getElementById('product_img');
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
						url: '{{route("delete_product_gallery")}}',
						data: {
							id: id
						},
						cache: false,
						success: function(res) {
							if (res) {
								$('#gall_' + id + '').fadeOut(1200).css({
									'background-color': '#f2dede'
								});
							}
						}
					});
				}
			});
	};
	const calculateSale = (listPrice, discount) => {
		listPrice = parseFloat(listPrice);
		discount = parseFloat(discount);
		var total = ((listPrice * discount / 100)).toFixed(2); // Sale price
		return (total - listPrice).toFixed(2);
	}
	/* Price Calculate*/
	final_price();
	$("#mrp_price").keyup(function(event) {
		final_price();
		var mrp_price = $("#mrp_price").val();
	});
	$("#discount").keyup(function(event) {
		final_price();
	});
	$("#discount_type").change(function(event) {
		final_price();
	});
	$("#regular_price").keyup(function(event) {
		final_price();
	});
	$("#gst").keyup(function(event) {
		var gst = $("#gst").val();
		if (gst > 100) {
			alert("Maximum gst will be 18% only/-");
			// var gst = $("#gst").val('18');
			final_price();
			return false();
		}
		final_price();
	});
	$("#sale_price").keyup(function(event) {
		final_price();
	});

	function final_price() {
		var mrp_price = $("#mrp_price").val();
		var discount = $("#discount").val();
		var discount_type = $("#discount_type").find(":selected").val();
		var regular_price = $("#regular_price").val();
		var gst = $("#gst").val();
		var sale_price = $("#sale_price").val();
		if (discount_type == "flat") {
			var final_price = parseFloat(mrp_price) - parseFloat(discount);
			var regular_price = parseFloat(final_price) || parseFloat(mrp_price);
			var discount = $("#regular_price").val(regular_price);
		} else if (discount_type == "percentage") {
			var discou = mrp_price * discount;
			var discount_price = discou / 100;
			var discount_price = discount_price.toFixed(1);
			var regprice = parseFloat(mrp_price) - parseFloat(discount_price);
			var regular_price = parseFloat(regprice) || parseFloat(mrp_price);
			var discount = $("#regular_price").val(regular_price);
		}
		if (gst) {
			var gst_slav = (parseInt(gst) + 100);
			var gst_price = ((regular_price / gst_slav) * 100).toFixed(2);
			// console.log(regular_price);
			$('#gst_pric').val((regular_price - gst_price).toFixed(2));
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

	function convertToSlug(Text) {
		return Text.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
	}
	$('select[name="category"]').change(function() {
		if ($(this).val() == '') {
			alert("Please select Category");
			$('#attributes').html('');
			$('#subcategory').remove();
			$('#childcategory').remove();
			return false;
		}
		$.ajax({
			url: "{{route('get_sub_category')}}",
			data: {
				id: $(this).val(),
				datatype: 'html'
			},
			cache: false,
			success: function(response) {
				var ress = JSON.parse(response);
				$('#sub_category').html(ress.data);
				// $('#attributes').append(ress.attribute);
			}
		});
	});
	$('body').on('change', '#sub_category', function() {
		if ($(this).val() == '') {
			$('.sub_cat_attribute').remove();
			return false;
		}
		var category_id = $('select[name="category"]').val();
		$.ajax({
			url: "{{route('get_child_category')}}",
			data: {
				sub_cat_id: $(this).val(),
				datatype: 'html',
				cat_id: category_id
			},
			cache: false,
			success: function(response) {
				var ress = JSON.parse(response);
				$('#child_category').html(ress.data);
				//$('#attributes').append(ress.attribute);
			}
		});
	});
	$('#estimatetime').hide();
	$('body').on('click', '#is_estimatetime', function() {
		if ($(this).is(':checked')) {
			$('#estimatetime').show();
			$('#is_estimatetime').val('yes');
		} else {
			$('#estimatetime').hide();
			$('#is_estimatetime').val('no');
		}
	});
	$('.prod_size').hide();
	$('body').on('click', '#is_prod_size', function() {
		if ($(this).is(':checked')) {
			$('#stock').hide();
			$('.prod_size').show();
			$('#is_prod_size').val('yes');
		} else {
			$('#stock').show();
			$('.prod_size').hide();
			$('#is_prod_size').val('no');
		}
	});
	$('body').on('click', '#add_more_size', function() {
		$('#append_prodsize').append('<tr><td><label>Size Name :</label> <input type="text" class="form-control" name="size_name[]"></td><td><label>Size Qty :</label> <input type="number" class="form-control" name="size_quantity[]"></td><td><label>Size Price :</label><input type="number" class="form-control" name="size_price[]"></td><td class="delete_attribute"><span class="btn  btn-sm btn-outline-danger " style="margin-top:26px;"><i class="fa fa-minus"></i></span></td></tr>');
	});
	//  
	$(document).on('click', '.delete_attribute', function() {
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
	$('.prod_color').hide();
	$('body').on('click', '#is_prod_color', function() {
		if ($(this).is(':checked')) {
			$('.prod_color').show();
			$('#is_prod_color').val('yes');
		} else {
			$('.prod_color').hide();
			$('#is_prod_color').val('no');
		}
	});
	/* Add and Delete Color */
	$('body').on('click', '#add_more_color', function() {
		$('#append_color').append('<div class="col-md-3" style="padding: 10px;"><input type="color" class="form-control" name="prod_color[]" value=""> <span class="remove color-remove"><i class="fas fa-times"></i></span></div>');
	});
	$(document).on('click', '.color-remove', function() {
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
	$("#regular_price,#sale_price,#discount,#stock_value,#gst,#mrp_price").keydown(function(event) {
		if (event.shiftKey == true) {
			event.preventDefault();
		}
		if ((event.keyCode >= 48 && event.keyCode <= 57) ||
			(event.keyCode >= 96 && event.keyCode <= 105) ||
			event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
			event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {} else {
			event.preventDefault();
		}
		if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
			event.preventDefault();
	});
	// step form functions
	$('#home_next_btn').click(function() {
		$('.nav-link').removeClass('active');
		$('#add-product-category-tab').addClass('active');
		$('.tab-pane.fade').removeClass('active show');
		$('#add-product-category').addClass('active show');
		$("html, body").animate({
			scrollTop: 0
		}, "slow");
	});
	$('#next_to_pricenext').click(function() {
		$('.nav-link').removeClass('active');
		$('.tab-pane.fade').removeClass('active show');
		$('#add-product-price-tab').addClass('active');
		$('#add-product-price').addClass('active show');
		$("html, body").animate({
			scrollTop: 0
		}, "slow");
	});
	$('#back_to_home').click(function() {
		$('.nav-link').removeClass('active');
		$('.tab-pane.fade').removeClass('active show');
		$('#add-product-home-tab').addClass('active');
		$('#add-product-home').addClass('active show');
		$("html, body").animate({
			scrollTop: 0
		}, "slow");
	});
	$('#next_to_gallery').click(function() {
		$('.nav-link').removeClass('active');
		$('.tab-pane.fade').removeClass('active show');
		$('#add-product-gallery-tab').addClass('active');
		$('#add-product-gallery').addClass('active show');
		$("html, body").animate({
			scrollTop: 0
		}, "slow");
	});
	$('#back_to_category').click(function() {
		$('.nav-link').removeClass('active');
		$('.tab-pane.fade').removeClass('active show');
		$('#add-product-category-tab').addClass('active');
		$('#add-product-category').addClass('active show');
		$("html, body").animate({
			scrollTop: 0
		}, "slow");
	});
	$('#next_to_attribute').click(function() {
		$('.nav-link').removeClass('active');
		$('.tab-pane.fade').removeClass('active show');
		$('#add-product-attributes-tab').addClass('active');
		$('#add-product-attributes').addClass('active show');
		$("html, body").animate({
			scrollTop: 0
		}, "slow");
	});
	$('#back_to_price').click(function() {
		$('.nav-link').removeClass('active');
		$('.tab-pane.fade').removeClass('active show');
		$('#add-product-price-tab').addClass('active');
		$('#add-product-price').addClass('active show');
		$("html, body").animate({
			scrollTop: 0
		}, "slow");
	});
	$('#back_to_gallery').click(function() {
		$('.nav-link').removeClass('active');
		$('.tab-pane.fade').removeClass('active show');
		$('#add-product-gallery-tab').addClass('active');
		$('#add-product-gallery').addClass('active show');
		$("html, body").animate({
			scrollTop: 0
		}, "slow");
	});

	function GetCustomFields(obj) {
		var custom = $(obj).find(':selected').attr('data-custom')
		var json = JSON.parse(custom);
		console.log(json);

		$("#LoadCustomFields").html("");
		var HTML = "";

		for (i = 0; i < json.length; i++) {
			HTML += '<div class="form-group col-lg-4 col-md-6">';
			HTML += '<label class="form-label">' + json[i] + '<span class="text-danger">*</span></label>';
			HTML += '<input class="form-control text-center" name="custom[' + json[i] + ']" required autocomplete="off">';
			HTML += '</div>'
		}

		$("#LoadCustomFields").html(HTML);
	}
</script>
@endsection