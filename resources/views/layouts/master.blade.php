<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/cacao.png')}}" type="image/x-icon">
    <title>CACOSOF </title>
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
    <script src="{{ asset('js/app.js') }}" defer></script>
    <style>
        .main-sidebar {
            background-color: #f8f9fa;
            color: #343a40;
        }
        .nav-link.active {
            background-color: #28a745 !important;
        }
        .card-dashboard {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-warning {
            background-color: #ffc107;
        }
        .summary-box {
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .summary-box h4 {
            margin-top: 0;
            color: #495057;
        }
        .summary-box .value {
            font-size: 24px;
            font-weight: bold;
            color: #212529;
        }
        .summary-box .sub-text {
            font-size: 12px;
            color: #6c757d;
        }
        .brand-link {
    display: flex;
    align-items: center;
    justify-content: center;
}

.brand-logo {
    width: 40px; /* Ajusta el tamaño según necesites */
    height: auto;
    margin-right: 8px; /* Espacio entre el logo y el texto */
}

    </style>
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
                    <a href="#" class="nav-link">Dashboard</a>
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
<!-- Brand Logo -->
<a href="#" class="brand-link text-center">
    <img src="{{ asset('img/cacao.png') }}" alt="Logo" class="brand-logo">
    <span class="brand-text font-weight-bold">CACOSOF</span>
</a>


            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                                
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
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
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
                                                    <div class="card card-dashboard">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Trabajadores Recientes</h3>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="mr-2">
                                                                                        <div class="bg-light rounded-circle" style="width: 30px; height: 30px; text-align: center; line-height: 30px;">J</div>
                                                                                    </div>
                                                                                    <div>
                                                                                        <div class="font-weight-bold">Juan Díaz</div>
                                                                                        <div class="small text-muted">Cooperativa El Progreso</div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-right text-success">+$1,999.00</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="mr-2">
                                                                                        <div class="bg-light rounded-circle" style="width: 30px; height: 30px; text-align: center; line-height: 30px;">M</div>
                                                                                    </div>
                                                                                    <div>
                                                                                        <div class="font-weight-bold">María Rodríguez</div>
                                                                                        <div class="small text-muted">Chocolates Finos S.A.</div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-right text-success">+$3,500.00</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="mr-2">
                                                                                        <div class="bg-light rounded-circle" style="width: 30px; height: 30px; text-align: center; line-height: 30px;">C</div>
                                                                                    </div>
                                                                                    <div>
                                                                                        <div class="font-weight-bold">Carlos Pérez</div>
                                                                                        <div class="small text-muted">Exportadora Cacao Premium</div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-right text-success">+$2,750.00</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="mr-2">
                                                                                        <div class="bg-light rounded-circle" style="width: 30px; height: 30px; text-align: center; line-height: 30px;">L</div>
                                                                                    </div>
                                                                                    <div>
                                                                                        <div class="font-weight-bold">Laura Gómez</div>
                                                                                        <div class="small text-muted">Dulces Artesanales</div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-right text-success">+$899.00</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="mr-2">
                                                                                        <div class="bg-light rounded-circle" style="width: 30px; height: 30px; text-align: center; line-height: 30px;">A</div>
                                                                                    </div>
                                                                                    <div>
                                                                                        <div class="font-weight-bold">Andrés Martínez</div>
                                                                                        <div class="small text-muted">Distribuidora Orgánica</div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-right text-success">+$1,250.00</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
    <div class="col-md-6">
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

                        <div class="col-md-6">
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
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2025 <a href="#">CacaoBooks</a>.</strong> Todos los derechos reservados.
        </footer>
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
    <script>
        // Sales Chart
        var salesCtx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [{
                    label: 'Ventas',
                    data: [2500, 9500, 3000, 5000, 2000, 3000, 4000, 5000, 3000, 2000, 5000, 4000],
                    backgroundColor: '#28a745',
                    borderColor: '#28a745',
                    borderWidth: 1
                }, {
                    label: 'Producción',
                    data: [1500, 2000, 2500, 3000, 1500, 2000, 3000, 2500, 3500, 3000, 2000, 3000],
                    backgroundColor: '#fd7e14',
                    borderColor: '#fd7e14',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        // Production Chart
        var productionCtx = document.getElementById('productionChart').getContext('2d');
        var productionChart = new Chart(productionCtx, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [{
                    label: 'Criollo',
                    data: [300, 350, 400, 450, 300, 350, 400, 450, 500, 450, 400, 450],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    fill: true
                }, {
                    label: 'Forastero',
                    data: [200, 250, 300, 350, 250, 300, 350, 300, 350, 400, 350, 300],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    fill: true
                }, {
                    label: 'Trinitario',
                    data: [150, 200, 250, 300, 200, 250, 300, 250, 300, 350, 300, 250],
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1,
                    fill: true
                }, {
                    label: 'Orgánico',
                    data: [100, 150, 200, 250, 150, 200, 250, 200, 250, 300, 250, 200],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
       
    </script>
    <script>
   $(document).ready(function() {
    // Handle click on Inventory menu item
    $('.nav-link, .nav-sidebar .nav-link').filter(function() {
        return $(this).text().trim() === 'Inventario';
    }).on('click', function(e) {
        e.preventDefault();
        
        // Hide dashboard content
        $('.content-wrapper > .content-header, .content-wrapper > .content > .container-fluid').hide();
        $('#dashboard-content').hide();
        
        // Show inventory content container and load it via AJAX
        $('#inventory-content').show().html('<div class="text-center mt-5"><i class="fas fa-spinner fa-spin fa-3x"></i><p class="mt-2">Cargando inventario...</p></div>');
        
        $.ajax({
            url: $(this).attr('href'),
            method: 'GET',
            success: function(response) {
                // Extract only the content part from the response
                const contentMatch = /<div class="content-wrapper">([\s\S]*?)<footer class="main-footer">/i.exec(response);
                
                if (contentMatch && contentMatch[1]) {
                    // Insert just the content portion
                    $('#inventory-content').html(contentMatch[1]);
                } else {
                    // If extraction fails, insert the complete response
                    $('#inventory-content').html(response);
                }
                
                // Activate the corresponding menu item
                $('.nav-sidebar .nav-link').removeClass('active');
                $('.nav-sidebar .nav-link').filter(function() {
                    return $(this).text().trim() === 'Inventario';
                }).addClass('active');
                
                // Initialize inventory event handlers
                initInventoryEventHandlers();
            },
            error: function() {
                $('#inventory-content').html('<div class="alert alert-danger m-5">Error al cargar el inventario.</div>');
            }
        });
    });
    
    // Event delegation for the back to dashboard button
    $(document).on('click', '.back-to-dashboard, .inventory-back-btn, [data-action="back-to-dashboard"]', function(e) {
        e.preventDefault();
        
        // Hide inventory content
        $('#inventory-content').hide();
        
        // Show dashboard content
        $('.content-wrapper > .content-header, .content-wrapper > .content > .container-fluid').show();
        $('#dashboard-content').show();
        
        // Activate Dashboard menu
        $('.nav-sidebar .nav-link').removeClass('active');
        $('.nav-sidebar .nav-link').filter(function() {
            return $(this).text().trim() === 'Dashboard';
        }).addClass('active');
        
        // Update dashboard data if needed
        if (typeof loadInventoryData === 'function') {
            loadInventoryData();
        }
    });
    
    // Function to initialize inventory event handlers
    function initInventoryEventHandlers() {
        // Agregar Producto (AJAX)
        $('#addProductForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: $('#addProductForm').attr('action') || '/inventario',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    // Agregar nueva fila a la tabla
                    const newRow = `
                        <tr data-id="${response.producto.id}">
                            <td>${response.producto.id}</td>
                            <td>${response.producto.nombre}</td>
                            <td>${response.producto.tipo_insumo}</td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control cantidad-input" value="${response.producto.cantidad}" data-id="${response.producto.id}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary update-cantidad-btn" data-id="${response.producto.id}">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge ${response.producto.estado === 'Óptimo' ? 'badge-success' : 'badge-warning'}">
                                    ${response.producto.estado}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm delete-producto-btn" data-id="${response.producto.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    
                    $('#inventoryTable tbody').append(newRow);
                    
                    // Mostrar mensaje de éxito
                    $('#ajaxResponse').html(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ${response.message}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                    
                    // Cerrar modal
                    $('#inventoryModal').modal('hide');
                    
                    // Limpiar formulario
                    $('#addProductForm')[0].reset();
                },
                error: function(xhr) {
                    // Manejar errores
                    $('#ajaxResponse').html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Error al agregar producto: ${xhr.responseJSON.message || 'Ha ocurrido un error'}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                }
            });
        });

        // Actualizar Cantidad (AJAX) - usando delegación de eventos
        $(document).off('click', '.update-cantidad-btn').on('click', '.update-cantidad-btn', function() {
            const id = $(this).data('id');
            const cantidad = $(this).closest('td').find('.cantidad-input').val();
            const row = $(this).closest('tr');
            
            $.ajax({
                url: `/inventario/${id}`,
                method: 'PUT',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    cantidad: cantidad
                },
                success: function(response) {
                    // Actualizar estado
                    const badge = row.find('.badge');
                    badge.removeClass('badge-success badge-warning')
                         .addClass(response.producto.estado === 'Óptimo' ? 'badge-success' : 'badge-warning')
                         .text(response.producto.estado);
                    
                    // Mostrar mensaje de éxito
                    $('#ajaxResponse').html(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ${response.message}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                },
                error: function(xhr) {
                    // Manejar errores
                    $('#ajaxResponse').html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Error al actualizar producto: ${xhr.responseJSON ? xhr.responseJSON.message : 'Ha ocurrido un error'}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                }
            });
        });

        // Eliminar Producto (AJAX) - usando delegación de eventos
        $(document).off('click', '.delete-producto-btn').on('click', '.delete-producto-btn', function() {
            const id = $(this).data('id');
            const row = $(this).closest('tr');
            
            if(confirm('¿Estás seguro de eliminar este producto?')) {
                $.ajax({
                    url: `/inventario/${id}`,
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Eliminar fila de la tabla
                        row.remove();
                        
                        // Mostrar mensaje de éxito (asumiendo que la respuesta es JSON)
                        let message = typeof response === 'object' ? response.message : 'Producto eliminado exitosamente';
                        
                        $('#ajaxResponse').html(`
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                ${message}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `);
                    },
                    error: function(xhr) {
                        // Manejar errores
                        $('#ajaxResponse').html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Error al eliminar producto: ${xhr.responseJSON ? xhr.responseJSON.message : 'Ha ocurrido un error'}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `);
                    }
                });
            }
        });
    }
    
    // Initialize on page load for direct access
    initInventoryEventHandlers();
});

</script>

     @yield('scripts')
    @stack('scripts')
</body>

</html>