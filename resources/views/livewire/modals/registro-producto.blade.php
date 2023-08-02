<div>
<div class="modal fade" id="form" style="padding-left: 17px;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{ $tipo == 'create'? 'REGISTRAR '.strtoupper($cabecera): 'ACTUALIZAR '.strtoupper($cabecera)}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                    <!--form wire:submit.prevent="createUser"-->
                    
                @if ($tipo == 'create')
                    {!! Form::open(['wire:submit.prevent'=>'createProducto','method'=>'post','enctype'=>'multipart/form-data']) !!}
                @else
                    {!! Form::model($producto,['wire:submit.prevent'=>'editarProducto', 'method'=>'put','enctype'=>'multipart/form-data']) !!}
                @endif
            
                <div class="form-group">
                    {!! Form::label('all','Nombre (*)') !!}
                    {!! Form::text('nombre', null, ['class'=>'form-control'.($errors->has('nombre') ? ' is-invalid' : null),'autocomplete'=>'off','placeholder'=>'Ingrese nombre','wire:model.defer'=>'data.nombre']) !!}
                    @error('nombre')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('nd','Marca') !!}
                    {!! Form::text('marca', null, ['class'=> 'form-control'.($errors->has('marca') ? ' is-invalid' : null),'autocomplete'=>'off','placeholder'=>'Ingrese marca','wire:model.defer'=>"data.marca"]) !!}
                    @error('marca')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                    
                </div>
                <div class="form-group">
                    {!! Form::label('name','Categoria (*)') !!}<a href="#" wire:click="$emit('abrilModalCategoria','create')">CREAR</a>
                    {!! Form::select('categoria_id', $categorias, null, ['class'=> 'form-control'.($errors->has('categoria_id') ? ' is-invalid' : null),'wire:model.defer'=>'data.categoria_id']) !!}
                    @error('categoria_id')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('name','Imagen Producto') !!}
                    {!! Form::file('img', ['class'=> 'form-control'.($errors->has('img') ? ' is-invalid' : null),'wire:model'=>'data.img']) !!}
                    @error('img')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                    @if (isset($data['imagen']) && $this->data['imagen']!='')
                        <div style="display: flex;justify-content: center">
                            <button type="button" wire:click="eliminarImagen" class="close" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <img src="{{asset($data['imagen'])}}" height="180px">
                        </div>
                    @endif
                    
                </div>
                <div class="form-group">
                    {!! Form::label('name','Stock Mínimo (*)') !!}
                    {!! Form::number('stock_minimo', null, ['class'=> 'form-control'.($errors->has('stock_minimo') ? ' is-invalid' : null),'step'=>'any','autocomplete'=>'off','placeholder'=>'Ingrese stock mínimo','wire:model.defer'=>"data.stock_minimo"]) !!}
                    @error('stock_minimo')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('name','Exonerados') !!}
                    {!! Form::radio('afecto_igv', 'E', null,['id'=>'radioExonerado','wire:model.defer'=>"data.afecto_igv"]) !!}
                    {!! Form::label('name','Inafectos') !!}
                    {!! Form::radio('afecto_igv', 'I',null, ['id'=>'radioInafecto','wire:model.defer'=>"data.afecto_igv"]) !!}
                    <!--input class="form-check-input" type="radio" name="afecto_igv" id="radioExonerado">
                    <label class="form-check-label" style="margin-right: 25px" for="flexRadioDefault1"-->
                    [<a href="#" wire:click="$emit('desmarcarRadioButton')" style="font-size:13px">Desmarcar</a>]
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
@livewire('modals.registro-categoria')
</div>