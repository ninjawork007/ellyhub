<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\EbayCredential;
use Auth;

use App\Http\Controllers\Controller;
use App\Helpers\Ebay\EbayHelper;

class EbayOauthController extends Controller
{
   

    //Todo: Production
    public $appID;
    public $devID;
    public $certID;
    public $ruName;//ruName == redirectURI
    public $url;//ruName == redirectURI
	public $environment;
	


    public function __construct()
    {
        $this->appID = config('app.ebay_prod_app_id');
        $this->devID = config('app.ebay_prod_dev_id');
        $this->certID = config('app.ebay_prod_cert_id');
        $this->ruName = config('app.ebay_prod_runame');
        $this->url = config('app.url');
		$this->environment = config('app.ebay_app_environment');
    }

    /*--------------------------------Todo: Step 1 Login Pages Show --------------------------------------------------*/
    public function showEbayLogin()
    {
        //https://auth.ebay.com/oauth2/authorize?client_id=DanishSi-itemRepr-PRD-fec73a437-96145cfe&response_type=code&redirect_uri=Waqar_Siddiqui-DanishSi-itemRe-ulmjpy&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/commerce.identity.readonly https://api.ebay.com/oauth/api_scope/commerce.notification.subscription https://api.ebay.com/oauth/api_scope/commerce.notification.subscription.readonly
		
		
		if($this->environment=='sandbox')	
		{
			 $EBAY_OAUTH_URL = 'https://auth.sandbox.ebay.com/oauth2/authorize?client_id=' . $this->appID . '&response_type=code&redirect_uri=' . $this->ruName . '&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/commerce.identity.readonly';
			
		}
		
		else
		{
        $EBAY_OAUTH_URL = 'https://auth.ebay.com/oauth2/authorize?client_id=' . $this->appID . '&response_type=code&redirect_uri=' . $this->ruName . '&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/commerce.identity.readonly';
		
		}
        //return $EBAY_OAUTH_URL; //https://auth.ebay.com/oauth2/authorize?client_id=DanishSi-itemRepr-PRD-fec73a437-96145cfe&response_type=code&redirect_uri=Waqar_Siddiqui-DanishSi-itemRe-ulmjpy&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/commerce.identity.readonly
        return redirect()->to($EBAY_OAUTH_URL);
    }
    /*--------------------------------Todo: Step 1 Login Pages Show --------------------------------------------------*/


    /*----------------------------Todo : LoginSuccess then get Access_Token and User_id-------------------------------*/
    /*------------------------Todo: Step 2 Ebay Token User data and Media Get ---------------------------------------*/
    public function loginEbay()
    {
        $user = Auth::user();  

        $apicall = $this->soApicall($_GET['code']);
	
        $apiResponseArray = json_decode($apicall, true); // string format object to array

      
        if ($apiResponseArray) {
            $ebay_credentials = EbayCredential::where('user_id', '=', $user->id)->first();
            if ($ebay_credentials) {
                $ebay_credentials->user_id = $user->id;
                $ebay_credentials->access_token = $apiResponseArray['access_token'];
                $ebay_credentials->expires_in = $apiResponseArray['expires_in'];
                $ebay_credentials->refresh_token = $apiResponseArray['refresh_token'];
                $ebay_credentials->refresh_token_expires_in = $apiResponseArray['refresh_token_expires_in'];
                $ebay_credentials->save();

                if ($ebay_credentials) {
                    return redirect()->route('market_settings')->with('success', 'You have successfully connected your eBay');
                } else {
                    return redirect()->route('market_settings')->with('success', 'Failed to connect your eBay');
                }
            } else {
                $ebay_credentials = new EbayCredential();
                $ebay_credentials->user_id = $user->id;
                $ebay_credentials->paypal_email = null;
                $ebay_credentials->access_token = $apiResponseArray['access_token'];
                $ebay_credentials->expires_in = $apiResponseArray['expires_in'];
                $ebay_credentials->refresh_token = $apiResponseArray['refresh_token'];
                $ebay_credentials->refresh_token_expires_in = $apiResponseArray['refresh_token_expires_in'];
                $ebay_credentials->save();
			

                if ($ebay_credentials) {
					
					$helper=new EbayHelper();
					$helper->getBusinessPolicies($user->id);
		
                    return redirect()->route('market_settings')->with('success', 'You have successfully connected your eBay');
                } else {
                    return redirect()->route('market_settings')->with('success', 'Failed to connect your eBay');
                }
            }
        } else {
            return redirect()->to('/show-ebay-login');
        }

    }
    /*------------------------Todo:END Step 2 Ebay Token User data and Media Get ---------------------------------------*/

    //TODO: CALL ->    https://developer.ebay.com/api-docs/static/oauth-authorization-code-grant.html
    /*------------------------Todo:Start Step 3 Ebay API Call ---------------------------------------*/
    /*------------------------Todo:Start Test Api Error Solved Step 4 Ebay API Call ---------------------------------------*/
    public function soApicall($auth_code)
    {
        //        return [$auth_code,$this->appID,$this->certID,$this->redirectURI];
        $clientID = $this->appID;
        $clientSecret = $this->certID;
        $ruName = $this->ruName;
        $authCode = $auth_code;
		if($this->environment=='sandbox')	
			$url = 'https://api.sandbox.ebay.com/identity/v1/oauth2/token';
		else	
        	$url = 'https://api.ebay.com/identity/v1/oauth2/token';
       
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode($clientID . ':' . $clientSecret)
        ];

        $body = http_build_query([
            'grant_type' => 'authorization_code',
            'code' => $authCode,
            'redirect_uri' => $ruName
        ]);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => $headers
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // echo $response."\n";
            return $response;
        }
    }

    /*------------------------Todo:End Test Api Error Solved Step 4 Ebay API Call ---------------------------------------*/

    public function loginFailEbay()
    {
        return redirect()->to('/');
    }

    /*------------------------Todo:SandBox  ---------------------------------------*/
    public function loginEbaySandBox()
    {
        $user = Auth::user();  

        //        print_r($_GET);
        $apicall = $this->soApicallSandBox($_GET['code']);
        return [
            '$_GET' => $_GET,
            'getType_$_GET' => gettype($_GET),


            'apicall' => $apicall,
            'apicall_type' => gettype($apicall),
            'apicall_json_encode' => json_encode($apicall),
            'apicall_json_encode_type' => gettype(json_encode($apicall)),

            'apicall_json_encode_true' => json_encode($apicall, true),
            'apicall_json_encode_type_true' => gettype(json_encode($apicall, true)),


            'apicall_json_encode_true' => json_decode($apicall),
            'apicall_json_encode_type_true' => gettype(json_decode($apicall)),

            'apicall_json_decode_true' => json_decode($apicall, true),
            'apicall_json_encode_type_true' => gettype(json_decode($apicall, true)),
        ];

        //        Error list show in readme file
        $apiResponseArray = json_decode($apicall, true);

        $file_name_generate = date("d-m-Y H_i_s", time()) . '_log_file.txt';
        $log_file_path = '/app/public/oauth/ebay_oauth_info/' . $file_name_generate; // /app/public/amazon-api/log_file/50006018750_log_file.txt
       /* $myfile = fopen(storage_path($log_file_path), "w");
        fwrite($myfile, $apicall);
        fclose($myfile);*/

        $ebay_credentials = EbayCredential::where('user_id', '=', $user->id)->first();
        if ($ebay_credentials) {
            $ebay_credentials->user_id = $user->id;
            $ebay_credentials->access_token = $apiResponseArray['access_token'];
            $ebay_credentials->expires_in = $apiResponseArray['expires_in'];
            $ebay_credentials->refresh_token = $apiResponseArray['refresh_token'];
            $ebay_credentials->refresh_token_expires_in = $apiResponseArray['refresh_token_expires_in'];
            $ebay_credentials->save();

            if ($ebay_credentials) {
                return redirect()->to($this->url . '/vendor-ebay-credential');
            } else {
                return redirect()->to($this->url . '/vendor-ebay-credential');
            }
        } else {
            $ebay_credentials = new EbayCredential();
            $ebay_credentials->user_id = $user->id;
            $ebay_credentials->paypal_email = null;
            $ebay_credentials->access_token = $apiResponseArray['access_token'];
            $ebay_credentials->expires_in = $apiResponseArray['expires_in'];
            $ebay_credentials->refresh_token = $apiResponseArray['refresh_token'];
            $ebay_credentials->refresh_token_expires_in = $apiResponseArray['refresh_token_expires_in'];
            $ebay_credentials->save();

            if ($ebay_credentials) {
                return redirect()->to($this->url . '/vendor-ebay-credential');
            } else {
                return redirect()->to($this->url . '/vendor-ebay-credential');
            }
        }
    }

    public function soApicallSandBox($auth_code)
    {
        //        return [$auth_code,$this->appID,$this->certID,$this->redirectURI];
        $clientID = config('app.EBAY_SANDBOX_APP_ID');
        $clientSecret = config('app.EBAY_SANDBOX_CERT_ID');
        $ruName = config('app.EBAY_SANDBOX_RUNAME');
        $authCode = $auth_code;

        $url = 'https://api.sandbox.ebay.com/identity/v1/oauth2/token';
        //$url = 'https://api.ebay.com/identity/v1/oauth2/token';

        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode($clientID . ':' . $clientSecret)
        ];

        $body = http_build_query([
            'grant_type' => 'authorization_code',
            'code' => $authCode,
            'redirect_uri' => $ruName
        ]);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => $headers
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // echo $response."\n";
            return $response;
        }
    }
    /*------------------------Todo:SandBox  ---------------------------------------*/
}
