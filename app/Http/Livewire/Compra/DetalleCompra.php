<?php

namespace App\Http\Livewire\Compra;

use App\Models\CompraDetalle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DetalleCompra extends Component
{   
    public $compra_id;
    public $detalle = [];
    public $igv;
    public $igv_porcentaje;
    protected  $listeners = ['detalleCompra'=>'alexlo','detalleCompra-refresh'=>'$refresh'];
    public function render()
    {   
        if ($this->compra_id) {
            $this->detalle = DB::table('compra_detalles as cd')
                ->join('producto_unidads as pu','cd.producto_unidad_id','=','pu.id')
                ->join('unidad_medidas as um','pu.unidad_medida_id','=','um.id')
                ->join('productos as p','cd.producto_id','=','p.id')
                ->leftJoin('producto_precio_clientes as ppc','cd.producto_unidad_id','=','ppc.producto_unidad_id')
                ->leftJoin('tipo_clientes as tc','ppc.tipo_cliente_id','=','tc.id')
                //->select('ppc.precio_venta', 'p.nombre','p.id as producto_id','cd.precio','cd.precio_compra','um.nombre as unidad_medida','cd.cantidad','cd.descuento','cd.id')
                //->select(DB::raw("group_concat(SUBSTRING(tc.nombre,1,3),': ',ppc.precio_venta separator' | ') as precio_venta"),'ppc.precio_compra as precio_compra2', 'p.nombre','p.id as producto_id','cd.precio','cd.precio_compra','um.nombre as unidad_medida','cd.cantidad','cd.descuento','cd.id')
                ->select(DB::raw("string_agg(SUBSTRING(tc.nombre,1,3)|| ' :' ||ppc.precio_venta,',') as precio_venta"),'ppc.precio_compra as precio_compra2', 'p.nombre','p.id as producto_id','cd.precio','cd.precio_compra','um.nombre as unidad_medida','cd.cantidad','cd.descuento','cd.id')
                ->where('cd.compra_id','=',$this->compra_id)
                //->where('ppc.tipo_cliente_id','=',1)
                ->groupBy('p.id','p.nombre','cd.precio','precio_compra2','cd.precio_compra','unidad_medida','cd.cantidad','cd.descuento','cd.id')
                ->get();
                //ddd($this->detalle);
                if (count($this->detalle)>0) {
                    $this->emit('exiteArticulos',true);
                }else{
                    $this->emit('exiteArticulos',false);
                }
        }

        return view('livewire.compra.detalle-compra');
    }

    public function alexlo($id,$igv,$igv_porcentaje){
        $this->compra_id = $id;
        $this->igv = $igv;
        $this->igv_porcentaje = $igv_porcentaje;
    }
    public function eliminarDetalle($id){
        CompraDetalle::find($id)->delete();
        $this->dispatchBrowserEvent('toastr',['message'=>'Registro eliminado!!']);
    }
}
