<?php

namespace App\Http\Livewire\Admin;

use App\Models\Movimiento;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListCajaMovimientos extends Component
{   
    public $arqueoId;
    public $ventas;
    public $movimientos;
    protected  $listeners = ['mostrar','limpiar','recargar' => '$refresh'];

    public function mount(){
        $this->arqueoId = '';
        //$this->salidas = [];
        $this->movimientos = [];
        //$this->ordenSalidas = [];
    }
    public function render()
    {   
        //dd($this->arqueoId);
        if ($this->arqueoId != '') {
            $this->ventas = DB::table('ventas as v')
                        ->join('venta_detalles as vd', 'vd.venta_id','=','v.id')
                        ->join('personas as p','p.id','=','v.cliente_id')
                        ->where('v.estado','=','1')
                        ->where('v.arqueo_id','=',$this->arqueoId)
                        ->select('v.id','p.nombre','p.apellido_paterno','p.apellido_materno','v.fecha', DB::raw('sum(ROUND(cast(vd.cantidad * vd.precio as numeric),2)) as total'))
                        ->groupBy('v.id','p.nombre','p.apellido_paterno','p.apellido_materno','v.fecha')
                        ->orderBy('v.fecha')
                        ->get();



            $this->movimientos = Movimiento::where('estado','=','1')
                                ->where('arqueo_id','=',$this->arqueoId)
                                ->select('tipo_movimiento','descripcion','monto','created_at as fecha')
                                ->get();


        }else{
            //dd('alexlo');
            $this->ventas = [];

            $this->movimientos = [];
        }
        
        return view('livewire.admin.list-caja-movimientos');
    }

    public function mostrar($id){
        $this->arqueoId = $id;
    }
    public function limpiar(){
        //dd('ALEXLO');
        $this->arqueoId = '';
        //$this->salidas = [];
        //$this->pagoSocios = [];
        $this->movimientos = [];
    }
}
