<div>
    <div class="card">
      <div class="card-body" style="padding-bottom: 0px;">
        <form wire:submit.prevent="listarVentas">
          <div class="form-row">
            <div class="form-group col-md-5">
              <label>Desde</label>
              <input type="date" wire:model.defer="desde" class="form-control{{($errors->has('desde') ? ' is-invalid' : null)}}" name="desde"/>
              @error('desde')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
            <div class="form-group col-md-5">
              <label>Hasta</label>
              <input type="date" wire:model.defer="hasta" class="form-control{{($errors->has('hasta') ? ' is-invalid' : null)}}" name="hasta">
              @error('hasta')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
            
            <div class="form-group col-md-2">
              <button type="submit" class="btn btn-primary btn-block" style="padding: 9px;margin-top:25px;">Buscar</button>
            </div>
          </div>
        </form>
      </div>

      <div class="row p-1">
        <div class="col-md-12 mr-3 table-responsive-sm">
          @if (count($resultado)>0)
          <table class="table table-sm" >
            <thead style="background-color: #343a40;">
              <tr style="background-color: bisque;">
                <th scope="col" class="text-center" colspan="9">
                  Reporte {{date("d/m/Y", strtotime($desde))}} - {{date("d/m/Y", strtotime($hasta))}}
                </th>
              </tr>
              <tr style="color: white">
                <th scope="col">#</th>
                <th scope="col" class="text-center">COMPROB.</th>
                <th scope="col" class="text-center">CLIENTE</th>
                <th scope="col" class="text-center">FECHA</th>
                <th scope="col" class="text-center">VALOR VENTA</th>
                <th scope="col" class="text-center">DESCUENTO</th>
                <th scope="col" class="text-center">TOTAL</th>
                <th scope="col" class="text-center">SUNAT</th>
              </tr>
            </thead>
            <tbody>
              @php($suma_total = 0)
              @foreach ($resultado as $index=> $resultado)
                @php($total_venta = $resultado->total_venta - $resultado->descuento)
                @php($suma_total = $suma_total + $total_venta)
                <tr>
                  <td>{{$index+1}}</td>
                  <td class="text-center">
                    <a href="#" wire:click.prevent="verComprobante({{$resultado->id}})">
                      {{$resultado->serie}} -{{str_pad($resultado->numero_comprobante,strlen($resultado->numero_maximo)-strlen($resultado->numero_comprobante), "0", STR_PAD_LEFT)}}
                    </a>
                  </td>
                  <td class="text-center">{{$resultado->nombre}} {{$resultado->apellido_paterno}} {{$resultado->apellido_materno}}</td>
                  <td class="text-center">{{date("d/m/Y h:i:A", strtotime( $resultado->fecha))}}</td>
                  <td class="text-center">{{number_format($resultado->total_venta,2)}}</td>
                  <td class="text-center">{{number_format($resultado->descuento,2)}}</td>
                  <td class="text-center">{{number_format($total_venta,2)}}</td>
                  <td class="text-center"><a ref="#" wire:click="$emit('confirmarSunat',{{$resultado->id}},'Desea envia el comprobante a Sunat?')" class="btn btn-outline-success btn-sm"><i class="fa fa-fax" aria-hidden="true"></i>Enviar</button></td>
                </tr> 
              @endforeach
                <tr>
                    <td colspan="5"></td>
                    <td class="text-center">Total Facturado :</td>
                    <td class="text-center"><span class="badge badge-info" style="font-size: 95%"> {{number_format($suma_total,2)}}</span></td>
                    <td></td>
                  </tr>
            </tbody>
          </table>   
          @endif
          
        </div>
      
      </div>
    </div>
</div>