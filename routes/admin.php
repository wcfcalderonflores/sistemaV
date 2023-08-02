<?php
use App\Http\Controllers\caja\CajaController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\user\UserController;

//Route::resource('users', [UserController::class])->names('admin.users');
Route::get('user', [UserController::class,'index'])->name('admin.users')->middleware('role:Admin');
Route::delete('user/{user}', [UserController::class,'destroy'])->name('admin.users.destroy');
Route::get('user/create', [UserController::class,'create'])->middleware('role:Admin')->name('admin.users.create');
Route::post('user/store', [UserController::class,'store'])->name('admin.users.store');
Route::get('user/{user}/edit', [UserController::class,'edit'])->middleware('role:Admin')->name('admin.users.edit');
Route::put('user/{user}', [UserController::class,'update'])->name('admin.users.update');
Route::get('user/{user}', [UserController::class,'show'])->name('admin.users.show');

Route::get('caja-recibir', [CajaController::class,'recibir'])->name('admin.caja.recibir');
Route::get('caja-crear', [CajaController::class,'crear'])->name('admin.caja.crear');

