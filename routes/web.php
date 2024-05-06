<?php

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return view('home');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // $namespacePrefix = '\\' . config('voyager.controllers.namespace') . '\\';

    // Route::get('/', ['uses' => $namespacePrefix . 'VoyagerController@index',   'as' => 'dashboard']);
    Route::get('/admin', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/get-municipios/{departamento}', 'TCG\Voyager\Http\Controllers\AjaxController@obtener_municipios');
Route::get('/get-club/{liga}', 'TCG\Voyager\Http\Controllers\AjaxController@obtener_club');
Route::get('/get-modalidades/{tipo_arma}', 'TCG\Voyager\Http\Controllers\AjaxController@obtener_modalidades');


// Manejo de excepciones error 419 page expired
// Route::get('/test-419', function () {
//     throw new \Illuminate\Session\TokenMismatchException;
// });