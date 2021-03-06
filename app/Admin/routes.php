<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

//    $router->get('/', 'HomeController@index');
    $router->redirect('/', 'admin/merchants');

    $router->get('orders', 'O2oOrderController@index');
    $router->get('b2c_orders', 'SdbB2cOrdersController@index');
    $router->get('b2c_orders/{order_id}', 'SdbB2cOrdersController@show');

    $router->get('merchant_types', 'O2oMerchantTypeController@index');
    $router->get('merchant_types/create', 'O2oMerchantTypeController@create');
    $router->post('merchant_types', 'O2oMerchantTypeController@store');
    $router->get('merchant_types/{id}/edit', 'O2oMerchantTypeController@edit');
    $router->get('api/merchant_types', 'O2oMerchantTypeController@apiTypes');
    $router->put('merchant_types/{id}', 'O2oMerchantTypeController@update');
    $router->delete('merchant_types/{id}', 'O2oMerchantTypeController@destroy');

    $router->get('pic_types', 'O2oPicTypeController@index');
    $router->get('pic_types/create', 'O2oPicTypeController@create');
    $router->post('pic_types', 'O2oPicTypeController@store');
    $router->get('pic_types/{id}/edit', 'O2oPicTypeController@edit');
    $router->put('pic_types/{id}', 'O2oPicTypeController@update');
    $router->delete('pic_types/{id}', 'O2oPicTypeController@destroy');
    $router->get('pic_types/{id}', 'O2oPicTypeController@show');

    $router->get('title_types', 'O2oTitleTypeController@index');
    $router->get('title_types/create', 'O2oTitleTypeController@create');
    $router->post('title_types', 'O2oTitleTypeController@store');
    $router->get('title_types/{id}/edit', 'O2oTitleTypeController@edit');
    $router->put('title_types/{id}', 'O2oTitleTypeController@update');
    $router->delete('title_types/{id}', 'O2oTitleTypeController@destroy');
    $router->get('title_types/{id}', 'O2oTitleTypeController@show');

    $router->get('banner', 'O2oBannerController@index');
    $router->get('banner/create', 'O2oBannerController@create');
    $router->post('banner', 'O2oBannerController@store');
    $router->get('banner/{id}/edit', 'O2oBannerController@edit');
    $router->put('banner/{id}', 'O2oBannerController@update');
    $router->delete('banner/{id}', 'O2oBannerController@destroy');
    $router->get('banner/{id}', 'O2oBannerController@show');

    $router->get('activity', 'O2oActivityController@index');
    $router->get('activity/create', 'O2oActivityController@create');
    $router->post('activity', 'O2oActivityController@store');
    $router->get('activity/{id}/edit', 'O2oActivityController@edit');
    $router->put('activity/{id}', 'O2oActivityController@update');
    $router->delete('activity/{id}', 'O2oActivityController@destroy');
    $router->get('activity/{id}', 'O2oActivityController@show');

    $router->get('search_keywords', 'O2oSearchKeywordController@index');
    $router->get('search_keywords/create', 'O2oSearchKeywordController@create');
    $router->post('search_keywords', 'O2oSearchKeywordController@store');
    $router->get('search_keywords/{id}/edit', 'O2oSearchKeywordController@edit');
    $router->put('search_keywords/{id}', 'O2oSearchKeywordController@update');
    $router->delete('search_keywords/{id}', 'O2oSearchKeywordController@destroy');
    $router->get('search_keywords/{id}', 'O2oSearchKeywordController@show');

    $router->get('merchant_hots', 'O2oMerchantHotController@index');
    $router->get('merchant_hots/create', 'O2oMerchantHotController@create');
    $router->post('merchant_hots', 'O2oMerchantHotController@store');
    $router->get('merchant_hots/{id}/edit', 'O2oMerchantHotController@edit');
    $router->put('merchant_hots/{id}', 'O2oMerchantHotController@update');
    $router->delete('merchant_hots/{id}', 'O2oMerchantHotController@destroy');
    $router->get('merchant_hots/{id}', 'O2oMerchantHotController@show');

    $router->get('merchants', 'O2oMerchantController@index');
    $router->get('merchants/{id}', 'O2oMerchantController@show');
    $router->get('merchants/{id}/edit', 'O2oMerchantController@edit');
    $router->put('merchants/{id}', 'O2oMerchantController@update');
    $router->post('merchants/hot', 'O2oMerchantController@hot');

    $router->get('members', 'O2oMemberController@index');
    $router->post('members/lock', 'O2oMemberController@lock');
    $router->post('members/score', 'O2oMemberController@score');
    $router->post('members/score_edit', 'O2oMemberController@score_edit');

    $router->get('member_points', 'O2oMemberPointController@index');

    $router->get('coupons', 'O2oCouponController@index');
    $router->get('coupons/create', 'O2oCouponController@create');
    $router->post('coupons', 'O2oCouponController@store');
    $router->get('coupons/{id}/edit', 'O2oCouponController@edit');
    $router->put('coupons/{id}', 'O2oCouponController@update');
    $router->delete('coupons/{id}', 'O2oCouponController@destroy');
    $router->get('coupons/{id}', 'O2oCouponController@show');

    $router->get('coupon_buy', 'O2oCouponBuyController@index');

    $router->get('charts/{action}', 'ChartsController@index');

});
