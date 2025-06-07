<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/cacao.png')}}" type="image/x-icon">
    <title>CACAOSOF </title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Chart.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css">
    <link rel="stylesheet" href="{{ asset('css/master.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="http://127.0.0.1:8000/admin/dashboard" class="nav-link">Inicio</a>
                </li>

                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('register.lote.form') }}" class="nav-link">Lotes</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('inventario.index') }}" class="nav-link">Inventario</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Ventas</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Producción</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Informes</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Mi Cuenta
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-user-circle mr-2"></i> Perfil
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-cog mr-2"></i> Configuración
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item bg-danger text-white" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light elevation-2">

            <!-- Brand Logo -->
                <a href="#" class="brand-link text-center">
                <img src="{{ asset('img/cacao.png') }}" alt="Logo" class="brand-logo">
                    <span class="brand-text font-weight-bold">CACAOSOF</span>
                    </a>


            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                    <a href="http://127.0.0.1:8000/admin/dashboard" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Inicio</p>
                    </a>
                </li>
    

                <li class="nav-item">
                    <a href="{{ route('register.lote.form') }}" class="nav-link">
                <i class="nav-icon fas fa-draw-polygon"></i>
                <p>Lotes</p>
                </a>
                </li>

                  
                        <li class="nav-item">
    <a href="{{ route('inventario.index') }}" class="nav-link">
        <i class="nav-icon fas fa-warehouse"></i>
        <p>Inventario</p>
    </a>
</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>Ventas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-industry"></i>
                                <p>Producción</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('trabajadores.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-warehouse"></i>
                                <p>Trabajadores</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>Informes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>Configuración</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">   
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                   
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <button class="btn btn-primary mr-2">Descargar Informe</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
            <!-- /.content-header -->
            <div id="inventory-content" style="display: none;"></div>
            <!-- Main content -->
            <section class="content">
            <div id="dashboard-content">
        @yield('content')
    </div>
                <div class="container-fluid">
                    <!-- Summary boxes -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="summary-box">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>Ventas Totales</h4>
                                        <div class="value">$45,231.89</div>
                                        <div class="sub-text">Últimos 30 días de ventas</div>
                                    </div>
                                    <div>
                                        <i class="fas fa-dollar-sign text-success fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="summary-box">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>Producción Total</h4>
                                        <div class="value">1,245 kg</div>
                                        <div class="sub-text">Últimos 30 días de producción</div>
                                    </div>
                                    <div>
                                        <i class="fas fa-industry text-primary fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="summary-box">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>Clientes Activos</h4>
                                        <div class="value">24</div>
                                        <div class="sub-text">Últimos 30 días de actividad</div>
                                    </div>
                                    <div>
                                        <i class="fas fa-users text-info fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="summary-box">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>Rentabilidad</h4>
                                        <div class="value">32.5%</div>
                                        <div class="sub-text">Promedio de los últimos 30 días</div>
                                    </div>
                                    <div>
                                        <i class="fas fa-chart-line text-warning fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <ul class="nav nav-tabs card-header-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#resumen" data-toggle="tab">Resumen</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#ventas" data-toggle="tab">Ventas</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#produccion" data-toggle="tab">Producción</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#inventario" data-toggle="tab">Inventario</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="resumen">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="card card-dashboard">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Resumen de Ventas</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <canvas id="salesChart" height="300"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                <div class="card shadow-sm border-0 mb-4">
                                                @isset($trabajadores)
                                                
<div class="card-header" style="background-color: #6F4F37; color: white;" d-flex justify-content-between align-items-center">

    <h5 class="mb-0">👷 Trabajadores Recientes</h5>
</div>
<div class="table-responsive" id="tabla-trabajadores">
    <table class="table table-striped">
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
@endisset

                                        <div class="tab-pane" id="ventas">
                                            <!-- Ventas content -->
                                        </div>
                                        <div class="tab-pane" id="produccion">
                                            <!-- Producción content -->
                                        </div>
                                        <div class="tab-pane" id="inventario">
                                            <!-- Inventario content -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
    <!-- Tabla de Inventario Actual -->
   <div class="col-md-6 mb-4 px-3">
    <div class="card card-dashboard">
        <div class="card-header">
            <h3 class="card-title">Inventario Actual</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped" id="dashboard-inventory-table">
            <thead>
        <tr>
            <th>Nombre</th>
            <th>Tipo de Insumo</th>
            <th>Cantidad (kg)</th>
            <th>Estado</th>
        </tr>
            </thead>
               <tbody>
                     <!-- Datos dinámicos -->
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>

    

@push('scripts')
<script>
    $(function() {
    // Cargar datos de inventario al iniciar la página
    loadInventoryData();
    
    // Actualizar cada 30 segundos
    setInterval(loadInventoryData, 30000);
    
    function loadInventoryData() {
    $.ajax({
        url: '{{ route("api.inventario.data") }}',
        method: 'GET',
        success: function(data) {
            const dashboardTable = $('#dashboard-inventory-table tbody');
            dashboardTable.empty();
            
            data.forEach(function(item) {
                const badgeClass = item.estado === 'Óptimo' ? 'badge-success' : 'badge-warning';
                dashboardTable.append(`
                    <tr>
                        <td>${item.nombre}</td>
                        <td>${item.tipo_insumo || 'N/A'}</td>
                        <td>${item.cantidad}</td>
                        <td><span class="badge ${badgeClass}">${item.estado}</span></td>
                    </tr>
                `);
            });
        },
        error: function(error) {
            console.error('Error al cargar datos de inventario:', error);
        }
    });
}
    
    // Escuchar eventos personalizados para actualizar el inventario
    document.addEventListener('inventoryUpdated', function() {
        loadInventoryData();
    });
});
</script>
@endpush

                       <div class="col-md-6 mb-4 px-3">
    <div class="card card-dashboard">
        <div class="card-header">
            <h3 class="card-title">Producción Mensual</h3>
        </div>
        <div class="card-body">
            <canvas id="productionChart" height="250"></canvas>
        </div>
    </div>
</div>
                    </div>
                </div>
            </section>
        </div>

        <div id="inventory-content" class="content-wrapper" style="display: none;"></div>


        <!-- Footer -->
      <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        
    </div>
    <strong>
        Copyright &copy; 2025 
        <a href="#" data-bs-toggle="modal" data-bs-target="#rightsModal">Cacaosof</a>.
    </strong>
    Todos los derechos reservados.
</footer>
<div class="modal fade" id="rightsModal" tabindex="-1" aria-labelledby="rightsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content custom-modal">
      <div class="modal-header">
        <h5 class="modal-title" id="rightsModalLabel">Derechos Reservados</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        Todo el contenido, diseño, textos, imágenes y código fuente son propiedad de <strong>CacaoBooks</strong> y están protegidos por derechos de autor según las leyes vigentes en 2025. Queda prohibida su reproducción total o parcial sin autorización previa.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<style>
    .custom-modal {
    background-color: #f6f0e7; /* fondo café muy suave */
    color: #3e2f1c; /* texto en café oscuro */
    border: 2px solid #d4bda0;
    border-radius: 10px;
}

.custom-modal .modal-header {
    background-color: #d4bda0; /* tono café medio para el encabezado */
    color: #3e2f1c;
    border-bottom: 1px solid #c1a77c;
}

.custom-modal .modal-footer {
    background-color: #f0e8dc;
    border-top: 1px solid #d4bda0;
}
</style>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('AdminLTE-3.2.0/dist/js/adminlte.js') }}"></script>

    <!-- Chart Initialization -->
   <script src="{{ asset('js/master.js') }}" defer></script>
     @yield('scripts')
    @stack('scripts')
</body>

</html>