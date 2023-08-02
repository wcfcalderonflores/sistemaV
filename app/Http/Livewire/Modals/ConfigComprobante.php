<?php

namespace App\Http\Livewire\Modals;

use App\Models\ComprobanteConfig;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ConfigComprobante extends Component
{   
    public $tipo;
    public $data;
    public $idComprobante;
    protected $listeners = [
        'config-comprobante-tipo'=>'tipo',
        'config-comprobante-data'=>'data',];
    public function render()
    {
        return view('livewire.modals.config-comprobante');
    }
    public function tipo($dato,$id){
        $this->idComprobante = $id;
        $this->tipo = $dato;
        if($this->tipo == 'create'){
            $this->data = [];
        }
    }
    public function data($data){
        $this->data = $data;

    }

    public function registrar(){
        $this->data['serie'] = strtoupper($this->data['serie']);
        $config = Validator::make($this->data,[
            'serie' => 'required|unique:comprobante_configs',
            'contador' => 'required',
            'numero_maximo' => 'required',
            'valor_igv' => 'required'
        ])->validate();
        $config['comprobante_id'] = $this->idComprobante;
        
        ComprobanteConfig::create($config);
        $this->emit('comprobante.config-comprobante');
        $this->dispatchBrowserEvent('hide-form-config', ['message'=>'Configuración registrada!!!']);
    }
    public function editar(){
        $this->data['serie'] = strtoupper($this->data['serie']);
        $config = Validator::make($this->data,[
            'serie' => 'required|unique:comprobante_configs,serie,'.$this->data['id'],
            'contador' => 'required',
            'numero_maximo' => 'required',
            'valor_igv' => 'required'
        ])->validate();
            
        ComprobanteConfig::find($this->data['id'])->update($this->data);
        $this->dispatchBrowserEvent('hide-form-config', ['message'=>'Comprobante actualizado!!!']);
        $this->emit('comprobante.config-comprobante');

    }

    
}
