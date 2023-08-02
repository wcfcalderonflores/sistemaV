<?php

namespace App\Http\Livewire\Registros;

use App\Models\Persona;
use App\Models\Proveedor;
use App\Models\Ubigeo;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ListProveedor extends Component
{   
    public $search;
    public $dataUbigeo=[];
    public $data= [];
    use WithPagination;
    protected $listeners = ['listProveedor' => '$refresh'];
    public function render()
    {   
        $proveedores = DB::table('proveedors as p')
                        ->join('personas','p.persona_id','=','personas.id')
                        ->leftJoin('ubigeos','personas.ubigeo_id','=','ubigeos.id')
                        ->select('personas.*','ubigeos.departamento','ubigeos.provincia','ubigeos.distrito')
                        ->where('nombre','LIKE','%'.$this->search.'%')
                        ->orWhere('numero_documento','LIKE','%'.$this->search.'%')
                        ->paginate(15);
        return view('livewire.registros.list-proveedor', compact('proveedores'));
    }

    public function agregarProveedor(){
        $this->emit('modals.registro-cliente-tipo','create');
        $this->emit('modals.registro-cliente-limpiar');
        $this->emit('modals.registro-cliente-clienteId');
        $this->emit('modals.registro-cliente-cabecera','Proveedor');
        $this->dispatchBrowserEvent('show-form');

    }

    public function tipoDocumento($tipo){

        switch ($tipo) {
            case '01':
                return 'DNI';
                break;
            case '02':
                return 'CARNET EXT';
                break;
            case '06':
                return 'RUC';
                break;
            case '07':
                return 'PASAPORTE';
                break;
            default:
            return 'SIN ASIGNAR';
                break;
        }

    }

    public function editarProveedor($id){
        $this->emit('modals.registro-cliente-cabecera','Proveedor');
        $this->dataUbigeo = [];
        $cliente = Persona::where('id','=',$id)->get();
        $this->cliente = $cliente; 
         
        foreach ($cliente as $alex) {
            $this->data = $alex->toArray();
        }   
        $ubigeo  = Ubigeo::where('id','=',$this->data['ubigeo_id'])->get();
        foreach ($ubigeo as $ubi) {
            $this->dataUbigeo = $ubi->toArray();
        }
        $this->emit('modals.registro-cliente-data',$this->data);
        $this->emit('modals.registro-cliente-dataUbigeo',$this->dataUbigeo);
        $this->emit('modals.registro-cliente-tipo','update');
        $this->dispatchBrowserEvent('show-form');
                      
    }

    public function eliminar($id){
        try {
            Proveedor::where('persona_id','=',$id)->delete();
            //Persona::where('id','=',$id)->delete();
            $this->resetPage();
            $this->dispatchBrowserEvent('toastr', ['message'=>'Conductor eliminado.']);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('toastr-error', ['message'=>'Registro tiene dependencia.'/*$th->errorInfo[2]*/]);
        }
    }
}
