<div>
    <div class="card">
        <div class="card-header col-md-12">
            <div class="row">
                <div  class="col-md-4">
                    <a href="#" wire:click.prevent="agregarProducto" class="btn btn-secondary btn-block"> <i class="fa fa-plus-circle mr-1"></i> Registrar Producto</a>
                </div>
                <div  class="col-md-8">
                    <input wire:model="search" class="form-control" placeholder="Ingrese nombre">
                </div>
            </div>
            
            
        </div>
        @if ($productos->count())
            <div class="card-body table-responsive-sm">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Categoría</th>
                            <th class="text-center">Marca</th>
                            <!--th class="text-center">Unidad</th-->
                            <th class="text-center">Stock unid.</th>
                            <th class="text-center">Stock Mínimo</th>
                            <!--th class="text-center">Precio</th-->
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $index =>$producto)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td class="text-center">{{$producto->nombre}}</td>
                                <td class="text-center">{{$producto->categoria}}</td>
                                <td class="text-center">{{$producto->marca}}</td>
                                <td class="text-center">{{$producto->stock}}</td>
                                <td class="text-center">{{ $producto->stock_minimo }}</td>
                                <td class="text-center" width="140px"><a class="btn btn-success btn-sm" wire:click="$emit('modalConfigurarPrecio',{{$producto->id}})" href="#">Configurar Precios</a></td>
                                <td width="150px">
                                    <a class="btn btn-primary btn-sm" wire:click.prevent="editarProducto({{$producto->id}})" href="#">Editar</a>
                                    <a href="#" wire:click.prevent="eliminar({{$producto->id}})" class="btn btn-danger btn-sm">Eliminar</a>
                                </td> 
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                <div class="footer">{{$productos->links()}}</div> 
            </div>
            
        @else
            <div class="card-body"><strong>No hay registros</strong></div>
        @endif
    </div>

    <!-- Modal -->
    @livewire('modals.registro-producto')
    @livewire('modals.configurar-precio')