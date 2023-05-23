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
	public function category_list(){
        $data['category'] = DB::table('categories')->paginate(10);
        return view('admin.category.list',$data);
	}

    public function category_add(){
        return view('admin.category.add');
    }
	/* Show Category On Home Screen*/
    public function home_category(Request $request){
		 
		 $totalrows =   count(DB::select(DB::raw("SELECT home_screen  FROM categories WHERE `home_screen` = 'yes' and isactive  = 'active'")));
		if($totalrows < 5){
			  $update =   DB::table('categories')->where('id',$request->id)->update(['home_screen'=>$request->value]); 
			  echo 1;
		 } else {
				 if($request->value == 'no') {
					  $update =   DB::table('categories')->where('id',$request->id)->update(['home_screen'=>$request->value]);
				 }
			  echo 2;
		 }  
	}
	/* Change Status Of Category */
	    public function category_status(Request $request){
			$update =   DB::table('categories')->where('id',$request->id)->update(['isactive'=>$request->value]); 
			echo 1;
	   }
	 
	
    public function category_save(Request $request){
        $input = $request->all();

        $banner = $icon = null;
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
            } else {
                $icon = null;
            }
        }

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



        $insert = DB::table('categories')->insert(['name'=>$input['name'],'slug'=>$input['slug'],'image'=>$icon,'banner'=>$banner]);
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
        $input = $request->all();
	
        
        if (DB::table('categories')->where([['slug','=',$request->slug],['id','!=',$request->id]])->exists()) {
             return back()->with('danger','This category name already exits.');
        }
        

        $data['category'] = DB::table('categories')->where('id',$request->id)->first();
        
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
            } else {
                $icon = $data['category']->image;
            }
        }else{
            $icon = $data['category']->image;
        }

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
                $banner = $data['category']->banner;
            }
        }else{
            $banner = $data['category']->banner;
        }

        $insert = DB::table('categories')->where('id',$request->id)->update(['name'=>$input['name'],'slug'=>$input['slug'],'image'=>$icon,'banner'=>$banner]);
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

    public function sub_category_list(Request $request){
        $data['sub_category'] = DB::table('sub_categories')->paginate(10);
        return view('admin.subcategory.list',$data);
    }

    public function sub_category_add(Request $request){
        $data['category'] = DB::table('categories')->get();
        return view('admin.subcategory.add',$data);
    }

    public function sub_category_save(Request $request){
        $input = $request->all();
        $banner = null;
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
            }else{
                $banner = null;
            }
        }
        $insert = DB::table('sub_categories')->insert(['category_id'=>$input['category'],'title'=>$input['name'],'banner'=>$banner]);
        if ($insert) {
            return redirect(url('admin/sub-category'))->with('success','Sub category is added successfully!');
        }else{
            return redirect(url('admin/sub-category'))->with('danger','Oops something went wrong.');
        }
    }

    public function sub_category_edit(Request $request,$id){
        $data['category'] = DB::table('categories')->get();
        $data['sub_category'] = DB::table('sub_categories')->where('id',$id)->first();
        return view('admin.subcategory.edit',$data);
    }

    public function sub_category_update(Request $request){
        $input = $request->all();
        $data['category'] = DB::table('sub_categories')->where('id',$request->id)->first();

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
                $banner = $data['category']->banner;
            }
        }else{
            $banner = $data['category']->banner;
        }

        $update = DB::table('sub_categories')->where('id',$request->id)->update(['category_id'=>$request->category,'title'=>$input['name'],'banner'=>$banner]);
        if ($update) {
            return redirect(url('admin/sub-category'))->with('success','Category is updated successfully!');
        }else{
            return redirect(url('admin/sub-category'))->with('danger','Oops something went wrong.');
        }
    }

    // child category

 
	public function child_category_list(Request $request){
        $data['child_categories'] = DB::table('child_categories')->paginate(10);
        return view('admin.child_category.list',$data);
    }
	
	

   public function child_category_add(Request $request){
        $data['category'] = DB::table('categories')->get();
        return view('admin.child_category.add',$data);
    }
	
	
	
  public function save_child_category(Request $request){
        $input = $request->all();
        $insert = DB::table('child_categories')->insert([
		'category_id'=>$input['category'],
		'sub_category_id'=>$input['sub_category'],
        'name'=>$input['name']
		  ] );
        if ($insert) {
            return redirect(url('admin/child-category'))->with('success','Child   category is added successfully!');
        }else{
            return redirect(url('admin/child-category'))->with('danger','Oops something went wrong.');
        }
    }

	//edit_child_category
	//update_child_category
	
    public function edit_child_category(Request $request,$id){
        $data['category'] = DB::table('categories')->get();
        $data['sub_category'] = DB::table('sub_categories')->get();
        $data['child_categories'] = DB::table('child_categories')->where('id',$request->id)->first();
        return view('admin.child_category.edit',$data);
    }

    public function update_child_category(Request $request){
        $input = $request->all();
        $update = DB::table('child_categories')->where('id',$request->id)->update([
		'category_id'=>$input['category'],
		'sub_category_id'=>$input['sub_category'],
        'name'=>$input['name']
		  ] );

         if ($update) {
            return redirect(url('admin/child-category'))->with('success','Category is updated successfully!');
        }else{
            return redirect(url('admin/child-category'))->with('danger','Oops something went wrong.');
        }
    }
	
 
 public function ajax_get_child_category(Request $request){
        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'status'=>@$_GET['status']);
        $search = "";

        if ($input['search']){
            $search = "WHERE (a.name LIKE '%".$input['search']."%')";
        }

        if ($input['start']=='') {
            $input['start']=0;
        }

        if ($input['length']=='') {
            $input['length']=10;
        }

        $totalrows = count(DB::select(DB::raw("SELECT a.* FROM child_categories as a $search")));

        $data  = DB::select(DB::raw("SELECT a.*,(SELECT title FROM sub_categories WHERE id=a.sub_category_id) as sub_category,(SELECT name FROM categories WHERE id=a.sub_category_id) as category FROM child_categories as a $search ORDER BY id DESC limit ".$input['start'].",".$input['length'].""));

        $final = [];
        $i=0;
        foreach($data as $row){
            
            $final[] = array(
                            "DT_RowId" => $row->id,
                            $row->name,
                            $row->sub_category,
                            $row->category,
                            '<a href="{{route("attribute",["sub_category",$key->id])}}" class="btn btn-outline-primary btn-sm">Attribute</a>',
                            date('M d, Y',strtotime($row->created_at)),
                            '<div class="btn-group" role="group" aria-label="Basic example">
                            <a href="#"><button  title="View Features"  class="btn btn-outline-primary rounded-pill mb-3"><i class="fa fa-eye"></i> View Features</button></a>
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

    // attribute functions

    public function attribute_list(Request $request,$cat,$id){
        $data['id'] = $id;
        $data['type'] = $cat;
        $attribute = DB::table('attribute')->where([['category_type','=',$cat],['category_id','=',$id]])->get();
        $data['attribute']=array();
        foreach ($attribute as $key) {
            $data['attribute'][] = [
                'category_type'=>$key->category_type,
                'category_id'=>$key->category_id,
                'title'=>$key->title,
                'id'=>$key->id,
                'options'=>DB::table('attribute_options')->where('attribute_id',$key->id)->get()->toarray()
            ];
        }
	  return view('admin.attribute.list',$data);
    }

    public function attribute_add(Request $request,$cat,$id){
        $data['id'] = $id;
        $data['type'] = $cat;
        return view('admin.attribute.add',$data);
    }
	
	public function attribute_edit(Request $request,$id){
         $data['id'] = $id;
         $data['attribute'] = DB::table('attribute')->where('id','=',$id)->get();
         $data['attribute_options'] = DB::table('attribute_options')->where('attribute_id','=',$id)->get()->toarray();
         return view('admin.attribute.edit',$data);
    }


	
	public function attribute_save(Request $request){
         $save_attribute = DB::table('attribute')->insertGetId(['category_id'=>$request->id,'category_type'=>$request->type,'title'=>$request->name]);
        if ($save_attribute) {
            foreach ($request->option as $key) {
                DB::table('attribute_options')->insert(['attribute_id'=>$save_attribute,'title'=>$key]);
            }
            return redirect(url('admin/attribute',[$request->type,$request->id]))->with('success','Attribute updated successfully!');
        }else{
            return redirect(url('admin/attribute',[$request->type,$request->id]))->with('danger','Oops something went wrong.');
        }  
    }
	
 public function  update_attribute(Request $request){
		$attribute_id =  $request->update_id; 
	  if ($attribute_id) {
		    $update = DB::table('attribute')->where('id',$attribute_id)->update(['title'=>$request->name]);
			$delete =  DB::table('attribute_options')->where('attribute_id',$attribute_id)->delete();
            foreach ($request->option as $key) {
                DB::table('attribute_options')->insert(['attribute_id'=>$attribute_id,'title'=>$key]);
            }
            return redirect(url('admin/attribute',[$request->type,$request->id]))->with('success','Attribute is added successfully!');
        }else{
            return redirect(url('admin/attribute',[$request->type,$request->id]))->with('danger','Oops something went wrong.');
        }
    }
	
	 
	 
	  public function delete_attributes(Request $request){
	       $delete =  DB::table('attribute')->where('id',$request->id)->delete();
	       $delete =  DB::table('attribute_options')->where('attribute_id',$request->id)->delete();
		   echo 1;
	  }
	  public function delete_attribute_options(Request $request){
	      //$delete =  DB::table('attribute')->where('id',$request->id)->delete();
	      // $delete =  DB::table('attribute_options')->where('attribute_id',$request->id)->delete();
		 echo 1;
	  }
}
