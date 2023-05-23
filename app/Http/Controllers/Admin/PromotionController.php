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
class PromotionController extends Controller{
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
	public function send_mail(){
		$data['user'] = DB::table('users')->where([['isactive','=','1'],['user_type','=','customer'],['email_verify','=','yes']])->get();
	    return view('admin.promotion.mail',$data);
	}
    public function send_mail_touser(Request $request){
        $ids = explode(',', $request->ids);
        for ($i=0; $i < count($ids); $i++) { 
        	$user = DB::table('users')->where('id',$ids[$i])->first();
        	$array['to'][]=array('email'=>$user->email,'name'=>$user->name);
            $array['subject']='Bazarhat99:- Notifications';
            $array['dynamic_template_data']=array('name'=>$user->name,'message'=>$request->message);
            $email['personalizations'][]=$array;
            $email['from']['email'] ='hello@amrsoftec.com';
            $email['template_id']='d-07ed869c21934de8bcc39c8efb1d4e14';
            $json=json_encode($email);
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.sendgrid.com/v3/mail/send",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => $json,
              CURLOPT_HTTPHEADER => array(
                "authorization: Bearer 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",
                "content-type: application/json"
              ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
        }
        return redirect(url('admin/send-mail'))->with('success','Email sent successfully.');
    }
    
}
