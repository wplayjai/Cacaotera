@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Panel de Trabajador</div>

                <div class="card-body">
                    ¡Bienvenido al panel de Trabajador!
                </div>
            </div>
        </div>
    </div>
</div>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-danger">Cerrar sesión</button>
</form>
@endsection
