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

});