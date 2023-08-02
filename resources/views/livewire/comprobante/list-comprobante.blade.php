<div>
<div class="card">
    <div class="card-body table-responsive-sm">
        <div style="background-color: #343a40; color: white; margin-top:12px" class="text-center">
            REGISTRAR COMPROBANTE 
            [<a href="#" wire:click="$emit('abrirModal','create')" class="btn btn-sm">
                <i class="fa fa-plus-square text-light" aria-hidden="true"></i>
            </a>]
        </div>
        @if ($comprobantes)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NOMBRE</th>
                        <th>ABREVIATURA</th>
                        <th>ESTADO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comprobantes as $comprobante)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$comprobante->nombre}}</td>
                        <td>{{$comprobante->abreviatura}}</td>
                        <td>
                            <a href="#" wire:click="activarDesactivar({{$comprobante->id}},'{{$comprobante->estado}}')">
                                <i class="fa fa-check-circle {{$comprobante->estado == '0' ? 'text-danger' : ''}}"  aria-hidden="true"></i>
                            </a>
                        </td>
                        <td>
                            <a ref="#" wire:click="eliminar({{$comprobante->id}})" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <a ref="#" wire:click.prevent="editar({{$comprobante->id}})" class="btn btn-sm btn-secondary">Edit</a>
                            <a ref="#" wire:click.prevent="comprobanteConfig({{$comprobante}})" class="btn btn-sm btn-primary">Configurar</a>
                        </td>
                    </tr>  
                    @endforeach

                </tbody>
            </table>
        @endif
    </div>
    @livewire('modals.registro-comprobante')
    
</div>
@if ($mostrarConfig)
    <div class="card">
        @livewire('comprobante.config-comprobante')
    </div>
@endif

</div>