<?php
Route::prefix('binh-luan')->namespace('Roniejisa\Comment\Controllers')->middleware('web')->group(function () {
    Route::get('/', 'CommentController@show');
});
