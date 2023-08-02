<?php

namespace App\Http\Livewire\Modals;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MostrarAjuste extends Component
{   
    public $compra_id;
    public $detalle = [];
    public $compra = [];
    public $igv;
    public $igv_porcentaje;
    public $referencia;

    protected $listeners = ['modals.mostrar-ajuste'=>'listarDetalleAjuste'];
    public function render()
    {
        return view('livewire.modals.mostrar-ajuste');
    }

    public function listarDetalleAjuste($id, $referencia){
        $this->referencia = $referencia;
        //dd('alexlo');
        $this->detalle = DB::table('detalle_ajuste_stocks as das')
                    ->join('productos as p', 'das.producto_id','=','p.id')
                    ->join('producto_unidads as pu','das.producto_unidad_id','=','pu.id')
                    ->join('unidad_medidas as um','pu.unidad_medida_id','=','um.id')
                    ->select('das.id','p.nombre','um.nombre as unidad_medida','um.abreviatura','das.cantidad','das.cantidad_unidad','das.precio_compra','das.cantidad_recuperada')
                    ->where('das.ajuste_stock_id','=',$id)
                    ->get();
        //dd($qry);
    }

}
