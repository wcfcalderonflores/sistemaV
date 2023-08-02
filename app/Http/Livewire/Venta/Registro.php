<?php

namespace App\Http\Livewire\Venta;

use App\Http\Livewire\Compra\DetalleCompra;
use App\Models\Arqueo;
use App\Models\CompraDetalle;
use App\Models\Comprobante;
use App\Models\ComprobanteConfig;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\ProductoUnidad;
use App\Models\TipoCliente;
use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\ventaDetalleCompra;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;

use function Pest\Laravel\get;

class Registro extends Component
{   
    public $numero_comprobante;
    public $picked;
    public $picked2;
    public $clientes;
    public $productos;
    public $venta_id; // viene para la edicion
    public $btn_terminar;
    public $editar_venta;
    public $buscar;
    public $buscarProducto;
    public $datos_cliente;
    public $producto_id;
    public $cantidad;
    public $total;
    public $precio;
    public $precio_registro;
    public $precio_compra;
    public $cliente_id;
    public $unidad_medida;
    public $producto_unidad;
    public $cantidad_unidad;
    public $venta;
    public $tipo_precios;
    public $tipo_precio_id;
    public $comprobantes_config;
    public $comprobante;

    protected  $listeners = ['detalle'=>'exiteArticulos'];
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
        
        $this->clientes = [];
        $this->productos = [];
        $this->producto_id = null;
        /*$this->comprobantes_config = DB::table('comprobante_configs as cc')
                                        ->join('comprobantes as c','cc.comprobante_id','=','c.id')
                                        ->select('cc.id','cc.serie','c.nombre')
                                        ->where('cc.estado','=','1')
                                        ->get(); */
        //Comprobante::where('estado','=','1')->orderBy('id','asc')->get();
        //$this->comprobante = $this->comprobantes_config[2]->id; // variable estática
        $this->tipo_precios = TipoCliente::where('estado','=','1')
                                    ->orderBy('id')
                                    ->get();                        
        $this->tipo_precio_id = $this->tipo_precios[0]->id;
        //dd($this->tipo_precio_id);
        if ($this->venta_id) { //cunado viene de venta en proceso
            $this->venta = Venta::find($this->venta_id);
            $this->tipo_precio_id = $this->venta->tipo_cliente_id;
            $this->comprobante = $this->venta->comprobante_config_id;
            //dd(strval($this->comprobante));
            $this->picked = true;
            $this->numero_comprobante =  $this->venta->numero_comprobante =='' ? false : true;
            //$this->comprobante = $this->venta->compro;
            $persona = Persona::find($this->venta->cliente_id,['nombre','apellido_paterno','apellido_materno','id']);
            $this->datos_cliente= $persona->nombre." ".$persona->apellido_paterno." ".$persona->apellido_materno;
            $this->cliente_id = $this->venta->cliente_id;
            $cant = VentaDetalle::where('venta_id','=',$this->venta_id)->count();
            if($cant>0) {
               $this->btn_terminar = true;
            }
            
        }
        //dd('ALEXLO');
    }
    public function render()
    {   
        $this->comprobantes_config = DB::table('comprobante_configs as cc')
                                        ->join('comprobantes as c','cc.comprobante_id','=','c.id')
                                        ->select('cc.id','cc.serie','c.nombre')
                                        ->where('cc.estado','=','1')
                                        ->get(); 
        $this->comprobante = $this->comprobantes_config[0]->id;
        return view('livewire.venta.registro');
    }


    public function updatedBuscar()
    {   
        $this->buscarProducto = '';
        $this->productos = [];
        $this->datos_cliente = null;
        $this->cliente_id = null;
        $this->picked = false;
        $this->validate([
            "buscar" => "required|min:2"
        ]);
        
        //dd($this->datos_cliente);
        $this->clientes = DB::table('clientes as s')
                                    ->join('personas as p','s.persona_id','=','p.id')
                                    ->where(DB::raw("UPPER(CONCAT(p.nombre, ' ', p.apellido_paterno, ' ',p.apellido_materno))"), "like", "%" .trim(strtoupper($this->buscar)) . "%")
                                    ->orWhere('numero_documento','LIKE','%'.$this->buscar.'%')
                                    ->select('p.nombre','p.apellido_paterno','p.apellido_materno','p.id')
                                    ->take(3)
                                    ->get();
        //dd($this->clientes);
            
    }

    public function asignarCliente( $id,$datos)
    {   
        //$datos  = json_decode($persona,true); 
        $this->buscar = ''; 
        $this->datos_cliente = $datos;
        $this->cliente_id = $id;      
        $this->picked = true;
    }

    public function limpiar(){
        //$this->clientes = [];
        $this->productos = [];
        $this->producto_id = null;
        $this->cantidad = '';
        $this->total = '';
        $this->precio = '';
        $this->unidad_medida = '';
        //$this->datos_cliente = null;
        $this->buscarProducto = '';
        $this->picked2 = false;
        //$this->picked = false;
    }

    public function updatedbuscarProducto()
    {   
        
        $this->clientes = [];
        $this->productos = [];
        $this->producto_id = null;
        $this->cantidad = '';
        $this->total = '';
        $this->precio = '';
        $this->unidad_medida = '';
        //$this->datos_cliente = null;
        $this->picked2 = false;
        $this->validate([
            "buscarProducto" => "required|min:2"
        ]);
        
        //dd($this->tipo_precio_id);
        $this->productos = DB::table('productos as p')
                                    ->join('producto_unidads as pu','p.id','=','pu.producto_id')
                                    ->join('unidad_medidas as u','pu.unidad_medida_id','=','u.id')
                                    ->join('producto_precio_clientes as ppc','pu.id','=','ppc.producto_unidad_id')
                                    ->where(DB::raw("p.nombre"), "like", trim(strtoupper($this->buscarProducto)) . "%")
                                    ->where('ppc.tipo_cliente_id','=',$this->tipo_precio_id)
                                    //->whereNotNull('ppc.precio_compra')
                                    ->select('p.nombre','p.id','p.stock'/*'pu.stock'*/,'ppc.precio_compra','ppc.precio_venta','pu.cantidad_unidades','pu.id as producto_unidad_id','u.nombre as unidad_medida','u.abreviatura')
                                    ->take(3)
                                    ->get();
        //ddd('SL');    
    }
    public function asignarProducto($id,$datos,$precio_venta,$precio_compra,$unidad,$producto_unidad_id,$cantidad_unidades){
        $this->buscarProducto = $datos;
        $this->producto_id = $id;
        $this->total = number_format($precio_venta,2); 
        $this->precio = $precio_venta;
        $this->precio_registro = $precio_venta;
        $this->precio_compra = $precio_compra;
        $this->unidad_medida = $unidad;
        $this->cantidad_unidad = $cantidad_unidades;
        $this->producto_unidad = $producto_unidad_id;
        $this->cantidad=1;   
        $this->picked2 = true;
    }
    public function updatedcantidad(){
        $this->cantidad == '' ? $this->total = number_format(0,2) : $this->total = number_format($this->cantidad * $this->precio,2);
    }

    public function updatedtotal(){
        $this->total == '' ? $this->cantidad = number_format(0,3) : $this->cantidad = number_format($this->total / $this->precio,3);
    }

    public function registrarVenta(){
        $this->validate([
            'cliente_id' =>'required',
            'producto_id' => 'required',
            'cantidad' => 'required',
            'precio' => 'required',
            'tipo_precio_id' => 'required'
        ]);
        $productoUnidad = ProductoUnidad::find($this->producto_unidad);
        if ($productoUnidad['stock'] >=$this->cantidad) {
            $fecha = new DateTime();
            $primerRegistro = true;
            //$config = ComprobanteConfig::where('serie','=','TK02')->first();
            if (!$this->venta) {
                $primerRegistro = false;
                $this->venta = Venta::create([
                    'cliente_id' => $this->cliente_id,
                    'tipo_cliente_id' => $this->tipo_precio_id,
                    'user_id' => auth()->id(),
                    'fecha' => $fecha->format("Y-m-d H:i:s"),
                    'comprobante_config_id' => $this->comprobante
                ]);
            }
            
            $detalle = VentaDetalle::create([
                'venta_id' => $this->venta->id,
                'producto_id' => $this->producto_id,
                'producto_unidad_id' => $this->producto_unidad,
                'precio_registro' => $this->precio_registro,
                'precio' => $this->precio,
                'precio_compra' => $this->precio_compra,
                'cantidad' => $this->cantidad,
                'cantidad_unidad' => $this->cantidad_unidad,
                'user_id' => auth()->id()
            ]);
            if ($detalle) {
                /* insertamos las compras que estan saliendo */
                $detalleCompras = CompraDetalle::where('producto_unidad_id','=',$this->producto_unidad)
                                ->where('stock','>',0)->orderBy('id')->get();
                
                $cantidadSolicitada = $this->cantidad; 
                //ddd($this->producto_unidad);            
                foreach ($detalleCompras as $detCompra) {
                    $resta = $detCompra['stock'] - $cantidadSolicitada;
                    if ($resta >= 0) {
                        ventaDetalleCompra::create([
                            'venta_detalle_id' => $detalle->id,
                            'compra_detalle_id' => $detCompra->id,
                            'cantidad' => $cantidadSolicitada,
                            'precio_compra' => $detCompra->precio_compra
                        ]);
                        $detCompra->update(['stock'=> $detCompra['stock']-$cantidadSolicitada]);
                        break;
                    }else{
                        ventaDetalleCompra::create([
                            'venta_detalle_id' => $detalle->id,
                            'compra_detalle_id' => $detCompra->id,
                            'cantidad' => $detCompra['stock'],
                            'precio_compra' => $detCompra->precio_compra
                        ]);
                        $cantidadSolicitada = $cantidadSolicitada - $detCompra['stock'];
                        $detCompra->update(['stock'=> 0]);
                    }
                }

                $productoUnidad->update(['stock'=> $productoUnidad['stock']-$this->cantidad]);
            }
            if ($primerRegistro) {
                $this->limpiar();
                $this->dispatchBrowserEvent('toastr',['message'=>'Registro satisfactorio!!']);
                $this->emit('detalleVenta',$this->venta->id);
            } else {
                redirect('/ventas/'.$this->venta->id);
            }
        } else {
            $this->limpiar();
            $this->dispatchBrowserEvent('toastr-error',['message'=>'Stock insuficiente!!']);
        }
        
        
        
        
    }
    public function exiteArticulos($data){
        //dd('alexlo');
        $this->btn_terminar=$data;
    }
    public function editarVenta(){
        $this->editar_venta = true;
    }
    public function guardarVenta() {
        $this->validate([
            'cliente_id' => 'required',
        ]);
        //dd('dd:'.$this->tipo_precio_id);
        //dd($this->comprobante);
        if ($this->editar_venta) { // se require editar los datos de la venta
            $this->venta->update([
                'cliente_id' => $this->cliente_id,
                'tipo_cliente_id' => $this->tipo_precio_id,
                'comprobante_config_id' => $this->comprobante
            ]);
            //dd($this->venta);
            $this->editar_venta = false;
            $this->dispatchBrowserEvent('toastr',['message'=>'Se actualizó los datos.']);
        }
        
    }

    public function eliminarVenta(){
        //devolvemos el stock
        // calculamos cantidades de cada producto para actualizar el stock
        $detalle = DB::table('venta_detalles')
                        ->where('venta_id','=',$this->venta->id)
                        ->select('id','producto_unidad_id')
                        ->get();
        // insertamos los stock en la tabla productos
        //dd($detalle);
        foreach ($detalle as $det) {
            $sumaStockCompras = 0;
            $ventaDetalleCompra = ventaDetalleCompra::where('venta_detalle_id','=',$det->id)->get();
            
            foreach ($ventaDetalleCompra as $ventaDetCompra) {
                $compraDetalle = CompraDetalle::find($ventaDetCompra->compra_detalle_id);
                //dd($compraDetalle);
                $compraDetalle->update(['stock'=> $compraDetalle['stock'] + $ventaDetCompra->cantidad]);
                $sumaStockCompras =  $sumaStockCompras + $ventaDetCompra->cantidad;
            }
            //dd($sumaStockCompras);
            $productoUnidad = ProductoUnidad::find($det->producto_unidad_id);
            $productoUnidad->update(['stock'=> $productoUnidad['stock'] + $sumaStockCompras]);
        }
        // fin de stock
        $this->venta->delete();
        redirect()->route('venta');
    }

    public function terminarRegistro( Request $request){
        //$config = ComprobanteConfig::all()->first();
        $config = ComprobanteConfig::find($this->venta->comprobante_config_id);
        $numero = $config->contador + 1;
        //$hoy = getdate();
        $fecha = new DateTime();
        //ddd($fecha->getTimestamp());
        $this->venta->update([
            'estado' => '1',
            'numero_comprobante' => $numero,
            'fecha' =>$fecha->format("Y-m-d H:i:s"),
            'arqueo_id' => $request->session()->get('arqueo')
        ]);
        $config->update([
            'contador' => $numero,
        ]);
        $this->dispatchBrowserEvent('toastr',['message'=>'Registro finalizado.']);
        redirect()->route('venta.comprobante',$this->venta);
    }

    public function agregarCliente(){

        $this->emit('modals.registro-cliente-tipo','create');
        $this->emit('modals.registro-cliente-limpiar');
        $this->emit('modals.registro-cliente-clienteId');
        $this->dispatchBrowserEvent('show-form');
        //return redirect()->back();
        
    }

    public function cambiarPrecio(){
        $this->buscarProducto = '';
        $this->productos = [];
    }
}
