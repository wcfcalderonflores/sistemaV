
    <div class="card">
        <div class="card-body table-responsive-sm">
            <div style="background-color: #343a40; color: white; margin-top:12px" class="text-center">
                CREAR CAJA 
                [<a href="#" wire:click="$emit('abrirModal','create')" class="btn btn-sm">
                    <i class="fa fa-plus-square text-light" aria-hidden="true"></i>
                </a>]
            </div>
            @if ($cajas)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NOMBRE</th>
                            <th>ESTADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cajas as $caja)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$caja->nombre}}</td>
                            <td>
                                <a href="#" wire:click="activarDesactivar({{$caja->id}},'{{$caja->estado}}')">
                                    <i class="fa fa-check-circle {{$caja->estado == '0' ? 'text-danger' : ''}}"  aria-hidden="true"></i>
                                </a>
                            </td>
                            <td>
                                <a ref="#" wire:click="eliminar({{$caja->id}})" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                <a ref="#" wire:click.prevent="editar({{$caja->id}})" class="btn btn-sm btn-secondary">Edit</a>
                            </td>
                        </tr>  
                        @endforeach
    
                    </tbody>
                </table>
            @endif
        </div>
        @livewire('modals.registro-caja')
        
    </div>