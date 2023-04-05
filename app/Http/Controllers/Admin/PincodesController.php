<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;
class PincodesController extends Controller
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
	public function pin_codes(){
        return view('admin.pincodes.list');
	}

    public function ajax_get_pincodes(Request $request){
        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'status'=>@$_GET['status']);
        $search = "";
        if ($input['search']){
            $search = "WHERE (pincode LIKE '%".$input['search']."%')";
        }

        if ($input['start']=='') {
            $input['start']=0;
        }

        if ($input['length']=='') {
            $input['length']=10;
        }

        $totalrows = count(DB::select(DB::raw("SELECT * FROM pin_codes $search")));
        $data  = DB::select(DB::raw("SELECT * FROM pin_codes $search ORDER BY id DESC limit ".$input['start'].",".$input['length'].""));
        $final = [];
        $i=0;
        foreach($data as $row){
            $final[] = array(
                            "DT_RowId" => $row->id,
                            $row->pincode,
                            '<div class="btn-group" role="group" aria-label="Basic example">
                            <a href="javascript:;" class="delete_row"  id="'.$row->id.'"><button  title="View Features" class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
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

    public function add_pin_code(){
        return view('admin.pincodes.add');
    }

    public function save_pincode(Request $request){
        $input = $request->all();
        if (DB::table('pin_codes')->where([['pincode','=',$input['code']]])->exists()) {
            return redirect(url('admin/pin-codes'))->with('danger','This pincode already in database.');
        }

        $insert = DB::table('pin_codes')->insert(['pincode'=>$input['code']]);
        if ($insert) {
            return redirect(url('admin/pin-codes'))->with('success','New Pin code is added successfully!');
        }else{
            return redirect(url('admin/pin-codes'))->with('danger','Something went wrong. Please try after some time.');
        }
    }

    public function delete_pincode(Request $request){
    	DB::table('pin_codes')->where('id',$request->id)->delete();
    	echo true;
    }
}
