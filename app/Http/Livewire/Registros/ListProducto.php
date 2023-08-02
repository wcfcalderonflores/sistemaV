<?php

namespace App\Http\Livewire\Registros;

use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListProducto extends Component
{   
    public $search;
    //public $producto;
    //public $productos = [];
    protected $listeners = ['listProducto' => '$refresh'];
    public function render()
    {   
        $productos = DB::table('productos as p')
                        ->join('producto_categorias as pc','pc.id','=','p.categoria_id')
                        ->select('p.id','p.nombre','pc.nombre as categoria','p.marca','p.stock_minimo','p.stock')
                        ->where('p.nombre','LIKE','%'.$this->search.'%')
                        ->orderBy('id')
                        ->paginate(15);
        //dd($productos);
        return view('livewire.registros.list-producto', compact('productos'));
    }

    public function mount(){
        $this->search = '';
        //$this->productos = [];
    }

    public function agregarProducto(){
        $this->emit('registro-producto-tipo','create');
        $this->emit('registro-producto-data', null);
        $this->emit('show-form');
        $this->dispatchBrowserEvent('show-form');
    }

    public function unidad($unidad){

        switch ($unidad) {
            case '01':
                return 'Kg';
                break;
            case '02':
                return 'Lit';
                break;
            case '03':
                return 'Pqt';
                break;
            
            default:
                return 'Unid';
                break;
        }

    }

    public function eliminar($id){
        try {
            Producto::find($id)->delete();
            $this->dispatchBrowserEvent('hide-form', ['message'=>'Producto eliminado!!!']);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('toastr-error', ['message'=>'Producto tiene dependencia!!']);
        }
       
    }

    public function editarProducto($id){
        $producto = Producto::find($id);
        //dd($this->producto);
        //$this->emit('registro-producto');
        $this->emit('registro-producto-tipo','update');
        $this->emit('registro-producto-data',$producto);
        $this->emit('show-form');
        //$this->dispatchBrowserEvent('show-form');
    }
}
