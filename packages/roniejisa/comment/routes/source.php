<?php
Route::post('danh-gia', 'CommentController@onlyRating');
Route::post('danh-gia-khoa-hoc', 'CommentController@commentCourse');
Route::get('detail-comment', 'CommentAdminController@detailComment');
Route::post('tra-loi-binh-luan', 'CommentAdminController@repComment');
Route::get('fetch-comment/{id}', 'CommentAdminController@fetchComment');
Route::get('change-act/{id}', 'CommentAdminController@changeAct');
Route::post('binh-luan', 'CommentController@commentNow');
Route::match(['GET', 'POST'], 'danh-gia-san-pham', 'CommentController@ratingOrder');
Route::post('shop-tra-loi-binh-luan', 'CommentController@shopReplyComment');

Route::get('show-comment/{id}', 'CommentController@showComment');
Route::post('tra-loi-binh-luan', 'CommentController@repCommentNow');
Route::post('binh-luan-be-khac', 'CommentController@fetchCommentChild');
Route::post('binh-luan-khac', 'CommentController@fetchCommentMore');
Route::post('loc-danh-gia', 'CommentController@filterRating');
Route::post('thich-binh-luan', 'CommentController@likeAndUnlike');
Route::get('{source}/{file}', 'CommentController@file');
