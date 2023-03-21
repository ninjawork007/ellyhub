<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;
class DeliveryController extends Controller
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
	public function delivery(){
        return view('admin.delivery.list');
	}

    public function ajax_get_delivery_slab(Request $request){
        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'status'=>@$_GET['status']);
        $search = "";
        if ($input['search']){
            $search = "WHERE (delivery_fee LIKE '%".$input['search']."%')";
        }

        if ($input['start']=='') {
            $input['start']=0;
        }

        if ($input['length']=='') {
            $input['length']=10;
        }
        $totalrows = count(DB::select(DB::raw("SELECT * FROM delivery_fee_slab $search ")));
        $data  = DB::select(DB::raw("SELECT * FROM delivery_fee_slab $search ORDER BY id DESC limit ".$input['start'].",".$input['length'].""));
        $final = [];
        $i=0;
        foreach($data as $row){
            $final[] = array(
                            "DT_RowId" => $row->id,
                            '₹'.$row->price_from,
                            '₹'.$row->price_to,
                            '₹'.$row->delivery_fee,
                            '<div class="btn-group" role="group" aria-label="Basic example">
                            <a href="javascript:;" class="delete_row" table="delivery_fee_slab" id="'.$row->id.'"><button  title="Remove" class="btn btn-danger">Trash</button></a>
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

    public function save_delivery_slab(Request $request){
        if (!DB::table('delivery_fee_slab')->where([['price_from','=',$request->range_from],['price_to','=',$request->range_to]])->exists()){
            $insert = DB::table('delivery_fee_slab')->insert(['price_from'=>$request->range_from,'price_to'=>$request->range_to,'delivery_fee'=>$request->delivery_fee]);
            if ($insert) {
                return redirect(url('admin/delivery'))->with('success','New delivery slab added.');
            }else{
                return redirect(url('admin/delivery'))->with('danger','Something went wrong. Please try after some time.');
            }
        }else{
            return redirect(url('admin/delivery'))->with('danger','This delivery slab already exists.');
        }
    }

    public function delete_delivery_slab(Request $request){
        DB::table($request->table)->where('id',$request->id)->delete();
        echo true;
    }
}
