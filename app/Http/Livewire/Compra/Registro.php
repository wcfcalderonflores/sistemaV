<?php

namespace App\Http\Livewire\Compra;

use App\Http\Livewire\Venta\DetalleVenta;
use App\Models\Arqueo;
use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\Comprobante;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\ProductoPrecioCliente;
use App\Models\ProductoUnidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Registro extends Component
{   
    public $estado_compra; //
    public $numero_comprobante; //
    public $fecha_compra; //
    public $forma_pago; //
    public $igv; //
    public $incluye_igv; //
    public $igv_porcentaje;//
    public $picked;//
    public $picked2; //
    public $comprobante; //
    public $proveedores = []; //
    public $productos = [];
    public $comprobantes;
    public $compra_id; // viene para la edicion
    public $btn_terminar;
    public $editar_compra; //
    public $buscar; //
    public $buscarProducto; //
    public $producto_id; //
    public $cantidad;
    public $total; //
    public $precio; //
    //public $precio_registro;
    public $proveedor_id;//
    public $unidad_medida; //
    public $producto_unidad; //
    public $cantidad_unidad; //
    public $compra; //
    public $tipo_precios; //
    public $tipo_precio_id; //
    public $actualizar_precio_venta;//
    protected  $listeners = ['exiteArticulos'];
    public function render()
    {   
        
        return view('livewire.compra.registro');
    }

    public function mount( Request $request ){
        if (!$request->session()->has('arqueo')) {
            $arqueo = Arqueo::where('estado','=','1')
                    ->where('estado_recibido','=','1')
                    ->where('usuario_id','=',auth()->user()->id)
                    ->pluck('id');
            if (count($arqueo)) {
                session(['arqueo' => $arqueo[0]]);
            }
        }
        $this->comprobantes = Comprobante::where('estado','=','1')->get();
        //dd($this->comprobantes);
        $this->comprobante = $this->comprobantes[0]['id'];
        $this->forma_pago = '1';
        $this->igv = false;
        $this->actualizar_precio_venta = true;
        $this->estado_compra = '2';

        if ($this->compra_id) { //cunado viene de venta en proceso o primer registro
            $this->compra = Compra::find($this->compra_id);
            $this->picked = true;
            $this->estado_compra =  $this->compra->estado;
            $this->comprobante = $this->compra->comprobante_id;
            $this->numero_comprobante = $this->compra->numero_comprobante;
            $this->fecha_compra = $this->compra->fecha_compra;
            $this->forma_pago = $this->compra->forma_pago;
            $this->igv = $this->compra->estado_igv == '0' ? false : true;
           // $this->incluye_igv = $this->compra->estado_igv == '2' ? true : false;
            $this->igv_porcentaje = $this->compra->porcentaje_igv;
            $persona = Persona::find($this->compra->proveedor_id,['nombre','apellido_paterno','apellido_materno','id']);
            $this->buscar= $persona->nombre." ".$persona->apellido_paterno." ".$persona->apellido_materno;
            $this->proveedor_id = $this->compra->proveedor_id;
            $detalle = CompraDetalle::where('compra_id','=',$this->compra_id)->count();
            if ($detalle > 0) {
                $this->btn_terminar=true;
            }
            
            
        }
    }

    public function updatedBuscar(){
        $this->proveedor_id = null;
        $this->picked = false;
        $this->proveedores = [];
        $this->validate([
            "buscar" => "required|min:2"
        ]);
        
        //dd($this->datos_cliente);
        $this->proveedores = DB::table('proveedors as pr')
                                    ->join('personas as p','pr.persona_id','=','p.id')
                                    ->where(DB::raw("UPPER(CONCAT(p.nombre, ' ', p.apellido_paterno, ' ',p.apellido_materno))"), "like", "%" .trim(strtoupper($this->buscar)) . "%")
                                    ->orWhere('numero_documento','LIKE','%'.$this->buscar.'%')
                                    ->select('p.nombre','p.apellido_paterno','p.apellido_materno','p.id')
                                    ->take(3)
                                    ->get();
                                    //ddd("alex");
    }

    public function asignarProveedor( $id,$datos)
    {    
        $this->buscar = $datos; 
        $this->proveedor_id = $id;      
        $this->picked = true;
    }
    public function updatedbuscarProducto()
    {   
        
        $this->proveedores = [];
        $this->productos = [];
        $this->producto_id = null;
        $this->cantidad = '';
        $this->unidad_medida = '';
       // $this->total = '';
        $this->precio = '';
        $this->picked2 = false;
        $this->validate([
            "buscarProducto" => "required|min:2"
        ]);
        
        //dd($this->datos_cliente);
        $this->productos = DB::table('productos as p')
                                    ->join('producto_unidads as pu','p.id','=','pu.producto_id')
                                    ->join('unidad_medidas as u','pu.unidad_medida_id','=','u.id')
                                    //->join('producto_precio_clientes as ppc','pu.id','=','ppc.producto_unidad_id')
                                    ->where(DB::raw("upper(p.nombre)"), "like", trim(strtoupper($this->buscarProducto)) . "%")
                                    //->where('ppc.tipo_cliente_id','=',$this->tipo_precio_id)
                                    ->select('p.nombre','p.id',/*'ppc.precio',*/'pu.cantidad_unidades','pu.id as producto_unidad_id','u.nombre as unidad_medida','u.abreviatura')
                                    ->take(3)
                                    ->get();
                                   //ddd('alexlo'.$this->productos);
            
    }

    public function asignarProducto($id,$datos,$unidad,$producto_unidad_id,$cantidad_unidades){
        $this->buscarProducto = $datos;
        $this->producto_id = $id;
        $this->unidad_medida = $unidad;
        $this->cantidad_unidad = $cantidad_unidades;
        $this->producto_unidad = $producto_unidad_id;
        $this->cantidad=1;   
        $this->picked2 = true;
    }

    public function updatedcantidad(){
        $this->precio = $this->precio ? $this->precio : 0.00;
        $this->cantidad == '' ? $this->total = number_format(0,2) : $this->total = number_format($this->cantidad * $this->precio,2);
    }
    public function updatedprecio(){
        $this->cantidad = $this->cantidad ? $this->cantidad : 0;
        $this->precio == '' ? $this->total = number_format(0,2) : $this->total = number_format($this->cantidad * $this->precio,2);
    }

    public function registrarCompra(){
        $id = $this->compra ? $this->compra->id : 0;
        $this->validate([
            'proveedor_id' =>'required',
            'comprobante' =>'required',
            'numero_comprobante' =>'required|unique:compras,numero_comprobante,'.$id,
            'fecha_compra' =>'required',
            'forma_pago' =>'required',
            'producto_id' => 'required',
            'cantidad' => 'required',
            'precio' => 'required',
        ]);
        $primerRegistro = true;
        if (!$this->compra) {
            
            $primerRegistro = false;
            $this->compra = Compra::create([
                'proveedor_id' => $this->proveedor_id,
                'numero_comprobante' => $this->numero_comprobante,
                'comprobante_id' => $this->comprobante,
                'user_id' => auth()->id(),
                'fecha_compra' => $this->fecha_compra,
                'forma_pago' => $this->forma_pago,
                'estado_igv' => $this->igv,
                'porcentaje_igv' => $this->igv ? 18 : 0
            ]);
        }
        // verificamos ue el producto_ unidad no este agregado el el detalle
        $existe = CompraDetalle::where('compra_id','=',$this->compra->id)
                                ->where('producto_id','=',$this->producto_id)
                                ->where('producto_unidad_id','=',$this->producto_unidad)->count();
        if ($existe == 0) {
            $detalle = CompraDetalle::create([
                'compra_id' => $this->compra->id,
                'producto_id' => $this->producto_id,
                'producto_unidad_id' => $this->producto_unidad,
                'precio' => $this->precio,
                'precio_compra' => $this->compra->igv == '0' ? round($this->precio) : round(($this->precio) + ($this->compra->porcentaje_igv/100 * $this->precio),2),
                'cantidad' => $this->cantidad,
                'stock' => $this->cantidad,
                'cantidad_unidad' => $this->cantidad_unidad,
                'stock_unidades' => $this->cantidad_unidad * $this->cantidad,
                'user_id' => auth()->id()
            ]);
            /*if ($detalle) { // insertamos el precio venta en configuracion de precios
                if ($this->actualizar_precio_venta) { // si el precio de venta esta activo actulizamos precio
                    $precios = ProductoPrecioCliente::where('producto_unidad_id','=',$detalle->producto_unidad_id);//->get();
                    if ($precios) {
                        $precios->update(['precio_compra' => $detalle->precio_compra]);
                    }
                }
            }*/
            if ($primerRegistro) {
                $this->limpiar();
                $this->dispatchBrowserEvent('toastr',['message'=>'Registro satisfactorio!!']);
                $this->emit('detalleCompra',$this->compra->id,$this->compra->estado_igv,$this->compra->porcentaje_igv);
            } else {
                redirect('/compras/'.$this->compra->id);
            }
        }else{
            $this->limpiar();
            $this->dispatchBrowserEvent('toastr-error',['message'=>'Ya existe registro!!']);
        }
        
        
    }

    public function limpiar(){
        $this->productos = [];
        $this->producto_id = null;
        $this->unidad_medida = '';
        $this->cantidad = '';
        $this->total = '';
        $this->precio = '';
        $this->buscarProducto = '';
        $this->picked2 = false;
    }

    public function eliminarCompra(){
        $this->compra->delete();
        redirect()->route('compra');
    }

    public function agregarProveedor(){
        $this->emit('modals.registro-cliente-tipo','create');
        $this->emit('modals.registro-cliente-limpiar');
        $this->emit('modals.registro-cliente-clienteId');
        $this->emit('modals.registro-cliente-cabecera','Proveedor');
        $this->dispatchBrowserEvent('show-form');

    }
    public function editarCompra(){
        $this->editar_compra = true;
    }

    public function guardarCompra() {
        $this->validate([
            'proveedor_id' =>'required',
            'comprobante' =>'required',
            'numero_comprobante' =>'required|unique:compras,numero_comprobante,'.$this->compra->id,
            'fecha_compra' =>'required',
            'forma_pago' =>'required',
        ]);
        
        if ($this->editar_compra) { // se reuire editar los datos de la compra
            // si igv se actualiza voolver a pintar detalle
            
            $this->compra->estado_igv == '1' ? true : false;
            //dd($this->igv);
            $pintar = false;
            $this->compra->estado_igv == $this->igv ? $pintar = false : $pintar = true;
            //dd($this->igv);
            $this->compra->update([
                'proveedor_id' => $this->proveedor_id,
                'numero_comprobante' => $this->numero_comprobante,
                'comprobante_id' => $this->comprobante,
                'user_id' => auth()->id(),
                'fecha_compra' => $this->fecha_compra,
                'forma_pago' => $this->forma_pago,
                //'estado_igv' => $this->incluye_igv ? '2' : ($this->igv ? '1' : '0'),
                'estado_igv' => $this->igv,
                'porcentaje_igv' => $this->igv ? 18 : 0
            ]);
            $this->editar_compra = false;
            if ($pintar) {
                $compra_detalle = CompraDetalle::where('compra_id','=',$this->compra->id);
                $compra_detalle->update([
                    'precio_compra' => $this->compra->igv == '0' ?  DB::raw('precio') : DB::raw('round(cast(precio'.'+ ('.$this->compra->porcentaje_igv/100 .'*'.'precio) as numeric),2)')//($this->compra->porcentaje_igv/100 * DB::raw('precio/cantidad_unidad')),
                ]);
                if ($this->actualizar_precio_venta) { // si el precio de venta esta activo actulizamos precio
                    // actualizamos los precios despues de cambiar el igv
                    $precios = ProductoPrecioCliente::where('producto_unidad_id','=',$compra_detalle->get()[0]['producto_unidad_id']);//->get();
                    if ($precios) {
                    $precios->update(['precio_compra' => $compra_detalle->get()[0]['precio_compra']]);
                    }
                }
                $this->emit('detalleCompra',$this->compra->id,$this->compra->estado_igv,$this->compra->porcentaje_igv);
            }else{
                $this->dispatchBrowserEvent('toastr',['message'=>'Se actualizó los datos.']);
            }
            
        }
        
    }

    public function terminarRegistro( Request $request){
        
        
        $this->compra->update([
            'estado' => '1',
            'arqueo_id' => $request->session()->get('arqueo')
        ]);
        // cuando usamos stock por producto unidad de medida
        /*
        // calculamos cantidades de cada producto para actualizar el stock
        $detalle = DB::table('compra_detalles as cd')
                        ->where('compra_id','=',$this->compra->id)
                        ->select('cd.producto_unidad_id','cd.cantidad','producto_id')
                        ->get();
        // insertamos los stock en la tabla productos
        foreach ($detalle as $det) {
            $productoUnidad = ProductoUnidad::find($det->producto_unidad_id);
            //$stock = $productoUnidad['stock'] ? $productoUnidad['stock'] : 0 ;
            //dd($stock + $det->total);
            $productoUnidad->stock = $productoUnidad['stock'] + $det->cantidad;
            try {
                $productoUnidad->save();
            } catch (\Throwable $th) {
                $this->dispatchBrowserEvent('toastr-error',['message'=>'Error al actualizar stock']);
            }
        }*/
        $detalle = DB::table('compra_detalles as cd')
                        ->where('compra_id','=',$this->compra->id)
                        ->select('producto_id',DB::raw('SUM(cd.cantidad*cd.cantidad_unidad) as total'))
                        ->groupBy('producto_id')
                        ->get();
        // insertamos los stock en la tabla productos
        foreach ($detalle as $det) {
            $producto = Producto::find($det->producto_id);
            $stock = $producto['stock'] ? $producto['stock'] : 0 ;
            //dd($stock + $det->total);
            $producto->stock = $stock + $det->total;
            try {
                $producto->save();
            } catch (\Throwable $th) {
                $this->dispatchBrowserEvent('toastr-error',['message'=>'Error al actualizar stock']);
            }
        }

        $this->dispatchBrowserEvent('toastr',['message'=>'Registro finalizado.']);
        redirect()->route('compra');
    }
    public function exiteArticulos($data){
        $this->btn_terminar=$data;
    }

    public function estadoIgv(){
        $this->igv ? '' : $this->incluye_igv = false;
    }
}
