<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;
use Redirect;
use File;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
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
	public function show_vendor(){
        return view('admin.users.vendor_list');
	}

    public function ajax_get_vendor(Request $request){
        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'status'=>@$_GET['status']);
        $search = "";
        if ($input['search']){
            $search.= "AND (a.name LIKE '%".$input['search']."%' OR a.email LIKE '%".$input['search']."%' OR a.mobile LIKE '%".$input['search']."%')";
        }

        if ($input['status']!=='') {
            $search.="AND (a.isactive='".$input['status']."')";
        }

        if ($input['start']=='') {
            $input['start']=0;
        }

        if ($input['length']=='') {
            $input['length']=10;
        }
        $totalrows = count(DB::select(DB::raw("SELECT a.* FROM users as a WHERE a.user_type='vendor' $search ")));
        $data  = DB::select(DB::raw("SELECT a.*,(SELECT profile_photo FROM user_info WHERE userid=a.id) as profile FROM users as a WHERE a.user_type='vendor' $search ORDER BY a.id DESC limit ".$input['start'].",".$input['length'].""));
        $final = [];
        $i=0;
        foreach($data as $row){
            $status='';
            $status.='<select class="form-control change_status" id="'.$row->id.'">';
            if ($row->isactive=='0') {
                $status.='<option value="0" selected>Pending</option>';
            }else{
                $status.='<option value="0">Pending</option>';
            }
            if ($row->isactive=='1') {
                $status.='<option value="1" selected>Approved</option>';
            }else{
                $status.='<option value="1">Approved</option>';
            }
            if ($row->isactive=='2') {
                $status.='<option value="2" selected>Disapproved</option>';
            }else{
                $status.='<option value="2">Disapproved</option>';
            }
            $status.='</select>';
            if ($row->email_verify=='yes') {
               $verify='<span class="badge badge-success">Verified</span>';
            }else{
               $verify='<span class="badge badge-danger">Unverified</span>';
            }
			
			if($row->image){
				$image = '<img src="'.url('public/'.$row->image).'" class="product_img">'.$row->name;
			} else {
				$image = '<img src="'.url('public/no-image.png').'" class="product_img">'.$row->name;
			}
			
            $final[] = array(
                            "DT_RowId" => $row->id,
                             $image,
                            $row->name,
                             $row->email.'</br> '.$verify,
                            $row->mobile,
                            $status,
                            $verify,
                            date('M d, Y',strtotime($row->created_at)),
                            '<div class="btn-group" role="group" aria-label="Basic example">
                            <a href="'.url("admin/vendor",[$row->id]).'" class="btn btn-icon btn-primary btn-tone view_document" table="user_info" id="'.$row->id.'"><i class="anticon anticon-eye"></i></a>&emsp;<a href="'.url("admin/vendor/edit",[$row->id]).'" class="btn btn-icon btn-default btn-tone view_document" table="user_info" id="'.$row->id.'"><i class="anticon anticon-edit"></i></a>
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

    public function show_vendor_document(Request $request){
        $check = DB::table('user_info')->Where('userid',$request->id)->first();
        $html = '';
        if ($check) {
            $html.='<div class="rows text-center"><p>Pan Card</p><img class="images" src="'.url('public/'.$check->pan_card).'"></div><hr><div class="rows text-center"><p>Adhar Card</p><img class="images" src="'.url('public/'.$check->adhar_card).'"></div><hr><div class="rows text-center"><p>GST Registration</p><img class="images" src="'.url('public/'.$check->gst_registration).'"></div><hr><div class="rows text-center"><p>Firm Registration</p><img class="images" src="'.url('public/'.$check->firm_registration).'"></div>';
            echo json_encode(array('success'=>true,'data'=>$html));
        }else{
            echo json_encode(array('success'=>false,'data'=>'<div class="alert alert-info" role="alert">No Document upload.</div>'));
        }
    }

    public function update_vendor_status(Request $request){
       DB::table('users')->where('id',$request->id)->update(['isactive'=>$request->value]);
       if ($request->value=='2') {
          DB::table('products')->where([['vendor_id','=',$request->id],['status','=','approved']])->update(['status'=>'disapproved']);
       }else if($request->value=='1'){
        DB::table('products')->where([['vendor_id','=',$request->id],['status','=','disapproved']])->update(['status'=>'approved']);
       }
       
       echo true;
    }

    public function show_customer(Request $request){
        return view('admin.users.customer_list');
    }

    public function ajax_get_customer(Request $request){
        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'status'=>@$_GET['status']);
        $search = "";
        if ($input['search']){
            $search = "AND (a.name LIKE '%".$input['search']."%' OR a.email LIKE '%".$input['search']."%' OR a.mobile LIKE '%".$input['search']."%')";
        }

        if ($input['start']=='') {
            $input['start']=0;
        }

        if ($input['length']=='') {
            $input['length']=10;
        }
//dd("SELECT a.*,(SELECT profile_photo FROM user_info WHERE userid=a.id) as profile FROM users as a WHERE a.user_type='vendor' $search ORDER BY a.id DESC limit ".$input['start'].",".$input['length']."");
        $totalrows = count(DB::select(DB::raw("SELECT a.* FROM users as a WHERE a.user_type='customer' $search ")));
        $data  = DB::select(DB::raw("SELECT a.*,(SELECT profile_photo FROM user_info WHERE userid=a.id) as profile FROM users as a WHERE a.user_type='customer' $search ORDER BY a.id DESC limit ".$input['start'].",".$input['length'].""));
        $final = [];
        $i=0;
        foreach($data as $row){
            if ($row->email_verify=='yes') {
               $verify='<span class="badge badge-success">Verified</span>';
            }else{
               $verify='<span class="badge badge-danger">Unverified</span>';
            }
			
           if($row->image){
				$image = '<img src="'.url('public/'.$row->image).'" class="product_img">'.$row->name;
			} else {
				$image = '<img src="'.url('public/no-image.png').'" class="product_img">'.$row->name;
			}
            $final[] = array(
                            "DT_RowId" => $row->id,
                            $image,
                            $row->email.' '.$verify,
                            $row->mobile,
                            date('M d, Y',strtotime($row->created_at)),
                            '<div class="btn-group" role="group" aria-label="Basic example">
                            <a href="javascript:;" class="remove" table="users" id="'.$row->id.'"><button  title="View Features" class="btn btn-danger">Remove</button></a>
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

    public function view_vendor_detail(Request $request,$id){
        $data['vendor'] = DB::table('users')->where('id',$id)->first();
        $data['vendor_information'] = DB::table('user_info')->where('userid',$id)->first();
        $data['bank_detail'] = DB::table('bank_detail')->where('vendor_id',$id)->first();
        //dd($data);
        return view("admin.users.user_detail",$data);
    }

    public function edit_vendor_detail(Request $request,$id){
        $data['product_id'] = $id;
        $data['vendor'] = DB::table('users')->where('id',$id)->first();
        $data['vendor_information'] = DB::table('user_info')->where('userid',$id)->first();
        //dd($data);
        return view("admin.users.edit_user_detail",$data);
    }

    public function admin_update_vendor(Request $request){
        
        $info = DB::table('user_info')->where('userid',$request->id)->first();
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

        $update_user_table = DB::table('users')->where('id',$request->id)->update(['name'=>$request->name,'mobile'=>$request->contact,'image'=>$profile]);
        if ($info) {
            DB::table('user_info')->where('userid',$request->id)->update(['complete_address'=>$request->address,'pan_card'=>$pancard,'adhar_card'=>$adharcard,'gst_registration'=>$gst,'firm_registration'=>$firm_registration]);
        }else{
            DB::table('user_info')->insert(['userid'=>$request->id,'complete_address'=>$request->address,'pan_card'=>$pancard,'adhar_card'=>$adharcard,'gst_registration'=>$gst,'firm_registration'=>$firm_registration]);
        }
        return Redirect::back()->with('success', 'Update successfull.');
    }

    public function add_vendor(){
        return view('admin.users.add_vendor');
    }

    public function admin_save_vendor(Request $request){

        if (DB::table('users')->where([['email','=',$request->email],['user_type','=','vendor']])->exists()) {
            return Redirect::back()->with('danger', $request->email.' is already register.');
        }
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
                $profile = null;
            }
        }else{
            $profile = null;
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
                $pancard = null;
            }
        }else{
            $pancard = null;
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
                $adharcard = null;
            }
        }else{
            $adharcard = null;
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
                $gst = null;
            }
        }else{
            $gst = null;
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
                $firm_registration = null;
            }
        }else{
            $firm_registration = null;
        }

        $user_save = DB::table('users')->insertGetId(['login_type'=>'normal','name'=>$request->name,'email'=>$request->email,'mobile'=>$request->contact,'email_verified_at'=>date('Y-m-d H:i:s'),'password'=>Hash::make($request->password),'user_type'=>'vendor','isactive'=>'1','email_verify'=>'yes','image'=>$profile,'created_at'=>date('Y-m-d H:i:s')]);
        if ($user_save) {
            $user_save = DB::table('user_info')->insert(['userid'=>$user_save,'profile_photo'=>$profile,'complete_address'=>$request->address,'pan_card'=>$pancard,'adhar_card'=>$adharcard,'gst_registration'=>$gst,'firm_registration'=>$firm_registration]);
            return redirect(url('admin/vendor'))->with('success', 'New vendor register successfully.');
        }else{
            return Redirect::back()->with('danger', 'Something went wrong. Please trya after some time.');
        }
    }

    public function vendor_payments($id=null){

        $data=array();
        $data['final_order_total']=0;
        $data['final_total_collection_fee']=0;
        $data['final_total_product_comission']=0;
        $data['final_total_fixed_fee']=0;
        $data['final_total_gst_on_comission']=0;
        $data['final_admin_comission']=0;
        $data['final_payable_amount']=0;
        $data['order_ids']=array();
        $data['vendor_list'] = DB::table('users')->select('id','name','email')->where('user_type','vendor')->get();
        if (isset($_GET['search']) && $_GET['search']==true) {
            $data['is_show']=true;
        }else{
            $data['is_show']=false;
        }

        $data['orders'] = array();
        if (isset($_GET['vendorid']) && $_GET['vendorid']!=='') {
            $data['vendor_id'] = $_GET['vendorid'];
        }else{
            $data['vendor_id'] = '0';
        }

        if (isset($_GET['startdate']) && $_GET['startdate']!=='') {
            $data['start_date'] = $_GET['startdate'];
        }else{
            $data['start_date'] = '';
        }

        if (isset($_GET['enddate']) && $_GET['enddate']!=='') {
            $data['end_date'] = $_GET['enddate'];
        }else{
            $data['end_date'] = '';
        }
        if (isset($_GET['search'])){
            if (isset($_GET['startdate']) && $_GET['startdate']!=='') {
                $where = [
                    ['orders.order_status','=','accept'],
                    ['orders.delivery_status','=','delivered'],
                    ['created_at','>=',$_GET['startdate'].' 00:00:00'],
                    ['created_at','<=',$_GET['enddate'].' 23:59:59'],
                    ['orders.vendorid','=',$_GET['vendorid']],
                    ['orders.is_vendor_paid','=','0']
                ];
            }
            if (isset($_GET['vendorid']) && $_GET['vendorid']!=='') {
                $where = [
                    ['orders.order_status','=','accept'],
                    ['orders.delivery_status','=','delivered'],
                    ['orders.created_at','>=',$_GET['startdate'].' 00:00:00'],
                    ['orders.created_at','<=',$_GET['enddate'].' 23:59:59'],
                    ['orders.vendorid','=',$_GET['vendorid']],
                    ['orders.is_vendor_paid','=','0']
                ];
            }else{
                $where = [
                    ['orders.order_status','=','accept'],
                    ['orders.delivery_status','=','delivered'],
                    ['orders.created_at','>=',$_GET['startdate'].' 00:00:00'],
                    ['orders.created_at','<=',$_GET['enddate'].' 23:59:59'],
                    ['orders.is_vendor_paid','=','0']
                ];
            }
            $orders=DB::table('orders')
                            ->join('users', 'orders.vendorid', '=', 'users.id')
                            ->join('products', 'orders.productid', '=', 'products.id')
                            ->select('orders.*', 'users.name as vendorname', 'products.gst as gst','products.comission as comission')
                            ->where($where)
                            ->get();
                            
            if ($orders->count()) {
                foreach ($orders as $row) {
                $data['order_ids'][]=$row->id;
                $gst_exclude_price = ($row->sale_price*(100/(100+$row->gst)));
                $gst_for_price = $row->sale_price-$gst_exclude_price;
                $fixedfeee = $row->sale_price*$row->product_quantity;
                if ($fixedfeee < 500) {
                        $fixedfee=1;
                    }else if($fixedfeee >= 500 && $fixedfeee <= 2999){
                        $fixedfee=5;
                    }else if($fixedfeee >= 3000){
                        $fixedfee=15;
                    }
                    if ($row->comission) {
                        $comission = ($row->comission / 100)*$gst_exclude_price;
                    }else{
                       $comission=0; 
                    }
                    $collection_fee = (2.35/100)*$row->sale_price;
                    $total_comission = $comission*$row->product_quantity;
                    $gst_marrkitplace = (18/100)*(($collection_fee*$row->product_quantity)+$total_comission+$fixedfee);
                    $admin_comission = ($gst_marrkitplace+$total_comission+($collection_fee*$row->product_quantity)+$fixedfee);
                $data['final_order_total']+=($row->sale_price*$row->product_quantity);
                $data['final_total_collection_fee']+=$collection_fee;
                $data['final_total_product_comission']+=$comission;
                $data['final_total_fixed_fee']+=$fixedfee;
                $data['final_total_gst_on_comission']+=$gst_marrkitplace;
                $data['final_admin_comission']+=number_format($admin_comission,2);
                $data['final_payable_amount']+=($row->sale_price*$row->product_quantity)-number_format($admin_comission,2);
                $final = array(
                                'order_id'=>'<a href="'.url('order_detail',[base64_encode($row->order_id)]).'" target="_blank">'.$row->order_id.'</a>',
                                'created_date'=>date('Y F, d',strtotime($row->created_at)),
                                'order_total'=>$row->sale_price*$row->product_quantity,
                                'total_collection_fee'=>number_format($collection_fee,2),
                                'total_product_comission'=>number_format($comission,2),
                                'total_fixed_fee'=>number_format($fixedfee,2),
                                'total_gst_on_comission'=>number_format($gst_marrkitplace,2),
                                'admin_comission'=>number_format($admin_comission,2),
                                'payable_amount'=>number_format(($row->sale_price*$row->product_quantity)-$admin_comission,2),
                        );
                $arrayy[]=$final;
            }
            }else{
               $arrayy=array(); 
            }
            $data['orders'] = $arrayy;
        }
        
        return view('admin.users.vendor_payments',$data);
    }

    public function vendor_payment_report_download(Request $request){
        if (isset($request->vendor) && $request->vendor!=='') {
           $where = [['user_type','=','vendor'],['isactive','=','1'],['id','=',$request->vendor]];
        }else{
            $where = [['user_type','=','vendor'],['isactive','=','1']];
        }

        $data=array();
        $data['vendor_list'] = DB::table('users')->select('id','name','email')->where('user_type','vendor')->get();
        $vendors = DB::table('users')
                                ->where($where)
                                ->orderby('id','desc')
                                ->get();

        if(!$vendors->count()){
           $array['vendor_order_count'] = 0;
           $data['vendor'] = array();
           return redirect()->back()->with('danger','No data to download.');
        }

        foreach ($vendors as $key ) {
            $array['tax_able_amount']=0;
            $array['orders_total']=0;
            $array['total_order']=0;
            $array['vendor_name'] = $key->name;
            $array['vendor_id'] = $key->id;
            $array['vendor_email'] = $key->email;
            $array['account_name'] = (DB::table('bank_detail')->where('vendor_id',$key->id)->first())?DB::table('bank_detail')->where('vendor_id',$key->id)->first()->bank_name:'Not Updated';
            $array['account_number'] = (DB::table('bank_detail')->where('vendor_id',$key->id)->first())?DB::table('bank_detail')->where('vendor_id',$key->id)->first()->account_number:'Not Updated';
            $array['ifsc'] = (DB::table('bank_detail')->where('vendor_id',$key->id)->first())?DB::table('bank_detail')->where('vendor_id',$key->id)->first()->ifsc:'Not Updated';
            $array['accountant_name'] = (DB::table('bank_detail')->where('vendor_id',$key->id)->first())?DB::table('bank_detail')->where('vendor_id',$key->id)->first()->accountant_name:'Not Updated';
            $array['total_comission'] = 0;
            $array['collection_fee'] = 0;
            $array['collection_fee_percent'] = 2.35;
            $array['fixed_fee'] = 0;
            $array['admin_gst'] = 0;
            $array['admin_final_comission'] = 0;
            $orders = DB::table('orders')
                        ->join('products','orders.productid','=','products.id')
                        ->select('orders.*','products.gst','products.gst_amount','products.shipping_charges','products.comission')
                        ->where([['vendorid','=',$array['vendor_id']],['is_payment_done','=','0']])
                        ->get();

            $array['total_order'] = $orders->count();
            foreach ($orders as $key) {
                if ($key->sale_price < 500) {
                    $fixedfee=1;
                }else if($key->sale_price >= 500 && $key->sale_price <= 2999){
                    $fixedfee=5;
                }else if($key->sale_price >= 3000){
                    $fixedfee=15;
                }
                $sale_price = $key->sale_price*$key->product_quantity;
                $gst = $key->gst;
                $array['sale_price'] = $sale_price;
                $array['product_price'] = $key->sale_price;
                $array['quantity'] = $key->product_quantity;
                if ($key->gst) {
                    $slav = $key->gst+100;
                    $gst_amount = ($sale_price/$slav)*100;
                    $gst_exclude_price = ($gst_amount);
                }else{
                    $gst_exclude_price=(($sale_price-0));
                }
                $collection_fee = ($array['collection_fee_percent']/100)*$sale_price;
                $array['collection_fee'] = $array['collection_fee']+$collection_fee;
                $array['fixed_fee'] = $array['fixed_fee']+$fixedfee;
                // $shipping_charges = ($key->shipping_charges)?$key->shipping_charges:0;

                $shipping_charges =0;
                if ($key->comission) {
                    $comission = $key->comission;
                    $array['comission_percentage'] = $comission;
                    $array['comission'] = ($key->comission / 100)*$gst_exclude_price;
                }else{
                    $comission = 0;
                    $array['comission_percentage'] = $comission;
                    $array['comission'] = $gst_exclude_price;
                }
                $array['total_comission'] = $array['total_comission']+$array['comission'];

                $array['tax_able_amount']=$array['tax_able_amount']+$gst_exclude_price-$shipping_charges;
                $array['orders_total'] = $array['orders_total'] + $key->total_price;

                $admin_gst = $array['total_comission'] + $array['fixed_fee'] + $array['collection_fee'];
                $array['admin_gst'] = (18 / 100)*$admin_gst;
                $array['admin_final_comission'] = $admin_gst+ $array['admin_gst'];
               // dd($array);

            }
           
           $array['vendor_order_count'] = $orders->count();
           $vendor[] = $array;
           
        }
        return $this->donwlod_csv($vendor);
    }

    public function vendor_payments_report($id=null){
        
        if ($id) {
            $where = [['user_type','=','vendor'],['isactive','=','1'],['id','=',$id]];
        }else{
            $where = [['user_type','=','vendor'],['isactive','=','1']];
        }
        $data=array();
        $data['is_show'] = false;
        $data['vendor_list'] = DB::table('users')->select('id','name','email')->where('user_type','vendor')->get();
        $vendors = DB::table('users')
                                ->where($where)
                                ->orderby('id','desc')
                                ->paginate(15);

        if(!$vendors->count()){
           $array['vendor_order_count'] = 0;
           $data['vendor'] = array();
           $data['pagination'] = '';
           return view('admin.users.vendor_payments',$data);die;
        }
        foreach ($vendors as $key ) {
            $array['tax_able_amount']=0;
            $array['orders_total']=0;
            $array['total_order']=0;
            $array['vendor_name'] = $key->name;
            $array['vendor_id'] = $key->id;
            $array['vendor_email'] = $key->email;
            $array['account_name'] = (DB::table('bank_detail')->where('vendor_id',$key->id)->first())?DB::table('bank_detail')->where('vendor_id',$key->id)->first()->bank_name:'Not Updated';
            $array['account_number'] = (DB::table('bank_detail')->where('vendor_id',$key->id)->first())?DB::table('bank_detail')->where('vendor_id',$key->id)->first()->account_number:'Not Updated';
            $array['ifsc'] = (DB::table('bank_detail')->where('vendor_id',$key->id)->first())?DB::table('bank_detail')->where('vendor_id',$key->id)->first()->ifsc:'Not Updated';
            $array['accountant_name'] = (DB::table('bank_detail')->where('vendor_id',$key->id)->first())?DB::table('bank_detail')->where('vendor_id',$key->id)->first()->accountant_name:'Not Updated';
            $array['total_comission'] = 0;
            $array['collection_fee'] = 0;
            $array['collection_fee_percent'] = 2.35;
            $array['fixed_fee'] = 0;
            $array['admin_gst'] = 0;
            $array['admin_final_comission'] = 0;
            $orders = DB::table('orders')
                        ->join('products','orders.productid','=','products.id')
                        ->select('orders.*','products.gst','products.gst_amount','products.shipping_charges','products.comission')
                        ->where([['vendorid','=',$array['vendor_id']],['is_payment_done','=','0']])
                        ->get();

            $array['total_order'] = $orders->count();
            foreach ($orders as $key) {
                if ($key->sale_price < 500) {
                    $fixedfee=1;
                }else if($key->sale_price >= 500 && $key->sale_price <= 2999){
                    $fixedfee=5;
                }else if($key->sale_price >= 3000){
                    $fixedfee=15;
                }
                $sale_price = $key->sale_price*$key->product_quantity;
                $gst = $key->gst;
                $array['sale_price'] = $sale_price;
                $array['product_price'] = $key->sale_price;
                $array['quantity'] = $key->product_quantity;
                if ($key->gst) {
                    $slav = $key->gst+100;
                    $gst_amount = ($sale_price/$slav)*100;
                    $gst_exclude_price = ($gst_amount);
                }else{
                    $gst_exclude_price=(($sale_price-0));
                }
                $collection_fee = ($array['collection_fee_percent']/100)*$sale_price;
                $array['collection_fee'] = $array['collection_fee']+$collection_fee;
                $array['fixed_fee'] = $array['fixed_fee']+$fixedfee;
                // $shipping_charges = ($key->shipping_charges)?$key->shipping_charges:0;

                $shipping_charges =0;
                if ($key->comission) {
                    $comission = $key->comission;
                    $array['comission_percentage'] = $comission;
                    $array['comission'] = ($key->comission / 100)*$gst_exclude_price;
                }else{
                    $comission = 0;
                    $array['comission_percentage'] = $comission;
                    $array['comission'] = $gst_exclude_price;
                }
                $array['total_comission'] = $array['total_comission']+$array['comission'];

                $array['tax_able_amount']=$array['tax_able_amount']+$gst_exclude_price-$shipping_charges;
                $array['orders_total'] = $array['orders_total'] + $key->total_price;

                $admin_gst = $array['total_comission'] + $array['fixed_fee'] + $array['collection_fee'];
                $array['admin_gst'] = (18 / 100)*$admin_gst;
                $array['admin_final_comission'] = $admin_gst+ $array['admin_gst'];
               // dd($array);

            }
           
           $array['vendor_order_count'] = $orders->count();
           $data['vendor'][] = $array;
           $data['pagination'] = $vendors->links();
        }
        dd($data);
        return view('admin.users.vendor_payments',$data);
    }

    public function donwlod_csv($vendor){
        
        $fileName = 'vendor-payment.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $columns = array('Name', 'Email', 'Account Name', 'Account Number', 'IFSC', 'Bank Name', 'Payable amount');

        $callback = function() use($vendor, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($vendor as $task) {
            
            fputcsv($file, array($task->vendor_name,$task->vendor_email,$task->account_name,$task->account_number,$task->ifsc,$task->accountant_name,($task->orders_total-$task->admin_final_comission)));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function make_vendor_payment(Request $request){
        $payment = DB::table('payments')->insert(['vendor_id'=>$request->vendor_id,'vendor_payment'=>$request->vendor_payment,'admin_comission'=>$request->admin_comission,'total_collection_fee'=>$request->total_collection_fee,'total_product_comission'=>$request->total_product_comission,'total_fixed_fee'=>$request->total_fixed_fee,'total_gst_on_comission'=>$request->total_gst_on_comission,'payment_date'=>date('Y-m-d H:i:s'),'status'=>1,'created_at'=>date('Y-m-d H:i:s'),'from_date'=>$request->start_date,'to_date'=>$request->end_date]);
        if ($payment) {
            $orderids = explode(',', $request->orderids);
            foreach($orderids as $key){
                $update_orders = DB::table('orders')->where([['id','=',$key]])->update(['is_vendor_paid'=>'1']);
            }
            return Redirect::back()->with('success', 'Payment update successfully.');
        }else{
             return Redirect::back()->with('danger', 'Something went wrong. Please trya after some time.');
        }
    }

    public function download_vendor_csv(){
        $search='';
        $where='';
        
        if (isset($_GET['status'])) {
            $search.="AND (a.isactive='".$_GET['status']."')";
        }
        
        $fileName = 'vendor.csv';
        $tasks  = DB::select(DB::raw("SELECT a.* FROM users as a WHERE a.user_type='vendor' $search"));
         $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $columns = array('Name', 'Email', 'Contact', 'register date', 'status');
        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($tasks as $task) {

            if($task->isactive==0){
                $status='pending';
            }else if($task->isactive==1){
                $status='Activate';
            }else if($task->isactive==2){
                $status='De-activate';
            }

            $row['Name']  = $task->name;
            $row['Email']    = $task->email;
            $row['Contact']= $task->mobile;
            $row['register date']  = $task->created_at;
            $row['status'] = $status;

            fputcsv($file, array($row['Name'],$row['Email'],$row['Contact'],$row['register date'],$row['status']));
            }

            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
