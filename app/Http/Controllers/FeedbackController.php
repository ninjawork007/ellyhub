<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\feedback;
use Redirect;
use File;

class FeedbackController extends Controller
{
    public function index($type, $orderid){
        $request = Request();
        $data['type'] = $type;
        $data['order_id'] = $orderid;
        $data['order'] = DB::select(DB::raw("SELECT orders.*, users.name FROM orders as orders
            LEFT JOIN users ON users.id = orders.vendorid WHERE 
            orders.userid='".$request->session()->get('userid')."' AND
            orders.id = '$orderid'"));

        return view('feedback', $data);
    }

    public function submitFeedback(Request $request){

        $checkrecord = feedback::where('user_id', $request->session()->get('userid'))->where('order_id', $request->order_id)->first();

        $image = [];
        if(!empty($checkrecord)){
            return Redirect::to('/')->with('danger', 'Your feedback is already submitted!');
        }

        $feedback = new feedback();

        if ($request->hasFile('file')) {

            foreach($request->file('file') as $file) {
                $destinationPath = public_path('uploads/feedbacks');

                if (!File::isDirectory($destinationPath)) {
    
                    File::makeDirectory($destinationPath, 0777, true, true);
    
                }
    
                $extension = $file->getClientOriginalExtension();

                $image_name = time() . '.' . $extension;

                if ($file->move($destinationPath, $image_name)) {

                    $image[] = $image_name;

                }
            }
            if(!empty($decodeImages)){
                $finalImageArr = array_merge($image, $decodeImages);
            }
            else{
                $finalImageArr = $image;
            }
            $feedback->images = json_encode($finalImageArr);
        }

        $feedback->description = $request->description;

        $feedback->type = $request->type;

        $feedback->order_id = $request->order_id;

        $feedback->vendor_id = $request->vendor_id;

        $feedback->product_id = $request->product_id;

        $feedback->user_id = $request->session()->get('userid');

        $feedback->save();

        if($feedback->save()){
            return Redirect::to('/')->with('success', 'Feedback added successfully!');
        }
        else{
            return back()->with('danger', 'Feedback not added successfully!');
        }
    }
}
