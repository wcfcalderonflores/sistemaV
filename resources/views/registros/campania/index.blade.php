@extends('adminlte::page')
@section('title', 'Campania')

@section('content_header')
@livewireStyles
    <h1>Lista de Campañas</h1>
@stop

@section('content')

    @livewire('registros.list-campania')
@stop
@section('css')
<link rel="stylesheet" href="{{ mix('css/app.css') }}">
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
    
</style>
@stop

@section('js')
@livewireScripts
<!--script src="{{ mix('js/app.js') }}"></script-->
<script src="{{ asset('vendor/toastr/toastr.min.js')}}"></script>
<script>
    $(document).ready(function(){
        toastr.options = {
            "progressBar": true,
            "positionClass": "toast-top-right",
        }
        window.addEventListener('hide', event =>{
            $('#campania').modal('hide');
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
     window.addEventListener('campaniaModal', event =>{
        $('#campania').modal('show');
        
        });
    Livewire.on('campaniaModal',() =>{
      $('#campania').modal('show');
      Livewire.emitTo('registros.list-campania','rutaModal2');
    });

</script>
@stop