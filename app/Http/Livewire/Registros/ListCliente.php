<?php

namespace App\Http\Livewire\Registros;

use App\Models\Persona;
use App\Models\Ubigeo;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ListCliente extends Component
{   
    public $search;
    public $tipo;//='create';
    public $provincias=[];
    public $distritos=[];
    public $departamento;
    public $departamentos;
    public $data= [];
    public $cliente=[];
    public $dataUbigeo=[];
    use WithPagination;
    protected $listeners = ['listCliente' => '$refresh'];
    public function mount(){
        $this->departamentos = [];
    }
    public function updatingSearch(){
        $this->resetPage();
    }
    public function render()
    {   
        /*$clientes = Cliente::where('nombres','LIKE','%'.$this->search.'%')
                        ->orWhere('email','LIKE','%'.$this->search.'%')
                        ->paginate(3);*/
        $clientes = DB::table('clientes')
                        ->join('personas','clientes.persona_id','=','personas.id')
                        ->leftJoin('ubigeos','personas.ubigeo_id','=','ubigeos.id')
                        ->select('personas.*','ubigeos.departamento','ubigeos.provincia','ubigeos.distrito')
                        ->where('nombre','LIKE','%'.$this->search.'%')
                        ->orWhere('numero_documento','LIKE','%'.$this->search.'%')//->get()->toArray();
                        ->paginate(15);
        //dd($clientes->get());

        return view('livewire.registros.list-cliente', compact('clientes'));
    }

    public function agregarCliente(){

        $this->emit('modals.registro-cliente-tipo','create');
        $this->emit('modals.registro-cliente-limpiar');
        $this->emit('modals.registro-cliente-clienteId');
        $this->dispatchBrowserEvent('show-form');
        //return redirect()->back();
        
    }

    public function buscarProvincia($data){
        /*$this->distritos=[];
        $this->provincias = [];*/
        
        $this->departamento = $data;
        
        $provincias = DB::table('ubigeos')
                        ->select('provincia')
                        ->distinct()
                        ->where('departamento','=',$data)
                        ->pluck('provincia','provincia');
        $this->provincias = $provincias->prepend('--Seleccione-',null);
        //dd($this->departamento);
    }

    public function buscarDistrito($data){
        $distritos = DB::table('ubigeos')
                        ->select('id','distrito')
                        ->distinct()
                        ->where('departamento','=',$this->departamento)
                        ->where('provincia','=',$data)
                        ->pluck('distrito','id');
        $this->distritos = $distritos->prepend('--Seleccione-',null);
    }

    public function editarCliente($id){
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

    public function eliminar($id)
    {   try {
        Persona::where('id','=',$id)->delete();
        $this->resetPage();
        $this->dispatchBrowserEvent('toastr', ['message'=>'Cliente eliminado.']);
    } catch (\Throwable $th) {
    $this->dispatchBrowserEvent('toastr-error', ['message'=>'Registro tiene dependencia.'/*$th->errorInfo[2]*/]);
    }
        
        return redirect()->back();
    }
}
