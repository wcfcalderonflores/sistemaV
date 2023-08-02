<div>
  @if (count($movimientos) > 0)
    <div class="card">
      <div class="card-header text-center">
      <strong>MOVIMIENTOS</strong>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col">
              Total Ingresos :
          </div>
          <div class="col text-right">
              S/. {{number_format($movimientos[0]->ingresos,2)}}
          </div>
        </div>
        <div class="row">
          <div class="col">
              Total Egresos :
          </div>
          <div class="col text-right">
              S/. {{number_format($movimientos[0]->egresos,2)}}
          </div>
        </div>
        <div class="row">
          <div class="col">
              <strong>Diferencia :</strong>
          </div>
          @php($diferencia = $movimientos[0]->ingresos - $movimientos[0]->egresos)
          <div class="col text-right">
            <span class="badge badge-{{$diferencia >= 0 ? 'success' : 'danger'}}">  S/ {{number_format($diferencia,2)}} </span>
          </div>
        </div>
      </div>
      <div class="card-footer text-muted">
        Fecha : {{date("d/m/Y", strtotime( $desde))}} - {{date("d/m/Y", strtotime( $hasta))}}
      </div>
  </div> 
  @endif
</div>
