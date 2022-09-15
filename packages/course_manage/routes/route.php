<?php
Route::group([
    'prefix' => 'esystem/view-order',
    'middleware' => ['web','h_users'],
    'namespace' =>  'CourseManage\Controllers'
],function(){
    Route::get('order_courses', "OrderCourseManageController@viewOrderCourse");
    Route::get('order_course_combos', "OrderCourseManageController@viewOrderCourseCombo");
});
Route::group([
    'prefix' => 'esystem/course-manage',
    'middleware' => ['web','h_users'],
    'namespace' =>  'CourseManage\Controllers'
],function(){
    Route::post('change-order-course-status', "OrderCourseManageController@changeOrderCourseStatus");
    Route::post('change-order-course-combo-status', "OrderCourseManageController@changeOrderCourseComboStatus");
});
