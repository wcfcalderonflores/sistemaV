<?php

namespace App\Http\Livewire\AjustarStock;

use App\Models\DetalleAjusteStock as ModelsDetalleAjusteStock;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DetalleAjusteStock extends Component
{   
    public $ajuste_id;
    public $detalle = [];

    protected  $listeners = ['detalleAjuste'=>'alexlo'];
    public function render()
    {   
        if ($this->ajuste_id) {
            $this->detalle = DB::table('detalle_ajuste_stocks as das')
                ->join('producto_unidads as pu','das.producto_unidad_id','=','pu.id')
                ->join('unidad_medidas as um','pu.unidad_medida_id','=','um.id')
                ->join('productos as p','das.producto_id','=','p.id')
                ->select('p.nombre','das.precio_compra','um.nombre as unidad_medida','das.cantidad_recuperada','das.cantidad','das.cantidad_unidad','das.id')
                ->where('das.ajuste_stock_id','=',$this->ajuste_id)
                ->get();
                
                if (count($this->detalle)>0) {
                    //dd('alelo');
                    $this->emit('ajusteDetalle',true);
                }else{
                    $this->emit('ajusteDetalle',false);
                }
        }
        return view('livewire.ajustar-stock.detalle-ajuste-stock');
    }

    public function alexlo($id){
        //dd('alexlo');
        $this->ajuste_id = $id;
    }

    public function eliminarDetalle($id){
        $detalle = ModelsDetalleAjusteStock::find($id); 
        $detalle->delete();
        $this->dispatchBrowserEvent('toastr',['message'=>'Registro eliminado!!']);

    }
}
