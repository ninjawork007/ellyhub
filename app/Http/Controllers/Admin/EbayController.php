<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\EbayCredential;
use Auth;
use App\Http\Controllers\Admin\EbayCronController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Ebay\EbayHelper;
use Illuminate\Support\Facades\DB;

class EbayController extends Controller
{
    public function ebayCredentialsStore(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'paypal_email' => ['required'],
        ]);

        $ebay_credentials = EbayCredential::where('user_id', '=', $user->id)->first();
        if ($ebay_credentials) {
            $ebay_credentials->user_id = $user->id;
            $ebay_credentials->paypal_email = $request->paypal_email;
            $ebay_credentials->save();

            if ($ebay_credentials) {
                return redirect()->back()->with('success', 'Ebay credentials update successfully');
            } else {
                return redirect()->back()->with('success', 'Ebay credentials Not update successfully.');
            }
        } else {
            $ebay_credentials = new EbayCredential();
            $ebay_credentials->user_id = auth()->user()->id;
            $ebay_credentials->paypal_email = $request->paypal_email;
            $ebay_credentials->access_token = '';
            $ebay_credentials->expires_in = '';
            $ebay_credentials->refresh_token = '';
            $ebay_credentials->refresh_token_expires_in = '';
            $ebay_credentials->save();

            if ($ebay_credentials) {
                return redirect()->back()->with('success', 'Ebay credentials store successfully');
            } else {
                return redirect()->back()->with('success', 'Ebay credentials Not store successfully.');
            }
        }
    }

    public function ebayCredentialsRemove()
    {
        $user = Auth::user();

        $ebay_credentials = EbayCredential::where('user_id', '=', $user->id)->delete();
        if ($ebay_credentials == 1) {
            return redirect()->back()->with('success', 'Ebay credentials remove successfully');
        } else {
            return redirect()->back()->with('success', 'Ebay credentials not remove successfully');
        }
    }
	
	 public function updatePaypal(Request $request)
    {
        $user = Auth::user();
		

        $ebay = EbayCredential::where('user_id', $user->id)->firstOrFail();
        $ebay->paypal_email = $request->paypal;
        $ebay->save();

		$helper=new EbayHelper();
		$helper->getBusinessPolicies($user->id);


        return redirect()->back()->with('success', 'Your paypal has been successfully updated.');
    }
	 public function fetchEbayProductCron()
    {
		
		 try {
			 // Storage::disk('local')->put(date("Y-m-d H:i:s").'_'.'ebay.txt', 'content');
				$ebay=new EbayCronController();
				  
				$ebay_credentials = EbayCredential::get(); 
				if ($ebay_credentials) 
				{
					foreach($ebay_credentials as $cre)
						$ebay->fetchProduct('',false,$cre->user_id);
				}
                logger("Cron Job Running");
		 }
          catch (\Exception $exception) {
			  Storage::disk('local')->put(date("Y-m-d H:i:s").'_'.'error.txt', $exception->getMessage());
          
          }
       
		return true;

       
    }

	
	 public function fetchEbayProduct()
    {
				
       $ebay=new EbayCronController();
		$ebay->fetchProductNew();

       return redirect()->back()->with('success', 'eBay Product has been successfully fetched.');
    }

}
