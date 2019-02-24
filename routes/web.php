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

Route::get('/', 'Auth\LoginController@showLogin');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'web'], function() {
    /** ============= Authentication ============= */
    Route::get('/auth/login', 'Auth\LoginController@showLogin');

    Route::post('/auth/signin', 'Auth\LoginController@doLogin');

    Route::get('/auth/logout', 'Auth\LoginController@doLogout');

    Route::get('/auth/register', 'Auth\RegisterController@register');

    Route::post('/auth/signup', 'Auth\RegisterController@create');
});

Route::group(['middleware' => ['web','auth']], function () {
    Route::get('reserve/calendar', 'ReservationController@calendar');    
    Route::get('reserve/list', 'ReservationController@list');    
    Route::get('reserve/add', 'ReservationController@add');  
    Route::post('reserve/store', 'ReservationController@store');        
    Route::get('reserve/edit', 'ReservationController@edit');  
    Route::post('reserve/update', 'ReservationController@update');  
    Route::get('reserve/ajaxlayout/{id}', 'ReservationController@ajaxlayout');  
    Route::get('reserve/ajaxcalendar/{sdate}/{edate}', 'ReservationController@ajaxcalendar');

    // Route::get('reserve/creditor-paid', 'ReservationController@creditorPaid');    
    // Route::get('reserve/creditor-paid-rpt/{creditor}/{sdate}/{edate}/{showall}', 'ReservationController@creditorPaidRpt');     
    // Route::get('reserve/creditor-paid-excel/{creditor}/{sdate}/{edate}/{showall}', 'ReservationController@creditorPaidExcel');

    Route::get('room/list', 'RoomController@list');
    Route::get('room/detail/{roomId}', 'RoomController@detail');
    Route::get('room/get-room/{roomId}', 'RoomController@getById');
    Route::get('room/add', 'RoomController@add');
    Route::post('room/store', 'RoomController@store');
    Route::get('room/edit/{roomId}', 'RoomController@edit');
    Route::put('room/update', 'RoomController@update');
    Route::delete('room/delete/{roomId}', 'RoomController@delete');

    Route::get('equipment/list', 'EquipmentController@list');
	Route::get('equipment/search/{searchKey}', 'EquipmentController@search');
    Route::get('equipment/get-equipment/{equipmentId}', 'EquipmentController@getById');
    Route::get('equipment/add', 'EquipmentController@add');
    Route::post('equipment/store', 'EquipmentController@store');
    Route::get('equipment/edit/{equipmentId}', 'EquipmentController@edit');
    Route::put('equipment/update', 'EquipmentController@update');
    Route::delete('equipment/delete/{equipmentId}', 'EquipmentController@delete');

    Route::get('debt/list', 'DebtController@list');
    Route::get('debt/rpt/{creditor}/{sdate}/{edate}/{showall}', 'DebtController@debtRpt');
    Route::get('debt/get-debt/{debtId}', 'DebtController@getById');
    Route::get('debt/add/{creditor}', 'DebtController@add');
    Route::post('debt/store', 'DebtController@store');
    Route::get('debt/edit/{creditor}/{debtId}', 'DebtController@edit');
    Route::put('debt/update', 'DebtController@update');
    Route::delete('debt/delete/{debtId}', 'DebtController@delete');
    Route::post('debt/setzero', 'DebtController@setZero');

    Route::get('report/debt-creditor/list', 'ReportController@debtCreditor');    
    Route::get('report/debt-creditor/rpt/{creditor}/{sdate}/{edate}/{showall}', 'ReportController@debtCreditorRpt');    
    Route::get('report/debt-creditor-excel/{creditor}/{sdate}/{edate}/{showall}', 'ReportController@debtCreditorExcel');     
    Route::get('report/debt-debttype/list', 'ReportController@debtDebttype');    
    Route::get('report/debt-debttype/rpt/{debtType}/{sdate}/{edate}/{showall}', 'ReportController@debtDebttypeRpt');  
    Route::get('report/debt-debttype-excel/{debttype}/{sdate}/{edate}/{showall}', 'ReportController@debtDebttypeExcel');
    Route::get('report/debt-chart/{creditorId}', 'ReportController@debtChart');     
    Route::get('report/sum-month-chart/{month}', 'ReportController@sumMonth');     
    Route::get('report/sum-year-chart/{month}', 'ReportController@sumYear');     
});
