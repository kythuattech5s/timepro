<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/clear', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    echo '<pre>';
    var_dump(__LINE__);
    die();
});

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    'namespace' => 'App\Http\Controllers',
], function () {
    Route::match(['GET', 'POST'], '/', 'HomeController@index')->name('home');
    Route::get('cronimg', array('uses' => 'CronImgController@convertImg'));
    Route::get('cronmail', 'CronMailController@cronmail');
    Route::get('reset-email', 'CronMailController@reset');
    Route::get('tai-danh-muc-khoa-hoc','HomeController@getCategoryCourse');
    Route::post('cart/{action}', 'CartController@action');
    Route::get('thong-tin-giang-vien/{uslug}', 'UserController@view');
    Route::get('test', function(){
        $results = App\Helpers\SmsHelper::send('0336307382','Cam on quy khach da su dung dich vu cua chung toi. Chuc quy khach mot ngay tot lanh!');
        var_dump($results);die();
    });
    
    
    Route::post('get-last-dat-of-month', 'StaticController@getLastDateOfMonth');
    Route::get('get-district-by-province', 'StaticController@getDistrictByProvince');
    Route::get('get-ward-by-district', 'StaticController@getWardByDistrict');

    Route::post('hoi-dap', 'AskAndAnswerController@ask');
    Route::post('thich-cau-hoi', 'AskAndAnswerController@like');
    Route::post("reply-cau-hoi", 'AskAndAnswerController@replyAsk');
    Route::post("tai-cau-thoi", 'AskAndAnswerController@filter');
    Route::post('tai-them-thong-bao', 'Auth\NotificationController@loadMore');
    Route::post('danh-dau-da-doc-thong-bao', 'Auth\NotificationController@readNotification');
    Route::match(['get', 'post'], '/{link}', array('uses' => 'RouteController@direction'))->where('link', '^((?!esystem)[0-9a-zA-Z\?\.\-/])*$');
});
