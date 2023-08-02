<?php

namespace App\Http\Livewire\Movimiento;

use App\Models\Movimiento;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Margen extends Component
{   
    public $desde;
    public $hasta;
    public $movimientos = [];

    protected  $listeners = ['margenMovimiento'=>'listarMargen'];
    public function render()
    {   
        $this->movimientos = Movimiento::where('estado','=','1')
                            ->whereBetween(DB::raw('date(created_at)'),[$this->desde,$this->hasta])
                            ->selectRaw("SUM(CASE WHEN tipo_movimiento = 'I' THEN monto ELSE 0 END) AS ingreso, ".
                                "SUM(CASE WHEN tipo_movimiento = 'E' THEN monto ELSE 0 END) AS egreso")
                            ->get();
        return view('livewire.movimiento.margen');
    }

    public function listarMargen($desde, $hasta){
        $this->desde = $desde;
        $this->hasta = $hasta;
    }
}
