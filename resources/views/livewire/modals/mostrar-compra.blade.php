<div class="modal fade bd-example" id="mostrarCompra" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">COMPROBANTE [{{$numero_comprobante}}]</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body row col-md-12">
                <div class="col-md-12">
                    @if (count($detalle)>0)
      <table class="table table-sm">
        <thead style="background-color: #d8dfe6;">
          <tr>
            <th scope="col" class="text-center">Producto</th>
            <th scope="col" class="text-center">Unid.</th>
            <th scope="col" class="text-center">Cantidad</th>
            <th scope="col" class="text-center">Precio</th>
            <th scope="col" class="text-right">Importe</th>
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
              <td class="text-center">{{$det->nombre}}</td>
              <td class="text-center">{{$det->unidad_medida}}</td>
              <td class="text-center">{{$det->cantidad}}</td>
              <td class="text-center">{{number_format($det->precio,2)}}</td>
              <td class="text-right">{{number_format($importe,2)}}</td>
            </tr>
          @endforeach
          <tr>
            <td colspan="3">
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
            <td colspan="3">
            </td>
            <td class="text-right">IGV({{$igv_porcentaje}}%) :</td>
            <td class="text-right">S/. {{number_format($valor_igv,2)}}</td>
          </tr> 
          @endif
          <tr>
            <td colspan="3">
            </td>
            <td class="text-right">TOTAL :</td>
            <td class="text-right"><span class="badge badge-info" style="font-size: 95%"> S/. {{number_format( ($subtotal + $valor_igv),2)}}</span></td>
          </tr>
        </tbody>
      </table>
      
    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
