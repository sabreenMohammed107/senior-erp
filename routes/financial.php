<?php

Route::namespace('Financial')->group(function () {
    //Banks Partition
    Route::get('/Financial/Banks','BanksController@index');
    Route::get('/Financial/Banks/Add','BanksController@Add');
    Route::get('/Financial/Banks/Edit/{bank_id}','BanksController@Edit');
    Route::get('/Financial/Banks/View/{bank_id}','BanksController@View');
    // POST Routes
    Route::post('/Financial/Banks/Create','BanksController@Create');
    Route::post('/Financial/Banks/Update','BanksController@Update');
    Route::post('/Financial/Banks/Delete','BanksController@Delete');

    //CashBoxes Partition
    Route::get('/Financial/CashBox','CashBoxController@index');
    Route::get('/Financial/CashBox/Add','CashBoxController@Add');
    Route::get('/Financial/CashBox/Edit/{cash_box_id}','CashBoxController@Edit');
    Route::get('/Financial/CashBox/View/{cash_box_id}','CashBoxController@View');
    // POST Routes
    Route::post('/Financial/CashBox/Create','CashBoxController@Create');
    Route::post('/Financial/CashBox/Update','CashBoxController@Update');
    Route::post('/Financial/CashBox/Delete','CashBoxController@Delete');

    //GLChart Partition
    Route::get('/Financial/GLChart','GLChartController@index');
    Route::get('/Financial/GLChart/Fetch','GLChartController@FetchTree');
    Route::get('/Financial/GLChart/Add','GLChartController@Add');
    Route::get('/Financial/GLChart/Edit','GLChartController@Edit');
    Route::get('/Financial/GLChart/Delete/{id}','GLChartController@Delete');
    // POST Routes
    Route::post('/Financial/GLChart/Create','GLChartController@Create');
    Route::post('/Financial/GLChart/Update','GLChartController@Update');

});
