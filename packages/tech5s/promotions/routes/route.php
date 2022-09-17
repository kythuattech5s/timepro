<?php
Route::group([
    'prefix' => 'action-promotion',
    'middleware' => 'web',
    'namespace' =>  'Tech5sMarketing\Tech5sPromotion\Controllers'
],function(){
    Route::get('get-vouchers', "ActionPromotionController@getListVoucher");
    Route::post('apply-or-cancel-voucher', "ActionPromotionController@applyAndRemoveVoucher");
});

Route::group(['prefix' => 'sys-promotion', 'middleware' => 'web', 'namespace' => 'Tech5sMarketing\Tech5sPromotion\Controllers'], function () {
    Route::post('load-item-condition', "Controller@loadItemCondition");
    Route::get('load-item-selecter', "Controller@loadItemSelecter");

    // voucher
    Route::prefix('vouchers')->namespace('Marketing')->group(function () {
        Route::get('add', 'VoucherController@showFormAddVoucher');
        Route::post('create', 'VoucherController@create');
        Route::get('edit/{id}', 'VoucherController@editFormVoucher');
        Route::post('update/{id}', 'VoucherController@update');
        Route::get('copy/{id}', 'VoucherController@copyFormVoucher');
        Route::post('remove-product', 'VoucherController@removeProduct');
        Route::get('send-voucher/{id}', 'VoucherController@showFormSendVoucher');
    });

    Route::prefix('flash_sales')->namespace('Marketing')->group(function () {
        //Thêm
        Route::get('add', 'FlashSaleController@showFormAdd');
        Route::post('create', 'FlashSaleController@create');
        Route::post('create-time-slot', 'FlashSaleController@createTimeSlot');
        Route::post('edit-time-slot', 'FlashSaleController@editTimeSlot');
        Route::post('change-act', 'FlashSaleController@changeAct');
        Route::post('change-act-multiple', 'FlashSaleController@changeActMultiple');
        Route::post('change-act-multiple-choose', 'FlashSaleController@changeActMultipleChoose');
        Route::post('delete-item-product', 'FlashSaleController@deleteItemProduct');
        Route::post('delete-item-big', 'FlashSaleController@deleteItemBig');
        Route::post('save-product-no-active', 'FlashSaleController@saveProductNoActive');

        //Sửa
        Route::get('edit/{id}', 'FlashSaleController@showFormEdit');
        Route::post('update/{id}', 'FlashSaleController@update');

        //copy
        Route::get('copy/{id}', 'FlashSaleController@showFormCopy');
        Route::post('create-copy', 'FlashSaleController@createCopy');
    });

    Route::prefix('combos')->namespace('Marketing')->group(function () {
        Route::get('add', 'ComboController@showFormAdd');
        Route::post('change-act', 'ComboController@changeAct');
        Route::post('remove-item', 'ComboController@removeItem');
        Route::post('create', 'ComboController@create');
        Route::get('edit/{id}', 'ComboController@showFormEdit');
        Route::post('update/{id}', 'ComboController@update');
        Route::get('copy/{id}', 'ComboController@showFormCopy');
    });

    Route::prefix('deals')->namespace('Marketing')->group(function () {
        Route::get('add', 'DealController@showFormAdd');
        Route::post('create', 'DealController@create');
        Route::post('save-product-main', 'DealController@saveProductMain');
        Route::post('change-act', 'DealController@changeAct');
        Route::post('change-act-sub', 'DealController@changeActSub');
        Route::post('remove-item', 'DealController@removeItem');
        Route::post('save-edit-deal', 'DealController@saveEditDeal');
        Route::get('edit-deal/{id}', 'DealController@editDeal');
        Route::get('edit/{id}', 'DealController@showFormEdit');
        Route::post('save', 'DealController@save');
        Route::get('copy/{id}', 'DealController@showFormCopy');
        Route::get('edit-product-main', 'DealController@editProductMain');
        Route::post('save-product-sub', 'DealController@saveProductSub');
        Route::get('edit-product-sub', 'DealController@editProductSub');
    });

    Route::prefix('promotion_products')->namespace('Marketing')->group(function () {
        Route::get('/add', 'PromotionProductController@formAdd');
        Route::post('/store', 'PromotionProductController@store');
        Route::get('/edit/{id}', 'PromotionProductController@show');
        Route::post('/update/{id}', 'PromotionProductController@update');
        Route::get('/copy/{id}', 'PromotionProductController@copy');
    });

    Route::prefix('marketing')->namespace('Marketing')->group(function () {
        Route::get('show-product', 'MarketingController@showProduct');
        Route::post('search-product', 'MarketingController@searchProduct');
        Route::post('choose-product-for-promotion', 'MarketingController@chooseProductForPromotion');
    });

});
