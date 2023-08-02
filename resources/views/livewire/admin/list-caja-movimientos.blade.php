<div>
   @if (count($ventas)>0)
        <div class="card">
            <div class="card-body" style="padding-bottom: 0px;">
                <div class="text-center"><strong>VENTAS</strong></div>
                <div class="row p-1">
                    <div class="col-md-12 mr-3 table-responsive-sm">
                        <table class="table table-striped">
                            <thead>
                                <tr style="color: white">
                                    <th scope="col">#</th>
                                    <th scope="col" class="text-center">CLIENTE</th>
                                    <th scope="col" class="text-center">FECHA</th>
                                    <th scope="col" class="text-center">IMPORTE</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @php($suma_total = 0)
                                @foreach ($ventas as $index=> $resultado)
                                    @php($suma_total = $suma_total+$resultado->total)
                                    <tr>
                                    <td>{{$index+1}}</td>
                                    <td class="text-center">{{$resultado->nombre}} {{$resultado->apellido_paterno}} {{$resultado->apellido_materno}}</td>
                                    <td class="text-center">{{date("d/m/Y h:i:A", strtotime( $resultado->fecha))}}</td>
                                    <td class="text-center">{{number_format($resultado->total,2)}}</td>
                                    </tr> 
                                @endforeach
                                    <tr>
                                        <td colspan="2"></td>
                                        <td class="text-center">Total Facturado :</td>
                                        <td class="text-center"><span class="badge badge-info" style="font-size: 95%"> {{number_format($suma_total,2)}}</span></td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>   
            </div>
        </div>
    @endif


   @if (count($movimientos)>0)
   <div class="card">
        <div class="card-body" style="padding-bottom: 0px;">
            <div class="text-center"><strong>INGRESOS / GASTOS</strong></div>
            <div class="row p-1">
                <div class="col-md-12 mr-3 table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr style="background-color: #94bfb9">
                                
                                <th class="text-center">#</th>
                                <th class="text-center">T. MOVI</th>
                                <th class="text-center">DESCRIPCION</th>
                                <th class="text-center">FECHA</th>
                                <th class="text-center">MONTO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($total_mov_ingreso = 0)
                            @php($total_mov_gasto = 0)
                            @foreach ($movimientos as $index=>$movimiento)
                                @if ($movimiento->tipo_movimiento =='I')
                                    @php($total_mov_ingreso = $total_mov_ingreso +$movimiento->monto)
                                @else
                                    @php($total_mov_gasto = $total_mov_gasto + $movimiento->monto)
                                @endif
                            <tr>
                                <td class="text-center">{{$index+1}}</td>
                                <td class="text-center">{{$movimiento->tipo_movimiento == 'I' ? 'Ingreso' : 'Gasto'}}</td>
                                <td class="text-center">{{$movimiento->descripcion}}</td>
                                <td class="text-center">{{$movimiento->fecha}}</td>
                                <td class="text-center">{{number_format($movimiento->monto,2)}}</td>
                            </tr>  
                            @endforeach
                            <tr>
                                <td colspan="2"></td>
                                <td class="text-center">Total Gasto : {{number_format($total_mov_gasto,2)}}</td>
                                <td class="text-center">Total Ingreso : {{number_format($total_mov_ingreso,2)}}</td>
                                <td class="text-center">Total : <span style="font-size: 92%" class="badge badge-{{$total_mov_ingreso - $total_mov_gasto < 0 ?'danger':'success'}}">{{number_format($total_mov_ingreso - $total_mov_gasto,2)}}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>   
        </div>
    </div>
   @endif

</div>
