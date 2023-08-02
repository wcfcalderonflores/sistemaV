<?php

namespace App\Http\Livewire\Venta;

use App\Models\ComprobanteConfig;
use App\Models\Persona;
use App\Models\Ubigeo;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Comprobante extends Component
{   
    public $venta;
    //protected $formatter;

    public $detalle=[];
    public $persona=[];
    public $ubigeo_cliente=[];
    public $config=[];

    protected $listeners = ['mostrar' => 'mostrar'];
    public function render()
    {   
        if ($this->venta) {
            $this->detalle = DB::table('venta_detalles as vd')
                                ->join('producto_unidads as pu','vd.producto_unidad_id','=','pu.id')
                                ->join('unidad_medidas as um','pu.unidad_medida_id','=','um.id')
                                ->join('productos as p','vd.producto_id','=','p.id')
                                ->select('p.nombre','vd.precio','um.abreviatura as unidad_medida','vd.cantidad','vd.descuento','vd.id')
                                ->where('vd.venta_id','=',$this->venta->id)
                                ->get();
            $this->persona = Persona::find($this->venta->cliente_id, ['nombre','apellido_paterno','apellido_materno','tipo_documento','numero_documento','ubigeo_id']);
            $this->ubigeo_cliente = Ubigeo::find($this->persona->ubigeo_id);
            $this->config = ComprobanteConfig::join('comprobantes','comprobante_configs.comprobante_id','=','comprobantes.id')
                        ->find($this->venta->comprobante_config_id,['comprobantes.nombre','comprobante_configs.serie','comprobante_configs.numero_maximo']);
        }
        return view('livewire.venta.comprobante');
    }

    public function mostrar(Venta $venta){
        $this->venta=$venta;
        
    }
    public function unidad($unidad){

        switch ($unidad) {
            case '01':
                return 'Kg';
                break;
            case '02':
                return 'Lit';
                break;
            case '03':
                return 'Pqt';
                break;
            
            default:
                return 'Unid';
                break;
        }

    }

}
