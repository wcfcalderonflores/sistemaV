<?php

namespace App\Http\Livewire\Caja;

use App\Models\Arqueo;
use App\Models\Caja;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CajaApertura extends Component
{   
    public $data=[];
    public function render()
    {   
        $cajas = Caja::where('estado','=','1')->pluck('nombre','id');
        $cajas = $cajas->prepend('--Seleccione-',null);
        $aperturas = DB::table('arqueos as a')
                            ->join('cajas as c','a.caja_id','=','c.id')
                            ->where('a.estado','=','1')
                            ->orwhere('a.estado_recibido','=','1')
                            ->where('a.usuario_id','=',auth()->user()->id)
                            ->select('c.nombre','a.fecha_apertura','a.fecha_cierre','a.monto_apertura','a.monto_cierre','total_ventas','a.estado','a.estado_recibido')
                            ->get();
                            //ddd("alelll");
        return view('livewire.caja.caja-apertura',compact('cajas','aperturas'));
    }

    public function aperturarCaja(){
        Validator::make($this->data,[
            'caja' => 'required',
            'monto_apertura' => 'required',
        ])->validate();
        $fecha = new DateTime();
        $fecha = $fecha->format("Y-m-d H:i:s");
        $contador = Arqueo::where('usuario_id','=',auth()->user()->id)
                            ->where('estado','=','1')
                            ->orwhere('estado_recibido','=','1')
                            ->get()
                            ->count();
        //dd($contador);
        if ($contador == 0) {
            $arqueo = Arqueo::create([
                'caja_id' => $this->data['caja'],
                'usuario_id' => auth()->user()->id,
                'fecha_apertura' => $fecha,
                'monto_apertura'=>$this->data['monto_apertura'],
            ]);
            //dd("alexloooo");
            session(['arqueo' => $arqueo->id]);
            $this->dispatchBrowserEvent('toastr',['message'=>'Se registro apertura.']);
        }else{
            $this->dispatchBrowserEvent('toastr-error',['message'=>'Tiene caja aperturada o no recibida.']);
        }
        
        

    }
}
