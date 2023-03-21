<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;
class AdminController extends Controller
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
        return view('admin.staff.list');
	}

    public function ajax_get_staff(Request $request){
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

        $totalrows = count(DB::select(DB::raw("SELECT a.* FROM users as a WHERE a.user_type='superadmin' AND a.admin_type='staff' $search $where")));
        $data  = DB::select(DB::raw("SELECT a.* FROM users as a WHERE a.user_type='superadmin' AND a.admin_type='staff' $search $where ORDER BY a.id DESC limit ".$input['start'].",".$input['length'].""));
        $final = [];
        $i=0;
        foreach($data as $row){
            $final[] = array(
                            "DT_RowId" => $row->id,
                            $row->name,
                            $row->email,
                            $row->mobile,
                            date('M d, Y',strtotime($row->created_at)),
                            '<div class="btn-group" role="group" aria-label="Basic example">
                            <a href="javascript:;" class="delete_row" table="users" id="'.$row->id.'" data-value="1"><button  title="View Features" class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
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

    public function add_staff(){
        return view('admin.staff.add');
    }

    public function save_staff(Request $request){
        $input = $request->all();
        if (DB::table('users')->where([['email','=',$input['email']],['user_type','=','superadmin']])->exists()) {
            return redirect(url('admin/staff-add'))->with('danger','This email is already register with us. Please user other email address.');
        }

        $insert = DB::table('users')->insert(['name'=>$input['name'],'email'=>$input['email'],'mobile'=>$input['mobile'],'password'=>Hash::make($input['password']),'user_type'=>'superadmin','admin_type'=>'staff','isactive'=>'1']);
        if ($insert) {
            return redirect(url('admin/staff'))->with('success','New staff is added successfully!');
        }else{
            return redirect(url('admin/staff'))->with('danger','Something went wrong. Please try after some time.');
        }
    }
}
