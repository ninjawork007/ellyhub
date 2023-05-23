<?php
namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\admin\Input;
use App\Http\Controllers\Admin\EbayCronController;
use App\Helpers\Ebay\EbayHelper;
use App\Models\Product;
use App\Models\EbayPaymentPolicy;
use App\Models\EbayReturnPolicy;
use App\Models\EbayShippingPolicy;

class ProductController extends Controller{

    use AuthenticatesUsers;

    public function __construct() {

            $this->middleware('auth');

            $this->middleware(function ($request, $next) {

                if (!Auth::user()) {

                   return redirect()->route('admin_logout'); 

                }

                return $next($request);

            });

    }

	//show admin page

	public function products(){
		//$helper=new EbayCronController();
		//$helper->fetchProduct();
        return view('admin.products.list');

	}



    public function product_list(Request $request){

        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'status'=>@$_GET['status']);

        $search = "";

        $where = "";

        if (Auth::user()->user_type=='vendor') {

            $where = "AND (a.vendor_id = '".Auth::user()->id."')";

        }

        if ($input['search']){

            $search = "AND (a.name LIKE '%".$input['search']."%')";

        }



        if ($input['start']=='') {

            $input['start']=0;

        }



        if ($input['length']=='') {

            $input['length']=10;

        }



        $totalrows = count(DB::select(DB::raw("SELECT a.* FROM products as a WHERE a.is_delete='0' $search $where")));

        $data  = DB::select(DB::raw("SELECT a.*,(SELECT name FROM users WHERE id=a.vendor_id) as vendor_name,(SELECT name FROM categories WHERE id=a.category_id) as category FROM products as a WHERE a.is_delete='0' $search $where ORDER BY a.id DESC limit ".$input['start'].",".$input['length'].""));

        $final = [];

        $i=0;

        foreach($data as $row){

            $disabled='';

            if (Auth::user()->user_type=='vendor') {

                $disabled='disabled';

            }

            $status='';

            $status.='<select class="form-control" id="'.$row->id.'" '.$disabled.'>';

            if ($row->status=='pending') {

                $status.='<option value="pending" selected>Pending</option>';

            }else{

                $status.='<option value="pending">Pending</option>';

            }

            if ($row->status=='approved') {

                $status.='<option value="approved" selected>Approved</option>';

            }else{

                $status.='<option value="approved">Approved</option>';

            }

            if ($row->status=='disapproved') {

                $status.='<option value="disapproved" selected>Disapproved</option>';

            }else{

                $status.='<option value="disapproved">Disapproved</option>';

            }
            if ($row->is_uploaded) {
                $image_array = explode(',',$row->image);
                $product_image = '<img data-fancybox="gallery" src="'.$image_array[0].'"  alt= "" class="product_img">'.$row->name;
            }else
			{
				
					/*if (str_contains($row->image, 'http')) { 
					 $product_image = '<img data-fancybox="gallery" src="'.$row->image.'"  alt= "" class="product_img">'.$row->name;
  
				}
				else*/
              	  $product_image = '<img data-fancybox="gallery" src="'.url('public/'.$row->image).'"  alt= "" class="product_img">'.$row->name;
            }

            $status.='</select>';

            $final[] = array(

                            "DT_RowId" => $row->id,

                            $product_image,

                            $row->vendor_name,

                            $row->category,

                            $row->mrp_price,

                            $row->discount,

                            $status,

                            date('M d, Y',strtotime($row->created_at)),
							
							 ' <a href="'.$row->ebay_product_url.'" target="_blank" class="btn btn-outline-primary btn-sm"> '.$row->ebay_product_id.' </a>',

                            '<div class="btn-group" role="group" aria-label="Basic example">

                            <a href="'.url('admin/product',[$row->id]).'" class="btn btn-outline-primary btn-sm"> <i class="fa fa-eye"></i> </a>&nbsp;

                           <br> <a href="'.url('admin/product/edit',[$row->id]).'" class="btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i></a>

							<br><a href="javascript:;" class="delete_row btn btn-outline-danger btn-sm" table="products" id="'.$row->id.'" data-value="1"><i class="fa fa-trash"></i></a>

                            </div>'

                    );

            $i++;

        }



        $json_data = array(

                        "draw"=> intval($input['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 

                        "recordsTotal"    => intval(count($final) ),  // total number of records

                        "recordsFiltered" => intval($totalrows), // total number of records after searching, if there is no searching then totalFiltered = totalData

                        "data"            => $final   // total data array

                    );

        echo json_encode($json_data);

    }

    

    public function product_add(){

		$user=Auth::user();
        $data['category'] = DB::table('categories')->where('isactive','active')->get()->toarray();

        $data['brand'] = DB::table('brand')->where('status','yes')->get()->toarray();
		
		$data['ebay_category'] = DB::table('ebay_categories')->where('status','1')->get()->toarray();
		
		 $data['ebay_payment_policies']=EbayPaymentPolicy::where('user_id', '=', $user->id)->get();
		 $data['ebay_shipping_policies']=EbayShippingPolicy::where('user_id', '=', $user->id)->get();
		 $data['ebay_return_policies']=EbayReturnPolicy::where('user_id', '=', $user->id)->get();

        return view('admin.products.add',$data);

    }



    public function product_save(Request $request){
        $data['user'] = DB::table('users')->where('id',Auth::user()->id)->first();

        if ($data['user']->user_type=='superadmin') {
            $status = 'approved';
        }else{
            $status = 'pending';
        }
        if (isset($request->child_category)) {
            $child_category = $request->child_category;
        }else{
            $child_category = null;
        }
        // estimate time
        if ($request->is_estimatetime=='yes') {
            $shipping_time = $request->is_estimatetime;
            $estimate_time = $request->estimate_time;
        }else{
            $shipping_time = null;
            $estimate_time = null;
        }
        if ($request->is_prod_size=='yes'){
            $stock = 0;
        }else{
            $stock = $request->stock;
        }
        // upload images
        $image='';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $destinationPath = public_path('uploads');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            $image_name = time() . '.' . $extension;
            if ($file->move($destinationPath, $image_name)) {
                $image = 'uploads/' . $image_name;
            } else {
                $image = null;
            }
        }
        $taxable_price = $request->mrp_pric-$request->gst_price;
        $insertid = DB::table('products')->insertGetId(['vendor_id'=>auth::user()->id,'category_id'=>$request->category,'sub_category_id'=>$request->sub_category,'child_category_id'=>$child_category,'name'=>$request->name,'slug'=>$request->slug,'sku'=>$request->sku,'brand'=>$request->brand,'tags'=>$request->tags,'unit'=>$request->unit,'short_description'=>$request->short_description,'image'=>$image,'seo_title'=>$request->seo_title,'seo_description'=>$request->seo_description,'seo_tags'=>$request->seo_tags,'shipping_time'=>$shipping_time,'estimate_time'=>$estimate_time,'mrp_price'=>$request->mrp_price,'product_price'=>$taxable_price,'sale_price'=>$request->product_price,'discount_type'=>$request->discount_type,'discount'=>$request->discount,'gst_amount'=>$request->gst_price,'stock'=>$stock,'description'=>$request->description,'policy'=>$request->buy_rent_policy,'video_url'=>$request->video_url,'gst'=>$request->gst,'hsn'=>$request->hsn,'status'=>$status,'comission'=>$request->commission,'shipping_charges'=>$request->shipping_charges,'product_type'=>$request->product_type, 'ebay_category_id'=>$request->ebay_category_id,'return_policy_id'=>$request->return_policy_id,'payment_policy_id'=>$request->payment_policy_id,'shipping_policy_id'=>$request->shipping_policy_id,'package_type'=>$request->package_type,'package_weight'=>$request->package_weight,'package_dimensions_length'=>$request->package_dimensions_length,'package_dimensions_width'=>$request->package_dimensions_width,'package_dimensions_height'=>$request->package_dimensions_height,'country'=>$request->country,'city_or_state'=>$request->city_or_state,'zip_code'=>$request->zip_code]);
        if ($insertid) {
            // upload gallery
            $imgarr = array();
            if(count($request['gallery']) > 0){
            foreach ($request['gallery'] as $photo) { 
               $destinationPath = public_path('uploads');
               $galleryImg = time().'_'.$file->getClientOriginalName().rand(1111111,99999999).'.'.$photo->getClientOriginalExtension();
               if ($photo->move($destinationPath, $galleryImg)) {
                  $imgarr[] = array('product_id'=>$insertid,'images'=>'uploads/' . $galleryImg);
               }else{
                  $imgarr = array();
               }
            }
            $media = DB::table('product_gallery')->insert($imgarr);
          }

          if (isset($request->is_prod_size)) {
              for ($i=0; $i < count($request->size_name); $i++) { 
                  DB::table('product_size')->insert(['product_id'=>$insertid,'name'=>$request->size_name[$i],'quantity'=>$request->size_quantity[$i],'price'=>$request->size_price[$i]]);
              }
          }

          if (isset($request->is_prod_color)) {
              for ($x=0; $x < count($request->prod_color); $x++) { 
                  DB::table('product_colors')->insert(['product_id'=>$insertid,'color_code'=>$request->prod_color[$x]]);
              }
          }
		  
		  //ebay upload
		 
		   $EbayCronAddProduct = new EbayCronController();
           $data = $EbayCronAddProduct->addProduct($insertid);
		  
		  
		  
          return redirect(url('admin/products'))->with('success','Product is added successfully!');
        }else{
          return redirect(url('admin/products'))->with('danger','Something went wrong. Please try after some time.');
        } 
    }

  /*   public function product_detail(Request $request,$id){

       $data['product'] = DB::table('products')->where('id',$id)->first();

     return view('admin.products.product_detail',$data);

    } */  



	public function product_detail(Request $request,$id){

		 $data['category'] = DB::table('categories')->where('isactive','active')->get()->toarray();

		 $data['subcategory'] = DB::table('sub_categories')->get()->toarray();

         $data['product'] = DB::table('products')->where('id',$id)->first();

         $data['product_gallery'] = DB::table('product_gallery')->where('product_id',$id)->get()->toarray();

         $data['product_colors'] = DB::table('product_colors')->where('product_id',$id)->get()->toarray();

         $data['product_size'] = DB::table('product_size')->where('product_id',$id)->get()->toarray();

		 $data['brand'] = DB::table('brand')->where('status','yes')->get()->toarray();

        return view('admin.products.product_detail',$data);

    }	

	

	public function product_edit(Request $request,$id){

        $data['product'] = DB::table('products')->where('id',$id)->first();



		$data['category'] = DB::table('categories')->where('isactive','active')->get()->toarray();

		$data['subcategory'] = DB::table('sub_categories')->where('category_id',$data['product']->category_id)->get()->toarray();

        $data['child_category'] = DB::table('child_categories')->where([['category_id','=',$data['product']->category_id],['sub_category_id','=',$data['product']->sub_category_id]])->get()->toarray();

       // dd($data);

        $data['product_gallery'] = DB::table('product_gallery')->where('product_id',$id)->get()->toarray();

        $data['product_colors'] = DB::table('product_colors')->where('product_id',$id)->get()->toarray();

        $data['product_size'] = DB::table('product_size')->where('product_id',$id)->get()->toarray();

		$data['brand'] = DB::table('brand')->where('status','yes')->get()->toarray();
		//eBay
		
		 $user = Auth::user();  
		$data['ebay_category'] = DB::table('ebay_categories')->where('status','1')->get()->toarray();
		
		 $data['ebay_payment_policies']=EbayPaymentPolicy::where('user_id', '=', $user->id)->get();
		 $data['ebay_shipping_policies']=EbayShippingPolicy::where('user_id', '=', $user->id)->get();
		 $data['ebay_return_policies']=EbayReturnPolicy::where('user_id', '=', $user->id)->get();
		 
               
          

        //dd($data['product']);

        return view('admin.products.edit',$data);

    }



    public function update_product_status(Request $request){

        DB::table('products')->where('id',$request->id)->update(['status'=>$request->value]);

        echo 1;

    } 

 

   public function update_product(Request $request){

		$input = $request->all(); 

	    $data = DB::table('products')->where('id',$request->id)->first();

        if (isset($request->child_category)) {

            $child_category = $request->child_category;

        }else{

            $child_category = null;

        }



        // estimate time

            $shipping_time = $request->is_estimatetime;

            $estimate_time = $request->estimate_time;

        



        if ($request->is_prod_size=='yes'){

            $stock = 0;

        }else{

            $stock = $request->stock;

        }

        // upload images

        $image='';

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $destinationPath = public_path('uploads');

            if (!File::isDirectory($destinationPath)) {

                File::makeDirectory($destinationPath, 0777, true, true);

            }



            $filename = $file->getClientOriginalName();

            $extension = $file->getClientOriginalExtension();



            $image_name = time() . '.' . $extension;

            if ($file->move($destinationPath, $image_name)) {

                $image = 'uploads/' . $image_name;

				 @unlink(public_path($data->image));

            } else {

                $image = $data->image;

            }

        }else {

                $image = $data->image;

            }



		   $taxable_price = $request->mrp_price-$request->gst_price;

       $update = DB::table('products')->where('id',$request->id)->update([

		   'category_id'=>$request->category,

		   'sub_category_id'=>$request->sub_category,

		   'child_category_id'=>$child_category,

		   'name'=>$request->name,

		   'slug'=>$request->slug,

		   'brand'=>$request->brand,

		   'tags'=>$request->tags,

		   'unit'=>$request->unit,

		   'sku'=>$request->sku,

		   'image'=>$image,

		   'shipping_time'=>$shipping_time,

		   'estimate_time'=>$estimate_time,

		   'mrp_price'=>$request->mrp_price,

		   'product_price'=>$request->product_price,

		   'sale_price'=>$request->product_price,

		   'discount_type'=>$request->discount_type,

		   'discount'=>$request->discount,

           'gst_amount'=>$request->gst_price,

		   'stock'=>$stock,

		   'short_description'=>$request->short_description,

		   'seo_title'=>$request->seo_title,

		   'seo_description'=>$request->seo_description,

		   'seo_tags'=>$request->seo_tags,

		   'description'=>$request->description,

		   'policy'=>$request->buy_rent_policy,

		   'video_url'=>$request->video_url,

		   'gst'=>$request->gst,

		   'hsn'=>$request->hsn,

			'comission'=>$request->commission,
			'shipping_charges'=>$request->shipping_charges,
			'product_type'=>$request->product_type,
			'ebay_category_id'=>$request->ebay_category_id,
			'return_policy_id'=>$request->return_policy_id,
			'payment_policy_id'=>$request->payment_policy_id,
			'shipping_policy_id'=>$request->shipping_policy_id,
			'package_type'=>$request->package_type,
			'package_weight'=>$request->package_weight,
			'package_dimensions_length'=>$request->package_dimensions_length,
			'package_dimensions_width'=>$request->package_dimensions_width,
			'package_dimensions_height'=>$request->package_dimensions_height,
			
			'country'=>$request->country,
			'city_or_state'=>$request->city_or_state,
			'zip_code'=>$request->zip_code,

		 ]);

		 

        

            // upload gallery

            $imgarr = array();  

            if(!empty($request['gallery'])){

            if(count($request['gallery']) > 0){

            foreach ($request['gallery'] as $photo) { 

               $destinationPath = public_path('uploads');

               $galleryImg = time().'.'.$photo->getClientOriginalExtension();

               if ($photo->move($destinationPath, $galleryImg)) {

                  $imgarr[] = array('product_id'=>$request->id,'images'=>'uploads/' . $galleryImg);

               }else{

                  $imgarr = array();

               }

            }

            $media = DB::table('product_gallery')->insert($imgarr);

		} }

  

         if(!empty($request->size_name)){         

		  DB::table('product_size')->where('product_id',$request->id)->delete();

		  if (isset($request->is_prod_size)) {

              for ($i=0; $i < count($request->size_name); $i++) { 

			  

                  DB::table('product_size')->insert(['product_id'=>$request->id,'name'=>$request->size_name[$i],'quantity'=>$request->size_quantity[$i],'price'=>$request->size_price[$i]]);

              }

         } }

		  

		 if(!empty($request->prod_color)){

			  DB::table('product_colors')->where('product_id',$request->id)->delete();

			  if (isset($request->is_prod_color)) {

				  for ($x=0; $x < count($request->prod_color); $x++) { 

					  DB::table('product_colors')->insert(['product_id'=>$request->id,'color_code'=>$request->prod_color[$x]]);

				  }

		} }

		$model_product = Product::where('id', $request->id)->first();
		if($model_product)
		{
			$EbayCronAddProduct = new EbayCronController();
			if($model_product->ebay_product_id)
				$data = $EbayCronAddProduct->updateProduct($request->id);
			else
				$data = $EbayCronAddProduct->addProduct($request->id);
		}

          return redirect(url('admin/products'))->with('success','Product   Updated successfully!');

        

         

    }







    // product stock functions



    public function product_stock(Request $request){

        $data['product_stock'] = DB::table('products')->get()->toarray();

        return view('admin.products.product_stock',$data);

    }



    public function ajax_get_product_stock(Request $request){

        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'status'=>@$_GET['status']);

        $search = "";



        $where = "";

        if (Auth::user()->user_type=='vendor') {

            $where = "AND (a.vendor_id = '".Auth::user()->id."') AND (a.status = 'approved')";

        }



        if ($input['search']){

            $search = "AND (a.name LIKE '%".$input['search']."%')";

        }



        if ($input['start']=='') {

            $input['start']=0;

        }



        if ($input['length']=='') {

            $input['length']=10;

        }



        $totalrows = count(DB::select(DB::raw("SELECT a.* FROM products as a WHERE a.is_delete='0' $search $where")));



        $data  = DB::select(DB::raw("SELECT a.id,a.name,a.stock,a.status,a.image,a.created_at FROM products as a Where a.is_delete='0' $search $where ORDER BY a.id DESC limit ".$input['start'].",".$input['length'].""));

       

        $final = [];

        $i=0;

        foreach($data as $row){

            $final[] = array(

                            "DT_RowId" => $row->id,

                            '<img src="'.url('public/'.$row->image).'" class="product_img">'.$row->name,

                            $row->stock,

                            ($row->stock)?'<span class="badge badge-success">Stock In</span>':'<span class="badge badge-danger">Stock Out</span>',

                            date('M d, Y',strtotime($row->created_at)),

                            '<div class="btn-group" role="group" aria-label="Basic example">

                            <a href="javascript:;" class="add_stock" id="'.$row->id.'"><button  title="Add new stock" class="btn btn-primary">Add Stock</button></a>

                            &nbsp;<a href="javascript:;" class="remove_stock" id="'.$row->id.'"><button  title="Make stock empty" class="btn btn-danger">Stock Out</button></a>

                            </div>'

                    );

            $i++;

        }



        $json_data = array(

                        "draw"=> intval($input['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 

                        "recordsTotal"    => intval(count($final) ),  // total number of records

                        "recordsFiltered" => intval($totalrows), // total number of records after searching, if there is no searching then totalFiltered = totalData

                        "data"            => $final   // total data array

                    );

        echo json_encode($json_data);

    }



    public function add_stock(Request $request){

        $get_stock = DB::table('products')->select('stock')->where('id',$request->id)->first();

        $stock = ((int)$get_stock->stock)+$request->value;

        DB::table('products')->where('id',$request->id)->update(['stock'=>$stock]);

        echo json_encode(array('success'=>true,'message'=>"Stock Updated",'data'=>[]));

        

    }



    public function stock_out(Request $request){

        DB::table('products')->where('id',$request->id)->update(['stock'=>'0']);

        echo 1;

    }



    public function deleted_products(){

        return view('admin.products.product_deleted');

    }

    

	

	public function delete_product_gallery(Request $request){

      $data['gallery'] = DB::table('product_gallery')->where('id',$request->id)->first();

        /* Unlink file on update new file*/

				if(!empty($data['gallery']->images)){

					$file_with_path = public_path('/').$data['gallery']->images; 

					if (file_exists($file_with_path)) {

								unlink($file_with_path);

				 } }

      $delete =  DB::table('product_gallery')->where('id',$request->id)->delete();

	   if($delete){ echo 1; } else { echo 2; }

    }

	

    public function ajax_get_product_deleted(Request $request){

        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'status'=>@$_GET['status']);

        $search = "";

        $where = "";

        if (Auth::user()->user_type=='vendor') {

            $where = "AND (a.vendor_id = '".Auth::user()->id."')";

        }

        if ($input['search']){

            $search = "AND (a.name LIKE '%".$input['search']."%')";

        }



        if ($input['start']=='') {

            $input['start']=0;

        }



        if ($input['length']=='') {

            $input['length']=10;

        }



        $totalrows = count(DB::select(DB::raw("SELECT a.* FROM products as a WHERE a.is_delete='1' $search $where")));



        $data  = DB::select(DB::raw("SELECT a.*,(SELECT name FROM users WHERE id=a.vendor_id) as vendor_name,(SELECT name FROM categories WHERE id=a.category_id) as category FROM products as a WHERE a.is_delete='1' $search $where ORDER BY a.id DESC limit ".$input['start'].",".$input['length'].""));

       

        $final = [];

        $i=0;

        foreach($data as $row){

            $status='';

            $status.='<select class="form-control" id="'.$row->id.'" disabled>';

            if ($row->status=='pending') {

                $status.='<option value="pending" selected>Pending</option>';

            }else{

                $status.='<option value="pending">Pending</option>';

            }

            if ($row->status=='approved') {

                $status.='<option value="approved" selected>Approved</option>';

            }else{

                $status.='<option value="approved">Approved</option>';

            }

            if ($row->status=='disapproved') {

                $status.='<option value="disapproved" selected>Disapproved</option>';

            }else{

                $status.='<option value="disapproved">Disapproved</option>';

            }

            $status.='</select>';

            $final[] = array(

                            "DT_RowId" => $row->id,

                            '<img src="'.url('public/'.$row->image).'" class="product_img">'.$row->name,

                            $row->vendor_name,

                            $row->category,

                            $row->product_price,

                            $row->sale_price,

                            $status,

                            date('M d, Y',strtotime($row->created_at)),

                            '<div class="btn-group" role="group" aria-label="Basic example">

                            <a href="javascript:;" class="delete_row" table="products" id="'.$row->id.'" data-value="0"><button  title="Restore product" class="btn btn-success"><i class="fas fa-trash-restore"></i></button></a>&nbsp;

                            <a href="javascript:;" class="delete_product" table="products" id="'.$row->id.'" data-value="0"><button  title="Permanent delete" class="btn btn-danger"><i class="fas fa-times"></i></button></a>

                            </div>'

                    );

            $i++;

        }



        $json_data = array(

                        "draw"=> intval($input['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 

                        "recordsTotal"    => intval(count($final) ),  // total number of records

                        "recordsFiltered" => intval($totalrows), // total number of records after searching, if there is no searching then totalFiltered = totalData

                        "data"            => $final   // total data array

                    );

        echo json_encode($json_data);

    }



    public function delete_product(Request $request){

        DB::table('products')->where('id',$request->id)->update(['is_delete'=>$request->value]);
		
		$user = Auth::user();
        $product = Product::where('id', $request->id)->where('vendor_id', $user->id)->first();

        if ($product) {
            if ($product->ebay_product_id) {
                try {
                    $ebay_api = new EbayCronController();
                    $ebay_api->deleteProduct($product);
                } catch (\Exception $e) {
                }
            }
		}

        echo 1;

    }



    public function delete_product_permanent(Request $request){

        $product = DB::table('products')->where('id',$request->id)->first();

        if ($product) {

            DB::table('products')->where('id',$request->id)->delete();

            @unlink(public_path($product->image));

        }

        $gallery = DB::table('product_gallery')->where('product_id',$request->id)->get();

        DB::table('product_gallery')->where('product_id',$request->id)->delete();

        foreach ($gallery as $key) {

            @unlink(public_path($key->images));

        }

        echo 1;

    }



    public function unapproved_products(){

        return view('admin.products.product_unapproved');

    }



    public function ajax_get_product_unapproved(Request $request){

        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'status'=>@$_GET['status']);

        $search = "";

        $where = "";

        if (Auth::user()->user_type=='vendor') {

            $where = "AND (a.vendor_id = '".Auth::user()->id."')";

        }

        if ($input['search']){

            $search = "AND (a.name LIKE '%".$input['search']."%')";

        }



        if ($input['start']=='') {

            $input['start']=0;

        }



        if ($input['length']=='') {

            $input['length']=10;

        }



        $totalrows = count(DB::select(DB::raw("SELECT a.* FROM products as a WHERE a.is_delete='1' AND status='disapproved' $search $where")));



        $data  = DB::select(DB::raw("SELECT a.*,(SELECT name FROM users WHERE id=a.vendor_id) as vendor_name,(SELECT name FROM categories WHERE id=a.category_id) as category FROM products as a WHERE a.is_delete='0' AND status='disapproved' $search $where ORDER BY a.id DESC limit ".$input['start'].",".$input['length'].""));

       

        $final = [];

        $i=0;

        foreach($data as $row){

            $status='';

            $status.='<select class="form-control" id="'.$row->id.'" >';

            if ($row->status=='pending') {

                $status.='<option value="pending" selected>Pending</option>';

            }else{

                $status.='<option value="pending">Pending</option>';

            }

            if ($row->status=='approved') {

                $status.='<option value="approved" selected>Approved</option>';

            }else{

                $status.='<option value="approved">Approved</option>';

            }

            if ($row->status=='disapproved') {

                $status.='<option value="disapproved" selected>Disapproved</option>';

            }else{

                $status.='<option value="disapproved">Disapproved</option>';

            }

            $status.='</select>';

            $final[] = array(

                            "DT_RowId" => $row->id,

                            '<img src="'.url('public/'.$row->image).'" class="product_img">'.$row->name,

                            $row->vendor_name,

                            $row->category,

                            $row->product_price,

                            $row->sale_price,

                            $status,

                            date('M d, Y',strtotime($row->created_at)),

                            '<div class="btn-group" role="group" aria-label="Basic example">

                            <a href="javascript:;" class="delete_row" table="products" id="'.$row->id.'" data-value="0"><button  title="Delete product" class="btn btn-danger"><i class="fas fa-trash"></i></button></a>'

                    );

            $i++;

        }



        $json_data = array(

                        "draw"=> intval($input['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 

                        "recordsTotal"    => intval(count($final) ),  // total number of records

                        "recordsFiltered" => intval($totalrows), // total number of records after searching, if there is no searching then totalFiltered = totalData

                        "data"            => $final   // total data array

                    );

        echo json_encode($json_data);

    }



    // product bundle



    public function product_bundle(){

        return view('admin.products.product_bundle');

    }



    public function ajax_get_product_bundle(Request $request){

        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'status'=>@$_GET['status']);

        $search = "";

        $where = "";

        if (Auth::user()->user_type=='vendor') {

            $where = "AND (a.vendor_id = '".Auth::user()->id."')";

        }

        if ($input['search']){

            $search = "AND (a.name LIKE '%".$input['search']."%')";

        }



        if ($input['start']=='') {

            $input['start']=0;

        }



        if ($input['length']=='') {

            $input['length']=10;

        }



        $totalrows = count(DB::select(DB::raw("SELECT a.* FROM product_bundle as a WHERE a.is_active='1' $search $where")));



        $data  = DB::select(DB::raw("SELECT a.*,(SELECT count(id) FROM product_bundle_product_lists WHERE product_bundle_id=a.id) as count FROM product_bundle as a WHERE a.is_active='1' $search $where ORDER BY a.id DESC limit ".$input['start'].",".$input['length'].""));

       

        $final = [];

        $i=0;

        foreach($data as $row){

            $disable='';

            if (Auth::user()->user_type=='vendor'){

                $disable='disabled';

            }

            $status='';

            $status.='<select class="form-control" id="'.$row->id.'" '.$disable.'>';

            if ($row->is_active=='1') {

                $status.='<option value="1" selected>Active</option>';

            }else{

                $status.='<option value="1">Active</option>';

            }

            if ($row->is_active=='0') {

                $status.='<option value="0" selected>De-Active</option>';

            }else{

                $status.='<option value="0">De-Active</option>';

            }

            $status.='</select>';

            $final[] = array(

                            "DT_RowId" => $row->id,

                            '<img src="'.url('public/'.$row->image).'" class="product_img">'.$row->title,

                            $row->count,

                            $row->sale_price,

                            $row->product_price,

                            $status,

                            date('M d, Y',strtotime($row->created_at)),

                            '<div class="btn-group" role="group" aria-label="Basic example">

                            <a href="'.url('admin/product-bundle',[$row->id]).'"><button  title="View Features" class="btn btn-primary"><i class="fa fa-eye"></i></button></a>&nbsp;

                            <a href="javascript:;" class="delete_row" id="'.$row->id.'" data-value="1"><button  title="View Features" class="btn btn-danger"><i class="fa fa-trash"></i></button></a>

                            </div>'

                    );

            $i++;

        }



        $json_data = array(

                        "draw"=> intval($input['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 

                        "recordsTotal"    => intval(count($final) ),  // total number of records

                        "recordsFiltered" => intval($totalrows), // total number of records after searching, if there is no searching then totalFiltered = totalData

                        "data"            => $final   // total data array

                    );

        echo json_encode($json_data); 

    }



    public function add_bundle(){

        return view('admin.products.product_bundle_add');

    }



    public function save_bundle(Request $request){

        $image='';

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $destinationPath = public_path('uploads');

            if (!File::isDirectory($destinationPath)) {

                File::makeDirectory($destinationPath, 0777, true, true);

            }



            $filename = $file->getClientOriginalName();

            $extension = $file->getClientOriginalExtension();



            $image_name = time() . '.' . $extension;

            if ($file->move($destinationPath, $image_name)) {

                $image = 'uploads/' . $image_name;

            } else {

                $image = null;

            }

        }

        $id = DB::table('product_bundle')->insertGetId(['vendor_id'=>Auth::user()->id,'title'=>$request->name,'slug'=>$request->slug,'image'=>$image,'product_price'=>$request->product_price,'sale_price'=>$request->sale_price,'gst'=>$request->gst,'description'=>$request->description]);

        if ($id) {

            return redirect(url('admin/product-bundle/'.$id))->with('success','Bundle created. Please add product to bundle.');

        }else{

            return redirect(url('admin/product-bundle-add'))->with('danger','Something went wrong. Please try after some time.');

        }

    }



    public function add_product_to_bundle(Request $request,$id){

        if (!DB::table('product_bundle')->where('id',$id)->exists()) {

            return redirect(url('admin'))->with('danger','Not authorize to access.');

        }

        $data['bundle'] = DB::table('product_bundle')->where([['id','=',$id]])->first();

        $data['bundle_product_list'] = DB::table('product_bundle_product_lists')->where('product_bundle_id',$id)->get();

        $data['bundle_product_id']=array();

        foreach ($data['bundle_product_list'] as $key) {

            $data['bundle_product_id'][] = $key->product_id;

        }

        $data['products'] = DB::table('products')->where([['status','=','approved'],['is_delete','=','0'],['vendor_id','=',Auth::user()->id]])->get()->toarray();



        return view('admin.products.product_bundle_products',$data);

    }



    public function ajax_get_bundle_products(Request $request){

        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'status'=>@$_GET['status']);

        $search = "";

        $where = "";

        

        if ($input['search']){

            $search = "AND (product_name LIKE '%".$input['search']."%')";

        }



        if ($input['start']=='') {

            $input['start']=0;

        }



        if ($input['length']=='') {

            $input['length']=10;

        }



        $totalrows = count(DB::select(DB::raw("SELECT a.*,(SELECT name FROM products WHERE id=a.product_id) as product_name FROM product_bundle_product_lists as a WHERE a.product_bundle_id='".$request->bundleid."' $search $where")));



        $data  = DB::select(DB::raw("SELECT a.*,(SELECT name FROM products WHERE id=a.product_id) as product_name,(SELECT image FROM products WHERE id=a.product_id) as product_image FROM product_bundle_product_lists as a WHERE a.product_bundle_id='".$request->bundleid."' $search $where ORDER BY a.id DESC limit ".$input['start'].",".$input['length'].""));

       

        $final = [];

        $i=0;

        foreach($data as $row){

            $final[] = array(

                            "DT_RowId" => $row->id,

                            $row->product_name,

                            '<img src="'.url('public/'.$row->product_image).'" class="product_img">',

                            '<div class="btn-group" role="group" aria-label="Basic example">

                            <a href="javascript:;" class="delete_product" id="'.$row->id.'" table="product_bundle_product_lists"><button  title="Make stock empty" class="btn btn-danger">Remove</button></a>

                            </div>'

                    );

            $i++;

        }



        $json_data = array(

                        "draw"=> intval($input['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 

                        "recordsTotal"    => intval(count($final) ),  // total number of records

                        "recordsFiltered" => intval($totalrows), // total number of records after searching, if there is no searching then totalFiltered = totalData

                        "data"            => $final   // total data array

                    );

        echo json_encode($json_data); 

    }



    public function product_bundle_product_save(Request $request){

        if (count($request->product_id)) {

            foreach ($request->product_id as $key) {

                if (!DB::table('product_bundle_product_lists')->where([['product_bundle_id','=',$request->bundle_id],['product_id','=',$key]])->exists()) {

                    $save = DB::table('product_bundle_product_lists')->insert(['product_bundle_id'=>$request->bundle_id,'product_id'=>$key]);

                }

            }

            return redirect(url('admin/product-bundle/'.$request->bundle_id))->with('success','Product added.');

        }else{

            return redirect(url('admin/product-bundle/'.$request->bundle_id))->with('danger','no produc id selected.');

        }

        

    }



    public function delete_product_bundle(Request $request){

        DB::table($request->table)->where('id',$request->id)->delete();

        echo true;

    }



    public function product_bulk_upload(){

        $data['category'] = DB::table('categories')->where('isactive','active')->get()->toarray();

        $data['brand'] = DB::table('brand')->where('status','yes')->get()->toarray();

        return view('admin.products.csv_upload',$data);

    }



    public function save_csv(Request $request){

        $file = $request->file('csv');

        $destinationPath = public_path('/uploads');

        if (!File::isDirectory($destinationPath)) {

            File::makeDirectory($destinationPath, 0777, true, true);

        }



        $filename = $file->getClientOriginalName();

        $extension = $file->getClientOriginalExtension();

        $image_name = time() . '.' . $extension;

        if ($file->move($destinationPath, $image_name)) {

            $image = 'uploads/' . $image_name;

        } else {

            $image = null;

        }

        $file_complete_path = public_path($image);

        $data = $this->csvToArray($file_complete_path);


        unlink($file_complete_path);
        // dd($data);
        $status = 'approved';// pending

        foreach ($data as $data) {
            $image=[];
            if($data['product_image_1']){
                $image[] = $data['product_image_1'];
            }
            if($data['product_image_2']){
                $image[] = $data['product_image_2'];
            }
            if($data['product_image_3']){
                $image[] = $data['product_image_3'];
            }
            if($data['product_image_4']){
                $image[] = $data['product_image_4'];
            }
            if($data['product_image_5']){
                $image[] = $data['product_image_5'];
            }
            if($data['product_image_6']){
                $image[] = $data['product_image_6'];
            }
            
            $image_srting = implode(',', $image);
            if (isset($data['child_category'])) {

                $child_category = $data['child_category'];

            }else{

                $child_category = null;

            }

            $slug = $this->slugify($data['name']);

            if ($data['discount_type']=='percentage') {

                $gst_amount = ($data['discount']/100)*$data['mrp_price'];

                $sale_price = $data['mrp_price']-$gst_amount;

            }else{

                $gst_amount = $data['discount'];

                $sale_price = intval($data['mrp_price'])- intval($data['discount']);

            }

            $insertid = DB::table('products')->insert(['vendor_id'=>auth::user()->id,'category_id'=>$data['category_id'],'name'=>$data['name'],'slug'=>$slug,'sku'=>$data['sku'],'brand_name'=>$data['brand'],'tags'=>$data['tags'],'short_description'=>$data['short_description'],'image'=>$image_srting,'seo_title'=>$data['seo_title'],'seo_description'=>$data['seo_description'],'seo_tags'=>$data['seo_tags'],'estimate_time'=>$data['estimate_time'],'mrp_price'=>$data['mrp_price'],'sale_price'=>$sale_price,'discount_type'=>$data['discount_type'],'discount'=>$data['discount'],'gst_amount'=>$gst_amount,'stock'=>$data['stock'],'description'=>$data['description'],'policy'=>$data['policy'],'video_url'=>$data['video_url'],'gst'=>$data['gst'],'hsn'=>$data['hsn'],'status'=>$status,'comission'=>$data['comission'],'shipping_charges'=>$data['shipping_charges'],'is_uploaded'=>1]);

            

        }

        if ($insertid) {

          return redirect(url('admin/products'))->with('success','Product is added successfully!');

        }else{

          return redirect(url('admin/products'))->with('danger','Something went wrong. Please try after some time.');

        }

    }



    function csvToArray($filename = '', $delimiter = ','){

        if (!file_exists($filename) || !is_readable($filename))

            return false;



        $header = null;

        $data = array();

        if (($handle = fopen($filename, 'r')) !== false)

        {

            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)

            {
                

                if (!$header)

                    $header = $row;

                else
                    // reurn $header;
                    $data[] = array_combine($header, $row);

            }

            fclose($handle);

        }

        return $data;

    }



    public static function slugify($text){

      $text = preg_replace('~[^\pL\d]+~u', '-', $text);

      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

      $text = preg_replace('~[^-\w]+~', '', $text);

      $text = trim($text, '-');

      $text = preg_replace('~-+~', '-', $text);

      $text = strtolower($text);

      if (empty($text)) {

        return 'n-a';

      }

      return $text;

    }

}

