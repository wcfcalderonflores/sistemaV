<?php

namespace App\Http\Controllers\registros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(){
        return view('registros.producto.index');
    }
}
