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
		/* Front Pages */
		Route::get('static_pages',['as'=>'static_pages', 'uses'=>'Admin\StaticPageController@index']);

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

		});

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

		/*-------------Business Reviews Module Start------------*/
		Route::group(['prefix'=>'reviews'], function(){
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
			Route::post('delete_gallery',				 ['as' => 'admin_business_listing_delete' 	  ,'uses' 	=>'Admin\BusinessListingController@delete_gallery']);


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
	Route::group(['prefix'=>'sales_user'], function()
	{
		Route::get('/',       								['as' => 'admin_sales_index'     				,'uses' =>'Admin\SalesController@index']);
		Route::get('manage',       							['as' => 'admin_sales_manage'     				,'uses' =>'Admin\SalesController@index']);
		Route::get('create',       							['as' => 'admin_sales_create'    			    ,'uses' =>'Admin\SalesController@create']);
		Route::post('store',								['as' => 'admin_sales_store'    			    ,'uses' =>'Admin\SalesController@store']);
		Route::get('edit/{enc_id}',							['as' => 'admin_sales_edit'    			        ,'uses' =>'Admin\SalesController@edit']);
		Route::post('update/{enc_id}',						['as' => 'admin_sales_update'    			    ,'uses' =>'Admin\SalesController@update']);
		Route::get('toggle_status/{enc_id}/{action}',       ['as' => 'admin_sales_toggle_status'     		,'uses' =>'Admin\SalesController@toggle_status']);
		Route::post('multi_action',       					['as' => 'admin_sales_multi_action'     		,'uses' =>'Admin\SalesController@multi_action']);

	});

     /* Sales User Dashboard*/
	Route::group(['prefix'=>'sales'], function ()
	{
		Route::get('/',										['as' => 'sales_user_dashboard'             	,'uses' =>'Admin\SalesAccountController@index']);
		Route::get('business_listing',						['as' => 'sales_user_business_list'             ,'uses' =>'Admin\SalesAccountController@business_listing']);
		Route::get('create_business/{enc_id}',				['as' => 'sales_user_create_business'           ,'uses' =>'Admin\SalesAccountController@create_business']);
		Route::post('store_business',						['as' => 'sales_user_store_business'            ,'uses' =>'Admin\SalesAccountController@store_business']);
		Route::get('profile',								['as' => 'sales_user_profile'            	    ,'uses' =>'Admin\SalesAccountController@profile']);
		Route::get('create_user',							['as' => 'sales_user_create_user'          	    ,'uses' =>'Admin\SalesAccountController@create_user']);
		Route::post('store_user',							['as' => 'sales_user_store_user'          	    ,'uses' =>'Admin\SalesAccountController@store_user']);

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



	});


		/* Sales User Module */
	Route::group(['prefix'=>'membership'], function()
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












});


/*--------------Restaurant Admin Routes ---------------------------*/



/*--------------------------WEB SERVICES-------------------------*/

Route::group(['prefix'=>'api','middleware'=>'api'],function()
{
	Route::group(['prefix'=>'user'], function()
	{
		Route::post('login','Api\UserController@login');
		Route::post('register','Api\UserController@register');
		Route::get('edit','Api\UserController@edit');
		Route::post('update','Api\UserController@update');
		Route::get('forget_password','Api\UserController@forget_password');
	});

	Route::group(['prefix'=>'deal'], function()
	{
		Route::post('store','Api\DealController@store');
		Route::get('edit','Api\DealController@edit');
		Route::post('update','Api\DealController@update');
		Route::get('get_menus','Api\DealController@get_menus');
		Route::get('get_sub_menus','Api\DealController@get_sub_menus');
		Route::get('featured_deals','Api\DealController@featured_deals');
	});

	Route::group(['prefix'=>'restaurant_profile'] ,function ()
	{
		Route::get('edit','Api\RestaurantController@edit');
		Route::get('update','Api\RestaurantController@update');
		Route::get('about_us','Api\RestaurantController@about_us');
		Route::get('menu','Api\RestaurantController@menu');
	});


});

/*------------------------END-------------------------------------*/

/*Role Methods*/

Route::get('/create_role',function()
{
	$role = Sentinel::getRoleRepository()->createModel()->create([
    'name' => 'Restaurant Admin',
    'slug' => 'restaurant_admin',
	]);

});

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
