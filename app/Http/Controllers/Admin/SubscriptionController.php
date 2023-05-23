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
use Stripe;
class SubscriptionController extends Controller
{
	#get_location
	public function List(Request $request){
		$data['locations'] = DB::table('memberships')->get();
		return view('admin.subscription.list',$data);
	}
    #add_location
	public function add_membership(Request $request){
		return view('admin.subscription.add_membership');
	}

	public function save_membership(Request $request){
		$stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
		// create product
		$product = $stripe->products->create([
			  'name' => 'Gold Special',
			]);
		// create plan
		$plan = $stripe->plans->create([
		  'amount' => $request->price*100,
		  'currency' => 'usd',
		  'interval' => $request->interval,
		  'product' => $product->id,
		]);
		$insert = DB::table('memberships')->insert(['productid'=>$product->id,'planid'=>$plan->id,'title'=>$request->title,'price'=>$request->price,'duration'=>$request->interval,'description'=>$request->description]);
		if ($insert) {
			return back()->with('success','New membership added successfully.');
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
