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
class PageController extends Controller{
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
	public function index(){
        return view('admin.pages.list');
	}

    public function ajax_get_pages(Request $request){
        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'status'=>@$_GET['status']);
        $search = "";
        if ($input['search']){
            $search = "WHERE (page_title LIKE '%".$input['search']."%')";
        }

        if ($input['start']=='') {
            $input['start']=0;
        }

        if ($input['length']=='') {
            $input['length']=10;
        }
        $totalrows = count(DB::select(DB::raw("SELECT * FROM pages $search")));
        $data  = DB::select(DB::raw("SELECT * FROM pages $search ORDER BY id DESC limit ".$input['start'].",".$input['length'].""));
        $final = [];
        $i=0;
        foreach($data as $row){
            $final[] = array(
                            "DT_RowId" => $row->id,
                            $row->type,
                            $row->page_title,
                            $row->status,
                            date('M d, Y',strtotime($row->created_at)),
                            '<div class="btn-group" role="group" aria-label="Basic example">
                            <a href="javascript:;" class="btn btn-outline-primary btn-sm"> <i class="fa fa-eye"></i> </a>&nbsp;
							<br><a href="javascript:;" class="delete_row btn btn-outline-danger btn-sm" table="pages" data-value="'.$row->id.'"><i class="fa fa-trash"></i></a>
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

    public function add_page(){
        return view('admin.pages.add');
    }

    public function save_page(Request $request){
        if (!DB::table('pages')->where('type',$request->page_name)->exists()) {
            $insert = DB::table('pages')->insert(['type'=>$request->page_name,'page_title'=>$request->page_title,'description'=>$request->description,'seo_title'=>$request->seo_title,'seo_descripton'=>$request->seo_description,'seo_tags'=>$request->seo_tags,'link'=>$request->link]);
            if ($insert){
                return redirect()->back()->with('success','New Page Added.');
            }else{
                return redirect()->back()->with('danger','Something went wrong. Please try after some time.');
            }
        }else{
            return redirect()->back()->with('danger','This page is already added');
        }
    }
}
