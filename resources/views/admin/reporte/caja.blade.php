@extends('adminlte::page')
@section('title', 'Reporte Cajas')

@section('content_header')
@livewireStyles
    <h4 style="margin:0px">Reporte Cajas</h4>
@stop

@section('content')
    @livewire('admin.reporte-caja')
@stop

@section('css')
<style>
  th{
    font-size: 0.92rem;
  }
  td{
    font-size: 0.93rem;
  }
  .form-control{
    border-radius: 0%;
  }
</style>
@stop
@section('js')
@livewireScripts
@stop