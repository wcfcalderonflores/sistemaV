<div>
    <div class="card">
      <div class="card-body" style="padding-bottom: 0px;">
        <form wire:submit.prevent="listarCompras">
          <div class="form-row">
            <div class="form-group col-md-5">
              <label>Desde</label>
              <input type="date" wire:model.defer="desde" class="form-control{{($errors->has('desde') ? ' is-invalid' : null)}}" name="desde"/>
              @error('desde')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
            <div class="form-group col-md-5">
              <label>Hasta</label>
              <input type="date" wire:model.defer="hasta" class="form-control{{($errors->has('hasta') ? ' is-invalid' : null)}}" name="hasta">
              @error('hasta')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
            
            <div class="form-group col-md-2">
              <button type="submit" class="btn btn-primary btn-block" style="padding: 9px;margin-top:25px;">Buscar</button>
            </div>
          </div>
        </form>
      </div>

      <div class="row p-1">
        <div class="col-md-12 mr-3 table-responsive-sm">
          @if (count($resultado)>0)
          <table class="table table-sm" >
            <thead style="background-color: #343a40;">
              <tr style="background-color: bisque;">
                <th scope="col" class="text-center" colspan="9">
                  Reporte {{date("d/m/Y", strtotime($desde))}} - {{date("d/m/Y", strtotime($hasta))}}
                </th>
              </tr>
              <tr style="color: white">
                <th scope="col">#</th>
                <th scope="col" class="text-center">COMPROB.</th>
                <th scope="col" class="text-center">PROVEEDOR</th>
                <th scope="col" class="text-center">FECHA</th>
                <th scope="col" class="text-center">FORMA PAGO</th>
                <th scope="col" class="text-center">TOTAL</th>
                <th scope="col" class="text-center"></th>
              </tr>
            </thead>
            <tbody>
              @php($suma_total = 0)
              @foreach ($resultado as $index=> $resultado)
                @php( $valor_igv = 0)
                @if ($resultado->estado_igv == '1')
                  @php($valor_igv = ($resultado->porcentaje_igv/100) * $resultado->total)
                @endif
                @php($suma_total = $suma_total+$resultado->total + $valor_igv)
                
                
                <tr>
                  <td>{{$index+1}}</td>
                  <td class="text-center">
                    <a href="#" wire:click.prevent="verCompra({{$resultado->id}},'{{$resultado->estado_igv}}',{{$resultado->porcentaje_igv}},'{{$resultado->numero_comprobante}}')">
                     {{$resultado->numero_comprobante}}
                    </a>
                  </td>
                  <td class="text-center">{{$resultado->nombre}} {{$resultado->apellido_paterno}} {{$resultado->apellido_materno}}</td>
                  <td class="text-center">{{date("d/m/Y", strtotime( $resultado->fecha_compra))}}</td>
                  <td class="text-center">{{$resultado->forma_pago == '1' ? 'Contado' : 'Crédito'}}</td>
                  <td class="text-center">{{number_format($resultado->total + $valor_igv,2)}}</td>
                  <td>
                    <a href="#" class="text-danger" style="margin-right: 8px" wire:click="$emit('confirmar',{{$resultado->id}},'Desea anular compra??','1')">
                      <i class="fa fa-window-close" aria-hidden="true"></i>
                    </a>
                    <a href="#" >
                      <i class="fa fa-eraser" aria-hidden="true" wire:click="$emit('confirmar',{{$resultado->id}},'Desea editar compra??','2')"></i>
                    </a>
                  </td>
                </tr> 
              @endforeach
                <tr>
                    <td colspan="4"></td>
                    <td class="text-center">Total Facturado :</td>
                    <td class="text-center"><span class="badge badge-info" style="font-size: 95%"> {{number_format($suma_total,2)}}</span></td>
                    <td></td>
                </tr>
            </tbody>
          </table>
          @else
            @if ($pintar)
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Sin resultados!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div> 
            @endif
              
          @endif
          
        </div>
      
      </div>
    </div>
</div>
@livewire('modals.mostrar-compra')