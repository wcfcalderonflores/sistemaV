<div>
    @php
        $existe = count($aperturas);
    @endphp
    <div class="card">
        <div class="card-body" style="padding-bottom: 0px;">
          <form wire:submit.prevent="aperturarCaja">
            <div class="form-row">
              <div class="form-group col-md-3">
                <label>Caja</label>
                <select name="caja" {{$existe>0 ? 'disabled' : ''}} wire:model.defer="data.caja" class="form-control{{($errors->has('caja') ? ' is-invalid' : null)}} py-1" >
                    @foreach ($cajas as $index=>$caja)
                        <option value="{{$index}}">{{$caja}}</option>
                    @endforeach
                    
                </select>
                @error('caja')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
              <div class="form-group col-md-3">
                <label>Monto inicial</label>
                <input type="number" step="0.01" {{$existe>0 ? 'disabled' : ''}} wire:model.defer="data.monto_apertura" class="form-control{{($errors->has('monto_apertura') ? ' is-invalid' : null)}}" name="monto_apertura">
                @error('monto_apertura')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
              <div class="form-group col-md-3">
                <label>Usuario</label>
                <input type="input" value="{{auth()->user()->name}}" disabled  class="form-control{{($errors->has('usuario') ? ' is-invalid' : null)}}" name="usuario"/>
                @error('usuario')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
              <div class="form-group col-md-3">
                <button type="submit" {{$existe>0 ? 'disabled' : ''}} class="btn btn-primary btn-block" style="padding: 9px;margin-top:25px;">Aperturar</button>
              </div>
            </div>
          </form>
        </div>
        <div class="row p-1">
            <div class="col-md-12 mr-3 table-responsive-sm">
              @if ($existe>0)
              <table class="table table-sm" >
                <thead style="background-color: #d8dfe6;">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="text-center">CAJA</th>
                    <th scope="col" class="text-center">FECHA APERTURA</th>
                    <th scope="col" class="text-center">FECHA CIERRE</th>
                    <th scope="col" class="text-center">MONTO APERTURA</th>
                    <th scope="col" class="text-center">MONTO CIERRE</th>
                    <th scope="col" class="text-center">TOTAL VENTAS</th>
                    <th scope="col" class="text-center">ESTADO CAJA</th>
                    <th scope="col" class="text-center">ESTADO RECIBIDO</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($aperturas as $index=> $apertura)
                    <tr>
                      <td>{{$index+1}}</td>
                      <td class="text-center">{{$apertura->nombre}}</td>
                      <td class="text-center">{{date("d/m/Y h:i:A",strtotime($apertura->fecha_apertura))}}</td>
                      <td class="text-center">{{$apertura->fecha_cierre ? date("d/m/Y h:i:A",strtotime($apertura->fecha_cierre)) : ''}}</td>
                      <td class="text-center">{{number_format($apertura->monto_apertura,2)}}</td>
                      <td class="text-center">{{$apertura->monto_cierre ? number_format($apertura->monto_cierre,2) : ''}}</td>
                      <td class="text-center">{{$apertura->total_ventas ? number_format($apertura->total_ventas,2) : ''}}</td>
                      <td class="text-center"><span class="badge badge-{{$apertura->estado == '1' ? 'success' : 'danger'}}">{{$apertura->estado == '1' ? 'APERTURADO' : 'CERRADO'}}</span></td>
                      <td class="text-center"><span class="badge badge-{{$apertura->estado_recibido == '1' ? 'success' : 'danger'}}">{{$apertura->estado_recibido == '1' ? 'SIN RECIBIR' : 'RECIBIDO'}}</span></td>
                    </tr> 
                  @endforeach
                </tbody>
              </table>   
              @endif
            </div>
        </div>
    </div>
</div>
