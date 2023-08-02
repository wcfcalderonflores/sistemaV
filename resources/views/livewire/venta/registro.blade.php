<div class="card">
    @if (session()->has('arqueo'))
        @if (!$numero_comprobante)
        <div class="card-body" style="padding-top: 0px">
        
            <div class="col-md-12 order-md-1">  
            <form wire:submit.prevent="registrarVenta" >
                <div style="display: flex">
                    <a href="#" class="btn btn-secondary btn-sm" wire:click.prevent="agregarCliente" style="height: 28px; margin-top:6px; margin-left: 2px"><i class="fa fa-plus-circle mr-1"></i>Cliente</a>
                    @if ($venta)
                    <a href="#" class="btn btn-secondary btn-sm" wire:click.prevent="{{$editar_venta ? 'guardarVenta' : 'editarVenta'}}" style="height: 28px; margin-top:6px; margin-left: 2px"><i class="fa fa-edit mr-1"></i>{{$editar_venta ? 'Guardar' : 'Editar'}}</a>
                    <a href="#" class="btn btn-danger btn-sm" wire:click.prevent="eliminarVenta()" style="height: 28px; margin-top:6px; margin-left: 2px"><i class="fa fa-times mr-1"></i>Eliminar</a>
                    @endif 
                </div>
                <div class="row">
                    <div class="col-md-12 mb-1">
                        
                        <div class="row">
                            <div class="col-md-3 mb-3" style="position: relative">
                                <label for="firstName"><strong>Buscar</strong>
                                    @if($picked)
                                        <span class="badge badge-success">Seleccionado</span>
                                    @else
                                        <span class="badge badge-danger">Seleccionar</span>
                                    @endif
                                </label>
                                <input autocomplete="off" name="buscar" wire:model="buscar" {{$venta ? ($editar_venta ? '': 'readonly'): ''}}
                                 type="text" placeholder="Busq. por Nombres" class="form-control">
                                    @error('buscar')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                            @error("buscar")                    
                                <small class="form-text text-danger">{{$message}}</small>                                    
                            @else
                                @if(count($clientes)>0)
                                    @if(!$picked)
                                    <div class="shadow rounded px-2 pt-2 pb-0 buscador">
                                        @foreach($clientes as $cliente)
                                            <div style="cursor: pointer;" class="resultado" wire:click="asignarCliente('{{ $cliente->id }}','{{ $cliente->nombre }} {{$cliente->apellido_paterno}} {{$cliente->apellido_materno}}')">
                                                <a>
                                                    {{ $cliente->nombre }} {{$cliente->apellido_paterno}} {{$cliente->apellido_materno}}
                                                </a>
                                            </div>
                                            <hr class="my-2">
                                        @endforeach
                                    </div>
                                    @endif
                                @else
                                    <!--small class="form-text text-muted">Comienza a teclear para ver resultados</small-->
                                @endif
                            @enderror
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="lastName">Cliente*</label>
                                <input type="text" wire:model.defer="datos_cliente" class="form-control{{($errors->has('cliente_id') ? ' is-invalid' : null)}}" readonly >
                                @error('cliente_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                                <input type="hidden" name="cliente_id" wire:model.defer="cliente_id" class="form-control" >
                                
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="lastName">Precio</label>
                                <select name="tipo_precio" {{$venta ? ($editar_venta ? '': 'disabled'): ''}} {{$picked2 ? 'disabled' : ''}} class="form-control{{($errors->has('tipo_precio_id') ? ' is-invalid' : null)}}" wire:click="cambiarPrecio" wire:model.defer="tipo_precio_id">
                                    @foreach ($tipo_precios as $tipo)
                                        <option value="{{$tipo->id}}" {{$tipo->id == $tipo_precio_id ? 'selected' : ''}}>{{$tipo->nombre}}</option>
                                    @endforeach
                                </select>
                                @error('tipo_precio_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="lastName">Comprobante</label>
                                <select name="comprobante" {{$venta ? ($editar_venta ? '': 'disabled'): ''}} {{$picked2 ? 'disabled' : ''}} class="form-control{{($errors->has('comprobante') ? ' is-invalid' : null)}}" wire:model.defer="comprobante">
                                    @foreach ($comprobantes_config as $comp)
                                        <option value="{{$comp->id}}" {{strval($comp->id) == strval($comprobante) ? 'selected' : ''}}>{{$comp->nombre}} [{{$comp->serie}}]</option>
                                    @endforeach
                                </select>
                                @error('comprobante')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                
                </div>
                <h5 class="mb-1" style="color: #1e3890; margin-top:0px">Agregar producto</h5>
                <hr class="mb-1" style="border-top: 1px solid #1e3890;">
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <div class="input-group mb-3" style="position: relative">
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
                                        
                                        <div style="cursor: pointer;" class="resultado" wire:click="asignarProducto('{{ $producto->id }}','{{ $producto->nombre }} [{{ $producto->abreviatura }} x{{$producto->cantidad_unidades}}]',{{$producto->precio_venta}},0,'{{$producto->abreviatura}}',{{$producto->producto_unidad_id}},{{$producto->cantidad_unidades}})">
                                            <a>
                                                {{ $producto->nombre }} [{{ $producto->abreviatura }} x{{$producto->cantidad_unidades}}] <span class="badge badge-{{$producto->stock>0 ? 'success' : 'danger'}}">Stock: {{$producto->stock}}</span>
                                            </a>
                                        </div>
                                    <hr class="my-2">
                                    @endforeach
                                </div>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Unid.</span>
                            </div>
                            <input name="unidad_medida" type="text" readonly class="form-control{{($errors->has('unidad_medida') ? ' is-invalid' : null)}}" wire:model="unidad_medida" >
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Cant.</span>
                            </div>
                            <input name="cantidad" type="number" step="0.001" {{$producto_id ? '' : 'readonly'}} class="form-control{{($errors->has('cantidad') ? ' is-invalid' : null)}}" wire:model="cantidad" >
                            @error('cantidad')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Tot.</span>
                            </div>
                            <input name="precio" type="text" maxlength="10" step="0.01" {{$producto_id ? '' : 'readonly'}} class="form-control{{($errors->has('precio') ? ' is-invalid' : null)}}" placeholder="" wire:model="total" >
                            @error('precio')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-1 mb-3">
                        <div class="input-group mb-3">
                            <button type="submit" class="btn btn-secondary btn-sm btn-block" >Agregar</button>
                        </div>
                    </div>
                
                </div>

            </form>
            </div>
            @livewire('venta.detalle-venta',['venta_id'=>$venta_id])
            @if ($btn_terminar && $editar_venta==false)
                <a href="#" wire:click.prevent="terminarRegistro" class="btn btn-success">Terminar registro</a>
            @elseif($editar_venta==true)
            <h5 style="color: red">Guardar datos de venta!!</h5>
            @endif
            
        </div>

        @livewire('modals.registro-cliente')
        @else
        <div class="alert alert-danger" role="alert">
            El registro ya no es editable
        </div>
        @endif
    @else 
    <div class="alert alert-danger" role="alert">
        Primero aperturar caja
    </div>
    @endif
    
     
</div>
