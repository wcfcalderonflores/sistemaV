<div class="modal fade bd-example" id="mostrarAjuste" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">REFERENCIA [{{$referencia}}]</h5>
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
            <th scope="col" class="text-center">P. Compra</th>
            <th scope="col" class="text-right">Importe</th>
            <th scope="col" class="text-right">Cant. Recup</th>
          </tr>
        </thead>
        <tbody>
          @php
            $total = 0;
            $total_recuperado = 0;
        @endphp
        @foreach ($detalle as $det)
        @php
            $importe = $det->precio_compra * $det->cantidad;
            $total = $total + $importe;
            $total_recuperado = $total_recuperado + $det->cantidad_recuperada
        @endphp
            <tr>
              <td class="text-center">{{$det->nombre}}</td>
              <td class="text-center">{{$det->abreviatura}} X [{{$det->cantidad_unidad}}]</td>
              <td class="text-center">{{$det->cantidad}}</td>
              <td class="text-center">{{number_format($det->precio_compra,2)}}</td>
              <td class="text-right">{{number_format($importe,2)}}</td>
              <td class="text-right">{{number_format($det->cantidad_recuperada,2)}}</td>
            </tr>
          @endforeach
          <tr>
            <td colspan="3"></td>
            <td>Totales:</td>
            <td class="text-right"><span class="badge badge-info" style="font-size: 95%"> S/.{{number_format($total,2)}}</span></td>
            <td class="text-right"><span class="badge badge-success" style="font-size: 95%"> S/.{{number_format($total_recuperado,2)}}</span></td>
          </tr>
          <tr>
            <td colspan="3"></td>
            <td>Pérdida:</td>
            @php($perdida_total = $total - $total_recuperado)
            <td colspan="2"><span class="badge badge-{{$perdida_total > 0 ? 'danger' : 'info'}}" style="font-size: 95%"> {{number_format($perdida_total,2)}}</span></td>
          </tr>
        </tbody>
      </table>
      
    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
