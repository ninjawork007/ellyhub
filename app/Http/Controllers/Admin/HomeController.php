<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;
use File;
class HomeController extends Controller
{
     /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
    */
       
    
    /**
     * Create a new controller instance.
     *
     * @return void
    */
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
	public function index(){
        $where='';
        $status='';
        $where_order='';
        if (Auth::user()->user_type=='vendor') {
            $where = "AND vendor_id='".Auth::user()->id."'";
            $where_order="AND vendorid='".Auth::user()->id."'";
        }

        if (Auth::user()->user_type=='vendor') {
            $status="WHERE status='approved'";
        }else{
            $status="WHERE status!=''";
        }
        //dd("SELECT id FROM products $status $where");
        $data['vendor'] = count(DB::select(DB::raw("SELECT id FROM users WHERE `user_type`='vendor'")));
        $data['product'] = count(DB::select(DB::raw("SELECT id FROM products $status $where")));
        $data['user'] = count(DB::select(DB::raw("SELECT id FROM users WHERE user_type='customer'")));
        $data['earning'] = DB::select(DB::raw("SELECT sum(order_total) as total FROM orders WHERE order_id!='' $where_order"))[0]->total;
        $data['orders'] = count(DB::select(DB::raw("SELECT id FROM orders WHERE order_id!='' $where_order GROUP BY order_id")));
        $data['pending_order'] = count(DB::select(DB::raw("SELECT id FROM orders WHERE delivery_status='pending' $where_order GROUP BY order_id")));
        $data['processing_orders'] = count(DB::select(DB::raw("SELECT id FROM orders WHERE delivery_status='dispatch' AND order_status='accept' $where_order GROUP BY order_id")));
        $data['complete_orders'] = count(DB::select(DB::raw("SELECT id FROM orders WHERE delivery_status='delivered' AND order_status='accept' $where_order GROUP BY order_id")));

        return view('admin.dashboard',$data);
	}

    public function my_profile(){
        $data['user_info'] = DB::table('user_info')->where('userid',Auth::user()->id)->first();
        $data['bank'] = DB::table('bank_detail')->where('vendor_id',Auth::user()->id)->first();
        // dd($data);
        return view('admin.my_profile',$data);
    }
	public function comming_soon(){
        $data['user_info'] = DB::table('user_info')->where('userid',Auth::user()->id)->first();
        return view('admin.comming_soon',$data);
    }

    public function update_bank_information(Request $request){
        if (DB::table('bank_detail')->where('vendor_id',Auth::user()->id)->exists()) {
           $update =  DB::table('bank_detail')->where('vendor_id',Auth::user()->id)->update(['bank_name'=>$request->bank_name,'account_number'=>$request->account_number,'ifsc'=>$request->ifsc,'accountant_name'=>$request->accountant_name,'created_at'=>date('Y-m-d H:i:s')]);
           return redirect(url('admin/my-profile'))->with('success','Bank detail update.');
        }else{
            $insert = DB::table('bank_detail')->insert(['vendor_id'=>Auth::user()->id,'bank_name'=>$request->bank_name,'account_number'=>$request->account_number,'ifsc'=>$request->ifsc,'accountant_name'=>$request->accountant_name,'created_at'=>date('Y-m-d H:i:s')]);
            if ($insert) {
                return redirect(url('admin/my-profile'))->with('success','Bank detail update.');
            }else{
                return redirect(url('admin/my-profile'))->with('danger','Error! something went wrong. Please try after some time.');
            }
        }
    }

    public function update_vendor_information(Request $request){
        // dd($request->all());
        $address_array = [];
        $address_array['city'] = $request->city;
        $address_array['state'] = $request->state;
        $address_array['state_short'] = $request->state_short;
        $address_array['country_long'] = $request->country_long;
        $address_array['country_short'] = $request->country_short;
        $address_array['zipcode'] = $request->zipcode;

        $info = DB::table('user_info')->where('userid',Auth::user()->id)->first();
        // upload profile
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $destinationPath = public_path('uploads');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            $image_name = 'profile'.time() . '.' . $extension;
            if ($file->move($destinationPath, $image_name)) {
                $profile = 'uploads/' . $image_name;
            } else {
                $profile = ($info)?$info->profile_photo:null;
            }
        }else{
            $profile = ($info)?$info->profile_photo:null;
        }

        // upload pan
         if ($request->hasFile('pancard')) {
            $file = $request->file('pancard');
            $destinationPath = public_path('uploads');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            $image_name = 'pancard'.time() . '.' . $extension;
            if ($file->move($destinationPath, $image_name)) {
                $pancard = 'uploads/' . $image_name;
            } else {
                $pancard = ($info)?$info->pan_card:null;
            }
        }else{
            $pancard = ($info)?$info->pan_card:null;
        }

        // upload adhar_card
         if ($request->hasFile('adharcard')) {
            $file = $request->file('adharcard');
            $destinationPath = public_path('uploads');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            $image_name = 'adharcard'.time() . '.' . $extension;
            if ($file->move($destinationPath, $image_name)) {
                $adharcard = 'uploads/' . $image_name;
            } else {
                $adharcard = ($info)?$info->adhar_card:null;
            }
        }else{
            $adharcard = ($info)?$info->adhar_card:null;
        }

        // upload adhar_card
        if($request->hasFile('gst')) {
            $file = $request->file('gst');
            $destinationPath = public_path('uploads');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            $image_name = 'gst'.time() . '.' . $extension;
            if ($file->move($destinationPath, $image_name)) {
                $gst = 'uploads/' . $image_name;
            } else {
                $gst = ($info)?$info->gst_registration:null;
            }
        }else{
            $gst = ($info)?$info->gst_registration:null;
        }

        // upload adhar_card
        if($request->hasFile('firm_registration')) {
            $file = $request->file('firm_registration');
            $destinationPath = public_path('uploads');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            $image_name = 'firm_registration'.time() . '.' . $extension;
            if ($file->move($destinationPath, $image_name)) {
                $firm_registration = 'uploads/' . $image_name;
            } else {
                $firm_registration = ($info)?$info->firm_registration:null;
            }
        }else{
            $firm_registration = ($info)?$info->firm_registration:null;
        }
        $update = DB::table('users')->where('id',Auth::user()->id)->update(['name'=>$request->name,'mobile'=>$request->mobile,'image'=>$profile]);
        if (DB::table('user_info')->where('userid',Auth::user()->id)->exists()) {
            $update =DB::table('user_info')->where('userid',Auth::user()->id)->update(['profile_photo'=>$profile,'complete_address'=>$request->address,'pan_card'=>$pancard,'adhar_card'=>$adharcard,'gst_registration'=>$gst,'firm_registration'=>$firm_registration,'address_json'=>json_encode($address_array)]);
            return redirect(url('admin/my-profile'))->with('success','Detail is added successfully!');
        }else{
            $insert = DB::table('user_info')->insert(['userid'=>Auth::user()->id,'profile_photo'=>$profile,'complete_address'=>$request->address,'pan_card'=>$pancard,'adhar_card'=>$adharcard,'gst_registration'=>$gst,'firm_registration'=>$firm_registration,'address_json'=>json_encode($address_array)]);
            if ($insert) {
                return redirect(url('admin/my-profile'))->with('success','Detail is added successfully!');
            }else{
                return redirect(url('admin/my-profile'))->with('danger','Something went wrong. please try after some time.');
            }
        }
    }
}
