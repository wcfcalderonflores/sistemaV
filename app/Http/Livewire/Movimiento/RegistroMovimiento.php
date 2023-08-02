<?php

namespace App\Http\Livewire\Movimiento;

use App\Models\Arqueo;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class RegistroMovimiento extends Component
{   public $salidas=[];
    public $data = [];
    //public $arqueo;

    protected  $listeners = ['eliminar'];
    public function render(Request $request)
    {   
        if (!$request->session()->has('arqueo')) {
            $arqueo = Arqueo::where('estado','=','1')
                    ->where('estado_recibido','=','1')
                    ->pluck('id');
            //dd($arqueo);
            if (count($arqueo)) {
                session(['arqueo' => $arqueo[0]]);
            }
        }
        $movimientos = Movimiento::where('arqueo_id','=',$request->session()->get('arqueo'))
                                    ->get();
        return view('livewire.movimiento.registro-movimiento', compact('movimientos'));
    }

    public function registrarMovimiento(Request $request){

        Validator::make($this->data,[
            'tipo_movimiento' => 'required',
            'monto' => 'required',
            'descripcion' => 'required'            
        ])->validate();
        if ($request->session()->has('arqueo')){
            Movimiento::create([
                'tipo_movimiento' => $this->data['tipo_movimiento'],
                'descripcion' => $this->data['descripcion'],
                'monto' => $this->data['monto'],
                'user_id' => auth()->user()->id,
                'arqueo_id' => $request->session()->get('arqueo'),
            ]);
            $this->dispatchBrowserEvent('toastr',['message'=>'Se registró movimiento']);
        }else{
            $this->dispatchBrowserEvent('toastr-error',['message'=>'Debe aperturar caja']);
        }
        $this->data=[];
    }

    public function eliminar(Movimiento $movi){
        $movi->delete();

    }
}
