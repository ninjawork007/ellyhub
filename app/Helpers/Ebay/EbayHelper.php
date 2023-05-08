<?php
namespace App\Helpers\Ebay;
use Auth;
use App\Models\Order;
use App\Models\Product;
use App\Http\Controllers\Admin\EbayCronController;


class EbayHelper {
	
	 public function getBusinessPolicies($user_id)
    {
		
		
		$EbayCronFetchProduct = new EbayCronController();
		$return=   $EbayCronFetchProduct->getReturnPolicy($user_id);
		$return=   $EbayCronFetchProduct->getPaymentPolicy($user_id);
		$return=   $EbayCronFetchProduct->getShippingPolicy($user_id);
		
	}

}

//  end of classWalmartHelper