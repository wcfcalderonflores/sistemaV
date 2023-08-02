@extends('adminlte::page')
@section('title', 'Mostrar Rol')

@section('content_header')
@livewireStyles
    <h1>Mostrar rol</h1>
@stop

@section('content')
@if (session('info'))
    
    <div class="alert alert-success">
        <strong>{{session('info')}}</strong>
    </div>
@endif
    @livewire('admin.list-user')
@stop
@section('js')
@livewireScripts
@stop
