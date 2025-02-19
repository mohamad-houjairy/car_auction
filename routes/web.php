<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\NotificationController;

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('list', [AuctionController::class, 'index'])->name('auctions.index');
    /////////////////////////////////////////////////userlist/////////////////////////////////////////////////
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register-view.register');
Route::post('register', [RegisterController::class, 'register'])->name('register');
});

// Vendor Routes
Route::middleware(['auth', 'role:vendor'])->group(function () {
    
    ///////////////////////////////////////////my auction (vendor)///////////////////////////////////////////////////////////////////


});

// Patient Routes
Route::middleware(['auth', 'role:patient'])->group(function () {
 

});
// Apply middleware to allow admin and vendor access
Route::middleware(['auth', 'admin_or_vendor'])->group(function () {
 Route::get('/my-auctions', [AuctionController::class, 'myAuctions'])->name('auctions.my');
    Route::get('/auctions/{id}/edit', [AuctionController::class, 'edit'])->name('auctions.edit');
    Route::put('/auctions/{id}', [AuctionController::class, 'update'])->name('auctions.update');
    Route::delete('/auctions/{id}', [AuctionController::class, 'destroy'])->name('auctions.destroy');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/auctions/create', [AuctionController::class, 'create'])->name('auctions.create');
});


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
    return view('home-view/home');
});

Route::get('/home', [PostController::class, 'home'])->name('home-view.home');
  Route::get('/myaccount', [PostController::class, 'myaccount'])->name('myaccount-view.myaccount');
  
  Route::get('/createbids', [PostController::class, 'createbids'])->name('myaccount-view.createbids');
  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  Route::resource('auctions', AuctionController::class);
  Route::get('/login', function () {
    return view('auth.login'); // Make sure you have resources/views/auth/login.blade.php
})->name('login');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register-view.register');
Route::post('register', [RegisterController::class, 'register'])->name('register');
///////////////////////////////////////////////////Login////////////////////////////////////////////////////////////////////////////
// routes/web.php
use App\Http\Controllers\Auth\LoginController;

// Display the login form
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

// Handle the login request
Route::post('login', [LoginController::class, 'login']);

// Logout route
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
////////////////////////////////// Password reset routes/////////////////////////////////////////////////////
// Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
// Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
//////////////////////////////////////show details of car/////////////////////////////////////////////////////////////
// Show auction details
Route::middleware(['auth'])->group(function () {
// Route to show car details based on auction ID
Route::get('/auction/{id}/details', [AuctionController::class, 'showCarDetails'])->name('car.details');

  
});
// //////////////////////////////Auction CRUD////////////////////////////////////////////////////////////////////////
Route::get('/auctions', [AuctionController::class, 'index2'])->name('auctions.index2');



Route::post('/auctions', [AuctionController::class, 'store'])->name('auctions.store');
Route::get('/auctions/{id}', [AuctionController::class, 'show'])->name('auctions.show');

//////////////////////////////////////////////////////////////////////////////bidspage//////////////////////////////
Route::middleware(['auth'])->group(function () {
    Route::get('/bids/{auction}', [BidController::class, 'index'])->name('bids.index');
    Route::post('/bids/store/{auction}', [BidController::class, 'store'])->name('bids.store');
});

Route::post('/auctions/{auction}/end', [AuctionController::class, 'endAuction'])->name('auctions.end');
Route::get('/test', function () {
    return 'Test route is working!';
});


/////////////////////////////////my bids///////////////////////////////////////////////////////////////////////////////////////
Route::get('/my-bids', [AuctionController::class, 'myBids'])->name('auctions.my_bids');
/////////////////////////////////change password ////////////////////////////////////////////////////////////////


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home-view.home');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
///////////////////////////////////reset password/////////////////////////////////////////////////////////////////////////
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Forgot Password Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Reset Password Routes
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
 Route::get('/profile', [PostController::class, 'edit'])->name('profile.edit');
Route::post('/profile', [PostController::class, 'update'])->name('');
Route::get('/accountdetails', [PostController::class, 'accountdetails'])->name('');



Route::get('/user/{user}/edit', [PostController::class, 'edit'])->name('myaccount-view.accountdetails');
Route::put('/user/{user}', [PostController::class, 'update'])->name('profile.update');

use App\Http\Controllers\FavoriteController;

Route::post('/favorites/add/{id}', [FavoriteController::class, 'add'])->name('favorites.add');
Route::post('/favorites/remove/{id}', [FavoriteController::class, 'remove'])->name('favorites.remove');
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.list');
///////////////////////////////////////////////////////////notf/////////////////////////////////
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

// Mark notification as read
Route::post('/notifications/{notificationId}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
