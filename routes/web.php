<?php

use App\Http\Controllers\Voyager\TipoPeticionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
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


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', 'App\Http\Controllers\Auth\VerificationController@verify')
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', 'App\Http\Controllers\Auth\VerificationController@send')
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/admin', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified']], function () {
    Voyager::routes();
});
Route::get('/get-municipios/{departamento}', 'TCG\Voyager\Http\Controllers\AjaxController@obtener_municipios');
Route::get('/get-club/{liga}', 'TCG\Voyager\Http\Controllers\AjaxController@obtener_club');
Route::get('/get-modalidades/{tipo_arma}', 'TCG\Voyager\Http\Controllers\AjaxController@obtener_modalidades');


// Manejo de excepciones error 419 page expired
// Route::get('/test-419', function () {
//     throw new \Illuminate\Session\TokenMismatchException;
// });




// <?php

// use App\Http\Controllers\Voyager\TipoPeticionController;
// use Illuminate\Support\Facades\Notification;
// use Illuminate\Foundation\Auth\EmailVerificationRequest;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

// /*
// |--------------------------------------------------------------------------
// | Web Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register web routes for your application. These
// | routes are loaded by the RouteServiceProvider and all of them will
// | be assigned to the "web" middleware group. Make something great!
// |
// */

// Route::get('/', function () {
//     // return view('welcome');
//     return view('home');
// });


// Route::middleware([
//     'auth:sanctum',
//     'verified',
// ])->group(function () {

//     // Route::get('/', ['uses' => $namespacePrefix . 'VoyagerController@index',   'as' => 'dashboard']);
//     Route::get('/', function () {
//         return view('home');
//     })->name('home');
// });

// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// })->middleware('auth')->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();

//     return redirect('/home');
// })->middleware(['auth', 'signed'])->name('verification.verify');


// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();

//     return back()->with('message', 'Verification link sent!');
// })->middleware(['auth', 'throttle:6,1'])->name('verification.send');


// // Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
// //     return view('dashboard');
// // })->name('dashboard');

// Route::group(['prefix' => 'admin'], function () {
//     Voyager::routes();
// });

// Route::get('/admin', function () {
//     // Only verified users may access this route...
// })->middleware(['auth', 'verified']);

// Route::get('/get-municipios/{departamento}', 'TCG\Voyager\Http\Controllers\AjaxController@obtener_municipios');
// Route::get('/get-club/{liga}', 'TCG\Voyager\Http\Controllers\AjaxController@obtener_club');
// Route::get('/get-modalidades/{tipo_arma}', 'TCG\Voyager\Http\Controllers\AjaxController@obtener_modalidades');


// // Manejo de excepciones error 419 page expired
// // Route::get('/test-419', function () {
// //     throw new \Illuminate\Session\TokenMismatchException;
// // });