<?php
    Route::group([
        'prefix' => 'sys-check-table',
        'middleware' => 'web',
        'namespace' =>  'CustomTable\Controllers'
    ],function(){
        Route::post('check-editing', "CheckController@checkEditing");
        Route::get('remove-editing', "CheckController@removeEditing");
    });
?>