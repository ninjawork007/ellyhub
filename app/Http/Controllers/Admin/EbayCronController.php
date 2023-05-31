<?php

namespace App\Http\Controllers\Admin;

use App\EbayProductStatus;

use App\Models\EbayCategory;
use App\Models\EbayPaymentPolicy;
use App\Models\Product;
use App\Models\EbayReturnPolicy;
use App\Models\EbayShippingPolicy;
use Illuminate\Http\Request;
use App\Models\EbayCredential;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Auth;

use App\Models\User;
use App\Models\Marketplace;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\ProductGallery;

use App\Http\Controllers\Controller;

class EbayCronController extends Controller
{
    public $image_url;
    
    public $siteId;
    public $listingDuration;
    public $listingType;
    public $limit;

    public $appId;
    public $devId;
    public $certId;
    public $serverUrl;
    public $userToken;

    public $ebayGlobalId;
    public $compatabilityLevel;
	public $environment;

    public function __construct()
    {
        $this->appId = config('app.ebay_prod_app_id');
        $this->devId = config('app.ebay_prod_dev_id');
        $this->certId = config('app.ebay_prod_cert_id');
		$this->environment = config('app.ebay_app_environment');
       
	   if($this->environment=='sandbox')
	   	$this->serverUrl = 'https://api.sandbox.ebay.com/ws/api.dll';	    
	   else 
	    $this->serverUrl = 'https://api.ebay.com/ws/api.dll';	
		

        $this->ebayGlobalId = config('app.ebay_global_id');
        $this->siteId = config('app.ebay_site_id');

        $this->compatabilityLevel = 1081;
        $this->listingDuration = 'GTC';
        $this->listingType = 'FixedPriceItem';
        $this->limit = 200;

        $this->image_url = config('app.url') . '/storage/';
    }

    public function deleteProduct($productUpdate)
    {
        $user = Auth::user();

        $userToken = $this->getToken();
        if ($userToken) {
            //$requestXmlBody .= "<ItemID>373911892051</ItemID>";
            if ($productUpdate) {
                $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
                $requestXmlBody .= '<EndItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
                $requestXmlBody .= '<RequesterCredentials>';
                $requestXmlBody .= "<eBayAuthToken>$userToken</eBayAuthToken>";
                $requestXmlBody .= "</RequesterCredentials>";
                $requestXmlBody .= "<ErrorLanguage>en_US</ErrorLanguage>";
                $requestXmlBody .= "<WarningLevel>High</WarningLevel>";
                $requestXmlBody .= "<ItemID>$productUpdate->ebay_product_id</ItemID>";
                $requestXmlBody .= "<EndingReason>NotAvailable</EndingReason>";
                $requestXmlBody .= "</EndItemRequest>";

               
                $callname = 'EndItem';
                $responseXml = $this->sendHttpRequest($requestXmlBody, $userToken, $callname);
                $response = $this->xmlToArray($responseXml);

              

                if ($response['Ack'] == 'Success') {
                    
                    $productUpdate->ebay_product_id = null;
                    $productUpdate->save();
                    return [
                        'success' => true,
                        '$response' => $response,
                        '$requestXmlBody' => $requestXmlBody,
                        '$responseXml' => $responseXml,
                        '$productUpdate' => $productUpdate,
                    ];
                } else {
                    return [
                        'success' => false,
                        '$response' => $response,
                        '$requestXmlBody' => $requestXmlBody,
                        '$responseXml' => $responseXml,
                        '$productUpdate' => $productUpdate,
                    ];
                }
            }
        }
    }

    
	
	

    public function fetchProduct($id = '',$isAuth=true,$user_id=0)
    {
        //EbayCategory::truncate();
        //Product::truncate();
        //Category::truncate();
        //SubCategory::truncate();
        //ChildCategory::truncate();

        $EbayFetchProductIds = array();

		if($isAuth) {
            $user = Auth::user();  
        } else {
            $user = User::find($user_id);
        }
		
        $userToken = $this->getToken($isAuth,$user_id);    
		
        $startDate = date('Y-m-d', strtotime('-60 days')) . 'T' . date('H:i:s') . '.420Z'; //2022-01-25T08:39:40.420Z
        $endDate = date('Y-m-d') . 'T' . date('H:i:s') . '.420Z'; //2022-02-01T08:39:50.420Z
        $lastpage = false;
        $dataProducts = array();
        $t = 0;
        $pageno = 1;
		
        if (!empty($userToken)) {
            if (!empty($id)) {
                $query = '?q=' . $id . '&limit=100&offset=0';
			  if($this->environment=='sandbox')
              	 $url = 'https://api.sandbox.ebay.com/sell/inventory/v1/inventory_item?listingId=' . $query;
			   else
			    $url = 'https://api.ebay.com/sell/inventory/v1/inventory_item?listingId=' . $query;
                //https://www.ebay.com/sh/lst/active?catType=ebayCategories&q_field1=listingId&q_op1=EQUAL&q_value1=373911892051&action=search
				
            } else {
                $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
                $requestXmlBody .= '<GetMyeBaySellingRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
                $requestXmlBody .= '<RequesterCredentials>';
                $requestXmlBody .= '<eBayAuthToken>'.$userToken.'</eBayAuthToken>';
                $requestXmlBody .= '</RequesterCredentials>';
                $requestXmlBody .= '<ActiveList>';
                $requestXmlBody .= '<Sort>TimeLeft</Sort>';
                $requestXmlBody .= '<Pagination>
                    <EntriesPerPage>' . $this->limit . '</EntriesPerPage>
                    <PageNumber>' . $pageno . '</PageNumber>
                  </Pagination>';
                $requestXmlBody .= '</ActiveList>';
                $requestXmlBody .= '</GetMyeBaySellingRequest>';
                $callname = 'GetMyeBaySelling';
                $responseXml = $this->sendHttpRequest($requestXmlBody, $userToken, $callname);
                $productData = $this->xmlToArray($responseXml);
                array_push($dataProducts, $productData["ActiveList"]['ItemArray']);

                $t++;
                $pageno++;
                if ($productData['Ack'] == 'Success') {
                    $pages = $productData['ActiveList']['PaginationResult']['TotalNumberOfPages'];
                    if ($pages > 1) {
                        for ($g = 2; $g <= $pages; $g++) {
                            $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';

                            $requestXmlBody .= '<GetMyeBaySellingRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
                            $requestXmlBody .= '<RequesterCredentials>';
                            $requestXmlBody .= '<eBayAuthToken>'.$userToken.'</eBayAuthToken>';
                            $requestXmlBody .= '</RequesterCredentials>';
                            $requestXmlBody .= '<ActiveList>';
                            $requestXmlBody .= '<Sort>TimeLeft</Sort>';
                            $requestXmlBody .= '<Pagination>
                                <EntriesPerPage>' . $this->limit . '</EntriesPerPage>
                                <PageNumber>' . $pageno . '</PageNumber>
                              </Pagination>';
                            $requestXmlBody .= '</ActiveList>';
                            $requestXmlBody .= '</GetMyeBaySellingRequest>';
                            $callname = 'GetMyeBaySelling';
                            $responseXml = $this->sendHttpRequest($requestXmlBody, $userToken, $callname);
                            $productData = $this->xmlToArray($responseXml);
                            array_push($dataProducts, $productData["ActiveList"]['ItemArray']);
                            $t++;
                            $pageno++;
                        }
                    }
                }
            }
            $productStoreInfoArraySuccess = [];
            $productStoreInfoArrayError = [];

            if (!empty($dataProducts)) {
                $activeProductStore = [];
                foreach ($dataProducts as $dataProduct) {
                    foreach ($dataProduct['Item'] as $product) {
                        $item_id = $product['ItemID'] ?? '';

                        if ($item_id) {
                            $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
                            $requestXmlBody .= '<GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
                            $requestXmlBody .= '<RequesterCredentials>';
                            $requestXmlBody .= '<eBayAuthToken>' . $userToken . '</eBayAuthToken>';
                            $requestXmlBody .= '</RequesterCredentials>';
                            $requestXmlBody .= '<ErrorLanguage>en_US</ErrorLanguage>';
                            $requestXmlBody .= '<WarningLevel>High</WarningLevel>';
                            $requestXmlBody .= '<DetailLevel>ReturnAll</DetailLevel>';
                            $requestXmlBody .= '<IncludeItemSpecifics>true</IncludeItemSpecifics>';
                            $requestXmlBody .= '<ItemID>' . $item_id . '</ItemID>';
                            $requestXmlBody .= '</GetItemRequest>';

                            $EbayFetchProductIds[] = $item_id;

                            $callname = 'GetItem';
                            $responseXml = $this->sendHttpRequest($requestXmlBody, $userToken, $callname);
                            $productData = $this->xmlToArray($responseXml);

                            if ($productData['Ack'] == 'Success') {
                                $product = $productData['Item'];
                            }

                            $ebayCategoryId = $product['PrimaryCategory']['CategoryID'] ?? '';
                            $ebayCategoryName = $product['PrimaryCategory']['CategoryName'] ?? '';

                            $item_specific = '';
                            $ItemSpecificationKeys = array();

                            if (isset($product['ItemSpecifics']['NameValueList'])) {
                                $ItemSpecifics = json_decode(json_encode($product['ItemSpecifics']));
                                if (gettype($ItemSpecifics->NameValueList) == 'object') {
                                    if (isset($ItemSpecifics->NameValueList->Name)) {
                                        $ItemSpecificationKeys[] = $ItemSpecifics->NameValueList->Name;
                                        $key = $ItemSpecifics->NameValueList->Name;
                                        $value = $ItemSpecifics->NameValueList->Value;
                                        $item_specific_array = [];
                                        $item_specific_array[$key] = $value;
                                        $item_specific = json_encode($item_specific_array);
                                    }
                                } else if (gettype($ItemSpecifics->NameValueList) == 'array') {
                                    $item_specific_array = [];
                                    foreach ($ItemSpecifics->NameValueList as $itemSpecific) {
                                        $ItemSpecificationKeys[] = $itemSpecific->Name;
                                        $key = $itemSpecific->Name;
                                        $value = $itemSpecific->Value;
                                        $item_specific_array[$key] = $value;
                                    }
                                    $item_specific = json_encode($item_specific_array);
                                }
                            }

                            if ($ebayCategoryId) {
                                $checkCategory = EbayCategory::where('category_id', $ebayCategoryId)->first();
                                if (!$checkCategory) {
                                    $checkCategory = new EbayCategory();
                                    $checkCategory->category_id = $ebayCategoryId;
                                    $checkCategory->name = $ebayCategoryName != '' ? str_replace(':', ' > ', $ebayCategoryName) : '';
                                    $checkCategory->status = 1;
                                    $checkCategory->custom_fields = json_encode($ItemSpecificationKeys);
                                    $checkCategory->save();
                                }
                            }

                            $ExpCatName = explode(":", $ebayCategoryName);
                            $MainCatID = 0;
                            $SubCatID = 0;
                            $ChildCatID = 0;

                            if(isset($ExpCatName[0])){
                                $CheckCategoryExists = Category::where("name", trim($ExpCatName[0]))->first();
                                if(isset($CheckCategoryExists->id)){
                                    $MainCatID = $CheckCategoryExists->id;
                                }else{
                                    $CatObj = new Category();
                                    $CatObj->name = trim($ExpCatName[0]);
                                    if(trim($ExpCatName[0]) == "Cell Phones & Accessories" || trim($ExpCatName[0]) == "Cameras & Photo"){
                                        $CatObj->home_screen = "yes";
                                    }
                                    $CatObj->slug = $this->slugify(trim($ExpCatName[0]));
                                    $CatObj->home_category = 1;
                                    $CatObj->save();
                                    $MainCatID = $CatObj->id;
                                }
                            }

                            if(isset($ExpCatName[1])){
                                $CheckCategoryExists = SubCategory::where("title", trim($ExpCatName[1]))->first();
                                if(isset($CheckCategoryExists->id)){
                                    $SubCatID = $CheckCategoryExists->id;
                                }else{
                                    $CatObj = new SubCategory();
                                    $CatObj->category_id = $MainCatID;
                                    $CatObj->title = trim($ExpCatName[1]);
                                    $CatObj->slug = $this->slugify(trim($ExpCatName[1]));
                                    $CatObj->save();
                                    $SubCatID = $CatObj->id;
                                }
                            }

                            if(isset($ExpCatName[2])){
                                $CheckCategoryExists = ChildCategory::where("name", trim($ExpCatName[2]))->first();
                                if(isset($CheckCategoryExists->id)){
                                    $ChildCatID = $CheckCategoryExists->id;
                                }else{
                                    $CatObj = new ChildCategory();
                                    $CatObj->category_id = $MainCatID;
                                    $CatObj->sub_category_id = $SubCatID;
                                    $CatObj->name = trim($ExpCatName[2]);
                                    $CatObj->slug = $this->slugify(trim($ExpCatName[2]));
                                    $CatObj->save();
                                    $ChildCatID = $CatObj->id;
                                }
                            }

                            $categoryId = $ebayCategoryId;

                            $title = $product['Title'] ?? '';
                            $sku = $product['SKU'] ?? null;

                            $description = $product['Description'] ?? '';
                            $quantity = $product['Quantity'] ?? 0;
                            $price = $product['SellingStatus']['CurrentPrice'] ?? 0;

                            $brand = $product['ProductListingDetails']['BrandMPN']['Brand'] ?? null;
                            //$MPN = $product['ProductListingDetails']['BrandMPN']['MPN'] ?? null;

                            //return [$item_specific, $product];

                            $UPC = $product['ProductListingDetails']['UPC'] ?? null;

                            //$picture_url = isset($product['PictureDetails']['PictureURL']) ? (gettype($product['PictureDetails']['PictureURL']) == 'string' ? $product['PictureDetails']['PictureURL'] : (gettype($product['PictureDetails']['PictureURL']) == 'array' ? $product['PictureDetails']['PictureURL'][0] : "")) : "";
                            if (isset($product['PictureDetails']['PhotoDisplay'])) {
                                if ($product['PictureDetails']['PhotoDisplay'] == 'PicturePack') {
                                    $picture_url = isset($product['PictureDetails']['PictureURL']) ? (gettype($product['PictureDetails']['PictureURL']) == 'string' ? $product['PictureDetails']['PictureURL'] : (gettype($product['PictureDetails']['PictureURL']) == 'array' ? $product['PictureDetails']['PictureURL'][0] : "")) : "";
                                } else if (isset($product['PictureDetails']['GalleryURL'])) {
                                    $picture_url = isset($product['PictureDetails']['GalleryURL']) ? (gettype($product['PictureDetails']['GalleryURL']) == 'string' ? $product['PictureDetails']['GalleryURL'] : (gettype($product['PictureDetails']['GalleryURL']) == 'array' ? $product['PictureDetails']['GalleryURL'][0] : "")) : "";
                                }
                            }
                            //$picture_url = $product['PictureDetails']['PictureURL'];

                            $shipping_policy_id = null;
                            $return_policy_id = null;
                            $payment_policy_id = null;

                            $ShippingProfileID = $product['SellerProfiles']['SellerShippingProfile']['ShippingProfileID'] ?? '';
                            $ReturnProfileID = $product['SellerProfiles']['SellerReturnProfile']['ReturnProfileID'] ?? '';
                            $PaymentProfileID = $product['SellerProfiles']['SellerPaymentProfile']['PaymentProfileID'] ?? '';

                            if ($ShippingProfileID) {
                                $ShippingPolicy = EbayShippingPolicy::where('policy_id', '=', $ShippingProfileID)->first();
                                if (!$ShippingPolicy) {
                                    $ShippingPolicy = new ShippingPolicy();
                                    $ShippingPolicy->policy_id = $ShippingProfileID;
                                    $ShippingPolicy->name = $product['SellerProfiles']['SellerShippingProfile']['ShippingProfileName'] ?? '';
                                    $ShippingPolicy->save();
                                }
                                $shipping_policy_id = $ShippingPolicy->id;
                            }

                            if ($ReturnProfileID) {
                                $ReturnPolicy = EbayReturnPolicy::where('policy_id', '=', $ReturnProfileID)->first();
                                if (!$ReturnPolicy) {
                                    $ReturnPolicy = new EbayReturnPolicy();
                                    $ReturnPolicy->policy_id = $ReturnProfileID;
                                    $ReturnPolicy->name = $product['SellerProfiles']['SellerReturnProfile']['ReturnProfileName'] ?? '';
                                    $ReturnPolicy->save();
                                }
                                $return_policy_id = $ReturnPolicy->id;
                            }

                            if ($PaymentProfileID) {
                                $PaymentPolicy = EbayPaymentPolicy::where('policy_id', '=', $PaymentProfileID)->first();
                                if (!$PaymentPolicy) {
                                    $PaymentPolicy = new EbayPaymentPolicy();
                                    $PaymentPolicy->policy_id = $PaymentProfileID;
                                    $PaymentPolicy->name = $product['SellerProfiles']['SellerPaymentProfile']['PaymentProfileName'] ?? '';
                                    $PaymentPolicy->save();
                                }
                                $payment_policy_id = $PaymentPolicy->id;
                            }


                            $package_type = $product['ShippingPackageDetails']['ShippingPackage'] ?? '';
                            $package_dimensions_length = $product['ShippingPackageDetails']['PackageLength'] ?? '';
                            $package_dimensions_width = $product['ShippingPackageDetails']['PackageWidth'] ?? '';
                            $package_dimensions_height = $product['ShippingPackageDetails']['PackageDepth'] ?? '';

                            $irregular_package = $product['ShippingPackageDetails']['ShippingIrregular'] ?? false;
                            $package_weight_major = $product['ShippingPackageDetails']['WeightMajor'] ?? '0';
                            $package_weight_minor = $product['ShippingPackageDetails']['WeightMinor'] ?? '0';

                            $package_weight = $package_weight_major . '.' . $package_weight_minor;

                            $country = $product['Country'] ?? '';
                            $zip_code = $product['PostalCode'] ?? '';
                            $city_or_state = $product['Location'] ?? '';

                           // $user = Auth::user();
							

                            $productStore = Product::where('vendor_id', $user->id)->where('ebay_product_id', $item_id)->first();
                            if (!$productStore) {
                                $productStore = new Product();
                            }

                            $productStore->vendor_id = $user->id;
                            $productStore->ebay_category_id = $categoryId;
                            $productStore->category_id = $MainCatID;
                            $productStore->sub_category_id = $SubCatID;
                            $productStore->child_category_id = $ChildCatID;

                           // $productStore->item_tag ='https://www.ebay.com/itm/'. $item_id;
                            $productStore->name = $title;
                             $productStore->sku = $sku;

                            $productStore->description = $description;
							$productStore->sale_price=$productStore->mrp_price=$productStore->product_price = $price;

                         

							//$productStore->supplierStock = 'Out of stock';
                            $productStore->stock = $quantity;

                           

                            $productStore->brand = $brand;
                            //$productStore->MPN = $MPN;
                           // $productStore->UPC = $UPC;
                            //$productStore->item_specifics = $item_specific;

                            $productStore->return_policy_id = $return_policy_id;
                            $productStore->payment_policy_id = $payment_policy_id;
                            $productStore->shipping_policy_id = $shipping_policy_id;

                            $productStore->package_type = $package_type;
                            $productStore->package_dimensions_length = $package_dimensions_length;
                            $productStore->package_dimensions_width = $package_dimensions_width;
                            $productStore->package_dimensions_height = $package_dimensions_height;
                           // $productStore->irregular_package = $irregular_package == 'true' ? 1 : 0;
                            $productStore->package_weight = (float)$package_weight;

                            $productStore->country = $country;
                            $productStore->zip_code = $zip_code;
                            $productStore->city_or_state = $city_or_state;

                            $productStore->image = $picture_url;
							$productStore->is_uploaded=1;
							$productStore->status='approved';

                            // $productStore->status = 1;

                            $productStore->ebay_product_id = $item_id;
                           if($this->environment=='sandbox')
                           	 $productStore->ebay_product_url ='https://www.sandbox.ebay.com/itm/'. $item_id;
							else
								$productStore->ebay_product_url ='https://www.ebay.com/itm/'. $item_id;
								 
                            $productStore->save();

                            if(isset($product["PictureDetails"]["PictureURL"]) && is_array($product["PictureDetails"]["PictureURL"])){
                                $CheckGallery = ProductGallery::where("product_id", $productStore->id)->count();
                                if(count($product["PictureDetails"]["PictureURL"]) > 0 && $CheckGallery == 0){
                                    foreach($product["PictureDetails"]["PictureURL"] as $PicURL){
                                        $GalleryObj = new ProductGallery();
                                        $GalleryObj->product_id = $productStore->id;
                                        $GalleryObj->images = $PicURL;
                                        $GalleryObj->save();
                                    }
                                }
                            }

                            array_push($activeProductStore, [$product, $productStore]);
                            array_push($productStoreInfoArraySuccess, $productStore);
                        } else {
                            array_push($productStoreInfoArrayError, '$item_id null');
                        }
                    }
                }

                Product::where(["ebay_product_id" => $EbayFetchProductIds])->delete();
                
                return [
                    'success' => true,
                    '$productStoreInfoArraySuccess' => $productStoreInfoArraySuccess,
                    '$productStoreInfoArrayError' => $productStoreInfoArrayError
                ];
            } else {
                return response()->json(['message' => 'Products not found', 'status' => 404]);
            }
        } else {
            return response()->json(['message' => 'Authtoken not found', 'status' => 404]);
        }
    }

    public function slugify($text, string $divider = '-')
    {
      // replace non letter or digits by divider
      $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

      // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);

      // trim
      $text = trim($text, $divider);

      // remove duplicate divider
      $text = preg_replace('~-+~', $divider, $text);

      // lowercase
      $text = strtolower($text);

      if (empty($text)) {
        return 'n-a';
      }

      return $text;
    }

  
    public function addProduct($id = '',$isAuth = true)
    {
        $ebayproduct = Product::where('id', $id)->get();	
		
			
		if($isAuth) {
            $user = Auth::user();  
        } else {
            $user = User::find($ebayproduct[0]->user);
        }

        //return 'addProduct';
        $userToken = $this->getToken(false,$user->id);
		
		
        if (!empty($userToken)) {
            if (!empty($id)) {
              
                $getProducts = Product::where('id', $id)->where('vendor_id', $user->id)->get();
            } else {
                $getProducts = Product::where('ebay_uploaded', 0)->with(['ebay_category'])->get();
            }
            //return $getProducts;
            if (!empty($getProducts)) {
                $responseData = array();
				

                foreach ($getProducts as $ky => $products) {
                    // $totalAmount = $products->price * $products->quantity;
                    $totalAmount = $products->target_price * $products->inventory;

                    if ($totalAmount < '250000') {
						
						$ebay_category_id = $products->ebay_category_id;
                        

                        $title = !empty($products['name']) ? substr($products['name'], 0, 75) : '';
                        $price = $products->sale_price;
                        $description = !empty($products['description']) ? $products['description'] : '';
						
						$description_header ='';// !empty($products['description_header']) ? $products['description_header'] : '';
						$description_footer ='';// !empty($products['description_footer']) ? $products['description_footer'] : '';	
						//$description=$description_header.'\n'.$description.'\n'.$description_footer;					
						$description=nl2br("$description_header\n$description\n$description_footer");
						$description=str_replace('<br />','',$description);


                        $requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
                        $requestXmlBody .= '<AddItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
                        $requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
                        $requestXmlBody .= '<ErrorLanguage>en_US</ErrorLanguage>';
                        $requestXmlBody .= '<WarningLevel>High</WarningLevel>';
                        $requestXmlBody .= '<Version>' . $this->compatabilityLevel . '</Version>';
                        $requestXmlBody .= '<Item>';
                        $requestXmlBody .= "<Title><![CDATA[" . $title . "]]>.</Title>";
                        $requestXmlBody .= "<Description><![CDATA[" . $description . "]]></Description>";

                        $requestXmlBody .= '<PrimaryCategory>';
                        $requestXmlBody .= "<CategoryID>" . $ebay_category_id . "</CategoryID>";
                        $requestXmlBody .= '</PrimaryCategory>';

                        $requestXmlBody .= "<StartPrice>" . $price . "</StartPrice>";
                        $requestXmlBody .= '<CategoryMappingAllowed>true</CategoryMappingAllowed>';
                        $requestXmlBody .= '<ConditionID>1000</ConditionID>';
                        //Todo: Country //$requestXmlBody .= '<Country>' . $products->country . '</Country>';
                        $requestXmlBody .= '<Currency>USD</Currency>';
                        $requestXmlBody .= '<DispatchTimeMax>3</DispatchTimeMax>';
                        $requestXmlBody .= "<ListingDuration>$this->listingDuration</ListingDuration>";
                        $requestXmlBody .= '<ListingType>' . $this->listingType . '</ListingType>';
                        //Todo: city_or_state //$requestXmlBody .= '<Location>' . $products->city_or_state . '</Location>';
                        $requestXmlBody .= '<PaymentMethods>CashOnPickup</PaymentMethods>';
                        $requestXmlBody .= '<PictureDetails>';
                        $requestXmlBody .= '<GalleryType>Gallery</GalleryType>';
						
						
						// $products->img1='https://ellyhub.com/uploads/1672832001_518XTpxmd4L._SY450_.jpg80196956.jpg';
						 $images=explode(',',$products->image);

						
                     foreach($images as $img){
                          $requestXmlBody .= '<PictureURL>' . strtok($img,'?') . '</PictureURL>';
                        }

                       /* if ($products->img2) {
                          $requestXmlBody .= '<PictureURL>' . strtok($products->img2,'?'). '</PictureURL>';
                        }*/

                     

                        $requestXmlBody .= '</PictureDetails>';

                        //$requestXmlBody .= '<Country>US</Country>';
                        //$requestXmlBody .= '<Location>Orlando, Florida</Location>';
                        //$requestXmlBody .= '<PostalCode>32829</PostalCode>';
                        //Todo: zip_code//$requestXmlBody .= '<PostalCode>32829</PostalCode>';

                        //$requestXmlBody .= '<ItemSpecifics></ItemSpecifics>';
                        //$requestXmlBody .= '<Name>Brand</Name>';$requestXmlBody .= '<Value>HolaHatha</Value>';
                        //$requestXmlBody .= '<Name>Manufacturer Part Number</Name>';$requestXmlBody .= '<Value>20836084</Value>';
                        //return [$item_specifics, gettype($item_specifics), $products->item_specifics, gettype($products->item_specifics)];
                        //if (count($item_specifics) > 0) {}

                        $requestXmlBody .= '<ItemSpecifics>';
						
							/*$requestXmlBody .= '<NameValueList>';
							$requestXmlBody .= "<Name><![CDATA[Brand]]></Name>";
						     $requestXmlBody .= "<Value><![CDATA[" . $products->brand . "]]></Value>";
							$requestXmlBody .= '</NameValueList>';
								*/


                        $Specs = json_decode($products->ItemSpecification, true);

                        if (count($Specs) > 0) {
                            //$item_specifics = json_decode($products->item_specifics);
                            foreach ($Specs as $key => $item_specific) {
                                $requestXmlBody .= '<NameValueList>';
                                $requestXmlBody .= "<Name><![CDATA[" . $key . "]]></Name>";
                                $requestXmlBody .= "<Value><![CDATA[" . $item_specific . "]]></Value>";
                                //$requestXmlBody .= '<Name>' . $key . '</Name>';
                                //$requestXmlBody .= '<Value>' . $item_specific . '</Value>';
                                $requestXmlBody .= '</NameValueList>';
                            }
                        }
                        $requestXmlBody .= '</ItemSpecifics>';

                        $requestXmlBody .= '<ProductListingDetails>';

                        /*if ($products->brand != null && $products->MPN != null) {
                            $requestXmlBody .= '<BrandMPN>';
                            $requestXmlBody .= '<Brand>' . $products->brand . '</Brand>';
                            $requestXmlBody .= '<MPN>' . $products->MPN . '</MPN>';
                            $requestXmlBody .= '</BrandMPN>';
                        }*/

						//$products->UPC=null;
                        //if ($products->UPC != null) {
                            $requestXmlBody .= '<UPC>Does Not Apply</UPC>';
                        //}

                        $requestXmlBody .= '<IncludeeBayProductDetails>true</IncludeeBayProductDetails>';
                        $requestXmlBody .= '<IncludeStockPhotoURL>true</IncludeStockPhotoURL>';
                        $requestXmlBody .= '<IncludePrefilledItemInformation>true</IncludePrefilledItemInformation>';
                        $requestXmlBody .= '<UseFirstProduct>true</UseFirstProduct>';
                        $requestXmlBody .= '<UseStockPhotoURLAsGallery>true</UseStockPhotoURLAsGallery>';
                        $requestXmlBody .= '<ReturnSearchResultOnDuplicates>true</ReturnSearchResultOnDuplicates>';
                        $requestXmlBody .= '</ProductListingDetails>';

                        $requestXmlBody .= "<Quantity>" . $products->stock . "</Quantity>";

                        $requestXmlBody .= '<ShippingDetails>';
                        $requestXmlBody .= '<ShippingType>Flat</ShippingType>';
                        $requestXmlBody .= '<ShippingServiceOptions>';
                        $requestXmlBody .= '<ShippingServicePriority>1</ShippingServicePriority>';
                        $requestXmlBody .= '<ShippingService>USPSExpressMailLegalFlatRateEnvelope</ShippingService>';
                        $requestXmlBody .= '<FreeShipping>true</FreeShipping>';
                        //$requestXmlBody .= '<ShippingServiceAdditionalCost currencyID="USD">' . $products->shipping_price . '</ShippingServiceAdditionalCost>';
                        $requestXmlBody .= '</ShippingServiceOptions>';
                        $requestXmlBody .= '</ShippingDetails>';

                        //Todo: SellerProfiles Policy
                        $requestXmlBody .= '<SellerProfiles>';

                        if ($products->payment_policy != null) {
                            $requestXmlBody .= '<SellerPaymentProfile>';
                            $requestXmlBody .= '<PaymentProfileID>' . $products->payment_policy->policy_id . '</PaymentProfileID>';
                            $requestXmlBody .= '<PaymentProfileName>' . $products->payment_policy->name . '</PaymentProfileName>';
                            $requestXmlBody .= '</SellerPaymentProfile>';
                        }
						

                        if ($products->return_policy != null) {
                            $requestXmlBody .= '<SellerReturnProfile>';
                            $requestXmlBody .= '<ReturnProfileID>' . $products->return_policy->policy_id . '</ReturnProfileID>';
                            $requestXmlBody .= '<ReturnProfileName>' . $products->return_policy->name . '</ReturnProfileName>';
                            $requestXmlBody .= '</SellerReturnProfile>';
                        }

                        if ($products->shipping_policy != null) {
                            $requestXmlBody .= '<SellerShippingProfile>';
                            $requestXmlBody .= '<ShippingProfileID>' . $products->shipping_policy->policy_id . '</ShippingProfileID>';
                            $requestXmlBody .= '<ShippingProfileName>' . $products->shipping_policy->name . '</ShippingProfileName>';
                            $requestXmlBody .= '</SellerShippingProfile>';
                        }
                        $requestXmlBody .= '</SellerProfiles>';
                        //Todo: SellerProfiles Policy

                        //Todo: ShippingPackageDetails
                        $requestXmlBody .= '<ShippingPackageDetails>';
                        $requestXmlBody .= '<MeasurementUnit>English</MeasurementUnit>';
						
					
						
					
						$irregular_package='0';
					
                        $requestXmlBody .= '<PackageDepth unit="inches" measurementSystem="English">' . $products->package_dimensions_height . '</PackageDepth>';
                        $requestXmlBody .= '<PackageLength unit="inches" measurementSystem="English">' . $products->package_dimensions_length . '</PackageLength>';
                        $requestXmlBody .= '<PackageWidth unit="inches" measurementSystem="English">' . $products->package_dimensions_width . '</PackageWidth>';
                        $requestXmlBody .= '<ShippingIrregular>' . $irregular_package . '</ShippingIrregular>';
                        $requestXmlBody .= '<ShippingPackage>' . $products->package_type . '</ShippingPackage>';
                        $requestXmlBody .= '<WeightMajor unit="lbs" measurementSystem="English">' . $products->package_weight . '</WeightMajor>';
                        $requestXmlBody .= '<WeightMinor unit="oz" measurementSystem="English">0</WeightMinor>';

                        $requestXmlBody .= '</ShippingPackageDetails>';
                        //Todo: ShippingPackageDetails

                        //Todo: Item Location					
						
                        $requestXmlBody .= '<Country>' . $products->country . '</Country>';
                        $requestXmlBody .= '<Location>' . $products->city_or_state . '</Location>';
                        $requestXmlBody .= '<PostalCode>' . $products->zip_code . '</PostalCode>';
                        //Todo: Item Location

                        $requestXmlBody .= '<ReturnPolicy>';
                        $requestXmlBody .= '<ReturnsAcceptedOption>ReturnsAccepted</ReturnsAcceptedOption>';
                        $requestXmlBody .= '<ReturnsWithinOption>Days_30</ReturnsWithinOption>';
                        $requestXmlBody .= '<ShippingCostPaidByOption>Buyer</ShippingCostPaidByOption>';
                        $requestXmlBody .= '</ReturnPolicy>';

                        $requestXmlBody .= '<Site>US</Site>';
                        $requestXmlBody .= '</Item>';
                        $requestXmlBody .= '</AddItemRequest>';
						
						
                        //return [$requestXmlBody];
                        //send the request and get response
                        $callname = 'AddItem';
                        $responseXml = $this->sendHttpRequest($requestXmlBody, $userToken, $callname);
                        $response = $this->xmlToArray($responseXml);
                        logger($response);


                        $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
                        $requestXmlBody .= '<GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
                        $requestXmlBody .= '<RequesterCredentials>';
                        $requestXmlBody .= '<eBayAuthToken>' . $userToken . '</eBayAuthToken>';
                        $requestXmlBody .= '</RequesterCredentials>';
                        $requestXmlBody .= '<ErrorLanguage>en_US</ErrorLanguage>';
                        $requestXmlBody .= '<WarningLevel>High</WarningLevel>';
                        $requestXmlBody .= '<DetailLevel>ReturnAll</DetailLevel>';
                        $requestXmlBody .= '<IncludeItemSpecifics>true</IncludeItemSpecifics>';
                        $requestXmlBody .= '<ItemID>' . $response["ItemID"] . '</ItemID>';
                        $requestXmlBody .= '</GetItemRequest>';

                        $callname = 'GetItem';
                        $responseXml = $this->sendHttpRequest($requestXmlBody, $userToken, $callname);
                        $productData = $this->xmlToArray($responseXml);

                        logger($productData);

						
						$environment = config('app.ebay_app_environment');					
						if ($response['Ack'] != 'Failure') {
                            $item_id = $response['ItemID'];
                            if (!empty($item_id)) {
                                $productUpdate = Product::where('id', '=', $products->id)->first();
                                if ($productUpdate) {
                                    $productUpdate->ebay_product_id = $item_id;
									if($this->environment=='sandbox')	
										 $productUpdate->ebay_product_url ='https://sandbox.ebay.com/itm/'.$item_id;
									else
										$productUpdate->ebay_product_url ='https://www.ebay.com/itm/'.$item_id; 
                                  
									
                                    $productUpdate->save();
									//error report
									$this->error_report('ebay',$id,'Successfully uploaded to eBay. eBay ID:'.$item_id);	
									

                                }
                            }
							
							 array_push($responseData, [
                            'success' => true,
                            'response' => $response,
                            'responseXml' => $responseXml,
                            'requestXmlBody' => $requestXmlBody,
                            'products' => $products,
                            'productUpdate' => isset($productUpdate),
                            'ebay_product_status' => isset($ebay_product_status),
                        ]);
							
							
                        }
						else
						{
							 //error report
							 $this->error_report('ebay',$id,$response);
							  array_push($responseData, [
                            'success' => false,
                            'response' => $response,
                            'responseXml' => $responseXml,
                            'requestXmlBody' => $requestXmlBody,
                            'products' => $products,
                            'productUpdate' => isset($productUpdate),
                            'ebay_product_status' => isset($ebay_product_status),
                        ]);
														
							
						}
                       
                        /*array_push($responseData, [
                            'success' => true,
                            'response' => $response,
                            'responseXml' => $responseXml,
                            'requestXmlBody' => $requestXmlBody,
                            'products' => $products,
                            'productUpdate' => isset($productUpdate),
                            'ebay_product_status' => isset($ebay_product_status),
                        ]);*/
                    } else {
						
						//error report
							 $this->error_report('ebay',$id,'This listing would cause you to exceed the amount ($250,000.00) you can list');
							 
                        array_push($responseData, [
                            'success' => false,
                            'response' => 'This listing would cause you to exceed the amount ($250,000.00) you can list',
                            'products' => $products,
                        ]);
                    }
                }
                // return response()->json(['response_data' => $responseData, 'status' => 200]);

                return $responseData;
            } else {
				
				//error report
				
				 $this->error_report('ebay',$id,'Inter-Product not found');
                // return response()->json(['message' => 'Products not found', 'status' => 404]);

                return [
                  'success' => false,
                  'message' => 'Product not found'
                ];
            }
        } else {
            // return response()->json(['message' => 'Authtoken not found', 'status' => 404]);
 			$this->error_report('ebay',$id,"eBay account not connected.");
            return [
              'success' => false,
              'message' => "eBay account not connected. Set your eBay connection by going into Fbmfox's Account settings and select 'eBay Settings' to connect."
            ];
        }
    }

    
		
		
		
		
	/*Retired Product*/	
	 public function endItem($id)
    {
     
            $userToken = $this->getToken();
            if ($userToken) {
				
				 $product = Product::where('id', $id)->whereNotNull('ebay_product_id')->first();
				 if (!empty($product)) {
						if ($product->ebay_product_id) {  
					$requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
					$requestXmlBody .= '<EndItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		
					$requestXmlBody .= "<RequesterCredentials ><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
					$requestXmlBody .= '<ErrorLanguage>en_US</ErrorLanguage>';
					$requestXmlBody .= '<WarningLevel>High</WarningLevel>';
					$requestXmlBody .= '<Version>' . $this->compatabilityLevel . '</Version>';
					 $requestXmlBody .= ' 
		<ItemID>'.$product->ebay_product_id.'</ItemID>
		 <EndingReason>NotAvailable</EndingReason>
	 
	</EndItemRequest > ';		
	
	 $callname = 'EndItem';
							$responseXml = $this->sendHttpRequest($requestXmlBody, $userToken, $callname);
							$response = $this->xmlToArray($responseXml);
							
	
							if ($response['Ack'] != 'Failure') {
								
								return true;
							}
							else
							return false;
							
						}
						
				 }
						
			}
					
	}

	
		// bulk in and out of stock-marketplace action 
	 public function bulkInAndOutofStock($marketplace_id,$action='out')
    {
		
		$user = Auth::user();
		$getProducts = Product::where('marketplace_id', $marketplace_id)->where('user', $user->id)->get();
		if($getProducts)
		{
			foreach($getProducts as $product)
			{
				//out of stock
				if($action=="out")
					$this->makeOutofStock($product->id);
				else if($action=="in")
				 $this->makeInStock($product->id);
			}
		
		}
		return true;
		
	}
	
	 public function makeInStock($id)
    {
		$model =Product::find($id);
		if($model)
		{
			//$model->supplierStock='In stock';
			//$model->inventory=2;
			$model->ebay_enabled=1;
			$model->save();		
			if($model->ebay_product_id)				
				$this->updateProduct($id);
			else
				$this->addProduct($id);
				
			return true;
		}
		
	}
	
	
	 public function makeOutofStock($id)
    {
		$model =Product::find($id);
		if($model)
		{
			//$model->supplierStock='Out of stock';
			$model->ebay_enabled=0;
			$model->save();		
			//$this->updateProduct($id);
			if($model->ebay_product_id)				
				$this->updateProduct($id);
			else
				$this->addProduct($id);
			return true;
		}
		
	}
		
		
	 public function SetUserPreferences()
    {
     
            $userToken = $this->getToken();
            if ($userToken) {
              
				$requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
				$requestXmlBody .= '<SetUserPreferencesRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
	
				$requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
				$requestXmlBody .= '<ErrorLanguage>en_US</ErrorLanguage>';
				$requestXmlBody .= '<WarningLevel>High</WarningLevel>';
				$requestXmlBody .= '<Version>' . $this->compatabilityLevel . '</Version>';
				 $requestXmlBody .= ' 
    <OutOfStockControlPreference>true</OutOfStockControlPreference>
 
</SetUserPreferencesRequest> ';		

 $callname = 'SetUserPreferences';
						$responseXml = $this->sendHttpRequest($requestXmlBody, $userToken, $callname);
						$response = $this->xmlToArray($responseXml);
						

                        if ($response['Ack'] != 'Failure') {
							
							return true;
						}
						
			}
					
	}
		
		
    public function updateProduct($id,$make_out_of_stock=0)
    {
	
        if ($id) {
			
            $userToken = $this->getToken();
            if ($userToken) {
                $product = Product::where('id', $id)->whereNotNull('ebay_product_id')->first();
                if (!empty($product)) {
                    if ($product->ebay_product_id) {						
						
						/*if($product->forceOOS==1 || $product->inventory<=0 ||  $product->supplierStock=='Out of stock')
						{
							$this->SetUserPreferences();
							if($product->forceOOS==1 ||  $product->supplierStock=='Out of stock')
							{
								$product->inventory=0;
							}
							
						}					*/	
                       
						$title = !empty($products['name']) ? substr($products['name'], 0, 75) : '';
                        $price = $product->sale_price;
                        $description = !empty($product['description']) ? $product['description'] : '';
						
						$description_header ='';// !empty($products['description_header']) ? $products['description_header'] : '';
						$description_footer ='';// !empty($products['description_footer']) ? $products['description_footer'] : '';	
						//$description=$description_header.'\n'.$description.'\n'.$description_footer;					
						$description=nl2br("$description_header\n$description\n$description_footer");
						$description=str_replace('<br />','',$description);


                        $requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
                        $requestXmlBody .= '<ReviseItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';

                        $requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
                        $requestXmlBody .= '<ErrorLanguage>en_US</ErrorLanguage>';
                        $requestXmlBody .= '<WarningLevel>High</WarningLevel>';
                        $requestXmlBody .= '<Version>' . $this->compatabilityLevel . '</Version>';

                        $requestXmlBody .= '<Item>';
                        $requestXmlBody .= '<ItemID>' . $product->ebay_product_id . '</ItemID>';
                        $requestXmlBody .= "<Title><![CDATA[" . $title . "]]>.</Title>";

                        if ($description != '') {
                            $requestXmlBody .= "<Description><![CDATA[" . $description . "]]></Description>";
                            $requestXmlBody .= "<DescriptionReviseMode>Replace</DescriptionReviseMode>";
                        }


                        if ($product->ebay_category_id != null) {
                            $requestXmlBody .= '<PrimaryCategory>';
                            $requestXmlBody .= "<CategoryID>" . $product->ebay_category_id . "</CategoryID>";
                            $requestXmlBody .= '</PrimaryCategory>';
                        }


                        $requestXmlBody .= "<StartPrice>" . $price . "</StartPrice>";
                        $requestXmlBody .= '<CategoryMappingAllowed>true</CategoryMappingAllowed>';
                        $requestXmlBody .= '<ConditionID>1000</ConditionID>';
                        //$requestXmlBody .= '<Country>US</Country>';
                        $requestXmlBody .= '<Currency>USD</Currency>';
                        $requestXmlBody .= '<DispatchTimeMax>3</DispatchTimeMax>';
                        //$requestXmlBody .= "<ListingDuration>$this->listingDuration</ListingDuration>";
                        $requestXmlBody .= '<ListingType>' . $this->listingType . '</ListingType>';
                        $requestXmlBody .= '<PaymentMethods>CashOnPickup</PaymentMethods>';

                        $PictureDetailsUpdate = 0;
						 $images=explode(',',$product->image);

						
                     foreach($images as $img){
                          $requestXmlBody .= '<PictureURL>' . strtok($img,'?') . '</PictureURL>';
                        }
                        
                        if ($PictureDetailsUpdate == 1) {
                            $requestXmlBody .= '</PictureDetails>';
                        }

                        //$requestXmlBody .= '<PostalCode>32829</PostalCode>';

                        $requestXmlBody .= '<ItemSpecifics>';
                        if ($product->item_specifics != null) {
                            $item_specifics = json_decode($product->item_specifics);
                            //if (count($product->item_specifics) > 0) {}
                            foreach ($item_specifics as $key => $item_specific) {
                                $requestXmlBody .= '<NameValueList>';
                                $requestXmlBody .= "<Name><![CDATA[" . $key . "]]></Name>";
                                $requestXmlBody .= "<Value><![CDATA[" . $item_specific . "]]></Value>";
                                //$requestXmlBody .= '<Name>' . $key . '</Name>';
                                //$requestXmlBody .= '<Value>' . $item_specific . '</Value>';
                                $requestXmlBody .= '</NameValueList>';
                            }
                        }

                        $requestXmlBody .= '</ItemSpecifics>';

                        $requestXmlBody .= '<ProductListingDetails>';

                        /*if ($product->brand != null && $product->MPN != null) {
                            $requestXmlBody .= '<BrandMPN>';
                            $requestXmlBody .= '<Brand>' . $product->brand . '</Brand>';
                            $requestXmlBody .= '<MPN>' . $product->MPN . '</MPN>';
                            $requestXmlBody .= '</BrandMPN>';
                        }*/

                        //if ($product->UPC != null) {
                            $requestXmlBody .= '<UPC>Does Not Apply</UPC>';
                        //}
						
						/*if($make_out_of_stock==1)
							$inventory=0;
						else*/
							$inventory=$product->stock;

                        $requestXmlBody .= '<IncludeeBayProductDetails>true</IncludeeBayProductDetails>';
                        $requestXmlBody .= '<IncludeStockPhotoURL>true</IncludeStockPhotoURL>';
                        $requestXmlBody .= '<IncludePrefilledItemInformation>true</IncludePrefilledItemInformation>';
                        $requestXmlBody .= '<UseFirstProduct>true</UseFirstProduct>';
                        $requestXmlBody .= '<UseStockPhotoURLAsGallery>true</UseStockPhotoURLAsGallery>';
                        $requestXmlBody .= '<ReturnSearchResultOnDuplicates>true</ReturnSearchResultOnDuplicates>';
                        $requestXmlBody .= '</ProductListingDetails>';
                        $requestXmlBody .= "<Quantity>" . $inventory . "</Quantity>";

                        $requestXmlBody .= '<ShippingDetails>';
                        $requestXmlBody .= '<ShippingType>Flat</ShippingType>';
                        $requestXmlBody .= '<ShippingServiceOptions>';
                        $requestXmlBody .= '<ShippingServicePriority>1</ShippingServicePriority>';
                        $requestXmlBody .= '<ShippingService>USPSExpressMailLegalFlatRateEnvelope</ShippingService>';
                        $requestXmlBody .= '<FreeShipping>true</FreeShipping>';
                        //$requestXmlBody .= '<ShippingServiceAdditionalCost currencyID="USD">' . $product->shipping_price . '</ShippingServiceAdditionalCost>';
                        $requestXmlBody .= '</ShippingServiceOptions>';
                        $requestXmlBody .= '</ShippingDetails>';


                        //Todo: SellerProfiles Policy
                        $requestXmlBody .= '<SellerProfiles>';

                        if ($product->payment_policy != null) {
                            $requestXmlBody .= '<SellerPaymentProfile>';
                            $requestXmlBody .= '<PaymentProfileID>' . $product->payment_policy->policy_id . '</PaymentProfileID>';
                            $requestXmlBody .= '<PaymentProfileName>' . $product->payment_policy->name . '</PaymentProfileName>';
                            $requestXmlBody .= '</SellerPaymentProfile>';
                        }

                        if ($product->return_policy != null) {
                            $requestXmlBody .= '<SellerReturnProfile>';
                            $requestXmlBody .= '<ReturnProfileID>' . $product->return_policy->policy_id . '</ReturnProfileID>';
                            $requestXmlBody .= '<ReturnProfileName>' . $product->return_policy->name . '</ReturnProfileName>';
                            $requestXmlBody .= '</SellerReturnProfile>';
                        }

                        if ($product->shipping_policy != null) {
                            $requestXmlBody .= '<SellerShippingProfile>';
                            $requestXmlBody .= '<ShippingProfileID>' . $product->shipping_policy->policy_id . '</ShippingProfileID>';
                            $requestXmlBody .= '<ShippingProfileName>' . $product->shipping_policy->name . '</ShippingProfileName>';
                            $requestXmlBody .= '</SellerShippingProfile>';
                        }
                        $requestXmlBody .= '</SellerProfiles>';
                        //Todo: SellerProfiles Policy

                        //Todo: ShippingPackageDetails
                        $requestXmlBody .= '<ShippingPackageDetails>';
                        $requestXmlBody .= '<MeasurementUnit>English</MeasurementUnit>';
						
						$irregular_package=0;

                        $requestXmlBody .= '<PackageDepth unit="inches" measurementSystem="English">' . $product->package_dimensions_height . '</PackageDepth>';
                        $requestXmlBody .= '<PackageLength unit="inches" measurementSystem="English">' . $product->package_dimensions_length . '</PackageLength>';
                        $requestXmlBody .= '<PackageWidth unit="inches" measurementSystem="English">' . $product->package_dimensions_width . '</PackageWidth>';
                        $requestXmlBody .= '<ShippingIrregular>' . $irregular_package . '</ShippingIrregular>';
                        $requestXmlBody .= '<ShippingPackage>' . $product->package_type . '</ShippingPackage>';
                        $requestXmlBody .= '<WeightMajor unit="lbs" measurementSystem="English">' . $product->package_weight . '</WeightMajor>';
                        $requestXmlBody .= '<WeightMinor unit="oz" measurementSystem="English">0</WeightMinor>';

                        $requestXmlBody .= '</ShippingPackageDetails>';
                        //Todo: ShippingPackageDetails


                        //Todo: Item Location
                        $requestXmlBody .= '<Country>' . $product->country . '</Country>';
                        $requestXmlBody .= '<Location>' . $product->city_or_state . '</Location>';
                        $requestXmlBody .= '<PostalCode>' . $product->zip_code . '</PostalCode>';
                        //Todo: Item Location


                        $requestXmlBody .= '<ReturnPolicy>';
                        $requestXmlBody .= '<ReturnsAcceptedOption>ReturnsAccepted</ReturnsAcceptedOption>';
                        $requestXmlBody .= '<ReturnsWithinOption>Days_30</ReturnsWithinOption>';
                        $requestXmlBody .= '<ShippingCostPaidByOption>Buyer</ShippingCostPaidByOption>';
                        $requestXmlBody .= '</ReturnPolicy>';

                        $requestXmlBody .= '<Site>US</Site>';
                        $requestXmlBody .= '</Item>';
                        $requestXmlBody .= '</ReviseItemRequest>';
                        //send the request and get response
                        $callname = 'ReviseItem';
                        //return [$requestXmlBody, $userToken, $callname];
						

                        $responseXml = $this->sendHttpRequest($requestXmlBody, $userToken, $callname);
                        $response = $this->xmlToArray($responseXml);
						
						
                        if ($response['Ack'] != 'Failure') {
                            $item_id = $response['ItemID'] ?? '';
                            if (!empty($item_id)) {
                                $productUpdate = Product::where('id', '=', $product->id)->first();
                                if ($productUpdate) {
                                  
								
                                
									$this->error_report('ebay',$id,'Successfully update to eBay. eBay ID:'.$item_id);
									
                                }
                            }
							
							 $responseData = [
                            [
                                'success' => true,
                                'response' => $response,
                            ]
                        ];

							
							
                        }
						else
						{
							$this->error_report('ebay',$id,$response);
							 $responseData = [
                            [
                                'success' => false,
                                'response' => $response,
                            ]
                        ];

						}

                        //return response()->json(['success' => true, '$response' => $response, 'message' => 'Ebay product update successfully', 'status' => 200]);
                       
                        // return response()->json(['response_data' => $responseData, 'status' => 200]);
						

                        return $responseData;

                        //return response()->json(['success' => true, '$response' => $response, 'message' => 'Ebay product update successfully', 'status' => 200]);
                        /*return [
                            'success' => true,
                            'response' => $response,
                            'responseXml' => $responseXml,
                            'requestXmlBody' => $requestXmlBody,
                            'product' => $product,
                            'productUpdate' => isset($productUpdate),
                            'ebay_product_status' => isset($ebay_product_status),
                        ];*/
                    } else {
                        // return response()->json(['success' => false, 'message' => 'Ebay Product id not found', 'status' => 200]);
						
						//error report
						$this->error_report('ebay',$id,'Ebay Update case:1- Product not found');

                        return [
                          'success' => false,
                          'message' => 'Ebay Product not found'
                        ];
                    }
                } else {
                    // return response()->json(['success' => false, 'message' => 'Products not found', 'status' => 404]);
					$this->error_report('ebay',$id,'Ebay Update case:2- Product not found');

                    return [
                  'success' => false,
                  'message' => 'Product not found'
                ];
                }
            } else {
                // return response()->json(['success' => false, 'message' => 'Product id not found', 'status' => 404]);
				$this->error_report('ebay',$id,'Ebay Update case:3- Product not found');

                return [
                  'success' => false,
                  'message' => 'Product not found'
                ];
            }
        } else {
            // return response()->json(['success' => false, 'message' => 'Authtoken not found', 'status' => 404]);
			$this->error_report('ebay',$id,"Update-eBay account not connected.");
            return [
              'success' => false,
              'message' => "eBay account not connected. Set your eBay connection by going into Fbmfox's Account settings and select 'eBay Settings' to connect."
            ];
        }
    }
	
	 public function error_report($market,$id, $msg)
    {
		
		/*$modelProduct = Product::where('id', '=', $id)->first();
		if($modelProduct)
		{
			$modelProduct->error_report=json_encode(array(''.$market=>$msg));
			$modelProduct->save();
		
		}*/
		$modelProduct = Product::where('id', '=', $id)->first();
		if($modelProduct)
		{		
			if($modelProduct->error_report)
			{
				$error_report=json_decode($modelProduct->error_report,true);			
				$error_report[$market]=$msg;
				
				
			}
			else
			{
				$error_report[$market]=$msg;
			}
		
		
			$modelProduct->error_report=json_encode($error_report);
			$modelProduct->save();
		
		}
		
		
	}

    public function xmlToArray($xmlstr)
    {
        $xml = simplexml_load_string($xmlstr, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $arrayData = json_decode($json, TRUE);
        return $arrayData;
    }

    public function sendHttpRequest($requestBody, $token, $callname)
    {
        //build eBay headers using variables passed via constructor
        $headers = $this->buildEbayHeaders($token, $callname);
        //initialise a CURL session
        $connection = curl_init();
        curl_setopt($connection, CURLOPT_URL, $this->serverUrl);
        curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($connection, CURLOPT_POST, 1);
        curl_setopt($connection, CURLOPT_POSTFIELDS, $requestBody);
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($connection);
        curl_close($connection);
        return $response;
    }

    public function __curl($url, $token, $method = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (empty($method)) {
            $method = 'GET';
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        $headers = array();
        $headers[] = 'Authorization: Bearer ' . $token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return json_decode($result);
    }

    public function getToken($isAuth = true,$user_id=0)
    {
        $this->userToken = '';
		if($isAuth) {
            $user = Auth::user();  
        } else {
            $user = User::find($user_id);
        }

    

        $ebay_credential = EbayCredential::where('user_id', $user->id)->first();
        if ($ebay_credential) {
            $paypalEmail = $ebay_credential->paypal_email;
            if ($paypalEmail) {
				
                $generate_time = $ebay_credential->updated_at; // 2021-04-26T12:20:49.000000Z
                $expired_time = date('Y-m-d H:i:s', strtotime($generate_time . '7200 second')); // 18:45 // 3600 not working add second specific //19:45 donw
                $current_time = date('Y-m-d H:i:s'); // 2021-04-26 12:56:47
                if ($current_time > $expired_time) {
                    //Token Expired
				
                    $ebay_credential = $this->getNewAccessTokenByAdmin($ebay_credential->refresh_token,$isAuth,$user_id);
                }
				
                $this->userToken = $ebay_credential->access_token;
            }
        }
        return $this->userToken;
    }

    public function getNewAccessTokenByAdmin($refresh_token,$isAuth = true,$user_id=0)
    {
        $newAccessToken = $this->callGetAccessTokenUsingRefreshToken($refresh_token);
        $ebayCallResponseArray = json_decode($newAccessToken, true);
        

        if (isset($ebayCallResponseArray['error'])) {
           // dd($ebayCallResponseArray);
        }

		
		if($isAuth) {
            $user = Auth::user();  
        } else {
			if($user_id>0)
            	$user = User::find($user_id);
			else
				$user = Auth::user();  
				
        }
		
       

        $ebay_credentials = EbayCredential::where('user_id', $user->id)->first();
        if ($ebay_credentials) {
            $ebay_credentials->access_token = $ebayCallResponseArray['access_token'];
            $ebay_credentials->expires_in = 7200;
            $ebay_credentials->save();
        }
        return $ebay_credentials;
    }

    public function callGetAccessTokenUsingRefreshToken($refresh_token)
    {
        $clientID = $this->appId;
        $clientSecret = $this->certId;
		 if($this->environment=='sandbox')
		 	$url = 'https://api.sandbox.ebay.com/identity/v1/oauth2/token';
		 else
       		 $url = 'https://api.ebay.com/identity/v1/oauth2/token';
       

        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode($clientID . ':' . $clientSecret)
        ];
		
		if($this->environment=='sandbox')
		{
			
			  $body = http_build_query([
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token,
            'scope' => '',
        ]);
		
		/*https://api.sandbox.ebay.com/oauth/api_scope https://api.sandbox.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.sandbox.ebay.com/oauth/api_scope/sell.marketing https://api.sandbox.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.sandbox.ebay.com/oauth/api_scope/sell.inventory https://api.sandbox.ebay.com/oauth/api_scope/sell.account.readonly https://api.sandbox.ebay.com/oauth/api_scope/sell.account https://api.sandbox.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.sandbox.ebay.com/oauth/api_scope/sell.fulfillment https://api.sandbox.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.sandbox.ebay.com/oauth/api_scope/sell.finances https://api.sandbox.ebay.com/oauth/api_scope/sell.payment.dispute https://api.sandbox.ebay.com/oauth/api_scope/commerce.identity.readonly*/
			
		}
		else
		{
        $body = http_build_query([
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token,
            'scope' => 'https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/commerce.identity.readonly',
        ]);
		
		}

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

    public function buildEbayHeaders($token, $callname)
    {
        $headers = array(
            //Regulates versioning of the XML interface for the API
            'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $this->compatabilityLevel,

            //set the keys
            'X-EBAY-API-IAF-TOKEN:' . $token,
            'X-EBAY-API-DEV-NAME: ' . $this->devId,
            'X-EBAY-API-APP-NAME: ' . $this->appId,
            'X-EBAY-API-CERT-NAME: ' . $this->certId,

            //the name of the call we are requesting
            'X-EBAY-API-CALL-NAME: ' . $callname,

            //SiteID must also be set in the Request's XML
            //SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
            //SiteID Indicates the eBay site to associate the call with
            'X-EBAY-API-SITEID: ' . $this->siteId,
            'X-EBAY-API-IAF-TOKEN' . $this->userToken
        );

        return $headers;
    }
	
	public function GetSuggestedCategories($query,$user_id)
    {
		
		  $userToken = $this->getToken(false,$user_id);
            if ($userToken) {
				
				
					$requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
					$requestXmlBody .= '<GetSuggestedCategoriesRequest  xmlns="urn:ebay:apis:eBLBaseComponents">';
		
					$requestXmlBody .= "<RequesterCredentials ><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
					$requestXmlBody .= '<ErrorLanguage>en_US</ErrorLanguage>';
					$requestXmlBody .= '<WarningLevel>High</WarningLevel>';
					$requestXmlBody .= '<Version>' . $this->compatabilityLevel . '</Version>';
					 $requestXmlBody .= ' 
					<Query>'.$query.'</Query>
					
				</GetSuggestedCategoriesRequest>';		
				 $callname = 'GetSuggestedCategories';
	 
							$responseXml = $this->sendHttpRequest($requestXmlBody, $userToken, $callname);
							$response = $this->xmlToArray($responseXml);
							if(isset($response['SuggestedCategoryArray']['SuggestedCategory']))
							{
								$arr=$response['SuggestedCategoryArray']['SuggestedCategory'];
								
								if ($response['Ack'] != 'Failure') {
								
									if(isset($response['SuggestedCategoryArray']['SuggestedCategory']))
									 return $response['SuggestedCategoryArray']['SuggestedCategory'];
									else 
									 return false;
								}
							
							}
							else
							return false;
							
						}
						
			
		
	}

    public function getCategories()
    {
        $userToken = $this->getToken();
        if (!empty($userToken)) {
			if($this->environment=='sandbox')
			 $url = 'https://api.sandbox.ebay.com/commerce/taxonomy/v1/category_tree/0';
			else
            $url = 'https://api.ebay.com/commerce/taxonomy/v1/category_tree/0';
            $getCategory = $this->__curl($url, $userToken, 'GET');
            //return [gettype($getCategory), $getCategory];
            return $getCategory->rootCategoryNode->childCategoryTreeNodes;
//            return [$getCategory];
            //return response()->json(['data' => $getCategory]);
            //echo "<PRE>";print_r($getCategory);exit;
        }
    }
	
	public function saveCategories()
    {
		$categories=$this->getCategories();
		
		foreach($categories as $cat)
		{
			
			$data=$this->GetChildCategories($cat);
			
			
		}
		
		
		
	}
	public function GetChildCategories($cat,$label="")
    {
			
			$label.=$cat->category->categoryName.'>';
			
			if(isset($cat->childCategoryTreeNodes))
			{
				
				foreach($cat->childCategoryTreeNodes as $cat2)
					$this->GetChildCategories($cat2,$label);
			}
			else
			{
				 $model = EbayCategory::where('category_id', $cat->category->categoryId)->first();
                 if (!$model) {
					$model=new EbayCategory;
					$model->category_id=$cat->category->categoryId;
					$model->name=rtrim($label, ">");
					$model->status=1;
					$model->save();
					
				 }
				return;
				
			}
			
		return ;
		
		
	}
	

    public function getShippingPolicy($user_id=0)
    {
        $userToken = $this->getToken();
        if (!empty($userToken)) {
			EbayShippingPolicy::where('user_id', $user_id)->delete();
           
            if($this->environment=='sandbox')
				$url = 'https://api.sandbox.ebay.com/sell/account/v1/fulfillment_policy?marketplace_id=EBAY_US';
			else
				$url = 'https://api.ebay.com/sell/account/v1/fulfillment_policy?marketplace_id=EBAY_US';
				
            $getShippingPolicy = $this->__curl($url, $userToken, 'GET');
            if (isset($getShippingPolicy->fulfillmentPolicies)) {
                $policies = $getShippingPolicy->fulfillmentPolicies;
                $countOfResponse = count($policies);
                if ($countOfResponse > 0) {
                    // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                    // ShippingPolicy::truncate();
                    // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                    foreach ($policies as $policy) {

                        $id = $policy->fulfillmentPolicyId;
						$shipping_policy = EbayShippingPolicy::where('user_id', $user_id)->where('policy_id', $id)->first();						
						if (!$shipping_policy) {		
							$name = $policy->name;
							$shipping_policy = new EbayShippingPolicy();
							$shipping_policy->policy_id = $id;
							$shipping_policy->name = $name;
							$shipping_policy->user_id = $user_id;
							$shipping_policy->save();
						
						}
                    }
                }
                return [$countOfResponse];
            }
            return [gettype($getShippingPolicy), $getShippingPolicy];
        }
    }

    public function getPaymentPolicy($user_id=0)
    {
        $userToken = $this->getToken();
        if (!empty($userToken)) {
			EbayPaymentPolicy::where('user_id', $user_id)->delete();
              if($this->environment=='sandbox')
			  	$url = 'https://api.sandbox.ebay.com/sell/account/v1/payment_policy?marketplace_id=EBAY_US';
			  else
           		 $url = 'https://api.ebay.com/sell/account/v1/payment_policy?marketplace_id=EBAY_US';
            $getPaymentPolicy = $this->__curl($url, $userToken, 'GET');
            //return [gettype($getPaymentPolicy), $getPaymentPolicy];
            if (isset($getPaymentPolicy->paymentPolicies)) {
                $policies = $getPaymentPolicy->paymentPolicies;

                $countOfResponse = count($policies);

                if ($countOfResponse > 0) {
                    // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                    // PaymentPolicy::truncate();
                    // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                    foreach ($policies as $policy) {
                        $id = $policy->paymentPolicyId;
							$payment_policy = EbayPaymentPolicy::where('user_id', $user_id)->where('policy_id', $id)->first();						
						if (!$payment_policy) {		
							$name = $policy->name;
							
							$payment_policy = new EbayPaymentPolicy();
							$payment_policy->policy_id = $id;
							$payment_policy->user_id = $user_id;
							$payment_policy->name = $name;
							$payment_policy->save();
						}
                    }
                }
                return [$countOfResponse];
            }
        }
    }

    public function getReturnPolicy($user_id=0)
    {
		
        $userToken = $this->getToken();
		
        if (!empty($userToken)) {
			EbayReturnPolicy::where('user_id', $user_id)->delete();
           
		    if($this->environment=='sandbox')
				$url = 'https://api.sandbox.ebay.com/sell/account/v1/return_policy?marketplace_id=EBAY_US';
			else
            	$url = 'https://api.ebay.com/sell/account/v1/return_policy?marketplace_id=EBAY_US';
            $getReturnPolicy = $this->__curl($url, $userToken, 'GET');			
			
			
            //return [$getReturnPolicy]; //return [gettype($getReturnPolicy), $getReturnPolicy];
            if (isset($getReturnPolicy->returnPolicies)) {
                $policies = $getReturnPolicy->returnPolicies;
                $countOfResponse = count($policies);
                if ($countOfResponse > 0) {
                    // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                    // ReturnPolicy::truncate();
                    // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                    foreach ($policies as $policy) {

                        $id = $policy->returnPolicyId;
						$return_policy = EbayReturnPolicy::where('user_id', $user_id)->where('policy_id', $id)->first();						
						if (!$return_policy) {					
							$name = $policy->name;
							$return_policy = new EbayReturnPolicy();
							$return_policy->policy_id = $id;
							$return_policy->user_id = $user_id;
							$return_policy->name = $name;
							$return_policy->save();
						}
                    }
                }
                return [$countOfResponse];
            }

        }
    }
	 public function fetchProductNew($id = '',$isAuth=true,$user_id=0)
    {
		if($isAuth) {
            $user = Auth::user();  
        } else {
            $user = User::find($user_id);
        }
		
        $userToken = $this->getToken($isAuth,$user_id);
		
        $startDate = date('Y-m-d', strtotime('-119 days')) . 'T' . date('H:i:s') . '.420Z'; //2022-01-25T08:39:40.420Z
        $endDate = date('Y-m-d') . 'T' . date('H:i:s') . '.420Z'; //2022-02-01T08:39:50.420Z
        $lastpage = false;
        $dataProducts = array();
        $t = 0;
        $pageno = 1;
		
        if (!empty($userToken)) {
            if (!empty($id)) {
                $query = '?q=' . $id . '&limit=100&offset=0';
			  if($this->environment=='sandbox')
              	 $url = 'https://api.sandbox.ebay.com/sell/inventory/v1/inventory_item?listingId=' . $query;
			   else
			    $url = 'https://api.ebay.com/sell/inventory/v1/inventory_item?listingId=' . $query;
                //https://www.ebay.com/sh/lst/active?catType=ebayCategories&q_field1=listingId&q_op1=EQUAL&q_value1=373911892051&action=search
				
            } else {
                $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
                $requestXmlBody .= '<GetSellerListRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                    <ErrorLanguage>en_US</ErrorLanguage>';
                $requestXmlBody .= '<WarningLevel>High</WarningLevel>';
                $requestXmlBody .= '<GranularityLevel>Coarse</GranularityLevel>';
                $requestXmlBody .= '<StartTimeFrom>' . $startDate . '</StartTimeFrom>';
                $requestXmlBody .= '<StartTimeTo>' . $endDate . '</StartTimeTo>';
                $requestXmlBody .= '<IncludeWatchCount>true</IncludeWatchCount>';
                $requestXmlBody .= '<Pagination>
                    <EntriesPerPage>' . $this->limit . '</EntriesPerPage>
                    <PageNumber>' . $pageno . '</PageNumber>
                  </Pagination>
                </GetSellerListRequest>';
                $callname = 'GetSellerList';
                $responseXml = $this->sendHttpRequest($requestXmlBody, $userToken, $callname);


                $productData = $this->xmlToArray($responseXml);
				
                //return [$productData['ItemArray']];
                array_push($dataProducts, $productData['ItemArray']);

                //return$dataProduct;

                $t++;
                $pageno++;


                if ($productData['Ack'] == 'Success') {
                    $pages = $productData['PaginationResult']['TotalNumberOfPages'];
                    if ($pages > 1) {
                        for ($g = 2; $g <= $pages; $g++) {
                            $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
                            $requestXmlBody .= '<GetSellerListRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                <ErrorLanguage>en_US</ErrorLanguage>';
                            $requestXmlBody .= '<WarningLevel>High</WarningLevel>';
                            $requestXmlBody .= '<GranularityLevel>Coarse</GranularityLevel>';
                            $requestXmlBody .= '<StartTimeFrom>' . $startDate . '</StartTimeFrom>';
                            $requestXmlBody .= '<StartTimeTo>' . $endDate . '</StartTimeTo>';
                            $requestXmlBody .= '<IncludeWatchCount>true</IncludeWatchCount>';
                            $requestXmlBody .= '<Pagination>
                                <EntriesPerPage>' . $this->limit . '</EntriesPerPage>
                                <PageNumber>' . $pageno . '</PageNumber>
                              </Pagination>
                            </GetSellerListRequest>';
                            $callname = 'GetSellerList';
                            $responseXml = $this->sendHttpRequest($requestXmlBody, $userToken, $callname);
                            $productData = $this->xmlToArray($responseXml);
                            array_push($dataProducts, $productData['ItemArray']);
                            $t++;
                            $pageno++;
                        }
                    }
                }
				
                //return [$productData];
                //echo "<PRE>";print_r($productData);exit;
            }
            //return $dataProducts;

            $productStoreInfoArraySuccess = [];
            $productStoreInfoArrayError = [];
			
         

            //return $dataProducts;
            if (!empty($dataProducts)) {
                $activeProductStore = [];
                foreach ($dataProducts as $dataProduct) {
                    //return $dataProduct;
                    //return $dataProduct['Item']; //Array $dataProduct->Item
					
                    foreach ($dataProduct['Item'] as $product) {
						 $quantity = $product['Quantity'] ?? 0;
                        //return $product //strtolower(trim();
                        if (isset($product['SellingStatus']['ListingStatus'])) {
                            if ($product['SellingStatus']['ListingStatus']== 'Active') {
							   if($quantity>0){
								// || $product['SellingStatus']['ListingStatus'] == 'Completed' Active,Ended
                                $item_id = $product['ItemID'] ?? '';
                                if ($item_id) {
                                   
                                    //return [$product];
                                    $ebayCategoryId = $product['PrimaryCategory']['CategoryID'] ?? '';
                                    $ebayCategoryName = $product['PrimaryCategory']['CategoryName'] ?? '';
                                    if ($ebayCategoryId) {
                                        $checkCategory = EbayCategory::where('category_id', $ebayCategoryId)->first();
                                        if (!$checkCategory) {
                                            $checkCategory = new EbayCategory();
                                            $checkCategory->category_id = $ebayCategoryId;
                                            $checkCategory->name = $ebayCategoryName != '' ? str_replace(':', ' > ', $ebayCategoryName) : '';
                                            $checkCategory->status = 1;
                                            $checkCategory->save();
                                        }
                                    }
									
									
									
                                    $categoryId = $checkCategory->id;
									
									
									

                                    $title = $product['Title'] ?? '';
                                    $sku = $product['SKU'] ?? null;

                                    $description = $product['Description'] ?? '';
                                   
                                    $price = $product['SellingStatus']['CurrentPrice'] ?? 0;

                                    $brand = $product['ProductListingDetails']['BrandMPN']['Brand'] ?? null;
                                    //$MPN = $product['ProductListingDetails']['BrandMPN']['MPN'] ?? null;

                                    $item_specific = '';
                                    if (isset($product['ItemSpecifics']['NameValueList'])) {
                                        $ItemSpecifics = json_decode(json_encode($product['ItemSpecifics']));
                                        if (gettype($ItemSpecifics->NameValueList) == 'object') {
                                            if (isset($ItemSpecifics->NameValueList->Name)) {
                                                $key = $ItemSpecifics->NameValueList->Name;
                                                $value = $ItemSpecifics->NameValueList->Value;
                                                $item_specific_array = [];
                                                $item_specific_array[$key] = $value;
                                                $item_specific = json_encode($item_specific_array);
                                            }
                                        } else if (gettype($ItemSpecifics->NameValueList) == 'array') {
                                            $item_specific_array = [];
                                            foreach ($ItemSpecifics->NameValueList as $itemSpecific) {
                                                $key = $itemSpecific->Name;
                                                $value = $itemSpecific->Value;
                                                $item_specific_array[$key] = $value;
                                            }
                                            $item_specific = json_encode($item_specific_array);
                                        }
                                    }

                                    //return [$item_specific, $product];

                                    $UPC = $product['ProductListingDetails']['UPC'] ?? null;

                                    //$picture_url = isset($product['PictureDetails']['PictureURL']) ? (gettype($product['PictureDetails']['PictureURL']) == 'string' ? $product['PictureDetails']['PictureURL'] : (gettype($product['PictureDetails']['PictureURL']) == 'array' ? $product['PictureDetails']['PictureURL'][0] : "")) : "";
                                    if (isset($product['PictureDetails']['PhotoDisplay'])) {
                                        if ($product['PictureDetails']['PhotoDisplay'] == 'PicturePack') {
                                            $picture_url = isset($product['PictureDetails']['PictureURL']) ? (gettype($product['PictureDetails']['PictureURL']) == 'string' ? $product['PictureDetails']['PictureURL'] : (gettype($product['PictureDetails']['PictureURL']) == 'array' ? $product['PictureDetails']['PictureURL'][0] : "")) : "";
                                        } else if (isset($product['PictureDetails']['GalleryURL'])) {
                                            $picture_url = isset($product['PictureDetails']['GalleryURL']) ? (gettype($product['PictureDetails']['GalleryURL']) == 'string' ? $product['PictureDetails']['GalleryURL'] : (gettype($product['PictureDetails']['GalleryURL']) == 'array' ? $product['PictureDetails']['GalleryURL'][0] : "")) : "";
                                        }
                                    }
                                    //$picture_url = $product['PictureDetails']['PictureURL'];

                                    $shipping_policy_id = null;
                                    $return_policy_id = null;
                                    $payment_policy_id = null;

                                    $ShippingProfileID = $product['SellerProfiles']['SellerShippingProfile']['ShippingProfileID'] ?? '';
                                    $ReturnProfileID = $product['SellerProfiles']['SellerReturnProfile']['ReturnProfileID'] ?? '';
                                    $PaymentProfileID = $product['SellerProfiles']['SellerPaymentProfile']['PaymentProfileID'] ?? '';

                                    if ($ShippingProfileID) {
                                        $ShippingPolicy = EbayShippingPolicy::where('policy_id', '=', $ShippingProfileID)->first();
                                        if (!$ShippingPolicy) {
                                            $ShippingPolicy = new EbayShippingPolicy();
                                            $ShippingPolicy->policy_id = $ShippingProfileID;
                                            $ShippingPolicy->name = $product['SellerProfiles']['SellerShippingProfile']['ShippingProfileName'] ?? '';
                                            $ShippingPolicy->save();
                                        }
                                        $shipping_policy_id = $ShippingPolicy->id;
                                    }

                                    if ($ReturnProfileID) {
                                        $ReturnPolicy = EbayReturnPolicy::where('policy_id', '=', $ReturnProfileID)->first();
                                        if (!$ReturnPolicy) {
                                            $ReturnPolicy = new EbayReturnPolicy();
                                            $ReturnPolicy->policy_id = $ReturnProfileID;
                                            $ReturnPolicy->name = $product['SellerProfiles']['SellerReturnProfile']['ReturnProfileName'] ?? '';
                                            $ReturnPolicy->save();
                                        }
                                        $return_policy_id = $ReturnPolicy->id;
                                    }

                                    if ($PaymentProfileID) {
                                        $PaymentPolicy = EbayPaymentPolicy::where('policy_id', '=', $PaymentProfileID)->first();
                                        if (!$PaymentPolicy) {
                                            $PaymentPolicy = new EbayPaymentPolicy();
                                            $PaymentPolicy->policy_id = $PaymentProfileID;
                                            $PaymentPolicy->name = $product['SellerProfiles']['SellerPaymentProfile']['PaymentProfileName'] ?? '';
                                            $PaymentPolicy->save();
                                        }
                                        $payment_policy_id = $PaymentPolicy->id;
                                    }


                                    $package_type = $product['ShippingPackageDetails']['ShippingPackage'] ?? '';
                                    $package_dimensions_length = $product['ShippingPackageDetails']['PackageLength'] ?? '';
                                    $package_dimensions_width = $product['ShippingPackageDetails']['PackageWidth'] ?? '';
                                    $package_dimensions_height = $product['ShippingPackageDetails']['PackageDepth'] ?? '';

                                    $irregular_package = $product['ShippingPackageDetails']['ShippingIrregular'] ?? false;
                                    $package_weight_major = $product['ShippingPackageDetails']['WeightMajor'] ?? '0';
                                    $package_weight_minor = $product['ShippingPackageDetails']['WeightMinor'] ?? '0';

                                    $package_weight = $package_weight_major . '.' . $package_weight_minor;

                                    $country = $product['Country'] ?? '';
                                    $zip_code = $product['PostalCode'] ?? '';
                                    $city_or_state = $product['Location'] ?? '';

                                   // $user = Auth::user();
									

                                    $productStore = Product::where('vendor_id', $user->id)->where('ebay_product_id', $item_id)->first();
                                    if (!$productStore) {
                                        $productStore = new Product();
                                    }

                                    $productStore->vendor_id = $user->id;
                                    $productStore->ebay_category_id = $categoryId;

                                   // $productStore->item_tag ='https://www.ebay.com/itm/'. $item_id;
                                    $productStore->name = $title;
                                     $productStore->sku = $sku;

                                    $productStore->description = $description;
									$productStore->sale_price=$productStore->mrp_price=$productStore->product_price = $price;

                                 

									//$productStore->supplierStock = 'Out of stock';
                                    $productStore->stock = $quantity;

                                   // ehub category id fetch
									$arr=explode(':', $ebayCategoryName);
									if(isset($arr[0]))
									{
										$cat_name=trim($arr[0]);
										$category = \App\Models\Category::where('name','=',$cat_name)->first();
										if($category){
											$productStore->category_id=$category->id;
										}
										else
										{
											$cat_name='Cell Phones & Accessories';
											$sql="SELECT * FROM categories WHERE '".$cat_name."' LIKE CONCAT('%',`name`, '%') limit 1";
											$result=DB::select($sql);
											if(isset($result[0]->id))
												$productStore->category_id=$result[0]->id;
											
											
										}
										
									}
									

                                    $productStore->brand = $brand;
                                    //$productStore->MPN = $MPN;
                                   // $productStore->UPC = $UPC;
                                    //$productStore->item_specifics = $item_specific;

                                    $productStore->return_policy_id = $return_policy_id;
                                    $productStore->payment_policy_id = $payment_policy_id;
                                    $productStore->shipping_policy_id = $shipping_policy_id;

                                    $productStore->package_type = $package_type;
                                    $productStore->package_dimensions_length = $package_dimensions_length;
                                    $productStore->package_dimensions_width = $package_dimensions_width;
                                    $productStore->package_dimensions_height = $package_dimensions_height;
                                   // $productStore->irregular_package = $irregular_package == 'true' ? 1 : 0;
                                    $productStore->package_weight = (float)$package_weight;

                                    $productStore->country = $country;
                                    $productStore->zip_code = $zip_code;
                                    $productStore->city_or_state = $city_or_state;

                                    $productStore->image = $picture_url;
									$productStore->is_uploaded=1;
									$productStore->status='approved';

                                    // $productStore->status = 1;

                                    $productStore->ebay_product_id = $item_id;
                                   if($this->environment=='sandbox')
                                   	 $productStore->ebay_product_url ='https://www.sandbox.ebay.com/itm/'. $item_id;
									else
										$productStore->ebay_product_url ='https://www.ebay.com/itm/'. $item_id;
										 
                                    $productStore->save();

                                    array_push($activeProductStore, [$product, $productStore]);
									

                                 
                                    array_push($productStoreInfoArraySuccess, $productStore);
                                } else {
                                    array_push($productStoreInfoArrayError, '$item_id null');
                                }
                            } 
							
							
						   }
						   
						}
						else {
                                array_push($productStoreInfoArrayError, ['item_id' => $product['ItemID'] ?? '', 'ListingStatus' => $product['SellingStatus']['ListingStatus'] ?? 'null']);
                            }
                        }
                   // }
                }


                return [
                    'success' => true,
                    '$productStoreInfoArraySuccess' => $productStoreInfoArraySuccess,
                    '$productStoreInfoArrayError' => $productStoreInfoArrayError
                ];
            } else {
                return response()->json(['message' => 'Products not found', 'status' => 404]);
            }
        } else {
            return response()->json(['message' => 'Authtoken not found', 'status' => 404]);
        }
    }
	
	public function getItemDetails($isAuth=true,$user_id=0)
	{
		if($isAuth) {
            $user = Auth::user();  
        } else {
            $user = User::find($user_id);
        }
		
        $userToken = $this->getToken($isAuth,$user_id);
		
		$sql="select category_id,ebay_product_id from products where category_id is null limit 100";
		$rows=DB::select($sql);
		foreach($rows as $row)
		{
			$item_id=$row->ebay_product_id;
			
		
		 if ($item_id) {
				$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
				$requestXmlBody .= '<GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';

				$requestXmlBody .= '<RequesterCredentials>';
				$requestXmlBody .= '<eBayAuthToken>' . $userToken . '</eBayAuthToken>';
				$requestXmlBody .= '</RequesterCredentials>';
				$requestXmlBody .= '<ErrorLanguage>en_US</ErrorLanguage>';
				$requestXmlBody .= '<WarningLevel>High</WarningLevel>';
				$requestXmlBody .= '<DetailLevel>ReturnAll</DetailLevel>';
				$requestXmlBody .= '<IncludeItemSpecifics>true</IncludeItemSpecifics>';
				//$requestXmlBody .= '<ItemID>373914763860</ItemID>';
				$requestXmlBody .= '<ItemID>' . $item_id . '</ItemID>';
				$requestXmlBody .= '</GetItemRequest>';

				$callname = 'GetItem';
				$responseXml = $this->sendHttpRequest($requestXmlBody, $userToken, $callname);
				$productData = $this->xmlToArray($responseXml);				
				if ($productData['Ack'] == 'Success') 
				{
					$product = $productData['Item'];
				
				}
				
					$productStore = Product::where('vendor_id', $user->id)->where('ebay_product_id', $item_id)->first();
					if ($productStore) {
					
					
				
					$ebayCategoryId = $product['PrimaryCategory']['CategoryID'] ?? '';
					$ebayCategoryName = $product['PrimaryCategory']['CategoryName'] ?? '';
					if ($ebayCategoryId) 
					{
						$checkCategory = EbayCategory::where('category_id', $ebayCategoryId)->first();
						if (!$checkCategory) 
						{
							$checkCategory = new EbayCategory();
							$checkCategory->category_id = $ebayCategoryId;
							$checkCategory->name = $ebayCategoryName != '' ? str_replace(':', ' > ', $ebayCategoryName) : '';
							$checkCategory->status = 1;
							$checkCategory->save();
						}
					}
					
					
					
				$categoryId = $checkCategory->id;
				
				$arr=explode(':', $ebayCategoryName);
				if(isset($arr[0]))
				{
					$cat_name=trim($arr[0]);
					$category = \App\Models\Category::where('name','=',$cat_name)->first();
					if($category){
						$productStore->category_id=$category->id;
					}
					else
					{
						$cat_name='Cell Phones & Accessories';
						$sql="SELECT * FROM categories WHERE '".$cat_name."' LIKE CONCAT('%',`name`, '%') limit 1";
						$result=DB::select($sql);
						if(isset($result[0]->id))
							$productStore->category_id=$result[0]->id;
						
						
					}
					
				}
				
				 $productStore->save();
				// dd('@'.$productStore->category_id);
									
									
					}
		 
		}
		
		}
		
	}
	
	
    public function fetchProductBackup($id = '',$isAuth=true,$user_id=0)
    {
        //EbayCategory::truncate();
        //Product::truncate();
        //Category::truncate();
        //SubCategory::truncate();
        //ChildCategory::truncate();

        if($isAuth) {
            $user = Auth::user();  
        } else {
            $user = User::find($user_id);
        }
        
        $userToken = $this->getToken($isAuth,$user_id);
        
        $startDate = date('Y-m-d', strtotime('-60 days')) . 'T' . date('H:i:s') . '.420Z'; //2022-01-25T08:39:40.420Z
        $endDate = date('Y-m-d') . 'T' . date('H:i:s') . '.420Z'; //2022-02-01T08:39:50.420Z
        $lastpage = false;
        $dataProducts = array();
        $t = 0;
        $pageno = 1;
        
        if (!empty($userToken)) {
            if (!empty($id)) {
                $query = '?q=' . $id . '&limit=100&offset=0';
              if($this->environment=='sandbox')
                 $url = 'https://api.sandbox.ebay.com/sell/inventory/v1/inventory_item?listingId=' . $query;
               else
                $url = 'https://api.ebay.com/sell/inventory/v1/inventory_item?listingId=' . $query;
                //https://www.ebay.com/sh/lst/active?catType=ebayCategories&q_field1=listingId&q_op1=EQUAL&q_value1=373911892051&action=search
                
            } else {
                $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
                $requestXmlBody .= '<GetSellerListRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                    <ErrorLanguage>en_US</ErrorLanguage>';
                $requestXmlBody .= '<WarningLevel>High</WarningLevel>';
                $requestXmlBody .= '<GranularityLevel>Coarse</GranularityLevel>';
                $requestXmlBody .= '<StartTimeFrom>' . $startDate . '</StartTimeFrom>';
                $requestXmlBody .= '<StartTimeTo>' . $endDate . '</StartTimeTo>';
                $requestXmlBody .= '<IncludeWatchCount>true</IncludeWatchCount>';
                $requestXmlBody .= '<Pagination>
                    <EntriesPerPage>' . $this->limit . '</EntriesPerPage>
                    <PageNumber>' . $pageno . '</PageNumber>
                  </Pagination>
                </GetSellerListRequest>';
                $callname = 'GetSellerList';
                $responseXml = $this->sendHttpRequest($requestXmlBody, $userToken, $callname);


                $productData = $this->xmlToArray($responseXml);
                //dd( $productData);
                //return [$productData['ItemArray']];
                array_push($dataProducts, $productData['ItemArray']);

                //return$dataProduct;

                $t++;
                $pageno++;


                if ($productData['Ack'] == 'Success') {
                    $pages = $productData['PaginationResult']['TotalNumberOfPages'];
                    if ($pages > 1) {
                        for ($g = 2; $g <= $pages; $g++) {
                            $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
                            $requestXmlBody .= '<GetSellerListRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                <ErrorLanguage>en_US</ErrorLanguage>';
                            $requestXmlBody .= '<WarningLevel>High</WarningLevel>';
                            $requestXmlBody .= '<GranularityLevel>Coarse</GranularityLevel>';
                            $requestXmlBody .= '<StartTimeFrom>' . $startDate . '</StartTimeFrom>';
                            $requestXmlBody .= '<StartTimeTo>' . $endDate . '</StartTimeTo>';
                            $requestXmlBody .= '<IncludeWatchCount>true</IncludeWatchCount>';
                            $requestXmlBody .= '<Pagination>
                                <EntriesPerPage>' . $this->limit . '</EntriesPerPage>
                                <PageNumber>' . $pageno . '</PageNumber>
                              </Pagination>
                            </GetSellerListRequest>';
                            $callname = 'GetSellerList';
                            $responseXml = $this->sendHttpRequest($requestXmlBody, $userToken, $callname);
                            $productData = $this->xmlToArray($responseXml);
                            array_push($dataProducts, $productData['ItemArray']);
                            $t++;
                            $pageno++;
                        }
                    }
                }
                //return [$productData];
                //echo "<PRE>";print_r($productData);exit;
            }
            //return $dataProducts;

            $productStoreInfoArraySuccess = [];
            $productStoreInfoArrayError = [];
            
         

            //return $dataProducts;
            if (!empty($dataProducts)) {
                $activeProductStore = [];
                foreach ($dataProducts as $dataProduct) {
                    //return $dataProduct;
                    //return $dataProduct['Item']; //Array $dataProduct->Item
                    
                    foreach ($dataProduct['Item'] as $product) {
                        //return $product //strtolower(trim();
                        if (isset($product['SellingStatus']['ListingStatus'])) {
                            if ($product['SellingStatus']['ListingStatus']== 'Active') {
                                $item_id = $product['ItemID'] ?? '';
                                $ChekPrd = Product::where("ebay_product_id", $item_id)->count();
                                if ($item_id && $ChekPrd == 0) {
                                    $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>';
                                    $requestXmlBody .= '<GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';

                                    $requestXmlBody .= '<RequesterCredentials>';
                                    $requestXmlBody .= '<eBayAuthToken>' . $userToken . '</eBayAuthToken>';
                                    $requestXmlBody .= '</RequesterCredentials>';
                                    $requestXmlBody .= '<ErrorLanguage>en_US</ErrorLanguage>';
                                    $requestXmlBody .= '<WarningLevel>High</WarningLevel>';
                                    $requestXmlBody .= '<DetailLevel>ReturnAll</DetailLevel>';
                                    $requestXmlBody .= '<IncludeItemSpecifics>true</IncludeItemSpecifics>';
                                    //$requestXmlBody .= '<ItemID>373914763860</ItemID>';
                                    $requestXmlBody .= '<ItemID>' . $item_id . '</ItemID>';
                                    $requestXmlBody .= '</GetItemRequest>';

                                    $callname = 'GetItem';
                                    $responseXml = $this->sendHttpRequest($requestXmlBody, $userToken, $callname);
                                    $productData = $this->xmlToArray($responseXml);

                                    if ($productData['Ack'] == 'Success') {
                                        $product = $productData['Item'];
                                        //return [$product , 'test'];
                                    }
                        
                                    //return [$product];
                                    $ebayCategoryId = $product['PrimaryCategory']['CategoryID'] ?? '';
                                    $ebayCategoryName = $product['PrimaryCategory']['CategoryName'] ?? '';
                                    if ($ebayCategoryId) {
                                        $checkCategory = EbayCategory::where('category_id', $ebayCategoryId)->first();
                                        if (!$checkCategory) {
                                            $checkCategory = new EbayCategory();
                                            $checkCategory->category_id = $ebayCategoryId;
                                            $checkCategory->name = $ebayCategoryName != '' ? str_replace(':', ' > ', $ebayCategoryName) : '';
                                            $checkCategory->status = 1;
                                            $checkCategory->save();
                                        }
                                    }

                                    $ExpCatName = explode(":", $ebayCategoryName);
                                    $MainCatID = 0;
                                    $SubCatID = 0;
                                    $ChildCatID = 0;

                                    if(isset($ExpCatName[0])){
                                        $CheckCategoryExists = Category::where("name", trim($ExpCatName[0]))->first();
                                        if(isset($CheckCategoryExists->id)){
                                            $MainCatID = $CheckCategoryExists->id;
                                        }else{
                                            $CatObj = new Category();
                                            $CatObj->name = trim($ExpCatName[0]);
                                            if(trim($ExpCatName[0]) == "Cell Phones & Accessories" || trim($ExpCatName[0]) == "Cameras & Photo"){
                                                $CatObj->home_screen = "yes";
                                            }
                                            $CatObj->slug = $this->slugify(trim($ExpCatName[0]));
                                            $CatObj->home_category = 1;
                                            $CatObj->save();
                                            $MainCatID = $CatObj->id;
                                        }
                                    }

                                    if(isset($ExpCatName[1])){
                                        $CheckCategoryExists = SubCategory::where("title", trim($ExpCatName[1]))->first();
                                        if(isset($CheckCategoryExists->id)){
                                            $SubCatID = $CheckCategoryExists->id;
                                        }else{
                                            $CatObj = new SubCategory();
                                            $CatObj->category_id = $MainCatID;
                                            $CatObj->title = trim($ExpCatName[1]);
                                            $CatObj->slug = $this->slugify(trim($ExpCatName[1]));
                                            $CatObj->save();
                                            $SubCatID = $CatObj->id;
                                        }
                                    }

                                    if(isset($ExpCatName[2])){
                                        $CheckCategoryExists = ChildCategory::where("name", trim($ExpCatName[2]))->first();
                                        if(isset($CheckCategoryExists->id)){
                                            $ChildCatID = $CheckCategoryExists->id;
                                        }else{
                                            $CatObj = new ChildCategory();
                                            $CatObj->category_id = $MainCatID;
                                            $CatObj->sub_category_id = $SubCatID;
                                            $CatObj->name = trim($ExpCatName[2]);
                                            $CatObj->slug = $this->slugify(trim($ExpCatName[2]));
                                            $CatObj->save();
                                            $ChildCatID = $CatObj->id;
                                        }
                                    }

                                    $categoryId = $ebayCategoryId;

                                    $title = $product['Title'] ?? '';
                                    $sku = $product['SKU'] ?? null;

                                    $description = $product['Description'] ?? '';
                                    $quantity = $product['Quantity'] ?? 0;
                                    $price = $product['SellingStatus']['CurrentPrice'] ?? 0;

                                    $brand = $product['ProductListingDetails']['BrandMPN']['Brand'] ?? null;
                                    //$MPN = $product['ProductListingDetails']['BrandMPN']['MPN'] ?? null;

                                    $item_specific = '';
                                    if (isset($product['ItemSpecifics']['NameValueList'])) {
                                        $ItemSpecifics = json_decode(json_encode($product['ItemSpecifics']));
                                        if (gettype($ItemSpecifics->NameValueList) == 'object') {
                                            if (isset($ItemSpecifics->NameValueList->Name)) {
                                                $key = $ItemSpecifics->NameValueList->Name;
                                                $value = $ItemSpecifics->NameValueList->Value;
                                                $item_specific_array = [];
                                                $item_specific_array[$key] = $value;
                                                $item_specific = json_encode($item_specific_array);
                                            }
                                        } else if (gettype($ItemSpecifics->NameValueList) == 'array') {
                                            $item_specific_array = [];
                                            foreach ($ItemSpecifics->NameValueList as $itemSpecific) {
                                                $key = $itemSpecific->Name;
                                                $value = $itemSpecific->Value;
                                                $item_specific_array[$key] = $value;
                                            }
                                            $item_specific = json_encode($item_specific_array);
                                        }
                                    }

                                    //return [$item_specific, $product];

                                    $UPC = $product['ProductListingDetails']['UPC'] ?? null;

                                    //$picture_url = isset($product['PictureDetails']['PictureURL']) ? (gettype($product['PictureDetails']['PictureURL']) == 'string' ? $product['PictureDetails']['PictureURL'] : (gettype($product['PictureDetails']['PictureURL']) == 'array' ? $product['PictureDetails']['PictureURL'][0] : "")) : "";
                                    if (isset($product['PictureDetails']['PhotoDisplay'])) {
                                        if ($product['PictureDetails']['PhotoDisplay'] == 'PicturePack') {
                                            $picture_url = isset($product['PictureDetails']['PictureURL']) ? (gettype($product['PictureDetails']['PictureURL']) == 'string' ? $product['PictureDetails']['PictureURL'] : (gettype($product['PictureDetails']['PictureURL']) == 'array' ? $product['PictureDetails']['PictureURL'][0] : "")) : "";
                                        } else if (isset($product['PictureDetails']['GalleryURL'])) {
                                            $picture_url = isset($product['PictureDetails']['GalleryURL']) ? (gettype($product['PictureDetails']['GalleryURL']) == 'string' ? $product['PictureDetails']['GalleryURL'] : (gettype($product['PictureDetails']['GalleryURL']) == 'array' ? $product['PictureDetails']['GalleryURL'][0] : "")) : "";
                                        }
                                    }
                                    //$picture_url = $product['PictureDetails']['PictureURL'];

                                    $shipping_policy_id = null;
                                    $return_policy_id = null;
                                    $payment_policy_id = null;

                                    $ShippingProfileID = $product['SellerProfiles']['SellerShippingProfile']['ShippingProfileID'] ?? '';
                                    $ReturnProfileID = $product['SellerProfiles']['SellerReturnProfile']['ReturnProfileID'] ?? '';
                                    $PaymentProfileID = $product['SellerProfiles']['SellerPaymentProfile']['PaymentProfileID'] ?? '';

                                    if ($ShippingProfileID) {
                                        $ShippingPolicy = EbayShippingPolicy::where('policy_id', '=', $ShippingProfileID)->first();
                                        if (!$ShippingPolicy) {
                                            $ShippingPolicy = new ShippingPolicy();
                                            $ShippingPolicy->policy_id = $ShippingProfileID;
                                            $ShippingPolicy->name = $product['SellerProfiles']['SellerShippingProfile']['ShippingProfileName'] ?? '';
                                            $ShippingPolicy->save();
                                        }
                                        $shipping_policy_id = $ShippingPolicy->id;
                                    }

                                    if ($ReturnProfileID) {
                                        $ReturnPolicy = EbayReturnPolicy::where('policy_id', '=', $ReturnProfileID)->first();
                                        if (!$ReturnPolicy) {
                                            $ReturnPolicy = new EbayReturnPolicy();
                                            $ReturnPolicy->policy_id = $ReturnProfileID;
                                            $ReturnPolicy->name = $product['SellerProfiles']['SellerReturnProfile']['ReturnProfileName'] ?? '';
                                            $ReturnPolicy->save();
                                        }
                                        $return_policy_id = $ReturnPolicy->id;
                                    }

                                    if ($PaymentProfileID) {
                                        $PaymentPolicy = EbayPaymentPolicy::where('policy_id', '=', $PaymentProfileID)->first();
                                        if (!$PaymentPolicy) {
                                            $PaymentPolicy = new EbayPaymentPolicy();
                                            $PaymentPolicy->policy_id = $PaymentProfileID;
                                            $PaymentPolicy->name = $product['SellerProfiles']['SellerPaymentProfile']['PaymentProfileName'] ?? '';
                                            $PaymentPolicy->save();
                                        }
                                        $payment_policy_id = $PaymentPolicy->id;
                                    }


                                    $package_type = $product['ShippingPackageDetails']['ShippingPackage'] ?? '';
                                    $package_dimensions_length = $product['ShippingPackageDetails']['PackageLength'] ?? '';
                                    $package_dimensions_width = $product['ShippingPackageDetails']['PackageWidth'] ?? '';
                                    $package_dimensions_height = $product['ShippingPackageDetails']['PackageDepth'] ?? '';

                                    $irregular_package = $product['ShippingPackageDetails']['ShippingIrregular'] ?? false;
                                    $package_weight_major = $product['ShippingPackageDetails']['WeightMajor'] ?? '0';
                                    $package_weight_minor = $product['ShippingPackageDetails']['WeightMinor'] ?? '0';

                                    $package_weight = $package_weight_major . '.' . $package_weight_minor;

                                    $country = $product['Country'] ?? '';
                                    $zip_code = $product['PostalCode'] ?? '';
                                    $city_or_state = $product['Location'] ?? '';

                                   // $user = Auth::user();
                                    

                                    $productStore = Product::where('vendor_id', $user->id)->where('ebay_product_id', $item_id)->first();
                                    if (!$productStore) {
                                        $productStore = new Product();
                                    }

                                    $productStore->vendor_id = $user->id;
                                    $productStore->ebay_category_id = $categoryId;
                                    $productStore->category_id = $MainCatID;
                                    $productStore->sub_category_id = $SubCatID;
                                    $productStore->child_category_id = $ChildCatID;

                                   // $productStore->item_tag ='https://www.ebay.com/itm/'. $item_id;
                                    $productStore->name = $title;
                                     $productStore->sku = $sku;

                                    $productStore->description = $description;
                                    $productStore->sale_price=$productStore->mrp_price=$productStore->product_price = $price;

                                 

                                    //$productStore->supplierStock = 'Out of stock';
                                    $productStore->stock = $quantity;

                                   

                                    $productStore->brand = $brand;
                                    //$productStore->MPN = $MPN;
                                   // $productStore->UPC = $UPC;
                                    //$productStore->item_specifics = $item_specific;

                                    $productStore->return_policy_id = $return_policy_id;
                                    $productStore->payment_policy_id = $payment_policy_id;
                                    $productStore->shipping_policy_id = $shipping_policy_id;

                                    $productStore->package_type = $package_type;
                                    $productStore->package_dimensions_length = $package_dimensions_length;
                                    $productStore->package_dimensions_width = $package_dimensions_width;
                                    $productStore->package_dimensions_height = $package_dimensions_height;
                                   // $productStore->irregular_package = $irregular_package == 'true' ? 1 : 0;
                                    $productStore->package_weight = (float)$package_weight;

                                    $productStore->country = $country;
                                    $productStore->zip_code = $zip_code;
                                    $productStore->city_or_state = $city_or_state;

                                    $productStore->image = $picture_url;
                                    $productStore->is_uploaded=1;
                                    $productStore->status='approved';

                                    // $productStore->status = 1;

                                    $productStore->ebay_product_id = $item_id;
                                   if($this->environment=='sandbox')
                                     $productStore->ebay_product_url ='https://www.sandbox.ebay.com/itm/'. $item_id;
                                    else
                                        $productStore->ebay_product_url ='https://www.ebay.com/itm/'. $item_id;
                                         
                                    $productStore->save();
                                    array_push($activeProductStore, [$product, $productStore]);
                                    array_push($productStoreInfoArraySuccess, $productStore);
                                } else {
                                    array_push($productStoreInfoArrayError, '$item_id null');
                                }
                            } else {
                                array_push($productStoreInfoArrayError, ['item_id' => $product['ItemID'] ?? '', 'ListingStatus' => $product['SellingStatus']['ListingStatus'] ?? 'null']);
                            }
                        }
                    }
                }


                return [
                    'success' => true,
                    '$productStoreInfoArraySuccess' => $productStoreInfoArraySuccess,
                    '$productStoreInfoArrayError' => $productStoreInfoArrayError
                ];
            } else {
                return response()->json(['message' => 'Products not found', 'status' => 404]);
            }
        } else {
            return response()->json(['message' => 'Authtoken not found', 'status' => 404]);
        }
    }
	
}
