<?php

namespace App\Http\Livewire\Caja;

use App\Models\Arqueo;
use App\Models\Movimiento;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CajaCierre extends Component
{
    public function render(Request $request)
    {   
        if (!$request->session()->has('arqueo')) {
            $arqueo = Arqueo::where('estado','=','1')
                    ->where('estado_recibido','=','1')
                    ->where('usuario_id','=',auth()->user()->id)
                    ->pluck('id');
            if (count($arqueo)) {
                session(['arqueo' => $arqueo[0]]);
            }
        }
        $aperturas = DB::table('arqueos as a')
                            ->join('cajas as c','a.caja_id','=','c.id')
                            ->where('a.estado','=','1')
                            ->where('a.usuario_id','=',auth()->user()->id)
                            ->select('c.nombre','a.id','a.fecha_apertura','a.fecha_cierre','a.monto_apertura','a.monto_cierre','total_ventas')
                            ->get();
        return view('livewire.caja.caja-cierre',compact('aperturas'));
    }

    public function totalVentas($id){
        $fecha = new DateTime();
        $fecha = $fecha->format("Y-m-d H:i:s");
        $ventas = DB::table('ventas as v')
                    ->join('venta_detalles as vd', 'vd.venta_id','=','v.id')
                    ->selectRaw('SUM(ROUND(vd.cantidad * vd.precio - coalesce(vd.descuento, 0))) AS total')
                    //->selectRaw('SUM(ROUND(coalesce(vd.cantidad * vd.precio - vd.descuento,0))) AS total')
                    ->where('v.estado','=','1')
                    ->where('v.arqueo_id','=',$id)
                    //->groupBy('total')
                    ->pluck('total');
        //ddd($ventas);


        $movimientos = Movimiento::where('estado','=','1')
                                    ->where('arqueo_id','=',$id)
                                    ->selectRaw("SUM(CASE WHEN tipo_movimiento = 'I' THEN monto ELSE 0 END) AS ingreso, ".
                                    "SUM(CASE WHEN tipo_movimiento = 'E' THEN monto ELSE 0 END) AS gasto")
                                    ->get();
        //dd($movimiento[0]->gasto);

        $total = $ventas[0] + $movimientos[0]->ingreso - $movimientos[0]->gasto;
        return floatval($total);

    }

    public function cerrarCaja(Request $request){
        $fecha = new DateTime();
        $fecha = $fecha->format("Y-m-d H:i:s");
        $total_ventas = $this->totalVentas($request->session()->get('arqueo'));
        
        Arqueo::find($request->session()->get('arqueo'))->update([
            'fecha_cierre' => $fecha,
            'total_ventas' => $total_ventas,
            'estado'=>'0'
        ]);
        $request->session()->forget('arqueo');
        $this->dispatchBrowserEvent('toastr',['message'=>'Caja cerrada.']);
        Auth::logout();
        redirect()->route('login');


    }
}
