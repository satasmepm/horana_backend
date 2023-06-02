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

// Route::get('/', function () {
//     return view('auth.login');
// });
Auth::routes();
Route::resource('/customer', CustomerController::class);
Route::get('/view_customers','CustomerController@viewCustomers');
Route::get('/geAllData','CustomerController@getEmployee');
Route::get('/pdfs', 'CustomerController@viewPdf');

Route::resource('/tower', TowerController::class);
Route::get('/view_towers','TowerController@viewTowers');
Route::get('/geAllTowerData','TowerController@getTowers');

Route::resource('/floor', FloorController::class);
Route::get('/view_floors','FloorController@viewfloors');
Route::get('/geAllFloorData','FloorController@getFloor');

Route::resource('/home', HomeController::class);
Route::get('/view_homes','HomeController@viewHomes');
Route::get('/get_floor_by_tower_id/{id}','HomeController@getFloorByTowerId');
Route::get('/geAllHomeData','HomeController@getHome');
// Route::get('/installemt','HomeController@installemt');

Route::resource('/payments', PaymentDetailsController::class);
Route::get('/installemt','PaymentDetailsController@installemt');
Route::get('/get_home_by_floorid/{id}','PaymentDetailsController@getHomeByFloorId');
Route::get('/get_customer_by_home_id/{id}','PaymentDetailsController@getCustomerByHomeId');
Route::get('/geAllPaymentsData','PaymentDetailsController@getPaymentsData');
Route::get('/view_payments','PaymentDetailsController@viewPayments');

Route::post('/installemt_by_home_id','PaymentDetailsController@installemtByHome');


Route::resource('/asign_home', AsignHomeController::class);
Route::get('/view_asign_homes','AsignHomeController@viewAsignHomes');
Route::get('/geAllAsignHomesData','AsignHomeController@getAllAsignHomesData');
Route::get('/get_home_by_floor_id/{id}','AsignHomeController@getHomeByFloorId');
Route::get('/autocomplete2-searchCustomer','AsignHomeController@searchCustomer');


// Route::get('/installemt','AsignHomeController@installemt');
// Route::get('/pdf/{filename}', 'CustomerController@show1')->name('pdf.show1');
Route::resource('/users', UserController::class);
Route::get('/view_users','UserController@viewUsers');
Route::get('/geAllUserData','UserController@getUsers');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    return redirect(route('login'));
});

Route::resource('/progress', ProgressController::class);
Route::get('/view_progress','ProgressController@viewProgress');
Route::get('/geAllProgressData','ProgressController@getAllProgressData');

Route::post('/installemt_by_home_id','PaymentDetailsController@installemtByHome');

Route::get('/resheddule','PaymentDetailsController@resheddule');
Route::post('/resheddule_by_home_id','PaymentDetailsController@reshedduleByHome');

