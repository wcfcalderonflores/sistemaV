<div>
    <div class="card">
        <div class="card-header col-md-12">
            <div class="row">
                <div  class="col-md-4">
                    <a href="#" wire:click.prevent="agregarCliente" class="btn btn-secondary btn-block"> <i class="fa fa-plus-circle mr-1"></i> Registrar cliente</a>
                </div>
                <div  class="col-md-8">
                    <input wire:model="search" class="form-control" placeholder="Ingrese nombre / DNI">
                </div>
            </div>
            
            
        </div>
        @if ($clientes->count())
            <div class="card-body table-responsive-sm">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>DNI</th>
                            <th>Lugar</th>
                            <th>Dirección</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $index =>$cliente)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$cliente->nombre}}</td>
                                <td>{{$cliente->apellido_paterno}}</td>
                                <td>{{$cliente->apellido_materno}}</td> 
                                <td>{{$cliente->numero_documento}}</td>
                                <td>{{$cliente->departamento}} / {{$cliente->provincia}} / {{$cliente->distrito}}</td>
                                <td>{{$cliente->direccion}}</td>
                                <td width="5px"><a class="btn btn-primary btn-sm" wire:click.prevent="editarCliente({{$cliente->id}})" href="#">Editar</a></td> 
                                <td wisth="5px">
                                    <a href="#" wire:click.prevent="eliminar({{$cliente->id}})" class="btn btn-danger btn-sm">Eliminar</a>
                                </td>  
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                <div class="footer">{{$clientes->links()}}</div> 
            </div>
            
        @else
            <div class="card-body"><strong>No hay registros</strong></div>
        @endif
    </div>

    <!-- Modal -->
    @livewire('modals.registro-cliente')
</div>

