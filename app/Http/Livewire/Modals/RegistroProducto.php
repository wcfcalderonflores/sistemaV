<?php

namespace App\Http\Livewire\Modals;

use App\Models\producto;
use App\Models\ProductoCategoria;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class RegistroProducto extends Component
{   
    use WithFileUploads;
    public $tipo;
    public $cabecera;
    public $producto;
    public $data = [];
    protected $listeners = [
                            'registro-producto-tipo'=>'tipo',
                            'registro-producto-data'=>'data',
                            'afectoIgv',
                            'registro-producto'=>'$refresh'
                        ];
    public function render()
    {   
        //$this->data['img'] = '';
        $categorias = ProductoCategoria::where('estado','=','1')->pluck('nombre','id');
        $categorias = $categorias->prepend('--Seleccione-',null);
        //dd($alexlo["id"]);
        return view('livewire.modals.registro-producto', compact('categorias'));
    }

    public function mount(){
        $this->tipo ='create';
        $this->data['afecto_igv'] = 'G';
        //dd($this->data);
    }


    public function createProducto(){
        //dd($this->data);
        isset($this->data['nombre']) ? $this->data['nombre'] = strtoupper($this->data['nombre']) : $this->data['nombre']='';
        isset($this->data['marca']) ? $this->data['marca'] = strtoupper($this->data['marca']) : '';
        /*if(!isset($this->data['afecto_igv'])){
            $this->data['afecto_igv'] = 'G';
        }*/
        Validator::make($this->data,[
           'nombre' => 'required|unique:productos',
           'categoria_id' => 'required',
           'imagen' => 'mimes:jpeg,jpg,png|dimensions:max_width=110,max_height=178|max:300',
           //'stock' => 'required',
           'stock_minimo' => 'required',
        ])->validate();
        if(isset($this->data['img']) && $this->data['img']!=''){
            $this->data['imagen'] = Storage::url($this->data['img']->storeAs('public/productos',$this->data['nombre'].".".$this->data['img']->getClientOriginalExtension()));
            //$this->data['imagen'] = $this->data['imagen']->store("public/productos");//As('productos',$this->data['nombre'].".".$this->data['imagen']->getClientOriginalExtension());
        }
        //dd($this->data);
        producto::create($this->data);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Producto creado!!!']);
        $this->emit('listProducto');
       
    }

    public function data($data){
        $this->data = $data;
        //dd($this->data);
    }
    public function tipo($dato){
        $this->tipo = $dato;
    }
    public function afectoIgv(){
        $this->data['afecto_igv'] = 'G';
    }

    public function editarProducto(){
        //dd($this->data);
        $this->data['nombre'] = strtoupper($this->data['nombre']);
        $this->data['marca'] = strtoupper($this->data['marca']);
        Validator::make($this->data,[
           'nombre' => 'required',
           'categoria_id' => 'required',
           //'imagen' => 'mimes:jpeg,jpg,png|dimensions:max_width=190,max_height=280|max:300',
           //'precio' => 'required',
           //'stock' => 'required',
           'stock_minimo' => 'required',
        ])->validate();
        if(isset($this->data['img']) && $this->data['img']!=''){
            //dd($this->data['imagen']);
            Validator::make($this->data,[
                'img' => 'mimes:jpeg,jpg,png|dimensions:max_width=190,max_height=280|max:300',
             ])->validate();
             $this->data['imagen'] = Storage::url($this->data['img']->storeAs('public/productos',$this->data['nombre'].".".$this->data['img']->getClientOriginalExtension()));   
        }
        //dd($this->data);
        
        producto::find($this->data['id'])->update($this->data);
        
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Producto actualizado!!!']);
        $this->emit('listProducto');

    }

    public function eliminarImagen(){
        $this->data['imagen'] = '';
    }
}
