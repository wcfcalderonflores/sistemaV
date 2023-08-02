<?php

namespace App\Http\Controllers\compra;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Compra;

class CompraController extends Controller
{
    public function index(){
        return view('compra.index');
    }
    public function edit($id)
    {
        return view('compra.edit', compact('id'));
    }
    public function proceso()
    {   
        $compras = DB::table('compras as c')
                    ->join('personas','c.proveedor_id','=','personas.id')
                    ->join('users','c.user_id','=','users.id')
                    ->join('comprobantes as co','c.comprobante_id','=','co.id')
                    ->select('c.id','co.nombre as comprobante','c.numero_comprobante','personas.nombre','personas.apellido_paterno','personas.apellido_materno','c.fecha_compra','users.name')
                    ->where('c.estado','=','2')
                    ->get();
        return view('compra.proceso', compact('compras'));
    }
    public function destroy($id) // si se esta usando
    {   
        Compra::destroy($id);
        return redirect()->route('compra.proceso');
    }
    public function reporte(){
        return view('compra.reporte');
    }
}
