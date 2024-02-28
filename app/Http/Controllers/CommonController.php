<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB,Auth;
use Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
class CommonController extends Controller
{
    public function __construct() {
            
    }
	//show admin page
	public function get_sub_category(Request $request){
        $category = DB::table('sub_categories')->where('category_id',$request->id)->get()->toarray();
         $html='';
         $attributehtml='';
        if (count($category)) {
            $attribute = DB::table('attribute')->where([['category_type','=','category'],['category_id','=',$request->id]])->get()->toarray();
            if (count($attribute)) {
                foreach ($attribute as $key) {
                    $attributehtml.='<div class="form-group row"><label class="col-sm-3 col-form-label">'  .ucwords($key->title).'</label><div class="col-sm-9">';
                    $options = DB::table('attribute_options')->where('attribute_id',$key->id)->get();
                    foreach ($options as $keyy) { 
                        $attributehtml.='<div class="form-check form-check-primary">
                            <label class="form-check-label">
							<input type="checkbox" class="form-check-input" name="'.$key->title.'[]" value="'.$keyy->title.'">
							'.ucwords($keyy->title).'
                            <i class="input-helper"></i></label>
                          </div>';
                    }
                    $attributehtml.='</div></div>';
                }
                
            }
			

            if ($request->datatype='html') {
                $html.='<div class="col-md-12" id="subcategory"><div class="form-group row"><label class="col-sm-3 col-form-label">Sub Category<span>*</span></label><div class="col-sm-9"><select class="form-control" name="sub_category" id="sub_category"><option value="">Select Sub Category</option>';
                foreach ($category as $key) {
                    $html.='<option value="'.$key->id.'">'.ucwords($key->title).'</option>';
                }
                $html.='</select></div></div></div>';
                echo json_encode(array('success'=>false,'data'=>$html,'message'=>'Sub category list.','attribute'=>$attributehtml));
            }else{
                echo json_encode(array('success'=>false,'data'=>$category,'message'=>'Sub category list.'));
            }
        }else{
            echo json_encode(array('success'=>false,'data'=>$html,'message'=>'No category found.'));
        }
	}

    public function get_child_category(Request $request){
        $html='';
        $attributehtml='';
        $attribute = DB::table('attribute')->where([['category_type','=','sub_category'],['category_id','=',$request->sub_cat_id]])->get()->toarray();
            if (count($attribute)) {
                foreach ($attribute as $key) {
                    $attributehtml.='<div class="form-group row sub_cat_attribute"><label class="col-sm-3 col-form-label">'.ucwords($key->title).'</label><div class="col-sm-9">';
                    $options = DB::table('attribute_options')->where('attribute_id',$key->id)->get();
                    foreach ($options as $keyy) {
					  $attributehtml.='<div class="form-check form-check-primary">
                            <label class="form-check-label">
							<input type="checkbox" class="form-check-input" name="'.$key->title.'[]" value="'.$keyy->title.'">
							'.ucwords($keyy->title).'
                            <i class="input-helper"></i></label>
                          </div>'; 
				 }
                    $attributehtml.='</div></div>';
                }
                
            }


        $category = DB::table('child_categories')->where([['category_id','=',$request->cat_id],['sub_category_id','=',$request->sub_cat_id]])->get()->toarray();
        if (count($category)) {
            if ($request->datatype='html') {
                
                $html.='<div class="col-md-12" id="childcategory"><div class="form-group row"><label class="col-sm-3 col-form-label">Child Category<span>*</span></label><div class="col-sm-9"><select class="form-control" name="child_category" ><option value="">Select Child Category</option>';
                foreach ($category as $key) {
                    $html.='<option value="'.$key->id.'">'.$key->name.'</option>';
                }
                $html.='</select></div></div></div>';
                echo json_encode(array('success'=>false,'data'=>$html,'message'=>'Sub category list.','attribute'=>$attributehtml));
            }else{
                echo json_encode(array('success'=>false,'data'=>$category,'message'=>'Sub category list.'));
            }
        }else{
            echo json_encode(array('success'=>false,'data'=>$html,'message'=>'No category found.','attribute'=>$attributehtml));
        }
    }

    public function get_featured_category(){
        $html='';
        $category = DB::table('categories')->orderby('id')->get();
        if (!$category->isEmpty()) {
            $html.='<div class="featured__first"><div class="ps-product--vertical"><a href="'.url('/category/'.$category[0]->id).'"><img class="ps-product__thumbnail" src="'.url('public/'.$category[0]->image).'" alt="alt" /></a><div class="ps-product__content"><a class="ps-product__name" href="'.url('/category/'.$category[0]->id).'">'.$category[0]->name.'</a><p class="ps-product__quantity"></p></div></div></div><div class="featured__group"><div class="row m-0">';
           for ($i=1; $i < $category->count(); $i++) { 
               $html.='<div class="col-sm-3 p-0"><div class="ps-product--vertical"><a href="'.url('/category/'.$category[0]->id).'"><img class="ps-product__thumbnail" src="'.url('public/'.$category[$i]->image).'" alt="alt" /></a><div class="ps-product__content"><a class="ps-product__name" href="'.url('/category/'.$category[0]->id).'">'.$category[$i]->name.'</a><p class="ps-product__quantity"></p></div></div></div>';
           }
           $html.='</div></div>';
        }else{
            $html.='<p class="nodata">No category.</p>';
        }
        echo $html;
    }

    public function get_product_ajax(Request $request){
        $product = DB::select(DB::raw("SELECT a.id, a.vendor_id, a.category_id, a.name, a.image, a.product_price, a.sale_price, a.status, a.modify_at, a.is_delete,(SELECT name FROM `categories` WHERE id=a.category_id) as category_name FROM products as a WHERE a.is_delete='0' AND a.status='approved' LIMIT 8"));
        $html='';
        if (count($product)) {
            foreach ($product as $key) {
                $html.='<div class="ps-product--standard"><a href="'.url('/product/'.$key->id).'"><img class="ps-product__thumbnail" src="'.url('public/'.$key->image).'" alt="alt" /></a><div class="ps-product__content"><p class="ps-product-price-block"><span class="ps-product__sale">'.$setting[0]->currency_sign.'2.90</span><span class="ps-product__price">'.$setting[0]->currency_sign.'4.90</span><span class="ps-product__off">25% Off</span></p><p class="ps-product__type"><i class="icon-store"></i>Bazarhat</p><a href="#"><h5 class="ps-product__name">Cornboat Holders</h5></a><div class="progress"><div class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div></div><p class="ps-product__sold">Sold: 0/40</p></div><div class="ps-product__footer"><div class="def-number-input number-input safari_only"><button class="minus" onclick="this.parentNode.querySelector("input[type=number]").stepDown()"><i class="icon-minus"></i></button><input class="quantity" min="0" name="quantity" value="1" type="number" /><button class="plus" onclick="this.parentNode.querySelector("input[type=number]").stepUp()"><i class="icon-plus"></i></button></div><div class="ps-product__total">Total: <span>'.$setting[0]->currency_sign.'2.90</span></div><button class="ps-product__addcart" data-toggle="modal" data-target="#popupAddToCart"><i class="icon-cart"></i>Add to cart</button><div class="ps-product__box"><a class="ps-product__wishlist" href="#">Wishlist</a><a class="ps-product__compare" href="#">Compare</a></div></div>';
            }
            $html.='</div>';
        }else{
            $html.='<p class="nodata">No Products.</p>';
        }
        echo $html;
    }
	
	
   public static function getCategoryName($category){
       $categories = DB::table('categories')->find($category);
       if( !empty($categories) ){
           return $categories->name;
       }else{
           return 'N-A';
       }
   }
   
   public static function getSubCategoryName($subcategories){
       $sub_categories = DB::table('sub_categories')->find($subcategories);
       if( !empty($sub_categories) ){
           return $sub_categories->title;
       }else{
           return 'N-A';
       }
   }
   
   public static function getChildCategoryName($childcategories){
       $childcat = DB::table('child_categories')->find($childcategories);
       if( !empty($childcat) ){
           return $childcat->name;
       }else{
           return 'N-A';
       }
   }
   public static function getBrandName($id){
       $brand = DB::table('brand')->find($id);
       if( !empty($brand) ){
           return $brand->title;
       }else{
           return 'N-A';
       }
   }
   
   public static function getVendorName($id){
       $brand = DB::table('users')->find($id);
       if( !empty($brand) ){
           return $brand->name;
       }else{
           return 'N-A';
       }
   }
   
   
       public function get_brand_product(Request $request){
         $product = DB::select(DB::raw(" SELECT    products.id as id , products.`name` , products.`slug` ,  products.`image` , products.`mrp_price`, products.`product_price` ,  products.`sale_price` , products.`discount_type` , products.`discount` , users.name as vendor_name ,products.`shipping_time` ,products.`estimate_time` , products.`stock`  , products.`gst` , products.`discount`  FROM `products`  INNER JOIN users ON  products.vendor_id=users.id  WHERE  products.is_delete='0' AND   products.brand='".$request->id."' AND products.status='approved' "));

		$html='';
        if (count($product)) {
            foreach ($product as $key) {   ?>
	   
					<div class="col-3 col-md-3 col-lg-2 p-0">
						<div class="ps-product--standard">  
						<a href="<?php echo url('/product'); ?>/<?php echo $key->id; ?>">
							 <img class="ps-product__thumbnail" src="<?php echo url('/public'); ?>/<?php echo $key->image; ?>" alt="alt">
						 </a>
						 <?php if( $key->discount_type== 'flat') { ?>
						 <span class="ps-badge ps-product__offbadge"> <?php echo $setting[0]->currency_sign;?><?php  echo $key->discount; ?> Off </span>
						 <?php  } ?>
						 <?php if( $key->discount_type== 'percentage') { ?>
						 <span class="ps-badge ps-product__offbadge"> <?php  echo $key->discount; ?>% Off </span>
						 <?php  } ?>

						<div class="ps-product__content">
						<p class="ps-product__type"><i class="icon-store"></i><?php echo  $key->vendor_name; ?></p>
						<h5><a class="ps-product__name" href="<?php echo url('/product'); ?>/<?php echo $key->id; ?>"><?php  echo $key->name; ?></a></h5>
						<!--p class="ps-product__unit">1 per pack</p-->
						<div class="ps-product__rating">
						<div class="br-wrapper br-theme-fontawesome-stars"><select class="rating-stars" style="display: none;">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4" selected="selected">4</option>
						<option value="5">5</option>
						</select><div class="br-widget"><a href="#" data-rating-value="1" data-rating-text="1" class="br-selected"></a><a href="#" data-rating-value="2" data-rating-text="2" class="br-selected"></a><a href="#" data-rating-value="3" data-rating-text="3" class="br-selected"></a><a href="#" data-rating-value="4" data-rating-text="4" class="br-selected br-current"></a><a href="#" data-rating-value="5" data-rating-text="5"></a><div class="br-current-rating">4</div></div></div><span>(6)</span>
						</div>
						<p class="ps-product-price-block">
						<span class="ps-product__sale"><?= $setting[0]->currency_sign; ?><?php echo  $key->mrp_price; ?></span>
						<span class="ps-product__price"><?= $setting[0]->currency_sign; ?><?php echo  $key->sale_price; ?></span>
						</p>
						<div class="progress">
						<div class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<?php if( $key->shipping_time== 'yes') { ?>
						   <p class="ps-product__sold"><i class="icon-truck"></i>  Delivery : <?php echo $key->estimate_time; ?></p>
						<?php } ?>
						</div>

						<div class="ps-product__footer">
						<div class="def-number-input number-input safari_only">
						<button class="minus" data-id="6" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
						<input class="quantity" data-id="6" min="0" name="quantity" value="1" type="number">
						<button class="plus" data-id="6" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
						</div>
						<button class="ps-product__addcart" data-toggle="modal" data-target="#popupAddToCart"><i class="icon-cart"></i>Add to cart</button>
						<div class="ps-product__box">
						<a class="ps-product__wishlist" onclick="add_wishlist('<?php echo  $key->id; ?>')" href="JavaScript:void(0);">Wishlist</a>
						<a class="ps-product__compare"  onclick="add_compare('<?php echo  $key->id; ?>')"  href="JavaScript:void(0);">Compare</a>
						
						</div>
						</div>
						</div>
					</div>


	   <?php
 		   // $html.='<div class="ps-product--standard"><a href="#"><img class="ps-product__thumbnail" src="'.url('public/'.$key->image).'" alt="alt" /></a><div class="ps-product__content"><p class="ps-product-price-block"><span class="ps-product__sale">₹2.90</span><span class="ps-product__price">₹4.90</span><span class="ps-product__off">25% Off</span></p><p class="ps-product__type"><i class="icon-store"></i>Bazarhat</p><a href="#"><h5 class="ps-product__name">Cornboat Holders</h5></a><div class="progress"><div class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div></div><p class="ps-product__sold">Sold: 0/40</p></div><div class="ps-product__footer"><div class="def-number-input number-input safari_only"><button class="minus" onclick="this.parentNode.querySelector("input[type=number]").stepDown()"><i class="icon-minus"></i></button><input class="quantity" min="0" name="quantity" value="1" type="number" /><button class="plus" onclick="this.parentNode.querySelector("input[type=number]").stepUp()"><i class="icon-plus"></i></button></div><div class="ps-product__total">Total: <span>₹2.90</span></div><button class="ps-product__addcart" data-toggle="modal" data-target="#popupAddToCart"><i class="icon-cart"></i>Add to cart</button><div class="ps-product__box"><a class="ps-product__wishlist" href="#">Wishlist</a><a class="ps-product__compare" href="#">Compare</a></div></div>';
            }
            
        }else {  ?>
             <p class="nodata">No Products.</p> 
        <?php  }
         
    }
	
	
	 public function add_wishlist(Request $request){
         /*if(empty(Auth::user()->id)){
             echo json_encode(array('success'=>false,'count'=>0,'message'=>'Product add to wishlist.'));
         }
         else{*/
         if (!DB::table($request->table)->where([['userid','=',$request->session()->get('userid')],['product_id','=',$request->id]])->exists()) {
             $insert = DB::table($request->table)->insert(['product_id'=>$request->id,'userid'=>$request->session()->get('userid')]);
             if ($insert) {
                 $count = DB::table($request->table)->where([['userid','=',$request->session()->get('userid')]])->count();
                 echo json_encode(array('success'=>true,'count'=>$count,'message'=>'Product add to wishlist.'));
             }else{

                 echo json_encode(array('success'=>false,'count'=>0,'message'=>'Something went wrong. Please try after sometime.'));
             }
         }else{
             echo json_encode(array('success'=>false,'count'=>0,'message'=>'Product add to wishlist.'));
         }
         //}
		 
	 }

   public function get_wishlist_ajax(Request $request){
       $count = DB::table('wishlist')->where([['userid','=',$request->session()->get('userid')]]);

       $wishlist = DB::table('wishlist')
           ->where([['userid','=',$request->session()->get('userid')]])
           ->leftJoin('products', 'products.id', '=', 'wishlist.product_id')
           ->limit(4)
           ->get(array('wishlist.*', 'products.image', 'products.name', 'products.shipping_charges', 'products.product_price'));
       $div = '';
       $div .= '<div class="row mt-4">';
       foreach($wishlist as $records){
           $shipping_charges = (empty($records->shipping_charges)) ? "+ $".$records->shipping_charges : "Free";
           $name = \Illuminate\Support\Str::limit($records->name, 40, $end='...');
           $div .= '
            <div class="col-md-6">
                <div class="border" style="height:100px;">
                    <a href="'.route('product_details',[$records->id]).'" class="product-link"><div style="background-image: url('.$records->image.');height:100%;background-size:contain"></div></a>
                </div>
                <div class="products-watchlist">
                    <a href="'.route('product_details',[$records->id]).'" class="product-link">'.$name.'</a><br>
                    <b>$'.number_format($records->product_price, 2).'</b>
                    <p style="font-style:normal;color:#000;font-weight:bold">'.$shipping_charges.' Shipping</p>
                </div>
            </div>';
       }
       $div .= '</div>';
       echo json_encode(array('success'=>true,'count'=>$count->count(),'html' => $div, 'message'=>''));
   }

    public function get_notifications_ajax(Request $request){
       $wishlist = DB::table('notifications')
           ->where([['userid','=',$request->session()->get('userid')]])
           ->limit(6)
           ->get();
       $div = '';
       foreach($wishlist as $records){
           $name = \Illuminate\Support\Str::limit($records->notification_title, 40, $end='...');
           $description = \Illuminate\Support\Str::limit($records->notification, 40, $end='...');
           $div .= '
            <div class="border-bottom">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <img src="'.$records->image.'" class="img-fluid">
                    </div>
                    <div class="col-md-9">
                        <small class="text-uppercase">'.$name.'</small><br>
                        <div class="description">'.$description.'</div>
                    </div>
                </div>
            </div>';
       }
       echo json_encode(array('success'=>true,'html' => $div, 'message'=>''));
   }
	 
	 /* Add Compare*/
	 public function add_compare(Request $request){
		   $input = $request->all();
		   $server =  parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
		   $count = DB::table('compare')->where('product_id',$request->id)->where('server_ip',$server)->count();
		   if($count == 0){
			   $insert = DB::table('compare')->insert(['product_id'=>$input['id'],'server_ip'=>$server]);
	           echo 1;	 
		 } else{
			   echo 2;	 
		   }
           die();
	 }

	public function add_to_cart(Request $request){
    $setting = DB::select(DB::raw("SELECT * FROM settings WHERE id='1'"));
    if (isset($request->amenties)) {
      $prod_info = $request->amenties;
    }else{
      $prod_info = json_encode(array());
    }
		 $html='';
     $userid = session()->get('userid');
     
     $product = DB::table('products')->where('id',$request->product_id)->first();
     if ($product) {
      // check quantity
      if ($request->quantity=='0') {
        DB::table('cart')->where([['userid','=',$userid],['product_id','=',$request->product_id]])->delete();
        $cart_product = DB::table('cart')->where([['userid','=',$userid]])->get();

          $total = DB::select(DB::raw("SELECT sum(total_price) as total FROM cart WHERE userid='".$userid."'"));
          foreach ($cart_product as $key) {
            $html.='<li class="amr-mc-item" id="cart_remove'.$key->id.'"><div class="amr-mc-detail"><div class="amr-mc-thumb"><a href="javascript:;"><img class="ps-product__thumbnail" src="'.url('public/'.$key->image).'" alt="alt"></a></div><div class="amr-mc-product-name"><a href="javascript:;">'.$key->product_name.'</a><p class="amr-mc-product-meta"> <span class="amr-mc-price">'.$setting[0]->currency_sign.$key->total_price.'</span><span class="amr-mc-quantity">(x'.$key->product_quantity.')</span></p></div></div><a class="amr-mc-item-remove" onclick="remove_cart_item('.$key->id.')"><i class="amr-close"></i></a></li>';
          }
          echo json_encode(array('success'=>true,'message'=>'porduct added','data'=>$html,'total'=>$total[0]->total,'count'=>$cart_product->count()));
          die;
      }
      if (isset(json_decode($request->amenties)->size)) {
        $product_sizee = DB::table('product_size')->where([['product_id','=',$request->product_id],['name','=',json_decode($request->amenties)->size]])->first();
        $sale_price = $product_sizee->price;
        
      }else{
        $sale_price = $product->sale_price;
      }
        $total_price = $sale_price*$request->quantity;
        if (DB::table('cart')->where([['userid','=',$userid],['product_id','=',$request->product_id]])->exists()) {
          $update = DB::table('cart')->where([['userid','=',$userid],['product_id','=',$request->product_id]])->update(['product_quantity'=>$request->quantity,'total_price'=>$total_price]);
          $cart_product = DB::table('cart')->where([['userid','=',$userid]])->get();

          $total = DB::select(DB::raw("SELECT sum(total_price) as total FROM cart WHERE userid='".$userid."'"));
          foreach ($cart_product as $key) {
            $html.='<li class="amr-mc-item" id="cart_remove'.$key->id.'"><div class="amr-mc-detail"><div class="amr-mc-thumb"><a href="javascript:;"><img class="ps-product__thumbnail" src="'.url('public/'.$key->image).'" alt="alt"></a></div><div class="amr-mc-product-name"><a href="javascript:;">'.$key->product_name.'</a><p class="amr-mc-product-meta"> <span class="amr-mc-price">'.$setting[0]->currency_sign.$key->total_price.'</span><span class="amr-mc-quantity">(x'.$key->product_quantity.')</span></p></div></div><a class="amr-mc-item-remove" onclick="remove_cart_item('.$key->id.')"><i class="amr-close"></i></a></li>';
          }
          echo json_encode(array('success'=>true,'message'=>'porduct added','data'=>$html,'total'=>$total[0]->total,'count'=>$cart_product->count()));
        }else{
          $insert = DB::table('cart')->insert(['userid'=>$userid,'product_id'=>$request->product_id,'product_name'=>$product->name,'product_quantity'=>$request->quantity,'product_price'=>$product->mrp_price,'sale_price'=>$sale_price,'total_price'=>$total_price,'image'=>$product->image,'product_info'=>$prod_info]);
          if ($insert) {
            $cart_product = DB::table('cart')->where([['userid','=',$userid]])->get();

            $total = DB::select(DB::raw("SELECT sum(total_price) as total FROM cart WHERE userid='".$userid."'"));
          foreach ($cart_product as $key) {
            $html.='<li class="amr-mc-item" id="cart_remove'.$key->id.'"><div class="amr-mc-detail"><div class="amr-mc-thumb"><a href="javascript:;"><img class="ps-product__thumbnail" src="'.url('public/'.$key->image).'" alt="alt"></a></div><div class="amr-mc-product-name"><a href="javascript:;">'.$key->product_name.'</a><p class="amr-mc-product-meta"> <span class="amr-mc-price">'.$setting[0]->currency_sign.$key->total_price.'</span><span class="amr-mc-quantity">(x'.$key->product_quantity.')</span></p></div></div><a class="amr-mc-item-remove" onclick="remove_cart_item('.$key->id.')"><i class="amr-close"></i></a></li>';
          }
            echo json_encode(array('success'=>true,'message'=>'porduct added','data'=>$html,'total'=>$total[0]->total,'count'=>$cart_product->count()));
          }else{
            $cart_product = DB::table('cart')->where([['userid','=',$userid]])->get();

     $total = DB::select(DB::raw("SELECT sum(total_price) as total FROM cart WHERE userid='".$userid."'"));
          foreach ($cart_product as $key) {
            $html.='<li class="amr-mc-item" id="cart_remove'.$key->id.'"><div class="amr-mc-detail"><div class="amr-mc-thumb"><a href="javascript:;"><img class="ps-product__thumbnail" src="'.url('public/'.$key->image).'" alt="alt"></a></div><div class="amr-mc-product-name"><a href="javascript:;">'.$key->product_name.'</a><p class="amr-mc-product-meta"> <span class="amr-mc-price">'.$setting[0]->currency_sign.$key->total_price.'</span><span class="amr-mc-quantity">(x'.$key->product_quantity.')</span></p></div></div><a class="amr-mc-item-remove" onclick="remove_cart_item('.$key->id.')"><i class="amr-close"></i></a></li>';
          }
            echo json_encode(array('success'=>true,'message'=>'No product available','data'=>$html,'total'=>$total[0]->total,'count'=>$cart_product->count()));
          }
        }
        
     }else{
        echo json_encode(array('success'=>false,'message'=>'No product available','data'=>$html,'total'=>0,'count'=>0));
     }
     
	 }
   
   public function check_login(Request $request){
     if ($request->session()->has('userid')) {
       echo $request->session()->get('userid');
     }else{
        $guestid = date('YmdHis').rand(1111,9999);
        $request->session()->put('userid',$guestid);
        echo $request->session()->get('userid');
     }
   }

   public function get_cart_ajax(Request $request){
    $html='';
     if ($request->session()->has('userid')) {
       $userid = $request->session()->get('userid');
     }else{
        $userid = 0;
     }

     $cart_product = DB::table('cart')->where([['userid','=',$userid]])->get();
     $setting = DB::select(DB::raw("SELECT * FROM settings WHERE id='1'"));
     $total = DB::select(DB::raw("SELECT sum(total_price) as total FROM cart WHERE userid='".$userid."'"));
          if (!$cart_product->isEmpty()) {

            foreach ($cart_product as $key) {
                $is_upload = DB::table('products')->where('id',$key->product_id)->first()->is_uploaded;
              $html.='<li class="amr-mc-item" id="cart_remove'.$key->id.'"><div class="amr-mc-detail"><div class="amr-mc-thumb"><a href="javascript:;">';
              if ($is_upload) {
                $image_array = explode(',',$key->image);
                $html.='<img class="ps-product__thumbnail" src="'.$image_array[0].'" alt="alt">';
              }else{
                $html.='<img class="ps-product__thumbnail" src="'.url('public/'.$key->image).'" alt="alt">';
              }
              
               $html.='</a></div><div class="amr-mc-product-name"><a href="javascript:;">'.$key->product_name.'</a><p class="amr-mc-product-meta"> <span class="amr-mc-price">'.$setting[0]->currency_sign.$key->total_price.'</span><span class="amr-mc-quantity">(x'.$key->product_quantity.')</span></p></div></div><a class="amr-mc-item-remove" onclick="remove_cart_item('.$key->id.')"><i class="amr-close"></i></a></li>';
            }
              echo json_encode(array('success'=>true,'message'=>'product Added','data'=>$html,'total'=>$total[0]->total,'count'=>$cart_product->count()));
          }else{
            echo json_encode(array('success'=>false,'message'=>'No product in cart','data'=>$html,'total'=>0,'count'=>0));
          }
   }

    public function get_cart_ajax_v2(Request $request){
    $html='';
     if ($request->session()->has('userid')) {
       $userid = $request->session()->get('userid');
     }else{
        $userid = 0;
     }

     $cart_product = DB::table('cart')->where([['userid','=',$userid]])->leftJoin('products', 'products.id', '=', 'cart.product_id')
         ->limit(4)
         ->get(array('cart.*', 'products.image', 'products.name', 'products.shipping_charges', 'products.product_price'));;
     $setting = DB::select(DB::raw("SELECT * FROM settings WHERE id='1'"));
     $total = DB::select(DB::raw("SELECT sum(total_price) as total FROM cart WHERE userid='".$userid."'"));
          if (!$cart_product->isEmpty()) {

            foreach ($cart_product as $key) {
                $is_upload = DB::table('products')->where('id',$key->product_id)->first()->is_uploaded;
                $html .= '<div class="row align-items-center" id="cart_remove'.$key->id.'">';
                $html .= '<div class="col-md-3">';
                if ($is_upload) {
                    $image_array = explode(',',$key->image);
                    $html.='<img class="" src="'.$image_array[0].'" alt="alt">';
                }else{
                    $html.='<img class="" src="'.url('public/'.$key->image).'" alt="alt">';
                }

                $html .= '</div>';
                $html .= '<div class="col-md-9">';
                $html .= '<a href="javascript:;" class="px-0">'.\Illuminate\Support\Str::limit($key->product_name, 25, $end='...').'</a>';
                $html .= '<div class="row">';
                    $html .= '<div class="col-md-6">';
                        $html .= '<h5 class="text-black mb-0">$'.$key->product_price.'</h5>';
                    $html .= '</div>';
                    $html .= '<div class="col-md-6">';
                        $html .= '<p class="text-black mb-0">Qty: '.$key->product_quantity.'</p>';
                    $html .= '</div>';
                $html .= '</div>';
                $html .= '<div class="row">';
                $html .= '<div class="col-md-6">';
                $shipping_charges = (empty($key->shipping_charges)) ? "+ $".$key->shipping_charges : "Free";
                $html .= '<p class="text-black mb-0">'.$shipping_charges.' Shipping</p>';
                $html .= '</div>';
                $html .= '<div class="col-md-6">';
                $html.='<a class="amr-mc-item-remove justify-content-end p-0" onclick="remove_cart_item('.$key->id.')"><img src="'.url('public/assets/web/images/Screenshot_6.png').'"></a>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
            }
              $html .= '<span class="view_cart_header"><a class="" href="'.url('cart').'">View cart</a> to see all of your items</span>';
              $html .= '<div class="border row py-3" style="background-color: rgb(247,247,247)">';
              $html .= '<div class="col-md-6 text-black font-bold">Total</div>';
              $html .= '<div class="col-md-6 text-end text-black font-bold">$'.$total[0]->total.'</div>';
              $html .= '</div>';
              $html .= '<a class="btn checkout-header justify-content-center mt-4" href="'.url('checkout').'">Checkout</a>';
              $html .= '<a class=" mt-4 btn justify-content-center cart-header" href="'.url('cart').'">View cart</a>';
              echo json_encode(array('success'=>true,'message'=>'product Added','data'=>$html,'total'=>$total[0]->total,'count'=>$cart_product->count()));
          }else{
            echo json_encode(array('success'=>false,'message'=>'No product in cart','data'=>$html,'total'=>0,'count'=>0));
          }
   }
   
    public function remove_from_cart_ajax(Request $request){
      DB::table('cart')->where('id',$request->cartid)->delete();
      $html='';
     if ($request->session()->has('userid')) {
       $userid = $request->session()->get('userid');
     }else{
        $userid = 0;
     }

     $cart_product = DB::table('cart')->where([['userid','=',$userid]])->get();

     $total = DB::select(DB::raw("SELECT sum(total_price) as total FROM cart WHERE userid='".$userid."'"));
          if (!$cart_product->isEmpty()) {
            foreach ($cart_product as $key) {
              $html.='<li class="amr-mc-item" id="cart_remove'.$key->id.'"><div class="amr-mc-detail">
              <div class="amr-mc-thumb"><a href="javascript:;">
              <img class="ps-product__thumbnail" src="'.url('public/'.$key->image).'" alt="alt"></a>
              </div><div class="amr-mc-product-name"><a href="javascript:;">'.$key->product_name.'</a>
              <p class="amr-mc-product-meta">
              <span class="amr-mc-price">'.$setting[0]->currency_sign.$key->total_price.'</span>
              <span class="amr-mc-quantity">(x'.$key->product_quantity.')</span></p></div></div>
              <a class="amr-mc-item-remove" onclick="remove_cart_item('.$key->id.')"><i class="amr-close"></i></a></li>';
            }
              echo json_encode(array('success'=>true,'message'=>'product Added','data'=>$html,'total'=>$total[0]->total,'count'=>$cart_product->count()));
          }else{
            echo json_encode(array('success'=>true,'message'=>'No product in cart','data'=>$html,'total'=>0,'count'=>0));
          }
    }

   public function remove_from_cart(Request $request){
      DB::table('cart')->where('id',$request->cartid)->delete();
      return back()->with('success','Item remove from cart.');
   }

   public function empty_cart(Request $request){
      DB::table('cart')->where('userid',$request->session()->get('userid'))->delete();
      echo true;
   }

   public function apply_coupen(Request $request){
     $coupen = DB::table('coupens')->where('code',$request->coupen)->first();
     if (!$coupen) {
       echo json_encode(array('success'=>false,'message'=>'Wrong coupen code','data'=>[] ));
       die;
     }
     $cart_product = DB::table('cart')->where([['userid','=',$request->userid]])->get();
     $total = DB::select(DB::raw("SELECT sum(total_price) as total FROM cart WHERE userid='".$request->userid."'"))[0]->total;
     $coupen_discount = $coupen->discount;
     $discount_type = $coupen->type;
     if ($discount_type=='fixed') {
       $final_price = $total-$coupen_discount;
       $total_discount = $total - $final_price;
     }else{
       $final_price = round($coupen_discount * ($total / 100),2);
       $total_discount = $total - $final_price;
     }
     $shipping_amount = DB::table('settings')->where('id','1')->select('shipping_amount')->first()->shipping_amount;
     $data['shipping'] = $shipping_amount;
     $data['final_price'] = $final_price+$shipping_amount;
     $data['total_discount'] = $total_discount;
     echo json_encode(array('success'=>true,'message'=>'Coupen Applied','data'=>$data ));
       die;
   }

   public function order_success(){
     return view('success');
   }

   public function user_orders(Request $request){
    $data['orders'] = DB::select(DB::raw("SELECT *,count(id) as total FROM orders WHERE userid='".$request->session()->get('userid')."' GROUP BY order_id"));
    $data['completed'] = DB::select(DB::raw("SELECT *,count(id) as total FROM orders WHERE userid='".$request->session()->get('userid')."' AND `delivery_status`='delivered' GROUP BY order_id"));
    return view('guest_orders',$data);
   }

   public function wishlist(Request $request){
     $data['wishlist'] = DB::table('wishlist')
                          ->join('products', 'wishlist.product_id', '=', 'products.id')
                          ->select('wishlist.*', 'products.name', 'products.image','products.sale_price', 'products.is_uploaded',
                              'products.product_type', 'products.brand', 'products.mrp_price', 'products.shipping_charges')
                          ->where('wishlist.userid','=',$request->session()->get('userid'))
                          ->get();
    return view('wishlist',$data);
   }

   public function remove_from_wishlist(Request $request){
     DB::table('wishlist')->where('id',$request->id)->delete();
     echo true;
   }

   public function order_detail(Request $request,$orderid){
    if (isset($_GET['search'])) {
        $orderid = $orderid;
    }else{
        $orderid = base64_decode($orderid);
    }
    $data['orders'] = DB::select(DB::raw("SELECT a.*,(SELECT name FROM users WHERE id=a.vendorid) as vendoe_name,(SELECT mobile FROM users WHERE id=a.vendorid) as vendoe_contact FROM orders as a WHERE a.order_id='".$orderid."'"));
    $data['count'] = count(DB::select(DB::raw("SELECT id FROM orders WHERE order_id='".$orderid."'")));
    $data['delivery'] = DB::select(DB::raw("SELECT * FROM `delivery_fee_slab` WHERE price_from <= '".$data['orders'][0]->order_total."' AND price_to >= '".$data['orders'][0]->order_total."'"))[0]->delivery_fee;
    $data['setting'] = DB::select(DB::raw("SELECT * FROM `settings` WHERE id = '1'"));
     return view('order_details',$data);
   }

   public function cancel_order(Request $request,$orderid){
     
    $data['order'] = DB::select(DB::raw("SELECT * FROM orders WHERE order_id='".$orderid."'"));
    foreach ($data['order'] as $key) {
      DB::table('orders')->where('order_id',$orderid)->update(['order_status'=>'cancelled']);
    }
    return back()->with('success','Order Cancelled successfully.');
   }

   public function vendor_order_detail(Request $request,$orderid,$productid){
     $data['orders'] = DB::select(DB::raw("SELECT a.*,(SELECT name FROM users WHERE id=a.vendorid) as vendoe_name,(SELECT mobile FROM users WHERE id=a.vendorid) as vendoe_contact FROM orders as a WHERE a.order_id='".base64_decode($orderid)."' AND a.vendorid='".$productid."'"));
    $data['count'] = count(DB::select(DB::raw("SELECT * FROM orders WHERE order_id='".base64_decode($orderid)."'")));
    $data['delivery'] = DB::select(DB::raw("SELECT * FROM `delivery_fee_slab` WHERE price_from <= '".$data['orders'][0]->order_total."' AND price_to >= '".$data['orders'][0]->order_total."'"))[0]->delivery_fee;

     return view('vendor_order_detail',$data);
   }

   public function test_mail(){
    $array['to'][]=array('email'=>'rubbi.amrsoftec@gmail.com','name'=>'rubbi.amrsoftec');
    $array['subject']='Bazarhat99:- Welcome Email';
    $url = url('vendor/verify/'.'rubbi.amrsoftec@gmail.com');
    $array['dynamic_template_data']=array('name'=>'rubbi','link'=>$url);
    $email['personalizations'][]=$array;
    $email['from']['email'] ='hello@amrsoftec.com';
    $email['template_id']='d-88c01524637540a494cd41cf6227d62f';
    $json=json_encode($email);
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.sendgrid.com/v3/mail/send",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $json,
      CURLOPT_HTTPHEADER => array(
        "authorization: Bearer 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",
        "content-type: application/json"
      ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
   }

   public function get_address(Request $request){
      $address = DB::table('saved_address')->where('id',$request->id)->first();
      if ($address) {
        $json = json_encode(array('success'=>true,'data'=>array('street'=>$address->street,'zip'=>$address->zip,'town'=>$address->town,'country'=>$address->country)));
      }else{
        $json = json_encode(array('success'=>false,'data'=>[]));
      }
      echo $json;
   }

   public static function get_pages(){
     return DB::table('pages')->select('type','link')->get();
   }

   public function page_s(Request $request,$page){
     $data['page'] = DB::table('pages')->where('link',$page)->first();
     return view('page',$data);
   }

   public function find_product(Request $request){
     dd($request->all());
   }

   public function rate_and_review($id){
        $data['orderid'] = $id;
       if (Auth::user()) {
        $data['products'] = DB::table('orders')->where('order_id',$id)->select('productid','product_name','image')->get();
        // dd($data['products']);
        return view('review_rating',$data);
       }else{
        return redirect(url('user/login'));
       }
   }

   public function submit_review(Request $request){
       $save_review = DB::table('reviews')->insert(['productid'=>$request->product_id,'userid'=>$request->userid,'orderid'=>$request->orderid,'rating'=>$request->rating,'comment'=>addslashes($request->review)]);
       if ($save_review) {
           return back()->with('success','Review successfully saved.');
       }else{
            return back()->with('danger','Something went wrong. Please try after sometime.');
       }
   }

   public function update_review(Request $request){
       $save_review = DB::table('reviews')->where([['productid','=',$request->product_id],['userid','=',$request->userid],['orderid','=',$request->orderid]])->update(['rating'=>$request->rating,'comment'=>addslashes($request->review)]);
       if ($save_review) {
           return back()->with('success','Review successfully update.');
       }else{
            return back()->with('danger','Something went wrong. Please try after sometime.');
       }
   }
}
