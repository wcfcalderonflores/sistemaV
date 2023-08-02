<?php

namespace App\Http\Livewire\Movimiento;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ReporteMovimiento extends Component
{   
    public $data;
    public $movimientos;
    public function mount(){
        $this->data=[
            'tipo_movimiento' => ''
        ];

        $this->movimientos=[];
        $this->resultados = true;
    }
    public function render()
    {   
        if(count($this->data)>1){ 

            $query = DB::table('movimientos as m')
                        ->join('users as u','m.user_id','=','u.id');
            $this->data['tipo_movimiento']!='' ? $query->where('m.tipo_movimiento','=',$this->data['tipo_movimiento']):'';
            $query = $query->whereBetween(DB::raw('date(m.created_at)'),[$this->data['desde'],$this->data['hasta']]);
            $this->movimientos = $query->select('m.tipo_movimiento','m.descripcion','m.monto','u.name','m.created_at')
                                    ->orderBy('m.created_at')
                                    ->get();
            if(count($this->movimientos)==0)
                $this->dispatchBrowserEvent('toastr',['message'=>'Sin resultados.']);
        }

        return view('livewire.movimiento.reporte-movimiento');
    }
    public function listarMovimientos(){
        
        $this->resultados = true;
        Validator::make($this->data,[
            'desde' => 'required',
            'hasta' => 'required'
        ])->validate();
        
    }
}
