<div>
    @if (count($detalle)>0)
      <table class="table table-sm">
        <thead style="background-color: #d8dfe6;">
          <tr>
            <th scope="col" class="text-center">Producto</th>
            <th scope="col" class="text-center">Unid.</th>
            <th scope="col" class="text-center">Cantidad</th>
            <th scope="col" class="text-center">Precio</th>
            <th scope="col" class="text-center">Precio Compra</th>
            <th scope="col" class="text-center">Precio Venta</th>
            <th scope="col" class="text-right">Importe</th>
            <th scope="col" class="text-center"></th>
          </tr>
        </thead>
        <tbody>
          @php
            $subtotal = 0;
        @endphp
        @foreach ($detalle as $det)
        @php
            $importe = $det->precio * $det->cantidad;
            $subtotal = $subtotal + $importe;
        @endphp
            <tr>
              <td class="text-center">
                
                <a style="color: #14263a" wire:click="$emit('modalConfigurarPrecio',{{$det->producto_id}})" href="#"><i class="fa fa-calculator" aria-hidden="true"></i></a>
                {{$det->nombre}}
              </td>
              <td class="text-center">{{$det->unidad_medida}}</td>
              <td class="text-center">{{$det->cantidad}}</td>
              <td class="text-center">{{number_format($det->precio,2)}}</td>
              <td class="text-center">{{number_format($det->precio_compra,2)}} | <span class="badge badge-warning" style="font-size: 95%">{{number_format($det->precio_compra2,2)}}</span></td>
              <td class="text-center">{{$det->precio_venta}}</td>
              <td class="text-right">{{number_format($importe,2)}}</td>
              <td width="10px"><a href="#" wire:click.prevent="eliminarDetalle({{$det->id}})" style="color: red"><i class="fa fa-times" aria-hidden="true"></i></a></td>
            </tr>
          @endforeach
          <tr>
            <td colspan="5">
            </td>
            <td class="text-right">SUB TOTAL :</td>
            <td class="text-right">S/. {{number_format($subtotal,2)}}</td>
          </tr>
          
          @php
            $valor_igv = 0;
              if($igv){
                $valor_igv = ($igv_porcentaje/100) * $subtotal;
              }
          @endphp
          @if ($igv)
          <tr>
            <td colspan="5">
            </td>
            <td class="text-right">IGV({{$igv_porcentaje}}%) :</td>
            <td class="text-right">S/. {{number_format($valor_igv,2)}}</td>
          </tr> 
          @endif
          <tr>
            <td colspan="5">
            </td>
            <td class="text-right">TOTAL :</td>
            <td class="text-right"><span class="badge badge-info" style="font-size: 95%"> S/. {{number_format( ($subtotal + $valor_igv),2)}}</span></td>
          </tr>
        </tbody>
      </table>
      
    @endif
      
  </div>
  