<?php

use Illuminate\Support\Facades\Route;

// Admin Route Group
Route::prefix('admin')->name('admin.')->middleware('auth:admin_user')->namespace('Backend')->group(function() {
    // Admin Home Page
    Route::get('/', 'PageController@home')->name('home');
});