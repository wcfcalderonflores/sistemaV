<div>
    <div class="card">
        <div class="card-header col-md-12">
            <div class="row">
                <div  class="col-md-4">
                    <a href="#" wire:click.prevent="agregarProveedor" class="btn btn-secondary btn-block"> <i class="fa fa-plus-circle mr-1"></i> Registrar Proveedor</a>
                </div>
                <div  class="col-md-8">
                    <input wire:model="search" class="form-control" placeholder="Ingrese nombre / DNI">
                </div>
            </div>
            
            
        </div>
        @if ($proveedores->count())
            <div class="card-body table-responsive-sm">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Tipo Doc.</th>
                            <th>Numero Doc.</th>
                            <th>Lugar</th>
                            <th>Dirección</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proveedores as $index =>$proveedor)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$proveedor->nombre}} {{$proveedor->apellido_paterno}} {{$proveedor->apellido_materno}}</td>
                                <td>{{$this->tipoDocumento($proveedor->tipo_documento)}}</td> 
                                <td>{{$proveedor->numero_documento}}</td>
                                <td>{{$proveedor->departamento}} / {{$proveedor->provincia}} / {{$proveedor->distrito}}</td>
                                <td>{{$proveedor->direccion}}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" wire:click.prevent="editarProveedor({{$proveedor->id}})" href="#">Editar</a>
                                    <a href="#" wire:click.prevent="eliminar({{$proveedor->id}})" class="btn btn-danger btn-sm">Eliminar</a>
                                </td> 
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                <div class="footer">{{$proveedores->links()}}</div> 
            </div>
            
        @else
            <div class="card-body"><strong>No hay registros</strong></div>
        @endif
    </div>

    <!-- Modal -->
    @livewire('modals.registro-cliente')
</div>
