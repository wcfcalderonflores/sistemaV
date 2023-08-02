<?php

namespace App\Http\Controllers\venta;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {   
        //$campania = Campania::where('estado',"=","1")->get();
        return view('venta.index');
    }
    public function show(Venta $venta) // si se esta usando
    {   
        return view('venta.show', compact('venta'));
    }
    public function destroy($id) // si se esta usando
    {   
        Venta::destroy($id);
        return redirect()->route('venta.proceso');
    }
    public function view(Venta $venta)
    {   
        return view('venta.viewComprobante',compact('venta'));
    }
    public function proceso()
    {   
        $ventas = DB::table('ventas as v')
                    ->join('personas','v.cliente_id','=','personas.id')
                    ->join('users','v.user_id','=','users.id')
                    ->join('comprobante_configs','v.comprobante_config_id','=','comprobante_configs.id')
                    ->select('v.id','comprobante_configs.serie','v.numero_comprobante','personas.nombre','personas.apellido_paterno','personas.apellido_materno','v.created_at','users.name')
                    ->where('v.estado','=','2')
                    ->get();
        return view('venta.proceso', compact('ventas'));
    }
    public function edit($id)
    {
        return view('venta.edit', compact('id'));
    }
    public function reporte(){
        return view('venta.reporte');
    }
}
