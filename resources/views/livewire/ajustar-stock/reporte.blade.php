<div>
    <div class="card">
      <div class="card-body" style="padding-bottom: 0px;">
        <form wire:submit.prevent="listarAjustes">
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
                <th scope="col" class="text-center">REFERENCIA</th>
                <th scope="col" class="text-center">T. AJUSTE</th>
                <th scope="col" class="text-center">FECHA</th>
                <th scope="col" class="text-center">USUARIO</th>
                <th scope="col" class="text-center">CANT. PERDIDA</th>
                <th scope="col" class="text-center">CANT. RECUPERADA</th>
                <th scope="col" class="text-center"></th>
              </tr>
            </thead>
            <tbody>
              @php($total_perdido = 0)
              @php($total_recuperado = 0)
              @foreach ($resultado as $index=> $resultado)
                @php($total_perdido = $total_perdido+$resultado->cantidad_perdida)
                @php($total_recuperado = $total_recuperado+$resultado->cantidad_recuperada)
                
                
                <tr>
                  <td>{{$index+1}}</td>
                  <td class="text-center">
                    <a href="#" wire:click.prevent="verAjuste({{$resultado->id}},'{{$resultado->referencia}}')">
                     {{$resultado->referencia}}
                    </a>
                  </td>
                  <td class="text-center">{{$resultado->tipo_ajuste == '1' ? 'Vencimiento' : ($resultado->tipo_ajuste == '2' ? 'Pérdida' :'Otro')}}</td>
                  <td class="text-center">{{date("d/m/Y", strtotime( $resultado->created_at))}}</td>
                  <td class="text-center">{{$resultado->nombre}} {{$resultado->apellido_paterno}} {{$resultado->apellido_materno}}</td>
                  <td class="text-center">{{number_format($resultado->cantidad_perdida, 2)}}</td>
                  <td class="text-center">{{number_format($resultado->cantidad_recuperada, 2)}}</td>
                  
                  
                  
                  <!--td>
                    <a href="#" class="text-danger" style="margin-right: 8px" wire:click="$emit('confirmar',{{$resultado->id}},'Desea anular compra??','1')">
                      <i class="fa fa-window-close" aria-hidden="true"></i>
                    </a>
                    <a href="#" >
                      <i class="fa fa-eraser" aria-hidden="true" wire:click="$emit('confirmar',{{$resultado->id}},'Desea editar compra??','2')"></i>
                    </a>
                  </td-->
                </tr> 
              @endforeach
                <tr>
                    <td colspan="4"></td>
                    <td class="text-center">Totales:</td>
                    <td class="text-center"><span class="badge badge-info" style="font-size: 95%"> {{number_format($total_perdido,2)}}</span></td>
                    <td class="text-center"><span class="badge badge-info" style="font-size: 95%"> {{number_format($total_recuperado,2)}}</span></td>
                </tr>
                @php($perdida_total = $total_perdido - $total_recuperado)
                <tr>
                  <td colspan="4"></td>
                  <td class="text-center">Pérdida Total:</td>
                  <td></td>
                  <td class="text-center"><span class="badge badge-{{$perdida_total > 0 ? 'danger' : 'info'}}" style="font-size: 95%"> {{number_format($perdida_total,2)}}</span></td>
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
@livewire('modals.mostrar-ajuste')