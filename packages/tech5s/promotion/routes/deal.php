<?php

Route::post('create', 'DealController@create');
Route::post('save-product-main', 'DealController@saveProductMain');
Route::post('change-act', 'DealController@changeAct');
Route::post('change-act-sub', 'DealController@changeActSub');
Route::post('remove-item', 'DealController@removeItem');
Route::post('save-edit-deal', 'DealController@saveEditDeal');
Route::get('edit-deal/{id}', 'DealController@editDeal');
Route::post('save', 'DealController@save');
Route::get('edit-product-main', 'DealController@editProductMain');
Route::post('save-product-sub', 'DealController@saveProductSub');
Route::get('edit-product-sub', 'DealController@editProductSub');
