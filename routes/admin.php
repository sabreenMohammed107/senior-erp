<?php



Route::namespace('Admin')->group(function () {
    /*********************==Branch==******************* */
Route::resource('/branch', 'BranchController');
Route::POST('branch/search', 'BranchController@search')->name('branch.search');
/*********************==users==******************* */
Route::resource('/users', 'UserController');
Route::get('/userSite', 'UserController@userSite')->name('userSite');
Route::get('/userStock', 'UserController@userStock')->name('userStock');
Route::post('users/search', 'UserController@search')->name('users.search');
/*********************==item-category==******************* */
Route::resource('/item-category', 'ItemCategoryController');
Route::POST('add-subCategory', 'ItemCategoryController@AddsubCategory')->name('add-subCategory');
Route::POST('delete-subCategory/{id}', 'ItemCategoryController@deletesubCategory')->name('delete-subCategory');
/*********************==items==******************* */
Route::resource('/items', 'ItemsController');
Route::POST('items/search', 'ItemsController@search')->name('items.search');
/*********************==stocks==******************* */
Route::resource('/stocks', 'StocksController');
Route::get('/stockBranchdetails.fetch', 'StocksController@branchFetch')->name('stockBranchdetails.fetch');
Route::get('/stocks.creation', 'StocksController@creation')->name('stocks.creation');
Route::get('/stockCategory', 'StocksController@stockCategory')->name('stockCategory');
Route::get('/stockTransaction', 'StocksController@stockTransaction')->name('stockTransaction');
Route::get('/stocks.openBalance/{id}', 'StocksController@openBalance')->name('stocks.openBalance');
Route::get('addRow/fetch', 'StocksController@addRow')->name('addRow.fetch');
Route::get('/editSelectVal.fetch', 'StocksController@editSelectVal')->name('editSelectVal.fetch');
Route::post('/store-open-balance', 'StocksController@storeOpenBalance')->name('store-open-balance');
Route::post('/approve-open-balance', 'StocksController@approveOpenBalance')->name('approve-open-balance');
Route::get('/stock/Remove/Item','StocksController@DeleteStockItem');







});