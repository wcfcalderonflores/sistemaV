<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class MargenGanancia extends Component
{   
    public $desde;
    public $hasta;
    public $estado_accion;
    public function render()
    {
        return view('livewire.admin.margen-ganancia');
    }

    public function listarMargen(){
        $this->validate([
            'desde' => 'required',
            'hasta' => 'required'
        ]);
        $this->estado_accion = true;
        $this->emit('margenVenta',$this->desde,$this->hasta);
        $this->emit('margenMovimiento',$this->desde,$this->hasta);
        $this->emit('margenCompra',$this->desde,$this->hasta);
    }
}
