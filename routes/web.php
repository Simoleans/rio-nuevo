<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CampoController;
use App\Http\Controllers\FaenaController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\VariedadController;
use App\Http\Controllers\ProductorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\TemporadaController;
use App\Http\Controllers\TipoCultivoController;

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
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('loginView');

Route::middleware(['auth:sanctum','user-inactive'])->group(function () {
    Route::resource('/reporte',ReporteController::class);
    Route::get('/reporte/excel/export',[ReporteController::class,'excelExport'])->name('excelExport');
    Route::put('/finalizarReporte/{reporte}',[ReporteController::class,'disabledReporte'])->name('disabledReporte');
    Route::put('/reporte/enable/{reporte}',[ReporteController::class,'enableReporte'])->name('reporte.enable');
    route::get('clone/reporte/{reporte}',[ReporteController::class,'cloneView'])->name('cloneView');
    Route::post('/reporte/clone',[ReporteController::class,'clone'])->name('reporte.clone');
});

Route::middleware(['auth:sanctum','user-inactive','admin'])->group(function () {
    Route::resource('/machine',MachineController::class);
    Route::put('/machine/enable/{machine}',[MachineController::class,'enable'])->name('machine.enable');
    Route::resource('/productors',ProductorController::class);
    Route::resource('/tipoCultivo',TipoCultivoController::class);
    Route::resource('/campo',CampoController::class);
    Route::resource('/variedad',VariedadController::class);
    Route::resource('/usuario',UserController::class);
    Route::resource('/faena',FaenaController::class);
    Route::put('/finalizarFaena/{faena}',[FaenaController::class,'disabledFaena'])->name('disabledFaena');
    Route::resource('/temporada',TemporadaController::class);
});

Route::middleware(['auth:sanctum', 'verified','user-inactive'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
