<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/loginCheck','ApiControlle@loginCheck');
Route::post('/upload_image','ApiControlle@uploadImage');
Route::post('/get_progress_by_home_id','ApiControlle@getAllProgress');
Route::post('/get_progress_by_id','ApiControlle@getProgressById');
Route::post('/get_home_by_customer_id','ApiControlle@getHomeByCustomerId');
Route::post('/get_payments_by_home_id','ApiControlle@getAllPaymentByHome');
Route::post('/get_payments_by_id','ApiControlle@getPaymentById');

