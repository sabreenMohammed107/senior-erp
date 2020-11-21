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
    Route::get('/Reports/CashBox/Account/Create','CashBoxAccountController@index');
    //Fetch
    Route::post('/Reports/CashBox/Account/Fetch','CashBoxAccountController@FetchEntries');
    //---------
    Route::get('/Reports/Supplier/Account/Create','SupplierAccountController@index');
    //Fetch
    Route::post('/Reports/Supplier/Account/Fetch','SupplierAccountController@FetchEntries');
    //---------
});
