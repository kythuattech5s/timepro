<?php
Route::post('create', 'VoucherController@create');
Route::post('update/{id}', 'VoucherController@update');
Route::post('remove-product', 'VoucherController@removeProduct');
Route::post('load-product', 'VoucherController@loadProduct');
Route::post('search-category', 'VoucherController@searchCategory');
Route::get('send-voucher/{id}', 'VoucherController@showFormSendVoucher');
Route::get('show-list-category', 'VoucherController@showListCategory');

Route::get('show-product', 'VoucherController@showProduct');
Route::post('search-product', 'VoucherController@searchProduct');
Route::post('choose-product-for-promotion', 'VoucherController@chooseProduct');


Route::post('ap-dung-ma-giam-gia', 'VoucherController@applyVoucher');
Route::post('huy-ap-dung-ma-giam-gia', 'VoucherController@removeVoucher');
