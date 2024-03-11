<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ChatController extends Controller
{
    public function index($order_id, $product_id){
        $request = Request();
        if($request->session()->get('userid')){
            $data['checking_chat'] = chat::where(['order_id' => $order_id, 'product_id' => $product_id, 'user_id' => $request->session()->get('userid')]);
        }
        else{
            return Redirect::to('user/login');
        }

        return view('chats', $data);
    }
}
