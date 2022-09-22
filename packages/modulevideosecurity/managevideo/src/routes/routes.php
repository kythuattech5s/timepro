<?php

Route::group(['prefix' => 'tvs-video', 'middleware' => 'web', 'namespace' => 'modulevideosecurity\managevideo\Controllers'], function () {

	Route::get('/playlist/{tvsMapItemId}', 'VideoSecurityController@getPlaylist')->name('tvs-video.playlist');

	Route::get('/file/{fileName}', 'VideoSecurityController@getFileTs')->name('tvs-video.file');

	Route::get('/key/{key}', 'VideoSecurityController@key')->name('tvs-video.key');

	Route::get('/auto-convert-tvs', 'VideoSecurityController@autoConvertTvs');

	Route::get('/fetch', 'VideoSecurityController@fetch');

	Route::post('/point', 'VideoSecurityController@point');

	Route::post('/press', 'VideoSecurityController@press');

	Route::get('/test', 'VideoSecurityController@test');

});

