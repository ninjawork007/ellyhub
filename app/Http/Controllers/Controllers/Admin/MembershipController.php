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
class MembershipController extends Controller
{

    use AuthenticatesUsers;
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
	public function membership(){
        $data['list'] = DB::table('memberships')->paginate(10);
        return view('admin.membership.list',$data);
	}

    public function membership_add(Request $request){
        return view('admin.membership.add');
    }

    public function membership_save(Request $request){
        $input = $request->all();
        $insert = DB::table('memberships')->insert(['price'=>$input['price'],'title'=>$input['title'],'description'=>$input['description']]);
        if ($insert) {
            return redirect(url('admin/membership'))->with('success','Membership is added successfully!');
        }else{
            return redirect(url('admin/membership'))->with('danger','Oops something went wrong.');
        }
    }

    public function membership_edit(Request $request,$id){
        $data['membership'] = DB::table('memberships')->where('id',$id)->first();
        return view('admin.membership.edit',$data);

    }

    public function membership_update(Request $request){
        $input = $request->all();
        $update = DB::table('memberships')->where('id',$input['id'])->update(['price'=>$input['price'],'title'=>$input['title'],'description'=>$input['description']]);
         return redirect(url('admin/membership'))->with('success','Membership is updated successfully!');
    }
}
