<div class="card">
    <div class="card-header text-center">
     <strong>VENTAS</strong>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col">
            Total ventas :
        </div>
        <div class="col text-right">
            S/. {{number_format($ventas[0]->total_precio_venta,2)}}
        </div>
      </div>
      <div class="row">
        <div class="col">
            Costo Compra :
        </div>
        <div class="col text-right">
            S/. {{number_format($ventas[0]->total_precio_compra,2)}}
        </div>
      </div>
      <div class="row">
        <div class="col">
            <strong>Ganancia :</strong>
        </div>
        @php($ganancia = $ventas[0]->total_precio_venta - $ventas[0]->total_precio_compra)
        <div class="col text-right">
          <span class="badge badge-{{$ganancia >= 0 ? 'success' : 'danger'}}">  S/ {{number_format($ganancia,2)}} </span>
        </div>
      </div>
    </div>
    <div class="card-footer text-muted">
      Fecha : {{date("d/m/Y", strtotime( $desde))}} - {{date("d/m/Y", strtotime( $hasta))}}
    </div>
</div>