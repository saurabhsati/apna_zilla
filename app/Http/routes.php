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
	Route::any('register_admin','Admin\AuthController@register_admin');
	Route::any('register','Admin\AuthController@register');
	Route::any('assign_role','Admin\AuthController@assignRole');
	Route::any('activation','Admin\AuthController@activation');
	Route::any('registerandactivate','Admin\AuthController@registerAndActivate');


	Route::get('/','Admin\AuthController@show_login');
	Route::get('login','Admin\AuthController@show_login');
	Route::post('process_login','Admin\AuthController@process_login');
	Route::get('dashboard','Admin\DashboardController@index');
	Route::get('logout','Admin\AuthController@logout');
	Route::get('change_password','Admin\AuthController@change_password');
	Route::post('update_password','Admin\AuthController@update_password');
	Route::get('edit_profile','Admin\AuthController@profile');
	Route::post('updateprofile','Admin\AuthController@updateprofile');
	/* Front Pages */
	Route::get('static_pages',['as'=>'static_pages', 'uses'=>'Admin\StaticPageController@index']);

	  /*---------------------CMS Module-------------------------*/
	   Route::group(array('prefix' => '/static_pages'), function()
		{
		Route::get('/',['as' => 'static_pages_manage' ,'uses' => 'Admin\StaticPageController@index']);
		Route::get('create',['as' => 'static_pages_create' ,'uses' => 'Admin\StaticPageController@create']);
		Route::get('edit/{enc_id}',['as' => 'static_pages_edit' ,'uses' => 'Admin\StaticPageController@edit']);
		Route::any('store',['as' => 'static_pages_store' ,'uses' => 'Admin\StaticPageController@store']);
		Route::get('delete/{enc_id}',['as' => 'static_pages_delete' ,'uses' => 'Admin\StaticPageController@delete']);
		Route::post('update/{enc_id}',['as' => 'static_pages_update' ,'uses' => 'Admin\StaticPageController@update']);
		Route::get('toggle_status/{enc_id}/{action}',['as' => 'static_pages_toggle_status' ,'uses' => 'Admin\StaticPageController@toggle_status']);
		Route::post('multi_action',['as' => 'static_pages_multi_action' ,'uses' => 'Admin\StaticPageController@multi_action']);

		});
	   /* Location module */
	   Route::group(array('prefix' => '/countries'), function()
		{
		Route::get('/',['as' => 'admin_countries_manage' ,'uses' => 'Admin\CountryController@index']);
		Route::get('show/{enc_id}',['as' => 'admin_countries_show' ,'uses' => 'Admin\CountryController@show']);
		Route::get('edit/{enc_id}',['as' => 'admin_countries_edit' ,'uses' => 'Admin\CountryController@edit']);
		Route::post('update/{enc_id}',['as' => 'admin_countries_update' ,'uses' => 'Admin\CountryController@update']);
		Route::get('create',['as' => 'admin_countries_create' ,'uses' => 'Admin\CountryController@create']);
		Route::get('toggle_status/{enc_id}/{action}',['as' => 'admin_countries_toggle_status' ,'uses' => 'Admin\CountryController@toggle_status']);
		Route::get('delete/{enc_id}',['as' => 'admin_countries_delete' ,'uses' => 'Admin\CountryController@delete']);
		Route::post('multi_action',['as' => 'admin_countries_block' ,'uses' => 'Admin\CountryController@multi_action']);
		Route::any('store',['as' => 'admin_countries_store' ,'uses' => 'Admin\CountryController@store']);

		});

		Route::group(array('prefix' => '/states'), function()
		{

			Route::get('/',['as' => 'admin_states_manage' ,'uses' => 'Admin\StateController@index']);
			Route::get('show/{enc_id}',['as' => 'admin_states_show' ,'uses' => 'Admin\StateController@show']);
			Route::get('edit/{enc_id}',['as' => 'admin_states_edit' ,'uses' => 'Admin\StateController@edit']);
			Route::post('update/{enc_id}',['as' => 'admin_states_update' ,'uses' => 'Admin\StateController@update']);
			Route::get('create',['as' => 'admin_states_create' ,'uses' => 'Admin\StateController@create']);
			Route::get('toggle_status/{enc_id}/{action}',['as' => 'admin_states_toggle_status' ,'uses' => 'Admin\StateController@toggle_status']);
			Route::post('multi_action',['as' => 'admin_states_block' ,'uses' => 'Admin\StateController@multi_action']);
			Route::any('store',['as' => 'admin_states_store' ,'uses' => 'Admin\StateController@store']);
			Route::get('delete/{enc_id}',['as' => 'admin_states_delete' ,'uses' => 'Admin\StateController@delete']);

		});

		Route::group(array('prefix' => '/cities'), function()
		{

			Route::get('/',['as' => 'admin_cities_manage' ,'uses' => 'Admin\CityController@index']);
			Route::get('show/{enc_id}',['as' => 'admin_cities_show' ,'uses' => 'Admin\CityController@show']);
			Route::get('edit/{enc_id}',['as' => 'admin_cities_edit' ,'uses' => 'Admin\CityController@edit']);
			Route::post('update/{enc_id}',['as' => 'admin_cities_update' ,'uses' => 'Admin\CityController@update']);
			Route::get('create',['as' => 'admin_cities_create' ,'uses' => 'Admin\CityController@create']);
			Route::get('toggle_status/{enc_id}/{action}',['as' => 'admin_cities_toggle_status' ,'uses' => 'Admin\CityController@toggle_status']);
			Route::post('multi_action',['as' => 'admin_cities_block' ,'uses' => 'Admin\CityController@multi_action']);
			Route::any('store',['as' => 'admin_cities_store' ,'uses' => 'Admin\CityController@store']);
			Route::any('nearby_destinations/{enc_id}',['as' => 'admin_nearby_destinations' ,'uses' => 'Admin\CityController@nearby_destinations']);
			Route::any('add_destinations',['as' => 'admin_add_destinations' ,'uses' => 'Admin\CityController@add_destinations']);
			Route::get('delete/{enc_id}',['as' => 'admin_cities_delete' ,'uses' => 'Admin\CityController@delete']);

		});

		Route::group(array('prefix' => '/zipcode'), function()
		{

			Route::get('/',['as' => 'admin_cities_manage' ,'uses' => 'Admin\ZipController@index']);
			Route::get('create',['as' => 'admin_cities_create' ,'uses' => 'Admin\ZipController@create']);
			Route::any('store',['as' => 'admin_cities_store' ,'uses' => 'Admin\ZipController@store']);
			Route::get('show/{enc_id}',['as' => 'admin_cities_show' ,'uses' => 'Admin\ZipController@show']);
			Route::get('edit/{enc_id}',['as' => 'admin_cities_edit' ,'uses' => 'Admin\ZipController@edit']);
			Route::post('update/{enc_id}',['as' => 'admin_cities_update' ,'uses' => 'Admin\ZipController@update']);
			Route::get('toggle_status/{enc_id}/{action}',['as' => 'admin_cities_toggle_status' ,'uses' => 'Admin\ZipController@toggle_status']);
			Route::post('multi_action',['as' => 'admin_cities_block' ,'uses' => 'Admin\ZipController@multi_action']);
			Route::get('delete/{enc_id}',['as' => 'admin_cities_delete' ,'uses' => 'Admin\ZipController@delete']);

		});
		/* Email Template Module */
		Route::group(array('prefix' => '/email_template'), function()
		{
			Route::get('/',						['as' => 'admin_email_template_index'		,'uses' => 'Admin\EmailTemplateController@index']);
			Route::get('create/',				['as' => 'admin_email_template_create' 		,'uses' => 'Admin\EmailTemplateController@create']);
			Route::post('store/',				['as' => 'admin_email_template_store' 		,'uses' => 'Admin\EmailTemplateController@store']);
			Route::get('edit/{coupon_id}',		['as' => 'admin_email_template_edit'		,'uses' => 'Admin\EmailTemplateController@edit']);
			Route::post('update/{coupon_id}',	['as' => 'admin_email_template_update' 		,'uses' => 'Admin\EmailTemplateController@update']);
		});

		Route::group(array('prefix' => '/email_template'), function()
		{
			Route::get('/',						['as' => 'admin_email_template_index'		,'uses' => 'Admin\EmailTemplateController@index']);
			Route::get('create/',				['as' => 'admin_email_template_create' 		,'uses' => 'Admin\EmailTemplateController@create']);
			Route::post('store/',				['as' => 'admin_email_template_store' 		,'uses' => 'Admin\EmailTemplateController@store']);
			Route::get('edit/{coupon_id}',		['as' => 'admin_email_template_edit'		,'uses' => 'Admin\EmailTemplateController@edit']);
			Route::post('update/{coupon_id}',	['as' => 'admin_email_template_update' 		,'uses' => 'Admin\EmailTemplateController@update']);
		});

		/* Comman function */
		Route::group(array('prefix' => '/common'), function()
		{
			Route::get('get_states/{country_id}',['as' => 'get_states' ,'uses' => 'Common\CountryController@get_states']);
			/*Route::get('get_cities/{state_id}',['as' => 'get_cities' ,'uses' => 'Common\CountryController@get_cities']);
			Route::get('get_nearby_state/{state_id}/{country_id}',['as' => 'get_nearby_states' ,'uses' => 'Common\CountryController@get_nearby_state']);
			Route::get('get_nearby_city/{city_id}/{state_id}',['as' => 'get_nearby_city' ,'uses' => 'Common\CountryController@get_nearby_city']);

			Route::get('get_sub_category/{id}',['as' => 'get_sub_category' ,'uses' => 'Common\CategoryController@get_sub_category']);*/

		});
	/* Users Module */
	Route::group(['prefix'=>'users'], function ()
	{
		Route::get('/','Admin\UserController@index');
		Route::get('manage','Admin\UserController@index');
		Route::get('show/{enc_id}','Admin\UserController@show');
		Route::get('edit/{enc_id}','Admin\UserController@edit');
		Route::post('update/{enc_id}','Admin\UserController@update');
		Route::get('create','Admin\UserController@create');
		Route::get('toggle_status/{enc_id}/{action}','Admin\UserController@toggle_status');
		Route::post('multi_action','Admin\UserController@multi_action');
		Route::any('store','Admin\UserController@store');
	});


	/* Categories Module */
	Route::group(array('prefix' => 'categories'), function()
	{
		Route::get('/',['as' => 'admin_categories_manage' ,'uses' => 'Admin\CategoryController@index']);
		Route::get('show/{enc_id}',['as' => 'admin_categories_show' ,'uses' => 'Admin\CategoryController@show']);
		Route::get('edit/{enc_id}',['as' => 'admin_categories_edit' ,'uses' => 'Admin\CategoryController@edit']);
		Route::post('update/{enc_id}',['as' => 'admin_categories_update' ,'uses' => 'Admin\CategoryController@update']);
		Route::get('create/{cat_id?}',['as' => 'admin_categories_create' ,'uses' => 'Admin\CategoryController@create']);
		Route::get('toggle_status/{enc_id}/{action}',['as' => 'admin_categories_toggle_status' ,'uses' => 'Admin\CategoryController@toggle_status']);
		Route::post('multi_action',['as' => 'admin_categories_block' ,'uses' => 'Admin\CategoryController@multi_action']);
		Route::post('store',['as' => 'admin_categories_store' ,'uses' => 'Admin\CategoryController@store']);
		Route::get('delete/{enc_id}',['as' => 'admin_categories_delete' ,'uses' => 'Admin\CategoryController@delete']);
		Route::get('sub_categories/{enc_id}',['as' => 'admin_sub_categories_store' ,'uses' => 'Admin\CategoryController@show_sub_categories']);
		Route::post('sub_categories/update',['as' => 'admin_sub_categories_update' ,'uses' => 'Admin\CategoryController@update']);
		Route::get('sub_categories/toggle_status/{enc_id}/{action}',['as' => 'admin_sub_categories_toggle_status' ,'uses' => 'Admin\CategoryController@toggle_status']);
		Route::post('sub_categories/multi_action',['as' => 'admin_sub_categories_block' ,'uses' => 'Admin\CategoryController@multi_action']);

		/*Route::get('sub_categories/brands/{enc_id}',['as' => 'admin_sub_categories_brands' ,'uses' => 'Web_admin\CategoryController@show_brands']);
		Route::get('sub_categories/brands/toggle_status/{enc_id}/{action}',['as' => 'admin_sub_categories_brands_toggle_status' ,'uses' => 'Web_admin\CategoryController@toggle_brand_status']);
		Route::post('sub_categories/brands/multi_action',['as' => 'admin_sub_categories_brands_multi_action' ,'uses' => 'Web_admin\CategoryController@brand_multi_action']);
		Route::post('sub_categories/brands/attach',['as' => 'admin_sub_categories_brands_attach' ,'uses' => 'Web_admin\CategoryController@attach_brand']);*/

	});

	/*------------------------- web_admin Attribute Related ------------------------------*/

	Route::group(array('prefix' => 'attribute'), function()
	{
		Route::get('show/{enc_id}',['as' => 'admin_email_attribute_create' ,'uses' => 'Admin\AttributeController@show']);
		Route::get('create/{enc_id}',['as' => 'admin_email_attribute_create' ,'uses' => 'Admin\AttributeController@create']);
		Route::any('store',['as' => 'admin_email_attribute_store' ,'uses' => 'Admin\AttributeController@store']);

		Route::get('edit/{enc_id}',['as' => 'admin_attribute_edit' ,'uses' => 'Admin\AttributeController@edit']);
		Route::post('update/{enc_id}',['as' => 'admin_attribute_update' ,'uses' => 'Admin\AttributeController@update']);

		Route::get('toggle_status/{enc_id}/{action}',['as' => 'admin_attribute_toggle_status' ,'uses' => 'Admin\AttributeController@toggle_status']);
		Route::post('multi_action',['as' => 'admin_attribute_block' ,'uses' => 'Admin\AttributeController@multi_action']);

		Route::get('delete_option_values/{enc_id}',['as' => 'admin_attribute_delete_option_values' ,'uses' => 'Admin\AttributeController@delete_option_values']);

	});


	/*------------------------- web_admin Contact Enquiry Related ----------*--------------------*/

	Route::group(array('prefix' => 'contact_enquiry'), function()
	{
		Route::get('/',['as' => 'list_contact_enquiry' ,'uses' => 'Admin\ContactEnquiryController@index']);
		Route::get('show/{enc_id}',['as' => 'show_contact_enquiry' ,'uses' => 'Admin\ContactEnquiryController@show']); 

	}); 

    /*************************************End*****************************************************/


/*************************News Letter Module***********************************/

	Route::group(array('prefix' => 'newsletter'), function()
	{

		Route::get('/',['as' => 'newsletter_manage' ,'uses' => 'Admin\NewsLetterController@index']);

		Route::get('show/{enc_id}',['as' => 'newsletter_show' ,'uses' => 'Admin\NewsLetterController@show']);
		Route::get('edit/{enc_id}',['as' => 'newsletter_edit' ,'uses' => 'Admin\NewsLetterController@edit']);
		Route::post('update/{enc_id}',['as' => 'admin_newsletter_update' ,'uses' => 'Admin\NewsLetterController@update']);
		Route::get('toggle_status/{enc_id}/{action}',['as' => 'admin_newsletter_toggle_status' ,'uses' => 'Admin\NewsLetterController@toggle_status']);
		Route::post('multi_action',['as' => 'admin_newsletter_block' ,'uses' => 'Admin\NewsLetterController@multi_action']);
		Route::get('create',['as' => 'admin_newsletter_create' ,'uses' => 'Admin\NewsLetterController@create']);
		Route::any('store',['as' => 'admin_newsletter_store' ,'uses' => 'Admin\NewsLetterController@store']);
		Route::get('compose',['as' => 'admin_newsletter_compose' ,'uses' => 'Admin\NewsLetterController@compose']);
		Route::post('send_email',['as' => 'admin_newsletter_send_email' ,'uses' => 'Admin\NewsLetterController@send_email']);

	});

/*****************************End************************************************/

	/*-------------Deals Module------------*/
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

	/*-------------Deals Reviews Module------------*/
	Route::group(['prefix'=>'dealsReviews'], function (){
		Route::get('/{enc_id}','Admin\DealReviewController@index');
		Route::get('view/{enc_id}','Admin\DealReviewController@view');
		Route::get('delete/{enc_id}','Admin\DealReviewController@delete');
		Route::get('toggle_status/{enc_id}/{action}','Admin\DealReviewController@toggle_status');
		Route::post('multi_action','Admin\DealReviewController@multi_action');
	});
	/*-------------End--------------------------*/

	/*-------------Restaurant Reviews Module------------*/
	Route::group(['prefix'=>'restaurantReviews'], function (){
		Route::get('/{enc_id}','Admin\RestaurantReviewController@index');
		Route::get('view/{enc_id}','Admin\RestaurantReviewController@view');
		Route::get('delete/{enc_id}','Admin\RestaurantReviewController@delete');
		Route::get('toggle_status/{enc_id}/{action}','Admin\RestaurantReviewController@toggle_status');
		Route::post('multi_action','Admin\RestaurantReviewController@multi_action');
	});
	/*-------------End--------------------------*/

	/*-------------Memberships Module------------*/
	Route::group(['prefix'=>'memberships'], function (){
		Route::get('/','Admin\MembershipController@index');
		Route::get('edit/{enc_id}','Admin\MembershipController@edit');
		Route::post('update/{enc_id}','Admin\MembershipController@update');
	});
	/*-------------End--------------------------*/

	/*-------------Website Setting Module------------*/
	Route::group(['prefix'=>'site_settings'], function (){
		Route::get('/','Admin\SiteSettingController@index');
		Route::post('update/{enc_id}','Admin\SiteSettingController@update');
	});
	/*-------------End--------------------------*/

	/*-------------Payment Records Module------------*/
	Route::group(['prefix'=>'transactions'], function (){
		Route::get('/','Admin\TransactionController@index');
		Route::get('view/{enc_id}','Admin\TransactionController@view');
	});
	/*-------------End--------------------------*/
});


/*--------------Restaurant Admin Routes ---------------------------*/

Route::group(['prefix'=>'/restaurant_admin','middleware'=>['web']], function ()
{
	Route::get('/','Restaurant_Admin\AuthController@show_login');
	Route::get('login','Restaurant_Admin\AuthController@show_login');
	Route::post('login','Restaurant_Admin\AuthController@process_login');
	Route::get('dashboard','Restaurant_Admin\DashboardController@index');
	Route::get('logout','Restaurant_Admin\AuthController@logout');


	/*------------Edit profile Restaurant user-----------------------------------*/

	Route::group(['prefix'=>'users'], function()
	{
		//Route::get('edit/{enc_id}','Admin\UserController@edit');
		//Route::post('update/{enc_id}','Admin\UserController@update');
		Route::get('change_password','Restaurant_Admin\AuthController@change_password');
		Route::post('change_password','Restaurant_Admin\AuthController@update_password');
	});
	/*----------------------End-------------------------------------*/


		/*-------------Deals Reviews Module------------*/
		Route::group(['prefix'=>'deal_reviews'], function ()
		{
			Route::get('/{enc_id}','Restaurant_Admin\DealReviewController@index');
			Route::get('view/{enc_id}','Restaurant_Admin\DealReviewController@view');
			Route::get('delete/{enc_id}','Restaurant_Admin\DealReviewController@delete');
			Route::get('toggle_status/{enc_id}/{action}','Restaurant_Admin\DealReviewController@toggle_status');
			Route::post('multi_action','Restaurant_Admin\DealReviewController@multi_action');
		});
		/*-------------End--------------------------*/

		/*-------------Restaurant Reviews Module------------*/
		Route::group(['prefix'=>'restaurant_reviews'], function ()
		{
			Route::get('/','Restaurant_Admin\RestaurantReviewController@index');
			Route::get('view/{enc_id}','Restaurant_Admin\RestaurantReviewController@view');
			Route::get('delete/{enc_id}','Restaurant_Admin\RestaurantReviewController@delete');
			Route::get('toggle_status/{enc_id}/{action}','Restaurant_Admin\RestaurantReviewController@toggle_status');
			Route::post('multi_action','Restaurant_Admin\RestaurantReviewController@multi_action');
		});
		/*-------------End--------------------------*/


		/*-------------Deals Reviews Module------------*/
		Route::group(['prefix'=>'dish_reviews'], function ()
		{
			Route::get('/{enc_id}','Restaurant_Admin\DishReviewController@index');
			Route::get('view/{enc_id}','Restaurant_Admin\DishReviewController@view');
			Route::get('delete/{enc_id}','Restaurant_Admin\DishReviewController@delete');
			Route::get('toggle_status/{enc_id}/{action}','Restaurant_Admin\DishReviewController@toggle_status');
			Route::post('multi_action','Restaurant_Admin\DishReviewController@multi_action');
		});
		/*-------------End--------------------------*/

			/*-------------Payment Records Module------------*/
			Route::group(['prefix'=>'transactions'], function ()
			{
				Route::get('/','Restaurant_Admin\TransactionController@index');
				/*Route::get('view/{enc_id}','Restaurant_Admin\TransactionController@view');*/
			});
			/*-------------End--------------------------*/

		/*-------------Paypal Payment intigration--------*/

		Route::group(['prefix'=>'membership_buy'], function ()
		{
			Route::get('/{enc_id}/{enc_user_id}','Restaurant_Admin\PaypalController@membership_buy');
			Route::get('/normal_pay/{enc_id}/{enc_user_id}','Restaurant_Admin\PaypalController@postPayment');
			Route::get('/getPaymentStatus/','Restaurant_Admin\PaypalController@getPaymentStatus');
			Route::get('/recurring_form/{enc_id}/{enc_user_id}','Restaurant_Admin\PaypalController@recurringForm');

			Route::get('/recurring_payment','Restaurant_Admin\PaypalController@billing_with_payplay');
			Route::get('/billing_with_payplay','Restaurant_Admin\PaypalController@billing_with_payplay');
			Route::get('/billing_update','Restaurant_Admin\PaypalController@billing_update');

			Route::get('/execute_agreement','Restaurant_Admin\PaypalController@execute_agreement');

		});

		/*-----------------------------------------------*/

});

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
