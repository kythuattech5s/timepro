<?php
Route::group([
    'prefix' => 'esystem/view-order',
    'middleware' => ['web','h_users'],
    'namespace' =>  'CourseManage\Controllers'
],function(){
    Route::get('orders', "OrderCourseManageController@viewOrder");
});
Route::group([
    'prefix' => 'esystem/course-manage',
    'middleware' => ['web','h_users'],
    'namespace' =>  'CourseManage\Controllers'
],function(){
    Route::post('change-order-status', "OrderCourseManageController@changeOrderStatus");
});
Route::get('esystem/import/questions', array('uses' => "CourseManage\Controllers\ImportQuestionController@import"));
Route::post('esystem/do-import/questions', array('uses' => "CourseManage\Controllers\ImportQuestionController@doImport"));