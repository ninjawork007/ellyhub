<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Mail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;
use Image;
use App\Helpers\Common;
use Socialite;
class WelcomeController extends Controller
{

    use AuthenticatesUsers;

    public function __construct() {

            

    }

	//show admin page

	

    public function register_vendor(Request $request){

        return view('vendor_register');

    }

  

    public function vendor_save(Request $request){

        if (DB::table('users')->where('email',$request->email)->exists()) {

            return redirect(url('vendor/register'))->with('danger','This email already in use.');

        }



        $register = DB::table('users')->insert(['name'=>$request->name,'email'=>$request->email,'password'=>Hash::make($request->password),'user_type'=>$request->type,'email_verify'=>'yes','email_verified_at'=>date('Y-m-d H:i:s'),'created_at'=>date('Y-m-d H:i:s')]);

        if ($register) {

            // $array['to'][]=array('email'=>$request->email,'name'=>$request->name);

            // $array['subject']='Bazarhat99:- Welcome Email';

            // $url = url('vendor/verify/'.$request->email);

            // $array['dynamic_template_data']=array('name'=>$request->name,'link'=>$url);

            // $email['personalizations'][]=$array;

            // $email['from']['email'] ='hello@amrsoftec.com';

            // $email['template_id']='d-88c01524637540a494cd41cf6227d62f';

            // $json=json_encode($email);

            // $curl = curl_init();

            // curl_setopt_array($curl, array(

            //   CURLOPT_URL => "https://api.sendgrid.com/v3/mail/send",

            //   CURLOPT_RETURNTRANSFER => true,

            //   CURLOPT_ENCODING => "",

            //   CURLOPT_MAXREDIRS => 10,

            //   CURLOPT_TIMEOUT => 30,

            //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

            //   CURLOPT_CUSTOMREQUEST => "POST",

            //   CURLOPT_POSTFIELDS => $json,

            //   CURLOPT_HTTPHEADER => array(

            //     "authorization: Bearer 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",

            //     "content-type: application/json"

            //   ),

            // ));

            // $response = curl_exec($curl);

            // $err = curl_error($curl);

            // curl_close($curl);

            //return redirect(url('vendor/register'))->with('success','We have sent you verification email on '.$request->email.'. please check you email.');

            return redirect(url('vendor/login'))->with('success','You are successfully register');

        }else{

            return redirect(url('vendor/register'))->with('danger','Sorry!!! somethig went wrong. Please try after some time.');

        }

    }

    public function vendor_profile_view(){
        return view('vendor_profile');
    }



    public function email(){

        $to_name = 'Davinder Singh';

        $to_email = 'davinder.amrsoftech@gmail.com';

        $data = array('name'=>"Davinder Singh Pandher", "body" => "Bharat Bazar");

        Mail::send('emails', $data, function($message) use ($to_name, $to_email) {

        $message->to($to_email, $to_name)->subject('Artisans Web Mail');

        $message->from('devmann111991@gmail.com','Bazarhat99');

        });

    }



    public function vendor_login(){

        return view('vendor_login');

    }



    public function vendor_dologin(Request $request){

        request()->validate([

            'email' => 'required', 'email',

            'password' => 'required', 'string', 'max:255'

        ]);



        $email = $request->email;

        $password = $request->password;

        // Check validation

        

        if (Auth::attempt(['email' => $email, 'password' => $password,'user_type'=>$request->type])) {

            if (Auth::user()->email_verify=='no'){

                Auth::logout();

                return back()->with('info','Your email is not verify. Please verify your email.')->with('email',$email);

                return redirect('/vendor/login');

            }

            if (Auth::user()->isactive=='2'){

                Auth::logout();

                return back()->with('danger','Your account is disapproved by admin. Please contact to support.');

                return redirect('/vendor/login');

            }

            $user = Auth::user();

            return redirect()->route('admin_dashboard');

        } else {

            return back()->with('danger','Crediantials not matched with records.');

            return redirect('/vendor/login');

        }

    }



    public function vendor_logout(){

         Auth::logout();

         return redirect('/');

    }



    public function logout(Request $request){

        $user = Auth::user();

        if ($user->user_type == "customer") {

            Auth::logout();

            $request->session()->forget('userid');

            return redirect('/');

        }else if($user->user_type == "superadmin"){

            Auth::logout();

            return redirect('/admin');

        }else if($user->user_type == "vendor"){

            Auth::logout();

            return redirect('/');

        }

    }



    public function vendor_verify(Request $request,$email){

        if (DB::table('users')->where([['email','=',$email],['user_type','=','vendor']])->exists()) {

            DB::table('users')->where([['email','=',$email],['user_type','=','vendor']])->update(['email_verified_at'=>date('Y-m-d H:i:s'),'email_verify'=>'yes']);

            $data['success'] = true;

            $data['message'] = 'Email verification completed.';

            $data['image'] = url('public/assets/email-images/email-success.png');

            return view('email_verify',$data);

        }else{

            $data['success'] = false;

            $data['message'] = 'Sorry!!! user verification fail.';

            $data['image'] = url('public/assets/email-images/email-error.png');

            return view('email_verify',$data);

        }

    }



    public function vendor_resend_email(Request $request,$email){

        if (DB::table('users')->where([['email','=',$email],['user_type','=','vendor']])->exists()) {

            $data = DB::table('users')->where([['email','=',$email],['user_type','=','vendor']])->first();

            $array['to'][]=array('email'=>$data->email,'name'=>$data->name);

            $array['subject']='Bazarhat99:- Welcome Email';

            $url = url('vendor/verify/'.$email);

            $array['dynamic_template_data']=array('name'=>$data->name,'link'=>$url);

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

            return back()->with('success','Email resend successfully.');

            return redirect('/vendor/login');

        }else{

            return back()->with('danger','This user not found.');

            return redirect('/vendor/login');

        }

    }



    public function get_product(){

	   $data['product'] = DB::select(DB::raw("SELECT a.*,(SELECT name FROM `categories` WHERE id=a.category_id) as category_name,(SELECT name FROM `users` WHERE id=a.vendor_id) as vendor FROM products as a WHERE a.is_delete='0' AND a.status='approved' ORDER BY id DESC LIMIT 8"));
	   $categories = DB::select(DB::raw("SELECT *  FROM categories WHERE `home_screen` = 'yes' and isactive  = 'active' "));

	   

		$floating_categories = array();

		 foreach($categories as $cat_id){

			    $cat = array();

			    $cat['id'] =      $cat_id->id;

			    $cat['name'] =      $cat_id->name;

			    $cat['image'] =      $cat_id->image;

			    $cat['banner'] =      $cat_id->banner;

 

					/*Sub Category List */

			        $subcategory = DB::table('sub_categories')->where('category_id',$cat_id->id)->get()->take(10)->toarray();

					$sub_list = array();

					foreach ($subcategory as $key) {

						      $sub = array();

							  $sub['id'] =      $key->id;

							  $sub['name'] =     $key->title;

							  $sub['banner'] =   $key->banner;

							  $sub_list[]  = $sub;

					}

                  $cat['subcategory'] =      $sub_list;

				  

 				    /*Product List   LIMIT 8 */

			        $products = DB::table('products')

					->where('is_delete','0')

					->where('status','approved')

					->where('category_id',$cat_id->id)

					->get()->take(8)->toarray();

					$products_list = array();

					foreach ($products as $key) {

						      $prod = array();

							  $prod['id'] =      $key->id;

							  $prod['name'] =     $key->name;

							  $prod['slug'] =   $key->slug;

							  $prod['image'] =   $key->image;

							  $prod['product_price'] =   $key->product_price;

							  $prod['sale_price'] =   $key->sale_price;

							  $prod['shipping_time'] =   $key->shipping_time;

							  $prod['estimate_time'] =   $key->estimate_time;
                              $prod['is_uploaded'] =   $key->is_uploaded;

                $prod['mrp_price'] =   $key->mrp_price;

                $prod['discount_type'] =   $key->discount_type;

                $prod['discount'] =   $key->discount;

                $prod['gst_amount'] =   $key->gst_amount;

                $prod['gst'] =   $key->gst;

							 

							  $vendor = DB::table('users')->select('name')->where('id','=',$key->vendor_id)->get()->first(); 

							  $prod['vendor_name'] = $vendor->name; 

							 

							  $products_list[]  = $prod; 

					}  

					

				$cat['products'] =      $products_list;

				$floating_categories[]  = $cat;	

					

		  } 

    

		  $data['floating_categories'] =    $floating_categories; 

		  $data['home_banner'] = DB::table('banner')->where('banner_type','=','1')->get();

		  $data['home_top_banner'] = DB::table('banner')->where('banner_type','=','2')->get();

		  $data['home_bottom_banner'] = DB::table('banner')->where('banner_type','=','3')->get();

		  $data['brand'] = DB::table('brand')->where('status','yes')->where('feature','yes')->get()->toarray();

		  // dd($data['home_top_banner']);

		 return view('welcome',$data);

    }

	

	 

	 public function product_details($id){

		 $data['product'] = DB::table('products')->where('id',$id)->first();

         $data['wishlist'] = DB::table('wishlist')->where([['userid','=',session()->get('userid')],['product_id','=',$data['product']->ebay_product_id]])->count();

         $data['product_gallery'] = DB::table('product_gallery')->where('product_id',$data['product']->ebay_product_id)->get()->toarray();

         $data['product_colors'] = DB::table('product_colors')->where('product_id',$data['product']->ebay_product_id)->get()->toarray();

         $data['product_size'] = DB::table('product_size')->where('product_id',$data['product']->ebay_product_id)->get()->toarray();

		 $data['latest_product'] = DB::select(DB::raw("SELECT a.id, a.shipping_time , a.estimate_time, a.vendor_id, a.category_id, a.name, a.image, a.product_price, a.sale_price, a.status, a.modify_at, a.is_delete,(SELECT name FROM `categories` WHERE id=a.category_id) as category_name,(SELECT name FROM `users` WHERE id=a.vendor_id) as vendor FROM products as a WHERE a.is_delete='0' AND a.status='approved' LIMIT 8"));
         $data['cart'] = DB::select(DB::raw("SELECT * FROM `cart` WHERE `userid`='".session()->get('userid')."' AND `product_id`='".$data['product']->ebay_product_id."'"));
          $data['reviews'] = DB::table('reviews')
                            ->leftJoin('users','reviews.userid','=','users.id')
                            ->select('reviews.*','users.name','users.image')
                            ->where('reviews.productid',$data['product']->ebay_product_id)
                            ->get();
          $data['sum_of_review'] = DB::select(DB::raw("SELECT sum(rating) as rating FROM reviews WHERE productid='".$data['product']->ebay_product_id."'"));
          // dd($data['reviews']);
          $data['common'] = new Common;
        return view('product_details',$data);
        

	}

   public function brand_list(){

		 $data['brand'] = DB::table('brand')->where('status','yes')->where('feature','yes')->get()->toarray();

        return view('brand_list',$data);

	}

	public function brand_details($id){

		 $data['brands'] = DB::table('brand')->where('id',$id)->first();

		 $data['product'] = DB::table('products')->where('brand',$id)->get()->toarray();

        return view('brand_details',$data);

	}

	
  public function all_categories(){
         $data['categories'] = DB::table('categories')->where('isactive','active')->get()->toarray(); 
         return view('all_categories',$data);
    }
   public function category_details($cat){
            $id = explode("-",$cat);
            $id = end($id); 

           $data['name'] =   DB::table('categories')->where('id',$id)->first()->name;

           $data['categories'] =DB::table('categories')->where('isactive','active')->get()->toarray();
           $data['product'] = DB::table('products')
                                 ->leftJoin('users','products.vendor_id','=','users.id')
                                 ->leftJoin('categories','products.category_id','=','categories.id')
                                 ->select('products.id','products.is_uploaded','products.name','products.image','products.mrp_price','products.sale_price','products.discount','products.discount_type','categories.name as category_name','categories.id as category_id','users.name as vendor_name')
                                  ->where([['products.category_id','=',$id],['products.is_delete','=','0'],['products.status','=','approved']])
                                 ->orderby('products.id','desc')
                                 ->groupBy('products.id')  
                                 ->paginate(8);
            $data['cat_array']=array();
          return view('category_details',$data);
    }
     public function sub_categorydetails($cat,$sub){
          
           $id = explode("-",$sub);
           $id = end($id); 
           $data['name'] =   DB::table('sub_categories')->where('id',$id)->first()->title;
           $data['categories'] =DB::table('categories')->where('isactive','active')->get()->toarray(); 
           $data['product'] = DB::table('products')
                                 ->join('users','products.vendor_id','=','users.id')
                                 ->join('categories','products.category_id','=','categories.id') 
                                 //->join('product_gallery','products.id','=','product_gallery.product_id') 
                                 ->select('products.id','products.name','products.image','products.mrp_price','products.sale_price','products.discount','products.discount_type','categories.name as category_name','categories.id as category_id','users.name as vendor_name')
                                  ->where([['products.sub_category_id','=',$id],['products.is_delete','=','0'],['products.status','=','approved']])
                                 ->orderby('products.id','desc')
                                 ->groupBy('products.id')  
                                 ->paginate(8)->appends(request()->query());
        $data['cat_array']=array();
          return view('category_details',$data);

     }

     public function child_categorydetails($cat,$sub,$child){
           $id = explode("-",$child);
           $id = end($id); 
           $data['name'] =   DB::table('child_categories')->where('id',$id)->first()->name;
           $data['categories'] =DB::table('categories')->where('isactive','active')->get()->toarray();
           $data['cat_array']=array();
           $data['product'] = DB::table('products')
                                 ->join('users','products.vendor_id','=','users.id')
                                 ->join('categories','products.category_id','=','categories.id') 
                                 //->join('product_gallery','products.id','=','product_gallery.product_id') 
                                 ->select('products.id','products.name','products.image','products.mrp_price','products.sale_price','products.discount','products.discount_type','categories.name as category_name','categories.id as category_id','users.name as vendor_name')
                                  ->where([['products.child_category_id','=',$id],['products.is_delete','=','0'],['products.status','=','approved']])
                                 ->orderby('products.id','desc')
                                 ->groupBy('products.id')  
                                 ->paginate(8)->appends(request()->query());
          return view('category_details',$data);
     }


    



    public function category_wise_products(Request $request){

        if (isset($request->brand)) {

            $brand_array = explode(',', $request->brand);

        }else{

            $brand_array = array();

        }



        if (isset($request->category)) {

            $cat_array = explode(',', $request->category);

        }else{

            $cat_array = array();

        }



          $data['product'] = DB::table('products')

                            ->join('users','products.vendor_id','=','users.id')

                            ->select('products.*','users.name as vendor_name')

                            ->where([['products.is_delete','=','0'],['products.status','=','approved']])

                            ->whereIn('products.category_id',$cat_array)

                            ->orWhereIn('products.brand',$brand_array)

                            ->paginate(8)->appends(request()->query());

          $data['brand'] = DB::table('brand')->where('status','yes')->get()->toarray();

          $data['brand_array'] = $brand_array;

          $data['cat_array'] = $cat_array;
          $data['name'] =   '';
          return view('category_details',$data);

    }

	

	public function sub_category_details($id){

		 $data['sub_categories'] = DB::table('sub_categories')->where('id',$id)->first();

		  $data['product'] = DB::table('products')->where('sub_category_id',$id)->get()->toarray();

        return view('sub_category_details',$data);

	}

	

	public function child_category_details($id){

		 $data['child_categories'] = DB::table('child_categories')->where('id',$id)->first();

		  $data['product'] = DB::table('products')->where('child_category_id',$id)->get()->toarray();

        return view('child_category_details',$data);

	}



    public function user_login(){
        return view('user_login_register');

        // return view('user_login');

    }
    public function user_login_register(){

        return view('user_login_register');

    }



    public function user_do_login(Request $request){

        request()->validate([

            'email' => 'required', 'email',

            'password' => 'required', 'string', 'max:255'

        ]);

        // dd($request->password);



        $email = $request->email;

        $password = $request->password;
        $remember = $request->has('remember');
        // $credentials = $request->only('email', 'password');

        // Check validation

        

        if (Auth::attempt(['email' => $email, 'password' => $password,'user_type'=>$request->type],$remember)) {

            if (Auth::user()->email_verify=='no'){

                Auth::logout();

                return redirect('/user/login')->with('info','Your email is not verify. Please verify your email.')->withInput($request->all());

            }

            if (Auth::user()->isactive=='2'){

                Auth::logout();

                return redirect('/user/login')->with('danger','Your account is disapproved by admin. Please contact to support.');

            }

            DB::table('cart')->where('userid',$request->session()->get('userid'))->update(['userid'=>Auth::user()->id]);

            $request->session()->put('userid',Auth::user()->id);

            $user = Auth::user();

            return redirect(url('/'))->withInput($request->all());

        } else {

            

            return back()->with('danger','Crediantials not matched with records.');

            return redirect('/user/login')->withInput($request->all());;

        }

    }



    public function user_register(){

        return view('user_login_register');

    }



    public function user_save(Request $request){

        request()->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'confirmed'],
            'password' => ['required', 'string', 'min:8'],
        ]);

         if (DB::table('users')->where([['email','=',$request->email],['user_type','=',$request->type]])->exists()) {

            return redirect(url('user/register'))->with('danger','This email already in use.');

         }



        $register = DB::table('users')->insert(['name'=>$request->first_name.' '.$request->last_name,'first_name'=>$request->first_name,'last_name'=>$request->last_name,'email'=>$request->email,'password'=>Hash::make($request->password),'user_type'=>$request->type,'email_verify'=>'yes','email_verified_at'=>date('Y-m-d H:i:s'),'isactive'=>'1']);

        if ($register) {

            //  $array['to'][]=array('email'=>$request->email,'name'=>$request->name);

            // $array['subject']='Bazarhat99:- Welcome Email';

            // $url = url('user/verify/'.$request->email);

            // $array['dynamic_template_data']=array('name'=>$request->name,'link'=>$url);

            // $email['personalizations'][]=$array;

            // $email['from']['email'] ='hello@amrsoftec.com';

            // $email['template_id']='d-88c01524637540a494cd41cf6227d62f';

            // $json=json_encode($email);

            // $curl = curl_init();

            // curl_setopt_array($curl, array(

            //   CURLOPT_URL => "https://api.sendgrid.com/v3/mail/send",

            //   CURLOPT_RETURNTRANSFER => true,

            //   CURLOPT_ENCODING => "",

            //   CURLOPT_MAXREDIRS => 10,

            //   CURLOPT_TIMEOUT => 30,

            //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

            //   CURLOPT_CUSTOMREQUEST => "POST",

            //   CURLOPT_POSTFIELDS => $json,

            //   CURLOPT_HTTPHEADER => array(

            //     "authorization: Bearer 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",

            //     "content-type: application/json"

            //   ),

            // ));

            // $response = curl_exec($curl);

            // $err = curl_error($curl);

            // curl_close($curl);

            return redirect(url('user/login'))->with('success','You are successfully register with us. please login');

        }else{

            return redirect(url('user/register'))->with('danger','Sorry!!! somethig went wrong. Please try after some time.');

        }

    }



    public function user_email_verify(Request $request,$email){

         if (DB::table('users')->where([['email','=',$email],['user_type','=','customer']])->exists()) {

            DB::table('users')->where([['email','=',$email],['user_type','=','customer']])->update(['email_verified_at'=>date('Y-m-d H:i:s'),'email_verify'=>'yes']);

            $data['success'] = true;

            $data['message'] = 'Email verification completed.';

            $data['image'] = url('public/assets/email-images/email-success.png');

            return view('email_verify',$data);

        }else{

            $data['success'] = false;

            $data['message'] = 'Sorry!!! user verification fail.';

            $data['image'] = url('public/assets/email-images/email-error.png');

            return view('email_verify',$data);

        }

    }



    public function cart_list(Request $request){

        $data['cart'] = DB::table('cart')

                            ->join('products', 'cart.product_id', '=', 'products.id')

                            ->join('users', 'products.vendor_id', '=', 'users.id')

                            ->select('cart.*', 'products.vendor_id', 'users.name')

                            ->where([['userid','=',$request->session()->get('userid')]])

                            ->get();

        $data['total'] = DB::select(DB::raw("SELECT sum(total_price) as total FROM cart WHERE userid='".$request->session()->get('userid')."'"))[0]->total;

        //dd($data);

        return view('cart',$data);

    }

    public function cart_list_v2(Request $request){

        $data['cart'] = DB::table('cart')

                            ->join('products', 'cart.product_id', '=', 'products.id')

                            ->join('users', 'products.vendor_id', '=', 'users.id')

                            ->leftJoin('user_info', 'products.vendor_id', '=', 'user_info.userid')

                            ->leftJoin('product_size', 'products.id', '=', 'product_size.product_id')

                            ->select('cart.*', 'products.id as product_id', 'products.shipping_charges',
                                'products.stock', 'products.vendor_id', 'users.name', 'products.is_uploaded',
                                'user_info.complete_address', 'product_size.quantity')

                            ->where([['cart.userid','=',$request->session()->get('userid')]])

                            ->get();

        $data['total'] = DB::select(DB::raw("SELECT sum(total_price) as total FROM cart WHERE userid='".$request->session()->get('userid')."'"))[0]->total;

        //dd($data);

        return view('cart_v2',$data);

    }



    public function checkout(Request $request){

        $data['address'] = DB::table('saved_address')->where([['user_id','=',$request->session()->get('userid')]])->get();



        $data['cart'] = DB::table('cart')->where([['userid','=',$request->session()->get('userid')]])->get();

        $data['total'] = DB::select(DB::raw("SELECT sum(total_price) as total FROM cart WHERE userid='".$request->session()->get('userid')."'"))[0]->total;

        $data['shipping_amount'] = DB::select(DB::raw("SELECT * FROM `delivery_fee_slab` WHERE price_from <= '".$data['total']."' AND price_to >= '".$data['total']."'"))[0]->delivery_fee;

        $data['zipcodes'] = DB::select(DB::raw("SELECT pincode FROM `pin_codes` ORDER BY pincode ASC"));



        return view('checkout',$data);

    }

	public function make_payment(Request $request){
        // dd($request->all());
        $common = new Common;
        $request->session()->put('order', $request->all());
        $stripe_array = [];
        
        $data['inputs'] = $request->all();

        $data['orderid'] = 'EH'.date('ymdHis').$this->generateRandomString(5);
        $request->session()->put('orderid', $data['orderid']);
        $stripe_array['orderid'] = $data['orderid'];
        $stripe_array['card'] = str_replace(' ', '', $request->card);
        $stripe_array['name_on_card'] = $request->name_on_card;
        $stripe_array['expiry'] = $request->expiry;
        $stripe_array['cvv'] = $request->cvv;
        $stripe_array['order_total_before'] = $request->order_total_before;
        $stripe_array['email'] = $request->email;
        $stripe_array['orderid'] = $data['orderid'];
        $stripe_array['card'] = str_replace(' ', '', $request->card);
        $stripe_array['name_on_card'] = $request->name_on_card;
        $stripe_array['expiry'] = $request->expiry;
        $stripe_array['cvv'] = $request->cvv;
        $stripe_array['order_total_before'] = $request->order_total_before;
        $stripe_array['email'] = $request->email;
        $stripe_response = json_decode($common->stripePayment($stripe_array));
        if ($stripe_response->success){
            Session::put('order.is_payment_done', $stripe_response->success);
            Session::put('order.payment_id', $stripe_response->data->id);
            Session::put('order.payment_message', $stripe_response->message);
            if (session('3d')) {
                return redirect()->away($stripe_response->data->next_action->redirect_to_url->url);
            }else{
                return redirect(url('make-order'));
            }
        }else{
            return redirect()->back()->with('error',$stripe_response->message);
        }
    }

    public function make_order(Request $request){
        //dd(session('order'));
        $address_array = [];
        $address_array['zip'] = session('order')['zip'];
        $address_array['city'] = session('order')['city'];
        $address_array['state'] = session('order')['state'];
        $address_array['state_short'] = session('order')['state_short'];
        $address_array['country'] = session('order')['country'];
        $address_array['country_short'] = session('order')['country_short'];
        $common = new Common;
        $stripe_array = [];
        $data['inputs'] = $request->all();
        $data['password'] = rand(1111,9999);       
        $data['cart_orders'] = DB::table('cart')->where('userid',$request->session()->get('userid'))->get();
        if ($data['cart_orders']->count()) {
            foreach ($data['cart_orders'] as $key) {
            $product = DB::table('products')->where('id',$key->product_id)->first();
            $get_vendor_mobile = DB::table('users')->select('mobile')->where('id',$product->vendor_id)->first();
            $vendor_data[] = array('product'=>$key->product_name,'mobile'=>$get_vendor_mobile->mobile);
            }
        }
        if (isset($request->save_address)){
            DB::table('saved_address')->insert(['user_id'=>$request->session()->get('userid'),'address_type'=>'home','street'=>$request->street_address,'zip'=>$request->zip,'town'=>$request->city,'country'=>$request->country]);
        }
        $payment = 'pending';
        if ($request->is_wallet=='yes') {
            $wallet_used = $request->wallet_balance_used;
            $payment="paid";
        }else{
            if(session('order')['is_payment_done']){
                $wallet_used = 0;
                $payment="paid";
            }
            else{
                $wallet_used = 0;
                $payment="pending";
            }
        }
       

        if ($data['cart_orders']->count()) {
            foreach ($data['cart_orders'] as $key) {

                $product = DB::table('products')->where('id',$key->product_id)->first();

                $insert = DB::table('orders')->insert([
                    'order_id'=>session('orderid'),
                    'userid'=>$request->session()->get('userid'),
                    'vendorid'=>$product->vendor_id,
                    'productid'=>$key->product_id,
                    'product_name'=>$key->product_name,
                    'product_quantity'=>$key->product_quantity,
                    'product_price'=>$key->product_price,
                    'sale_price'=>$key->sale_price,
                    'total_price'=>$key->total_price,
                    'image'=>$key->image,
                    'applied_coupen'=>session('order')['apply_code'],
                    'order_total'=>session('order')['order_total_before'],
                    'wallet_used'=>$wallet_used,
                    'after_discount_paid_by_customer'=>session('order')['order_total'],
                    'payment_method'=>'stripe',
                    'name'=>session('order')['name'],
                    'email'=>session('order')['email'],
                    'phone'=>session('order')['phone'],
                    'street_address'=>(isset(session('order')['street_address'])) ? session('order')['street_address'] : '',
                    'zip'=>session('order')['zip'],
                    'city'=>session('order')['city'],
                    'country'=>session('order')['country'],
                    'notes'=>session('order')['notes'],
                    'razor_pay'=>null,
                    'payment_status'=>$payment,
                    'product_info'=>$key->product_info,
                    'address_json'=>json_encode($address_array),
                    'is_payment_done' => session('order')['is_payment_done'],
                    'payment_id' => session('order')['payment_id'],
                    'payment_message' => session('order')['payment_message'],
                    'payment_date' => date('Y-m-d H:i:s', strtotime('now'))
                ]);

                $update = DB::table('products')->where('id',$key->product_id)->decrement('stock', $key->product_quantity);

                $target='vendor_order_detail';

                $notification_message = "<p>New order come. order id : ".session('orderid')."</p>";

                $notification_send = DB::table('notifications')->insert(['notification'=>$notification_message,'vendorid'=>$product->vendor_id,'is_read'=>0,'created_at'=>date('Y-m-d H:i:s')]);

            }

            if ($insert){

                if ($request->is_wallet=='yes') {

                    DB::table('users')->where('id',$request->session()->get('userid'))->decrement('balance',$request->wallet_balance_used);

                }

                DB::table('cart')->where('userid',$request->session()->get('userid'))->delete();
                if (isset($request->create_account)) {
                    if (!DB::table('users')->where([['email','=',$request->email],['user_type','=','vendor']])->exists()) {
                       $register = DB::table('users')->insert(['name'=>$request->name,'email'=>$request->email,'password'=>Hash::make($data['password']),'user_type'=>'vendor','email_verify'=>'no']);
                        if ($register) {
                            // register user
                            $array['to'][]=array('email'=>$request->email,'name'=>$request->name);
                            $array['subject']='Bazarhat99:- Welcome Email';
                            $url = url('vendor/verify/'.$request->email);
                        }
                    }
                }

                return redirect('/order-success')->with('success','Order place successfully.');

            }else{

                return redirect('/cart')->with('danger','somethig went wrong. Please try after some time.');

            }

        }else{

            return redirect('/cart')->with('danger','Seems you cart is empty. Please add items.');

        }

        dd($data);

    }



    public function generateRandomString($length) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {

            $randomString .= $characters[rand(0, $charactersLength - 1)];

        }

        return $randomString;

    }



    public function test_sms(){

        $number='7740082254';

        $message='Dear Bazarhat99 Seller, You got new order. Please visit your Bazarhat99.com store.';

        dd($this->send_sms($number,$message));

    }



    public function send_sms($number,$message){

        $apiKey = urlencode("MTVlMGQ0NWU1YWRiNDMwZDRiYWM2OWIxZDgwOGMyZmY=");

        

        // Message details

        $numbers = urlencode($number);

        $sender = urlencode('bzrtht');

        $message = rawurlencode($message);

     

        // Prepare data for POST request

        $data = 'apikey=' . $apiKey . '&numbers=' . $numbers . "&sender=" . $sender . "&message=" . $message;

     

        // Send the GET request with cURL

        $ch = curl_init('https://api.textlocal.in/send/?' . $data);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;

    }



    public function find_product($category_id = ''){

        $request = Request();
        $where = [];

        $where[] = ['status','=','approved'];

        if (isset($request->keyword) && $request->keyword!='') {

            $where[] = ['products.name', 'like', '%' . $request->keyword . '%'];

        }



        if (!empty($category_id) && $category_id!='0') {
            $where[] = ['products.category_id', '=', $category_id];

        }

        $data['products'] = DB::table('products')

        ->join('users','products.vendor_id','=','users.id')
        ->select('products.*','users.name as vendor_name')

        ->where($where)

        ->orderby('id','desc')

        ->paginate(14);

        $userPairs = [];
        if(!empty($request->session()->get('userid'))){
            $userPairs = DB::table('wishlist')->where('userid','=',(string)$request->session()->get('userid'))->pluck('product_id','id')->toArray();
        }
        $data['wishlists'] = $userPairs;

        return view('products',$data);

    }



    public function user_account(Request $request){

        if (!Auth::user()) {

            return redirect(url('access-denied'));die;

        }

        return view('user_profile');

    }



    public function access_denied(Request $request){

        return view('access_denied');

    }



    public function update_profile(Request $request){

        if (!Auth::user()) {

            return redirect(url('access-denied'));die;

        }

        $image=Auth::user()->image;

        if ($request->hasFile('file')) {

            $file = $request->file('file');

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

                $image=Auth::user()->image;

            }

        }



        $update = DB::table('users')->where('id',Auth::user()->id)->update(['name'=>$request->name,'mobile'=>$request->mobile,'image'=>$image]);

        return redirect('/account')->with('success','Profile detail upadate successfully.');

    }



    public function test(Request $request){

            $html='<table><tr style="color:black;">Hi Davinder singh</tr><tr style="color:black;">How Are you.</tr></table>';

            $email='davinder.amrsoftech@gmail.com';

            $name='Davinder Singh';

            $common = new Common;

           echo $common->send_email($html,$email,$name);

            

    }



    public function get_wallet(){

        if (!Auth::user()) {

            return redirect(url('access-denied'));die;

        }

        return view('wallet');

    }



    public function shipping_address(){

        if (!Auth::user()) {

            return redirect(url('access-denied'));die;

        }

        

        $data['address'] = DB::table('saved_address')->where('user_id',Auth::user()->id)->get();

        return view('my_address',$data);

    }



    public function remove_from_address(Request $request){

        DB::table('saved_address')->where('id',$request->id)->delete();

        echo 1;

    }



    public function contact_us(){

        return view('contact_us');

    }



    public function save_contactus(Request $request){

        $insert = DB::table('contact_us')->insert(['name'=>$request->name,'email'=>$request->email,'subject'=>$request->subject,'message'=>$request->message]);

        if ($insert) {

            return redirect('contact-us')->with('success','Your Query is submitted. We will contact you shortly.');

        }else{

             return redirect('contact-us')->with('danger','Something went wrong. Please try after some time.');

        }

    }



    public function redirectToProvider(){

        return Socialite::driver('facebook')->redirect();

    }

    public function handleProviderCallback(){

        $user = Socialite::driver('facebook')->user();

        dd($user);

        // $user->token;

    }



    public function change_product_size(Request $request){

        $input = $request->all();

        $data['product'] = DB::table('products')->where('id',$input['productid'])->first();

        $data['product_size'] = DB::table('product_size')->where([['product_id','=',$input['productid']],['name','=',$input['size']]])->first();

        if ($data['product']){

            $product_count='';

            $product_count.='<select name="quantity" id="detail_input'.$input['productid'].'">';

            $product_count.='<option value="">Select</option>';

            for ($i=1; $i < $data["product_size"]->quantity+1; $i++) { 

                $product_count.='<option value="'.$i.'">'.$i.'</option>';                                        

            }

            $product_count.='</select>';

            $response = array(

                'price'=>"<del>".$setting[0]->currency_sign.$data["product"]->mrp_price."</del><ins>".$setting[0]->currency_sign.$data["product_size"]->price."<sub></sub></ins>",

                'product_count'=>$product_count,

                'is_count'=>($data["product_size"]->quantity)?$data["product_size"]->quantity:0,

            );

            echo json_encode(array('success'=>true,'message'=>'Product Found.','data'=>$response));

        }else{

            echo json_encode(array('success'=>false,'message'=>'No Product Found.','data'=>[]));

        }

    }



    public function verify_pincode(Request $request){

        $pincode = DB::table('pin_codes')->where('pincode',$request->pincode)->first();

        if ($pincode) {

            echo json_encode(array('success'=>true,'message'=>'Delivery available'));

        }else{

            echo json_encode(array('success'=>false,'message'=>'Pincode not deliverable.'));

        }

    }



    public function login_with_facebook(Request $request){



        if (DB::table('users')->where([['login_type','=',$request->type],['email','=',$request->email]])->exists()) {

            $user = DB::table('users')->where([['login_type','=',$request->type],['email','=',$request->email]])->first();

            if (Auth::loginUsingId($user->id, true)) {

                if (Auth::user()->isactive=='2'){

                    Auth::logout();

                    echo json_encode(array('success'=>false,'message'=>'Your account is disapproved by admin. Please contact to support.'));

                }

                DB::table('cart')->where('userid',$request->session()->get('userid'))->update(['userid'=>Auth::user()->id]);

                $request->session()->put('userid',Auth::user()->id);

                $user = Auth::user();

                echo json_encode(array('success'=>true,'message'=>'Login Successfully.'));

            }else{

                echo json_encode(array('success'=>false,'message'=>'Error!!! not login.'));

            }

        }else{

            $insert = DB::table('users')->insertGetId(['login_type'=>$request->type,'name'=>$request->name,'email'=>$request->email,'email_verified_at'=>date('Y-m-d H:i:s'),'user_type'=>'customer','isactive'=>'1','email_verify'=>'yes']);

            if ($insert) {

                if (Auth::loginUsingId($insert, true)) {

                    if (Auth::user()->isactive=='2'){

                        Auth::logout();

                        echo json_encode(array('success'=>false,'message'=>'Your account is disapproved by admin. Please contact to support.'));

                    }

                    DB::table('cart')->where('userid',$request->session()->get('userid'))->update(['userid'=>Auth::user()->id]);

                    $request->session()->put('userid',Auth::user()->id);

                    $user = Auth::user();

                    echo json_encode(array('success'=>true,'message'=>'Login Successfully.'));

                }else{

                    echo json_encode(array('success'=>false,'message'=>'Error!!! not login.'));

                }

            }else{

                echo json_encode(array('success'=>false,'message'=>'Error!!! user not register.'));

            }

        }

    }



    public function user_forget_password(){

        $data['type'] = 'customer';

        return view('forget_password',$data);

    }



    public function send_password(Request $request){
        $common = new Common;
        $setting = DB::select(DB::raw("SELECT * FROM settings WHERE id='1'"));
        // dd([$request->email,$request->type]);
        if (!DB::table('users')->where([['email','=',$request->email],['user_type','=',$request->type]])->exists()) {
            return redirect('user/forget-password')->with('danger','This email not register with us.');

        }

        $password = rand(1111,9999);

        DB::table('users')->where('email',$request->email)->update(['password'=>Hash::make($password)]);
        $user = DB::table('users')->where('email',$request->email)->first();
        try{
            $array['data']['html']='';
            $array['data']['html'].='<tr><td>Hello '.$user->name.',</td></tr>';
            $array['data']['html'].='<tr><td>'.$password.' is your new password.</td></tr>';
            $array['data']['html'].='<tr><td>Please update your strong password after login.</td></tr><br>';
            $array['data']['html'].='<tr><td>Regards</td></tr>';
            $array['data']['html'].='<tr><td>Team '.$setting[0]->site_title.'</td></tr>';
            $array['data']['email']=$user->email;
            $array['data']['subject']=$user->email;
            $common->send_email($array['data']['html'],$array['data']['email'],$user->name,$array['data']['subject']);
        }catch(\Exception $e){

        }
        return redirect(url('user/login'))->with('success','We have sent you password email on '.$request->email.'. please check you email.')->withInput($request->all());



    }



    public function vendor_forget_password(){

        $data['type'] = 'vendor';

        return view('forget_password',$data);

    }



    public function google_redirectToProvider(){

        return Socialite::driver('google')->redirect();

    }



    public function google_handleProviderCallback(){

        try {

            $user = Socialite::driver('google')->user();

        } catch (\Exception $e) {

            return redirect('/login');

        }

        // dd($user);

        // only allow people with @company.com to login

        if(explode("@", $user->email)[1] !== 'company.com'){

            return redirect()->to('/');

        }

        // check if they're an existing user

        $existingUser = User::where('email', $user->email)->first();

        if($existingUser){

            // log them in

            auth()->login($existingUser, true);

        } else {

            // create a new user

            $newUser                  = new User;

            $newUser->name            = $user->name;

            $newUser->email           = $user->email;

            $newUser->google_id       = $user->id;

            $newUser->avatar          = $user->avatar;

            $newUser->avatar_original = $user->avatar_original;

            $newUser->save();

            auth()->login($newUser, true);

        }

        return redirect()->to('/home');

    }



    public function track_order(){

        return view('track_order');

    }

    public function search(Request $request){
        if ($request->type) {
            $product_type = $request->type;
        }else{
            $product_type = ['new','used','parts'];
        }
        
        $product_type_arr = "'" . implode ( "', '", $product_type ) . "'";
           $currency  =   DB::table('settings')->where('id','1')->select('currency_sign')->first()->currency_sign;
           $search  =  $request->search;
                 

                  /* Search product Start */
                // $products = DB::table('products')
                //              ->select('products.id','products.name','products.slug','products.image','products.mrp_price','products.sale_price')
                //              ->where([['products.name', 'like', '%' . $request->search . '%'],['products.is_delete','=','0'],['products.status','=','approved']])
                //              ->whereIn('product_type',$product_type)
                //              ->orderby('products.id','desc')->toSql();

                  $products = DB::select(DB::raw("select id,name,slug,image,is_uploaded,mrp_price,sale_price from products where (name like '%$request->search%' and is_delete = '0' and status = 'approved') AND product_type IN (".$product_type_arr.") order by products.id DESC LIMIT 10"));    
                  if(count($products)){                 
                        echo "<h6><b>Products</b></h6><ul>";
                        foreach ($products as $key => $value) {
                         $name = preg_replace('#'. preg_quote($search) .'#i', '<span style="background-color: #F9F902;">\\0</span>', $value->name);
                        echo "<li>
                                <a href=". url('/product/'.$value->id) .  "> 
                                <div class='search-img-thumb'>";
                                if($value->is_uploaded){
                                    $image_array = explode(',',$value->image);
                                    echo "<img src=".$image_array[0]." class='img-search'>";
                                }else{
                                    echo "<img src=".url('public/'.$value->image)." class='img-search'>";
                                }
                        
                        echo "</div><div><div class='search-pro-name'>". $name ."</div><div class='serch-pro-price'> <del>". $currency.$value->mrp_price ." </del>  <strong> ". $currency.$value->sale_price ." </strong> </div></div></a> 
                                </li>"; 
                          }  
                     echo "</ul>"; 
                }
                 /* Search product End */


                /* Search category Start */
                 $category = DB::table('categories')
                             ->select('categories.id','categories.name')
                             ->where([['categories.name', 'like', '%' . $request->search . '%'],['categories.isactive','=','active']])
                             ->orderby('categories.id','desc')->get(); 

                if(count($category)){                    
                        echo "<h6><b>Categories</b></h6><ul>";
                        foreach ($category as $key1 => $value1) {
                             $name = preg_replace('#'. preg_quote($search) .'#i', '<span style="background-color: #F9F902;">\\0</span>', $value1->name);
                              echo "<li>
                                    <a href=". url('/category/'.preg_replace('/[^a-zA-Z0-9]+/','-', strtolower($value1->name)).'-'.$value1->id) .  "> <div class='name-search'>".  $name ."</div></a> 
                                </li>";
                           }
                     echo "</ul>";   
                }
                 /* Search category End */

                 /* Search brand Start */
                 $brand = DB::table('brand')
                             ->select('brand.id','brand.title')
                             ->where([['brand.title', 'like', '%' . $request->search . '%'],['brand.status','=','yes']])
                             ->orderby('brand.id','desc')->get(); 

                if(count($brand)){                    
                        echo "<h6><b>Brands</b></h6><ul>";
                        foreach ($brand as $key1 => $value2) {
                            $url =  url('/brand/'.preg_replace('/[^a-zA-Z0-9]+/','-', strtolower($value2->title)).'-'.$value2->id);
                            $name = preg_replace('#'. preg_quote($search) .'#i', '<span style="background-color: #F9F902;">\\0</span>', $value2->title);
                           echo "<li>
                                    <a href=".$url .">".  $name ."</a> 
                                </li>";
                          }   
                     echo "</ul>";   
                }
                 /* Search brand End */
                   
               if((count($products) == 0)  && (count($category) == 0) &&  (count($brand) == 0) ) {
                      echo "<h6 class='text-center'><b>No records found!!!</b></h6><ul>";

               }
           }



}



	

	

	

