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
class OrderController extends Controller{
    use AuthenticatesUsers;
    public function __construct() {
            // $this->middleware('auth');
            // $this->middleware(function ($request, $next) {
            //     if (!Auth::user()) {
            //        return redirect()->route('admin_logout'); 
            //     }
            //     return $next($request);
            // });
    }
	//show admin page

	public function orders(){

	   return view('admin.orders.list');

	 }

	 

    public function ajax_get_orders(Request $request){

        $input = array('search'=>@$_GET['search_'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'start_date'=>@$_GET['start_date'],'end_date'=>@$_GET['end_date']);

        $search = "";

        $where = "";

        if ($input['search']){

            $search.= "AND (order_id LIKE '%".$input['search']."%')";

        }

        if ($input['start_date']!==''){

            $search.= "AND (created_at >='".$input['start_date']." 00:00:00')";

        }

        if ($input['end_date']!==''){

            $search.= "AND (created_at <='".$input['end_date']." 23:59:59')";

        }

        if ($input['start']=='') {

            $input['start']=0;

        }



        if ($input['length']=='') {

            $input['length']=10;

        }

        

        $totalrows = count(DB::select(DB::raw("SELECT * FROM orders WHERE order_id!='' $search $where GROUP BY order_id")));

        $data  = DB::select(DB::raw("SELECT * FROM orders WHERE order_id!='' $search $where GROUP BY order_id ORDER BY id DESC limit ".$input['start'].",".$input['length'].""));



        $final = [];

        $i=0;

        foreach($data as $row){

        	$delivery='';

        	$delivery.='<select class="form-control delivery_type"  name="delivery_type" ><option> Select Delivery Type</option>';

        	if ($row->delivery_by=='self') {

        	$delivery.='<option value="self" data-id="'.$row->id.'" selected> Self Delivery</option>';

        	}else{

        	$delivery.='<option value="self" data-id="'.$row->id.'"> Self Delivery</option>';

        	}



        	if ($row->delivery_by=='shipstation') {

        		$delivery.='<option value="shipstation" data-id="'.$row->id.'" selected> Shipstation </option>';

        	}else{

        		$delivery.='<option value="shipstation" data-id="'.$row->id.'"> Shipstation </option>';

        	}

        	$delivery.='</select>';



        	// payment status

            $payment_status='';

            if ($row->payment_status=='paid') { $payment_status_paid='selected';}else{$payment_status_paid='';}

            if ($row->payment_status=='pending') { $payment_status_pending='selected';}else{$payment_status_pending='';}

            $payment_status.='<select id="'.$row->order_id.'" data-key="payment_status" class="payment_status"><option value="">Select</option><option value="pending" '.$payment_status_pending.'>Pending</option><option value="paid" '.$payment_status_paid.'>paid</option></select>';



            // delivery status



            $delivery_status='';

            if ($row->delivery_status=='pending') { $delivery_status_pending='selected';}else{$delivery_status_pending='';}

            if ($row->delivery_status=='dispatch') { $delivery_status_dispatch='selected';}else{$delivery_status_dispatch='';}

            if ($row->delivery_status=='delivered') { $delivery_status_delivered='selected';}else{$delivery_status_delivered='';}

            $delivery_status.='<select id="'.$row->order_id.'" data-key="delivery_status" class="delivery_status"><option value="pending" '.$delivery_status_pending.'>Pending</option><option value="dispatch" '.$delivery_status_dispatch.'>Dispatch</option><option value="delivered" '.$delivery_status_delivered.'>Delivered</option></select>';

            $final[] = array(

                            "DT_RowId" => $row->order_id,

                            '<a href="'.url('order_detail',[base64_encode($row->order_id)]).'" target="_blank">'.$row->order_id.'</a>',

                            'Name: '.$row->name.'<br> Email: '.$row->email.'<br> Phone: '.$row->phone,

                            '₹'.$row->order_total,

                            '₹'.$row->after_discount_paid_by_customer,

							$delivery,

                            $row->payment_method,

                            // $row->payment_status,

                            $payment_status,

                            $delivery_status,

                            

                            date('M d, Y',strtotime($row->created_at)),

                            '<div class="btn-group" role="group" aria-label="Basic example">

                            <a target="_blank" href="'.url('order_detail',[base64_encode($row->order_id)]).'" class="btn btn-outline-primary btn-sm"> <i class="fa fa-eye"></i> </a>&nbsp;

							<br><a href="javascript:;" class="delete_row btn btn-outline-danger btn-sm" table="orders" id="'.$row->order_id.'"><i class="fa fa-trash"></i></a>

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

	

	

	 public function update_delivery_type(Request $request){
		$id = $request->id;
		$order  = DB::table('orders')->Where('id',$id)->first();
		if($request->value == 'self'){
            DB::table('orders')->where('id',$request->id)->update(['delivery_by'=>$request->value]);
		          echo 1;exit;
		 }
	 }



	 public function delete_order(Request $request){

	 	DB::table($request->table)->where('order_id',$request->id)->delete();

	 	echo true;

	 }

	 public function check_price_shipstation(Request $request){
	 	$order_detail = DB::table('orders')->where('id',$request->orderid)->first();
	 	// dd($order_detail);
	 	$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://ssapi.shipstation.com/shipments/getrates',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
		  "carrierCode": "fedex",
		  "serviceCode": "fedex_ground",
		  "packageCode": null,
		  "fromPostalCode": "78703",
		  "toState": "California",
		  "toCountry": "US",
		  "toPostalCode": "90277",
		  "toCity": "Washington",
		  "weight": {
		    "value": '.$request->weight.',
		    "units": "ounces"
		  },
		  "dimensions": {
		    "units": "inches",
		    "length": '.$request->length.',
		    "width": '.$request->width.',
		    "height": '.$request->height.'
		  },
		  "confirmation": "delivery",
		  "residential": false
		}',
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic OTNlZTNiMGMxMTVhNDEzYThjODBhN2QxYzQ4NmZmMzA6ZTJkYjkxNTk1OWEwNGRjMDhkZTkzNTUyNzg0YWY2Yjc='
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo json_encode(['status'=>true,'data'=>json_decode($response)]);
	 }

	 public function ajax_send_to_shipstation(Request $request){
	 	$order = DB::table('orders')->where('id',$request->orderid)->first();
	 	$vendor = DB::table('users')->where('id',$order->vendorid)->first();
	 	$vendor_info = DB::table('user_info')->where('userid',$vendor->id)->first();
	 	$vendor_address_array = json_decode($vendor_info->address_json);
	 	$address_array = json_decode($order->address_json);
	 	$order_id = $order->order_id;
	 	$reciever_email = $order->email;
	 	// dd($vendor->name);
	 	$curl = curl_init();
	 	curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://ssapi.shipstation.com/shipments/createlabel',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
		  "carrierCode": "fedex",
		  "serviceCode": "fedex_ground",
		  "packageCode": "package",
		  "confirmation": "delivery",
		  "shipDate": "'.date('Y-m-d').'",
		  "weight": {
		    "value": '.$request->weight.',
		    "units": "ounces"
		  },
		  "dimensions": {
		    "units": "inches",
		    "length": '.$request->length.',
		    "width": '.$request->width.',
		    "height": '.$request->height.'
		  },
		  "shipFrom": {
		    "name": "'.$vendor->name.'",
		    "company": "'.$vendor->name.'",
		    "street1": "'.$vendor_info->complete_address.'",
		    "city": "'.$vendor_address_array->city.'",
		    "state": "'.$vendor_address_array->state_short.'",
		    "postalCode": "'.$vendor_address_array->zipcode.'",
		    "country": "'.$vendor_address_array->country_short.'",
		    "phone": "'.str_replace('+','',$vendor->mobile).'",
		    "residential": false
		  },
		  "shipTo": {
		    "name": "'.$order->name.'",
		    "company": "",
		    "street1": "'.$order->street_address.'",
		    "city": "'.$order->city.'",
		    "state": "'.$address_array->state.'",
		    "postalCode": "'.$order->zip.'",
		    "country": "'.$address_array->country_short.'",
		    "phone": "'.str_replace('+','',$order->phone).'",
		    "residential": false
		  },
		  "insuranceOptions": null,
		  "internationalOptions": null,
		  "advancedOptions": null,
		  "testLabel": false
		}',
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic OTNlZTNiMGMxMTVhNDEzYThjODBhN2QxYzQ4NmZmMzA6ZTJkYjkxNTk1OWEwNGRjMDhkZTkzNTUyNzg0YWY2Yjc='
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		if ($response) {
			DB::table('orders')->where('order_id',$order_id)->update(['delivery_by'=>'shipstation','tracking_id'=>json_decode($response)->trackingNumber]);
			echo json_encode(['status'=>true,'data'=>json_decode($response)]);
		}
	 }

}

