<?php

namespace App\Http\Controllers\reporte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movimiento;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function general(){
        $ventas = DB::table('ventas as v')
                    ->join('venta_detalles as vd', 'vd.venta_id','=','v.id')
                    ->selectRaw("SUM(ROUND(vd.cantidad * vd.precio - vd.descuento,2)) AS total")
                    ->where('v.estado','=','1')
                    //->groupBy('v.id','p.nombre','p.apellido_paterno','p.apellido_materno','v.fecha')
                    ->get();
        //ddd($ventas);


        $movimientos = Movimiento::where('estado','=','1')
                                    ->selectRaw("SUM(CASE WHEN tipo_movimiento = 'I' THEN monto ELSE 0 END) AS pago, ".
                                    "SUM(CASE WHEN tipo_movimiento = 'E' THEN monto ELSE 0 END) AS debe")
                                    ->get();
        
        return view('admin.reporte.general',compact('ventas','movimientos'));
    }

    public function reporteCaja(){
        return view('admin.reporte.caja');
    }

    public function reporteMargenGanacia(){
        return view('admin.reporte.margen-ganancia');
    }
}
