<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//任务
// Route::get('/job','Front\JobController@index');
// Route::get('/tc','Front\JobController@tc');
// Route::put('/lock','Front\JobController@lock');

// //队列
// Route::get('/pipeline','Front\PipelineController@index');
// Route::put('/pipeline/add','Front\PipelineController@add');
// Route::put('/pipeline/cancel','Front\PipelineController@cancel');
// //模板
// Route::get('/preset','Front\PresetController@index');
// Route::get('/notification','Front\NotificationController@index');

// //通知
// Route::post('/notification/job','Front\NotificationController@save');
// Route::get('/notification/job/all','Front\NotificationController@get');
// Route::get('/notification/job/one','Front\NotificationController@one');


// Route::get('/notification/job/getid','Front\NotificationController@getid');
// Route::post('/notification/job/lock','Front\NotificationController@lock');

// Route::put('/notification/job/setjobstate','Front\NotificationController@setJobState');
// Route::put('/notification/job/setjobdata','Front\NotificationController@setJobData');

Route::group(['namespace'=>'Front'],function(){
	Route::get('/job','JobController@index');
	Route::get('/tc','JobController@tc');
	Route::put('/lock','JobController@lock');

	//队列
	Route::get('/pipeline','PipelineController@index');
	Route::put('/pipeline/add','PipelineController@add');
	Route::put('/pipeline/cancel','PipelineController@cancel');

	//模板
	Route::get('/preset','PresetController@index');
	Route::get('/notification','NotificationController@index');

	//通知
	Route::post('/notification/job','NotificationController@save');
	Route::get('/notification/job/all','NotificationController@get');
	Route::get('/notification/job/one','NotificationController@one');


	Route::get('/notification/job/getid','NotificationController@getid');
	Route::post('/notification/job/lock','NotificationController@lock');

	Route::put('/notification/job/setjobstate','NotificationController@setJobState');
	Route::put('/notification/job/setjobdata','NotificationController@setJobData');

});

Route::group(['namespace'=>'Admin','prefix'=>'v1_0/admin/tc'],function(){
	//队列
	Route::get('pipeline','PipelineController@index');

});

//Route::get('api','TestController@index')->middle('ddv-restful-api');



Route::group(['middleware' => 'ddv'], function () {
    Route::get('testapi', 'TestController@index');

   
});




