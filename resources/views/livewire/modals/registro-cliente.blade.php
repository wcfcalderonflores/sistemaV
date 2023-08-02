<div class="modal fade bd-example-modal-lg" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{ $tipo == 'create'? 'REGISTRAR '.strtoupper($cabecera): 'ACTUALIZAR '.strtoupper($cabecera)}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body row col-md-12">
                <div  class="col-md-6">
                    <!--form wire:submit.prevent="createUser"-->
                    
                    @if ($tipo == 'create')
                        {!! Form::open(['wire:submit.prevent'=>'createCliente']) !!}
                    @else
                        {!! Form::model($cliente,['wire:submit.prevent'=>'editarClientes', 'method'=>'put']) !!}
                    @endif
                
                    <div class="form-group">
                        {!! Form::label('td','Tipo Documento (*)') !!}
                        {!! Form::select('tipo_documento', [null=>'--Seleccione--','01'=>'DNI','06'=>'RUC'], null, ['class'=> 'form-control','form-control'.($errors->has('tipo_documento') ? ' is-invalid' : null),'required','wire:model.defer'=>'data.tipo_documento']) !!}
                        @error('tipo_documento')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('nd','Numero Documento (*)') !!}
                        {!! Form::text('numero_documento', null, ['class'=> 'form-control'.($errors->has('numero_documento') ? ' is-invalid' : null),'autocomplete'=>'off','placeholder'=>'Ingrese numero','wire:keydown.enter'=>'alexlo()','wire:model'=>"data.numero_documento"]) !!}
                        @error('numero_documento')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                        
                    </div>
                    
                    
                    <div class="form-group">
                        {!! Form::label('name','Nombre (*)') !!}
                        {!! Form::text('nombre', null, ['class'=> 'form-control'.($errors->has('nombre') ? ' is-invalid' : null),$cliente_id ? 'readonly':'','autocomplete'=>'off','placeholder'=>'Ingrese nombre','wire:model.defer'=>"data.nombre"]) !!}
                        @error('nombre')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('ap','Apellido Paterno (*)') !!}
                        {!! Form::text('apellido_paterno', null, ['class'=> 'form-control'.($errors->has('apellido_paterno') ? ' is-invalid' : null),$cliente_id ? 'readonly':'','autocomplete'=>'off','placeholder'=>'Ingrese apellido paterno','wire:model.defer'=>"data.apellido_paterno"]) !!}
                        @error('apellido_paterno')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('am','Apellido Materno (*)') !!}
                        {!! Form::text('apellido_materno', null, ['class'=> 'form-control'.($errors->has('apellido_materno') ? ' is-invalid' : null),$cliente_id ? 'readonly':'','autocomplete'=>'off','placeholder'=>'Ingrese apellido materno','wire:model.defer'=>"data.apellido_materno"]) !!}
                        @error('apellido_materno')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('sexo','Sexo (*)') !!}
                        {!! Form::select('sexo', [null=>'--Seleccione--','M'=>'Masculino','F'=>'Femenino'], null, ['class'=> 'form-control','form-control'.($errors->has('sexo') ? ' is-invalid' : null),$cliente_id ? 'readonly':'','required','wire:model.defer'=>"data.sexo"]) !!}
                        @error('sexo')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('celular','Celular') !!}
                        {!! Form::number('celular', null, ['class'=> 'form-control'.($errors->has('celular') ? ' is-invalid' : null),$cliente_id ? 'readonly':'','autocomplete'=>'off','placeholder'=>'Ingrese celular','wire:model.defer'=>"data.celular"]) !!}
                        @error('celular')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('dep','Departamento') !!}
                        {!! Form::select('departamento', $departamentos, $dataUbigeo, ['class'=> 'form-control',$cliente_id ? 'readonly':'','wire:change.prevent'=>'buscarProvincia($event.target.value)']) !!}
                        @error('departamento')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('pro','Provincia') !!}
                        {!! Form::select('provincia', $provincias, $dataUbigeo, ['class'=> 'form-control',$cliente_id ? 'readonly':'','wire:change.prevent'=>'buscarDistrito($event.target.value)']) !!}
                        @error('provincia')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('dep','Distrito') !!}
                        {!! Form::select('distrito', $distritos, $dataUbigeo , ['class'=> 'form-control','form-control'.($errors->has('distrito') ? ' is-invalid' : null),$cliente_id ? 'readonly':'','wire:model.defer'=>"data.ubigeo_id"]) !!}
                        @error('distrito')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('direccion','Dirección') !!}
                        {!! Form::text('direccion', null, ['class'=> 'form-control'.($errors->has('direccion') ? ' is-invalid' : null),$cliente_id ? 'readonly':'','autocomplete'=>'off','placeholder'=>'Ingrese direccion','wire:model.defer'=>"data.direccion"]) !!}
                        @error('direccion')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('name','Email') !!}
                        {!! Form::email('correo', null, ['class'=>'form-control'.($errors->has('correo') ? ' is-invalid' : null),$cliente_id ? 'readonly':'','autocomplete'=>'off','placeholder'=>'Ingrese email','wire:model.defer'=>"data.correo"]) !!}
                        @error('correo')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror 
                    </div>
                </div>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {!! Form::submit($tipo == 'create' ?'Registrar':'Actualizar', ['class'=>'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>