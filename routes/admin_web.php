<?php

use Illuminate\Support\Facades\Route;

// Admin Route Group
Route::prefix('admin')->name('admin.')->middleware('auth:admin_user')->namespace('Backend')->group(function() {
    // Admin Home Page
    Route::get('/', 'PageController@home')->name('home');

    // Admin User
    Route::resource('/admin-user', 'AdminUserController');
    // Admin User Datatables
    Route::get('/admin-user/datatables/ssd', 'AdminUserController@ssd')->name('admin-user.datatables.ssd');
    // User
    Route::resource('/user', 'UserController');
    // User Datatables
    Route::get('/user/datatables/ssd', 'UserController@ssd')->name('user.datatables.ssd');
    //Wallet
    Route::get('wallet', 'WalletController@index')->name('wallet.index');
    // Wallet Datatables
    Route::get('/wallet/datatables/ssd', 'WalletController@ssd')->name('wallet.datatables.ssd');
});