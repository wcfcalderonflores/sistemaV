<div class="modal fade bd-example" id="form" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{ $tipo == 'update' ? 'EDITAR VEHICULO' : 'REGISTRAR VEHICULO'}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body ">
                <div  class="col-md-12">
                    <!--form wire:submit.prevent="createUser"-->
                    @if ($tipo == 'update')
                        {!! Form::model($vehiculo, ['wire:submit.prevent'=>'updateVehiculo']) !!}
                    @else
                        {!! Form::open(['wire:submit.prevent'=>'createVehiculo']) !!}
                    @endif
                    <div class="form-group">
                        {!! Form::label('placa','Placa*') !!}
                        {!! Form::text('placa', null, ['class'=> 'form-control'.($errors->has('placa') ? ' is-invalid' : null),'autocomplete'=>"off",'required','placeholder'=>'Ingrese placa','wire:model.defer'=>"data.placa"]) !!}
                        @error('placa')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('marca','Marca*') !!}
                        {!! Form::text('marca', null, ['class'=> 'form-control'.($errors->has('marca') ? ' is-invalid' : null),'autocomplete'=>"off",'required','placeholder'=>'Ingrese marca','wire:model.defer'=>"data.marca"]) !!}
                        @error('marca')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('modelo','Modelo') !!}
                        {!! Form::text('modelo', null, ['class'=> 'form-control'.($errors->has('modelo') ? ' is-invalid' : null),'autocomplete'=>"off",'placeholder'=>'Ingrese modelo','wire:model.defer'=>"data.modelo"]) !!}
                        @error('modelo')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('am','Numero de Asientos') !!}
                        {!! Form::number('asientos', null, ['class'=> 'form-control'.($errors->has('asientos') ? ' is-invalid' : null),'autocomplete'=>"off",'placeholder'=>'Numero de asientos','wire:model.defer'=>"data.numero_asientos"]) !!}
                        @error('apellido_materno')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div wire:ignore class="form-group">
                        
                        <select class="form-control {{$errors->has('conductores') ? ' is-invalid' : null}}" required multiple  name="conductores[]" id="select2" wire:model.defer='data.conductores'>
                            @foreach ($conductores as $item)
                                <option value="{{$item->id}}">{{$item->data}}</option>
                            @endforeach
                        </select>
                        @error('conductores')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {!! Form::submit($tipo == 'update' ? 'Actualizar' : 'Registrar', ['class'=>'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>


    @push('js')
    <script>
        $(function (){
            $('#select2').select2({
                //theme: 'bootstrap',
            }).on('change', ()=>{
            //alert($('#select2').val());
            @this.set('data.conductores', $('#select2').val());
        })
    });

    </script>
    @endpush
