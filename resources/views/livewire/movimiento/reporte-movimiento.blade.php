<div>
    <div class="card">
      <div class="card-body" style="padding-bottom: 0px;">
        <form wire:submit.prevent="listarMovimientos">
          <div class="form-row">
            <div class="form-group col-md-3">
              <label>Desde</label>
              <input type="date" wire:model.defer="data.desde"  class="form-control{{($errors->has('desde') ? ' is-invalid' : null)}}" name="desde"/>
              @error('desde')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
            <div class="form-group col-md-3">
              <label>Hasta</label>
              <input type="date" wire:model.defer="data.hasta" class="form-control{{($errors->has('hasta') ? ' is-invalid' : null)}}" name="hasta">
              @error('hasta')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
            <div class="form-group col-md-3">
              <label>Tipo Movimiento</label>
              <select name="tipo_movimiento" wire:model.defer="data.tipo_movimiento" class="form-control py-1" >
                  <option value="">--Sin seleccionar--</option>
                  <option  value="I" >Ingresos</option>
                  <option  value="E" >Gastos</option>
              </select>
              @error('estado_encomienda')
                  <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
            <div class="form-group col-md-3">
              <button type="submit" class="btn btn-primary btn-block" style="padding: 9px;margin-top:25px;">Buscar</button>
            </div>
          </div>
        </form>
      </div>

      <div class="row p-1">
        <div class="col-md-12 mr-3 table-responsive-sm">
          @if (count($movimientos)>0)
          <table class="table table-sm" >
            <thead style="background-color: #d8dfe6;">
              <tr style="background-color: bisque;">
                <th scope="col" class="text-center" colspan="9">
                  Reporte {{date("d/m/Y", strtotime($data['desde']))}} - {{date("d/m/Y", strtotime($data['hasta']))}}
                </th>
              </tr>
              <tr>
                <th scope="col">#</th>
                <th scope="col" class="text-center">TIPO MOVIMIENTO</th>
                <th scope="col" class="text-center">FECHA</th>
                <th scope="col" class="text-center">USUARIO</th>
                <th scope="col" class="text-center">DESCRIPCIÓN</th>
                <th scope="col" class="text-center">MONTO</th>
              </tr>
            </thead>
            <tbody>
                @php
                  $debe = 0;
                  $pago=0  
                @endphp
              @foreach ($movimientos as $index=> $movimiento)
                @php
                    if($movimiento->tipo_movimiento == 'I'){
                        $pago = $pago + $movimiento->monto;
                    }else{
                        $debe = $debe + $movimiento->monto;
                    }
                @endphp
                <tr>
                    <td>{{$index+1}}</td>
                    <td class="text-center">{{$movimiento->tipo_movimiento == 'I' ? 'Ingreso' : 'Gasto'}}</td>
                    <td class="text-center">{{$movimiento->created_at}}</td>
                    <td class="text-center">{{$movimiento->name}}</td>
                    <td class="text-center">{{$movimiento->descripcion}}</td>
                    <td class="text-center">{{number_format($movimiento->monto,2)}}</td>
                </tr> 
              @endforeach
                <tr>
                  <td colspan="4" ></td>
                  <td class="text-center"><strong> Total Facturado :</strong></td>
                  <td class="text-center"><span class="badge badge-info" style="font-size: 95%"> S/. {{number_format($pago - $debe,2)}}</span></td>
                </tr>
                @if ($data['tipo_movimiento']=='')
                  <tr>
                    <td colspan="4" ></td>
                    <td class="text-center">Total Pagó :</td>
                    <td class="text-center"><span class="badge badge-success" style="font-size: 95%"> S/. {{number_format($pago,2)}}</span></td>
                  </tr>
                  <tr>
                    <td colspan="4" ></td>
                    <td class="text-center">Total Debe :</td>
                    <td class="text-center"><span class="badge badge-danger" style="font-size: 95%"> S/. {{number_format($debe,2)}}</span></td>
                  </tr> 
                @endif
                
            </tbody>
          </table>   
          @endif
          
        </div>
      
      </div>

    </div>
</div>
