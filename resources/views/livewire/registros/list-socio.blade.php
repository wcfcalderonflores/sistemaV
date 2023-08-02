<div>
    <div class="card">
        <div class="card-header col-md-12">
            <div class="row">
                <div  class="col-md-4">
                    <a href="#" wire:click.prevent="agregarSocio" class="btn btn-secondary btn-block"> <i class="fa fa-plus-circle mr-1"></i> Registrar Socio</a>
                </div>
                <div  class="col-md-8">
                    <input wire:model="search" class="form-control" placeholder="Ingrese nombre / DNI">
                </div>
            </div>
            
            
        </div>
        @if ($socios->count())
            <div class="card-body table-responsive-sm">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>DNI</th>
                            <th>TIPO</th>
                            <th>Lugar</th>
                            <th>Dirección</th>
                            <th>Activo</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($socios as $index =>$socio)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$socio->nombre}}</td>
                                <td>{{$socio->apellido_paterno}}</td>
                                <td>{{$socio->apellido_materno}}</td> 
                                <td>{{$socio->numero_documento}}</td>
                                <td>{{$socio->tipo_socio == '1' ? 'Socio' : 'Inquilino'}}</td>
                                <td>{{$socio->departamento}} / {{$socio->provincia}} / {{$socio->distrito}}</td>
                                <td>{{$socio->direccion}}</td>
                                <td> <a href="#" wire:click.prevent="descativarSocio({{$socio->id}},'{{$socio->estado}}')" class="btn btn-sm"> <i class="fa fa-check-circle {{$socio->estado == '1' ? 'text-primary' : 'text-danger' }}" aria-hidden="true"></i> </a></td>
                                <td>
                                    <a class="btn btn-primary btn-sm" wire:click.prevent="editarCliente({{$socio->id}},{{$socio->tipo_socio}})" href="#">Editar</a>
                                    <a href="#" wire:click.prevent="eliminar({{$socio->id}})" class="btn btn-danger btn-sm">Eliminar</a>
                                </td> 
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                <div class="footer">{{$socios->links()}}</div> 
            </div>
            
        @else
            <div class="card-body"><strong>No hay registros</strong></div>
        @endif
    </div>

    <!-- Modal -->
    @livewire('modals.registro-cliente')
</div>
