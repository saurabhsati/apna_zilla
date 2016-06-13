<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

/* Admin Routes */
Route::group(['prefix'=>'/web_admin','middleware'=>['web']], function ()
	{
		Route::any('register_admin',				  ['as' => 'admin_register',			   'uses' => 'Admin\AuthController@register_admin']);
		Route::any('register',						  ['as' => 'register',			   		   'uses' => 'Admin\AuthController@register']);
		Route::any('assign_role',					  ['as' => 'assign_role',			       'uses' => 'Admin\AuthController@assignRole']);
		Route::any('activation',					  ['as' => 'activation',			   	   'uses' => 'Admin\AuthController@activation']);
		Route::any('registerandactivate',			  ['as' => 'register_and_active',		   'uses' => 'Admin\AuthController@registerAndActivate']);

		Route::get('/','Admin\AuthController@show_login');
		Route::get('login',						 	  ['as' => 'admin_login',			   	   'uses' => 'Admin\AuthController@show_login']);
		Route::post('process_login',				  ['as' => 'admin_process_login',		   'uses' => 'Admin\AuthController@process_login']);
		Route::get('dashboard',						  ['as' => 'admin_dashboard',			   'uses' => 'Admin\DashboardController@index']);
		Route::post('view_sales_activity',			  ['as' => 'view_sales_activity',          'uses' => 'Admin\DashboardController@view_sales_activity']);
		Route::get('logout',						  ['as' => 'admin_logout',			   	   'uses' => 'Admin\AuthController@logout']);
		Route::get('change_password',				  ['as' => 'admin_change_password',		   'uses' => 'Admin\AuthController@change_password']);
		Route::post('update_password',				  ['as' => 'admin_update_password',		   'uses' => 'Admin\AuthController@update_password']);
		Route::get('edit_profile',					  ['as' => 'admin_edit_profile',		   'uses' => 'Admin\AuthController@profile']);
		Route::post('updateprofile',				  ['as' => 'admin_update_profile',		   'uses' => 'Admin\AuthController@updateprofile']);

		Route::get('clear_app_cache',function ()
		{
			\Artisan::call('cache:clear');
			return redirect()->back();
		});

	  /*---------------------CMS Module Start-------------------------*/
	   Route::group(array('prefix' => '/static_pages'), function()
		{
			Route::get('/',							 	 ['as' => 'static_pages_manage' 		,'uses' => 'Admin\StaticPageController@index']);
			Route::get('create',					 	 ['as' => 'static_pages_create' 		,'uses' => 'Admin\StaticPageController@create']);
			Route::get('edit/{enc_id}',					 ['as' => 'static_pages_edit' 			,'uses' => 'Admin\StaticPageController@edit']);
			Route::any('store',							 ['as' => 'static_pages_store' 			,'uses' => 'Admin\StaticPageController@store']);
			Route::get('delete/{enc_id}',				 ['as' => 'static_pages_delete' 		,'uses' => 'Admin\StaticPageController@delete']);
			Route::post('update/{enc_id}',				 ['as' => 'static_pages_update' 		,'uses' => 'Admin\StaticPageController@update']);
			Route::get('toggle_status/{enc_id}/{action}',['as' => 'static_pages_toggle_status' 	,'uses' => 'Admin\StaticPageController@toggle_status']);
			Route::post('multi_action',  				 ['as' => 'static_pages_multi_action' 	,'uses' => 'Admin\StaticPageController@multi_action']);

		});


	  /*---------------------CMS Module End-------------------------*/


	   /* Location module */
	   Route::group(array('prefix' => '/countries'), function()
		{
			Route::get('/',								 ['as' => 'admin_countries_manage' 			,'uses' => 'Admin\CountryController@index']);
			Route::get('show/{enc_id}',					 ['as' => 'admin_countries_show'			,'uses' => 'Admin\CountryController@show']);
			Route::get('edit/{enc_id}',					 ['as' => 'admin_countries_edit' 			,'uses' => 'Admin\CountryController@edit']);
			Route::post('update/{enc_id}',				 ['as' => 'admin_countries_update'			,'uses' => 'Admin\CountryController@update']);
			Route::get('create',						 ['as' => 'admin_countries_create' 			,'uses' => 'Admin\CountryController@create']);
			Route::get('toggle_status/{enc_id}/{action}',['as' => 'admin_countries_toggle_status'	,'uses' => 'Admin\CountryController@toggle_status']);
			Route::get('delete/{enc_id}',				 ['as' => 'admin_countries_delete' 			,'uses' => 'Admin\CountryController@delete']);
			Route::post('multi_action',					 ['as' => 'admin_countries_block' 			,'uses' => 'Admin\CountryController@multi_action']);
			Route::any('store',							 ['as' => 'admin_countries_store' 			,'uses' => 'Admin\CountryController@store']);

		});

		Route::group(array('prefix' => '/states'), function()
		{

			Route::get('/',									['as' => 'admin_states_manage'		    ,'uses' => 'Admin\StateController@index']);
			Route::get('show/{enc_id}',						['as' => 'admin_states_show' 			,'uses' => 'Admin\StateController@show']);
			Route::get('edit/{enc_id}',						['as' => 'admin_states_edit' 			,'uses' => 'Admin\StateController@edit']);
			Route::post('update/{enc_id}',					['as' => 'admin_states_update' 			,'uses' => 'Admin\StateController@update']);
			Route::get('create',							['as' => 'admin_states_create'		  	,'uses' => 'Admin\StateController@create']);
			Route::get('toggle_status/{enc_id}/{action}',	['as' => 'admin_states_toggle_status' 	,'uses' => 'Admin\StateController@toggle_status']);
			Route::post('multi_action',						['as' => 'admin_states_block' 			,'uses' => 'Admin\StateController@multi_action']);
			Route::any('store',								['as' => 'admin_states_store'			,'uses' => 'Admin\StateController@store']);
			Route::get('delete/{enc_id}',					['as' => 'admin_states_delete' 			,'uses' => 'Admin\StateController@delete']);
			Route::get('export/{format}',					['as' => 'admin_states_excel' 		    ,'uses' => 'Admin\StateController@export_excel']);
		});

		Route::group(array('prefix' => '/cities'), function()
		{

			Route::get('/',									['as' => 'admin_cities_manage'		  ,'uses' => 'Admin\CityController@index']);
			Route::get('show/{enc_id}',						['as' => 'admin_cities_show' 		  ,'uses' => 'Admin\CityController@show']);
			Route::get('edit/{enc_id}',						['as' => 'admin_cities_edit' 		  ,'uses' => 'Admin\CityController@edit']);
			Route::post('update/{enc_id}',					['as' => 'admin_cities_update' 		  ,'uses' => 'Admin\CityController@update']);
			Route::get('create',							['as' => 'admin_cities_create' 		  ,'uses' => 'Admin\CityController@create']);
			Route::get('toggle_status/{enc_id}/{action}',	['as' => 'admin_cities_toggle_status' ,'uses' => 'Admin\CityController@toggle_status']);
			Route::post('multi_action',						['as' => 'admin_cities_block' 		  ,'uses' => 'Admin\CityController@multi_action']);
			Route::any('store',								['as' => 'admin_cities_store' 		  ,'uses' => 'Admin\CityController@store']);
			Route::any('nearby_destinations/{enc_id}',		['as' => 'admin_nearby_destinations'  ,'uses' => 'Admin\CityController@nearby_destinations']);
			Route::any('add_destinations',					['as' => 'admin_add_destinations'	  ,'uses' => 'Admin\CityController@add_destinations']);
			Route::get('delete/{enc_id}',					['as' => 'admin_cities_delete' 		  ,'uses' => 'Admin\CityController@delete']);
			Route::get('export/{format}',					['as' => 'admin_cities_excel' 		  ,'uses' => 'Admin\CityController@export_excel']);
		});
		/*------------------------- web_admin Places Related ------------------------------*/

		Route::group(array('prefix' => '/places'), function()
		{

			Route::get('/',									['as' => 'admin_places_manage' ,'uses' => 'Admin\PlaceController@index']);
			Route::get('show/{enc_id}',						['as' => 'admin_places_show' ,'uses' => 'Admin\PlaceController@show']);
			Route::get('edit/{enc_id}',						['as' => 'admin_places_edit' ,'uses' => 'Admin\PlaceController@edit']);
			Route::post('update/{enc_id}',					['as' => 'admin_places_update' ,'uses' => 'Admin\PlaceController@update']);
			Route::get('create',							['as' => 'admin_places_create' ,'uses' => 'Admin\PlaceController@create']);
			Route::get('toggle_status/{enc_id}/{action}',	['as' => 'admin_places_toggle_status' ,'uses' => 'Admin\PlaceController@toggle_status']);
			Route::post('multi_action',						['as' => 'admin_places_multiaction' ,'uses' => 'Admin\PlaceController@multi_action']);
			Route::any('store',								['as' => 'admin_places_store' ,'uses' => 'Admin\PlaceController@store']);
			//Route::any('nearby_destinations/{enc_id}',['as' => 'admin_nearby_destinations' ,'uses' => 'Admin\PlaceController@nearby_destinations']);
			//Route::any('add_destinations',['as' => 'admin_add_destinations' ,'uses' => 'Admin\PlaceController@add_destinations']);
			Route::get('delete/{enc_id}',					['as' => 'admin_places_delete' ,'uses' => 'Admin\PlaceController@delete']);
			Route::get('export/{format}',					['as' => 'admin_place_excel' 		  ,'uses' => 'Admin\PlaceController@export_excel']);
		});

		/*-----------------------------------------------------------------------------------*/
		Route::group(array('prefix' => '/zipcode'), function()
		{

			Route::get('/',									['as' => 'admin_zipcode_manage'   		,'uses' => 'Admin\ZipController@index']);
			Route::get('create',							['as' => 'admin_zipcode_create' 		,'uses' => 'Admin\ZipController@create']);
			Route::any('store',								['as' => 'admin_zipcode_store'		    ,'uses' => 'Admin\ZipController@store']);
			Route::get('show/{enc_id}',						['as' => 'admin_zipcode_show' 			,'uses' => 'Admin\ZipController@show']);
			Route::get('edit/{enc_id}',						['as' => 'admin_zipcode_edit' 			,'uses' => 'Admin\ZipController@edit']);
			Route::post('update/{enc_id}',					['as' => 'admin_zipcode_update' 		,'uses' => 'Admin\ZipController@update']);
			Route::get('toggle_status/{enc_id}/{action}',	['as' => 'admin_zipcode_toggle_status'  ,'uses' => 'Admin\ZipController@toggle_status']);
			Route::post('multi_action',						['as' => 'admin_zipcode_block'			,'uses' => 'Admin\ZipController@multi_action']);
			Route::get('delete/{enc_id}',					['as' => 'admin_zipcode_delete' 		,'uses' => 'Admin\ZipController@delete']);

		});

		/* Email Template Module Start*/

		Route::group(array('prefix' => '/email_template'), function()
		{
			Route::get('/',						['as' => 'admin_email_template_index'		,'uses' => 'Admin\EmailTemplateController@index']);
			Route::get('create/',				['as' => 'admin_email_template_create' 		,'uses' => 'Admin\EmailTemplateController@create']);
			Route::post('store/',				['as' => 'admin_email_template_store' 		,'uses' => 'Admin\EmailTemplateController@store']);
			Route::get('edit/{coupon_id}',		['as' => 'admin_email_template_edit'		,'uses' => 'Admin\EmailTemplateController@edit']);
			Route::post('update/{coupon_id}',	['as' => 'admin_email_template_update' 		,'uses' => 'Admin\EmailTemplateController@update']);
		});

		/* Email Template Module End*/

		/* FAQ Module Start*/
		Route::group(array('prefix' => '/faq'), function()
		{

			Route::get('/',								 ['as' => 'admin_faq_manage' 		,'uses' => 'Admin\FAQController@index']);
			Route::get('create',						 ['as' => 'admin_faq_create' 		,'uses' => 'Admin\FAQController@create']);
			Route::get('create_sub_page/{enc_id}',		 ['as' => 'admin_faq_create_subpage','uses' => 'Admin\FAQController@create_sub_page']);
			Route::any('store',							 ['as' => 'admin_faq_store'  		,'uses' => 'Admin\FAQController@store']);
			Route::any('subpages/{enc_id}',				 ['as' => 'admin_faq_store'  		,'uses' => 'Admin\FAQController@subpages']);
			Route::get('show/{enc_id}',					 ['as' => 'admin_faq_show'          ,'uses' => 'Admin\FAQController@show']);
			Route::get('edit/{enc_id}',					 ['as' => 'admin_faq_edit'          ,'uses' => 'Admin\FAQController@edit']);
			Route::post('update/{enc_id}',				 ['as' => 'admin_faq_update'        ,'uses' => 'Admin\FAQController@update']);
			Route::get('toggle_status/{enc_id}/{action}',['as' => 'admin_faq_toggle_status' ,'uses' => 'Admin\FAQController@toggle_status']);
			Route::post('multi_action',					 ['as' => 'admin_faq_block' 		,'uses' => 'Admin\FAQController@multi_action']);
			Route::get('delete/{enc_id}',				 ['as' => 'admin_faq_delete' 		,'uses' => 'Admin\FAQController@delete']);

		});
		/* FAQ Module End */

		/* Comman function */

		Route::group(array('prefix' => '/common'), function()
		{
			Route::get('get_states/{country_id}',  						   ['as' => 'get_states' ,'uses' => 'Common\CountryController@get_states']);
			Route::get('get_cities/{state_id}',  						   ['as' => 'get_cities' ,'uses' => 'Common\CountryController@get_cities']);
			Route::get('get_postalcode/{city_id}',  					   ['as' => 'get_postalcode' ,'uses' => 'Common\CountryController@get_postalcode']);
			Route::get('get_public_id',  								   ['as' => 'get_public_id' ,'uses' => 'Common\CountryController@get_public_id']);
			/* Fetch Sales User */
			Route::get('get_sales_user_public_id/{sales_user_public_id}',  ['as' => 'get_public_id' ,'uses' => 'Common\CountryController@get_sales_user_public_id']);
			
			Route::get('get_subcategory/{main_cat_id}', 				   ['as' => 'get_subcategory' ,'uses' => 'Common\CountryController@get_subcategory']);
		});

		/*-------------Business Reviews Module------------*/
		Route::group(['prefix'=>'reviews'], function (){

			Route::get('/{enc_id}',       					['as' => 'admin_reviews_manage'     ,'uses' =>  'Admin\ReviewController@index']);
			Route::get('view/{enc_id}',    					['as' => 'admin_reviews_view'       ,'uses' =>'Admin\ReviewController@view']);
			Route::get('delete/{enc_id}',   				['as' => 'admin_reviews_delete'     ,'uses' =>'Admin\ReviewController@delete']);
			Route::get('toggle_status/{enc_id}/{action}', 	['as' => 'admin_reviews_status'     ,'uses' =>'Admin\ReviewController@toggle_status']);
			Route::post('multi_action',						['as' => 'admin_reviews_multiation' ,'uses' =>'Admin\ReviewController@multi_action']);
		});
		/*-------------Business Reviews Module End ------------*/

		/*--------------------------     Front SLider Start     ---------------------------*/

		Route::group(array('prefix' => '/front_slider'), function()
		{
				Route::get('/',									['as' => 'admin_front_slider_index' 	  ,'uses' 	=> 'Admin\FrontSliderController@index']);
				Route::get('create/',							['as' => 'admin_front_slider_create'      ,'uses' 	=> 'Admin\FrontSliderController@create']);
				Route::post('store/',							['as' => 'admin_front_slider_store' 	  ,'uses' 	=> 'Admin\FrontSliderController@store']);
				Route::get('edit/{slider_id}',					['as' => 'admin_front_slider_edit' 		  ,'uses' 	=> 'Admin\FrontSliderController@edit']);
				Route::get('show/{slider_id}',					['as' => 'admin_front_slider_show' 		  ,'uses' 	=> 'Admin\FrontSliderController@show']);
				Route::post('update/{slider_id}',				['as' => 'admin_front_slider_update' 	  ,'uses' 	=> 'Admin\FrontSliderController@update']);
				Route::get('delete/{slider_id}',				['as' => 'admin_front_slider_delete' 	  ,'uses' 	=> 'Admin\FrontSliderController@delete']);
				Route::post('multi_action',						['as' => 'admin_front_slider_multiaction' ,'uses' 	=> 'Admin\FrontSliderController@multi_action']);
				Route::any('save_order/{slider_id}/{order_id}', ['as' => 'admin_front_slider_save_order'  ,'uses'   => 'Admin\FrontSliderController@save_order']);
		});
		/*--------------------------     Front SLider End     ---------------------------*/

		/* --------------------------   Business Listing start --------------------------   */
		Route::group(['prefix'=>'business_listing'], function()
		{
			
			Route::get('manage',					 	 			['as' => 'admin_business_listing_manage' 	  ,'uses' 	=>'Admin\BusinessListingController@index']);
			Route::get('show/{enc_id}',					 			['as' => 'admin_business_listing_show' 	  ,'uses' 	=>'Admin\BusinessListingController@show']);
			Route::get('edit/{enc_id}',								['as' => 'admin_business_listing_edit' 	  ,'uses' 	=>'Admin\BusinessListingController@edit']);
			Route::post('update/{enc_id}',				  			['as' => 'admin_business_listing_update' 	  ,'uses' 	=>'Admin\BusinessListingController@update']);
			Route::get('create',						 			['as' => 'admin_business_listing_create' 	  ,'uses' 	=>'Admin\BusinessListingController@create']);
			Route::get('toggle_status/{enc_id}/{action}',			['as' => 'admin_business_listing_status' 	  ,'uses' 	=>'Admin\BusinessListingController@toggle_status']);
			Route::get('toggle_verifired_status/{enc_id}/{action}', ['as' => 'admin_business_listing_verifired_status' 	  ,'uses' 	=>'Admin\BusinessListingController@toggle_verifired_status']);
			Route::post('multi_action',					 			['as' => 'admin_business_listing_multiaction','uses' 	=>'Admin\BusinessListingController@multi_action']);
			Route::any('store',							 			['as' => 'admin_business_listing_store' 	  ,'uses' 	=>'Admin\BusinessListingController@store']);
			Route::post('delete_gallery',				 			['as' => 'admin_business_listing_gallery_delete' 	  ,'uses' 	=>'Admin\BusinessListingController@delete_gallery']);
			Route::post('delete_service',				 			['as' => 'admin_business_listing_service_delete' 	  ,'uses' 	=>'Admin\BusinessListingController@delete_service']);
			Route::post('delete_payment_mode',		     			['as' => 'admin_business_listing_payment_mode_delete' 	  ,'uses' 	=>'Admin\BusinessListingController@delete_payment_mode']);

			Route::get('assign_membership/{enc_id}/{user_id}/{category_id}',				 ['as' => 'admin_business_listing_assign_membership' 	  ,'uses' 	=>'Admin\BusinessListingController@assign_membership']);
			Route::post('get_plan_cost/',				 			['as' => 'get_plan_cost' 	  ,'uses' 	=>'Admin\BusinessListingController@get_plan_cost']);
			Route::post('purchase_plan/',				 			['as' => 'purchase_plan' 	  ,'uses' 	=>'Admin\BusinessListingController@purchase_plan']);
			Route::any('/{serch_by?}',							 	['as' => 'admin_business_listing_index' 	  ,'uses' 	=>'Admin\BusinessListingController@index']);
			Route::get('export/{format}',							['as' => 'admin_cities_excel' 		  ,'uses' => 'Admin\BusinessListingController@export_excel']);

		});

        /* --------------------------   Business Listing End --------------------------   */



 		  Route::group(array('prefix'=>'/deals_offers'), function()
		{
			Route::get('/create',							    ['as' => 'admin_deals_offers_create' 	  , 'uses'=>'Admin\DealsOffersController@create']);
			Route::get('/get_business_by_user/{user_id}',	    ['as' => 'admin_deals_offers_get_business_by_user' 	  , 'uses'=>'Admin\DealsOffersController@get_business_by_user']);
			Route::get('/{status?}',							['as' => 'admin_deals_offers_index' 	  , 'uses'=>'Admin\DealsOffersController@index']);
			Route::post('store',							    ['as' => 'admin_deals_offers_store' 	  , 'uses'=>'Admin\DealsOffersController@store']);
			Route::get('edit/{enc_id}',							['as' => 'admin_deals_offers_edit' 		  ,'uses' 	=> 'Admin\DealsOffersController@edit']);
			Route::post('update/{enc_id}',						['as' => 'admin_deals_offers_update' 	  ,'uses' 	=> 'Admin\DealsOffersController@update']);
			Route::get('delete/{enc_id}',						['as' => 'admin_deals_offers_delete' 	  ,'uses' 	=> 'Admin\DealsOffersController@delete']);
			Route::get('toggle_status/{enc_id}/{action}',       ['as' => 'admin_deals_offers_toggle_status'     		,'uses' =>'Admin\DealsOffersController@toggle_status']);
			Route::post('multi_action',							['as' => 'admin_deals_offers_multiaction' ,'uses' 	=> 'Admin\DealsOffersController@multi_action']);
			Route::post('delete_gallery',				        ['as' => 'admin_deals_slider_delete' 	  ,'uses' 	=>'Admin\DealsOffersController@delete_gallery']);
			Route::get('export/{format}',					    ['as' => 'admin_deal_offers_excel' 		  ,'uses' => 'Admin\DealsOffersController@export_excel']);
		
		});
	/*-------------Payment Records Module------------*/
		Route::group(['prefix'=>'deals_offers_transactions'], function (){
			Route::get('/',						'Admin\DealsOffersTransactionController@index');
			Route::get('view/{enc_id}',			'Admin\DealsOffersTransactionController@view');
			Route::get('edit/{enc_id}',			'Admin\DealsOffersTransactionController@edit');
			Route::post('update/{enc_id}',		'Admin\DealsOffersTransactionController@update');
			Route::get('export/{format}',	    'Admin\DealsOffersTransactionController@export_excel');
		
		});

		Route::group(['prefix'=>'deals_bulk_request'], function (){
			Route::get('/',						'Admin\BuyInBulkRequestController@index');
			Route::get('view/{enc_id}',			'Admin\BuyInBulkRequestController@view');
			Route::get('export/{format}',	    'Admin\BuyInBulkRequestController@export_excel');
		
		});

		 Route::group(array('prefix'=>'/offers'), function()
		{
			Route::get('/{enc_id}',							    ['as' => 'admin_offers_index' 	  , 'uses'=>'Admin\OffersController@index']);
			Route::get('/create/{enc_id}',					    ['as' => 'admin_offers_create' 	  , 'uses'=>'Admin\OffersController@create']);
			Route::post('store',							    ['as' => 'admin_offers_store' 	  , 'uses'=>'Admin\OffersController@store']);
			Route::get('edit/{enc_id}',							['as' => 'admin_offers_edit' 		  ,'uses' 	=> 'Admin\OffersController@edit']);
			Route::get('show/{enc_id}',							['as' => 'admin_offers_show' 		  ,'uses' 	=> 'Admin\OffersController@show']);
			Route::post('update/{enc_id}',						['as' => 'admin_offers_update' 	  ,'uses' 	=> 'Admin\OffersController@update']);
			Route::get('delete/{enc_id}',						['as' => 'admin_offers_delete' 	  ,'uses' 	=> 'Admin\OffersController@delete']);
			Route::get('toggle_status/{enc_id}/{action}',       ['as' => 'admin_offers_toggle_status'     		,'uses' =>'Admin\OffersController@toggle_status']);
			Route::post('multi_action',							['as' => 'admin_offers_multiaction' ,'uses' 	=> 'Admin\OffersController@multi_action']);
					
		});

		/*--------------------------     Coupon Code Realted      ---------------------------*/

		Route::group(array('prefix' => '/coupons'), function()
		{
			Route::get('/',						['as' => 'admin_coupon_index'		,'uses' => 'Admin\CouponController@index']);
			
			Route::get('create/',				['as' => 'admin_coupon_create' 		,'uses' => 'Admin\CouponController@create']);
			
			Route::post('store/',				['as' => 'admin_coupon_store' 		,'uses' => 'Admin\CouponController@store']);
			
			Route::get('edit/{coupon_id}',		['as' => 'admin_coupon_edit'		,'uses' => 'Admin\CouponController@edit']);
			
			Route::get('show/{coupon_id}',		['as' => 'admin_coupon_show' 		,'uses' => 'Admin\CouponController@show']);
			
			Route::post('update/{coupon_id}',	['as' => 'admin_coupon_update' 		,'uses' => 'Admin\CouponController@update']);
			
			Route::get('delete/{coupon_id}',	['as' => 'admin_coupon_delete' 		,'uses' => 'Admin\CouponController@delete']);
			
			Route::post('multi_action',			['as' => 'admin_coupon_multiaction'	,'uses' => 'Admin\CouponController@multi_action']);
		});


	  
		/* Users Module */
		Route::group(['prefix'=>'users'], function()
		{
			Route::get('/',       								['as' => 'admin_users_index'     				,'uses' =>'Admin\UserController@index']);
			Route::get('manage',       							['as' => 'admin_users_manage'     				,'uses' =>'Admin\UserController@index']);
			Route::get('show/{enc_id}',       					['as' => 'admin_users_show'    					,'uses' =>'Admin\UserController@show']);
			Route::get('edit/{enc_id}',       					['as' => 'admin_users_edit'     				,'uses' =>'Admin\UserController@edit']);
			Route::post('update/{enc_id}',       				['as' => 'admin_users_update'    			    ,'uses' =>'Admin\UserController@update']);
			Route::get('create',       							['as' => 'admin_users_create'    			    ,'uses' =>'Admin\UserController@create']);
			Route::get('toggle_status/{enc_id}/{action}',       ['as' => 'admin_users_toggle_status'     		,'uses' =>'Admin\UserController@toggle_status']);
			Route::post('multi_action',       					['as' => 'admin_users_,multi_action'     		,'uses' =>'Admin\UserController@multi_action']);
			Route::any('store',       							['as' => 'admin_users_store'     				,'uses' =>'Admin\UserController@store']);
		});


		/* Sales User Module */

		Route::group(['prefix'=>'/sales_user'], function ()
		{
			Route::get('/',       								['as' => 'admin_sales_index'     				,'uses' =>'SalesUser\SalesController@index']);
			Route::get('manage',       							['as' => 'admin_sales_manage'     				,'uses' =>'SalesUser\SalesController@index']);
			Route::get('create',       							['as' => 'admin_sales_create'    			    ,'uses' =>'SalesUser\SalesController@create']);
			Route::post('store',								['as' => 'admin_sales_store'    			    ,'uses' =>'SalesUser\SalesController@store']);
			Route::get('edit/{enc_id}',							['as' => 'admin_sales_edit'    			        ,'uses' =>'SalesUser\SalesController@edit']);
			Route::post('update/{enc_id}',						['as' => 'admin_sales_update'    			    ,'uses' =>'SalesUser\SalesController@update']);
			Route::get('toggle_status/{enc_id}/{action}',       ['as' => 'admin_sales_toggle_status'     		,'uses' =>'SalesUser\SalesController@toggle_status']);
			Route::post('multi_action',       					['as' => 'admin_sales_multi_action'     		,'uses' =>'SalesUser\SalesController@multi_action']);

		});




		/* Categories Module */
		Route::group(array('prefix' => 'categories'), function()	{
			Route::get('/',												['as' => 'admin_categories_manage' 				,'uses' => 'Admin\CategoryController@index']);
			Route::get('show/{enc_id}',									['as' => 'admin_categories_show' 				,'uses' => 'Admin\CategoryController@show']);
			Route::get('edit/{enc_id}',									['as' => 'admin_categories_edit' 				,'uses' => 'Admin\CategoryController@edit']);
			Route::post('update/{enc_id}',								['as' => 'admin_categories_update' 				,'uses' => 'Admin\CategoryController@update']);
			Route::get('create/{cat_id?}',								['as' => 'admin_categories_create' 				,'uses' => 'Admin\CategoryController@create']);
			Route::get('toggle_status/{enc_id}/{action}',				['as' => 'admin_categories_toggle_status' 		,'uses' => 'Admin\CategoryController@toggle_status']);
			Route::post('multi_action',									['as' => 'admin_categories_block' 				,'uses' => 'Admin\CategoryController@multi_action']);
			Route::post('store',										['as' => 'admin_categories_store' 				,'uses' => 'Admin\CategoryController@store']);
			Route::get('delete/{enc_id}',								['as' => 'admin_categories_delete' 				,'uses' => 'Admin\CategoryController@delete']);
			Route::get('sub_categories/{enc_id}',						['as' => 'admin_sub_categories_store' 			,'uses' => 'Admin\CategoryController@show_sub_categories']);
			Route::post('sub_categories/update',						['as' => 'admin_sub_categories_update' 			,'uses' => 'Admin\CategoryController@update']);
			Route::get('sub_categories/toggle_status/{enc_id}/{action}',['as' => 'admin_sub_categories_toggle_status' 	,'uses' => 'Admin\CategoryController@toggle_status']);
			Route::post('sub_categories/multi_action',					['as' => 'admin_sub_categories_block' 			,'uses' => 'Admin\CategoryController@multi_action']);
			Route::get('export/{format}',					            ['as' => 'admin_sub_categories_export_excel' 	,'uses' => 'Admin\CategoryController@export_excel']);
			Route::post('check_explore_count',							['as' => 'admin_sub_categories_check_explore_count' ,'uses' => 'Admin\CategoryController@check_explore_count']);

		});


			/* Admin Membership Module */
		Route::group(['prefix'=>'membership'], function ()
		{
			Route::get('/',       								['as' => 'admin_membershp_index'     				,'uses' => 'Admin\MembershipController@index']);
			Route::get('edit/{enc_id}',							['as' => 'admin_membershp_edit' 					,'uses' => 'Admin\MembershipController@edit']);
			Route::post('update/{enc_id}',						['as' => 'admin_membershp_update' 					,'uses' => 'Admin\MembershipController@update']);

		});

		Route::group(['prefix'=>'membershipcost'], function ()
		{
			Route::get('/',       								['as' => 'admin_membershpcost_index'     				,'uses' => 'Admin\MembershipCostController@index']);
			Route::get('create',								['as' => 'admin_membershpcost_create' 				,'uses' => 'Admin\MembershipCostController@create']);
			Route::post('store',								['as' => 'admin_membershpcost_store' 				,'uses' => 'Admin\MembershipCostController@store']);
			Route::get('edit/{enc_id}',							['as' => 'admin_membershpcost_edit' 					,'uses' => 'Admin\MembershipCostController@edit']);
			Route::post('update/{enc_id}',						['as' => 'admin_membershpcost_update' 					,'uses' => 'Admin\MembershipCostController@update']);

		});
		/*-------------Payment Records Module------------*/
		Route::group(['prefix'=>'transactions'], function (){
			Route::get('/',						'Admin\TransactionController@index');
			Route::get('view/{enc_id}',			'Admin\TransactionController@view');
			Route::get('edit/{enc_id}',			'Admin\TransactionController@edit');
			Route::post('update/{enc_id}',		'Admin\TransactionController@update');
		});
		/*-------------End--------------------------*/

	/*------------------------- web_admin Contact Enquiry Related ----------*--------------------*/

	Route::group(array('prefix' => 'contact_enquiry'), function()
	{
		Route::get('/',						['as' => 'list_contact_enquiry' ,'uses' => 'Admin\ContactEnquiryController@index']);
		Route::get('show/{enc_id}',			['as' => 'show_contact_enquiry' ,'uses' => 'Admin\ContactEnquiryController@show']);

	});

    /*************************************End*****************************************************/

	/*************************News Letter Module***********************************/

	Route::group(array('prefix' => 'newsletter'), function()
	{

		Route::get('/',									['as' => 'newsletter_manage' 					,'uses' => 'Admin\NewsLetterController@index']);
		Route::get('show/{enc_id}',						['as' => 'newsletter_show' 						,'uses' => 'Admin\NewsLetterController@show']);
		Route::get('edit/{enc_id}',						['as' => 'newsletter_edit'					    ,'uses' => 'Admin\NewsLetterController@edit']);
		Route::post('update/{enc_id}',					['as' => 'admin_newsletter_update' 				,'uses' => 'Admin\NewsLetterController@update']);
		Route::get('toggle_status/{enc_id}/{action}',	['as' => 'admin_newsletter_toggle_status'		,'uses' => 'Admin\NewsLetterController@toggle_status']);
		Route::post('multi_action',						['as' => 'admin_newsletter_block' 				,'uses' => 'Admin\NewsLetterController@multi_action']);
		Route::get('create',							['as' => 'admin_newsletter_create' 				,'uses' => 'Admin\NewsLetterController@create']);
		Route::any('store',								['as' => 'admin_newsletter_store' 				,'uses' => 'Admin\NewsLetterController@store']);
		Route::get('compose',							['as' => 'admin_newsletter_compose' 			,'uses' => 'Admin\NewsLetterController@compose']);
		Route::post('send_email',						['as' => 'admin_newsletter_send_email' 			,'uses' => 'Admin\NewsLetterController@send_email']);

	});

/*****************************End************************************************/

	/*-------------Admin Deals Module------------*/
	Route::group(['prefix'=>'deals'], function (){
		Route::get('/{enc_id}',							'Admin\DealController@index');
		Route::get('create/{enc_id}',					'Admin\DealController@create');
		Route::post('store',							'Admin\DealController@store');
		Route::get('edit/{enc_id}',						'Admin\DealController@edit');
		Route::post('update/{enc_id}',					'Admin\DealController@update');
		Route::get('delete/{enc_id}',					'Admin\DealController@delete');
		Route::get('toggle_status/{enc_id}/{action}',	'Admin\DealController@toggle_status');
		Route::post('multi_action',						'Admin\DealController@multi_action');
		Route::get('get_dishes/{enc_id}',				'Admin\DealController@get_dishes');
		Route::get('delete_dish/{id}',					'Admin\DealController@delete_dish');
	});
	/*-------------End--------------------------*/

	/*-------------Website Setting Module------------*/
	Route::group(['prefix'=>'site_settings'], function (){
		Route::get('/',								['as' => 'admin_site_settings_index'  ,'uses' => 'Admin\SiteSettingController@index']);
		Route::post('update/{enc_id}',				['as' => 'admin_site_settings_update' ,'uses' => 'Admin\SiteSettingController@update']);
	});
	/*-------------End--------------------------*/

});

	                       /* Sales User Dashboard*/

	Route::group(['prefix'=>'/sales_user','middleware'=>['web']], function ()
	{


		Route::get('clear_app_cache',function ()
		{
			\Artisan::call('cache:clear');
			return redirect()->back();
		});
		
        Route::get('/',										['as' => 'sales_user_login'						,'uses' =>'SalesUser\SalesAccountController@login']);
	    Route::get('login',									['as' => 'sales_user_login'             		,'uses' =>'SalesUser\SalesAccountController@login']);
		Route::post('process_login',				  		['as' => 'sales_user_process_login'          	,'uses' =>'SalesUser\SalesAccountController@process_login']);
		Route::get('dashboard',								['as' => 'sales_user_dashboard'             	,'uses' =>'SalesUser\SalesAccountController@index']);
		Route::get('profile',								['as' => 'sales_user_profile'            	    ,'uses' =>'SalesUser\SalesAccountController@profile']);
		Route::get('edit_profile',							['as' => 'sales_user_edit_profile'            	,'uses' =>'SalesUser\SalesAccountController@edit_profile']);
		Route::post('update_profile',						['as' => 'sales_user_update_profile'            ,'uses' =>'SalesUser\SalesAccountController@update_profile']);
		Route::get('change_password',						['as' => 'sales_user_change_password'           ,'uses' =>'SalesUser\SalesAccountController@change_password']);
		Route::post('update_password',						['as' => 'sales_user_update_password'           ,'uses' =>'SalesUser\SalesAccountController@update_password']);
		Route::get('logout',								['as' => 'sales_user_logout'            	    ,'uses' =>'SalesUser\SalesAccountController@logout']);

		Route::group(array('prefix' => '/users'), function()
		{
		Route::get('/',       								['as' => 'sales_user_users_index'     				,'uses' =>'SalesUser\UserController@index']);
		Route::get('create',       							['as' => 'sales_user_users_create'    			    ,'uses' =>'SalesUser\UserController@create']);
		Route::any('store',       							['as' => 'sales_user_users_store'     				,'uses' =>'SalesUser\UserController@store']);
		Route::get('show/{enc_id}',       					['as' => 'sales_user_users_show'    				,'uses' =>'SalesUser\UserController@show']);
		Route::get('edit/{enc_id}',       					['as' => 'sales_user_users_edit'     				,'uses' =>'SalesUser\UserController@edit']);
		Route::post('update/{enc_id}',       				['as' => 'sales_user_users_update'    			    ,'uses' =>'SalesUser\UserController@update']);
		Route::get('toggle_status/{enc_id}/{action}',       ['as' => 'sales_user_users_toggle_status'     		,'uses' =>'SalesUser\UserController@toggle_status']);
		Route::post('multi_action',       					['as' => 'sales_user_users_,multi_action'     		,'uses' =>'SalesUser\UserController@multi_action']);


		});
		Route::group(['prefix'=>'business_listing'], function()
		{
			Route::any('/',							 	 ['as' => 'sales_user_business_listing_index' 	  ,'uses' 	=>'SalesUser\BusinessListingController@index']);
			Route::get('show/{enc_id}',					 ['as' => 'sales_user_business_listing_show' 	  ,'uses' 	=>'SalesUser\BusinessListingController@show']);
			Route::get('edit/{enc_id}',					 ['as' => 'sales_user_business_listing_edit' 	  ,'uses' 	=>'SalesUser\BusinessListingController@edit']);
			Route::post('update/{enc_id}',				 ['as' => 'sales_user_business_listing_update' 	  ,'uses' 	=>'SalesUser\BusinessListingController@update']);
			Route::get('create',						 ['as' => 'sales_user_business_listing_create' 	  ,'uses' 	=>'SalesUser\BusinessListingController@create']);
			Route::get('toggle_status/{enc_id}/{action}',['as' => 'sales_user_business_listing_status' 	  ,'uses' 	=>'SalesUser\BusinessListingController@toggle_status']);
			Route::post('multi_action',					 ['as' => 'sales_user_business_listing_multiaction','uses' 	=>'SalesUser\BusinessListingController@multi_action']);
			Route::any('store',							 ['as' => 'sales_user_business_listing_store' 	  ,'uses' 	=>'SalesUser\BusinessListingController@store']);
			Route::post('delete_gallery',				 ['as' => 'sales_user_business_listing_gallery_delete' 	  ,'uses' 	=>'SalesUser\BusinessListingController@delete_gallery']);
			Route::post('delete_service',				 ['as' => 'sales_user_business_listing_service_delete' 	  ,'uses' 	=>'SalesUser\BusinessListingController@delete_service']);
			Route::post('delete_service',				 ['as' => 'sales_user_business_listing_service_delete' 	  ,'uses' 	=>'SalesUser\BusinessListingController@delete_service']);
			Route::post('delete_payment_mode',		     ['as' => 'sales_user_listing_payment_mode_delete' 	  ,'uses' 	=>'SalesUser\BusinessListingController@delete_payment_mode']);
			Route::get('toggle_verifired_status/{enc_id}/{action}',['as' => 'sales_user_business_listing_verifired_status' 	  ,'uses' 	=>'SalesUser\BusinessListingController@toggle_verifired_status']);
			
			Route::get('assign_membership/{enc_id}/{user_id}/{category_id}',				 ['as' => 'sales_user_business_listing_assign_membership' 	  ,'uses' 	=>'SalesUser\BusinessListingController@assign_membership']);
			Route::post('get_plan_cost/',				 ['as' => 'get_plan_cost' 	  ,'uses' 	=>'SalesUser\BusinessListingController@get_plan_cost']);
			Route::post('purchase_plan/',				 ['as' => 'purchase_plan' 	  ,'uses' 	=>'SalesUser\BusinessListingController@purchase_plan']);

		});

			/*-------------Payment Records Module------------*/
		Route::group(['prefix'=>'transactions'], function (){
			Route::get('/',						'SalesUser\TransactionController@index');
			Route::get('view/{enc_id}',			'SalesUser\TransactionController@view');
			Route::get('edit/{enc_id}',			'SalesUser\TransactionController@edit');
			Route::post('update/{enc_id}',		'SalesUser\TransactionController@update');
		});
		/*-------------End--------------------------*/

		  Route::group(array('prefix'=>'/deals_offers'), function()
		{
			Route::get('/create',							    ['as' => 'sales_user_deals_offers_create' 	            	  , 'uses'=>'SalesUser\DealsOffersController@create']);
			Route::get('/get_business_by_user/{user_id}',	    ['as' => 'sales_user_deals_offers_get_business_by_user' 	  , 'uses'=>'SalesUser\DealsOffersController@get_business_by_user']);
			Route::get('/{status?}',							['as' => 'sales_user_deals_offers_index' 	 				  , 'uses'=>'SalesUser\DealsOffersController@index']);
			Route::post('store',							    ['as' => 'sales_user_deals_offers_store' 					  , 'uses'=>'SalesUser\DealsOffersController@store']);
			Route::get('edit/{enc_id}',							['as' => 'sales_user_deals_offers_edit' 		  			  ,'uses' 	=> 'SalesUser\DealsOffersController@edit']);
			Route::post('update/{enc_id}',						['as' => 'sales_user_deals_offers_update' 	 				  ,'uses' 	=> 'SalesUser\DealsOffersController@update']);
			Route::get('delete/{enc_id}',						['as' => 'sales_user_deals_offers_delete' 	 				  ,'uses' 	=> 'SalesUser\DealsOffersController@delete']);
			Route::get('toggle_status/{enc_id}/{action}',       ['as' => 'sales_user_deals_offers_toggle_status'     	      ,'uses' =>'SalesUser\DealsOffersController@toggle_status']);
			Route::post('multi_action',							['as' => 'sales_user_deals_offers_multiaction' 				  ,'uses' 	=> 'SalesUser\DealsOffersController@multi_action']);
			Route::post('delete_gallery',				        ['as' => 'sales_user_deals_slider_delete' 	                  ,'uses' 	=>'SalesUser\DealsOffersController@delete_gallery']);
					
		});

		 Route::group(array('prefix'=>'/offers'), function()
		{
			Route::get('/{enc_id}',							    ['as' => 'sales_user_offers_index' 	  						, 'uses'=>'SalesUser\OffersController@index']);
			Route::get('/create/{enc_id}',					    ['as' => 'sales_user_offers_create' 	   			        , 'uses'=>'SalesUser\OffersController@create']);
			Route::post('store',							    ['as' => 'sales_user_offers_store' 	  						, 'uses'=>'SalesUser\OffersController@store']);
			Route::get('edit/{enc_id}',							['as' => 'sales_user_offers_edit' 		 					,'uses' 	=> 'SalesUser\OffersController@edit']);
			Route::get('show/{enc_id}',							['as' => 'sales_user_offers_show' 		 					,'uses' 	=> 'SalesUser\OffersController@show']);
			Route::post('update/{enc_id}',						['as' => 'sales_user_offers_update' 					    ,'uses' 	=> 'SalesUser\OffersController@update']);
			Route::get('delete/{enc_id}',						['as' => 'sales_user_offers_delete' 	  					,'uses' 	=> 'SalesUser\OffersController@delete']);
			Route::get('toggle_status/{enc_id}/{action}',       ['as' => 'sales_user_offers_toggle_status'     				,'uses' =>'SalesUser\OffersController@toggle_status']);
			Route::post('multi_action',							['as' => 'sales_user_offers_multiaction' 					,'uses' 	=> 'SalesUser\OffersController@multi_action']);
					
		});

		/*-------------Business Reviews Module------------*/
		Route::group(['prefix'=>'reviews'], function (){

			Route::get('/{enc_id}',       					['as' => 'admin_reviews_manage'     ,'uses' =>  'SalesUser\ReviewController@index']);
			Route::get('view/{enc_id}',    					['as' => 'admin_reviews_view'       ,'uses' =>'SalesUser\ReviewController@view']);
			Route::get('delete/{enc_id}',   				['as' => 'admin_reviews_delete'     ,'uses' =>'SalesUser\ReviewController@delete']);
			Route::get('toggle_status/{enc_id}/{action}', 	['as' => 'admin_reviews_status'     ,'uses' =>'SalesUser\ReviewController@toggle_status']);
			Route::post('multi_action',						['as' => 'admin_reviews_multiation' ,'uses' =>'SalesUser\ReviewController@multi_action']);
		});

		
		/*------------- Sales User added  OLd Deals Module under business list ------------*/
		Route::group(['prefix'=>'deals'], function (){
			Route::get('/{enc_id}',						 ['as' => 'sales_deals_index'             		,'uses' =>'SalesUser\DealController@index']);
			Route::get('create/{enc_id}',				 ['as' => 'sales_deals_create'             		,'uses' =>'SalesUser\DealController@create']);
			Route::post('store',						 ['as' => 'sales_deals_store'             		,'uses' =>'SalesUser\DealController@store']);
			Route::get('edit/{enc_id}',					 ['as' => 'sales_deals_edit'             		,'uses' =>'SalesUser\DealController@edit']);
			Route::post('update/{enc_id}',				 ['as' => 'sales_deals_update'             		,'uses' =>'SalesUser\DealController@update']);
			Route::get('delete/{enc_id}',				 ['as' => 'sales_deals_delete'             		,'uses' =>'SalesUser\DealController@delete']);
			Route::get('toggle_status/{enc_id}/{action}',['as' => 'sales_deals_status'             		,'uses' =>'SalesUser\DealController@toggle_status']);
			Route::post('multi_action',                  ['as' => 'sales_deals_multiaction'            	,'uses' =>'SalesUser\DealController@multi_action']);

		});
		/*-------------End--------------------------*/
});


						/* Front User Routes */

Route::group(['prefix' => '/','middleware'=>['web']], function()
{
	Route::group(array('prefix' => '/listing'), function()
	{
		Route::get('/',							 	 	 ['as' => 'listing' 	        	,'uses' => 'Front\ListingController@index']);
		Route::get('details/{enc_id}',					 ['as' => 'list_details' 	        ,'uses' => 'Front\ListingController@list_details']);
		//cookies
		Route::get('showCookie',						 ['as' => 'showcookies' 	        ,'uses' => 'Front\ListingController@showCookie']);
		Route::post('cekLogin',							 ['as' => 'ceklogin' 	            ,'uses' => 'Front\ListingController@cekLogin']);

		Route::post('store_reviews',					 ['as' => 'front_store_reviews'     ,'uses' => 'Front\ListingController@store_reviews']);
  	    Route::get('share_business/{enc_id}',			 ['as' => 'business_share' 	        ,'uses' => 'Front\ListingController@share_business']);
  	    Route::get('sms_email/{enc_id}',			     ['as' => 'business_sms_email' 	    ,'uses' => 'Front\ListingController@sms_email']);
  	    // add to fav
  	    Route::post('add_to_favourite', 				 ['as' =>'add_favourite'			,'uses'=>'Front\ListingController@add_to_favourite']);
  	    Route::post('send_enquiry', 					 ['as' =>'send_enquiry'			    ,'uses'=>'Front\ListingController@send_enquiry']);
  	    Route::post('send_sms', 						 ['as' =>'send_sms'			        ,'uses'=>'Front\ListingController@send_sms']);
  	    Route::post('sms_otp_check', 					 ['as' =>'sms_otp_check'			,'uses'=>'Front\ListingController@sms_otp_check']);

	});

	Route::get('/',										'Front\HomeController@index');
	Route::post('/get_business_by_exp_categry',			'Front\HomeController@get_business_by_exp_categry');
	Route::post('/get_business_history',				'Front\HomeController@get_business_history');

	Route::post('/locate_location',						'Front\HomeController@locate_location');
	Route::get('/get_category_auto',					'Front\HomeController@get_category_auto');
	Route::get('/get_city_auto',						'Front\HomeController@get_city_auto');
	Route::post('/set_city',							'Front\HomeController@set_city');
	Route::get('/get_location_auto',					'Front\HomeController@get_location_auto');
	Route::post('/set_location_lat_lng',				'Front\CategorySearchController@set_location_lat_lng');
	Route::post('/set_distance_range',					'Front\CategorySearchController@set_distance_range');
	Route::post('/set_rating',							'Front\CategorySearchController@set_rating');
	Route::post('/clear_rating',						'Front\CategorySearchController@clear_rating');
	Route::get('/get_deal_category_auto',				'Front\HomeController@get_deal_category_auto');

	Route::group(array('prefix' => '/payumoney'), function()
	{
		Route::post('/',								'Front\PayumoneyController@index');
		Route::post('success',							'Front\PayumoneyController@payment_success');
		Route::post('fail',								'Front\PayumoneyController@payment_fail');
		Route::post('cancel',							'Front\PayumoneyController@payment_cancle');
	});

	Route::group(array('prefix' => '/order'), function()
	{
		Route::get('/offerid={offers}/{enc_id}',		'Front\OrderController@index');
		Route::post('/set_order_deal_with_promocode',   'Front\OrderController@set_order_deal_with_promocode');
		Route::post('/remove_promocode',   				'Front\OrderController@remove_promocode');
		Route::post('/payment',						    'Front\OrderController@payment');
		Route::post('/success',							'Front\OrderController@payment_success');
		Route::post('/fail',							'Front\OrderController@payment_fail');
		Route::post('/cancel',							'Front\OrderController@payment_cancle');

		
	});

	/*--------------------------WEB SERVICES-------------------------*/


	Route::group(['prefix'=>'api','middleware'=>'api'],function()
	{

        /* User Register Service */
		Route::post('register',					        ['as' => 'front_users_register'        				,'uses' =>'Api\AuthController@register']);
		
		/* User  Login Service*/
		Route::post('login',							['as' => 'front_users_profile'        				,'uses' =>'Api\AuthController@login']);
		
		/* User  Chnage Password Service*/
		Route::post('change_password',					['as' => 'front_users_change_password'        		,'uses' =>'Api\AuthController@change_password']);
		
		/*  Profile Edit Service */
		Route::get('edit',					            ['as' => 'front_users_edit'        				    ,'uses' =>'Api\AuthController@edit']);


	    Route::post('update',					        ['as' => 'front_users_profile_update'        	    ,'uses' =>'Api\AuthController@update']);
		
		/* Recover Password Service:  check valid email and send the reset password link through email
	     */
		Route::post('recover_password',					['as' => 'front_users_recover_password'        		,'uses' =>'Api\AuthController@recover_password']);
		
	    /* Edit Front user address */
	    Route::get('edit_address',						['as' => 'front_users_address'        				,'uses' =>'Api\AuthController@edit_address']);
		
		/* Update Front user address */
		Route::post('update_address',			        ['as' => 'update_address'                           ,'uses' =>'Api\AuthController@update_address']);

		/* Register Via Facebook*/
		Route::post('register_via_facebook',			['as' => 'register_via_facebook'                    ,'uses' =>'Api\AuthController@register_via_facebook']);

		/* Register Via Facebook*/
		Route::post('register_via_google_plus',			['as' => 'register_via_google_plus'                    ,'uses' =>'Api\AuthController@register_via_google_plus']);

			/* Front Get all main category Route*/
		Route::post('get_all_main_Category',			['as' => 'get_all_main_Category'                    ,'uses' =>'Api\FrontAllCategoryController@get_all_main_Category']);	

		/* Front Get all sub category of main category Route*/
		Route::post('get_all_sub_category',			['as' => 'get_all_sub_category'                    ,'uses' =>'Api\FrontAllCategoryController@get_all_sub_category']);
	         /* Front Business Listing Route*/
		Route::post('get_business_listing',			['as' => 'get_business_listing'                    ,'uses' =>'Api\FrontAllCategoryController@get_business_listing']);

			/* Front Business Route*/	
		Route::group(array('prefix' => '/business'), function()
		{

			Route::post('/',       						['as' => 'business_index'     				,'uses' =>'Api\FrontBusinessController@index']);
			Route::post('favorite',       			    ['as' => 'business_favorite'     			,'uses' =>'Api\FrontBusinessController@favorite']);
			Route::post('my_order',       			    ['as' => 'business_my_order'     			,'uses' =>'Api\FrontBusinessController@my_order']);
			Route::post('toggle_favourite',       	    ['as' => 'business_toggle_favourite'     	,'uses' =>'Api\FrontBusinessController@toggle_favourite']);
			Route::post('store_business_step1',       	['as' => 'business_store_business_step1'    ,'uses' =>'Api\FrontBusinessController@store_business_step1']);
			Route::post('store_business_step2',       	['as' => 'business_store_business_step2'    ,'uses' =>'Api\FrontBusinessController@store_business_step2']);
			Route::post('store_business_step3',       	['as' => 'business_store_business_step3'    ,'uses' =>'Api\FrontBusinessController@store_business_step3']);
			Route::post('store_business_step4',       	['as' => 'business_store_business_step4'    ,'uses' =>'Api\FrontBusinessController@store_business_step4']);
			Route::post('store_business_step5',       	['as' => 'business_store_business_step5'    ,'uses' =>'Api\FrontBusinessController@store_business_step5']);

			Route::any('edit_business_step',      	 	['as' => 'business_edit_business_step'    	,'uses' =>'Api\FrontBusinessController@edit_business_step']);
			
			/* Update Business */
			Route::post('update_business_step1',       	['as' => 'business_update_business_step1'    ,'uses' =>'Api\FrontBusinessController@update_business_step1']);
			Route::post('update_business_step2',       	['as' => 'business_update_business_step2'    ,'uses' =>'Api\FrontBusinessController@update_business_step2']);
			Route::post('update_business_step3',       	['as' => 'business_update_business_step3'    ,'uses' =>'Api\FrontBusinessController@update_business_step3']);
			Route::post('update_business_step4',       	['as' => 'business_update_business_step4'    ,'uses' =>'Api\FrontBusinessController@update_business_step4']);
			Route::post('update_business_step5',       	['as' => 'business_update_business_step5'    ,'uses' =>'Api\FrontBusinessController@update_business_step5']);
			
            /* Perticular item delete service (Gallery Image & Services )*/
			Route::post('delete_gallery',       		['as' => 'delete_gallery'    				,'uses' =>'Api\FrontBusinessController@delete_gallery']);
			Route::post('delete_service',       		['as' => 'delete_service'   				,'uses' =>'Api\FrontBusinessController@delete_service']);
			
		});
		
		/* Assign Membership*/
		Route::post('assign_membership',					['as' => 'assign_membership' 	  ,'uses' 	=>'Api\MembershipPlanController@assign_membership']);
		Route::post('get_plan_cost',				 	['as' => 'get_plan_cost' 	      ,'uses' 	=>'Api\MembershipPlanController@get_plan_cost']);
		Route::post('manual_plan_purchase',				 	['as' => 'manual_plan_purchase' 	      ,'uses' 	=>'Api\MembershipPlanController@manual_plan_purchase']);


		/* Common service for getting the state ,city & pincode */
		Route::group(array('prefix' => '/location_common'), function()
		{
			Route::get('get_states_by_country',  		['as' => 'get_states_by_country' 					,'uses' => 'Api\CommonController@get_states_by_country']);
			Route::get('get_cities_by_state',  			['as' => 'get_cities_by_state' 						,'uses' => 'Api\CommonController@get_cities_by_state']);
			Route::get('get_postalcode_by_city',        ['as' => 'get_postalcode_by_city' 					,'uses' => 'Api\CommonController@get_postalcode_by_city']);
		});

		/* Common service for getting the Subcategory */
		Route::group(array('prefix' => '/category_common'), function()
		{
			Route::post('get_sub_category_by_main',  		['as' => 'get_states_by_country' 					,'uses' => 'Api\CommonController@get_sub_category_by_main']);
			Route::post('get_main_category',  				['as' => 'get_main_category' 					,'uses' => 'Api\CommonController@get_main_category']);
		});

		/* Common service for getting the selected business users */
		Route::group(array('prefix' => '/user_common'), function()
		{
			Route::post('get_users_by_sales_executive',  		['as' => 'get_users_by_sales_executive' 					,'uses' => 'Api\CommonController@get_users_by_sales_executive']);
		
		});


		/* create vendor */

		Route::group(array('prefix' => '/venders'), function()
		{
			Route::get('/',       								['as' => 'vender_index'     				,'uses' =>'Api\VenderController@index']);
			Route::post('store',       							['as' => 'vender_store'     				,'uses' =>'Api\VenderController@store']);
			Route::get('edit',       							['as' => 'vender_edit'     					,'uses' =>'Api\VenderController@edit']);
			Route::post('update',       						['as' => 'vender_update'    			    ,'uses' =>'Api\VenderController@update']);
			
			Route::post('toggle_status',       					['as' => 'vender_toggle_status'     		,'uses' =>'Api\VenderController@toggle_status']);
			Route::post('multi_action',       					['as' => 'vender_,multi_action'     		,'uses' =>'Api\VenderController@multi_action']);


		});

	
		/* Sales Executive Business Route*/

		Route::group(array('prefix' => '/sales_user'), function()
		{
			   Route::post('/dashboard',  ['as' => 'business_index', 'uses' =>'Api\SalesExecutiveDashboardController@dashboard']);
			
			Route::group(array('prefix' => '/business'), function()
		    {
		    	//Business listing
				Route::post('/',  ['as' => 'business_index', 'uses' =>'Api\SalesExecutiveBusinessController@index']);
				
				// Add business  
			  	Route::group(array('prefix' => '/add'), function()
			    {
					Route::post('/', ['as'=>'add_step1', 'uses'=>'Api\SalesExecutiveBusinessController@store_business_step1']);
					Route::post('step2', ['as'=>'add_step2', 'uses'=>'Api\SalesExecutiveBusinessController@store_business_step2']);
					Route::post('step3', ['as'=>'add_step3', 'uses'=>'Api\SalesExecutiveBusinessController@store_business_step3']);
					Route::post('step4', ['as'=>'add_step4', 'uses'=>'Api\SalesExecutiveBusinessController@store_business_step4']);
					Route::post('step5', ['as'=>'add_step5', 'uses'=>'Api\SalesExecutiveBusinessController@store_business_step5']);
				});

			    //edit business
			   Route::post('/edit',  ['as' => 'business_index', 'uses' =>'Api\SalesExecutiveBusinessController@edit']);

			    //update business
				Route::group(array('prefix' => '/update'), function()
			    {
					Route::post('/', ['as'=>'edit_step1', 'uses'=>'Api\SalesExecutiveBusinessController@update_business_step1']);
					Route::post('step2', ['as'=>'edit_step2', 'uses'=>'Api\SalesExecutiveBusinessController@update_business_step2']);
					Route::post('step3', ['as'=>'edit_step3', 'uses'=>'Api\SalesExecutiveBusinessController@update_business_step3']);
					Route::post('step4', ['as'=>'edit_step4', 'uses'=>'Api\SalesExecutiveBusinessController@update_business_step4']);
					Route::post('step5', ['as'=>'edit_step5', 'uses'=>'Api\SalesExecutiveBusinessController@update_business_step5']);
				});

				//delete gallery image
				 Route::post('/delete_gallery',  ['as' => 'business_index', 'uses' =>'Api\SalesExecutiveBusinessController@delete_gallery']);
				//delete service
				Route::post('/delete_service',  ['as' => 'business_index', 'uses' =>'Api\SalesExecutiveBusinessController@delete_service']); 
				//business verification
				Route::post('/toggle_verifired_status',  ['as' => 'toggle_verifired_status', 'uses' =>'Api\SalesExecutiveBusinessController@toggle_verifired_status']);
				//business status update
				Route::post('/active_status',  ['as' => 'active_status', 'uses' =>'Api\SalesExecutiveBusinessController@_active_status']);
				//business delete
				Route::post('/delete',  ['as' => 'delete', 'uses' =>'Api\SalesExecutiveBusinessController@_delete']);
				
				//Review 
				Route::post('/review_index',  ['as' => 'delete', 'uses' =>'Api\SalesExecutiveBusinessController@review_index']);

				Route::post('/show_review',  ['as' => 'show_review', 'uses' =>'Api\SalesExecutiveBusinessController@show_review']);

                 Route::post('/review_toggle_status',  ['as' => 'review_toggle_status', 'uses' =>'Api\SalesExecutiveBusinessController@review_toggle_status']);

			});
			
			

        });  


	});

	/*------------------------END-------------------------------------*/















	/*--------------------------Front-login-section-------------------------------*/

	Route::any('/facebook/register',					'Front\AuthController@register_via_facebook');
	Route::any('/google_plus/register',					'Front\AuthController@register_via_google_plus');

	/*---------------------------------End----------------------------------------*/

	Route::group(array('prefix' => '/page'), function()
	{
		Route::get('aboutus',							 ['as' => 'about_us' 		    ,'uses' => 'Front\CMSController@aboutus']);
		Route::get('{slug}',							 ['as' => 'static_page' 		,'uses' => 'Front\CMSController@page']);
	});


	Route::group(array('prefix' => '/contact_us' ), function()
	{
		Route::get('/',									 ['as' => 'contact_us_form'      ,'uses' => 'Front\ContactUsController@index']);
		Route::post('store',							 ['as' => 'contact_us_store'     ,'uses' => 'Front\ContactUsController@store']);

	});
	Route::get('/faqs',									 ['as' => 'contact_us_form'      ,'uses' => 'Front\FaqController@index']);
	Route::group(array('prefix' => '/front_users'), function()
	{
		Route::any('store',								['as' => 'front_users_store'    		  		    ,'uses' =>'Front\UserController@store']);
		Route::post('process_login',					['as' => 'front_users_process_login'        		,'uses' =>'Front\AuthController@process_login']);
		Route::post('recover_password',					['as' => 'front_users_recover_password'        		,'uses' =>'Front\AuthController@recover_password']);
		Route::get('/validate_reset_password_link/{enc_id}/{enc_reminder_code}','Front\AuthController@validate_reset_password_link');
	    Route::post('/reset_password','Front\AuthController@reset_password');

		// for testing  using ajax.
		Route::post('process_login_ajax',				['as' => 'front_users_process_login'        		,'uses' =>'Front\AuthController@process_login_ajax']);

		Route::get('profile',							['as' => 'front_users_profile'        				,'uses' =>'Front\UserController@profile']);
		Route::post('store_personal_details',			['as' => 'front_users_store_personal_details'       ,'uses' =>'Front\UserController@store_personal_details']);

		Route::get('address',							['as' => 'front_users_address'        				,'uses' =>'Front\UserController@address']);
		Route::post('store_address_details',			['as' => 'front_users_store_address_details'        ,'uses' =>'Front\UserController@store_address_details']);

		Route::get('my_business/{page?}',						['as' => 'front_users_business'        				,'uses' =>'Front\UserController@my_business']);

		// for adding business.
		Route::get('add_business',		    			['as' => 'business_add' 	        				,'uses' =>'Front\UserController@add_business']);
		// for getting country state from city_id ajax called function.
		Route::post('get_state',		    			['as' => 'get_state' 	        		    		,'uses' =>'Front\UserController@get_state']);

		Route::post('get_city',		    				['as' => 'get_city' 	        		    		,'uses' =>'Front\UserController@get_city']);

		Route::post('get_zip',		    				['as' => 'get_zip' 	        		    			,'uses' =>'Front\UserController@get_zip']);


		// for saving business data.
		Route::post('add_business_details',		    	['as' => 'business_add' 	        				,'uses' =>'Front\UserController@add_business_details']);
		// for showing contact information page for business
		Route::get('add_contacts/{enc_id}',		    	['as' => 'business_contacts' 	        			,'uses' =>'Front\UserController@show_business_contacts_details']);
		// for showing contact information page for business
		Route::post('add_contacts_details',		    	['as' => 'business_contacts' 	        			,'uses' =>'Front\UserController@add_contacts_details']);

			// for showing contact information page for business
		Route::post('add_other_details',		    	['as' => 'add_other_details' 	        			,'uses' =>'Front\UserController@add_other_details']);



		// for saving business data.
		Route::post('add_location_details',		    	['as' => 'add_location' 	        				,'uses' =>'Front\UserController@add_location_details']);
		// For adding other inforamation  for business
		Route::get('other_details/{enc_id}',		    ['as' => 'other_information' 	        			,'uses' =>'Front\UserController@show_other_info_details']);
		// For getting location info
		Route::get('add_location/{enc_id}',		    	['as' => 'show_location_details' 	        		,'uses' =>'Front\UserController@show_location_details']);
		// For getting Services Page.
		Route::get('add_services/{enc_id}',		    	['as' => 'show_services_details' 	        	    ,'uses' =>'Front\UserController@show_services_details']);

		Route::post('add_services_details',		    	['as' => 'add_services_details' 	        		,'uses' =>'Front\UserController@add_services_details']);
		//Get My favourites Businesses page.
		Route::get('my_favourites/{page?}',		    	['as' => 'my_favourite_businesses' 	        		,'uses' =>'Front\UserController@my_favourite_businesses']);

	    Route::get('edit_business_step1/{enc_id}',		    ['as' => 'business_edit1' 	        				,'uses' =>'Front\UserController@edit_business_step1']);
	    Route::post('update_business_step1/{enc_id}',		['as' => 'update_business_step1' 	        		,'uses' =>'Front\UserController@update_business_step1']);
	    Route::get('edit_business_step2/{enc_id}',		    ['as' => 'business_edit2' 	        				,'uses' =>'Front\UserController@edit_business_step2']);
	    Route::post('update_business_step2/{enc_id}',		['as' => 'update_business_step1' 	        		,'uses' =>'Front\UserController@update_business_step2']);
	    Route::get('edit_business_step3/{enc_id}',		    ['as' => 'business_edit3' 	        				,'uses' =>'Front\UserController@edit_business_step3']);
	    Route::post('update_business_step3/{enc_id}',		['as' => 'update_business_step3' 	        		,'uses' =>'Front\UserController@update_business_step3']);
	    Route::get('edit_business_step4/{enc_id}',		    ['as' => 'business_edit4' 	        				,'uses' =>'Front\UserController@edit_business_step4']);
	    Route::post('update_business_step4/{enc_id}',		['as' => 'update_business_step4' 	        		,'uses' =>'Front\UserController@update_business_step4']);
	    Route::post('delete_payment_mode',		       		['as' => 'delete_payment_mode' 	 					,'uses'=>'Front\UserController@delete_payment_mode']);
	    Route::get('edit_business_step5/{enc_id}',		    ['as' => 'business_edit5' 	        				,'uses' =>'Front\UserController@edit_business_step5']);
	    Route::post('update_business_step5/{enc_id}',		['as' => 'update_business_step5' 	        		,'uses' =>'Front\UserController@update_business_step5']);
	    Route::post('delete_gallery',		       		   	['as' => 'delete_gallery' 	 				  		,'uses'=>'Front\UserController@delete_gallery']);
	    Route::post('delete_service',		       			['as' => 'delete_service' 	 						,'uses'=>'Front\UserController@delete_service']);

		Route::get('logout',								['as' => 'front_users_logout'     					,'uses' =>'Front\AuthController@logout']);
		Route::get('change_password',				  		['as' => 'front_users_change_password'              ,'uses' =>'Front\AuthController@change_password']);
		Route::post('update_password',				  		['as' => 'front_users_update_password'				,'uses' =>'Front\AuthController@update_password']);

		Route::post('process_login_for_share/{enc_id}', 	['as' => 'front_users_process_login_for_share'      ,'uses' =>'Front\AuthController@process_login_for_share']);
		Route::post('otp_check', ['as' => 'front_users_otp_check'      ,'uses' =>'Front\UserController@otp_check']);


		Route::get('assign_membership/{enc_id}/{business_name}/{user_id}/{category_id}',						 ['as' => 'assign_membership' 	  ,'uses' 	=>'Front\MembershipPlanController@assign_membership']);
		Route::post('get_plan_cost/',				 		['as' => 'get_plan_cost' 	 					     ,'uses' 	=>'Front\MembershipPlanController@get_plan_cost']);

		/* My Orders*/
		Route::get('my_order/{page?}',								['as' => 'front_users_business'        				,'uses' =>'Front\UserController@my_order']);


	});

	Route::group(array('prefix' => '/{city}'), function()
	{
		Route::get('deals/',								['as' =>'deals_page'								,'uses' =>'Front\DealController@index']);
		Route::get('deals/cat-{cat_slug}/{sub_cat_slug}',   ['as' =>'deals_by_category'							,'uses' =>'Front\DealController@deals_by_category']);
		Route::get('deals/{deal_slug}/{enc_id}',			['as' =>'deals_detail'								,'uses' =>'Front\DealController@details']);
		Route::get('deals/{cat_slug}',						['as' =>'deals_by_category'							,'uses' =>'Front\DealController@deals_by_category']);
		Route::post('fetch_location_deal',					['as' =>'deals_by_location'							,'uses' =>'Front\DealController@fetch_location_deal']);
		Route::any('bulk_booking_form',				    ['as' =>'deals_buy_in_bulk'							,'uses' =>'Front\DealController@bulk_booking_form']);
		Route::post('booking_order',				        ['as' =>'deals_buy_in_bulk'							,'uses' =>'Front\DealController@booking_order']);
	});

	Route::group(array('prefix' => '/bulk-order'), function ()
	{
		Route::get('bulk-booking',								['as' =>'deals_buy_booking'							,'uses' =>'Front\DealController@bulk_booking']);
		
	});
	Route::post('/newsletter','Front\NewsLetterController@index');
	Route::group(array('prefix' => '/{city}'), function ()
	{
		Route::get('popular-city',								'Front\AllCategoryController@popular_city');
		Route::get('all-categories',							'Front\AllCategoryController@index');
		Route::get('category-{cat_slug}/{cat_id}',				'Front\CategorySearchController@index');
		Route::get('all-options/ct-{cat_id}/{ajax?}',			'Front\CategorySearchController@get_business');
		Route::get('{cat_location}/ct-{cat_id}/{ajax?}',		'Front\CategorySearchController@search_business_by_location');
		Route::get('{business_area}/{cat_id}',					'Front\ListingController@list_details');

	});

	Route::post('forgot_password',								'Front\PasswordController@postEmail');
	Route::get('password_reset/{code}',							'Front\PasswordController@getReset');
	Route::post('process_reset_password',						'Front\PasswordController@postReset');



});




/*Role Methods*/


Route::get('/assign_permission_to_role',function()
{
	$role = Sentinel::findRoleById(4);

	$role->permissions = [
	    'admin' => false,
	];

	$role->save();
});

Route::get('/assign_role',function()
{
	$role = Sentinel::findRoleBySlug('restaurant_admin');

	$user = Sentinel::findById(8); //assgning role to perticular user id statically.

	$user->roles()->attach($role);

});
