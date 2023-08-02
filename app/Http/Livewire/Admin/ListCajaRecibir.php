<?php

namespace App\Http\Livewire\Admin;

use App\Models\Arqueo;
use App\Models\Movimiento;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListCajaRecibir extends Component
{   
    public $userId = "";
    public $pintar=false;
    public function render()
    {   $usuarios = User::all()->pluck('name','id');
        $usuarios = $usuarios->prepend('--Sin seleccionar--',null);
        if ($this->userId != '') {
            $aperturas = DB::table('arqueos as a')
                                ->join('cajas as c','a.caja_id','=','c.id')
                                ->where('a.estado_recibido','=','1')
                                ->where('a.usuario_id','=',$this->userId)
                                ->select('c.nombre','a.id','a.fecha_apertura','a.fecha_cierre','a.monto_apertura','a.monto_cierre','a.total_ventas','a.estado','a.estado_recibido')
                                ->get();
            if (count($aperturas)==0) {
                $this->emit('limpiar');
            }
        }else {
            $aperturas = [];
            $this->emit('limpiar');
            //$this->emit('mostrar','');
        }
        
        return view('livewire.admin.list-caja-recibir', compact('aperturas','usuarios'));
    }

    public function totalVentas($id){
        $fecha = new DateTime();
        $fecha = $fecha->format("Y-m-d H:i:s");
        $ventas = DB::table('ventas as v')
                    ->join('venta_detalles as vd', 'vd.venta_id','=','v.id')
                    //->selectRaw("ifnull(SUM(ROUND(coalesce(vd.cantidad * vd.precio,0),2)),0) AS total")
                    ->selectRaw("SUM(ROUND(cast(vd.cantidad * vd.precio as numeric),2)) AS total")
                    ->where('v.estado','=','1')
                    ->where('v.arqueo_id','=',$id)
                    ->pluck('total');
        
        $movimiento = Movimiento::where('arqueo_id','=',$id)
                                    ->where('estado','=','1')
                                    ->selectRaw("SUM(CASE WHEN tipo_movimiento = 'I' THEN monto ELSE 0 END) AS ingreso, ".
                                    "SUM(CASE WHEN tipo_movimiento = 'E' THEN monto ELSE 0 END) AS gasto")
                                    ->get();
        //dd($movimiento[0]->gasto);

        $total = $ventas[0] + $movimiento[0]->ingreso - $movimiento[0]->gasto;
        return floatval($total);

    }

    public function listCaja($id){
        $this->userId = $id;
        $this->pintar = true;
    }
    public function movimiento($id){
        $this->emit('mostrar',$id);
        //$this->emit('limpiar');
    }
    public function recibirCaja($id){
        $total_ventas = $this->totalVentas($id);
        Arqueo::find($id)->update([
            'estado_recibido' => '0',
            'usuario_recibio' => auth()->user()->id,
            'total_ventas' => $total_ventas,
        ]);
        $this->emit('limpiar');
    }
}
