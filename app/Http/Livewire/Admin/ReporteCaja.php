<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ReporteCaja extends Component
{   
    public $resultados;
    public $arqueos;
    public $data;
    public function mount(){
        $this->data=[
            'usuario' => ''
        ];

        $this->arqueos=[];
        $this->resultados = true;
    }
    public function render()
    {   
        $usuarios = User::all()->pluck('name','id');
        $usuarios = $usuarios->prepend('--Sin seleccionar--',null);
        if(count($this->data)>1){ 
            if($this->data['usuario'] ==''){
                $this->arqueos = DB::table('arqueos as a')
                                    ->join('users as u','a.usuario_id','=','u.id')
                                    ->select(['a.fecha_apertura','a.fecha_cierre','a.monto_apertura','a.monto_cierre','total_ventas','u.name'])
                                    ->where('a.estado','=','0') // caja cerrada
                                    ->where('a.estado_recibido','=','0') // se recibio caja
                                    ->WhereBetween(DB::raw('date(a.fecha_apertura)'),[$this->data['desde'],$this->data['hasta']])
                                    ->orderBy('a.fecha_apertura')
                                    ->get();
            }else{
                $this->arqueos = DB::table('arqueos as a')
                                    ->join('users as u','a.usuario_id','=','u.id')
                                    ->select(['a.fecha_apertura','a.fecha_cierre','a.monto_apertura','a.monto_cierre','total_ventas','u.name'])
                                    ->where('a.estado','=','0') // caja cerrada
                                    ->where('a.estado_recibido','=','0') // se recibio caja
                                    ->where('u.id','=',$this->data['usuario'])
                                    ->WhereBetween(DB::raw('date(a.fecha_apertura)'),[$this->data['desde'],$this->data['hasta']])
                                    ->orderBy('a.fecha_apertura')
                                    ->get();

            }

            //dd($this->arqueos);
                                //ddd($this->data);
            if(count($this->arqueos)==0)
                $this->resultados = false;
        }
        return view('livewire.admin.reporte-caja',compact('usuarios'));
    }

    public function listarArqueos(){
        
        $this->resultados = true;
        Validator::make($this->data,[
            'desde' => 'required',
            'hasta' => 'required'
        ])->validate();
        
    }
}
