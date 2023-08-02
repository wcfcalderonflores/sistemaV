<?php

namespace App\Http\Livewire\Venta;

use App\Models\CompraDetalle;
use App\Models\Producto;
use App\Models\ProductoUnidad;
use App\Models\VentaDetalle;
use App\Models\ventaDetalleCompra;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DetalleVenta extends Component
{   
    public $venta_id;
    public $detalle = [];
    public $detalle_descuento;
    public $producto;
    public $descuento_producto;
    protected  $listeners = ['detalleVenta'=>'alexlo'];
    public function render()
    {   
        if ($this->venta_id) {
            $this->detalle = DB::table('venta_detalles as vd')
                ->join('producto_unidads as pu','vd.producto_unidad_id','=','pu.id')
                ->join('unidad_medidas as um','pu.unidad_medida_id','=','um.id')
                ->join('productos as p','vd.producto_id','=','p.id')
                ->select('p.nombre','vd.precio','um.nombre as unidad_medida','vd.cantidad','vd.descuento','vd.id')
                ->where('vd.venta_id','=',$this->venta_id)
                ->get();
                
                if (count($this->detalle)>0) {
                    //dd('alelo');
                    $this->emit('detalle',true);
                }else{
                    $this->emit('detalle',false);
                }
        }
        
        
        return view('livewire.venta.detalle-venta');
    }

    public function alexlo($id){
        //dd('alexlo');
        $this->venta_id = $id;
    }

    public function eliminarDetalle($id){
        $detalle = VentaDetalle::find($id);

        /* Cuando se maneja el stock por unidad de producto */
        $ventaDetalleCompra = ventaDetalleCompra::where('venta_detalle_id','=',$id)->get();
        $sumaStockCompras = 0;
        foreach ($ventaDetalleCompra as $ventaDetCompra) {
            $compraDetalle = CompraDetalle::find($ventaDetCompra->compra_detalle_id);
            //dd($compraDetalle);
            $compraDetalle->update(['stock'=> $compraDetalle['stock'] + $ventaDetCompra->cantidad]);
            $sumaStockCompras =  $sumaStockCompras + $ventaDetCompra->cantidad;
        }
        $productoUnidad = ProductoUnidad::find($detalle->producto_unidad_id);
        $productoUnidad->update(['stock'=> $productoUnidad['stock'] + $sumaStockCompras]);
        /* FIN DEL MANEJO DE STOCK POR UNIDAD DE PRODUCTO */
        /*
        //devolvemos el stock
        $producto = Producto::find($detalle['producto_id']); 
        $producto->update(['stock' => $producto['stock']+($detalle['cantidad']*$detalle['cantidad_unidad'])]);*/
        $detalle->delete();
        $this->dispatchBrowserEvent('toastr',['message'=>'Registro eliminado!!']);

    }

    public function agregarDescuento($id, $producto){
        $this->detalle_descuento = VentaDetalle::find($id);
        $this->descuento_producto = $this->detalle_descuento->descuento;
        $this->producto = $producto;
        $this->dispatchBrowserEvent('modalDescuento');
    }

    public function registrarDescuento(){
        
        //dd($this->descuento_producto);
        $actualizar = $this->detalle_descuento->update(['descuento' => $this->descuento_producto != "" ? $this->descuento_producto : NULL]);
        if($actualizar){
            $this->dispatchBrowserEvent('toastr',['message'=>'Descuento registrado!!']);
        }else{
            $this->dispatchBrowserEvent('toastr-error',['message'=>'No registrado!!']); 
        }
        $this->detalle_descuento = null;
        $this->dispatchBrowserEvent('modalDescuento-cerrar');

    }

}
