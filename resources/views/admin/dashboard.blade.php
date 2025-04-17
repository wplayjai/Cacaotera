@extends('layouts.master')

@section('tituloPagina', 'Panel Administrador')

@section('content')
<div class="container">
    <h1>Panel de Administrador</h1>
    <p>Bienvenido, {{ auth()->user()->name }}!</p>
</div>
@endsection

