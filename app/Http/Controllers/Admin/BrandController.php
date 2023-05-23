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
class BrandController extends Controller
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
	public function brand_list(){
		  $data['brand'] = DB::table('brand')->get()->toarray();
         return view('admin.brand.list',$data);
	}

    public function add_brand(){
		  return view('admin.brand.add');
    }
 
	
    public function save_brand(Request $request){
        $input = $request->all();
        $userid = Auth::user()->id;
        $banner  = null; 
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $destinationPath = public_path('uploads');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            $image_name = 'brand'.time() . '.' . $extension;
            if ($file->move($destinationPath, $image_name)) {
                $banner = 'uploads/' . $image_name;
            } else {
                $banner = null;
            }
        }
	 
       $insert = DB::table('brand')->insert(['title'=>$input['title'], 'status'=>$input['status'],'banner'=>$banner]);
        if ($insert) {
            return redirect(url('admin/brand'))->with('success','brand is added successfully!');
        }else{
            return redirect(url('admin/brand'))->with('danger','Oops something went wrong.');
        }
    }

	/* Update brand Status*/
    public function brand_status(Request $request){
		$update =   DB::table('brand')->where('id',$request->id)->update([$request->name=>$request->value]);
		if($update){ echo 1;  } else { echo 2;}
	}
	
	
    public function edit_brand(Request $request,$id){
        $data['brand'] = DB::table('brand')->where('id',$id)->first();
		 return view('admin.brand.edit',$data);
    }  
	public function view_brand(Request $request,$id){
        $data['brand'] = DB::table('brand')->where('id',$id)->first();
		 return view('admin.brand.view',$data);
    }

    public function  update_brand(Request $request){
        $input = $request->all();
        $userid = Auth::user()->id;
        $data['brand'] = DB::table('brand')->where('id',$request->id)->first();
 
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $destinationPath = public_path('uploads');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            $image_name = 'brand'.time() . '.' . $extension;
            if ($file->move($destinationPath, $image_name)) {
                $banner = 'uploads/' . $image_name;
				
				/* Unlink file on update new file*/
				if(!empty($data['brand']->banner)){
					$file_with_path = public_path('/').$data['brand']->banner; 
					if (file_exists($file_with_path)) {
								unlink($file_with_path);
				 } }
			 
            } else {
                $banner = $data['brand']->banner;
            }
        }else{
            $banner = $data['brand']->banner;
        }
		  
        $updated = DB::table('brand')->where('id',$request->id)->update(['title'=>$input['title'],'status'=>$input['status'],'banner'=>$banner]);
        if ($updated) {
            return redirect(url('admin/brand'))->with('success','brand is updated successfully!');
        }else{
            return redirect(url('admin/brand'))->with('danger','Oops something went wrong.');
        }
    }

    public function delete_brand(Request $request){
        DB::table($request->table)->where('id',$request->id)->delete();
        echo 1;
    }

 
}
