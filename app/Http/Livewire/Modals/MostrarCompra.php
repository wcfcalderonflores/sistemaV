<?php

namespace App\Http\Livewire\Modals;

use App\Models\Compra;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MostrarCompra extends Component
{   
    public $compra_id;
    public $detalle = [];
    public $compra = [];
    public $igv;
    public $igv_porcentaje;
    public $numero_comprobante;
    protected $listeners = ['modals.mostrar-compra'=>'mostrarCompra'];
    public function render()
    {
        return view('livewire.modals.mostrar-compra');
    }

    public function mostrarCompra($id,$estado_igv,$porcentaje_igv,$numero_comprobante){
        //dd($id);
        $this->numero_comprobante = $numero_comprobante;
        $this->igv = $estado_igv;
        $this->igv_porcentaje = $porcentaje_igv;
        //$this->compra = Compra::find($id);
        $this->detalle = DB::table('compra_detalles as cd')
                                ->join('producto_unidads as pu','cd.producto_unidad_id','=','pu.id')
                                ->join('unidad_medidas as um','pu.unidad_medida_id','=','um.id')
                                ->join('productos as p','cd.producto_id','=','p.id')
                                ->select('p.nombre','cd.precio','um.nombre as unidad_medida','cd.cantidad','cd.descuento','cd.id')
                                ->where('cd.compra_id','=',$id)
                                ->get();
    }
}
