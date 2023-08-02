<?php

namespace App\Http\Livewire\Config;

use App\Models\configSalida;
use App\Models\configSocio;
use Livewire\Component;

class ConfigMonto extends Component
{   
    public $salidas=[];
    public $socios=[];
    public $monto;
    public $modelo;
    public $datos;
    protected  $listeners = ['editar'];
    public function render()
    {   
        $this->socios = configSocio::select('id','nombre','tipo_socio','monto')->get();
        $this->salidas = configSalida::select('id','nombre','monto')->get();
        return view('livewire.config.config-monto');
    }

    public function editar($modelo , $dato){
        $modelo == 'SAL' ? $this->modelo = $modelo : $this->modelo = $dato['nombre'];
        $this->monto = $dato['monto'];
        $this->datos = $dato;
    }

    public function alexlo(){
        if ($this->modelo == 'SAL') {
           configSalida::find($this->datos['id'])->update(['monto'=>$this->monto]);
           $this->dispatchBrowserEvent('toastr',['message'=>'Registro actualizado.']);
        }else{
            configSocio::find($this->datos['id'])->update(['monto'=>$this->monto]);
            $this->dispatchBrowserEvent('toastr',['message'=>'Registro actualizado.']);
        }
    }
}
