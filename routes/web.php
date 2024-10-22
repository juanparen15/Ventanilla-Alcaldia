<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Voyager\InscripcionController;
use App\Http\Controllers\Voyager\VoyagerUserController;
use App\Http\Middleware\AllowPublicAccess;
use DragonCode\Support\Facades\Filesystem\File;
use Illuminate\Support\Facades\Response;
use TCG\Voyager\Facades\Voyager;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;

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
    return view('home');
});

// Email verification routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', 'App\Http\Controllers\Auth\VerificationController@verify')
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', 'App\Http\Controllers\Auth\VerificationController@send')
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

// Dashboard route requires authentication and email verification
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/admin', function () {
        return view('dashboard');
    })->name('dashboard');
});


// Route::group(['prefix' => 'admin'], function () {
//     Voyager::routes();
// });

// Define las rutas de Voyager con middleware
Route::group(['prefix' => 'admin'], function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Voyager::routes();
    });
});

// Custom routes for Ajax requests
Route::get('/get-municipios/{departamento}', 'TCG\Voyager\Http\Controllers\AjaxController@obtener_municipios');
// Route::get('/get-club/{liga}', 'TCG\Voyager\Http\Controllers\AjaxController@obtener_club');
// Route::get('/get-modalidades/{tipo_arma}', 'TCG\Voyager\Http\Controllers\AjaxController@obtener_modalidades');
// Route::get('/get-modalidades-by-evento/{codigo_evento}', 'TCG\Voyager\Http\Controllers\AjaxController@getModalidadesByEvento');
// Route::post('/get-valor-inscripcion', [InscripcionController::class, 'getValorInscripcion']);
// Route::get('inscripciones/{id}/detalle', [App\Http\Controllers\Voyager\InscripcionController::class, 'detalle'])->name('inscripciones.detalle');


// Email verification routes
Route::get('/email/verify', [EmailVerificationController::class, 'showVerifyForm'])
    ->middleware('auth')
    ->name('verification.notice');

Route::post('/email/verify', [EmailVerificationController::class, 'verify'])
    ->middleware('auth')
    ->name('verification.verify');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/send-message', [ContactController::class, 'send'])->name('contact.send');
