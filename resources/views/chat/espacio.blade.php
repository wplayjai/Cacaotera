@extends('layouts.app')

@section('title', 'Espacio de Chat')

@section('content')
<div class="container-fluid">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Espacio de Chat</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Espacio de Chat</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box bg-info text-white rounded shadow">
                        <span class="info-box-icon">
                            <i class="fas fa-comments"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Mensajes</span>
                            <span class="info-box-number">{{ number_format($totalMensajes) }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box bg-danger text-white rounded shadow">
                        <span class="info-box-icon">
                            <i class="fas fa-clock"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Mensajes Hoy</span>
                            <span class="info-box-number">{{ $mensajesHoy }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box bg-success text-white rounded shadow">
                        <span class="info-box-icon">
                            <i class="fas fa-users"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Conversaciones Activas</span>
                            <span class="info-box-number">{{ $conversacionesActivas }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box bg-warning text-white rounded shadow">
                        <span class="info-box-icon">
                            <i class="fas fa-hdd"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Espacio Usado</span>
                            <span class="info-box-number">{{ number_format($porcentajeUsado, 1) }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main row -->
            <div class="row mt-4">
                <!-- Espacio de almacenamiento -->
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-chart-pie mr-2"></i>
                                Uso del Espacio de Chat
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-light btn-sm" onclick="limpiarEspacio()">
                                    <i class="fas fa-broom"></i> Limpiar Espacio
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="chart-responsive">
                                        <div class="position-relative mb-4">
                                            <canvas id="espacioChart" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <ul class="chart-legend clearfix">
                                        <li><i class="far fa-circle text-danger"></i> Espacio Usado</li>
                                        <li><i class="far fa-circle text-success"></i> Espacio Disponible</li>
                                    </ul>
                                    <div class="mt-4">
                                        <p><strong>Espacio Total:</strong> {{ \App\Http\Controllers\ChatController::formatBytes($espacioTotal) }}</p>
                                        <p><strong>Espacio Usado:</strong> {{ \App\Http\Controllers\ChatController::formatBytes($espacioUsado) }}</p>
                                        <p><strong>Espacio Disponible:</strong> {{ \App\Http\Controllers\ChatController::formatBytes($espacioDisponible) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas adicionales -->
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header bg-info text-white">
                            <h3 class="card-title mb-0">Detalles del Chat</h3>
                        </div>
                        <div class="card-body">
                            <div class="progress-group">
                                Uso de Almacenamiento
                                <span class="float-right"><b>{{ number_format($porcentajeUsado, 1) }}%</b></span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar 
                                        @if($porcentajeUsado < 50) bg-success 
                                        @elseif($porcentajeUsado < 80) bg-warning 
                                        @else bg-danger 
                                        @endif" 
                                        style="width: {{ $porcentajeUsado }}%"></div>
                                </div>
                            </div>

                            <div class="progress-group mt-3">
                                Mensajes del Día
                                <span class="float-right"><b>{{ $mensajesHoy }}</b>/50</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-primary" style="width: {{ min(($mensajesHoy/50)*100, 100) }}%"></div>
                                </div>
                            </div>

                            <div class="progress-group mt-3">
                                Conversaciones Activas
                                <span class="float-right"><b>{{ $conversacionesActivas }}</b>/20</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-info" style="width: {{ min(($conversacionesActivas/20)*100, 100) }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Consejos de optimización -->
                    <div class="card shadow mt-3">
                        <div class="card-header bg-secondary text-white">
                            <h3 class="card-title mb-0">Consejos de Optimización</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <h5><i class="fas fa-info-circle"></i> Consejo:</h5>
                                Limpia regularmente tus conversaciones antiguas para liberar espacio.
                            </div>
                            @if($porcentajeUsado > 80)
                            <div class="alert alert-warning">
                                <h5><i class="fas fa-exclamation-triangle"></i> Advertencia:</h5>
                                Tu espacio de chat está casi lleno. Considera limpiar mensajes antiguos.
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Enlace rápido para volver -->
                    <div class="mt-3 text-center">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left"></i> Volver al Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(function () {
    // Configuración del gráfico de espacio
    var ctx = document.getElementById('espacioChart');
    if (ctx) {
        var espacioChart = new Chart(ctx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Espacio Usado', 'Espacio Disponible'],
                datasets: [{
                    data: [{{ $espacioUsado }}, {{ $espacioDisponible }}],
                    backgroundColor: ['#dc3545', '#28a745'],
                    borderWidth: 0
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
});

function limpiarEspacio() {
    if (confirm('¿Estás seguro de que deseas limpiar el espacio de chat? Esto eliminará mensajes antiguos.')) {
        $.ajax({
            url: '{{ route("chat.limpiar") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    alert('Espacio limpiado exitosamente. Se liberaron: ' + response.espacioLiberado);
                    location.reload();
                }
            },
            error: function() {
                alert('Error al limpiar el espacio. Inténtalo de nuevo.');
            }
        });
    }
}
</script>
@endsection