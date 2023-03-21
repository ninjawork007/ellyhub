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
class CategoryController extends Controller
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
                if (Auth::user()->user_type!='superadmin') {
                   return redirect()->route('admin_logout'); 
                }
                return $next($request);
            });
    }
	//show admin page
	public function category_list(){
        $data['category'] = DB::table('categories')->paginate(10);
        return view('admin.category.list',$data);
	}

    public function category_add(){
        return view('admin.category.add');
    }

    public function category_save(Request $request){
        $input = $request->all();
        if($request->hasFile('icon')){
            $icon = 'img_'.time().'.'.request()->icon->getClientOriginalExtension();
            $upload = request()->icon->move(public_path('/uploads'), $icon);
        } else {
            $icon = null;
        }

        $insert = DB::table('categories')->insert(['name'=>$input['name'],'slug'=>$input['slug'],'image'=>$icon]);
        if ($insert) {
            return redirect(url('admin/category'))->with('success','Category is added successfully!');
        }else{
            return redirect(url('admin/category'))->with('danger','Oops something went wrong.');
        }
    }

    public function category_edit(Request $request,$id){
        $data['category'] = DB::table('categories')->where('id',$id)->first();
        return view('admin.category.edit',$data);
    }

    public function category_update(Request $request){
        if (DB::table('categories')->where('slug',$request->slug)->exists()) {
             return back()->with('danger','This category name already exits.');
        }
        $input = $request->all();
        $data['category'] = DB::table('categories')->where('id',$request->id)->first();
        if($request->hasFile('icon')){
            $icon = 'img_'.time().'.'.request()->icon->getClientOriginalExtension();
            $upload = request()->icon->move(public_path('/uploads'), $icon);
        } else {
            $icon = $data['category']->image;
        }

        $insert = DB::table('categories')->where('id',$request->id)->update(['name'=>$input['name'],'slug'=>$input['slug'],'image'=>$icon]);
        if ($insert) {
            return redirect(url('admin/category'))->with('success','Category is updated successfully!');
        }else{
            return redirect(url('admin/category'))->with('danger','Oops something went wrong.');
        }
    }

    public function delete_row(Request $request){
        DB::table($request->table)->where('id',$request->id)->delete();
        echo 1;
    }
}
