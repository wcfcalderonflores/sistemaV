<?php

namespace App\Http\Controllers\stock;

use App\Http\Controllers\Controller;
use App\Models\AjusteStock;
use Illuminate\Support\Facades\DB;

class AjusteStockController extends Controller
{
    public function index(){
        return view('ajusteStock.index');
    }

    public function edit($id)
    {
        return view('ajusteStock.edit', compact('id'));
    }

    public function proceso()
    {   
        $ajustes = DB::table('ajuste_stocks as st')
                    ->join('detalle_ajuste_stocks as das','st.id','=','das.ajuste_stock_id')
                    ->select('st.id','st.tipo_ajuste','st.referencia','st.created_at as fecha', DB::raw("sum(das.cantidad * das.cantidad_unidad) as cantidad_unidades, sum(cantidad_recuperada) as cantidad_recuperada"))
                    ->where('st.estado','=','2')
                    ->groupBy('st.id','st.tipo_ajuste','st.referencia','fecha')
                    ->get();
        return view('ajusteStock.proceso', compact('ajustes'));
    }

    public function destroy($id) // si se esta usando
    {   
        AjusteStock::destroy($id);
        return redirect()->route('ajuste.proceso');
    }

    public function reporte(){
        return view('ajusteStock.reporte');
    }
}
