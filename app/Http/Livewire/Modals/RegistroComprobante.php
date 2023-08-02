<?php

namespace App\Http\Livewire\Modals;

use App\Models\Comprobante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class RegistroComprobante extends Component
{   
    public $tipo;
    public $cabecera;
    public $data;
    
    protected $listeners = [
        'registro-comprobante-tipo'=>'tipo',
        'registro-comprobante-data'=>'data',];
    public function render()
    {
        return view('livewire.modals.registro-comprobante');
    }
    /*public function mount(){
        $this->tipo = "create";
        $this->data = ['nombre'=>'','abreviatura'=>''];
    }*/

    public function registrar(){
        if(isset($this->data['nombre']))
            $this->data['nombre'] = strtoupper($this->data['nombre']);
        Validator::make($this->data,[
            'nombre' => 'required|unique:comprobantes',
            'abreviatura' => 'required'
        ])->validate();
        Comprobante::create($this->data);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Comprobante creado.']);
        $this->emit("listComprobante");
        
    }
    public function editar(){
        $this->data['nombre'] = strtoupper($this->data['nombre']);
        Validator::make($this->data,[
            'nombre' => 'required|unique:comprobantes,nombre,'.$this->data['id'],
            'abreviatura' => 'required'
        ])->validate();
            
        Comprobante::find($this->data['id'])->update($this->data);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Comprobante actualizado!!!']);
        $this->emit('listComprobante');

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
