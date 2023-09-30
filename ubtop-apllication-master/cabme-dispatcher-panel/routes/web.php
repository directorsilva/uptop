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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

Route::get('/users/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('users.profile');

Route::post('/users/profile/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.profile.update');

Route::get('/rides', [App\Http\Controllers\RidesController::class, 'all'])->name('rides');

Route::get('/ride/delete/{rideid}', [App\Http\Controllers\RidesController::class, 'deleteRide'])->name('ride.delete');

Route::get('/ride/show/{id}', [App\Http\Controllers\RidesController::class, 'show'])->name('ride.show');

Route::get('/rides/new', [App\Http\Controllers\RidesController::class, 'new'])->name('rides.new');

Route::get('/rides/confirmed', [App\Http\Controllers\RidesController::class, 'confirmed'])->name('rides.confirmed');

Route::get('/rides/onRide', [App\Http\Controllers\RidesController::class, 'onRide'])->name('rides.onRide');

Route::get('/rides/rejected', [App\Http\Controllers\RidesController::class, 'rejected'])->name('rides.rejected');

Route::get('/rides/completed', [App\Http\Controllers\RidesController::class, 'completed'])->name('rides.completed');

Route::get('/ride/delete/{rideid}', [App\Http\Controllers\RidesController::class, 'deleteRide'])->name('ride.delete');

Route::get('/ride/show/{id}', [App\Http\Controllers\RidesController::class, 'show'])->name('ride.show');

Route::get('/rides/filter', [App\Http\Controllers\RidesController::class, 'filterRides'])->name('rides.filter');

Route::put('/rides/update/{id}', [App\Http\Controllers\RidesController::class, 'updateRide'])->name('rides.update');

Route::get('/bookNow', [App\Http\Controllers\bookNowController::class, 'create'])->name('bookNow');

Route::post('/bookNow/store', [App\Http\Controllers\bookNowController::class, 'store'])->name('bookNow.store');


Route::post('/bookNow/storeUser', [App\Http\Controllers\bookNowController::class, 'storeUser'])->name('bookNow.storeuser');

Route::get('/bookNow/createUser', [App\Http\Controllers\bookNowController::class, 'createUser'])->name('bookNow.createuser');

Route::post('/bookNow/getDistance',[App\Http\Controllers\bookNowController::class, 'getDistance'])->name('bookNow.getDistance');

Route::get('/get-settings', [App\Http\Controllers\SettingsController::class, 'getSettings'])->name('get-settings');

Route::get('/getOnRides', [App\Http\Controllers\HomeController::class, 'getOnRides'])->name('getOnRides');

Route::get('lang/change', [App\Http\Controllers\languageController::class, 'change'])->name('changeLang');

Route::get('/getlang', [App\Http\Controllers\languageController::class, 'getLangauage'])->name('language.header');

Route::post('/gecode/{slugid}', [App\Http\Controllers\languageController::class, 'getCode'])->name('lang.code');
