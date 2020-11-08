<?php

Route::namespace('Reports')->group(function () {
    Route::get('/Reports/Financial/Transactions/Create','FinancialEntryController@index');
    //Fetch
    Route::post('/Reports/Financial/Transactions/Fetch','FinancialEntryController@FetchEntries');
    //---------
    Route::get('/Reports/Stock/Transactions/Create','StockEntryController@index');
    //Fetch
    Route::post('/Reports/Stock/Transactions/Fetch','StockEntryController@FetchEntries');
    //---------
});
