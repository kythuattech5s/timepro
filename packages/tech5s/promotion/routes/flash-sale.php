<?php

use Illuminate\Support\Facades\Route;
//Thêm
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

//copy
Route::post('create-copy', 'FlashSaleController@createCopy');

// Cập nhật danh sách sản phẩm