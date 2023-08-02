<div>
    @php
        $existe = count($aperturas);
    @endphp
    <div class="card">
        <div class="row p-1">
            <div class="col-md-12 mr-3 table-responsive-sm">
              @if ($existe>0)
              <table class="table table-sm" >
                <thead style="background-color: #d8dfe6;">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="text-center">CAJA</th>
                    <th scope="col" class="text-center">FECHA APERTURA</th>
                    <th scope="col" class="text-center">MONTO APERTURA</th>
                    <th scope="col" class="text-center">TOTAL VENTAS</th>
                    <th scope="col" class="text-center">TOTAL ENTREGAR</th>
                    <th scope="col" class="text-center">ESTADO</th>
                    <th scope="col" class="text-center"></th>
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
                      <td class="text-center">{{number_format($total_ventas,2)}}</td>
                      <td class="text-center">{{number_format($total_ventas + $apertura->monto_apertura , 2)}}</td>
                      <td class="text-center"><span class="badge badge-success">APERTURADO</span></td>
                      <td class="text-center"><a ref="#" wire:click.prevent="cerrarCaja()" class="btn btn-primary btn-sm">Cerrar</a></td>
                    </tr> 
                  @endforeach
                </tbody>
              </table>
              @else  
              <div class="alert alert-dark" role="alert">
                No tiene caja por cerrar
              </div>
              @endif
              
            </div>
        </div>
    </div>
</div>

