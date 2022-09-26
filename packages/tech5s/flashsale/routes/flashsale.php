<?php

Route::post('store', 'FlashSaleController@store');
Route::post('create-time-slot', 'FlashSaleController@createTimeSlot');
Route::post('edit-time-slot', 'FlashSaleController@editTimeSlot');
Route::post('change-act', 'FlashSaleController@changeAct');
Route::post('change-act-multiple', 'FlashSaleController@changeActMultiple');
Route::post('change-act-multiple-choose', 'FlashSaleController@changeActMultipleChoose');
Route::post('delete-item-product', 'FlashSaleController@deleteItemProduct');
Route::post('delete-item-big', 'FlashSaleController@deleteItemBig');
Route::post('save-product-no-active', 'FlashSaleController@saveProductNoActive');
Route::post('find-slot-time', 'FlashSaleController@findSlotTime');
Route::post('choose-slot-time', 'FlashSaleController@chooseSlotTime');
Route::post('choose-promotion-type', 'FlashSaleController@choosePromotionTypeApply');
Route::post('show-category-child', 'FlashSaleController@showChildCategory');
Route::post('search', 'FlashSaleController@search');
Route::get('chinh-sua-chi-tiet-flash-sale', 'FlashSaleController@show');
//Sửa
Route::post('update/{id}', 'FlashSaleController@update');



//

Route::post('load-product', 'FlashSaleController@loadProduct');
Route::get('show-product', 'FlashSaleController@showProduct');
Route::post('search-product', 'FlashSaleController@searchProduct');
Route::post('choose-product-for-promotion', 'FlashSaleController@chooseProduct');
Route::post('update-for-all', 'FlashSaleController@updateForAll');
Route::post('save-product-current', 'FlashSaleController@saveProductCurrent');
Route::post('save-product', 'FlashSaleController@saveProduct');
Route::post('remove-product', 'FlashSaleController@removeProduct');
