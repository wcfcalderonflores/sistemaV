<?php

namespace App\Http\Livewire\Venta;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MargenGanancia extends Component
{   
    public $desde;
    public $hasta;
    public $ventas;

    protected  $listeners = ['margenVenta'=>'listarMargen'];
    public function render()
    {   
        $this->ventas = DB::table('ventas as v')
                                ->join('venta_detalles as vd', 'vd.venta_id','=','v.id')
                                ->select( DB::raw('sum(ROUND(vd.cantidad * vd.precio - coalesce(vd.descuento,0),2)) as total_precio_venta, sum(ROUND(vd.cantidad * vd.precio_compra - coalesce(vd.descuento,0),2)) as total_precio_compra'))
                                ->whereBetween(DB::raw('date(v.fecha)'),[$this->desde,$this->hasta])
                                ->get();
        
        return view('livewire.venta.margen-ganancia');
    }

    public function listarMargen($desde, $hasta){
        $this->desde = $desde;
        $this->hasta = $hasta;
    }
}
