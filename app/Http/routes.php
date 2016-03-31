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
		Route::get('logout',						  ['as' => 'admin_logout',			   	   'uses' => 'Admin\AuthController@logout']);
		Route::get('change_password',				  ['as' => 'admin_change_password',		   'uses' => 'Admin\AuthController@change_password']);
		Route::post('update_password',				  ['as' => 'admin_update_password',		   'uses' => 'Admin\AuthController@update_password']);
		Route::get('edit_profile',					  ['as' => 'admin_edit_profile',		   'uses' => 'Admin\AuthController@profile']);
		Route::post('updateprofile',				  ['as' => 'admin_update_profile',		   'uses' => 'Admin\AuthController@updateprofile']);


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

			Route::get('/',['as' => 'admin_places_manage' ,'uses' => 'Admin\PlaceController@index']);
			Route::get('show/{enc_id}',['as' => 'admin_places_show' ,'uses' => 'Admin\PlaceController@show']);
			Route::get('edit/{enc_id}',['as' => 'admin_places_edit' ,'uses' => 'Admin\PlaceController@edit']);
			Route::post('update/{enc_id}',['as' => 'admin_places_update' ,'uses' => 'Admin\PlaceController@update']);
			Route::get('create',['as' => 'admin_places_create' ,'uses' => 'Admin\PlaceController@create']);
			Route::get('toggle_status/{enc_id}/{action}',['as' => 'admin_places_toggle_status' ,'uses' => 'Admin\PlaceController@toggle_status']);
			Route::post('multi_action',['as' => 'admin_places_multiaction' ,'uses' => 'Admin\PlaceController@multi_action']);
			Route::any('store',['as' => 'admin_places_store' ,'uses' => 'Admin\PlaceController@store']);
			//Route::any('nearby_destinations/{enc_id}',['as' => 'admin_nearby_destinations' ,'uses' => 'Admin\PlaceController@nearby_destinations']);
			//Route::any('add_destinations',['as' => 'admin_add_destinations' ,'uses' => 'Admin\PlaceController@add_destinations']);
			Route::get('delete/{enc_id}',['as' => 'admin_places_delete' ,'uses' => 'Admin\PlaceController@delete']);

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
			Route::get('get_states/{country_id}',  ['as' => 'get_states' ,'uses' => 'Common\CountryController@get_states']);

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
			Route::get('/',							 	 ['as' => 'admin_business_listing_index' 	  ,'uses' 	=>'Admin\BusinessListingController@index']);
			Route::get('manage',					 	 ['as' => 'admin_business_listing_manage' 	  ,'uses' 	=>'Admin\BusinessListingController@index']);
			Route::get('show/{enc_id}',					 ['as' => 'admin_business_listing_show' 	  ,'uses' 	=>'Admin\BusinessListingController@show']);
			Route::get('edit/{enc_id}',					 ['as' => 'admin_business_listing_edit' 	  ,'uses' 	=>'Admin\BusinessListingController@edit']);
			Route::post('update/{enc_id}',				 ['as' => 'admin_business_listing_update' 	  ,'uses' 	=>'Admin\BusinessListingController@update']);
			Route::get('create',						 ['as' => 'admin_business_listing_create' 	  ,'uses' 	=>'Admin\BusinessListingController@create']);
			Route::get('toggle_status/{enc_id}/{action}',['as' => 'admin_business_listing_status' 	  ,'uses' 	=>'Admin\BusinessListingController@toggle_status']);
			Route::post('multi_action',					 ['as' => 'admin_business_listing_multiaction','uses' 	=>'Admin\BusinessListingController@multi_action']);
			Route::any('store',							 ['as' => 'admin_business_listing_store' 	  ,'uses' 	=>'Admin\BusinessListingController@store']);
			Route::post('delete_gallery',				 ['as' => 'admin_business_listing_gallery_delete' 	  ,'uses' 	=>'Admin\BusinessListingController@delete_gallery']);
			Route::post('delete_service',				 ['as' => 'admin_business_listing_service_delete' 	  ,'uses' 	=>'Admin\BusinessListingController@delete_service']);
			Route::post('delete_payment_mode',		     ['as' => 'admin_business_listing_payment_mode_delete' 	  ,'uses' 	=>'Admin\BusinessListingController@delete_payment_mode']);

			Route::get('export/{format}',					['as' => 'admin_cities_excel' 		  ,'uses' => 'Admin\BusinessListingController@export_excel']);

		});

        /* --------------------------   Business Listing End --------------------------   */

		/*-------------Deals Module Start ------------*/
	    Route::group(['prefix'=>'deals'], function()
	    {

			Route::get('/{enc_id}',							['as' => 'admin_deals_index' 	  ,'Admin\DealController@index']);
			Route::get('create/{enc_id}',					['as' => 'admin_deals_create' 	  ,'Admin\DealController@create']);
			Route::post('store',							['as' => 'admin_deals_store' 	  ,'Admin\DealController@store']);
			Route::get('edit/{enc_id}',						['as' => 'admin_deals_edit' 	  ,'Admin\DealController@edit']);
			Route::post('update/{enc_id}',					['as' => 'admin_deals_update' 	  ,'Admin\DealController@update']);
			Route::get('delete/{enc_id}',					['as' => 'admin_deals_delete' 	  ,'Admin\DealController@delete']);
			Route::get('toggle_status/{enc_id}/{action}',   ['as' => 'admin_deals_status' 	  ,'Admin\DealController@toggle_status']);
			Route::post('multi_action',						['as' => 'admin_deals_multiaction','Admin\DealController@multi_action']);

	   });
	    /*-------------Deals Module End ------------*/


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
			Route::get('export/{format}',					['as' => 'admin_sub_categories_block' 			,'uses' => 'Admin\CategoryController@export_excel']);

		});


			/* Admin Membership Module */
		Route::group(['prefix'=>'membership'], function ()
		{
			Route::get('/',       								['as' => 'admin_membershp_index'     				,'uses' => 'Admin\MembershipController@index']);
			Route::get('edit/{enc_id}',							['as' => 'admin_membershp_edit' 					,'uses' => 'Admin\MembershipController@edit']);
			Route::post('update/{enc_id}',						['as' => 'admin_membershp_update' 					,'uses' => 'Admin\MembershipController@update']);

		});


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
		Route::get('/{enc_id}','Admin\DealController@index');
		Route::get('create/{enc_id}','Admin\DealController@create');
		Route::post('store','Admin\DealController@store');
		Route::get('edit/{enc_id}','Admin\DealController@edit');
		Route::post('update/{enc_id}','Admin\DealController@update');
		Route::get('delete/{enc_id}','Admin\DealController@delete');
		Route::get('toggle_status/{enc_id}/{action}','Admin\DealController@toggle_status');
		Route::post('multi_action','Admin\DealController@multi_action');
		Route::get('get_dishes/{enc_id}','Admin\DealController@get_dishes');
		Route::get('delete_dish/{id}','Admin\DealController@delete_dish');
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
			Route::get('/',							 	 ['as' => 'sales_user_business_listing_index' 	  ,'uses' 	=>'SalesUser\BusinessListingController@index']);
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
			Route::post('delete_payment_mode',		     ['as' => 'admin_business_listing_payment_mode_delete' 	  ,'uses' 	=>'SalesUser\BusinessListingController@delete_payment_mode']);

		});




		/*------------- Sales User added Deals Module under business list ------------*/
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
		Route::post('store_reviews/{enc_id}',			 ['as' => 'front_store_reviews'     ,'uses' => 'Front\ListingController@store_reviews']);
  	    Route::get('share_business/{enc_id}',			 ['as' => 'business_share' 	        ,'uses' => 'Front\ListingController@share_business']);
  	    Route::get('sms_email/{enc_id}',			     ['as' => 'business_sms_email' 	    ,'uses' => 'Front\ListingController@sms_email']);

	});

	Route::get('/','Front\HomeController@index');
	Route::post('/locate_location','Front\HomeController@locate_location');
	Route::get('/get_category_auto','Front\HomeController@get_category_auto');
	Route::get('/get_city_auto','Front\HomeController@get_city_auto');
	Route::post('/set_city','Front\HomeController@set_city');
	Route::get('/get_location_auto','Front\HomeController@get_location_auto');
	Route::post('/set_location_lat_lng','Front\CategorySearchController@set_location_lat_lng');
	Route::post('/set_distance_range','Front\CategorySearchController@set_distance_range');
	Route::post('/set_rating','Front\CategorySearchController@set_rating');
	Route::post('/clear_rating','Front\CategorySearchController@clear_rating');



	/*--------------------------Front-login-section-------------------------------*/

	Route::any('/facebook/register','Front\AuthController@register_via_facebook');
	Route::any('/google_plus/register','Front\AuthController@register_via_google_plus');

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

	Route::group(array('prefix' => '/front_users'), function()
	{
		Route::any('store',								['as' => 'front_users_store'    		  		    ,'uses' =>'Front\UserController@store']);
		Route::post('process_login',					['as' => 'front_users_process_login'        		,'uses' =>'Front\AuthController@process_login']);
		// for testing  using ajax.
		Route::post('process_login_ajax',				['as' => 'front_users_process_login'        		,'uses' =>'Front\AuthController@process_login_ajax']);

		Route::get('profile',							['as' => 'front_users_profile'        				,'uses' =>'Front\UserController@profile']);
		Route::post('store_personal_details',			['as' => 'front_users_store_personal_details'       ,'uses' =>'Front\UserController@store_personal_details']);

		Route::get('address',							['as' => 'front_users_address'        				,'uses' =>'Front\UserController@address']);
		Route::post('store_address_details',			['as' => 'front_users_store_address_details'        ,'uses' =>'Front\UserController@store_address_details']);

		Route::get('my_business',						['as' => 'front_users_business'        				,'uses' =>'Front\UserController@my_business']);
		// for adding business.
		Route::get('add_business',		    			['as' => 'business_add' 	        				,'uses' =>'Front\UserController@add_business']);
		// for getting country state from city_id ajax called function.
		Route::post('get_state_country',		    	['as' => 'get_state_country' 	        		    ,'uses' =>'Front\UserController@get_state_country']);
		// for saving business data.
		Route::post('add_business_details',		    	['as' => 'business_add' 	        				,'uses' =>'Front\UserController@add_business_details']);
		// for showing contact information page for business
		Route::get('add_contacts',		    			['as' => 'business_contacts' 	        			,'uses' =>'Front\UserController@show_business_contacts_details']);



	    Route::get('edit_business/{enc_id}',		    ['as' => 'business_edit' 	        				,'uses' =>'Front\UserController@edit_business']);
		Route::post('update_business_details/{enc_id}',	['as' => 'front_users_store_business_details'       ,'uses' =>'Front\UserController@update_business_details']);

		Route::get('logout',							['as' => 'front_users_logout'     					,'uses' =>'Front\AuthController@logout']);
		Route::get('change_password',				  	['as' => 'front_users_change_password'              ,'uses' =>'Front\AuthController@change_password']);
		Route::post('update_password',				  	['as' => 'front_users_update_password'				,'uses' =>'Front\AuthController@update_password']);

		Route::post('process_login_for_share/{enc_id}', ['as' => 'front_users_process_login_for_share'      ,'uses' =>'Front\AuthController@process_login_for_share']);



	});

	Route::group(array('prefix' => '/deals'), function()
	{
		Route::get('/',									['as' =>'deals_page'								,'uses' =>'Front\DealController@index']);
		Route::get('details/{enc_id}',					['as' =>'deals_detail'								,'uses' =>'Front\DealController@details']);
	});

	Route::post('/newsletter','Front\NewsLetterController@index');
	Route::group(array('prefix' => '/{city}'), function ()
	{
		Route::get('popular-city','Front\AllCategoryController@popular_city');
		Route::get('all-categories','Front\AllCategoryController@index');
		Route::get('category-{cat_slug}/{cat_id}','Front\CategorySearchController@index');
		Route::get('all-options/ct-{cat_id}','Front\CategorySearchController@get_business');
		Route::get('{cat_location}/ct-{cat_id}','Front\CategorySearchController@search_business_by_location');
		Route::get('{business_area}/{cat_id}','Front\ListingController@list_details');

	});


	Route::post('forgot_password','Front\PasswordController@postEmail');
	Route::get('password_reset/{code}','Front\PasswordController@getReset');
	Route::post('process_reset_password','Front\PasswordController@postReset');



});


/*--------------------------WEB SERVICES-------------------------*/

Route::group(['prefix'=>'api','middleware'=>'api'],function()
{



});

/*------------------------END-------------------------------------*/

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
