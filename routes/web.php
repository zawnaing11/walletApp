<?php

use Illuminate\Support\Facades\Route;

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
// Admin Authentication
Route::get('/admin/login', 'Auth\AdminLoginController@showLoginForm');
Route::post('/admin/login', 'Auth\AdminLoginController@login')->name('admin.login');
// Logout Admin Authentication
Route::post('/admin/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
Auth::routes();

Route::middleware('auth')->namespace('Frontend')->group(function() {
    // Frontend Home
    Route::get('/', 'PageController@home')->name('home');
    // Profile
    Route::get('profile', 'PageController@profile')->name('profile');
    // Update Password
    Route::get('update-password', 'PageController@updatePassword')->name('update-password');
    Route::post('update-password', 'PageController@updatePasswordStore')->name('update-password-store');
    // Wallet
    Route::get('wallet', 'PageController@wallet')->name('wallet');
    //Transfer
    Route::get('transfer', 'PageController@transfer')->name('transfer');
    // Transfer Hash
    Route::get('transfer-hash', 'PageController@transferHash')->name('transfer.hash');
    // Transfer Confirm
    Route::get('transfer/confirm', 'PageController@transferConfrim')->name('transfer.confirm');
    // Transfer complete
    Route::post('transfer/complete', 'PageController@transferComplete')->name('transfer.complete');
    // Password Check
    Route::get('/password-check', 'PageController@passwordCheck');
    // To Account Verify
    Route::get('/to-account-verify', 'PageController@toAccountVerify');
    // Transaction
    Route::get('/transaction', 'PageController@transaction')->name('transaction');
    // Transaction Details
    Route::get('/transaction/{trs_id}/{status}', 'PageController@transactionDetail')->name('transaction.detail');
});