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
use Response;
class SaleController extends Controller{
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
	public function my_sale(){
        $data['vendor'] = DB::table('products')->select('id','name')->where('vendor_id',Auth::user()->id)->get();
        return view('admin.sale.list',$data);
	}

    public function ajax_get_sale(Request $request){
        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'productid'=>@$_GET['productid'],'delivery_status'=>@$_GET['delivery_status']);
        $search = "";
        $where = "AND vendorid='".Auth::user()->id."'";
        if ($input['productid']){
            $search.= "AND (productid LIKE '%".$input['productid']."%')";
        }
        if ($input['delivery_status']!=='') {
           $search.= "AND (delivery_status LIKE '%".$input['delivery_status']."%')";
        }

        if ($input['start']=='') {
            $input['start']=0;
        }

        if ($input['length']=='') {
            $input['length']=10;
        }
        $totalrows = count(DB::select(DB::raw("SELECT * FROM orders WHERE order_id!='' $search $where")));
        $data  = DB::select(DB::raw("SELECT * FROM orders WHERE order_id!='' $search $where ORDER BY id DESC limit ".$input['start'].",".$input['length'].""));
        $final = [];
        $i=0;
        foreach($data as $row){
            if (Auth::user()->user_type='vendor') {
                $target = 'vendor_order_detail';
            }else{
                $target = 'order_detail';
            }
        if ($row->delivery_status=='delivered') { $disabled = 'disabled';}else{$disabled = '';}
            // order status
            $order_status='';
            if ($row->order_status=='accept') { $order_status_accept='selected';}else{$order_status_accept='';}
            if ($row->order_status=='reject') { $order_status_reject='selected';}else{$order_status_reject='';}
            if ($row->order_status=='cancelled') { $order_status_cancelled='selected';}else{$order_status_cancelled='';}
            $order_status.='<select '.$disabled.' id="'.$row->id.'" data-key="order_status" class="order_status"><option value="">Select</option><option value="accept" '.$order_status_accept.'>Accept</option><option value="reject" '.$order_status_reject.'>Reject</option><option value="cancelled" '.$order_status_cancelled.'>Cancelled</option></select>';
            // payment status
            $payment_status='';
            if ($row->payment_status=='paid') { $payment_status_paid='selected';}else{$payment_status_paid='';}
            if ($row->payment_status=='pending') { $payment_status_pending='selected';}else{$payment_status_pending='';}
            $payment_status.='<select '.$disabled.' id="'.$row->id.'" data-key="payment_status" class="payment_status"><option value="">Select</option><option value="pending" '.$payment_status_pending.'>Pending</option><option value="paid" '.$payment_status_paid.'>paid</option></select>';
            // delivery status

            $delivery_status='';
            if ($row->delivery_status=='pending') { $delivery_status_pending='selected';}else{$delivery_status_pending='';}
            if ($row->delivery_status=='dispatch') { $delivery_status_dispatch='selected';}else{$delivery_status_dispatch='';}
            if ($row->delivery_status=='delivered') { $delivery_status_delivered='selected';}else{$delivery_status_delivered='';}
            $delivery_status.='<select id="'.$row->id.'" data-key="delivery_status" class="delivery_status" '.$disabled.'><option value="pending" '.$delivery_status_pending.'>Pending</option><option value="dispatch" '.$delivery_status_dispatch.'>Dispatch</option><option value="delivered" '.$delivery_status_delivered.'>Delivered</option></select>';
            $final[] = array(
                            "DT_RowId" => $row->id,
                            '<a href="'.url($target,[base64_encode($row->order_id),$row->vendorid]).'" target="_blank">'.$row->order_id.'</a>',
                            'Name: '.$row->name.'<br> Email: '.$row->email.'<br> Phone: '.$row->phone,
                            $row->product_name,
                            '<img src="'.url(''.$row->image).'"  alt= "'.$row->name.'" class="product_img">',
                            $row->product_price,
                            $row->sale_price,
                            $order_status,
                            $payment_status,
                            $delivery_status,
                            date('M d, Y',strtotime($row->created_at)),
                            '<div class="btn-group" role="group" aria-label="Basic example">
                            <a target="_blank" href="'.url($target,[base64_encode($row->order_id),$row->vendorid]).'" class="btn btn-outline-primary btn-sm"> <i class="fa fa-eye"></i> </a>&nbsp;
							<br><a href="javascript:;" class="delete_row btn btn-outline-danger btn-sm" table="products" id="'.$row->id.'" data-value="1"><i class="fa fa-trash"></i></a>
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

    public function update_order_parameter(Request $request){
        $update = DB::table('orders')->where('id',$request->id)->update([$request->table_key=>$request->value]);
        echo true;
    }

    public function update_order_parameter_admin(Request $request){
        $update = DB::table('orders')->where('order_id',$request->orderid)->update([$request->table_key=>$request->value]);
        echo true;
    }

    //show admin page
    public function sale(){
        $data['vendor'] = DB::table('users')->select('id','name','email')->where('user_type','vendor')->get();
        return view('admin.sale.sale_list',$data);
    }

    public function ajax_sale(Request $request){
        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'vendorid'=>@$_GET['vendorid'],'start_date'=>@$_GET['start_date'],'end_date'=>@$_GET['end_date']);
        $search = "";
        $datesearch="";
        if (Auth::user()->user_type=='vendor') {
           $where = "AND vendorid='".Auth::user()->id."' AND delivery_status='delivered'";
           $show = 'disabled';
        }else{
            $show = '';
            $where = 'AND delivery_status="delivered"';
        }
        
        if ($input['vendorid']){
            $search = "AND (vendorid LIKE '%".$input['vendorid']."%')";
        }
        if ($input['start_date'] !=='') {
            $datesearch.="AND created_at >='".$input['start_date']." 00:00:00'";
        }
        if ($input['end_date'] !=='') {
            $datesearch.="AND created_at <='".$input['end_date']." 23:59:59'";
        }
        if ($input['start']=='') {
            $input['start']=0;
        }

        if ($input['length']=='') {
            $input['length']=10;
        }
        $totalrows = count(DB::select(DB::raw("SELECT * FROM orders WHERE order_id!='' $search $where $datesearch")));
        $data  = DB::select(DB::raw("SELECT * FROM orders WHERE order_id!='' $search $where $datesearch ORDER BY id DESC limit ".$input['start'].",".$input['length'].""));
        $final = [];
        $i=0;
        foreach($data as $row){
            if (Auth::user()->user_type='vendor') {
                $target = 'vendor_order_detail';
            }else{
                $target = 'order_detail';
            }
            // order status
            $order_status='';
            if ($row->order_status=='accept') { $order_status_accept='selected';}else{$order_status_accept='';}
            if ($row->order_status=='reject') { $order_status_reject='selected';}else{$order_status_reject='';}
            if ($row->order_status=='cancelled') { $order_status_cancelled='selected';}else{$order_status_cancelled='';}
            $order_status.='<select '.$show.' id="'.$row->id.'" data-key="order_status" class="order_status"><option value="">Select</option><option value="accept" '.$order_status_accept.'>Accept</option><option value="reject" '.$order_status_reject.'>Reject</option><option value="cancelled" '.$order_status_cancelled.'>Cancelled</option></select>';
            // payment status
            $payment_status='';
            if ($row->payment_status=='paid') { $payment_status_paid='selected';}else{$payment_status_paid='';}
            if ($row->payment_status=='pending') { $payment_status_pending='selected';}else{$payment_status_pending='';}
            $payment_status.='<select '.$show.' id="'.$row->id.'" data-key="payment_status" class="payment_status"><option value="">Select</option><option value="pending" '.$payment_status_pending.'>Pending</option><option value="paid" '.$payment_status_paid.'>paid</option></select>';
            // delivery status

            $delivery_status='';
            if ($row->delivery_status=='pending') { $delivery_status_pending='selected';}else{$delivery_status_pending='';}
            if ($row->delivery_status=='dispatch') { $delivery_status_dispatch='selected';}else{$delivery_status_dispatch='';}
            if ($row->delivery_status=='delivered') { $delivery_status_delivered='selected';}else{$delivery_status_delivered='';}
            $delivery_status.='<select '.$show.' id="'.$row->id.'" data-key="delivery_status" class="delivery_status"><option value="pending" '.$delivery_status_pending.'>Pending</option><option value="dispatch" '.$delivery_status_dispatch.'>Dispatch</option><option value="delivered" '.$delivery_status_delivered.'>Delivered</option></select>';
            $final[] = array(
                            "DT_RowId" => $row->id,
                            '<a href="'.url($target,[base64_encode($row->order_id),$row->vendorid]).'" target="_blank">'.$row->order_id.'</a>',
                            'Name: '.$row->name.'<br> Email: '.$row->email.'<br> Phone: '.$row->phone,
                            $row->product_name,
                            '<img src="'.url($row->image).'"  alt= "'.$row->name.'" class="product_img">',
                            $row->product_price,
                            $row->sale_price,
                            $order_status,
                            $payment_status,
                            $delivery_status,
                            date('M d, Y',strtotime($row->created_at)),
                            '<div class="btn-group" role="group" aria-label="Basic example">
                            <a target="_blank" href="'.url($target,[base64_encode($row->order_id),$row->vendorid]).'" class="btn btn-outline-primary btn-sm"> <i class="fa fa-eye"></i> </a>&nbsp;
                            <br><a href="javascript:;" class="delete_row btn btn-outline-danger btn-sm" table="products" id="'.$row->id.'" data-value="1"><i class="fa fa-trash"></i></a>
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

    public function sale_report(){
        $data['vendor'] = DB::table('users')->select('id','name','email')->where([['user_type','=','vendor']])->get();
        return view('admin.sale.sale_report',$data);
    }

    public function ajax_sale_report(Request $request){
        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'vendorid'=>@$_GET['vendorid'],'start_date'=>@$_GET['start_date'],'end_date'=>@$_GET['end_date']);

        $search = "";
        $date_filter='';
        if ($input['vendorid']){
            $search = "AND (a.vendorid ='".$input['vendorid']."')";
        }
        if ($input['start_date']!=='') {
            $date_filter.="AND a.created_at >='".$input['start_date']." 00:00:00'";
        }

        if ($input['end_date']!=='') {
            $date_filter.="AND a.created_at <='".$input['end_date']." 23:59:59'";
        }
        if ($input['start']=='') {
            $input['start']=0;
        }

        if ($input['length']=='') {
            $input['length']=10;
        }
        
        $totalrows = count(DB::select(DB::raw("SELECT a.* FROM orders as a WHERE a.delivery_status='delivered' $search $date_filter")));
        $data  = DB::select(DB::raw("SELECT a.*,(SELECT name FROM users WHERE id=a.vendorid) as vendorname,(SELECT gst_amount FROM products WHERE id=a.productid) as product_gst,(SELECT gst FROM products WHERE id=a.productid) as gst,(SELECT comission FROM products WHERE id=a.productid) as comission,(SELECT shipping_charges FROM products WHERE id=a.productid) as shipping_charges FROM orders as a WHERE a.delivery_status='delivered' $search $date_filter ORDER BY id DESC limit ".$input['start'].",".$input['length'].""));
        
        $final = [];
        $i=0;
        //dd($data);
        foreach($data as $row){
            
            //$gst_for_price = ($row->gst/100)*$row->sale_price;
            $gst_exclude_price = ($row->sale_price*(100/(100+$row->gst)));
            $gst_for_price = $row->sale_price-$gst_exclude_price;
            $fixedfeee = $row->sale_price*$row->product_quantity;
            if ($fixedfeee < 500) {
                    $fixedfee=1;
                }else if($fixedfeee >= 500 && $fixedfeee <= 2999){
                    $fixedfee=5;
                }else if($fixedfeee >= 3000){
                    $fixedfee=15;
                }
                if ($row->comission) {
                    $comission = ($row->comission / 100)*$gst_exclude_price;
                }else{
                   $comission=0; 
                }
                $collection_fee = (2.35/100)*$row->sale_price;
                $total_comission = $comission*$row->product_quantity;
                $gst_marrkitplace = (18/100)*(($collection_fee*$row->product_quantity)+$total_comission+$fixedfee);
                $admin_comission = ($gst_marrkitplace+$total_comission+($collection_fee*$row->product_quantity)+$fixedfee);
            $final[] = array(
                            "DT_RowId" => $row->id,
                            $row->vendorname,
                            date('Y F, d',strtotime($row->created_at)),
                            '<a href="'.url('order_detail',[base64_encode($row->order_id)]).'" target="_blank">'.$row->order_id.'</a>',
                            $row->product_name,
                            $row->product_quantity,
                            number_format(($row->sale_price-$gst_for_price)*$row->product_quantity,2),
                            number_format($gst_for_price,2),
                            number_format($row->shipping_charges,2),
                            number_format(($row->sale_price)*$row->product_quantity,2),
                            number_format($total_comission,2),
                            number_format($collection_fee,2)*$row->product_quantity,
                            number_format($fixedfee,2),
                            number_format($gst_marrkitplace,2),
                            number_format($admin_comission,2),
                            number_format(($row->sale_price*$row->product_quantity)-$admin_comission,2),
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

    public function sale_report_download(){
        $date_filter='';
        $search='';
        if (isset($_GET['vendorid']) && $_GET['vendorid']!=='undefined'){
            $search = "AND (a.vendorid ='".$_GET['vendorid']."')";
        }else{
            $search = '';
        }
        if (isset($_GET['start_date']) && $_GET['start_date']!=='') {
            $date_filter.="AND a.created_at >='".$_GET['start_date']." 00:00:00'";
        }

        if (isset($_GET['end_date']) && $_GET['end_date']!=='') {
            $date_filter.="AND a.created_at <='".$_GET['end_date']." 23:59:59'";
        }

        $data  = DB::select(DB::raw("SELECT a.*,(SELECT name FROM users WHERE id=a.vendorid) as vendorname,(SELECT gst_amount FROM products WHERE id=a.productid) as product_gst,(SELECT gst FROM products WHERE id=a.productid) as gst,(SELECT comission FROM products WHERE id=a.productid) as comission,(SELECT shipping_charges FROM products WHERE id=a.productid) as shipping_charges FROM orders as a WHERE a.delivery_status='delivered' $search $date_filter ORDER BY id DESC"));
        $fileName = 'sale-report.csv';
        $handle = fopen($fileName, 'w+');
        fputcsv($handle, array('Vendor Name', 'Order Date', 'Order No','Product','Quantity','Taxable Amount','GST','Shipping Charge','Total Sale Value','Comission Fee','Collection Fee','Fixed Fee','GST (Markitplace)','Total Comission Amount','Vendor Payable Amount'));
        $final = [];
        $i=0;

        foreach ($data as $row) {
            $gst_exclude_price = ($row->sale_price*(100/(100+$row->gst)));
            $gst_for_price = $row->sale_price-$gst_exclude_price;
            $fixedfeee = $row->sale_price*$row->product_quantity;
            if ($fixedfeee < 500) {
                    $fixedfee=1;
                }else if($fixedfeee >= 500 && $fixedfeee <= 2999){
                    $fixedfee=5;
                }else if($fixedfeee >= 3000){
                    $fixedfee=15;
                }
                if ($row->comission) {
                    $comission = ($row->comission / 100)*$gst_exclude_price;
                }else{
                   $comission=0; 
                }
                $collection_fee = (2.35/100)*$row->sale_price;
                $total_comission = $comission*$row->product_quantity;
                $gst_marrkitplace = (18/100)*(($collection_fee*$row->product_quantity)+$total_comission+$fixedfee);
                $admin_comission = ($gst_marrkitplace+$total_comission+($collection_fee*$row->product_quantity)+$fixedfee);

                $arr['Vendor Name'] = $row->vendorname;
                $arr['Order Date'] =   date('Y F, d',strtotime($row->created_at));
                $arr['Order No'] = $row->order_id;
                $arr['Product'] = $row->product_name;
                $arr['Quantity'] = $row->product_quantity;
                $arr['Taxable Amount'] = number_format(($row->sale_price-$gst_for_price)*$row->product_quantity,2);
                $arr['GST'] = number_format($gst_for_price,2);
                $arr['Shipping Charge'] = number_format($row->shipping_charges,2);
                $arr['Total Sale Value'] = number_format(($row->sale_price)*$row->product_quantity,2);
                $arr['Comission Fee'] = number_format($total_comission,2);
                $arr['Collection Fee'] = number_format($collection_fee,2)*$row->product_quantity;
                $arr['Fixed Fee'] = number_format($fixedfee,2);
                $arr['GST (Markitplace)'] = number_format($gst_marrkitplace,2);
                $arr['Total Comission Amount'] = number_format($admin_comission,2);
                $arr['Vendor Payable Amount'] = number_format(($row->sale_price*$row->product_quantity)-$admin_comission,2);
                fputcsv($handle, array($arr['Vendor Name'],$arr['Order Date'],$arr['Order No'],$arr['Product'],$arr['Quantity'],$arr['Taxable Amount'],$arr['GST'],$arr['Shipping Charge'],$arr['Total Sale Value'],$arr['Comission Fee'],$arr['Collection Fee'],$arr['Fixed Fee'],$arr['GST (Markitplace)'],$arr['Total Comission Amount'],$arr['Vendor Payable Amount']));
        }
        fclose($handle);
        $headers1 = array(
            'Content-Type' => 'text/csv',
        );
        return Response::download($fileName, 'sale-report.csv', $headers1);
    }
}
