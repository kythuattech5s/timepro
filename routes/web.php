
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

    Route::post('cart/{action}', 'CartController@action');
    Route::get('thong-tin-giang-vien/{uslug}', 'UserController@view');

    Route::post('hoi-dap', 'AskAndAnswerController@ask');
    Route::post('thich-cau-hoi', 'AskAndAnswerController@like');
    Route::post("reply-cau-hoi", 'AskAndAnswerController@replyAsk');
    Route::match(['get', 'post'], '/{link}', array('uses' => 'RouteController@direction'))->where('link', '^((?!esystem)[0-9a-zA-Z\?\.\-/])*$');
});
