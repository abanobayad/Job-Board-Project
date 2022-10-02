<?php

use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect('/listing');
});

Auth::routes();

Route::get('/listing', [App\Http\Controllers\ListingController::class, 'index'])->name('listing.index');
Route::get('/new', [App\Http\Controllers\ListingController::class, 'create'])->name('listing.create');
Route::post('/new-list', [App\Http\Controllers\ListingController::class, 'store'])->name('listing.store');
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
    Route::get('/{listing}', [App\Http\Controllers\ListingController::class, 'show'])->name('listing.show');
    Route::get('/{listing}/apply', [App\Http\Controllers\ListingController::class, 'apply'])->name('listing.apply');
});
