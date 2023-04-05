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
class BannerController extends Controller
{
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
	public function banner_list(){
		 $data['banner'] = DB::table('banner')->paginate(10);
        return view('admin.banner.list',$data);
	}

    public function add_banner(){
		  return view('admin.banner.add');
    }
 
	
    public function save_banner(Request $request){
        $input = $request->all();
        $userid = Auth::user()->id;
        $banner = $m_banner =  null;
 
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $destinationPath = public_path('uploads');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            $image_name = 'banner'.time() . '.' . $extension;
            if ($file->move($destinationPath, $image_name)) {
                $banner = 'uploads/' . $image_name;
            } else {
                $banner = null;
            }
        }
		//m_banner
        if ($request->hasFile('m_banner')) {
            $file = $request->file('m_banner');
            $destinationPath = public_path('uploads');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            $image_name = 'm_banner'.time() . '.' . $extension;
            if ($file->move($destinationPath, $image_name)) {
                $m_banner = 'uploads/' . $image_name;
            } else {
                $m_banner = null;
            }
        }


       $insert = DB::table('banner')->insert(['title'=>$input['title'],'user_id'=>$userid,'status'=>$input['status'],'url'=>$input['url'],'banner_type'=>$input['banner_type'],'m_banner'=>$m_banner,'banner'=>$banner]);
        if ($insert) {
            return redirect(url('admin/banner'))->with('success','Banner is added successfully!');
        }else{
            return redirect(url('admin/banner'))->with('danger','Oops something went wrong.');
        }
    }

	/* Update Banner Status*/
    public function banner_status(Request $request){
		$update =   DB::table('banner')->where('id',$request->id)->update(['status'=>$request->value]);
		if($update){ echo 1;  } else { echo 2;}
	}
	
	
    public function edit_banner(Request $request,$id){
        $data['banner'] = DB::table('banner')->where('id',$id)->first();
		 return view('admin.banner.edit',$data);
    }  
	public function view_banner(Request $request,$id){
        $data['banner'] = DB::table('banner')->where('id',$id)->first();
		 return view('admin.banner.view',$data);
    }

    public function  update_banner(Request $request){
        $input = $request->all();
        $userid = Auth::user()->id;
        $data['banner'] = DB::table('banner')->where('id',$request->id)->first();
        $file_with_path = public_path('/').$data['banner']->m_banner; 
 
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $destinationPath = public_path('uploads');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            $image_name = 'banner'.time() . '.' . $extension;
            if ($file->move($destinationPath, $image_name)) {
                $banner = 'uploads/' . $image_name;
				
				/* Unlink file on update new file*/
				if(!empty($data['banner']->banner)){
					$file_with_path = public_path('/').$data['banner']->banner; 
					if (file_exists($file_with_path)) {
								unlink($file_with_path);
				 } }
			 
            } else {
                $banner = $data['banner']->banner;
            }
        }else{
            $banner = $data['banner']->banner;
        }
		
		// Mobile m_banner
		if ($request->hasFile('m_banner')) {
            $file = $request->file('m_banner');
            $destinationPath = public_path('uploads');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            $image_name = 'm_banner'.time() . '.' . $extension;
            if ($file->move($destinationPath, $image_name)) {
                $m_banner = 'uploads/' . $image_name;
				
				/* Unlink file on update new file*/
				if(!empty($data['banner']->m_banner)){
					$file_with_path = public_path('/').$data['banner']->m_banner; 
					if (file_exists($file_with_path)) {
								unlink($file_with_path);
					}
				}
			 
            } else {
                $m_banner = $data['banner']->m_banner;
            }
        }else{
            $m_banner = $data['banner']->m_banner;
        }

        $updated = DB::table('banner')->where('id',$request->id)->update(['title'=>$input['title'],'user_id'=>$userid,'status'=>$input['status'],'url'=>$input['url'],'banner_type'=>$input['banner_type'],'banner'=>$banner,'m_banner'=>$m_banner]);
        if ($updated) {
            return redirect(url('admin/banner'))->with('success','Banner is updated successfully!');
        }else{
            return redirect(url('admin/banner'))->with('danger','Oops something went wrong.');
        }
    }

    public function delete_banner(Request $request){
        DB::table($request->table)->where('id',$request->id)->delete();
        echo 1;
    }

 
}
