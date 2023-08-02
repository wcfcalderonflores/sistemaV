@extends('adminlte::page')
@section('title', 'Reporte General')

@section('content_header')
@livewireStyles
    <h4 style="margin:0px">Margen de Ganacia</h4>
@stop

@section('content')
    @livewire('admin.margen-ganancia')
@stop

@section('css')
<style>
  th{
    font-size: 0.92rem;
  }
  td{
    font-size: 0.93rem;
  }
</style>
@stop
@section('js')
@livewireScripts
@stop