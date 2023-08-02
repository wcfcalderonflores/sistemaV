<?php

namespace App\Http\Livewire\Venta;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Reporte extends Component
{   
    public $desde;
    public $hasta;
    public $pintar;
    public $resultado = [];
    public function render()
    {   
        if ($this->pintar) {
            $this->resultado = DB::table('ventas as v')
                                ->join('venta_detalles as vd', 'vd.venta_id','=','v.id')
                                ->join('personas as p','p.id','=','v.cliente_id')
                                ->join('comprobante_configs as cc','v.comprobante_config_id','=','cc.id')
                                ->select('v.id','cc.serie','cc.numero_maximo','v.numero_comprobante','p.nombre','p.apellido_paterno','p.apellido_materno','v.fecha', DB::raw('sum(vd.cantidad * vd.precio) as total_venta ,sum(coalesce(vd.descuento,0)) as descuento'))
                                ->whereBetween(DB::raw('date(v.fecha)'),[$this->desde,$this->hasta])
                                ->groupBy('v.id','cc.serie','cc.numero_maximo','v.numero_comprobante','p.nombre','p.apellido_paterno','p.apellido_materno','v.fecha')
                                ->orderBy('v.fecha')
                                ->get();
            //ddd($this->resultado);
        }
        return view('livewire.venta.reporte');
    }
    public function listarVentas(){
        //dd($this->data);
        $this->validate([
            'desde' => 'required',
            'hasta' => 'required'
        ]);
        $this->pintar = true;
    }
    public function verComprobante($id){
        $ruta = route('venta.show',$id);
        $this->dispatchBrowserEvent('show-form',$ruta);
    }

    public function enviarSunat($id){
        $emisor = array(
            'tipodoc'                   =>  '6',
            'ruc'                       =>  '20123456789',
            'razon_social'              =>  'CETI ORG',
            'nombre_comercial'          =>  'CETI',
            'direccion'                 =>  'VIRTUAL',
            'ubigeo'                    =>  '130101',
            'departamento'              =>  'LAMBAYEQUE',
            'provincia'                 =>  'CHICLAYO',
            'distrito'                  =>  'CHICLAYO',
            'pais'                      =>  'PE',
            'usuario_secundario'        =>  'MODDATOS',
            'clave_usuario_secundario'  =>  'MODDATOS'
        );
        
        $cliente = array(
            'tipodoc'                   =>  '6',
            'ruc'                       =>  '10123456789',
            'razon_social'              =>  'CLIENTE DE PRUEBA',
            'direccion'                 =>  'VIRTUAL',
            'pais'                      =>  'PE'
        );
        
        $comprobante = array(
            'tipodoc'                   =>  '01',
            'serie'                     =>  'F001',
            'correlativo'               =>  124,
            'fecha_emision'             =>  date('Y-m-d'),
            'hora'                      =>  '00:00:00',
            'fecha_vencimiento'         =>  date('Y-m-d'),
            'moneda'                    =>  'PEN', //PEN: SOLES, USD: DOLARES
            'total_opgravadas'          =>  0,
            'total_opexoneradas'        =>  0,
            'total_opinafectas'         =>  0,
            'total_impbolsas'           =>  0,
            'igv'                       =>  0,
            'total'                     =>  0,
            'total_texto'               =>  '',
        
            'forma_pago'                =>  'Credito',
            'monto_pendiente'           =>  100
        );
        
        $cuotas = array(
            array(
                'cuota'                 =>  'Cuota001',
                'monto'                 =>  50,
                'fecha'                 =>  '2022-03-12'
            ),
            array(
                'cuota'                 =>  'Cuota002',
                'monto'                 =>  50,
                'fecha'                 =>  '2022-04-12'
            ),
        );
        
        $detalle = array(
            array(
                'item'                  =>  1,
                'codigo'                =>  'COD001',
                'descripcion'           =>  'BICICLETA GOLIAT SIERRA 29',
                'cantidad'              =>  1,
                'valor_unitario'        =>  1016.95, //No incluye IGV
                'precio_unitario'       =>  1200, //incluye IGV=18%
                'tipo_precio'           =>  '01', //catalogo nro 16
                'igv'                   =>  183.05,
                'porcentaje_igv'        =>  18,
                'valor_total'           =>  1016.95, //cantidad * valor unitario
                'importe_total'         =>  1200, //cantidad * precio unitario
                'unidad'                =>  'NIU',
                'tipo_afectacion_igv'   =>  '10', //10:gravadas, 20; exoneradas, 30: inafectas
                'codigo_tipo_tributo'   =>  '1000',
                'tipo_tributo'          =>  'VAT',
                'nombre_tributo'        =>  'IGV',
                'bolsa_plastica'        =>  'NO'
            ),
            array(
                'item'                  =>  2,
                'codigo'                =>  'COD002',
                'descripcion'           =>  'LIBRO MATEMATICA',
                'cantidad'              =>  2,
                'valor_unitario'        =>  120, //No incluye IGV
                'precio_unitario'       =>  120, //incluye IGV=18%
                'tipo_precio'           =>  '01', //catalogo nro 16
                'igv'                   =>  0,
                'porcentaje_igv'        =>  18,
                'valor_total'           =>  240, //cantidad * valor unitario
                'importe_total'         =>  240, //cantidad * precio unitario
                'unidad'                =>  'NIU',
                'tipo_afectacion_igv'   =>  '20', //10:gravadas, 20; exoneradas, 30: inafectas
                'codigo_tipo_tributo'   =>  '9997',
                'tipo_tributo'          =>  'VAT',
                'nombre_tributo'        =>  'EXO',
                'bolsa_plastica'        =>  'NO'
            ),
            array(
                'item'                  =>  3,
                'codigo'                =>  'COD003',
                'descripcion'           =>  'SANDIA',
                'cantidad'              =>  1,
                'valor_unitario'        =>  8, //No incluye IGV
                'precio_unitario'       =>  8, //incluye IGV=18%
                'tipo_precio'           =>  '01', //catalogo nro 16
                'igv'                   =>  0,
                'porcentaje_igv'        =>  18,
                'valor_total'           =>  8, //cantidad * valor unitario
                'importe_total'         =>  8, //cantidad * precio unitario
                'unidad'                =>  'NIU',
                'tipo_afectacion_igv'   =>  '30', //10:gravadas, 20; exoneradas, 30: inafectas
                'codigo_tipo_tributo'   =>  '9998',
                'tipo_tributo'          =>  'FRE',
                'nombre_tributo'        =>  'INA',
                'bolsa_plastica'        =>  'NO'
            ),
            array(
                'item'                  =>  4,
                'codigo'                =>  'CODBOL',
                'descripcion'           =>  'BOLSA PLASTICA',
                'cantidad'              =>  4,
                'valor_unitario'        =>  0.04, //No incluye IGV
                'precio_unitario'       =>  0.05, //incluye IGV=18%
                'tipo_precio'           =>  '01', //catalogo nro 16
                'igv'                   =>  0.04,
                'porcentaje_igv'        =>  18,
                'valor_total'           =>  0.16, //cantidad * valor unitario
                'importe_total'         =>  0.20, //cantidad * precio unitario
                'unidad'                =>  'NIU',
                'tipo_afectacion_igv'   =>  '10', //10:gravadas, 20; exoneradas, 30: inafectas
                'codigo_tipo_tributo'   =>  '1000',
                'tipo_tributo'          =>  'VAT',
                'nombre_tributo'        =>  'IGV',
                'bolsa_plastica'        =>  'SI'
            )
        );
        
        //inicializar totales
        $total_opgravadas = 0;
        $total_opexoneradas = 0;
        $total_opinafectas = 0;
        $total_impbolsas = 0;
        $igv = 0;
        $total = 0;
        
        foreach ($detalle as $key => $value) {
            if($value['tipo_afectacion_igv'] == 10)
            {
                $total_opgravadas += $value['valor_total'];
            }
        
            if($value['tipo_afectacion_igv'] == 20)
            {
                $total_opexoneradas += $value['valor_total'];
            }
        
            if($value['tipo_afectacion_igv'] == 30)
            {
                $total_opinafectas += $value['valor_total'];
            }
        
            if ($value['bolsa_plastica'] == 'SI') {
                $total_impbolsas += $value['cantidad']*0.40; //el valor de 0.40 corresponde al año 2022
            }
        
            $igv += $value['igv'];
            $total += $value['importe_total'] + $total_impbolsas;
        }
        
        $comprobante['total_opgravadas'] = $total_opgravadas;
        $comprobante['total_opexonerdas'] = $total_opexoneradas;
        $comprobante['total_opinafectas'] = $total_opinafectas;
        $comprobante['igv'] = $igv;
        $comprobante['total'] = $total;
        $comprobante['total_impbolsas'] = $total_impbolsas;
        
        require_once('cantidad_en_letras.php');
       // $comprobante['total_texto'] = CantidadEnLetra($total);
    }
}
