<?php

namespace App\Http\Controllers\caja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CajaController extends Controller
{
    public function index()
    {   
        return redirect()->route('caja.apertura');
    }

    public function apertura()
    {   
        return view('caja.apertura');
    }

    public function cierre(){
        return view('caja.cierre');
    }

    public function recibir(){ // pertenece al administrador
        return view('admin.caja.recibir');
    }
    public function crear(){ // pertenece al administrador
        return view('admin.caja.crear');
    }
}
