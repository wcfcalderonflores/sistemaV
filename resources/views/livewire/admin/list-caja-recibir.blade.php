
<div class="card">
    <div class="card-body" style="padding-bottom: 0px;">
        <div class="form-group">
            <label>Usuario</label>
            <select name="ruta" class="form-control py-1" wire:change.prevent="listCaja($event.target.value)">
                @foreach ($usuarios as $index=>$usuario)
                <option  value="{{$index}}">{{$usuario}}</option>
                @endforeach
                
            </select>
        </div>
        @if (count($aperturas)>0)
            <div class="row p-1">
                <div class="col-md-12 mr-3 table-responsive-sm">
                    <table class="table table-sm" >
                        <thead style="background-color: #d8dfe6;">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" class="text-center">CAJA</th>
                            <th scope="col" class="text-center">FECHA APERTURA</th>
                            <th scope="col" class="text-center">MONTO APERTURA</th>
                            <th scope="col" class="text-center">TOTAL VENTAS</th>
                            <th scope="col" class="text-center">FECHA CIERRE</th>
                            <th scope="col" class="text-center">TOTAL ENTREGAR</th>
                            <th scope="col" class="text-center">ESTADO CAJA</th>
                            <th scope="col" class="text-center">RECIBIDO</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($aperturas as $index=> $apertura)
                        @php
                            $total_ventas = $this->totalVentas($apertura->id)
                        @endphp
                            <tr>
                            <td>{{$index+1}}</td>
                            <td class="text-center">{{$apertura->nombre}}</td>
                            <td class="text-center">{{date("d/m/Y h:i:A",strtotime($apertura->fecha_apertura))}}</td>
                            <td class="text-center">{{number_format($apertura->monto_apertura,2)}}</td>
                            <td class="text-center"><a href="#" wire:click="movimiento({{$apertura->id}})">{{number_format($total_ventas,2)}}</a></td>
                            <td class="text-center">{{$apertura->fecha_cierre ? date("d/m/Y h:i:A",strtotime($apertura->fecha_cierre)) : ''}}</td>
                            <td class="text-center">{{number_format($total_ventas + $apertura->monto_apertura , 2)}}</td>
                            <td class="text-center"><span class="badge badge-{{$apertura->estado == '1' ? 'success' : 'danger'}}">{{$apertura->estado == '1' ? 'APERTURADO' : 'CERRADO'}}</span></td>
                            <td class="text-center">
                                @if ($apertura->estado == '0')
                                    @if ($apertura->estado_recibido == '1')
                                        <a ref="#" wire:click.prevent="recibirCaja({{$apertura->id}})" class="btn btn-sm"><i class="fa fa-unlock text-primary" aria-hidden="true"></i></a>
                                    @else
                                    <i class="fa fa-lock text-danger" aria-hidden="true"></i> 
                                    @endif
                                @else
                                    <span class="badge badge-info">FALTA CERRAR CAJA</span>
                                @endif
                                

                            </td>
                            </tr> 
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
        <p class="text-primary"> {{$pintar ? 'Sin resultado.': ''}}</p>
       
        @endif
    </div>
</div>
@livewire('admin.list-caja-movimientos')

        
