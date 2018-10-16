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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard',function(){
// 	return view('layouts.master');
// });


Route::get('/',[
	'as'=>'/',
	'uses'=>'LoginController@getLogin',
]);
Route::post('/login',[
	'as'=>'login',
	'uses'=>'LoginController@postLogin',
]);

Route::get('/noPermission',function(){
	return view('permission.noPermission');
});

Route::group( ['middleware'=>['authen'] ] , function(){
	Route::get('/dashboard',[
		'as'=>'dashboard',
		'uses'=>'DashboardController@dashboard',
	]);
	Route::get('/logout',[
		'as'=>'logout',
		'uses'=>'LoginController@getLogout',
	]);
});

Route::group( ['middleware'=>['authen','roles'] , 'roles'=>['admin'] ] , function(){
	
	Route::get('/manage/course',[
		'as'=>'manageCourse',
		'uses'=>'CourseController@getManageCourse',
	]);
	Route::post('/manage/course/insert',[
		'as'=>'postInsertAcademic',
		'uses'=>'CourseController@postInsertAcademic',
	]);
	Route::post('/manage/course/insert-program',[
		'as'=>'postInsertProgram',
		'uses'=>'CourseController@postInsertProgram',
	]);
	Route::post('/manage/course/insert-level',[
		'as'=>'postInsertLevel',
		'uses'=>'CourseController@postInsertLevel',
	]);

	Route::get('manage/course/show-level',[
		'as'=>'showLevel',
		'uses'=>'CourseController@showLevel',
	]);

	Route::post('/manage/course/insert-shift',[
		'as'=>'postInsertShift',
		'uses'=>'CourseController@postInsertShift',
	]);
	Route::post('/manage/course/insert-time',[
		'as'=>'postInsertTime',
		'uses'=>'CourseController@postInsertTime',
	]);

	Route::post('/manage/course/insert-batch',[
		'as'=>'postInsertBatch',
		'uses'=>'CourseController@postInsertBatch',
	]);

	Route::post('/manage/course/insert-group',[
		'as'=>'postInsertGroup',
		'uses'=>'CourseController@postInsertGroup',
	]);

	Route::post('/manage/course/insert-class',[
		'as'=>'postInsertclass',
		'uses'=>'CourseController@postInsertclass',
	]);

	Route::get('/manage/course/classInfo',[
		'as'=>'getClassInformation',
		'uses'=>'CourseController@getClassInformation',
	]);

	Route::post('/manage/course/class/delete',[
		'as'=>'deleteClass',
		'uses'=>'CourseController@deleteClass',
	]);

	Route::get('/manage/course/class/edit',[
		'as'=>'editClass',
		'uses'=>'CourseController@editClass',
	]);

	Route::post('/manage/course/class/update',[
		'as'=>'upadteClassInformation',
		'uses'=>'CourseController@upadteClassInformation',
	]);

	//********************* Student controller routes ***************************///

	Route::get('/student/get-register',[
		'as'=>'get_student_register',
		'uses'=>'StudentController@showStudentRegistrationForm',
	]);
	Route::post('/student/insert-student',[
		'as'=>'insert_student',
		'uses'=>'StudentController@insertStudent',
	]);

	//list out students and search and edit functionality

	Route::get('/student/show-studentlist',[
		'as'=>'showStudentInfo',
		'uses'=>'StudentController@showStudentInfo'
	]);

	

	Route::get('/student/show-studentlist-ajax',[
		'as'=>'ShowAjaxStudentView',
		'uses'=>'StudentController@ShowAjaxStudentView'
	]);

	Route::post('/student/show-studentlist-ajaxdata',[
		'as'=>'showAjaxStudentInfo',
		'uses'=>'StudentController@showAjaxStudentInfo'
	]);

	//********************* Student Fee Payment ***************************///
	
	Route::get('/student/payment/show',[
		'as'=>'getPayment',
		'uses'=>'FeeController@getPayment',
	]);

	Route::get('/student/payment/search',[
		'as'=>'showStudentPayment',
		'uses'=>'FeeController@showStudentPayment',
	]);

	Route::get('/student/payment/proceed/{student_id}',[
		'as'=>'proceedToPay',
		'uses'=>'FeeController@proceedToPay',
	]);

	Route::post('/student/payment/save',[
		'as'=>'savePayment',
		'uses'=>'FeeController@savePayment',
	]);

	//**********************Remaining Fee***************************************//
	Route::get('/student/payment/get-remaining-fee',[
		'as'=>'getRemainingFeeToPay',
		'uses'=>'FeeController@getRemainingFeeToPay',
	]);

	Route::post('/student/payment/remaininf-fee/save',[
		'as'=>'payRemainingFee',
		'uses'=>'FeeController@payRemainingFee',
	]);


	//********************* Create FEEE ***************************///

	Route::post('/student/fee/create',[
		'as'=>'createFee',
		'uses'=>'FeeController@createFee',
	]);


	//********************* Receipt ***************************///

	Route::get('/student/payment/invoice/{receipt_id}',[
		'as'=>'printInvoince',
		'uses'=>'FeeController@printInvoince',
	]);

	//********************* Delete Transaction ***************************///

	Route::get('/student/transaction/delete/{transact_id}',[
		'as'=>'deleteTransaction',
		'uses'=>'FeeController@deleteTransaction',
	]);


	//8888888888888888888888show level (payment page header value change on course change)
	Route::get('/student/level/change',[
		'as'=>'showLevelStudent',
		'uses'=>'FeeController@showLevelStudent',
	]);

	Route::get('/student/invoice/change',[
		'as'=>'changeInvoiceId',
		'uses'=>'FeeController@changeInvoiceId',
	]);
	

	
	//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&& Report COntroller&&&&&&&&&&&&&&&&&&&&&&&&&

	Route::get('/report/student-list',[
		'as'=>'getStudentList',
		'uses'=>'ReportController@getStudentList',
	]);

	Route::get('/report/student-information',[
		'as'=>'showStudentInformation',
		'uses'=>'ReportController@showStudentInformation',
	]);

	Route::get('/report/multi-class-student-list',[
		'as'=>'getMultiClassStudentList',
		'uses'=>'ReportController@getMultiClassStudentList',
	]);

	Route::get('/report/multi-class-student-information',[
		'as'=>'showStudentMultiClassInformation',
		'uses'=>'ReportController@showStudentMultiClassInformation',
	]);

	//fee report

	Route::get('/report/show-fee-report',[
		'as'=>'showFeeReport',
		'uses'=>'ReportController@show_fee_report',
	]);

	Route::get('/report/get-fee-report',[
		'as'=>'getFeeReport',
		'uses'=>'ReportController@get_fee_report',
	]);


	//chart

	Route::get('/report/chart/new-student-registered',[
		'as'=>'newStudentRegistered',
		'uses'=>'ReportController@new_student_registered_chart',
	]);
	

});

