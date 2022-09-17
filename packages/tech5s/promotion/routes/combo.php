<?php
use Illuminate\Support\Facades\Route;

Route::post('change-act', 'ComboController@changeAct');
Route::post('remove-item', 'ComboController@removeItem');
Route::post('create', 'ComboController@create');
Route::post('update/{id}', 'ComboController@update');