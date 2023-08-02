<?php

namespace App\Http\Controllers\registros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        return view('registros.proveedor.index');
    }
}
