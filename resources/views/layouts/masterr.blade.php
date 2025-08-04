<!DOCTYPE html>
<html lang="es" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/cacao.png')}}" type="image/x-icon">
    <title>CACAOSOF </title>

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

    @yield('styles')
    
</head>

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
    

<body>

      
    <!-- Sidebar -->
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
               <a href="{{ route('ventas.index') }}" class="nav-link">
                    <i class="bi bi-cart"></i> Ventas
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('produccion.index') }}" class="nav-link">
                    <i class="bi bi-boxes"></i> Producción
                </a>
            </li>
            <li class="nav-item">
    <a href="{{ route('trabajadores.index') }}" class="nav-link">
        <i class="bi bi-people"></i> Trabajadores
    </a>
</li>
            <li class="nav-item">
                <a href="{{ route('reportes.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-chart-line"></i> Reportes
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-gear"></i> Configuración
                </a>
            </li>
        </ul>
    </div>

    



<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
            </div>
        </div>

         <div class="container-fluid py-4">
        @yield('content') </div> 


    <!-- jQuery (debe ir ANTES de master.js) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Bootstrap JS (bundle incluye Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js UMD compatible con navegador -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

    <!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- jQuery (debes incluirlo tú manualmente) -->

<!-- Bootstrap 5 JS (sin jQuery) -->



    <!-- Bootstrap 5 JS (sin jQuery) -->





    <canvas id="miGrafico"></canvas>
    


    <!-- Tu archivo personalizado -->
    <script src="{{ asset('js/masterr.js') }}"></script>

    <!-- Scripts opcionales de Laravel -->
    @yield('scripts')
    @stack('scripts')
   
</body>
</html>