<!DOCTYPE html>
<html lang="es" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/cacao.png')}}" type="image/x-icon">
    <title>CACAOSOF - Trabajador</title>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Chart.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/masterr.css') }}">
    <link rel="stylesheet" href="{{ asset('css/trabajador/worker-layout.css') }}">

    @yield('styles')
    @stack('styles')
    
</head>

<body>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navigation -->
        <div class="top-nav">
            <div>
                <h1>Panel de Trabajador</h1>
                <p class="welcome-text">Bienvenido, {{ auth()->user()->name ?? 'Trabajador' }}</p>
            </div>
            <div class="user-info">
                <div class="dropdown">
                    <a class="dropdown-toggle text-decoration-none" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <span>Mi Cuenta</span>
                    </a>
                    
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li>
                            <a class="dropdown-item" href="{{ route('trabajador.dashboard') }}">
                                <i class="fas fa-user mr-2"></i> Mi Perfil
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
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="container-fluid py-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content') 
        </div> 
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('img/cacao.png') }}" alt="CACAOSOF">
            <h4>CACAOSOF</h4>
        </div>
        
        <ul class="sidebar-nav list-unstyled">
            <li class="nav-item">
                <a href="{{ route('trabajador.dashboard') }}" class="nav-link">
                    <i class="bi bi-house"></i> Inicio
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('trabajador.modulo') }}" class="nav-link">
                    <i class="bi bi-tools"></i> Módulo de Trabajo
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('trabajador.lotes') }}" class="nav-link">
                    <i class="bi bi-geo-alt"></i> Mis Lotes
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('trabajador.inventario') }}" class="nav-link">
                    <i class="bi bi-boxes"></i> Inventario
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('trabajador.produccion') }}" class="nav-link">
                    <i class="bi bi-leaf"></i> Producción
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('trabajador.reportes') }}" class="nav-link">
                    <i class="bi bi-chart-bar"></i> Mis Reportes
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('trabajador.historial') }}" class="nav-link">
                    <i class="bi bi-history"></i> Mi Historial
                </a>
            </li>
        </ul>
    </div>

    <!-- Formulario de logout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form> 


    <!-- jQuery (debe ir ANTES de master.js) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Bootstrap JS (bundle incluye Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js UMD compatible con navegador -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Toastr CSS y JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Tu archivo personalizado -->
    <script src="{{ asset('js/masterr.js') }}"></script>
   


    <!-- Scripts opcionales de Laravel -->
    @yield('scripts')
    @stack('scripts')
   
</body>
</html>
