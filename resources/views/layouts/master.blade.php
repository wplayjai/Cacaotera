<!DOCTYPE html>
<html lang="es" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CACAOSOF - Panel de Administrador</title>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Chart.js -->
    
    <link rel="stylesheet" href="{{ asset('css/master.css') }}">

    
</head>

<body>
     <div class="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('img/cacao.png') }}" alt="CACAOSOF">

            <h4>CACAOSOF</h4>
        </div>
        
<ul class="sidebar-nav list-unstyled">
    <li class="nav-item">
        <a href="http://127.0.0.1:8000/admin/dashboard" class="nav-link">
            <i class="bi bi-house"></i> Inicio
        </a>
    </li>
            <li class="nav-item">
    <a href="{{ route('lotes.index') }}" class="nav-link">
        <i class="bi bi-geo-alt"></i> Lotes
    </a>
</li>
           <li class="nav-item">
    <a href="{{ route('inventario.index') }}" class="nav-link">
        <i class="bi bi-boxes"></i> Inventario
    </a>
</li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-cart"></i> Ventas
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-gear-wide-connected"></i> Producción
                </a>
            </li>
            <li class="nav-item">
    <a href="{{ route('trabajadores.index') }}" class="nav-link">
        <i class="bi bi-people"></i> Trabajadores
    </a>
</li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-warehouse"></i> Informes
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-gear"></i> Configuración
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navigation -->
        <div class="top-nav">
            <div>
                <h1>Panel de Administrador</h1>
                <p class="welcome-text">Bienvenido, Administrador</p>
            </div>
            <div class="user-info">
                <button class="btn btn-download">
                    <i class="bi bi-download"></i> Descargar Informe
                </button>
     <div class="dropdown">
    <a class="dropdown-toggle text-decoration-none" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        <span>Mi Cuenta</span>
    </a>
    
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        <li>
            <a class="dropdown-item" href="">
                <i class="fas fa-user mr-2"></i> Ver Perfil
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="#">
                <i class="fas fa-cog mr-2"></i> Configuración
            </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
            </a>
        </li>
    </ul>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
            </div>
        </div>

        <!-- Stats Container -->
        <div class="stats-container">
            <!-- Stats Cards -->
            <div class="stats-row">
                <div class="stat-card primary">
                    <div class="stat-card-content">
                        <h3>$45,231.89</h3>
                        <p>Ventas Totales</p>
                        <small>Ultimos 30 días de ventas</small>
                    </div>
                    <div class="stat-card-icon">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                </div>
                
                <div class="stat-card secondary">
                    <div class="stat-card-content">
                        <h3>1,245 kg</h3>
                        <p>Producción Total</p>
                        <small>Ultimo mes de producción</small>
                    </div>
                    <div class="stat-card-icon">
                        <i class="bi bi-gear-wide-connected"></i>
                    </div>
                </div>
                
                <div class="stat-card warning">
                    <div class="stat-card-content">
                        <h3>24</h3>
                        <p>Clientes Activos</p>
                        <small>Clientes con 90 días de actividad</small>
                    </div>
                    <div class="stat-card-icon">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
                
                <div class="stat-card danger">
                    <div class="stat-card-content">
                        <h3>32.5%</h3>
                        <p>Rentabilidad</p>
                        <small>Rentabilidad últimos 30 días</small>
                    </div>
                    <div class="stat-card-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                </div>
            </div>

           <div class="chart-row">
    <div class="chart-card chart-half">
        <div class="chart-header">
            <h5> 💰 Resumen de Ventas</h5>
        </div>
        <div class="chart-container">
            <canvas id="salesChart"></canvas>
        </div>
    </div>
              <div class="table-container">
       <div class="table-header">
            <h5 class="mb-0">👷 Trabajadores Recientes</h5>
        </div>
        <div class="table-responsive" id="tabla-trabajadores">
            <table class="table table-hover mb-0">
                <tbody>
                    @forelse($trabajadores as $trabajador)
                        <tr>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-light text-primary fw-bold d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($trabajador->user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $trabajador->user->name }}</div>
                                        <div class="text-muted small">{{ $trabajador->tipo_contrato }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle text-end">
                                <span class="badge bg-success">{{ $trabajador->telefono }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted py-4">No hay trabajadores registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

          







<!-- 3. VISTA BLADE - dashboard.blade.php -->
<div class="chart-row">
    <!-- 📦 Inventario Actual -->
    <div class="table-container">
        <div class="table-header">
            <h5>📦 Inventario Actual</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped" id="dashboard-inventory-table">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo de Insumo</th>
                            <th>Cantidad (kg)</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventarios as $producto)
                            <tr>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->tipo }}</td>
                                <td>{{ $producto->cantidad }} {{ $producto->unidad_medida }}</td>
                                <td>
                                    @if($producto->estado == 'Óptimo')
                                        <span class="badge bg-success">✅ Óptimo</span>
                                    @elseif($producto->estado == 'Por vencer')
                                        <span class="badge bg-warning text-dark">⚠️ Por vencer</span>
                                    @else
                                        <span class="badge bg-danger">🔒 Restringido</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



 

    <!-- Trabajadores Recientes (si lo quieres al lado) -->
    
                
                 <!-- 🌱 Producción Mensual -->
    <div class="chart-card">
        <div class="chart-header">
            <h5>🌱 Producción Mensual</h5>
        </div>
        <div class="chart-container">
            <canvas id="productionChart"></canvas>
        </div>
    </div>
</div>

    <!-- Bootstrap JS -->
    <!-- jQuery (primero siempre) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Bootstrap JS (con Popper incluido) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Chart.js compatible con uso clásico -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<canvas id="miGrafico"></canvas>

<!-- Tu script principal (sin defer) -->
<script src="{{ asset('js/master.js') }}"></script>

<!-- Laravel Scripts -->
@yield('scripts')
@stack('scripts')

   
</body>
</html>