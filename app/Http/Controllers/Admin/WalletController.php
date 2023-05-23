<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;
class WalletController extends Controller
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
	public function wallet(){
        return view('admin.wallet.list');
	}

    public function ajax_get_customer_wallet(Request $request){
        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'status'=>@$_GET['status']);
        $search = "";
        if ($input['search']){
            $search = "AND (name LIKE '%".$input['search']."%' OR email LIKE '%".$input['search']."%')";
        }

        if ($input['start']=='') {
            $input['start']=0;
        }

        if ($input['length']=='') {
            $input['length']=10;
        }
        $totalrows = count(DB::select(DB::raw("SELECT * FROM users WHERE user_type='customer' $search ")));
        $data  = DB::select(DB::raw("SELECT * FROM users WHERE user_type='customer' $search ORDER BY id DESC limit ".$input['start'].",".$input['length'].""));
        $final = [];
        $i=0;
        foreach($data as $row){
            $final[] = array(
                            "DT_RowId" => $row->id,
                            $row->name,
                            $row->email,
                            $row->mobile,
                            '₹'.$row->balance,
                            '<div class="btn-group" role="group" aria-label="Basic example">
                            <a href="javascript:;" onclick="show_modal('.$row->id.')" class="add_amount" table="delivery_fee_slab" id="'.$row->id.'"><button  title="Wallet add" class="btn btn-primary">Add Balance</button></a>
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

    public function update_balance(Request $request){
        DB::table('users')->where('id',$request->id)->increment('balance',$request->amount);
        return back()->with('success','Wallet Balance updated.');
    }
}
