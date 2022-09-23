<?php
use Illuminate\Support\Facades\Route;

Route::group([
		'prefix' => LaravelLocalization::setLocale(),
		'middleware' => ['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
		'namespace' => 'paymentonline\manager\controller'
	], function(){
        Route::get('/callback-payment-online/{id}', 'PaymentOnlineController@callbackPaymentOnline');
        Route::get('/thanh-toan-online', 'PaymentOnlineController@paymentOnline');
        Route::get('/ipn-vnpay', 'PaymentOnlineController@ipnVnpay');
});