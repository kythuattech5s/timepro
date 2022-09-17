<?php
Route::namespace('Tech5s\VideoChapter\Controllers')->middleware(['web', 'auth'])->group(function () {
    Route::post('them-ghi-chu', 'VideoController@note');
    Route::post('lay-danh-sach-ghi-chu', 'VideoController@getListNote');
    Route::post('danh-dau-da-hoc-xong', 'VideoController@markVideoDone');
});
