<?php
Route::get('xem-lich-su-hoc-cua-hoc-vien/{id}', 'ManagerUserController@viewLearningHistoryOfUser');
Route::get('danh-sach-hoc-vien-cua-giao-vien/{id}', 'ManagerUserController@manageStudentOfTeacher');
Route::get('thong-ke-nguoi-hoc-cua-khoa-hoc/{id}', 'ManagerUserController@staticalUserStudentOfCourse');

Route::get('statical-all', 'ManagerUserController@staticalAll');
Route::get('user-and-course', 'ManagerUserController@staticalUserAndCourse');
Route::get('statical-user', 'ManagerUserController@staticalUser');
Route::get('statical-course', 'ManagerUserController@staticalCourse');
