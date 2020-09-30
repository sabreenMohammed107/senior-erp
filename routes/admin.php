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
    Route::get('/stock/Remove/Item', 'StocksController@DeleteStockItem');
    /*********************==customer==******************* */
    Route::resource('/customer', 'CustomerController');
    Route::get('dynamicPersonCountry/fetch', 'CustomerController@fetchCity')->name('dynamicPersonCountry.fetch');
    Route::get('dynamicPersonCity/fetch', 'CustomerController@fetchLocation')->name('dynamicPersonCity.fetch');
    Route::get('dynamicRepBranch/fetch', 'CustomerController@dynamicRepBranch')->name('dynamicRepBranch.fetch');


    /*********************==supplier==******************* */
    Route::resource('/supplier', 'SupplierController');
    /*********************==item-price==******************* */
    Route::resource('/item-price', 'ItemPricingController');
    Route::get('addRowPrice/fetch', 'ItemPricingController@addRow')->name('addRowPrice.fetch');
    Route::get('/itemPrice/Remove/Item', 'ItemPricingController@DeletePriceItem');

    /*********************==item-discount==******************* */
    Route::resource('/item-discount', 'ItemDiscountController');
    Route::get('addRowDiscount/fetch', 'ItemDiscountController@addRow')->name('addRowDiscount.fetch');
    Route::get('/itemDiscount/Remove/Item', 'ItemDiscountController@DeletePriceItem');

    /*********************==sales-order==******************* */
    Route::resource('/sales-order', 'SaleOrderController');
    Route::get('/sales-order.creation', 'SaleOrderController@creation')->name('sales-order.creation');
    Route::get('/selectBranch-saleOrder.fetch', 'SaleOrderController@branchFetch')->name('selectBranch-saleOrder.fetch');
    Route::get('/editSelectVal.fetch', 'SaleOrderController@editSelectVal')->name('editSelectVal.fetch');
    Route::get('addRow-saleOrder/fetch', 'SaleOrderController@addRow')->name('addRow-saleOrder.fetch');
    Route::get('/editSelectValPerson.fetch', 'SaleOrderController@editSelectValPerson')->name('editSelectValPerson.fetch');
    Route::get('/editSelectBatch.fetch', 'SaleOrderController@editSelectBatch')->name('editSelectBatch.fetch');
    Route::get('/saleOrder/Remove/Item', 'SaleOrderController@DeleteOrderItem');
    /*********************==approve-oreder==******************* */
Route::resource('/approve-sales-order', 'ApproveSalesOrderController');
Route::get('/dynamicApprovalOrder.fetch', 'ApproveSalesOrderController@branchFetch')->name('dynamicApprovalOrder.fetch');
Route::post('/approveOrder', 'ApproveSalesOrderController@approveOrder')->name('approveOrder');

Route::post('/rejectOrder', 'ApproveSalesOrderController@rejectOrder')->name('rejectOrder');

/*********************************************************************** */

});
