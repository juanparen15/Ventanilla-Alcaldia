<?php

use App\Http\Controllers\Voyager\InscripcionController;
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

// Rutas para la verificación de correo electrónico
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', 'App\Http\Controllers\Auth\VerificationController@verify')
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', 'App\Http\Controllers\Auth\VerificationController@send')
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

// Ruta para el panel de administración solo si el usuario está autenticado y verificado
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    // Ruta al panel de administración
    Route::get('/admin', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Rutas de Voyager
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified']], function () {
    Voyager::routes();
});

Route::get('/get-municipios/{departamento}', 'TCG\Voyager\Http\Controllers\AjaxController@obtener_municipios');
Route::get('/get-club/{liga}', 'TCG\Voyager\Http\Controllers\AjaxController@obtener_club');
Route::get('/get-modalidades/{tipo_arma}', 'TCG\Voyager\Http\Controllers\AjaxController@obtener_modalidades');
Route::get('/get-modalidades-by-evento/{codigo_evento}', 'TCG\Voyager\Http\Controllers\AjaxController@getModalidadesByEvento');
// Route::post('/obtenerValorModalidades', [InscripcionController::class, 'obtenerValorModalidades'])->name('obtenerValorModalidades');
Route::post('/get-valor-inscripcion', [InscripcionController::class, 'getValorInscripcion']);
