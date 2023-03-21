<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\CategoryRequest;
use DB;
use Cviebrock\EloquentSluggable\Services\SlugService;

class LocationController extends Controller
{
	#get_location
	public function get_location(Request $request){
		$data['locations'] = DB::table('city_state')->paginate(10);
		return view('admin.locations.list',$data);
	}
    #add_location
	public function add_location(Request $request){
		return view('admin.locations.add_location');
	}

	public function save_location(Request $request){
		$input = $request->all();
		$insert = DB::table('city_state')->insert(['city'=>$input['city'],'state'=>$input['state'],'country'=>$input['country'],'zip_code'=>$input['zip']]);
		if ($insert) {
			return back()->with('success','New location added successfully.');
		}else{
			return back()->with('danger','opss something went wrong. Please try after some time.');
		}
		
	}

	public function edit_location(Request $request,$id){
		$data['location'] = DB::table('city_state')->where('id',$id)->first();
		return view('admin.locations.edit_location',$data);
	}

	public function update_location(Request $request){
		$input = $request->all();
		$insert = DB::table('city_state')->where('id',$input['id'])->update(['city'=>$input['city'],'state'=>$input['state'],'country'=>$input['country'],'zip_code'=>$input['zip']]);
		return back()->with('success','Location update successfully.');
	}
}
