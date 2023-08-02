<?php

namespace App\Http\Livewire\Comprobante;

use App\Models\Comprobante;
use App\Models\ComprobanteConfig;
use Livewire\Component;

class ConfigComprobante extends Component
{   

    public $comprobante;
    protected $listeners = ['configComprobante-dataComprobante'=>'dataComprobante',
                            'comprobante.config-comprobante' =>'$refresh'];
    public function render()
    {   
        $comprobanteConfigs = null;
        if(isset($this->comprobante->id)){
            $comprobanteConfigs = ComprobanteConfig::where('comprobante_id','=',$this->comprobante->id)->get();
            //dd($comprobanteConfigs);
        }
            
        //dd($comprobanteConfigs);
        return view('livewire.comprobante.config-comprobante', compact('comprobanteConfigs'));
    }

    public function dataComprobante(Comprobante $comprobante){
        $this->comprobante = $comprobante;
        //dd($this->comprobante->id);

    }
    public function editar(ComprobanteConfig $config){
        $this->emit('config-comprobante-data',$config);
        $this->emit('abrirModalConfig','update',$this->comprobante->id);
    }

    public function eliminar(ComprobanteConfig $config){
        $config->delete();
        $this->dispatchBrowserEvent('hide-form-config', ['message'=>'Configuración eliminada!!!']);

    }

    public function activarDesactivar(ComprobanteConfig $config, $estado){
        $config->update(['estado' => $estado == '0' ? '1': '0']);
        $this->dispatchBrowserEvent('hide-form-config', ['message'=>$estado == '1' ? 'Se desactivo con éxito!!' : 'Se activo con éxito!!']);
    }
}
