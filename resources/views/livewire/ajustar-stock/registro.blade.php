<div class="card">
    @if ($estado == '2')
        @if (session()->has('arqueo'))
            <div class="card-body" style="padding-top: 0px">
                <div class="col-md-12 order-md-1">  
                <form wire:submit.prevent="registrarAjuste" >
                    <div style="display: flex">
                        @if ($ajuste)
                        <!--a href="#" class="btn btn-secondary btn-sm" wire:click.prevent="{{$editar_ajuste ? 'guardarVenta' : 'editarVenta'}}" style="height: 28px; margin-top:6px; margin-left: 2px"><i class="fa fa-edit mr-1"></i>{{$editar_ajuste ? 'Guardar' : 'Editar'}}</a-->
                        <a href="#" class="btn btn-danger btn-sm" wire:click.prevent="eliminarAjuste()" style="height: 28px; margin-top:6px; margin-left: 2px"><i class="fa fa-times mr-1"></i>Eliminar</a>
                        @endif 
                    </div>
                    <div class="row pt-2">

                        <div class="col-md-6 mb-1">
                            <label for="lastName">Tipo</label>
                            <select name="tipo_ajuste" {{$ajuste ? ($editar_ajuste ? '': 'disabled'): ''}} class="form-control{{($errors->has('tipo_ajuste') ? ' is-invalid' : null)}}" wire:model.defer="tipo_ajuste">
                                <option value="1">Vencimiento</option>
                                <option value="2">Perdida</option>
                                <option value="3">Otro</option>
                            </select>
                            @error('tipo_ajuste')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName">Referencia</label>
                                <input name="referencia" type="text" {{$ajuste ? ($editar_ajuste ? '': 'disabled'): ''}} class="form-control{{($errors->has('referencia') ? ' is-invalid' : null)}}" placeholder="" wire:model="referencia" >
                                @error('referencia')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                        </div>
                    
                    </div>
                    <h5 class="mb-1" style="color: #1e3890; margin-top:0px">Agregar producto</h5>
                    <hr class="mb-1" style="border-top: 1px solid #1e3890;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-2" style="position: relative">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Producto
                                    @if($picked2)
                                        <span class="badge badge-success">Seleccionado</span>
                                    @else
                                        <span class="badge badge-danger">Seleccionar</span>
                                    @endif
                                </span>
                                </div>
                                <input autocomplete="off" name="buscarProducto" wire:model="buscarProducto" 
                                    type="text" placeholder="Busq. Nombres" class="form-control">
                                @if(count($productos)>0)
                                    @if(!$picked2)
                                    <div class="shadow rounded px-2 pt-2 pb-0 buscador2">
                                        @foreach($productos as $producto)
                                            @php($stock = round($producto->stock /$producto->cantidad_unidades,3))
                                            <div style="cursor: pointer;" class="resultado" wire:click="asignarProducto('{{ $producto->id }}','{{ $producto->nombre }} [{{ $producto->abreviatura }} x{{$producto->cantidad_unidades}}]',{{$producto->precio_compra}},'{{$producto->abreviatura}}',{{$producto->producto_unidad_id}},{{$producto->cantidad_unidades}})">
                                                <a>
                                                    {{ $producto->nombre }} [{{ $producto->abreviatura }} x{{$producto->cantidad_unidades}}] <span class="badge badge-{{$stock>0 ? 'success' : 'danger'}}">Stock: {{$stock}}</span>
                                                </a>
                                            </div>
                                        <hr class="my-2">
                                        @endforeach
                                    </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Cant.</span>
                                </div>
                                <input name="cantidad" type="number" step="0.001" {{$producto_id ? '' : 'readonly'}} class="form-control{{($errors->has('cantidad') ? ' is-invalid' : null)}}" wire:model="cantidad" >
                                @error('cantidad')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Precio</span>
                                </div>
                                <input name="precio_compra" type="number" step="0.01" readonly class="form-control{{($errors->has('precio_compra') ? ' is-invalid' : null)}}" wire:model="precio_compra" >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Total</span>
                                </div>
                                <input name="precio" type="number" step="0.01"  readonly class="form-control{{($errors->has('precio') ? ' is-invalid' : null)}}" placeholder="" wire:model="total" >
                                @error('precio')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Cant. Recup.</span>
                                </div>
                                <input name="cantidad_recuperada" type="number" step="0.01"  {{$producto_id ? '' : 'readonly'}} class="form-control{{($errors->has('cantidad_recuperada') ? ' is-invalid' : null)}}" placeholder="" wire:model="cantidad_recuperada" >
                                @error('cantidad_recuperada')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-2 mb-1">
                            <div class="input-group mb-2">
                                <button type="submit" class="btn btn-secondary btn-sm btn-block" >Agregar</button>
                            </div>
                        </div>
                    
                    </div>

                </form>
                </div>

                    @livewire('ajustar-stock.detalle-ajuste-stock',['ajuste_id'=>$ajuste_id])
                    @if ($btn_terminar && $editar_ajuste==false)
                        <a href="#" wire:click.prevent="terminarRegistro" class="btn btn-success">Terminar registro</a>
                    @elseif($editar_ajuste==true)
                    <h5 style="color: red">Guardar datos de ajuste!!</h5>
                    @endif
                
                
            </div>
        @else 
        <div class="alert alert-danger" role="alert">
            Primero aperturar caja
        </div>
        @endif
    @else
        <div class="alert alert-danger" role="alert">
            El registro ya no es editable
        </div>
    @endif
</div>
