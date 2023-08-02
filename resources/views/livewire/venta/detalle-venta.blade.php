<div>
    @if (count($detalle)>0)
      <table class="table table-sm">
        <thead style="background-color: #d8dfe6;">
          <tr>
            <th scope="col" class="text-center">Producto</th>
            <th scope="col" class="text-center">Unid.</th>
            <th scope="col" class="text-center">Precio</th>
            <th scope="col" class="text-center">Cantidad</th>
            <th scope="col" class="text-center">Descuento</th>
            <th scope="col" class="text-center">Importe</th>
            <th scope="col" class="text-center"></th>
          </tr>
        </thead>
        <tbody>
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
              <td class="text-center">{{$det->nombre}}</td>
              <td class="text-center">{{$det->unidad_medida}}</td>
              <td class="text-center">{{number_format($det->precio,2)}}</td>
              <td class="text-center">{{$det->cantidad}}</td>
              <td class="text-center"><a href="#" wire:click="agregarDescuento({{$det->id}},'{{$det->nombre}}')">{{number_format($det->descuento,2)}}</a></td>
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
            <td class="text-center"><strong style="font-weight: 600">Total Valor Venta :</strong></td>
            <td class="text-center"><span class="badge badge-secondary" style="font-size: 95%"> S/. {{number_format($subtotal,2)}}</span></td>
          </tr>
          <tr>
            <td colspan="4">
            </td>
            <td class="text-center"><strong style="font-weight: 600">Descuentos :</strong></td>
            <td class="text-center"><span class="badge badge-secondary" style="font-size: 95%"> S/. {{number_format($descuentos,2)}}</span></td>
          </tr>
          <tr>
            <td colspan="4">
            </td>
            <td class="text-center"><strong style="font-weight: 600">Total :</strong></td>
            <td class="text-center"><span class="badge badge-info" style="font-size: 95%"> S/. {{number_format($subtotal - $descuentos,2)}}</span></td>
          </tr>
        </tbody>
      </table>
      
    @endif

    <!-- Modal descuento -->
    <div class="modal fade" id="modalDescuento" tabindex="-1" role="dialog" aria-labelledby="modalDescuento" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background: currentColor">
            <h5 class="modal-title" id="modalDescuento" style="color: #f2f2f2">{{$producto}}</h5>
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true" style="color:aliceblue">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="form-group">
                  {!! Form::label('CLI','Descuento') !!}
                  {!! Form::Number('descuento_producto', null, ['class'=> 'form-control'.($errors->has('precio_venta') ? ' is-invalid' : null),'step'=>'any','autocomplete'=>'off','placeholder'=>'Ingrese descuento','wire:model.defer'=>"descuento_producto"]) !!}
              </div>
              <div class="modal-footer">
                  <a ref="#" class= "btn btn-primary" wire:click="registrarDescuento">Registrar</a>
              </div>
          </div>
        </div>
      </div>
    </div>
      
  </div>