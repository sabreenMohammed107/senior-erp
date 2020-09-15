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

Route::get('/', function () {
    return view('home');
});

/*********************==Branch==******************* */
Route::resource('/branch', 'BranchController');
Route::POST('branch/search', 'BranchController@search')->name('branch.search');

/*********************==users==******************* */
Route::resource('/users', 'AdminUsersController');
Route::get('/userSite', 'AdminUsersController@userSite')->name('userSite');

Route::get('/userStock', 'AdminUsersController@userStock')->name('userStock');

/*********************==item-category==******************* */
Route::resource('/item-category', 'ItemCategoryController');
Route::POST('add-subCategory', 'ItemCategoryController@AddsubCategory')->name('add-subCategory');
Route::POST('delete-subCategory/{id}', 'ItemCategoryController@deletesubCategory')->name('delete-subCategory');
/*********************==orders==******************* */
Route::resource('/orders', 'OrdersController');
Route::get('/orders.creation', 'OrdersController@creation')->name('orders.creation');
Route::get('/dynamicBranch.fetch', 'OrdersController@branchFetch')->name('dynamicBranch.fetch');
Route::get('addRow/fetch', 'OrdersController@addRow')->name('addRow.fetch');
Route::get('/editSelectVal.fetch', 'OrdersController@editSelectVal')->name('editSelectVal.fetch');
Route::get('/editSelectValPerson.fetch', 'OrdersController@editSelectValPerson')->name('editSelectValPerson.fetch');
Route::get('/orders/Remove/Item','OrdersController@DeleteOrderItem');
Route::get('/editSelectBatch.fetch', 'OrdersController@editSelectBatch')->name('editSelectBatch.fetch');

/*********************==invoice==******************* */
Route::resource('/invoice', 'InvoiceController');
Route::get('/invoice.creation', 'InvoiceController@creation')->name('invoice.creation');

Route::get('/dynamicBranchInvoice.fetch', 'InvoiceController@branchFetch')->name('dynamicBranchInvoice.fetch');
Route::get('/dynamicOrderInvoice.fetch', 'InvoiceController@orderInvoice')->name('dynamicOrderInvoice.fetch');
Route::get('/dynamicOrderItemsInvoice.fetch', 'InvoiceController@orderItemsInvoice')->name('dynamicOrderItemsInvoice.fetch');

Route::get('/editSelectValInvoice.fetch', 'InvoiceController@editSelectVal')->name('editSelectValInvoice.fetch');
Route::get('/editSelectBatchInvoice.fetch', 'InvoiceController@editSelectBatch')->name('editSelectBatchInvoice.fetch');

Route::get('addInvoiceRow/fetch', 'InvoiceController@addRow')->name('addInvoiceRow.fetch');
/*********************==items==******************* */
Route::resource('/items', 'ItemController');
/*********************==stocks==******************* */
Route::resource('/stocks', 'StocksController');
Route::get('/stockBranchdetails.fetch', 'StocksController@branchFetch')->name('stockBranchdetails.fetch');
Route::get('/stocks.creation', 'StocksController@creation')->name('stocks.creation');
/*********************==approve-oreder==******************* */
Route::resource('/approve-order', 'OrderApprovalController');
Route::get('/dynamicApprovalOrder.fetch', 'OrderApprovalController@branchFetch')->name('dynamicApprovalOrder.fetch');
Route::post('/approveOrder', 'OrderApprovalController@approveOrder')->name('approveOrder');

Route::post('/rejectOrder', 'OrderApprovalController@rejectOrder')->name('rejectOrder');








