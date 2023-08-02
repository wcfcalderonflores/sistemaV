<div>
@if (count($compras) > 0)
    <div class="card">
        <div class="card-header text-center">
        <strong>COMPRAS</strong>
        </div>
        <div class="card-body">
            @foreach ($compras as $compra)
                <div class="row">
                    <div class="col">
                        {{$compra->forma_pago == '1' ? 'Contado' : 'Crédito'}}
                    </div>
                    <div class="col text-right">
                        S/. {{number_format($compra->total,2)}}
                    </div>
                </div>
            @endforeach
        
        </div>
        <div class="card-footer text-muted">
        Fecha : {{date("d/m/Y", strtotime( $desde))}} - {{date("d/m/Y", strtotime( $hasta))}}
        </div>
    </div>
@endif
</div>