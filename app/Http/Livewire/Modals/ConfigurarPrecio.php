<?php

namespace App\Http\Livewire\Modals;

use App\Models\Producto;
use App\Models\ProductoPrecioCliente;
use App\Models\ProductoUnidad;
use App\Models\TipoCliente;
use App\Models\UnidadMedida;
use Illuminate\Support\Facades\DB;
use Livewire\Component;


class ConfigurarPrecio extends Component
{   
    public $producto;
    public $unidad_medida;
    public $unidad_medidas;
    public $cantidad_unidad;
    public $producto_unidad_id;
    public $nombre_unidad;
    public $tipo_clientes;
    public $precio_venta;
    public $precio_compra;
    public $tipo_cliente;
    public $precio_cliente;
    public $btn;
    protected $listeners = ['producto','render'];
    public function render()
    {   
        if ($this->producto) {
            
            $producto_unidades = DB::table('producto_unidads as pu')
                                    ->join('unidad_medidas as um','pu.unidad_medida_id','=','um.id')
                                    ->where('pu.producto_id','=',$this->producto->id)
                                    ->select('um.nombre','um.id as unidad_id','pu.id','pu.cantidad_unidades','pu.stock')
                                    ->get();
            //dd($producto_unidades);
        }else{
            $unidad_medidas=[];
            $producto_unidades=[];
        }
        
        return view('livewire.modals.configurar-precio', compact('producto_unidades'));
    }

    public function mount(){
        $this->producto = null;
        $this->unidad_medida = null;
        $this->cantidad_unidad = null;
        $this->tipo_clientes = [];
        $this->precio_cliente = null;
        $this->btn = 'Agregar';
        $this->unidad_medidas = UnidadMedida::all()->pluck('nombre','id');
        foreach ($this->unidad_medidas as $key => $value) {
            $this->unidad_medida = $key;
            break;
        }
    }

    public function producto($id){
        $this->producto = Producto::find($id);
    }

    public function guardarConfiguracion(){
        
        $this->validate([
            'unidad_medida' => 'required',
            'cantidad_unidad' => 'required',
        ]);
        $existe = ProductoUnidad::where('producto_id','=',$this->producto->id)
                        ->where('unidad_medida_id','=',$this->unidad_medida)
                        ->where('cantidad_unidades','=',$this->cantidad_unidad)
                        ->get();
        if (count($existe)==0) {
            ProductoUnidad::create([
                'producto_id' => $this->producto->id,
                'unidad_medida_id' => $this->unidad_medida,
                'cantidad_unidades' => $this->cantidad_unidad
            ]);
            $this->dispatchBrowserEvent('toastr', ['message'=>'Unidad de producto creado!!!']);
        } else {
            $this->dispatchBrowserEvent('toastr-error', ['message'=>'Unidad ya existe!!!']);
        }
        
        
        $this->limpiarDatos();
       
    }

    public function seleccinarUnidad($id,$unidad){
        $this->producto_unidad_id = $id;
        $this->nombre_unidad = $unidad;
        $this->tipo_clientes = TipoCliente::where('estado','=','1')->pluck('nombre','id');
        foreach ($this->tipo_clientes as $key => $tipo_cliente) {
            $this->tipo_cliente = $key;
            break;
        }
        $this->precio_venta = null;
        $this->precio_compra = null;
        $this->precio_cliente = null;
        $this->dispatchBrowserEvent('abrirModal');
    }

    public function guardarPrecio(){
        $this->validate([
            'tipo_cliente' => 'required',
            'precio_venta' => 'required'
        ]);
        $existe = ProductoPrecioCliente::where('producto_unidad_id','=',$this->producto_unidad_id)
                                        ->where('tipo_cliente_id','=',$this->tipo_cliente)
                                        ->get();
        if (count($existe)==0) {
            $clientePrecio = ProductoPrecioCliente::create([
                'producto_unidad_id' => $this->producto_unidad_id,
                'tipo_cliente_id' => $this->tipo_cliente,
                'precio_venta' => $this->precio_venta,
                'precio_compra' => $this->precio_compra
            ]);
            /* actualizamos a todos con el mismo precio de compra*/
            ProductoPrecioCliente::where('producto_unidad_id','=',$clientePrecio->producto_unidad_id)->update(['precio_compra' => $clientePrecio->precio_compra]);
            $this->emit('cerrarModalGuardar');
            $this->emit('detalleCompra-refresh');
            $this->dispatchBrowserEvent('toastr', ['message'=>'Precio registrado!!!']);
        } else {
            $this->dispatchBrowserEvent('toastr-error', ['message'=>'Tipo cliente ya existe']);
        }        
    }

    public function editarPrecio(){
        $this->validate([
            'tipo_cliente' => 'required',
            'precio_venta' => 'required'
        ]);
        $existe = ProductoPrecioCliente::where('producto_unidad_id','=',$this->producto_unidad_id)
                                        ->where('tipo_cliente_id','=',$this->tipo_cliente)
                                        ->whereNotIn('id',[$this->precio_cliente->id])
                                        ->get();
        if (count($existe)==0) {
            //dd($this->precio_compra);
            $this->precio_cliente->update([
                'producto_unidad_id' => $this->producto_unidad_id,
                'tipo_cliente_id' => $this->tipo_cliente,
                'precio_venta' => $this->precio_venta,
                'precio_compra' => $this->precio_compra == "" ? NULL : $this->precio_compra
            ]);
            /* actualizamos a todos con el mismo precio de compra*/
            ProductoPrecioCliente::where('producto_unidad_id','=',$this->precio_cliente->producto_unidad_id)->update(['precio_compra' => $this->precio_cliente->precio_compra]);
            $this->dispatchBrowserEvent('toastr', ['message'=>'Precio actualizado!!!']);
            $this->emit('detalleCompra-refresh');
            $this->emit('cerrarModalGuardar');
        } else {
            $this->dispatchBrowserEvent('toastr-error', ['message'=>'Tipo cliente ya existe']);
        }        
    }

    public function listarPrecioProductoUnidad($producto_unidad_id){
        $data = DB::table('producto_precio_clientes as prc')
                        ->join('tipo_clientes as tc','prc.tipo_cliente_id','=','tc.id')
                        ->where('prc.producto_unidad_id','=',$producto_unidad_id)
                        ->select('tc.nombre','prc.precio_compra','prc.precio_venta','prc.id')
                        ->get();
        //ddd($data);
        return $data;
    }

    public function eliminarUnidadProducto($id){
        //dd('alexlo');
        try {
            ProductoUnidad::find($id)->delete();
            $this->limpiarDatos();
            $this->dispatchBrowserEvent('toastr', ['message'=>'Unidad eliminada!!!']);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('toastr-error', ['message'=>'Registro tiene dependencia']);
        }
        
    }

    public function eliminarPrecioCliente($id){
        ProductoPrecioCliente::find($id)->delete();
        $this->emit('detalleCompra-refresh');
        $this->dispatchBrowserEvent('toastr', ['message'=>'Precio eliminado!!!']);
    }
    public function editarPrecioCliente($id){
        $this->precio_cliente = ProductoPrecioCliente::find($id);
        $this->producto_unidad_id = $this->precio_cliente->producto_unidad_id;
        $this->tipo_cliente = $this->precio_cliente->tipo_cliente_id;
        $this->precio_venta = $this->precio_cliente->precio_venta;
        $this->precio_compra = $this->precio_cliente->precio_compra;
        $this->tipo_clientes = TipoCliente::where('estado','=','1')->pluck('nombre','id');
        $this->dispatchBrowserEvent('abrirModal');
        //$this->dispatchBrowserEvent('toastr', ['message'=>'Precio eliminado!!!']);
    }

    public function editarUnidadProducto($id,$unidad_id,$cantidad_unidades){
        $this->cantidad_unidad = $cantidad_unidades;
        $this->unidad_medida = $unidad_id;
        $this->producto_unidad_id = $id;
        $this->btn = 'Editar';
    }

    public function editarConfiguracion(){
        $this->validate([
            'unidad_medida' => 'required',
            'cantidad_unidad' => 'required',
        ]);
        ProductoUnidad::find($this->producto_unidad_id)->update([
            'unidad_medida_id' => $this->unidad_medida,
            'cantidad_unidades' => $this->cantidad_unidad,
        ]);
        $this->limpiarDatos();
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Unidad de producto actualizado!!!']);
    }
    
    public function limpiarDatos(){
        $this->cantidad_unidad = null;
        $this->btn = 'Agregar';
        $this->producto_unidad_id = null;
    }


}
