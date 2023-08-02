<?php

namespace App\Http\Livewire\Modals;

use App\Models\ProductoCategoria;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class RegistroCategoria extends Component
{   
    public $tipo;
    public $data;
    protected $listeners = [
        'registro-categoria-tipo'=>'tipo',
        'registro-categoria-data'=>'data',];
    public function render()
    {
        return view('livewire.modals.registro-categoria');
    }
    public function tipo($dato){
        $this->tipo = $dato;
    }
    public function registrar(){
        $this->data['nombre'] = strtoupper($this->data['nombre']);
       Validator::make($this->data,[
           'nombre' => 'required|unique:producto_categorias',
        ])->validate();
        //dd($this->data);
        ProductoCategoria::create(
           $this->data
        );
        $this->emit('cerrarModalCategoria');
        $this->dispatchBrowserEvent('toastr', ['message'=>'Categoría creada.']);
        $this->emit('registro-producto');
       
    }
}
