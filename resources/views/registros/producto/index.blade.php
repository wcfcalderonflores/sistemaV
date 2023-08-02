@extends('adminlte::page')
@section('title', 'Productos')

@section('content_header')
@livewireStyles
    <h1>Lista de Productos</h1>
@stop

@section('content')
    @livewire('registros.list-producto')
@stop
@section('css')
<link href="{{ asset('vendor/toastr/toastr.min.css') }}" rel="stylesheet"/>
<style>
    .form-control {
        height: calc(2.20rem);
        border-radius: 0%;
    }
    label{
        font-size: 14px;
    }
    .form-group{
        margin-bottom: 0.6rem;
    }
    .card-body {
        padding: 0px 1.25rem; 
    }
    .table td, .table th {
        padding: .2rem;
        font-size: 0.92rem;
        text-align: center;
    }
    .modal-header{
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
    }
    .modal{
        overflow: auto;
    }

    #from .modal{
        margin-left: -8px;
    }
    /*.modal-body{
        height: 395px;
        width: 100%;
        overflow-y: auto;
    }*/
    
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
        window.addEventListener('abrirModal', event =>{
            $('#exampleModal').modal('show');
        
        });
    });
</script>
<script>
    window.addEventListener('show-form', event =>{
        $('#form').modal('show');
    });
    Livewire.on('modalConfigurarPrecio', productoId =>{
        Livewire.emit('producto',productoId);
        $('#configurarPrecio').modal('show');

        //console.log(productoId);
    });
    Livewire.on('show-form',event=>{
        $('#form').modal('show');
    });
    Livewire.on('cerrarModal',()=>{
        $('#exampleModal').modal('hide');
    });
    Livewire.on('cerrarModalGuardar',()=>{
        $('#exampleModal').modal('hide');
        //toastr.success('Precio registrado','Exito!');
    });
    Livewire.on('desmarcarRadioButton',()=>{
        $('#radioInafecto').prop('checked',false);
        $('#radioExonerado').prop('checked',false);
        Livewire.emit('afectoIgv');
        //toastr.success('Precio registrado','Exito!');
    });

    /* Modal categoria*/
    Livewire.on('abrilModalCategoria',tipo=>{
        Livewire.emit('registro-categoria-tipo',tipo);
        $('#registroCategoriaModal').modal('show');
    });
    Livewire.on('cerrarModalCategoria',()=>{
        $('#registroCategoriaModal').modal('hide');
    });
</script>
@stop