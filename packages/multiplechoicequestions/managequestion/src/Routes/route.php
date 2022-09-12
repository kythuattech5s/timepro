<?php
Route::group(['prefix' => 'manage-question', 'middleware' => 'web', 'namespace' => 'multiplechoicequestions\managequestion\Controllers'], function () {
	Route::post('/load-question-content-admin', 'ManageQuestionController@loadQuestionContentAdmin');
	Route::post('/load-list-question-admin', 'ManageQuestionController@loadListQuestionAdmin');
	Route::post('/insert-list-question', 'ManageQuestionController@insertListQuestion');
	Route::post('/delete-item-question-pivot', 'ManageQuestionController@deleteQuestionPivot');
	Route::post('/update-item-question-pivot', 'ManageQuestionController@updateQuestionPivot');
	Route::post('/update-match-question-pivot', 'ManageQuestionController@updateMatchQuestionPivot');
	Route::post('/build-math-addition-subtraction-multiplication', 'ManageQuestionController@buildMathAdditionSubtractionMultiplication');
	Route::post('/build-math-number-concatenation', 'ManageQuestionController@buildMathNumberConcatenation');
});