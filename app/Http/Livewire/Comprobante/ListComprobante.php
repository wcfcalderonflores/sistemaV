<?php

namespace App\Http\Livewire\Comprobante;

use App\Models\Comprobante;
use Livewire\Component;

class ListComprobante extends Component
{   
    public $mostrarConfig = false;
    public $idComprobante;
    protected $listeners = ['listComprobante' => '$refresh'];
    public function render()
    {   
        $comprobantes = Comprobante::all();
        return view('livewire.comprobante.list-comprobante',compact('comprobantes'));
    }
    public function editar($id){
        $this->mostrarConfig = false;
        $comprobante = Comprobante::find($id);
        $this->emit('registro-comprobante-data',$comprobante);
        $this->emit('abrirModal','update');
    }
    public function eliminar($id){
        $this->mostrarConfig = false;
        try {
            Comprobante::find($id)->delete();
            $this->dispatchBrowserEvent('hide-form', ['message'=>'Comprobante eliminado!!!']);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('toastr-error', ['message'=>'Comprobante tiene dependencia!!']);
        }
       
    }

    public function activarDesactivar($id,$estado){
        Comprobante::find($id)->update(["estado"=>$estado=='1' ? '0' : '1']);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Se cambió de estado!!!']);
    }

    public function comprobanteConfig($comprobante){
        $this->mostrarConfig = true;
        $this->emit('configComprobante-dataComprobante',$comprobante);
    }
}
