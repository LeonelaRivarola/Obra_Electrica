<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\Tecnica\ObrasElectricas\EmailController;
use App\Http\Controllers\Tecnica\ObrasElectricas\SolicitudController;
use App\Http\Controllers\Tecnica\ObrasElectricas\ObservacionController;
use App\Http\Controllers\Tecnica\ObrasElectricas\PresupuestoController;
use App\Http\Controllers\Tecnica\ObrasElectricas\TipoObraController;

Route::middleware(['web'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->middleware('auth')->name('index');
    Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
    Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');
    Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('login');
    Route::post('sign-in', [SessionsController::class, 'store'])->middleware('guest');
    Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
    Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');
    Route::post('tecnica/obrasElectricas/solicitudes/path', [SolicitudController::class, 'path'])->name('path');

    Route::group(['middleware' => 'auth'], function () {
        // Solicitudes
        Route::get('tecnica/obrasElectricas/solicitudes', [SolicitudController::class, 'index'])->name('solicitudes');
        Route::get('tecnica/obrasElectricas/solicitudes/crear', [SolicitudController::class, 'create'])->name('nueva-solicitud');
        Route::post('tecnica/obrasElectricas/solicitudes/guardar', [SolicitudController::class, 'store'])->name('crear-solicitud');
        Route::get('tecnica/obrasElectricas/solicitudes/mostrar/{solicitud}', [SolicitudController::class, 'show'])->name('mostrar-solicitud');
        Route::get('tecnica/obrasElectricas/solicitudes/editar/{solicitud}', [SolicitudController::class, 'edit'])->name('editar-solicitud');
        Route::get('tecnica/obrasElectricas/solicitudes/acreditar/{solicitud}', [SolicitudController::class, 'accredit'])->name('acreditar-solicitud');
        Route::put('tecnica/obrasElectricas/solicitudes/actualizar/{solicitud}', [SolicitudController::class, 'update'])->name('actualizar-solicitud');
        Route::delete('tecnica/obrasElectricas/solicitudes/eliminar/{solicitud}', [SolicitudController::class, 'destroy'])->name('eliminar-solicitud');
        Route::get('tecnica/obrasElectricas/solicitudes/documento/{solicitud}', [SolicitudController::class, 'abrirSolicitud'])->name('abrir-solicitud');
        Route::put('tecnica/obrasElectricas/solicitudes/cancelar/{solicitud}', [SolicitudController::class, 'cancelar'])->name('cancelar-solicitud');
        Route::put('tecnica/obrasElectricas/solicitudes/finalizar/{solicitud}', [SolicitudController::class, 'finalizar'])->name('finalizar-solicitud');
        // Presupuestos
        Route::get('tecnica/obrasElectricas/presupuestos', [PresupuestoController::class, 'index'])->name('presupuestos');
        Route::get('tecnica/obrasElectricas/presupuestos/crear/{solicitud}', [PresupuestoController::class, 'create'])->name('presupuestar-solicitud');
        Route::post('tecnica/obrasElectricas/presupuestos/guardar', [PresupuestoController::class, 'store'])->name('crear-presupuesto');
        Route::get('tecnica/obrasElectricas/presupuestos/mostrar/{presupuesto}', [PresupuestoController::class, 'show'])->name('mostrar-presupuesto');
        Route::get('tecnica/obrasElectricas/presupuestos/documento/{solicitud}', [PresupuestoController::class, 'abrirPresupuesto'])->name('abrir-presupuesto');
        Route::post('tecnica/obrasElectricas/presupuestos/actualizar/{solicitud}', [PresupuestoController::class, 'update'])->name('procesar-presupuesto');
        Route::post('tecnica/obrasElectricas/solicitud/notificar-email/{solicitud}', [PresupuestoController::class, 'notificarEmail'])->name('notificar-presupuesto');
        // Observaciones
        Route::get('tecnica/ObrasElectricas/observaciones/crear/{solicitud}', [ObservacionController::class, 'create'])->name('observar-solicitud');
        Route::post('tecnica/ObrasElectricas/observaciones/guardar', [ObservacionController::class, 'store'])->name('crear-observacion');
        // E-mail de Solicitudes
        Route::get('tecnica/obrasElectricas/emails', [EmailController::class, 'index'])->name('emails');
        Route::get('tecnica/obrasElectricas/emails/mostrar/{email}', [EmailController::class, 'show'])->name('mostrar-email');
        // Tipo de Obra
        Route::get('tecnica/obrasElectricas/tiposDeObras', [TipoObraController::class, 'index'])->name('tipos-obras');
        Route::get('tecnica/obrasElectricas/tiposDeObras/editar/{tipoObra}', [TipoObraController::class, 'edit'])->name('editar-tipoObra');
        Route::put('tecnica/obrasElectricas/tiposDeObras/actualizar/{tipoObra}', [TipoObraController::class, 'update'])->name('actualizar-tipoObra');
        Route::get('tecnica/obrasElectricas/tiposDeObras/crear', [TipoObraController::class, 'create'])->name('crear-tipoObra');
        Route::post('tecnica/obrasElectricas/tiposDeObras/guardar', [TipoObraController::class, 'store'])->name('guardar-tipoObra');
        Route::delete('tecnica/obrasElectricas/tiposDeObras/{tipoObra}', [TipoObraController::class, 'destroy'])->name('eliminar-tipoObra');
    });
});
