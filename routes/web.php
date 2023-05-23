<?php

Route::get('/cache', function(){
	Artisan::call('cache:clear');
	Artisan::call('config:clear');
	Artisan::call('route:clear');
	Artisan::call('view:clear');
	return  'Cache is cleared.';
});

Route::get('GetCategory','Admin\EbayCronController@fetchProduct');

Route::get('track','WelcomeController@track_order')->name('track');
Route::get('find','CommonController@find_product')->name('find_product');
Route::get('pages/{page}', 'CommonController@page_s');
Route::get('test', 'WelcomeController@test');
Route::get('/', 'WelcomeController@get_product');
Route::get('search','WelcomeController@search')->name('search');

Route::get('categories', 'WelcomeController@all_categories')->name('all_categories');
Route::get('category/{cat}', 'WelcomeController@category_details')->name('category_details');
Route::get('category/{cat}/{sub}', 'WelcomeController@sub_categorydetails')->name('sub_categorydetails');
Route::get('category/{cat}/{sub}/{child}', 'WelcomeController@child_categorydetails')->name('child_categorydetails');

 
 
Route::get('filter', 'WelcomeController@category_wise_products')->name('category_details1');
Route::get('contact-us','WelcomeController@contact_us')->name('contact_us');
Route::post('contact-save','WelcomeController@save_contactus')->name('save_contactus');
Route::get('sub-category/{id}', 'WelcomeController@sub_category_details')->name('sub_category_details');
Route::get('child-category/{id}', 'WelcomeController@child_category_details')->name('child_category_details');
Route::get('product/{id}', 'WelcomeController@product_details')->name('product_details');
Route::get('brand/{id}', 'WelcomeController@brand_details')->name('brand_details');
Route::get('products','WelcomeController@find_product')->name('find_product');
Route::get('contact-us','WelcomeController@contact_us')->name('contact_us');

Route::get('vendor/register','WelcomeController@register_vendor')->name('vendor_register');
Route::post('vendor/regiter-save','WelcomeController@vendor_save')->name('register_form_save');
Route::get('vendor/login','WelcomeController@vendor_login')->name('vendor_login');
Route::post('vendor/dologin','WelcomeController@vendor_dologin')->name('vendor_login');
Route::get('vendor/logout','WelcomeController@vendor_logout')->name('vendor_logout');
Route::get('vendor/verify/{email}','WelcomeController@vendor_verify')->name('vendor_verify');
Route::get('vendor/resend-email/{email}','WelcomeController@vendor_resend_email')->name('vendor_resend_email');
Route::get('add_to_cart_ajax','CommonController@add_to_cart')->name('add_to_cart_ajax');
Route::get('get_wishlist_ajax','CommonController@get_wishlist_ajax')->name('get_wishlist_ajax');
Route::get('get_cart_ajax','CommonController@get_cart_ajax')->name('get_cart_ajax');
Route::get('cart','WelcomeController@cart_list')->name('cart');
Route::get('checkout','WelcomeController@checkout')->name('checkout');
Route::get('make-order','WelcomeController@make_order')->name('make_order');
Route::post('make_payment','WelcomeController@make_payment')->name('make_payment');
Route::get('logout','WelcomeController@logout')->name('user_logout');
// user routes
Route::get('user/login','WelcomeController@user_login')->name('user_login');
Route::post('user/dologin','WelcomeController@user_do_login')->name('user_do_login');
Route::get('user/register','WelcomeController@user_register')->name('user_register');
Route::post('user/save','WelcomeController@user_save')->name('user_register_form_save');
Route::get('user/verify/{email}','WelcomeController@user_email_verify')->name('user_verify_email');
Route::get('user/forget-password','WelcomeController@user_forget_password')->name('user_forget_password');
Route::post('user/send_password','WelcomeController@send_password')->name('send_password');
Route::get('vendor/forget-password','WelcomeController@vendor_forget_password')->name('vendor_forget_password');

Route::get('vendor/{name}','WelcomeController@vendor_profile_view')->name('vendor_profile_view');
// admin route
Route::get('admin','Admin\LoginController@index')->name('login');
Route::get('admin','Admin\LoginController@index')->name('admin_login');
Route::post('admin/login','Admin\LoginController@attempt_login')->name('attempt_login');
Route::get('admin/logout','Admin\LoginController@logout')->name('admin_logout');

Route::group(['middleware' => 'auth'], function(){
	Route::group(['namespace'=>'Admin','prefix'=>'admin'], function(){
		Route::get('dashboard','HomeController@index')->name('admin_dashboard');
		Route::get('comming_soon','HomeController@comming_soon')->name('comming_soon');

        /* Banner */
		Route::get('banner','BannerController@banner_list')->name('banner_list');
		Route::get('add_banner','BannerController@add_banner')->name('add_banner');
		Route::post('save_banner','BannerController@save_banner')->name('save_banner');
		Route::get('delete_banner','BannerController@delete_banner')->name('delete_banner');
		Route::get('banner-edit/{id}','BannerController@edit_banner')->name('edit_banner');
		Route::get('banner-view/{id}','BannerController@view_banner')->name('view_banner');
		Route::post('update_banner','BannerController@update_banner')->name('update_banner');
		Route::get('banner_status','BannerController@banner_status')->name('banner_status');
		
		/* Brand */
		Route::get('brand','BrandController@brand_list')->name('brand_list');
		Route::get('add_brand','BrandController@add_brand')->name('add_brand');
		Route::post('save_brand','BrandController@save_brand')->name('save_brand');
		Route::get('delete_brand','BrandController@delete_brand')->name('delete_brand');
		Route::get('brand-edit/{id}','BrandController@edit_brand')->name('edit_brand');
		Route::get('brand-view/{id}','BrandController@view_brand')->name('view_brand');
		Route::post('update_brand','BrandController@update_brand')->name('update_brand');
		Route::get('brand_status','BrandController@brand_status')->name('brand_status');
		 
		// category routes
		Route::get('category','CategoryController@category_list')->name('category_list');
		Route::get('category-add','CategoryController@category_add')->name('add_category');
		Route::post('category-save','CategoryController@category_save')->name('save_category');
		Route::get('category-edit/{id}','CategoryController@category_edit')->name('edit_category');
		Route::post('category-update','CategoryController@category_update')->name('update_category');
		Route::get('delete_row','CategoryController@delete_row')->name('delete_row');
		Route::get('home_category','CategoryController@home_category')->name('home_category');
		Route::get('category_status','CategoryController@category_status')->name('category_status');

		Route::get('sub-category','CategoryController@sub_category_list')->name('sub_category_list');
		Route::get('sub-category-add','CategoryController@sub_category_add')->name('add_sub_category');
		Route::post('sub-category-save','CategoryController@sub_category_save')->name('save_sub_category');
		Route::get('sub-category-edit/{id}','CategoryController@sub_category_edit')->name('edit_sub_category');
		Route::post('sub-category-update','CategoryController@sub_category_update')->name('update_sub_category');

		Route::get('child-category','CategoryController@child_category_list')->name('child_category_list');
		Route::get('child-category-add','CategoryController@child_category_add')->name('child_category_add');
		Route::post('child-category-save','CategoryController@save_child_category')->name('save_child_category');
		Route::get('child-category-edit/{id}','CategoryController@edit_child_category')->name('edit_child_category');
		Route::post('child-category-update','CategoryController@update_child_category')->name('update_child_category');
		
		 
		Route::get('ajax_get_child_category','CategoryController@ajax_get_child_category')->name('ajax_get_child_category');
  
		Route::get('attribute/{category}/{id}','CategoryController@attribute_list')->name('attribute');
		Route::get('attribute-add/{category}/{id}','CategoryController@attribute_add')->name('add_attribute');
		Route::get('attribute-edit/{id}','CategoryController@attribute_edit')->name('attribute_edit');
		Route::post('attribute-save','CategoryController@attribute_save')->name('save_attribute');
		Route::post('attribute-update','CategoryController@update_attribute')->name('update_attribute');
        Route::get('delete_attributes','CategoryController@delete_attributes')->name('delete_attributes');
        Route::get('delete_attribute_options','CategoryController@delete_attribute_options')->name('delete_attribute_options');
		// product routes
		Route::get('products','ProductController@products')->name('products');
		Route::get('products_ajax','ProductController@product_list')->name('ajax_get_products');
		Route::get('products-add','ProductController@product_add')->name('add_product');
		Route::post('products-save','ProductController@product_save')->name('save_product');
		Route::get('product/{id}','ProductController@product_detail')->name('product_detail_admin');
		Route::get('product/edit/{id}','ProductController@product_edit')->name('product_edit_admin');
		Route::get('update_product_status','ProductController@update_product_status')->name('update_product_status');
		Route::post('update_product','ProductController@update_product')->name('update_product');
        Route::get('delete_product_gallery','ProductController@delete_product_gallery')->name('delete_product_gallery');
       Route::post('upload-csv','ProductController@save_csv')->name('save_csv');
		
		Route::get('products-stock','ProductController@product_stock')->name('product_stock');
		Route::get('ajax_get_product_stock','ProductController@ajax_get_product_stock')->name('ajax_get_product_stock');
		Route::get('add_stock','ProductController@add_stock')->name('add_stock');
		Route::get('stock_out','ProductController@stock_out')->name('stock_out');

		Route::get('product-delete','ProductController@deleted_products')->name('deleted_products');
		Route::get('ajax_get_product_deleted','ProductController@ajax_get_product_deleted')->name('ajax_get_product_deleted');
		Route::get('delete_product','ProductController@delete_product')->name('delete_product');
		Route::post('delete_product_permanent','ProductController@delete_product_permanent')->name('delete_product_permanent');


		Route::get('product-unapproved','ProductController@unapproved_products')->name('unapproved_products');
		Route::get('ajax_get_product_unapproved','ProductController@ajax_get_product_unapproved')->name('ajax_get_product_unapproved');

		Route::get('product-bundle','ProductController@product_bundle')->name('product_bundle');
		Route::get('ajax_get_product_bundle','ProductController@ajax_get_product_bundle')->name('ajax_get_product_bundle');
		Route::get('product-bundle-add','ProductController@add_bundle')->name('add_bundle');
		Route::post('product-bundle-save','ProductController@save_bundle')->name('save_product_bundle');
		Route::get('product-bundle/{id}','ProductController@add_product_to_bundle')->name('add_product_to_bundle');
		Route::get('ajax_get_bundle_products','ProductController@ajax_get_bundle_products')->name('ajax_get_bundle_products');
		Route::post('product-bundle-product-save','ProductController@product_bundle_product_save')->name('product_bundle_product_save');
		Route::get('delete_product_bundle','ProductController@delete_product_bundle')->name('delete_product_bundle');
		Route::get('product-csv','ProductController@product_bulk_upload')->name('product_bulk_upload');


		Route::get('staff','AdminController@index')->name('admin_staff');
		Route::get('ajax_get_staff','AdminController@ajax_get_staff')->name('ajax_get_staff');
		Route::get('staff-add','AdminController@add_staff')->name('add_staff');
		Route::post('staff-save','AdminController@save_staff')->name('save_staff');

		Route::get('vendor','UserController@show_vendor')->name('vendor_list');
		Route::get('ajax_get_vendor','UserController@ajax_get_vendor')->name('ajax_get_vendor');
		Route::get('show_vendor_document','UserController@show_vendor_document')->name('show_vendor_document');
		Route::get('download_vendor_csv','UserController@download_vendor_csv')->name('download_vendor_csv');
		Route::get('update_vendor_status','UserController@update_vendor_status')->name('update_vendor_status');
		Route::get('vendor/{id}','UserController@view_vendor_detail')->name('admin_view_vendor');
		Route::get('vendor/edit/{id}','UserController@edit_vendor_detail')->name('edit_vendor_detail');
		Route::post('vendor/update','UserController@admin_update_vendor')->name('admin_update_vendor');
		Route::get('vendor-payments/{id?}','UserController@vendor_payments')->name('vendor_payments');
		Route::get('vendor-payments-report/{id?}','UserController@vendor_payments_report')->name('vendor_payments_report');
		Route::post('make_vendor_payment','UserController@make_vendor_payment')->name('make_vendor_payment');
		Route::get('vendor_payment_report_download','UserController@vendor_payment_report_download')->name('vendor_payment_report_download');
		

		Route::get('vendor-add','UserController@add_vendor')->name('add_vendor');
		Route::post('vendor-save','UserController@admin_save_vendor')->name('admin_save_vendor');
		// coupens routes
		Route::get('coupens','CoupenController@index')->name('coupens');
		Route::get('ajax_get_coupen','CoupenController@ajax_get_coupen')->name('ajax_get_coupen');
		Route::get('delete_row','CoupenController@delete_row')->name('delete_row');
		Route::get('add-coupen','CoupenController@add_coupen')->name('add_coupen');
		Route::post('save-coupen','CoupenController@save_coupen')->name('save_coupen');

		Route::get('my_sale','SaleController@my_sale')->name('my_sale');
		Route::get('sale','SaleController@sale')->name('sale');
		Route::get('ajax_sale','SaleController@ajax_sale')->name('ajax_sale');
		Route::get('ajax_get_sale','SaleController@ajax_get_sale')->name('ajax_get_sale');
		Route::get('update_order_parameter','SaleController@update_order_parameter')->name('update_order_parameter');
		Route::get('update_order_parameter_admin','SaleController@update_order_parameter_admin')->name('update_order_parameter_admin');
		Route::get('sale-report','SaleController@sale_report')->name('sale_report');
		Route::get('ajax_sale_report','SaleController@ajax_sale_report')->name('ajax_sale_report');
		Route::get('sale_report_download','SaleController@sale_report_download');
		Route::get('orders','OrderController@orders')->name('admin_orders');
		Route::get('order-trash','OrderController@delete_order')->name('delete_order');
		Route::get('update_delivery_type','OrderController@update_delivery_type')->name('update_delivery_type');
		Route::get('check_price_shipstation','OrderController@check_price_shipstation')->name('check_price_shipstation');
		Route::get('ajax_send_to_shipstation','OrderController@ajax_send_to_shipstation')->name('ajax_send_to_shipstation');

		
		Route::get('ajax_get_orders','OrderController@ajax_get_orders')->name('ajax_get_orders');
		//eBay
		
		
		Route::get('market-setting','SettingController@market_settings')->name('market_settings');
		 Route::group(['name' => 'Ebay OAuth Login'], function () {
        // Todo: start Ebay Api Login
        // Route::get('/show-ebay-login', 'ProductController@showEbayLogin')->name('showEbayLogin');
       
		Route::get('show-ebay-login','EbayOauthController@showEbayLogin')->name('showEbayLogin');
        Route::get('ebay-auth','EbayOauthController@loginEbay')->name('loginEbay'); // redirect-uri
        Route::get('ebay-auth-declined', 'EbayOauthController@loginFailEbay')->name('loginFailEbay'); // redirect-uri
        // Todo: End Ebay Api Login
        Route::get('ebay-auth-sand-box','EbayOauthController@loginEbaySandBox')->name('loginEbaySandBox'); // redirect-uri
    });
	
		// Route::post('ebay-credentials', 'ProductController@ebayCredentialsStore')->name('ebay_credentials'); //
        
        Route::delete('ebay-credentials-remove','EbayController@ebayCredentialsRemove')->name('ebay_credentials_remove');
		 Route::post('settings/update-paypal','EbayController@updatePaypal')->name('settings.update.paypal');
		 
		
		   Route::get('fetch-ebay-product','EbayController@fetchEbayProduct')->name('fetchEbayProduct');
		// vendor

		Route::get('my-profile','HomeController@my_profile')->name('my_profile');
		Route::post('update-vendor-information','HomeController@update_vendor_information')->name('update_vendor_information');
		Route::post('update_bank_information','HomeController@update_bank_information')->name('update_bank_information');

		Route::get('pages','PageController@index')->name('pages');
		Route::get('ajax_get_pages','PageController@ajax_get_pages')->name('ajax_get_pages');
		Route::get('page-add','PageController@add_page')->name('add_page');
		Route::post('page-save','PageController@save_page')->name('save_page');

		Route::get('customer','UserController@show_customer')->name('customer');
		Route::get('ajax_get_customer','UserController@ajax_get_customer')->name('ajax_get_customer');

		Route::get('delivery','DeliveryController@delivery')->name('delivery');
		Route::post('save-delivery','DeliveryController@save_delivery_slab')->name('save_delivery_slab');
		Route::get('ajax_get_delivery_slab','DeliveryController@ajax_get_delivery_slab')->name('ajax_get_delivery_slab');
		Route::get('delete_delivery_slab','DeliveryController@delete_delivery_slab')->name('delete_delivery_slab');
		Route::get('wallet','WalletController@wallet')->name('customer_wallet');
		Route::get('ajax_get_customer_wallet','WalletController@ajax_get_customer_wallet')->name('ajax_get_customer_wallet');
		Route::post('update_balance','WalletController@update_balance')->name('update_balance');

		Route::get('pin-codes','PincodesController@pin_codes')->name('pin_codes');
		Route::get('ajax_get_pincodes','PincodesController@ajax_get_pincodes')->name('ajax_get_pincodes');
		Route::get('delete_pincode','PincodesController@delete_pincode')->name('delete_pincode');
		Route::get('pin-code/add','PincodesController@add_pin_code')->name('add_pin_code');
		Route::post('pin-code/save','PincodesController@save_pincode')->name('save_pincode');

		Route::get('blog','BlogController@list')->name('blogs');


		Route::get('send-mail','PromotionController@send_mail')->name('send_mail');
		Route::post('send_mail','PromotionController@send_mail_touser')->name('send_mail_touser');

		Route::get('product-stock-report','ReportController@stock_report')->name('product_stock_report');
		Route::get('product_stock_report_download','ReportController@product_stock_report_download')->name('product_stock_report_download');
		Route::get('get_sub_category_admin','ReportController@get_sub_category_admin')->name('get_sub_category_admin');
		Route::get('get_child_category_admin','ReportController@get_child_category_admin')->name('get_child_category_admin');
		Route::get('ajax_get_product_reports','ReportController@ajax_get_product_reports')->name('ajax_get_product_reports');
		Route::get('vendor-payment-report','ReportController@vendor_payment_report')->name('vendor_payment_report');
		Route::get('ajax_get_payments_reports','ReportController@ajax_get_payments_reports')->name('ajax_get_payments_reports');
		Route::get('payment-history','ReportController@payment_history')->name('payment_history');
		Route::get('ajax_get_payments_history','ReportController@ajax_get_payments_history')->name('ajax_get_payments_history');
		Route::get('payment_history_download','ReportController@payment_history_download');

		Route::get('notifications','NotificationController@notifications')->name('notifications');
		Route::get('ajax_get_notification','NotificationController@ajax_get_notification')->name('ajax_get_notification');
		Route::get('get_notification_count','NotificationController@get_notification_count')->name('get_notification_count');
		Route::get('mark_read_notification','NotificationController@mark_read_notification')->name('mark_read_notification');

		// setting routes
		Route::get('general-setting','SettingController@general_setting')->name('general_setting');
		Route::get('homepage-setting','SettingController@home_page_setting')->name('home_page_setting');
		Route::post('update_settings','SettingController@update_settings')->name('update_settings');
	});


});

	// common routes
	Route::get('get_sub_category','CommonController@get_sub_category')->name('get_sub_category');
	Route::get('get_child_category','CommonController@get_child_category')->name('get_child_category');
	Route::get('get_featured_category','CommonController@get_featured_category')->name('get_featured_category');
	Route::get('get_product_ajax','CommonController@get_product_ajax')->name('get_product_ajax');
	Route::post('get_brand_product','CommonController@get_brand_product')->name('get_brand_product');
	
	
	Route::get('add_wishlist', 'CommonController@add_wishlist')->name('add_wishlist');
	Route::get('add_compare', 'CommonController@add_compare')->name('add_compare');
	Route::get('add_cart', 'CommonController@add_cart')->name('add_cart');
 	Route::get('check_login','CommonController@check_login')->name('check_login');
 	Route::get('remove_from_cart','CommonController@remove_from_cart')->name('remove_from_cart');
 	Route::get('remove_from_cart_ajax','CommonController@remove_from_cart_ajax')->name('remove_from_cart_ajax');
	Route::get('empty_cart','CommonController@empty_cart')->name('empty_cart');
	Route::get('apply_coupen','CommonController@apply_coupen')->name('apply_coupen');
	Route::get('order-success','CommonController@order_success')->name('order_success');
	Route::get('orders','CommonController@user_orders')->name('orders');
	Route::get('order_detail/{id}','CommonController@order_detail')->name('order_detail');
	Route::get('rate-and-review/{orderid}','CommonController@rate_and_review')->name('rate_and_review');
	Route::post('submit_review','CommonController@submit_review')->name('submit_review');
	Route::post('update_review','CommonController@update_review')->name('update_review');
	Route::get('cancel_order/{id}','CommonController@cancel_order')->name('cancel_order');
	Route::get('vendor_order_detail/{orderid}/{vendorid}','CommonController@vendor_order_detail')->name('vendor_order_detail');
	Route::get('wishlist','CommonController@wishlist')->name('wishlist');
	Route::get('remove_from_wishlist','CommonController@remove_from_wishlist')->name('remove_from_wishlist');
	Route::get('account','WelcomeController@user_account')->name('user_account');
	Route::get('access-denied','WelcomeController@access_denied')->name('access_denied');
	Route::post('update-profile','WelcomeController@update_profile')->name('update_profile');
	Route::get('test-mail','CommonController@test_mail');
	Route::get('get_address','CommonController@get_address')->name('get_address');
	Route::get('wallet','WelcomeController@get_wallet')->name('wallet');
	Route::get('my-address','WelcomeController@shipping_address')->name('shipping_address');
	Route::get('trash_address','WelcomeController@remove_from_address')->name('remove_from_address');
	Route::get('change_product_size','WelcomeController@change_product_size')->name('change_product_size');


	Route::get('login/facebook', 'WelcomeController@redirectToProvider');
	Route::get('login/facebook/callback', 'WelcomeController@handleProviderCallback');
	Route::get('verify_pincode','WelcomeController@verify_pincode')->name('verify_pincode');
	Route::get('login_with_facebook','WelcomeController@login_with_facebook')->name('login_with_facebook');

	Route::get('/google/redirect', 'WelcomeController@google_redirectToProvider');
	Route::get('/google/callback', 'WelcomeController@google_handleProviderCallback');
	Route::get('test_sms','WelcomeController@test_sms')->name('test_sms');