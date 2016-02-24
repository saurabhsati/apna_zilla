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
		Route::post('update',['as' => 'admin_categories_update' ,'uses' => 'Admin\CategoryController@update']);
		Route::get('create/{cat_id?}',['as' => 'admin_categories_create' ,'uses' => 'Admin\CategoryController@create']);
		Route::get('toggle_status/{enc_id}/{action}',['as' => 'admin_categories_toggle_status' ,'uses' => 'Admin\CategoryController@toggle_status']);
		Route::post('multi_action',['as' => 'admin_categories_block' ,'uses' => 'Admin\CategoryController@multi_action']);
		Route::post('store',['as' => 'admin_categories_store' ,'uses' => 'Admin\CategoryController@store']);

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

	/*------------------------- web_admin Contact Enquiry Related ------------------------------*/



/*************************News Letter Module***********************************/


	Route::group(array('prefix' => 'newsletter'), function()
	{

		Route::get('/',['as' => 'newsletter_manage' ,'uses' => 'Admin\NewsLetterController@index']);
		

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
