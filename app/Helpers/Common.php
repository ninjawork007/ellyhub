<?php

namespace App\Helpers;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Model\User;
use App\Model\Membership;
use File;
use DateTime;
use DateTimeZone;
use Mail;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
class Common{



   public function send_email($html,$to,$name,$subject){
            $array['data']['html']=$html;
            $array['data']['email']=$to;
            $array['data']['name']=$name;
            $array['data']['subject']=$subject;
            Mail::send('email.email', $array, function($message)use($array) {
                $message->to($array['data']['email'], $array['data']['name'])
                        ->subject($array['data']['subject'])->from(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME'));
            });

             if (Mail::failures()){
              return 0;
            }else{
               return 1;
            }
   }

   public function stripePayment($value){
        $baseurl = 'https://api.stripe.com';
        $secretkey = 'sk_test_51MOmYHL4yyegc2uILZLzGOQPW6YgOGL1az5l7eRvS4esQsiyDuc0yE8idmXr1UfDKLqZol49Vn8LOMfUXyaqgQP1006DG2iwUb';
        $amount = round($value['order_total_before']*100);
        $input['transaction_id'] = \Str::random(18); // random string for transaction id
        $secretkey = $secretkey;
        $payment_url = $baseurl.'/v1/payment_methods';
        $card_date_array = explode('/',$value['expiry']);
        $payment_data = [
            'type' => 'card',
            'card[number]' => $value['card'],
            'card[exp_month]' => $card_date_array[0],
            'card[exp_year]' => $card_date_array[1],
            'card[cvc]' => $value['cvv'],
            'billing_details[email]' => $value['email'],
            'billing_details[name]' => $value['name_on_card'],
        ];
        $payment_payload = http_build_query($payment_data);
        $payment_headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer '.$secretkey
        ];
        $payment_body = $this->curlPost($payment_url, $payment_payload, $payment_headers);
        $payment_response = json_decode($payment_body, true);

        if (isset($payment_response['id']) && $payment_response['id'] != null) {
            $request_url = $baseurl.'/v1/payment_intents';
            $request_data = [
                'amount' => $value['order_total_before']*100, // multiply amount with 100
                'currency' => 'USD',
                'payment_method_types[]' => 'card',
                'payment_method' => $payment_response['id'],
                'confirm' => 'true',
                'capture_method' => 'automatic',
                'return_url' => url('make-order'),
                'payment_method_options[card][request_three_d_secure]' => 'automatic',
            ];
            $request_payload = http_build_query($request_data);

            $request_headers = [
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Bearer '.$secretkey
            ];
            $response_body = $this->curlPost($request_url, $request_payload, $request_headers);

            $response_data = json_decode($response_body, true);
            if (isset($response_data['next_action']['redirect_to_url']['url']) && $response_data['next_action']['redirect_to_url']['url'] != null) {
                session()->put('3d', true);
                return json_encode(['success'=>true,'message'=>'Payment completed.redirect to 3d page','data'=>$response_data]);
            
            // transaction success without 3d secure redirect
            } elseif (isset($response_data['status']) && $response_data['status'] == 'succeeded') {
                session()->put('transectionid', $response_data['id']);
                session()->put('3d', false);
                return json_encode(['success'=>true,'message'=>'Payment completed.','data'=>$response_data]);

            // transaction declined because of error
            } elseif (isset($response_data['error']['message']) && $response_data['error']['message'] != null) {
                return json_encode(['success'=>false,'message'=>'transaction declined. please try again.','data'=>[]]);
            } else {
                return json_encode(['success'=>false,'message'=>'Something went wrong, please try again.','data'=>[]]);
            }
            // return json_encode(['success'=>true,'message'=>'payment intent','data'=>$payment_response]);
        }elseif (isset($payment_response['error']['message']) && $payment_response['error']['message'] != null) {
            return json_encode(['success'=>false,'message'=>$payment_response['error']['message'],'data'=>[]]);
        }
       return $payment_response;
   }

   private function curlPost($url, $data, $headers){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close ($ch);

        return $response;
    }
 
    public function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}
