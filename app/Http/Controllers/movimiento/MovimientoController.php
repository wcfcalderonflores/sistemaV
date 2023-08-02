<?php

namespace App\Http\Controllers\movimiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    public function index(){
        return view('movimiento.index');
    }

    public function reporte(){
        return view('movimiento.reporte');
    }
}
