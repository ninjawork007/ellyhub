<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\feedback;
use App\Models\Refund;
use App\Models\ReportVendor;
use App\Models\returnItems;
use Illuminate\Http\Request;
use App\Models\userOrders;
use DB;
use Illuminate\Support\Facades\File;

class PurchasesController extends Controller
{
    public $commonController;
    public function __construct()
    {
        $this->commonController = new CommonController();
    }

    public function index($type = ''){
        $typeFinal = $type;
        if($type == 'return_canceled'){
            $typeFinal = explode('_', $type);
        }

        $typeFirst = '';
        $typeSecond = '';
        if(is_array($typeFinal)){
            $typeFirst = $typeFinal[0];
            $typeSecond = $typeFinal[1];
        }
        $typeFirst = (!empty($typeFirst)) ? $typeFirst : $typeFinal;
        $typeSecond = (!empty($typeSecond)) ? $typeSecond : $typeFinal;
        $request = Request();

        if(empty($typeFinal)){
            $paginationData = DB::table('orders')
            ->select('orders.*', 'users.name')
            ->leftJoin('users', 'users.id', '=', 'orders.vendorid')
            ->where('orders.userid', $request->session()->get('userid'));
            /*$paginationData = DB::select(DB::raw("SELECT orders.*, users.name FROM orders as orders
            LEFT JOIN users ON users.id = orders.vendorid WHERE
            orders.userid='".$request->session()->get('userid')."'"));*/
        }
        else{
            $paginationData = DB::table('orders')
                ->select('orders.*', 'users.name')
                ->leftJoin('users', 'users.id', '=', 'orders.vendorid')
                ->where('orders.userid', $request->session()->get('userid'))
                ->where('orders.delivery_status', $typeFirst)
                ->where('orders.delivery_status', $typeSecond);
            /*$paginationData = DB::select(DB::raw("SELECT orders.*, users.name FROM orders as orders
            LEFT JOIN users ON users.id = orders.vendorid WHERE 
            orders.userid='".$request->session()->get('userid')."' AND 
            orders.delivery_status= '".$typeFirst."' OR
            orders.delivery_status ='".$typeSecond."'"))->paginate();*/
        }

        if(isset($request->search_orders)){
            $paginationData->where('orders.product_name', 'LIKE', '%'.$request->search_orders.'%');
            $paginationData->orWhere('users.name', 'LIKE', '%'.$request->search_orders.'%');
        }

        $data['orders'] = $paginationData->paginate(10);

        return view('purchases',$data)->withInput($request->all());
    }

    public function refunds(Request $request){

        $refund = new Refund();

        $refundval = $request->refund_price;
        if(empty($refundval)){
            $refundval = $request->refund_percentage;
        }
        if(empty($refundval)){
            $refundval = $request->refund;
        }

        if(empty($refundval)){
            return ['type' => 'error', 'message' => 'Please fill up values or click on full refund button.'];
        }

        $refund->user_id = $request->session()->get('userid');

        $refund->order_id = $request->order_id;

        $refund->vendor_id = $request->vendor_id;

        $refund->product_id = $request->product_id;

        $refund->refund_value = $refundval;

        $checkrecord = userOrders::where('userid', $request->session()->get('userid'))->where('id', $request->order_id)->where('productid', $request->product_id)->first();

        $data = [
            'type' => 'refund',
            'notification' => 'Refund request from order id: '.$checkrecord->order_id,
            'notification_title' => 'Refund request',
            'vendorid' => $request->vendor_id,
            'userid' => $request->session()->get('userid'),
            'created_at' => date('c')
        ];
        $this->commonController->notificationsInsert($data);

        if($refund->save()){
            return ['type' => 'success', 'message' => 'Your request has been submitted to the seller.'];
        }
        else{
            return ['type' => 'error', 'message' => 'Opps! something went wrong! Please try again later'];
        }
    }

    public function reportVendor(Request $request){
        $report_vendor = new ReportVendor();

        $report_vendor->report_type = implode(',',$request->policies);

        $report_vendor->description = $request->report_description;

        $report_vendor->user_id = $request->session()->get('userid');

        $report_vendor->vendor_id = $request->vendor_id;

        $report_vendor->order_id = $request->order_id;

        if($report_vendor->save()){
            return ['type' => 'success', 'message' => 'Your request has been submitted to the Ellyhub\'s violation management'];
        }
        else{
            return ['type' => 'error', 'message' => 'Opps! something went wrong! Please try again later'];
        }
    }

    public function orderDetails($order_id, $productid){
        $orderid = base64_decode($order_id);
        $productid = base64_decode($productid);
        $data['orders'] = DB::select(DB::raw("SELECT a.*,(SELECT name FROM users WHERE id=a.vendorid) as vendor_name,(SELECT mobile FROM users WHERE id=a.vendorid) as vendoe_contact FROM orders as a WHERE a.order_id='".$orderid."' AND a.productid='".$productid."'"));
        $data['count'] = count(DB::select(DB::raw("SELECT id FROM orders WHERE order_id='".$orderid."' AND productid='".$productid."'")));
        $data['delivery'] = DB::select(DB::raw("SELECT * FROM `delivery_fee_slab` WHERE price_from <= '".$data['orders'][0]->order_total."' AND price_to >= '".$data['orders'][0]->order_total."'"))[0]->delivery_fee;
        $data['setting'] = DB::select(DB::raw("SELECT * FROM `settings` WHERE id = '1'"));

        return view('order_details_v2', $data);
    }

    public function returnItems(Request $request){

        if(!empty($request->details_decription) || !empty($request->percentage) || !empty($request->quantity)){
            $returns = new Refund();

            $checkrecord = Refund::where('order_id', $request->order_id)->where('vendor_id', $request->vendor_id)->where('product_id', $request->product_id)->first();

            if(!empty($checkrecord)){
                return back()->with('danger', 'You already sent refund request for this item');
            }

            $returns->user_id = $request->session()->get('userid');

            $returns->vendor_id = $request->vendor_id;

            $returns->order_id = $request->order_id;

            $returns->product_id = $request->product_id;

            $returns->return_type = $request->return_type;

            $returns->quantity = $request->quantity;

            $returns->refund_percentage = $request->percentage;

            $returns->details = $request->details_decription;

            if ($request->hasFile('refund_images')) {

                foreach ($request->file('refund_images') as $file) {

                    $destinationPath = public_path('uploads/refunds');

                    if (!File::isDirectory($destinationPath)) {

                        File::makeDirectory($destinationPath, 0777, true, true);

                    }

                    $extension = $file->getClientOriginalExtension();

                    $image_name = time() . '.' . $extension;

                    if ($file->move($destinationPath, $image_name)) {

                        $image[] = $image_name;

                    }
                }
                if (!empty($decodeImages)) {
                    $finalImageArr = array_merge($image, $decodeImages);
                } else {
                    $finalImageArr = $image;
                }
                $returns->images = json_encode($finalImageArr);
            }

            $data = [
                'type' => 'refund',
                'notification' => 'Refund request from order id: '.$request->order_id,
                'notification_title' => 'Refund request',
                'vendorid' => $request->vendor_id,
                'userid' => $request->session()->get('userid'),
                'created_at' => date('c')
            ];
            $this->commonController->notificationsInsert($data);

            if($returns->save()){
                return back()->with('success', 'Refund request sent successfully!');
            }
            else{
                return back()->with('danger', 'Refund request can\'t sent try again later!');
            }
        }

        if(!empty($request->return_quantity)){
            $returns = new returnItems();

            $checkrecord = returnItems::where('order_id', $request->order_id)->where('vendor_id', $request->vendor_id)->where('product_id', $request->product_id)->first();

            if(!empty($checkrecord)){
                return back()->with('danger', 'You already sent return request for this item');
            }

            $returns->user_id = $request->session()->get('userid');

            $returns->vendor_id = $request->vendor_id;

            $returns->order_id = $request->order_id;

            $returns->product_id = $request->product_id;

            $returns->return_type = $request->return_type;

            $returns->quantity = $request->return_quantity;

            $returns->details = $request->return_details_decription;

            if ($request->hasFile('return_images')) {

                foreach ($request->file('return_images') as $file) {

                    $destinationPath = public_path('uploads/returns');

                    if (!File::isDirectory($destinationPath)) {

                        File::makeDirectory($destinationPath, 0777, true, true);

                    }

                    $extension = $file->getClientOriginalExtension();

                    $image_name = time() . '.' . $extension;

                    if ($file->move($destinationPath, $image_name)) {

                        $image[] = $image_name;

                    }
                }
                if (!empty($decodeImages)) {
                    $finalImageArr = array_merge($image, $decodeImages);
                } else {
                    $finalImageArr = $image;
                }
                $returns->images = json_encode($finalImageArr);
            }

            $data = [
                'type' => 'return',
                'notification' => 'Return request from order id: '.$request->order_id,
                'notification_title' => 'Retun request',
                'vendorid' => $request->vendor_id,
                'userid' => $request->session()->get('userid'),
                'created_at' => date('c')
            ];
            $this->commonController->notificationsInsert($data);

            if($returns->save()){
                return back()->with('success', 'Return request sent successfully!');
            }
            else{
                return back()->with('danger', 'Return request can\'t sent try again later!');
            }
        }

        return back()->with('danger', 'Please fill up fields to continue!');
    }
}
