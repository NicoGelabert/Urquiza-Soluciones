<?php

use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PaginaContenidoController;
use App\Http\Controllers\PaginaLegalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\ContactoController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\LegalController as PublicLegalController;
use App\Http\Controllers\Public\PresupuestoController;
use App\Http\Controllers\Public\ServicioController as PublicServicioController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\Api\ConfiguracionController as ApiConfiguracionController;
use App\Http\Controllers\Api\FaqController as ApiFaqController;
use App\Http\Controllers\Api\PaginaContenidoController as ApiPaginaContenidoController;
use App\Http\Controllers\Api\PaginaLegalController as ApiPaginaLegalController;
use App\Http\Controllers\Api\ServicioController as ApiServicioController;
use App\Http\Controllers\Api\SolicitudController as ApiSolicitudController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/servicios', [PublicServicioController::class, 'index'])->name('servicios.index');
Route::get('/servicios/{slug}', [PublicServicioController::class, 'show'])->name('servicios.show');
Route::get('/contacto', [ContactoController::class, 'index'])->name('contacto.index');
Route::post('/contacto', [ContactoController::class, 'store'])->middleware('throttle:5,1')->name('contacto.store');
Route::get('/presupuesto', [PresupuestoController::class, 'index'])->name('presupuesto.index');
Route::post('/presupuesto', [PresupuestoController::class, 'store'])->middleware('throttle:5,1')->name('presupuesto.store');
Route::get('/legal/{slug}', [PublicLegalController::class, 'show'])->name('legal.show');

Route::prefix('en')->group(function () {
    Route::get('/', HomeController::class)->name('en.home');
    Route::get('/services', [PublicServicioController::class, 'index'])->name('en.servicios.index');
    Route::get('/services/{slug}', [PublicServicioController::class, 'show'])->name('en.servicios.show');
    Route::get('/contact', [ContactoController::class, 'index'])->name('en.contacto.index');
    Route::post('/contact', [ContactoController::class, 'store'])->middleware('throttle:5,1')->name('en.contacto.store');
    Route::get('/quote', [PresupuestoController::class, 'index'])->name('en.presupuesto.index');
    Route::post('/quote', [PresupuestoController::class, 'store'])->middleware('throttle:5,1')->name('en.presupuesto.store');
    Route::get('/legal/{slug}', [PublicLegalController::class, 'show'])->name('en.legal.show');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('servicios', ServicioController::class)->except(['show', 'store', 'update', 'destroy']);
    Route::resource('faqs', FaqController::class)->except(['show', 'store', 'update', 'destroy']);
    Route::resource('contenido', PaginaContenidoController::class)->only(['index', 'edit']);
    Route::resource('legal', PaginaLegalController::class)->only(['index', 'edit']);
    Route::get('solicitudes', [SolicitudController::class, 'index'])->name('solicitudes.index');
    Route::get('solicitudes/{solicitud}', [SolicitudController::class, 'show'])->name('solicitudes.show');
    Route::get('configuracion', [ConfiguracionController::class, 'edit'])->name('configuracion.edit');
});

Route::middleware('auth')->prefix('api')->group(function () {
    Route::get('servicios', [ApiServicioController::class, 'index']);
    Route::post('servicios', [ApiServicioController::class, 'store']);
    Route::get('servicios/{servicio}', [ApiServicioController::class, 'show']);
    Route::match(['put', 'post'], 'servicios/{servicio}', [ApiServicioController::class, 'update']);
    Route::delete('servicios/{servicio}', [ApiServicioController::class, 'destroy']);

    Route::get('faqs', [ApiFaqController::class, 'index']);
    Route::post('faqs', [ApiFaqController::class, 'store']);
    Route::get('faqs/{faq}', [ApiFaqController::class, 'show']);
    Route::put('faqs/{faq}', [ApiFaqController::class, 'update']);
    Route::delete('faqs/{faq}', [ApiFaqController::class, 'destroy']);

    Route::get('contenido', [ApiPaginaContenidoController::class, 'index']);
    Route::get('contenido/{contenido}', [ApiPaginaContenidoController::class, 'show']);
    Route::put('contenido/{contenido}', [ApiPaginaContenidoController::class, 'update']);

    Route::get('legal', [ApiPaginaLegalController::class, 'index']);
    Route::get('legal/{legal}', [ApiPaginaLegalController::class, 'show']);
    Route::put('legal/{legal}', [ApiPaginaLegalController::class, 'update']);

    Route::get('solicitudes', [ApiSolicitudController::class, 'index']);
    Route::get('solicitudes/{solicitud}', [ApiSolicitudController::class, 'show']);
    Route::put('solicitudes/{solicitud}', [ApiSolicitudController::class, 'update']);

    Route::get('configuracion', [ApiConfiguracionController::class, 'show']);
    Route::put('configuracion', [ApiConfiguracionController::class, 'update']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
