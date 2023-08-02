<?php

namespace App\Http\Livewire\Admin;

use App\Models\Caja;
use Livewire\Component;

class CrearCaja extends Component
{   
    protected $listeners = ['listCaja' => '$refresh'];
    public function render()
    {   
        $cajas = Caja::all();
        return view('livewire.admin.crear-caja', compact('cajas'));
    }
    public function editar($id){
        $comprobante = Caja::find($id);
        $this->emit('registro-caja-data',$comprobante);
        $this->emit('abrirModal','update');
    }
    public function eliminar($id){
        try {
            Caja::find($id)->delete();
            $this->dispatchBrowserEvent('hide-form', ['message'=>'Caja eliminada!!!']);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('toastr-error', ['message'=>'Caja tiene dependencia!!']);
        }
       
    }

    public function activarDesactivar($id,$estado){
        Caja::find($id)->update(["estado"=>$estado=='1' ? '0' : '1']);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Se cambió de estado!!!']);
    }
}
