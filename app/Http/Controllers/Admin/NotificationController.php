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
use Response;
class NotificationController extends Controller{
    use AuthenticatesUsers;
    public function __construct() {
           
    }
	//show admin page
	public function notifications (){
        $data = array();
        return view('admin.notification.list',$data);
	}

    public function ajax_get_notification(Request $request){
        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw']);
        $search = "";
        $where = "vendorid='".Auth::user()->id."'";
        

        if ($input['start']=='') {
            $input['start']=0;
        }

        if ($input['length']=='') {
            $input['length']=10;
        }
        $totalrows = count(DB::select(DB::raw("SELECT * FROM notifications WHERE $search $where")));
        $data  = DB::select(DB::raw("SELECT * FROM notifications WHERE $search $where ORDER BY id DESC limit ".$input['start'].",".$input['length'].""));
        $final = [];
        $i=1;
        foreach($data as $row){
            $final[] = array(
                            "DT_RowId" => $row->id,
                            "DT_RowClass" => ($row->is_read)?'read':'not-read',
                            $i,
                            $row->notification,
                            date('M d, Y',strtotime($row->created_at)),
                            '<div class="btn-group" role="group" aria-label="Basic example">
                            <br><a href="javascript:;" class="mark_read btn btn-outline-success btn-sm" table="notifications" id="'.$row->id.'" data-value="1">mark read</a>
                            </div>'
                    );
            $i++;
        }

        $json_data = array(
                        "draw"=> intval($input['draw']),
                        "recordsTotal"    => intval(count($final) ),  
                        "recordsFiltered" => intval($totalrows), 
                        "data"            => $final 
                    );
        echo json_encode($json_data);
    }

   public function get_notification_count(Request $request){
       $notification = DB::table('notifications')->where([['vendorid','=',$request->id],['is_read','=',0]])->count();
       echo $notification;
   }

   public function mark_read_notification(Request $request){
       DB::table('notifications')->where('id',$request->rowid)->update(['is_read'=>1]);
       $notification = DB::table('notifications')->where([['vendorid','=',Auth::user()->id],['is_read','=',0]])->count();
       echo $notification;
   }
}
