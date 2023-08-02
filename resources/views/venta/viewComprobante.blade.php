@extends('adminlte::page')
@section('title', 'Comprobante')

@section('content_header')
    <h4 style="margin:0px">Impresión de comprobante</h4>
@stop

@section('content')
<div class="embed-responsive embed-responsive-21by9">
    <iframe src="{{route('venta.show',$venta)}}" width="40%" height="900"></iframe>
    
  </div>
    
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
        position: absolute;
        left: 0px;
        top: 65px;
        z-index: 100;
    }
    .resultado:hover{
        background-color: bisque;
    }
    label:not(.form-check-label):not(.custom-file-label) {
        font-weight: 550;
    }
</style>
@stop

@section('js')
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
    });
</script>
<script>
    window.addEventListener('show-form', event =>{
        
            $('#form').modal('show');
        });
</script>
@stop