<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;
class CoupenController extends Controller
{
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
        return view('admin.coupen.list');
	}

    public function ajax_get_coupen(Request $request){
        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'status'=>@$_GET['status']);
        $search = "";
        $where = "";
        
        if ($input['search']){
            $search = "WHERE (name LIKE '%".$input['search']."%')";
        }

        if ($input['start']=='') {
            $input['start']=0;
        }

        if ($input['length']=='') {
            $input['length']=10;
        }

        $totalrows = count(DB::select(DB::raw("SELECT * FROM coupens $search $where")));
        $data  = DB::select(DB::raw("SELECT * FROM coupens $search $where ORDER BY id DESC limit ".$input['start'].",".$input['length'].""));
        $final = [];
        $i=0;
        foreach($data as $row){
            $final[] = array(
                            "DT_RowId" => $row->id,
                            $row->name,
                            $row->code,
                            $row->type,
                            $row->discount,
                            date('M d, Y',strtotime($row->expiry_date)),
                            date('M d, Y',strtotime($row->created_at)),
                            '<div class="btn-group" role="group" aria-label="Basic example">
                            <a href="javascript:;" class="delete_row" table="coupens" id="'.$row->id.'" data-value="1"><button  title="View Features" class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
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

    public function add_coupen(){
        return view('admin.coupen.add');
    }

    public function save_coupen(Request $request){
        $input = $request->all();
        if (DB::table('coupens')->where([['slug','=',$input['slug']]])->exists()) {
            return redirect(url('admin/coupens'))->with('danger','This Coupen is already Exits.');
        }

        $insert = DB::table('coupens')->insert(['name'=>$input['name'],'slug'=>$input['slug'],'type'=>$input['discount_type'],'discount'=>$input['discount'],'expiry_date'=>$input['expiry_date'],'code'=>$input['code']]);
        if ($insert) {
            return redirect(url('admin/coupens'))->with('success','New Coupen is added successfully!');
        }else{
            return redirect(url('admin/coupens'))->with('danger','Something went wrong. Please try after some time.');
        }
    }

    public function delete_row(Request $request){
    	DB::table($request->table)->where('id',$request->id)->delete();
    	echo true;
    }
}
