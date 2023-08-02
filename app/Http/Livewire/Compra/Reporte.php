<?php

namespace App\Http\Livewire\Compra;

use App\Models\Compra;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Reporte extends Component
{   
    public $desde;
    public $hasta;
    public $pintar;
    public $resultado = [];

    protected $listeners = ['anularCompra','editarCompra'];
    public function render()
    {   
        if ($this->pintar) {
            $this->resultado = DB::table('compras as c')
                                ->join('compra_detalles as cd', 'cd.compra_id','=','c.id')
                                ->join('personas as p','p.id','=','c.proveedor_id')
                                ->select('c.id','c.forma_pago','p.nombre','p.apellido_paterno','p.apellido_materno','c.numero_comprobante','c.estado_igv','c.porcentaje_igv','c.fecha_compra', DB::raw('sum(ROUND(cd.cantidad * cd.precio,2)) as total'))
                                ->whereBetween(DB::raw('date(c.fecha_compra)'),[$this->desde,$this->hasta])
                                ->where('estado','=','1')
                                ->groupBy('c.id','c.forma_pago','c.numero_comprobante','p.nombre','p.apellido_paterno','p.apellido_materno','c.fecha_compra','c.estado_igv','c.porcentaje_igv')
                                ->orderBy('c.fecha_compra')
                                ->get();
            //ddd($this->resultado);
        }
        return view('livewire.compra.reporte');
    }

    public function listarCompras(){
        //dd($this->data);
        $this->validate([
            'desde' => 'required',
            'hasta' => 'required'
        ]);
        $this->pintar = true;
    }
    public function verCompra($id,$estado_igv, $porcentaje_igv,$numero_comprobante){
        //$ruta = route('venta.show',$id);
        $this->emit('modals.mostrar-compra',$id,$estado_igv,$porcentaje_igv,$numero_comprobante);
        $this->dispatchBrowserEvent('show-modal-compra');
    }

    public function anularCompra($id){
        Compra::find($id)
                ->update([
            'estado' => '0',
            //'arqueo_id' => $request->session()->get('arqueo')
        ]);
        // calculamos cantidades de cada producto para actualizar el stock
        $detalle = DB::table('compra_detalles as cd')
                        ->where('compra_id','=',$id)
                        ->select('producto_id',DB::raw('SUM(cd.cantidad*cd.cantidad_unidad) as total'))
                        ->groupBy('producto_id')
                        ->get();
        // insertamos los stock en la tabla productos
        foreach ($detalle as $det) {
            $producto = Producto::find($det->producto_id);
            $stock = $producto['stock'] ? $producto['stock'] : 0 ;
            //dd($stock + $det->total);
            $producto->stock = $stock - $det->total;
            try {
                $producto->save();
            } catch (\Throwable $th) {
                $this->dispatchBrowserEvent('toastr-error',['message'=>'Error al actualizar stock']);
            }
        }
        $this->dispatchBrowserEvent('toastr',['message'=>'Compra anulada.']);
        //redirect()->route('compra');
    }

    public function editarCompra($id){
        Compra::find($id)
                ->update([
            'estado' => '2',
            //'arqueo_id' => $request->session()->get('arqueo')
        ]);
        // calculamos cantidades de cada producto para actualizar el stock
        $detalle = DB::table('compra_detalles as cd')
                        ->where('compra_id','=',$id)
                        ->select('producto_id',DB::raw('SUM(cd.cantidad*cd.cantidad_unidad) as total'))
                        ->groupBy('producto_id')
                        ->get();
        // insertamos los stock en la tabla productos
        foreach ($detalle as $det) {
            $producto = Producto::find($det->producto_id);
            $stock = $producto['stock'] ? $producto['stock'] : 0 ;
            //dd($stock + $det->total);
            $producto->stock = $stock - $det->total;
            try {
                $producto->save();
            } catch (\Throwable $th) {
                $this->dispatchBrowserEvent('toastr-error',['message'=>'Error al actualizar stock']);
            }
        }
        //$this->dispatchBrowserEvent('toastr',['message'=>'Compra anulada.']);
        redirect()->route('compra.edit',$id);
    }
}
