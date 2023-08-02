
<div class="modal fade bd-example" id="configurarPrecio" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">CONFIGURAR PRECIO DE {{$producto ? $producto->nombre: ''}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body row col-md-12">
                <div  class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('pro','Unidad Medida') !!}
                        {!! Form::select('unidad', $unidad_medidas, $unidad_medida, ['class'=> 'form-control'.($errors->has('unidad_medida') ? ' is-invalid' : null),'wire:model.defer'=>"unidad_medida",]) !!}
                        @error('unidad_medida')
                        <span class="invalid-feedback">{{$message}}</span>
                        @enderror
                    </div>
                    
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('pro','Cant. Unidades') !!}
                        {!! Form::Number('catidad_unidad', null, ['class'=> 'form-control'.($errors->has('cantidad_unidad') ? ' is-invalid' : null), 'wire:model.defer'=>"cantidad_unidad"]) !!}
                        @error('cantidad_unidad')
                        <span class="invalid-feedback">{{$message}}</span>
                        @enderror
                    </div>  
                </div>
                <div class="col-md-12">
                    <a ref="" class="btn btn-primary" wire:click= "{{$btn == 'Editar' ? 'editarConfiguracion' : 'guardarConfiguracion'}}">{{$btn}}</a>
                </div>
                <div class="col-md-12">
                    @if ($producto_unidades)
                    <table class="table table-striped">
                        <thead style="background: #363b3f; color:#f2f2f2">
                            <th>#</th>
                            <th></th>
                            <th>UNID.</th>
                            <th>CANT</th>
                            <!--th>STOCK</th-->
                            <th class="text-center">PRECIO</th>
                        </thead>
                        <tbody>
                            @foreach ($producto_unidades as $index=>$producto_unidad)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>
                                        <a href="#" wire:click="eliminarUnidadProducto({{$producto_unidad->id}})"><i class="fa fa-trash text-danger" aria-hidden="true"></i></a>
                                        <a href="#" wire:click="editarUnidadProducto({{$producto_unidad->id}},{{$producto_unidad->unidad_id}},{{$producto_unidad->cantidad_unidades}})"><i class="fa fa-book" aria-hidden="true"></i></a>
                                    </td>
                                    <td>{{$producto_unidad->nombre}}</td>
                                    <td>{{$producto_unidad->cantidad_unidades}}</td>
                                    <!--td>{{$producto_unidad->stock}}</td-->
                                    <td>
                                        @php
                                            $precioClientes = $this->listarPrecioProductoUnidad($producto_unidad->id);
                                        @endphp
                                        <table class="table table-striped">
                                            <thead style="background: #12202c; color:bisque">
                                                <th>Cliente</th>
                                                <!--th>Compra</th-->
                                                <th>Venta</th>
                                                <th>
                                                    <a href="#" wire:click="seleccinarUnidad({{$producto_unidad->id}},'{{$producto_unidad->nombre}}')">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                    </a>
                                                </th>
                                            </thead>
                                            <tbody>
                                                
                                                @foreach ($precioClientes as $precioCliente)
                                                <tr>
                                                    <td><span class="badge badge-secondary">{{$precioCliente->nombre}}</span></td>
                                                    <!--td><span class="badge badge-warning">S/. $precioCliente->precio_compra ? number_format($precioCliente->precio_compra,2) : ''</span></td-->
                                                    <td><span class="badge badge-warning">S/. {{number_format($precioCliente->precio_venta,2)}}</span></td>
                                                    <td>
                                                        <a href="#" wire:click="eliminarPrecioCliente({{$precioCliente->id}})"><i class="fa fa-trash text-danger" aria-hidden="true"></i></a>
                                                        <a href="#" wire:click="editarPrecioCliente({{$precioCliente->id}})"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                          
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> 
                    @endif
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    
      
      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background: currentColor">
              <h5 class="modal-title" id="exampleModalLabel" style="color: #f2f2f2">PRECIO {{$nombre_unidad}}</h5>
              <button type="button" class="close" wire:click="$emit('cerrarModal')">
                <span aria-hidden="true" style="color:aliceblue">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('CLI','CLIENTE *') !!}
                    {!! Form::select('cliente', $tipo_clientes, null, ['class'=> 'form-control','wire:model.defer'=>"tipo_cliente",'form-control'.($errors->has('tipo_cliente') ? ' is-invalid' : null)]) !!}
                    @error('tipo_cliente')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('PRECIO','PRECIO VENTA *') !!}
                    {!! Form::number('precio_venta', null, ['class'=> 'form-control'.($errors->has('precio_venta') ? ' is-invalid' : null),'step'=>'any','autocomplete'=>'off','placeholder'=>'Ingrese precio venta','wire:model.defer'=>"precio_venta"]) !!}
                    @error('precio_venta')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <!--div class="form-group">
                    {!! Form::label('PRECIO COMPRA','PRECIO COMPRA') !!}
                    {!! Form::number('precio_compra', null, ['class'=> 'form-control'.($errors->has('precio_compra') ? ' is-invalid' : null),'step'=>'any','autocomplete'=>'off','placeholder'=>'Ingrese precio compra','wire:model.defer'=>"precio_compra"]) !!}
                    @error('precio')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div-->
                <div class="modal-footer">
                    <a ref="#" class= "btn btn-primary" wire:click="{{$precio_cliente ? 'editarPrecio' : 'guardarPrecio'}}">{{$precio_cliente ? 'Actualizar' : 'Registrar'}}</a>
                </div>
            </div>
          </div>
        </div>
      </div>
</div>
<!-- Modal -->
<!-- Button trigger modal -->
