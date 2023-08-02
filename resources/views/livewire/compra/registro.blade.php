<div class="card">
    @if (session()->has('arqueo'))
        @if ($estado_compra=='2')
        <div class="card-body" style="padding-top: 0px">
        
            <div class="col-md-12 order-md-1">  
            <form wire:submit.prevent="registrarCompra" >
                <div style="display: flex">
                    <a href="#" class="btn btn-secondary btn-sm" wire:click.prevent="agregarProveedor" style="height: 28px; margin-top:6px; margin-left: 2px"><i class="fa fa-plus-circle mr-1"></i>Proveedor</a>
                    @if ($compra)
                    <a href="#" class="btn btn-secondary btn-sm" wire:click.prevent="{{$editar_compra ? 'guardarCompra' : 'editarCompra'}}" style="height: 28px; margin-top:6px; margin-left: 2px"><i class="fa fa-edit mr-1"></i>{{$editar_compra ? 'Guardar' : 'Editar'}}</a>
                    <a href="#" class="btn btn-danger btn-sm" wire:click.prevent="eliminarCompra()" style="height: 28px; margin-top:6px; margin-left: 2px"><i class="fa fa-times mr-1"></i>Eliminar</a>
                    @endif 
                </div>
                <div class="row">
                    <div class="col-md-12 mb-1">
                        
                        <div class="row">
                            <div class="col-md-4 mb-3" style="position: relative">
                                <label for="firstName"><strong>Buscar</strong>
                                    @if($picked)
                                        <span class="badge badge-success">Seleccionado</span>
                                    @else
                                        <span class="badge badge-danger">Seleccionar</span>
                                    @endif
                                </label>
                                <input autocomplete="off" name="buscar" wire:model="buscar" {{$compra ? ($editar_compra ? '': 'readonly'): ''}}
                                 type="text" placeholder="Busq. por Nombres" class="form-control{{($errors->has('proveedor_id') ? ' is-invalid' : null)}}">
                                    @error('proveedor_id')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                            @error("proveedor_id")                                                     
                            @else
                                @if(count($proveedores)>0)
                                    @if(!$picked)
                                    <div class="shadow rounded px-2 pt-2 pb-0 buscador">
                                        @foreach($proveedores as $proveedor)
                                            <div style="cursor: pointer;" class="resultado" wire:click="asignarProveedor('{{ $proveedor->id }}','{{ $proveedor->nombre }} {{$proveedor->apellido_paterno}} {{$proveedor->apellido_materno}}')">
                                                <a>
                                                    {{ $proveedor->nombre }} {{$proveedor->apellido_paterno}} {{$proveedor->apellido_materno}}
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
                            <div class="col-md-2 mb-3">
                                <label for="lastName">Comprobante</label>
                                <select name="comprobante" {{$compra ? ($editar_compra ? '': 'disabled'): ''}} class="form-control{{($errors->has('comprobante') ? ' is-invalid' : null)}}" wire:model.defer="comprobante">
                                   @foreach ($comprobantes as $comprobante)
                                       <option value="{{$comprobante->id}}">{{$comprobante->nombre}}</option>
                                   @endforeach
                                </select>
                                @error('comprobante')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="lastName">Número</label>
                                <input type="text" {{$compra ? ($editar_compra ? '': 'readonly'): ''}} name="numero_comprobante" class="form-control{{($errors->has('numero_comprobante') ? ' is-invalid' : null)}}" wire:model.defer="numero_comprobante">
                                </select>
                                @error('numero_comprobante')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="lastName">Fecha Compra</label>
                                <input type="date" {{$compra ? ($editar_compra ? '': 'readonly'): ''}} name="fecha_compra" class="form-control{{($errors->has('fecha_compra') ? ' is-invalid' : null)}}" wire:model.defer="fecha_compra">
                                </select>
                                @error('fecha_compra')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="lastName">Forma de pago</label>
                                <select name="forma_pago" {{$compra ? ($editar_compra ? '': 'disabled'): ''}} class="form-control{{($errors->has('forma_pago') ? ' is-invalid' : null)}}" wire:model.defer="forma_pago">
                                    <option value="1">Contado</option>
                                    <option value="2">Crédito</option>
                                </select>
                                @error('forma_pago')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                                <div class="custom-control custom-switch">
                                    <input {{$compra ? ($editar_compra ? '': 'disabled'): ''}} type="checkbox" /*wire:click="estadoIgv()"*/ wire:model="igv" class="custom-control-input" id="customSwitch1">
                                    <label class="custom-control-label" for="customSwitch1">IGV</label>
                                </div>
                            </div>
                            @if ($igv != '0')
                                <!--div class="col-md-2">
                                    <div class="custom-control custom-switch">
                                        <input {{$compra ? ($editar_compra ? '': 'disabled'): ''}} type="checkbox" wire:model="incluye_igv" class="custom-control-input" id="customSwitch2">
                                        <label class="custom-control-label" for="customSwitch2">Incluye IGV</label>
                                    </div>
                                </div-->  
                            @endif
                            
                        </div>
                    </div>
                </div>
                
                <h5 class="mb-1" style="color: #1e3890; margin-top:0px">Agregar producto
                    <!--div class="custom-control custom-switch" style="display: inline">
                        <input type="checkbox"  wire:model="actualizar_precio_venta" class="custom-control-input" id="customSwitch3">
                        <label class="custom-control-label" for="customSwitch3">Act. P.venta</label>
                    </div--> 
                    @if ($producto_id)
                        <a style="color: #14263a; margin-left: 3px" wire:click="$emit('modalConfigurarPrecio',{{$producto_id}})" href="#"><i class="fa fa-calculator" aria-hidden="true"></i></a>
                    @endif
                </h5>
                <hr class="mb-1" style="border-top: 1px solid #1e3890;">
                <div class="row">
                    <div class="col-md-4 mb-3">
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
                                        <div style="cursor: pointer;" class="resultado" wire:click="asignarProducto('{{ $producto->id }}','{{ $producto->nombre }} [{{ $producto->abreviatura }} x{{$producto->cantidad_unidades}}]','{{$producto->abreviatura}}',{{$producto->producto_unidad_id}},{{$producto->cantidad_unidades}})">
                                            <a>
                                                {{ $producto->nombre }} [{{ $producto->abreviatura }} x{{$producto->cantidad_unidades}}]
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
                            <span class="input-group-text" id="basic-addon1">Precio</span>
                            </div>
                            <input name="precio" type="number" step="0.001" {{$producto_id ? '' : 'readonly'}} class="form-control{{($errors->has('precio') ? ' is-invalid' : null)}}" wire:model="precio" >
                            @error('precio')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <div class="input-group mb-3">
                            <button type="submit" class="btn btn-secondary btn-sm btn-block" >Agregar</button>
                        </div>
                    </div>
                
                </div>

            </form>
            </div>
            @livewire('compra.detalle-compra',['compra_id'=>$compra_id,'igv' => $igv, 'igv_porcentaje' => $igv_porcentaje])
            @if ($btn_terminar && $editar_compra==false)
                <a href="#" wire:click.prevent="terminarRegistro" class="btn btn-success">Terminar registro</a>
            @elseif($editar_compra==true)
            <h5 style="color: red">Guardar datos de compra!</h5>
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
    
    @livewire('modals.configurar-precio')
</div>
