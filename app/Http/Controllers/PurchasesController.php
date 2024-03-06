<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\feedback;
use App\Models\Refund;
use App\Models\ReportVendor;
use Illuminate\Http\Request;
use App\Models\userOrders;
use DB;

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
            $data['orders'] = DB::select(DB::raw("SELECT orders.*, users.name FROM orders as orders
            LEFT JOIN users ON users.id = orders.vendorid WHERE 
            orders.userid='".$request->session()->get('userid')."'"));
        }
        else{
            $data['orders'] = DB::select(DB::raw("SELECT orders.*, users.name FROM orders as orders
            LEFT JOIN users ON users.id = orders.vendorid WHERE 
            orders.userid='".$request->session()->get('userid')."' AND 
            orders.delivery_status= '".$typeFirst."' OR
            orders.delivery_status ='".$typeSecond."'"));
        }

        return view('purchases',$data);
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
}
