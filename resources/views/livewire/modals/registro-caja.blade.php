
<div class="modal fade" id="registroCajaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{ $tipo == 'create'? 'REGISTRAR': 'ACTUALIZAR'}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                @if ($tipo == 'create')
                    {!! Form::open(['wire:submit.prevent'=>'registrar']) !!}
                @else
                    {!! Form::model($data,['wire:submit.prevent'=>'editar', 'method'=>'put']) !!}
                @endif
            
                <div class="form-group">
                    {!! Form::label('all','Nombre (*)') !!}
                    {!! Form::text('nombre', null, ['class'=>'form-control'.($errors->has('nombre') ? ' is-invalid' : null),'autocomplete'=>'off','placeholder'=>'Ingrese nombre','wire:model.defer'=>'data.nombre']) !!}
                    @error('nombre')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>         
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {!! Form::submit($tipo == 'create' ?'Registrar':'Actualizar', ['class'=>'btn btn-primary']) !!}
            </div>
        </div>
    </div>
</div>
  