<div class="modal fade" id="registroCategoriaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0a2040">
            <h5 class="modal-title" style="color: white" id="exampleModalLabel">{{ $tipo == 'create'? 'REGISTRAR': 'ACTUALIZAR'}}</h5>
            <button type="button" class="close" wire:click="$emit('cerrarModalCategoria')">
                <span aria-hidden="true" style="color: white">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                @if ($tipo == 'create')
                    {!! Form::open(['wire:submit.prevent'=>'registrar']) !!}
                @else
                    {!! Form::model($data,['wire:submit.prevent'=>'editar', 'method'=>'put']) !!}
                @endif
            
                <div class="form-group">
                    {!! Form::label('all','Nombre Categoría(*)') !!}
                    {!! Form::text('nombre', null, ['class'=>'form-control'.($errors->has('nombre') ? ' is-invalid' : null),'autocomplete'=>'off','placeholder'=>'Ingrese nombre','wire:model.defer'=>'data.nombre']) !!}
                    @error('nombre')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>         
            </div>
            <div class="modal-footer">
                {!! Form::submit($tipo == 'create' ?'Registrar':'Actualizar', ['class'=>'btn btn-primary']) !!}
            </div>
        </div>
    </div>
</div>