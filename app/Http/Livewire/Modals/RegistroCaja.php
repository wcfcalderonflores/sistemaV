<?php

namespace App\Http\Livewire\Modals;

use App\Models\Caja;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class RegistroCaja extends Component
{   
    public $tipo;
    public $data;
    protected $listeners = [
        'registro-caja-tipo'=>'tipo',
        'registro-caja-data'=>'data',];
    public function render()
    {
        return view('livewire.modals.registro-caja');
    }

    public function registrar(){
        if(isset($this->data['nombre']))
            $this->data['nombre'] = strtoupper($this->data['nombre']);
        Validator::make($this->data,[
            'nombre' => 'required|unique:cajas',
        ])->validate();
        Caja::create($this->data);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Caja creada.']);
        $this->emit("listCaja");
        
    }
    public function editar(){
        $this->data['nombre'] = strtoupper($this->data['nombre']);
        Validator::make($this->data,[
            'nombre' => 'required|unique:cajas,nombre,'.$this->data['id'],
        ])->validate();
            
        Caja::find($this->data['id'])->update($this->data);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Caja actualizada!!!']);
        $this->emit('listCaja');

    }
   
    public function data($data){
        $this->data = $data;

    }
    public function tipo($dato){
        $this->tipo = $dato;
        if($this->tipo == 'create'){
            $this->data = [];
        }
    }
}
