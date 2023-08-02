<div>
    @if (count($detalle)>0)
      <table class="table table-sm">
        <thead style="background-color: #d8dfe6;">
          <tr>
            <th scope="col" class="text-center">Producto</th>
            <th scope="col" class="text-center">Unid.</th>
            <th scope="col" class="text-center">Precio</th>
            <th scope="col" class="text-center">Cantidad</th>
            <th scope="col" class="text-center">Monto recup.</th>
            <th scope="col" class="text-center">Importe</th>
            <th scope="col" class="text-center"></th>
          </tr>
        </thead>
        <tbody>
          @php
            $subtotal = 0;
        @endphp
        @foreach ($detalle as $det)
        @php
            $importe = $det->precio_compra * $det->cantidad;
            $subtotal = $subtotal + $importe;
        @endphp
            <tr>
              <td class="text-center">{{$det->nombre}}</td>
              <td class="text-center">{{$det->unidad_medida}} [x{{$det->cantidad_unidad}}]</td>
              <td class="text-center">{{number_format($det->precio_compra,2)}}</td>
              <td class="text-center">{{$det->cantidad}}</td>
              <td class="text-center">{{number_format($det->cantidad_recuperada,2)}}</td>
              <td class="text-center">{{number_format($importe,2)}}</td>
              <td width="50px">
                <a href="#" wire:click.prevent="eliminarDetalle({{$det->id}})" style="color: rgb(182, 8, 8)">
                  <i class="fa fa-trash" aria-hidden="true"></i>
                </a>
                
                
              </td>
            </tr>
          @endforeach
          <tr>
            <td colspan="4">
            </td>
            <td class="text-center"><strong style="font-weight: 600">Total :</strong></td>
            <td class="text-center"><span class="badge badge-info" style="font-size: 95%"> S/. {{number_format($subtotal,2)}}</span></td>
          </tr>
        </tbody>
      </table>
      
    @endif
  </div>