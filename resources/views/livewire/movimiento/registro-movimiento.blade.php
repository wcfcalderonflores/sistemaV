<div>
    @if (session()->has('arqueo'))
        <div class="card">
            <div class="card-body" style="padding-bottom: 0px;">
                <form wire:submit.prevent="registrarMovimiento">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Tipo movimiento</label>
                        <select name="tipo_movimiento" wire:model.defer="data.tipo_movimiento" class="form-control py-1 {{($errors->has('tipo_movimiento') ? ' is-invalid' : null)}}" >
                            <option value="">--Sin seleccionar--</option>
                            <option  value="E" >Gasto</option>
                            <option  value="I" >Ingreso</option>
                        </select>
                        @error('tipo_movimiento')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                    <label>Monto</label>
                    <input type="number" step="0.01" wire:model.defer="data.monto"  class="form-control{{($errors->has('monto') ? ' is-invalid' : null)}}" name="monto"/>
                    @error('monto')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                    </div>
                    <div class="form-group col-md-4">
                    <label>Descripción</label>
                    <textarea name="descripcion" wire:model.defer="data.descripcion" class="form-control{{($errors->has('descripcion') ? ' is-invalid' : null)}}"></textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                    </div>
                    
                    <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-primary btn-block" style="padding: 9px;margin-top:25px;">Registrar</button>
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
                    </tr>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="text-center">T. MOVIMIENTO</th>
                        <th scope="col" class="text-center">DESCRIPCION</th>
                        <th scope="col" class="text-center">MONTO</th>
                        <th scope="col" class="text-center"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                        $gasto    = 0;
                        $ingreso  = 0  
                        @endphp
                    @foreach ($movimientos as $index=> $movimiento)
                        @php
                            if($movimiento->tipo_movimiento == 'E'){
                                $gasto = $gasto + $movimiento->monto;
                            }else{
                                $ingreso = $ingreso + $movimiento->monto;
                            }
                        @endphp
                        <tr>
                            <td>{{$index+1}}</td>
                            <td class="text-center">{{$movimiento->tipo_movimiento == 'I' ? 'Ingreso' : 'Gasto'}}</td>
                            <td class="text-center">{{$movimiento->descripcion}}</td>
                            <td class="text-center">{{number_format($movimiento->monto,2)}}</td>
                            <td class="text-center">
                                <a ref="#" wire:click="$emit('messageEliminar',{{$movimiento}})" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr> 
                    @endforeach
                        <tr>
                            <td colspan="2" ></td>
                            <td class="text-center">Total Gasto :</td>
                            <td class="text-center"><span class="badge badge-danger" style="font-size: 95%"> S/. {{number_format($gasto,2)}}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" ></td>
                            <td class="text-center">Total Ingreso :</td>
                            <td class="text-center"><span class="badge badge-success" style="font-size: 95%"> S/. {{number_format($ingreso,2)}}</span></td>
                        </tr> 
                        
                    </tbody>
                </table>   
                @endif
                </div>
            </div>
        </div>
    @else 
        <div class="alert alert-dark" role="alert">
            Primero aperturar caja
        </div>
    @endif
</div>
  