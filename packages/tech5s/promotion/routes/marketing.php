<?php
use Illuminate\Support\Facades\Route;

Route::get('show-product', 'MarketingController@showProduct');
Route::post('search-product', 'MarketingController@searchProduct');
Route::post('choose-product-for-promotion', 'MarketingController@chooseProductForPromotion');
Route::post("search-shop",'MarketingController@searchShop');
Route::get('expired-promotion','ExpiredController@expiredPromotion');