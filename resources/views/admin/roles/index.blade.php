@extends('adminlte::page')
@section('title', 'Roles')

@section('content_header')
@livewireStyles
<a href="{{route('admin.roles.create')}}" class="btn btn-secondary float-right"> <i class="fa fa-plus-circle mr-1"></i> Crear Rol</a>
    <h1>Lista de roles</h1>
@stop
@section('css')
<style>
    th{
    font-size: 0.92rem;
    }
    td{
    font-size: 0.93rem;
    }
    .table td, .table th {
    padding: .2rem;
    font-size: 0.92rem;
    text-align: center;
}
</style>
@stop
@section('content')
@if (session('info'))
    
    <div class="alert alert-success">
        <strong>{{session('info')}}</strong>
    </div>
@endif
    @livewire('admin.list-role')
@stop
@section('js')
@livewireScripts
@stop
