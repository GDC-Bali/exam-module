<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('exam')->name('exam.')->group(function() {
    Route::get('/', 'ExamController@index')->name('dashboard');

    Route::resource('/group-category', 'GroupCategoryController');
    Route::post('/group-category/multiple_delete','GroupCategoryController@multiple_delete')->name('group-category.multipledelete');
    Route::get('/getdata-groupcategory', 'GroupCategoryController@getData')->name('group-category.getdata');

    Route::resource('/question-group', 'QuestionGroupController');
    Route::post('/question-group/multiple_delete','QuestionGroupController@multiple_delete')->name('question-group.multipledelete');
    Route::get('/getdata-questiongroup', 'QuestionGroupController@getData')->name('question-group.getdata');
    Route::post('/questiongroup-addfrombank', 'QuestionGroupController@addQuestionFromBank')->name('question-group.addfrombank');
    Route::post('/questiongroup-detachquestion', 'QuestionGroupController@detachQuestion')->name('question-group.detachquestion');
    Route::post('/questiongroup-reorder', 'QuestionGroupController@reorder')->name('question-group.reorder');

    Route::resource('/question-type', 'QuestionTypeController');
    Route::post('/question-type/multiple_delete','QuestionTypeController@multiple_delete')->name('question-type.multipledelete');
    Route::get('/getdata-questiontype', 'QuestionTypeController@getData')->name('question-type.getdata');    

    Route::resource('/question-category', 'QuestionCategoryController');
    Route::post('/question-category/multiple_delete','QuestionCategoryController@multiple_delete')->name('question-category.multipledelete');
    Route::get('/getdata-questioncategory', 'QuestionCategoryController@getData')->name('question-category.getdata');    

    Route::resource('/attempt', 'AttemptController');
    Route::get('/attempt/start/{id}', 'AttemptController@start')->name('attempt.start');
    Route::get('/attempt/show-essay', 'AttemptController@showEssay')->name('attempt.show-essay');
    Route::get('/attempt/{id}/detail', 'AttemptController@detail')->name('attempt.detail');
    Route::get('/get-attempt/{number}', 'AttemptController@getData')->name('attempt.getdata');
    Route::post('/attempt/save-answer', 'AttemptController@saveAnswer');
    Route::post('/attempt/end', 'AttemptController@endAttempt')->name('attempt.finish');
    Route::get('/getdata-attempt', 'AttemptController@getDatatable')->name('attempt.getdata');
    Route::get('/attempt/{id}/result', 'AttemptController@result')->name('attempt.result');
    Route::get('/attempt/{id}/review', 'AttemptController@review')->name('attempt.review');
    Route::get('/history', 'AttemptController@history')->name('history');
    Route::get('/get-review/{number}/{attempt_id}', 'AttemptController@getReview')->name('attempt.getreview');
    Route::get('/attempt/finalisasi-essay/{id}', 'AttemptController@finalisasiEssay')->name('attempt.finalisasiessay');
    Route::post('/attempt/save-essay/{id}', 'AttemptController@saveEssay')->name('attempt.saveessay');


    Route::get('/getdata-question','QuestionController@getData')->name('question.getdata');
    Route::get('/getdata-question/{group_id}','QuestionController@getDataByGroup')->name('question.getdatabygroup');

    Route::resource('/questions', 'QuestionController');
    Route::post('/questions/multiple_delete','QuestionController@multiple_delete')->name('questions.multipledelete');
    Route::post('/questions/image_upload','QuestionController@image_upload')->name('questions.image_upload');
    Route::get('/getdata-questions', 'QuestionController@getData')->name('questions.getdata'); 
    Route::get('/getdata-questionsbank', 'QuestionController@getDataBank')->name('questions.getbank'); 
    Route::get('/getdata-getdetailquestion/{id}', 'QuestionController@getDetailQuestion')->name('questions.getDetailQuestion'); 
});

