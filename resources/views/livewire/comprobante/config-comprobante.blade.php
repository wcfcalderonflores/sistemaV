<div>
    @if (isset($comprobante->nombre))
    <div class="card-body table-responsive-sm">
        <div style="background-color: #27517a; color: white; margin-top:12px" class="text-center">
            CONFIGURAR {{$comprobante->nombre}}
            [<a href="#" wire:click="$emit('abrirModalConfig','create',{{$comprobante->id}})" class="btn btn-sm">
                <i class="fa fa-plus-square text-light" aria-hidden="true"></i>
            </a>]
        </div>
        @if ($comprobanteConfigs)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>SERIE</th>
                        <th>CONTADOR</th>
                        <th>NUM. MÁXIMO</th>
                        <th>IGV</th>
                        <th>ESTADO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comprobanteConfigs as $config)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$config->serie}}</td>
                        <td>{{$config->contador}}</td>
                        <td>{{$config->numero_maximo}}</td>
                        <td>{{$config->valor_igv}}</td>
                        <td>
                            <a href="#" wire:click="activarDesactivar({{$config}},'{{$config->estado}}')">
                                <i class="fa fa-check-circle {{$config->estado == '0' ? 'text-danger' : ''}}"  aria-hidden="true"></i>
                            </a>
                        </td>
                        <td>
                            <a ref="#" wire:click="eliminar({{$config}})" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <a ref="#" wire:click.prevent="editar({{$config->id}})" class="btn btn-sm btn-secondary">Edit</a>
                        </td>
                    </tr>  
                    @endforeach

                </tbody>
            </table>
        @endif
    </div>
    @endif
    @livewire('modals.config-comprobante') 
</div>
