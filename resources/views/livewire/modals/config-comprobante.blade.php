
<div class="modal fade" id="registroConfigComprobanteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
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
                    {!! Form::label('all','Serie (*)') !!}
                    {!! Form::text('serie', null, ['class'=>'form-control'.($errors->has('serie') ? ' is-invalid' : null),'autocomplete'=>'off','placeholder'=>'Ingrese serie','wire:model.defer'=>'data.serie']) !!}
                    @error('serie')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('nd','Contador (*)') !!}
                    {!! Form::Number('contador', null, ['class'=> 'form-control'.($errors->has('contador') ? ' is-invalid' : null),'autocomplete'=>'off','placeholder'=>'Ingrese contador','wire:model.defer'=>"data.contador"]) !!}
                    @error('contador')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('nd','Número máximo (*)') !!}
                    {!! Form::Number('numero_maximo', null, ['class'=> 'form-control'.($errors->has('numero_maximo') ? ' is-invalid' : null),'autocomplete'=>'off','placeholder'=>'Ingrese número máximo','wire:model.defer'=>"data.numero_maximo"]) !!}
                    @error('numero_maximo')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('nd','Valor igv') !!}
                    {!! Form::Number('valor_igv', null, ['class'=> 'form-control'.($errors->has('valor_igv') ? ' is-invalid' : null),'autocomplete'=>'off','placeholder'=>'Ingresar igv','wire:model.defer'=>"data.valor_igv"]) !!}
                    @error('valor_igv')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div> 
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {!! Form::submit($tipo == 'create' ?'Registrar':'Actualizar', ['class'=>'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>          
            </div>
            
        </div>
    </div>
  </div>