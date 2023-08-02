@extends('adminlte::page')
@section('title', 'Editar Venta')

@section('content_header')
@livewireStyles
    <h4 style="margin:0px">Registro de compra</h4>
@stop

@section('content')
@livewire('compra.registro',['compra_id'=>$id])
@stop

@section('css')
<link href="{{ asset('vendor/toastr/toastr.min.css') }}" rel="stylesheet"/>
<style>
    .content-header {
        padding: 10px .5rem;
    }
    .h5, h5 {
        font-size: 1.06rem;
    }
    .mb-1, .my-1 {
    margin-top: 0.6rem;
    }
    .mb-3, .my-3 {
        margin-bottom: 0.2rem!important;
    }
    .form-control, .input-group-text {
    height: calc(2rem);
    }
    .buscador{
        position: relative;
        left: 0px;
        top: 0px;
        z-index: 100;
    }
    .buscador2{
        position: absolute;
        left: 5px;
        top: 35px;
        z-index: 1;
        width: inherit;
        background-color: white;
    }
    .resultado:hover{
        background-color: bisque;
    }
    label:not(.form-check-label):not(.custom-file-label) {
        font-weight: 550;
    }
    .table td, .table th {
        padding: 0.35rem;
    }
</style>
@stop

@section('js')
@livewireScripts
<script src="{{ asset('vendor/toastr/toastr.min.js')}}"></script>
<script>
    $(document).ready(function(){
        toastr.options = {
            "progressBar": true,
            "positionClass": "toast-top-right",
        }
        window.addEventListener('hide-form', event =>{
            $('#form').modal('hide');
            toastr.success(event.detail.message,'Exito!');
        
        });
        window.addEventListener('toastr', event =>{
            toastr.success(event.detail.message,'Exito!');
        
        });
        window.addEventListener('toastr-error', event =>{
        toastr.error(event.detail.message,'Error!!!');
    
        });
    });
</script>
<script>
    window.addEventListener('abrirModal', event =>{
        $('#exampleModal').modal('show');
    
    });
    window.addEventListener('show-form', event =>{
        $('#form').modal('show');
    });
    Livewire.on('modalConfigurarPrecio', productoId =>{
        Livewire.emit('producto',productoId);
        $('#configurarPrecio').modal('show');

        console.log(productoId);
    });
    Livewire.on('show-form',event=>{
        console.log('alexlo');
        $('#form').modal('show');
    });
    Livewire.on('cerrarModal',()=>{
        $('#exampleModal').modal('hide');
    });
    Livewire.on('cerrarModalGuardar',()=>{
        $('#exampleModal').modal('hide');
        //toastr.success('Precio registrado','Exito!');
    });
</script>
@stop