<?php

namespace App\Http\Livewire\AjustarStock;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;

class Reporte extends Component
{   
    public $desde;
    public $hasta;
    public $pintar;
    public $resultado = [];

    public function render()
    {   
        if ($this->pintar) {
            $this->resultado = DB::table('ajuste_stocks as s')
                                ->join('detalle_ajuste_stocks as ds', 'ds.ajuste_stock_id','=','s.id')
                                ->join('personas as p','s.user_id','=','p.id')
                                ->select('s.id','s.tipo_ajuste','s.created_at','s.referencia','p.nombre','p.apellido_paterno','p.apellido_materno', DB::raw('sum(ds.cantidad * ds.precio_compra) as cantidad_perdida,sum(ds.cantidad_recuperada) as cantidad_recuperada'))
                                ->whereBetween(DB::raw('date(s.created_at)'),[$this->desde,$this->hasta])
                                ->where('estado','=','1')
                                ->groupBy('s.id','s.tipo_ajuste','s.created_at','s.referencia','p.nombre','p.apellido_paterno','p.apellido_materno')
                                ->orderBy('s.created_at')
                                ->get();
        //ddd($this->resultado);
        }
        return view('livewire.ajustar-stock.reporte');
    }

    public function listarAjustes(){
        //dd($this->data);
        $this->validate([
            'desde' => 'required',
            'hasta' => 'required'
        ]);
        $this->pintar = true;
    }

    public function verAjuste($id, $referencia){
        $this->emit('modals.mostrar-ajuste',$id,$referencia);
        $this->dispatchBrowserEvent('show-modal-ajuste');
    }
}
