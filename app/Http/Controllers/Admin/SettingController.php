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
class SettingController extends Controller{
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
	public function general_setting(){
        $data['data'] = DB::table('settings')->first();
        return view('admin/frontpage.general',$data);
	}

    public function update_settings(Request $request){
          $input = $request->all();
          $data['setting'] = DB::table('settings')->first();
            //Update logo
           if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $destinationPath = public_path('uploads');
                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0777, true, true);
                }
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $image_name = 'logo'.time() . '.' . $extension;
                if ($file->move($destinationPath, $image_name)) {
                    $logo = 'uploads/' . $image_name;
                    /* Unlink file on update new file*/
                    if(!empty($data['setting']->logo)){
                        $file_with_path = public_path('/').$data['setting']->logo; 
                        if (file_exists($file_with_path)) {
                                    unlink($file_with_path);
                     } }
                 } else {
                    $logo = $data['setting']->logo;
                 }
            }else{
                 $logo = $data['setting']->logo;
            }
        

        //Update footer_logo
           if ($request->hasFile('footer_logo')) {
                $file = $request->file('footer_logo');
                $destinationPath = public_path('uploads');
                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0777, true, true);
                }
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $image_name = 'footer_logo'.time() . '.' . $extension;
                if ($file->move($destinationPath, $image_name)) {
                    $footer_logo = 'uploads/' . $image_name;
                    /* Unlink file on update new file*/
                    if(!empty($data['setting']->footer_logo)){
                        $file_with_path = public_path('/').$data['setting']->footer_logo; 
                        if (file_exists($file_with_path)) {
                                    unlink($file_with_path);
                     } }
                 } else {
                    $footer_logo = $data['setting']->footer_logo;
                 }
            } else {
                 $footer_logo = $data['setting']->footer_logo;
            }


             //Update icon
             if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $destinationPath = public_path('uploads');
                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0777, true, true);
                }
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $image_name = 'icon'.time() . '.' . $extension;
                if ($file->move($destinationPath, $image_name)) {
                    $icon = 'uploads/' . $image_name;
                    /* Unlink file on update new file*/
                    if(!empty($data['setting']->icon)){
                        $file_with_path = public_path('/').$data['setting']->icon; 
                        if (file_exists($file_with_path)) {
                                    unlink($file_with_path);
                     } }
                 } else {
                    $icon = $data['setting']->icon;
                 }
                  }else{
                         $icon = $data['setting']->icon;
               }
          
        $updated = DB::table('settings')->where('id',1)->update([
            'site_title'=>$input['site_title'],
            'phone'=>$input['phone'],
            'whatsapp'=>$input['whatsapp'], 
            'whatsapp_message'=>$input['whatsapp_message'], 
            'email'=>$input['email'], 
            'address'=>$input['address'], 
            'city'=>$input['city'], 
            'state'=>$input['state'], 
            'country'=>$input['country'], 
            'country_code'=>$input['country_code'], 
            'currency_sign'=>$input['currency_sign'], 
            'logo'=>$logo,
            'footer_logo'=>$footer_logo,
            'icon'=>$icon]);
        if ($updated) {
            return redirect()->back()->with('success','Record is updated successfully!');
        }else{
            return redirect()->back()->with('danger','Oops something went wrong.');
        }
    }

	public function home_page_setting(){
		return view('admin/frontpage.home');
	}
}
