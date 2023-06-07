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
use App\Http\Controllers\admin\Input;
use Response;
class ReportController extends Controller{
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
	public function stock_report(){
        $data['vendor'] = DB::table('users')->select('name','id','email')->where('user_type','vendor')->get();
        $data['category']=DB::table('categories')->select('name','id')->get();
        return view('admin.reports.list',$data);
	}

    public function get_sub_category_admin(Request $request){
        $data = DB::table('sub_categories')->where('category_id',$request->categoryid)->get();
        $html='<select class="form-control" id="sub_category_" name="sub_category">';
        $html.='<option value="">select sub-category</option>';       
        if ($data) {
           foreach ($data as $key) {
            $html.='<option value="'.$key->id.'">'.$key->title.'</option>';
           }
        }
        $html.='</select>';
        echo $html;
    }

    public function get_child_category_admin(Request $request){
        $data = DB::table('child_categories')->where([['category_id','=',$request->categoryid],['sub_category_id','=',$request->sub_categoey]])->get();
        $html='<select class="form-control" id="child_category_" name="child_category">';
        $html.='<option value="">select child-category</option>';       
        if ($data) {
           foreach ($data as $key) {
            $html.='<option value="'.$key->id.'">'.$key->name.'</option>';
           }
        }
        $html.='</select>';
        echo $html;
    }

    public function ajax_get_product_reports(Request $request){
        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'status'=>@$_GET['status'],'category'=>@$_GET['category'],'sub_category'=>@$_GET['sub_category'],'child_category'=>@$_GET['child_category'],'vendor'=>@$_GET['vendor']);
        $search = "";
        $where = "";
        if ($input['search']){
            $search = "AND (a.name LIKE '%".$input['search']."%')";
        }

        if ($input['category']) {
            $search.="AND (a.category_id='".$input['category']."')";
        }

        if ($input['sub_category']) {
            $search.="AND (a.sub_category_id='".$input['sub_category']."')";
        }

        if ($input['child_category']) {
            $search.="AND (a.child_category_id='".$input['child_category']."')";
        }

        if ($input['vendor']) {
            $search.="AND (a.vendor_id='".$input['vendor']."')";
        }

        if ($input['start']=='') {
            $input['start']=0;
        }

        if ($input['length']=='') {
            $input['length']=10;
        }

        $totalrows = count(DB::select(DB::raw("SELECT a.* FROM products as a WHERE a.is_delete='0' $search $where")));
        $data  = DB::select(DB::raw("SELECT a.id,a.name,a.stock,a.image,a.mrp_price,a.sale_price,a.discount,a.gst,a.comission,a.discount_type,(SELECT name FROM users WHERE id=a.vendor_id) as vendor_name,(SELECT COUNT(id) FROM orders WHERE productid=a.id) as product_sale_count FROM products as a WHERE a.is_delete='0' $search $where ORDER BY product_sale_count DESC limit ".$input['start'].",".$input['length'].""));
        $final = [];
        $i=0;
        
        foreach($data as $row){

            $variations = DB::table('product_size')->select('quantity')->where([['product_id','=',$row->id]])->get();
            
            $variation_sum=0;
            foreach ($variations as $key) {
                $variation_sum = $variation_sum+$key->quantity;
            }
            if($row->discount){
                $amount = $row->discount;
            }else{
                $amount = 0;
            }

            if ($row->discount_type=='flat') {
                $discount_type = '₹';
            }else{
                $discount_type = '%';
            }
            $discount = $amount.' '.$discount_type;
            $final[] = array(
                            "DT_RowId" => $row->id,
                            '<img src="'.url($row->image).'"  alt= "" class="product_img">'.$row->name,
                            $row->vendor_name,
                            ($row->sale_price==$row->mrp_price)? '₹'.$row->sale_price:'<del>₹'.$row->mrp_price.'</del> ₹'.$row->sale_price,
                            $discount,
                            ($row->gst)?$row->gst:0 .'%',
                            ($row->comission)?$row->comission:0,
                            (!$variations->isEmpty())?$variation_sum:$row->stock,
                            //($row->stock < 0)?0:$row->stock,
                            // $row->product_sale_count,
                            
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

    public function product_stock_report_download(){
        $search='';
        $where='';
        if (isset($_GET['category'])) {
            $search.="AND (a.category_id='".$_GET['category']."')";
        }

        if (isset($_GET['sub_category'])) {
            $search.="AND (a.sub_category_id='".$_GET['sub_category']."')";
        }

        if (isset($_GET['child_category'])) {
            $search.="AND (a.child_category_id='".$_GET['child_category']."')";
        }

        if (isset($_GET['vendor'])) {
            $search.="AND (a.vendor_id='".$_GET['vendor']."')";
        }
        
        $fileName = 'stock-report.csv';
        $tasks  = DB::select(DB::raw("SELECT a.id,a.name,a.stock,a.image,a.mrp_price,a.sale_price,a.discount,a.gst,a.comission,a.discount_type,(SELECT name FROM users WHERE id=a.vendor_id) as vendor_name,(SELECT COUNT(id) FROM orders WHERE productid=a.id) as product_sale_count FROM products as a WHERE a.is_delete='0' $search $where ORDER BY product_sale_count DESC"));
         $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $columns = array('Product Name', 'Vendor Name', 'Price', 'Discount', 'GST', 'Comission', 'Produc Stock');
        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($tasks as $task) {
            $variations = DB::table('product_size')->select('quantity')->where([['product_id','=',$task->id]])->get();

            $variation_sum=0;
            foreach ($variations as $key) {
                $variation_sum = $variation_sum+$key->quantity;
            }

            if($task->discount){
                $amount = $task->discount;
            }else{
                $amount = 0;
            }

            if ($task->discount_type=='flat') {
                $discount_type = 'Rs';
            }else{
                $discount_type = '%';
            }
            $discount = $amount.' '.$discount_type;
                $row['Product Name']  = $task->name;
                $row['Vendor Name']    = $task->vendor_name;
                $row['Price']= $task->mrp_price;
                $row['Discount']  = $discount;
                $row['GST']  = ($task->gst)?$task->gst:0 .'%';
                $row['Comission'] = ($task->comission)?$task->comission:0;
                //$row['Produc Stock'] =  ($task->stock < 0)?0:$task->stock;
                $row['Produc Stock'] = (!$variations->isEmpty())?$variation_sum:$task->stock;

                fputcsv($file, array($row['Product Name'],$row['Vendor Name'],$row['Price'],$row['Discount'],$row['GST'],$row['Comission'],$row['Produc Stock']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function vendor_payment_report(){
    	return view('admin.reports.vendor_payment_list');
    }
    
    public function ajax_get_payments_reports(Request $request){
        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'status'=>@$_GET['status']);
        $search = "";
        $where = "";
        
        if ($input['search']){
            $search = "AND (a.name LIKE '%".$input['search']."%')";
        }

        if ($input['start']=='') {
            $input['start']=0;
        }

        if ($input['length']=='') {
            $input['length']=10;
        }

        $totalrows = count(DB::select(DB::raw("SELECT a.* FROM users as a WHERE a.user_type='vendor' $search $where")));
        $data  = DB::select(DB::raw("SELECT a.id,a.name,a.email,(SELECT SUM(vendor_payment) FROM payments WHERE vendor_id=a.id) as vendor_payment,(SELECT SUM(admin_comission) FROM payments WHERE vendor_id=a.id) as admin_comission FROM users as a WHERE a.user_type='vendor' $search $where ORDER BY vendor_payment DESC limit ".$input['start'].",".$input['length'].""));
        $final = [];
        $i=0;
        foreach($data as $row){
            $final[] = array(
                            "DT_RowId" => $row->id,
                            $row->name,
                            $row->email,
                            number_format(($row->vendor_payment)?$row->vendor_payment:0,2),
                            number_format(($row->admin_comission)?$row->admin_comission:0,2),
                            
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

    public function payment_history(){
        $data['vendor'] = DB::table('users')->select('name','id','email')->where('user_type','vendor')->get();
        return view('admin.reports.payment_history',$data);
    }
    
    public function ajax_get_payments_history(){

        $input = array('search'=>@$_GET['search']['value'],'order'=>@$_GET['order'][0]['column'],'start'=>@$_GET['start'],'length'=>@$_GET['length'],'draw'=>@$_GET['draw'],'vendor'=>@$_GET['vendor'],'start_date'=>@$_GET['start_date'],'end_date'=>@$_GET['end_date']);
        
        $search = "";
        $where = "";
        if ($input['search']){
            $search = "AND (a.name LIKE '%".$input['search']."%')";
        }
        if ($input['start_date']!=='') {
            $search.= "AND (a.payment_date >='".$input['start_date']."')";
        }
        if ($input['end_date']!=='') {
            $search.= "AND (a.payment_date <='".$input['end_date']."')";
        }
        if ($input['vendor']!=='') {
            $search.= "AND (a.vendor_id ='".$input['vendor']."')";
        }
        if ($input['start']=='') {
            $input['start']=0;
        }

        if ($input['length']=='') {
            $input['length']=10;
        }

        $totalrows = count(DB::select(DB::raw("SELECT a.* FROM payments as a WHERE a.status='1' $search $where")));

        $data  = DB::select(DB::raw("SELECT a.*,(SELECT name FROM users WHERE id=a.vendor_id) as vendor_name FROM payments as a WHERE a.status='1' $search $where ORDER BY id DESC limit ".$input['start'].",".$input['length'].""));
        $final = [];
        $i=0;
        foreach($data as $row){
            if(Auth::user()->user_type=='vendor'){
                 $final[] = array(
                            "DT_RowId" => $row->id,
                            $row->vendor_name,
                            $row->from_date,
                            $row->to_date,
                            number_format(($row->admin_comission+$row->vendor_payment),2),
                            number_format($row->vendor_payment,2),
                            date('d F,Y',strtotime($row->payment_date)),
                    ); 
            }else{
              $final[] = array(
                            "DT_RowId" => $row->id,
                            $row->vendor_name,
                            $row->from_date,
                            $row->to_date,
                            number_format(($row->admin_comission+$row->vendor_payment),2),
                            number_format($row->total_collection_fee,2),
                            number_format($row->total_product_comission,2),
                            number_format($row->total_fixed_fee,2),
                            number_format($row->total_gst_on_comission,2),
                            number_format($row->admin_comission,2),
                            number_format($row->vendor_payment,2),
                            date('d F,Y',strtotime($row->payment_date)),
                    );  
            }
            
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

    public function payment_history_download(){
        //dd($_GET);
        $search='';
        $where='';

        if (isset($_GET['vendor'])) {
            $search.="AND (a.vendor_id='".$_GET['vendor']."')";
        }

        if (isset($_GET['start_date'])) {
            $search.="AND (a.payment_date >='".$_GET['start_date']."')";
        }

        if (isset($_GET['end_date'])) {
            $search.="AND (a.payment_date <='".$_GET['end_date']."')";
        }
        $fileName = 'payment-history.csv';
        $handle = fopen($fileName, 'w+');
        $tasks  =DB::select(DB::raw("SELECT a.*,(SELECT name FROM users WHERE id=a.vendor_id) as vendor_name FROM payments as a WHERE a.status='1' $search $where ORDER BY id DESC "));
        fputcsv($handle, array('Vendor Name', 'From date', 'To date', 'Total Sale', 'Total Collection Fees', 'Total Product Comission', 'Fixed Fee','GST On Comission','Total Comission','Total Payment','Payment Date'));

            foreach ($tasks as $task) {
                $row['Vendor Name'] = $task->vendor_name;
                $row['From date'] = $task->from_date;
                $row['To date']= $task->to_date;
                $row['Total Sale']  = ($task->vendor_payment+$task->admin_comission);
                $row['Total Collection Fees']  = $task->total_collection_fee;
                $row['Total Product Comission'] = $task->total_product_comission;
                $row['Fixed Fee'] =  $task->total_fixed_fee;
                $row['GST On Comission'] = $task->total_gst_on_comission;
                $row['Total Comission'] = $task->admin_comission;
                $row['Total Payment']= $task->vendor_payment;
                $row['Payment Date']= $task->created_at;

                fputcsv($handle, array($row['Vendor Name'],$row['From date'],$row['To date'],$row['Total Sale'],$row['Total Collection Fees'],$row['Total Product Comission'],$row['Fixed Fee'],$row['GST On Comission'],$row['Total Comission'],$row['Total Payment'],$row['Payment Date']));
            }
            fclose($handle);
            $headers1 = array(
                'Content-Type' => 'text/csv',
            );

        return Response::download($fileName, 'payment-history.csv', $headers1);
    }
}
