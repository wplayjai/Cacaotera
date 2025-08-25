<!DOCTYPE html>
<html lang="es" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/cacao.png')}}" type="image/x-icon">
    <title>AgroFinca </title>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

   <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-icons/bootstrap-icons.css') }}">


    <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">

   <link rel="stylesheet" href="{{ asset('assets/toastr/toastr.min.css') }}">
    <!-- Chart.js -->
    
    <link rel="stylesheet" href="{{ asset('css/masterr.css') }}">

    @yield('styles')
    @stack('styles')

</head>

<body>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navigation -->
        <div class="top-nav">
            <div>
                <h1>Panel de Administrador</h1>
                <p class="welcome-text">Bienvenido, Administrador</p>
            </div>
            <div class="user-info">
                
                <div class="dropdown">
                    <a class="dropdown-toggle text-decoration-none" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <span>Mi Cuenta</span>
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li>
                            <a class="dropdown-item" href="{{ route('perfil') }}">
    <i class="fas fa-user mr-2"></i> Ver Perfil
</a>
                        </li>
                        <li>
            <a class="dropdown-item" href="/manual_usuario.pdf" download>
                <i class="fas fa-book mr-2"></i> Manual de Usuario
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
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="container-fluid py-4">
            @yield('content')
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('img/cacao.png') }}" alt="AgroFinca">
            <h4>AgroFinca</h4>
        </div>

        <ul class="sidebar-nav list-unstyled">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
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
                <a href="{{ route('produccion.index') }}" class="nav-link">
                    <i class="bi bi-boxes"></i> Producción
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ventas.index') }}" class="nav-link">
                    <i class="bi bi-cart"></i> Ventas
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

    <!-- Formulario de logout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>


    <!-- jQuery (debe ir ANTES de master.js) -->
    <script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>

    <!-- Bootstrap JS (bundle incluye Popper) -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <!-- Chart.js UMD compatible con navegador -->
    <script src="{{ asset('js/chart.min.js') }}"></script>

    <!-- SweetAlert2 CDN -->
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

    <!-- Toastr CSS y JS -->
   
    <script src="{{ asset('assets/toastr/toastr.min.js') }}"></script>

    <!-- Tu archivo personalizado -->
    <script src="{{ asset('js/masterr.js') }}"></script>



    <!-- Scripts opcionales de Laravel -->
    @yield('scripts')
    @stack('scripts')

</body>
</html>
