<div class="card-body table-responsive-sm">
    <div style="background-color: #343a40; color: white" class="text-center">CAMPAÑA [<a href="#" wire:click="$emit('campaniaModal')" class="btn btn-sm"><i class="fa fa-plus-square text-light" aria-hidden="true"></i></a>]</div>
    <table class="table table-striped">
        <thead>
            <tr>
                
                <th>#</th>
                <th>NOMBRE</th>
                <th>DESCRIPCION</th>
                <th>ESTADO</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($campanias as $index=>$campania)
            <tr>
                <td>{{$index+1}}</td>
                <td>{{$campania->nombre}}</td>
                <td>{{$campania->descripcion}}</td>
                <td>
                    <a href="#" wire:click="activar({{$campania}})">
                        <i class="fa fa-check-circle {{$campania->estado == '1' ? 'text-primary' : 'text-danger' }}" aria-hidden="true"></i>
                    </a>
                </td>
                <td>
                    <a ref="#" wire:click="eliminar({{$campania}})" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    <a ref="#" wire:click="editar({{$campania}})" class="btn btn-sm btn-secondary">Edit</a>
                    
                </td>
            </tr>  
            @endforeach
        </tbody>
    </table>

    <div class="modal show fade" id="campania" tabindex="-1" role="dialog" wire:ignore.self aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">{{$accion == 'create' ? 'REGISTRAR' : 'ACTUALIZAR'}} CAMPAÑA</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="firstName"><strong>Nombre</strong></label>
                        <input autocomplete="off" wire:model.defer="data.nombre" name="nombre" type="number" class="form-control {{($errors->has('nombre') ? ' is-invalid' : null)}}">
                            @error('nombre')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="firstName"><strong>Descripción</strong></label>
                        <textarea class="form-control" wire:model.defer="data.descripcion"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            @if ($accion == 'create')
                <button type="button" if class="btn btn-primary" wire:click="guardar">Guardar</button>
            @else
                <button type="button" class="btn btn-primary" wire:click="actualizar({{$campania_id}})">Editar</button>
            @endif
            </div>
        </div>
        </div>
    </div> 
    
    
</div>