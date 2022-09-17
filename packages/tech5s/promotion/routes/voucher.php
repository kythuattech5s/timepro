<?php

use Illuminate\Support\Facades\Route;
Route::get('/',function(){
    dd('co');
});
Route::post('create', 'VoucherController@create');
Route::post('update/{id}', 'VoucherController@update');
Route::post('remove-product', 'VoucherController@removeProduct');
Route::post('load-product', 'VoucherController@loadProduct');
Route::post('search-category', 'VoucherController@searchCategory');
Route::get('send-voucher/{id}', 'VoucherController@showFormSendVoucher');
Route::get('show-list-category', 'VoucherController@showListCategory');
