<div>
    <form wire:submit.prevent="listarMargen">
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
    @if ($estado_accion)
        <div class="row">
            <div class="col-sm-6">
                @livewire('venta.margen-ganancia')
            </div>
            <div class="col-sm-6">
                @livewire('movimiento.margen')
            </div>
            <div class="col-sm-6">
                @livewire('compra.margen')
            </div>
        </div> 
    @endif
    
</div>
