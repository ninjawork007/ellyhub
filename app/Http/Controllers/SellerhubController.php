<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\chat;
use App\Models\Product;
use App\Models\returnItems;
use App\Models\userOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Str;

class SellerhubController extends Controller
{
    public function index(){

        $request = Request();
        $current_name = 'Seller Dashboard';

        $unread_messages = chat::where('vendor_id', Auth::user()->id)->where('is_read', 0)->groupBy('order_id', 'product_id')->get()->count();

        $strtotime = '-31 days';
        $days = date('Y-m-d', strtotime($strtotime));

        $userOrders = userOrders::where('vendorid', Auth::user()->id)->where('created_at', '>=', $days)->groupBy('order_id')->get()->sum('after_discount_paid_by_customer');

        $todaysOrders = userOrders::where('vendorid', Auth::user()->id)->where('created_at', 'LIKE', '%'.date('Y-m-d', strtotime('now')).'%')->groupBy('order_id')->get()->sum('after_discount_paid_by_customer');

        $returns = returnItems::where('vendor_id', Auth::user()->id)->groupBy('order_id')->get()->count();

        $categoryList = Category::where('isactive', 'active')->where('name','!=', '')->get();

        foreach($categoryList as $categories){
            $productsList = Product::where('status', 'approved')->where('category_id', $categories->id)->get()->count();
            $totalProducts[$categories->id] = $productsList;
        }

        arsort($totalProducts);

        $categoryCount = Category::select('categories.*', 'products.id as product_id')
            ->leftJoin('products', 'products.category_id', '=', 'categories.id')
            ->leftJoin('returns', 'returns.product_id','=','products.id')
            ->where('categories.isactive', 'active')->where('categories.name','!=', '')
            ->where('returns.vendor_id', $request->session()->get('userid'))
            ->get()->toArray();

        return view('seller.dashboard', compact('categoryCount', 'totalProducts', 'categoryList', 'returns', 'current_name', 'unread_messages', 'userOrders', 'strtotime', 'todaysOrders'));
    }

    public static function otherCategories($notInCategories = []){
        $request = Request();

        $categoryList = Category::where('isactive', 'active')->whereNotIn('id',$notInCategories)->where('name','!=', '')->get();

        foreach($categoryList as $categories){
            $productsList = Product::where('status', 'approved')->where('category_id', $categories->id)->get()->count();
            $totalProducts[$categories->id] = $productsList;
        }

        arsort($totalProducts);

        $countProducts = 0;
        foreach($totalProducts as $product){
            $countProducts += $product;
        }

        $categoryCount = Product::select('products.*')
            ->leftJoin('returns', 'returns.product_id','=','products.id')
            ->where('returns.vendor_id', $request->session()->get('userid'))
            ->whereNotIn('products.category_id',$notInCategories)
            ->get()->count();

        return $categoryCount.' of '.number_format($countProducts);
    }

    public function ordersGet(){
        $current_name = 'Orders';

        $request = Request();

        $orders = userOrders::select('orders.*', 'products.sku')->where('vendorid', $request->session()->get('userid'))->leftJoin('products', 'products.id', '=', 'orders.productid')->get();

        return view('seller.orders', compact('current_name', 'orders'));
    }

    public function findOrders(){

        $request = Request();

        $orders = userOrders::select('orders.*', 'products.sku')->where('vendorid', $request->session()->get('userid'))->leftJoin('products', 'products.id', '=', 'orders.productid')->get();

        $ordersList = [];
        foreach($orders as $order){
            $ordersList[$order['order_id']][] = $order;
        }

        $dataEnter = [
            "draw" => 1,
            "recordsTotal" => count($orders),
            "recordsFiltered" => count($orders),
        ];

        if(count($ordersList) != 0){
            foreach($ordersList as $productsList){
                $productsImages = [];
                $productTitle = [];
                $quantity = 0;
                foreach($productsList as $formdata){
                    if(strpos($formdata['image'], 'http') !== false){
                        $explode = explode(',', $formdata['image']);
                        $url = $explode[0];
                    }
                    else{
                        $url = url('public/'.$formdata['image']);
                    }

                    $increase = (count($productTitle) + 1);
                    $sku = (!empty($formdata['sku'])) ? ' <b class="text-black">('.$formdata['sku'].')</b>' : '';
                    array_push($productTitle, $increase.'. '.Str::limit($formdata['product_name'], 30, '').$sku.'<br>');

                    array_push($productsImages, '<img src="'.$url.'" style="height:100px">');

                    $quantity += $formdata['product_quantity'];

                    $name = $formdata['delivery_status'];
                    if($formdata['delivery_status'] == 'dispatch'){
                        $color = '#E3E6ED';
                        $font_color = '#000';
                    }
                    if($formdata['delivery_status'] == 'delivered'){
                        $color = '#FFEFCA';
                        $font_color = '#D27011';
                    }
                    if($formdata['delivery_status'] == 'pending'){
                        $color = 'transparent';
                        $font_color = '#000';

                        if(!empty($formdata['tracking_id'])){
                            $name = 'READY TO SHIP';
                            $color = '#E3E6ED';
                            $font_color = '#000';
                        }

                    }
                    $lables = '<div style="font-size:13px;padding:5px 10px;width:fit-content;background-color:'.$color.';color:'.$font_color.'" class="mx-auto text-center alert border text-uppercase">'.$name.'</div>
                    <p style="font-size:13px;color:#5c5c5c;" class="text-center">Ship by '.date('M d \a\t H:ia', $formdata['dispatch_date']).' PDT'.'</p>';

                    $orderData = [
                        '<p class="text-blue">#'.$formdata['id'].'</p>',
                        $lables,
                        '<div class="d-flex">'.implode(' ', $productsImages).'</div>',
                        implode(' ', $productTitle),
                        $formdata['userid'],
                        $quantity,
                        '$'.number_format($formdata['after_discount_paid_by_customer'], 2),
                        '<div class="position-relative"><a href="#" class="alert dotted-lines" data-id="">...</a>
                            <div class="dotted-open border p-3 position-absolute" style="">
                                <ul>
                                    <li><a href="'.url('seller/orders/order_details/'.base64_encode($formdata['order_id'])).'">View</a></li>
                                    <li><a href="#">Add Tracking number</a></li>
                                    <li><a href="#">Mark shipped</a></li>
                                    <li><a href="#" class="text-orange">Cancel</a></li>
                                    <li><a href="#">Relist</a></li>
                                    <li><a href="#">Sell Similar</a></li>
                                    <li><a href="#">Contact Buyer</a></li>
                                    <li><a href="#" class="text-danger open-modal" data-items="'.count($productsList).'" data-userid="'.$formdata['userid'].'" data-title="'.strip_tags(implode(' ', $productTitle)).'" data-id="#reportBuyer">Report Buyer</a></li>
                                    <li><a href="#">Refund</a></li>
                                    <li><a href="#" class="text-orange">Archive</a></li>
                                </ul>
                            </div>
                        </div>',
                    ];

                    $datas = $orderData;
                }

                $dataEnter['data'][] = $datas;
            }
        }
        else{
            $dataEnter['data'] = [];
        }
        return json_encode($dataEnter);
    }

    public function orderDetails($order_id){

        $data['current_name'] = 'Order details';

        $orderid = base64_decode($order_id);
        $data['orders'] = DB::select(DB::raw("SELECT a.*,(SELECT name FROM users WHERE id=a.vendorid) as vendor_name, products.sku, users.name as user_name FROM orders as a LEFT JOIN products ON a.productid = products.id LEFT JOIN users ON a.userid = users.id WHERE a.order_id='".$orderid."' AND vendorid = ".Auth::user()->id.""));
        $data['count'] = count(DB::select(DB::raw("SELECT id FROM orders WHERE order_id='".$orderid."' AND vendorid = ".Auth::user()->id."")));
        $data['delivery'] = DB::select(DB::raw("SELECT * FROM `delivery_fee_slab` WHERE price_from <= '".$data['orders'][0]->order_total."' AND price_to >= '".$data['orders'][0]->order_total."'"))[0]->delivery_fee;
        $data['setting'] = DB::select(DB::raw("SELECT * FROM `settings` WHERE id = '1'"));

        return view('seller.order_details', $data);
    }
}
