<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Referrals\ReferralController;

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
    return view('welcome');
})->name('index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin/referrals', [ReferralController::class, 'list'])->name('list');
Route::get('/admin/own-referrals', [ReferralController::class, 'ownlist'])->name('ownlist');

Route::group(['prefix' => 'referrals', 'namespace' => 'Referrals'], function() {

    Route::get('/',  [ReferralController::class, 'index'])->name('referrals');
    Route::post('/',  [ReferralController::class, 'store']);
    Route::post('/submitemail',  [ReferralController::class, 'submitemail']);

});
