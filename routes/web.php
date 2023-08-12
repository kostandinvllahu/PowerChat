<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SearchFriendsController;
use App\Http\Controllers\FriendRequestController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::resource('settings', SettingsController::class);
Route::resource('friendRequest',FriendRequestController::class);
Route::put('friendRequest/{friendId}/{option}', [FriendRequestController::class, 'update'])->name('friendRequest.update');
Route::resource('searchFriends', SearchFriendsController::class);
Route::get('verify-account/{tokenId}',[LoginController::class,'verifyAccount']);

