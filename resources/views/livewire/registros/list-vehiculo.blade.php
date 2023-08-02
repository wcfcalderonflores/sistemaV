<div>
    <div class="card">
        <div class="card-header col-md-12">
            <div class="row">
                <div  class="col-md-4">
                    <a href="#" wire:click.prevent="agregarVehiculo" class="btn btn-secondary btn-block"> <i class="fa fa-plus-circle mr-1"></i> Registrar vehículo</a>
                    </div>
                    <div  class="col-md-8">
                        <input wire:model="search" class="form-control" placeholder="Ingrese placa">
                    </div>
            </div>
        </div>
        @if ($vehiculos->count()>0)
            <div class="card-body table-responsive-sm">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>PLACA</th>
                            <th>MARCA</th>
                            <th>MODELO</th>
                            <th>ASIENTOS</th>
                            <th>CONDUCTOR</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehiculos as $index =>$vehiculo)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$vehiculo->placa}}</td>
                                <td>{{$vehiculo->marca}}</td>
                                <td>{{$vehiculo->modelo}}</td> 
                                <td>{{$vehiculo->numero_asientos}}</td>
                                <td>
                                    @php
                                        $resultado = $this->conductores($vehiculo->id);
                                        $alexlo = '';
                                        $i = 0;
                                        foreach ($resultado as $data) {
                                            if ($i == 0) {
                                                $alexlo = $alexlo.$data;
                                            }else{
                                                $alexlo = $alexlo.' / '.$data;
                                            }
                                            $i=$i+1;
                                           
                                        }
                                        
                                    @endphp
                                    {{$alexlo}}
                                </td>
                                <td width="10px"><a class="btn btn-primary btn-sm" wire:click.prevent="editarVehículo({{$vehiculo}})" href="#">Editar</a></td> 
                                <td wisth="10px">
                                    <a href="#" wire:click.prevent="eliminar({{$vehiculo}})" class="btn btn-danger btn-sm">Eliminar</a>
                                </td>  
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                <div class="footer">{{$vehiculos->links()}}</div> 
                <br>
            </div>
            
        @else
            <div class="card-body"><strong>No hay registros</strong></div>
        @endif
    </div>

    @livewire('modals.registro-vehiculo')
</div>
