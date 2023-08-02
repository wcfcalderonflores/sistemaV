<div>
    <div class="card">
        <div class="card-body" style="padding-bottom: 0px;">
            <form wire:submit.prevent="listarArqueos">
                <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Desde</label>
                    <input type="date" wire:model.defer="data.desde" class="form-control{{($errors->has('desde') ? ' is-invalid' : null)}}" name="desde"/>
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
                    <label>Usuario</label>
                    <select name="usuario" wire:model.defer="data.usuario" class="form-control py-1">
                        @foreach ($usuarios as $index=>$usuario)
                        <option  value="{{$index}}">{{$usuario}}</option>
                        @endforeach
                        
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <button type="submit" class="btn btn-primary btn-block" style="padding: 9px;margin-top:25px;">Buscar</button>
                </div>
                </div>
            </form>

        @if (!$resultados)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Sin resultados
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        </div>

        <div class="row p-1">
            <div class="col-md-12 mr-3 table-responsive-sm">
              @if (count($arqueos)>0)
              <table class="table table-sm" >
                <thead style="background-color: #343a40;">
                  <tr style="background-color: bisque;">
                    <th scope="col" class="text-center" colspan="9">
                      Reporte {{date("d/m/Y", strtotime($data['desde']))}} - {{date("d/m/Y", strtotime($data['hasta']))}}
                    </th>
                  </tr>
                  <tr style="color: white">
                    <th scope="col">#</th>
                    <th scope="col" class="text-center">VENDEDOR</th>
                    <th scope="col" class="text-center">FECHA APERTURA</th>
                    <th scope="col" class="text-center">FECHA CIERRE</th>
                    <th scope="col" class="text-center">MONTO APERTURA</th>
                    <th scope="col" class="text-center">TOTAL VENTAS</th>
                  </tr>
                </thead>
                <tbody>
                  @php($suma_total = 0)
                  @foreach ($arqueos as $index=> $arqueo)
                    @php($suma_total = $suma_total + $arqueo->total_ventas)
                    <tr>
                      <td>{{$index+1}}</td>
                      <td class="text-center">{{$arqueo->name}}</td>
                      <td class="text-center">{{date("d/m/Y h:i:A", strtotime($arqueo->fecha_apertura))}}</td>
                      <td class="text-center">{{date("d/m/Y h:i:A", strtotime($arqueo->fecha_cierre))}}</td>
                      <td class="text-center">{{number_format($arqueo->monto_apertura,2)}}</td>
                      <td class="text-center">{{number_format($arqueo->total_ventas,2)}}</td>
                    </tr> 
                  @endforeach
                    <tr>
                      <td colspan="4" ></td>
                      <td class="text-center">Total Facturado :</td>
                      <td class="text-center"><span class="badge badge-info" style="font-size: 95%"> S/. {{number_format($suma_total,2)}}</span></td>
                    </tr>
                </tbody>
              </table>   
              @endif
              
            </div>
          
          </div>
    </div>
</div>
