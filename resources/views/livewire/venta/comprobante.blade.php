<style>
    .text-center {
        text-align: center;
    }
    .text-right {
        text-align: right;
    }
    .text-left {
        text-align: left;
    }
    .center {
        margin: auto;
        padding: 10px;
    }
    body {
        font-family: Arial, Helvetica, sans-serif;
    }
    td {
        font-size: 15px;
    }
    .detalle{
        font-size: 14px;
    }
</style>
@php
    require '../vendor/autoload.php';
    use Luecano\NumeroALetras\NumeroALetras;
    $formatter = new NumeroALetras();
@endphp
<div>
@if ($venta)
    

    <table width="320"  cellpadding="0" cellspacing="1" class="center" onclick="window.print()" id="ticket">
        <tr>
            <td class="text-center"><strong> NOMBRE DE LA EMPRESA  SAC<strong></td>
        </tr>
        <tr>
            <td class="text-center">RUC : 12345678958</td>
        </tr>
        <tr>
            <td class="text-center">Av. Victor Raul Haya de la Torre #12345</td>
        </tr>
        <tr>
            <td class="text-center">JAÉN - JAÉN - CAJAMARCA</td>
        </tr>
        <tr>
        <tr>
            <td class="text-center">TEL: 12456789</td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        </tr>
        <tr>
            <td class="text-center"><strong>{{$config->nombre}}</strong></td>
        </tr>
        <tr>
            <td class="text-center">
                {{$config->serie}} - {{str_pad($venta->numero_comprobante,strlen($config->numero_maximo)-strlen($config->numero_comprobante), "0", STR_PAD_LEFT)}} </td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        </tr>
        <tr>
            <td>CLIENTE: {{$persona->nombre}} {{$persona->apellido_paterno}} {{$persona->apellido_materno}}</td>
        </tr>
        <tr>
            <td>DNI CLIENTE: {{$persona->numero_documento}}</td>
        </tr>
        @if ($ubigeo_cliente)
        <tr>
            <td>DIRECCIÓN: {{ucfirst(strtolower($ubigeo_cliente->departamento))}} - {{ucfirst(strtolower($ubigeo_cliente->provincia))}} - {{ucfirst(strtolower($ubigeo_cliente->distrito))}} </td>
        </tr> 
        @endif             

        <tr>
            <td>FECHA: {{date("d/m/Y h:i:A", strtotime( $venta->fecha))}}</td>
        </tr>

    </table>
    <table width="320" class="center">

        <tr>
            <td style="width: 20px" class="text-center detalle"><strong>Producto</strong></td>
            <td style="width: 200px" class="text-center detalle"><strong>Unid.</strong></td>
            <td style="width: 30px" class="text-center detalle"><strong>Precio</strong></td>
            <td style="width: 30px" class="text-center detalle"><strong>Cant.</strong></td>
            <td style="width: 30px" class="text-center detalle"><strong>Desc.</strong></td>
            <td style="width: 30px" class="text-center detalle"><strong>Importe</strong></td>
        </tr>
        <tr>
            <td class="text-center" colspan="6">----------------------------------------------------------</td>
        </tr>
        @php
            $subtotal = 0;
            $descuentos = 0;
        @endphp
       
        @foreach ($detalle as $det)
            @php
                $importe = $det->precio * $det->cantidad;
                $subtotal = $subtotal + $importe;
                $descuentos = $descuentos + $det->descuento;
            @endphp

        <tr>
            <td class="text-center detalle">{{$det->nombre}}</td>
            <td class="text-center detalle">{{$det->unidad_medida}}</td>
            <td class="text-center detalle">{{number_format($det->precio,2)}}</td>
            <td class="text-center detalle">{{$det->cantidad}}</td>
            <td class="text-center detalle">{{number_format($det->descuento,2)}}</td>
            <td class="text-right detalle">{{number_format($importe,2)}}</td>
        </tr>
        @endforeach
        
        <tr>
            <td class="text-center" colspan="6">----------------------------------------------------------</td>
        </tr>
        @php
            $total = $subtotal - $descuentos;
        @endphp
        <tr>
            
            <td class="detalle text-right" colspan="4" >TOTAL VALOR VENTA</td>
            <td class="detalle text-right" colspan="2"><strong>{{number_format($subtotal,2)}}</strong></td>
        </tr>
        <tr>
            
            <td class="detalle text-right" colspan="4" >DESCUENTOS</td>
            <td class="detalle text-right" colspan="2"><strong>{{number_format($descuentos,2)}}</strong></td>
        </tr>
        <tr>
            
            <td class="detalle text-right" colspan="4" >TOTAL</td>
            <td class="detalle text-right" colspan="2"><strong>{{number_format($total,2)}}</strong></td>
        </tr>
        <tr>
            <td colspan="6" height="10"></td>
        </tr>
        <tr>
            <td colspan="6" >SON: {{$formatter->toInvoice($total, 2, 'soles')}}</td>
        </tr>
        <tr>
            <td colspan="6" >FORMA DE PAGO: Contado</td>
        </tr>
        <tr>
            <td height="41" colspan="6">VEND: {{auth()->user()->name}}</td>
        </tr>
        <tr>
         <td colspan="6">DOCUMENTO NO VÁLIDO PARA SUNAT</td>
        </tr>
        <tr>
            <td colspan="6" class="text-center"><p>** GRACIAS POR SU PREFERENCIA **</p></td>
        </tr>

    </table>
@endif
</div>
