<?php

namespace App\Http\Livewire\Compra;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Margen extends Component
{   
    public $desde;
    public $hasta;
    public $compras = [];

    protected  $listeners = ['margenCompra'=>'listarMargen'];
    public function render()
    {   
        $this->compras = DB::table('compras as c')
                                ->join('compra_detalles as cd', 'cd.compra_id','=','c.id')
                                ->select('c.forma_pago', DB::raw('sum(ROUND(cd.cantidad * cd.precio,2)) as total'))
                                ->whereBetween(DB::raw('date(c.fecha_compra)'),[$this->desde,$this->hasta])
                                ->where('estado','=','1')
                                ->groupBy('c.forma_pago')
                                ->get();
        return view('livewire.compra.margen');
    }

    public function listarMargen($desde, $hasta){
        $this->desde = $desde;
        $this->hasta = $hasta;
    }
}
