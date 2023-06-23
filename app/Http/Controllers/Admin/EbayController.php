<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\EbayCredential;
use App\Models\Product;
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

    public function PostCarg(){
        $XML = '<?xml version="1.0"?>

<rdf:RDF xmlns="http://purl.org/rss/1.0/"
         xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
         xmlns:cl="http://www.craigslist.org/about/cl-bulk-ns/1.0">

  <channel>
    <items>
      <rdf:li rdf:resource="NYCBrokerHousingSample1"/>
      <rdf:li rdf:resource="NYCBrokerHousingSample2"/>
    </items>

    <cl:auth username="ewastesd@gmail.com"
             password="@Abc!@#123"
             accountID="385216959"/>
  </channel>

  <item rdf:about="NYCBrokerHousingSample1">
    <cl:category>fee</cl:category>
    <cl:area>nyc</cl:area>
    <cl:subarea>mnh</cl:subarea>
    <cl:neighborhood>Upper West Side</cl:neighborhood>
    <cl:housingInfo price="1450"
                    bedrooms="0"
                    sqft="600"/>
    <cl:replyEmail privacy="C">bulkuser@bulkposterz.net</cl:replyEmail>
    <cl:brokerInfo companyName="Joe Sample and Associates"
                   feeDisclosure="fee disclosure here" />
    <title>Spacious Sunny Studio in Upper West Side</title>
    <description><![CDATA[
      posting body here
    ]]></description>
  </item>

  <item rdf:about="NYCBrokerHousingSample2">
    <cl:category>fee</cl:category>
    <cl:area>nyc</cl:area>
    <cl:subarea>mnh</cl:subarea>
    <cl:neighborhood>Chelsea</cl:neighborhood>
    <cl:housingInfo price="2175"
                    bedrooms="1"
                    sqft="850"
                    catsOK="1"/>
    <cl:mapLocation city="New York"
                    state="NY"
                    crossStreet1="23rd Street"
                    crossStreet2="9th Avenue"
                    latitude="40.746492"
                    longitude="-74.001326"
    />
    <cl:replyEmail privacy="C"
                   otherContactInfo="212.555.1212">
      bulkuser@bulkposterz.net
    </cl:replyEmail>
    <cl:brokerInfo companyName="Joe Sample and Associates"
                   feeDisclosure="fee disclosure here" />
    <title>1BR Charmer in Chelsea</title>
    <description><![CDATA[
      posting body goes here
    ]]></description>
    <cl:PONumber>Purchase Order 094122</cl:PONumber>
    <cl:image position="1">/9j/4AAQSkZJRgABAQEASABIAAD/4QCARXhpZgAATU0AKgAAAAgABQESAAMAAAABAAEAAAEaAAUA
AAABAAAASgEbAAUAAAABAAAAUgEoAAMAAAABAAIAAIdpAAQAAAABAAAAWgAAAAAAAABIAAAAAQAA
AEgAAAABAAKgAgAEAAAAAQAAABCgAwAEAAAAAQAAABAAAAAA/9sAQwABAQEBAQEBAQEBAQEBAQEB
AQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEB/9sAQwEBAQEB
AQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEB
AQEB/8AAEQgAEAAQAwERAAIRAQMRAf/EAB8AAAEFAQEBAQEBAAAAAAAAAAABAgMEBQYHCAkKC//E
ALUQAAIBAwMCBAMFBQQEAAABfQECAwAEEQUSITFBBhNRYQcicRQygZGhCCNCscEVUtHwJDNicoIJ
ChYXGBkaJSYnKCkqNDU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6g4SFhoeI
iYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2drh4uPk5ebn6Onq
8fLz9PX29/j5+v/EAB8BAAMBAQEBAQEBAQEAAAAAAAABAgMEBQYHCAkKC//EALURAAIBAgQEAwQH
BQQEAAECdwABAgMRBAUhMQYSQVEHYXETIjKBCBRCkaGxwQkjM1LwFWJy0QoWJDThJfEXGBkaJico
KSo1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoKDhIWGh4iJipKTlJWWl5iZ
mqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6vLz9PX29/j5+v/a
AAwDAQACEQMRAD8A+4/jzpGrf8FNf2Kv27P+ClX7T/x08Z+Dv2ZvBPhL9orw/wDsDfs4eHvHUvgD
4Y3V58NrDxH4Q+H3xN+KMVvPbN8Q/iL48+Klja6VoXhu8nb/AInQn0C2k1TQ9T0nQLL+0eH61Hwt
444A8MOFchwWN4px+M4bxHiFxNiMAswzWMMzqYbG5jlWVOcZrLsty/Kak6uIxUIq1C2Il7LEUq2I
n/QeWVIcF8R8McHZJlmHxGdYnEZPV4pzerhVisbGOMnSxGLweCbUvqmEwuBnKdWtFL93aq+SpCdW
TPgHpOr/APBMz9in9hT/AIKV/swfHTxn4x/Zm8beFP2ePD37fP7OHiHx1L4/+GNrefEey8PeD/iB
8TfhdFcT3LfD34i+A/ilfXWl674bs51zrLQaDcSaXoem6toF6+IatHxS454+8MOKshwOC4pwOM4k
xPh7xNhsAsvzSdPLKmJxuXZXmrgorMstzDKYRq0MTOL/AHPNiIqriKtHEQeaVKfGnEfE/B2dZZh8
PnWGr5vV4WzijhfquNlHByq4jC4PGtcv1vCYrBRU6VaSf7vmqrnqThVj8N/ttfspePP2M9M+NP7L
37Yl/wDHvXP2C/hX8Of2nPHX/BNw/C/wdeap8DtV+PHxWtvGuvfDlP2hPFvhu6TWNE8W/D7xH4lF
lo2k+ILCTTZtXW+1iC50zwFqOuJ4u+84F4ty/jarkfFfBdPh+h4g5tmXC2A8Tf7VxsaWfUeH8ong
cPmT4cwmKi6FfB5jhsM6leth6ntVRcKDjVzCnQ+p/S8N55heIp5bnfD0cqp8U47GZLheMPruIjDM
4ZXgZYeljHlOHrJ06lDF0aLlUqUpe0UHCm1PFQpOg79ib9lPx1+2bpHwU/Zd/Y6vfj5oX7B/xU+H
X7M3jr/gpM3xQ8H3emfAzTfjt8KYPBevfEJf2evFviS6fWda8X/EHxD4baw1zSPD+nx6XFq50/Wp
rrU/Aen6LH4ROOuLcBwTWz3ivjSHD1fxAynMuKMB4YrKsbGrn1XIM3njsPlz4jweFgqFHB5bhsT7
ShWxFV1XR9pQUKWYVKzxhxJnmG4dqZnnfEMcrqcUYHF5zhuD/qWIjPM55ZjpYmlhP7WoUV7OnQwl
KtzUqlWXO6fPTShiZVHiP//Z
    </cl:image>
  </item>
</rdf:RDF>';


$connection = curl_init();
        curl_setopt($connection, CURLOPT_URL, "https://post.craigslist.org/bulk-rss/validate");
        curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($connection, CURLOPT_POST, 1);
        curl_setopt($connection, CURLOPT_POSTFIELDS, $XML);
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($connection);
        curl_close($connection);
        return $response;

    }

    public function PostOnFB(){
        $GetProduct = Product::get()->take(20);
        
        $XML = '<?xml version="1.0"?>
                        <rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
                            <channel>
                                <title>EllyHub Store</title>
                                <link>http://www.example.com</link>
                                <description>Product Feed</description>';
        foreach($GetProduct as $GPP){
$XML .= '<item>
<g:id>'.$GPP->id.'</g:id>
<g:title>'.$GPP->name.'</g:title>
<g:description>'.strip_tags($GPP->description).'</g:description>
<g:availability>in stock</g:availability>
<g:condition>new</g:condition>
<g:price>'.$GPP->product_price.' USD</g:price>
<g:link>'.$GPP->ebay_product_url.'</g:link>
<g:image_link>'.$GPP->image.'</g:image_link>
<g:brand>'.$GPP->brand.'</g:brand>
<g:quantity_to_sell_on_facebook>'.$GPP->stock.'</g:quantity_to_sell_on_facebook>
<g:fb_product_category>Electronics > Cameras</g:fb_product_category>
<g:google_product_category>Electronics > Communications > Telephony > Mobile Phone Accessories</g:google_product_category>
</item>';
        }

        $XML .= "</channel>
        </rss>";

        echo $XML;
    }

}
