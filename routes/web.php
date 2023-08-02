<?php

use App\Http\Controllers\stock\AjusteStockController;
use App\Http\Controllers\caja\CajaController;
use App\Http\Controllers\compra\CompraController;
use App\Http\Controllers\comprobante\ComprobanteController;
use App\Http\Controllers\movimiento\MovimientoController;
use App\Http\Controllers\registros\ClienteController;
use App\Http\Controllers\registros\ProductoController;
use App\Http\Controllers\registros\ProveedorController;
use App\Http\Controllers\reporte\ReporteController;
use App\Http\Controllers\user\RoleController;
use App\Http\Controllers\venta\VentaController;
use Illuminate\Routing\Route as RoutingRoute;
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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('', [CajaController::class, 'index'])->name('index');

Route::resource('roles', RoleController::class)->names('admin.roles');



/* ventas*/
Route::get('venta', [VentaController::class,'index'])->name('venta');
Route::get('venta/{venta}', [VentaController::class,'show'])->name('venta.show');
Route::get('venta/comprobante/{venta}', [VentaController::class,'view'])->name('venta.comprobante');
Route::get('venta-proceso', [VentaController::class,'proceso'])->name('venta.proceso');
Route::get('ventas/{id}', [VentaController::class,'edit'])->name('venta.edit');
Route::delete('venta/{id}', [VentaController::class,'destroy'])->name('venta.destroy');
Route::get('venta-reporte', [VentaController::class,'reporte'])->name('venta.reporte');

/* compras*/
Route::get('compra', [CompraController::class,'index'])->name('compra');
//Route::get('venta/{venta}', [VentaController::class,'show'])->name('venta.show');
//Route::get('venta/comprobante/{venta}', [VentaController::class,'view'])->name('venta.comprobante');
Route::get('compra-proceso', [CompraController::class,'proceso'])->name('compra.proceso');
Route::get('compras/{id}', [CompraController::class,'edit'])->name('compra.edit');
Route::delete('compra/{id}', [CompraController::class,'destroy'])->name('compra.destroy');
Route::get('compra-reporte', [CompraController::class,'reporte'])->name('compra.reporte');

/*registros*/
Route::resource('cliente', ClienteController::class)->names('cliente');
Route::get('producto', [ProductoController::class,'index'])->name('producto.index');
Route::get('proveedor', [ProveedorController::class,'index'])->name('proveedor.index');


/* caja*/
Route::get('caja-apertura', [CajaController::class,'apertura'])->name('caja.apertura');
Route::get('caja-cerrar', [CajaController::class,'cierre'])->name('caja.cerrar');

/* movimientos*/
Route::get('movimiento', [MovimientoController::class,'index'])->name('movimiento.index');
Route::get('reporte-movimiento', [MovimientoController::class,'reporte'])->name('movimiento.reporte');

/* ajuste stock*/
Route::get('ajuste-stock', [AjusteStockController::class,'index'])->name('ajuste.index');
Route::get('reporte-ajuste', [AjusteStockController::class,'reporte'])->name('ajuste.reporte');
Route::get('ajuste-proceso', [AjusteStockController::class,'proceso'])->name('ajuste.proceso');
Route::get('ajuste-stock/{id}', [AjusteStockController::class,'edit'])->name('ajuste.index.edit');
Route::delete('ajuste/{id}', [AjusteStockController::class,'destroy'])->name('ajuste.destroy');

/* COMPROBANTE */
Route::get('comprobante',[ComprobanteController::class,'index'])->name('comprobante.index');


/* reportes*/
Route::get('reporte-general', [ReporteController::class,'general'])->middleware('role:Admin')->name('reporte.general');
Route::get('reporte-caja', [ReporteController::class,'reporteCaja'])->middleware('role:Admin') ->name('reporte.caja');
Route::get('reporte-margen-ganancia', [ReporteController::class,'reporteMargenGanacia'])->middleware('role:Admin') ->name('reporte.margen-ganancia');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
