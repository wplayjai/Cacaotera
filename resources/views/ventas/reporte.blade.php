@extends('layouts.masterr')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
:root {
    --cacao-primary: #4a3728;
    --cacao-secondary: #6b4e3d;
    --cacao-accent: #8b6f47;
    --cacao-light: #d4c4b0;
    --cacao-bg: #f8f6f4;
    --cacao-white: #ffffff;
    --cacao-text: #2c1810;
    --cacao-muted: #8d6e63;
    --success: #2e7d32;
    --warning: #f57c00;
    --danger: #c62828;
    --info: #1976d2;
}

body {
    background: var(--cacao-bg);
    color: var(--cacao-text);
}

/* Container principal */
.main-container {
    background: var(--cacao-white);
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin: 1rem 0;
}

/* Header con gradiente */
.header-professional {
    background: linear-gradient(135deg, var(--cacao-primary) 0%, var(--cacao-secondary) 100%);
    color: var(--cacao-white);
    padding: 1.5rem;
    margin: -1.5rem -1.5rem 1.5rem -1.5rem;
}

/* Título principal */
.main-title {
    color: var(--cacao-white);
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.main-subtitle {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

/* Breadcrumb profesional */
.breadcrumb-professional {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 6px;
    padding: 0.5rem 1rem;
    margin-top: 1rem;
}

.breadcrumb-professional .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: color 0.2s ease;
}

.breadcrumb-professional .breadcrumb-item a:hover {
    color: var(--cacao-white);
}

.breadcrumb-professional .breadcrumb-item.active {
    color: var(--cacao-white);
}

/* Filtros profesionales */
.filters-card {
    background: var(--cacao-white);
    border: 1px solid var(--cacao-light);
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
}

.form-label-professional {
    color: var(--cacao-primary);
    font-weight: 500;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.form-control-professional,
.form-select-professional {
    border: 1px solid var(--cacao-light);
    border-radius: 6px;
    padding: 0.7rem 0.9rem;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    background: var(--cacao-white);
}

.form-control-professional:focus,
.form-select-professional:focus {
    border-color: var(--cacao-accent);
    box-shadow: 0 0 0 0.15rem rgba(139, 111, 71, 0.15);
    outline: none;
}

/* Botones profesionales */
.btn-professional {
    border: none;
    border-radius: 6px;
    padding: 0.7rem 1.3rem;
    font-weight: 500;
    font-size: 0.85rem;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
}

.btn-primary-professional {
    background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary));
    color: var(--cacao-white);
    box-shadow: 0 3px 8px rgba(74, 55, 40, 0.25);
}

.btn-primary-professional:hover {
    background: linear-gradient(135deg, var(--cacao-secondary), var(--cacao-primary));
    color: var(--cacao-white);
    transform: translateY(-1px);
    box-shadow: 0 5px 12px rgba(74, 55, 40, 0.3);
}

.btn-outline-professional {
    background: transparent;
    color: var(--cacao-primary);
    border: 2px solid var(--cacao-light);
}

.btn-outline-professional:hover {
    background: var(--cacao-primary);
    color: var(--cacao-white);
    border-color: var(--cacao-primary);
}

.btn-success-professional {
    background: linear-gradient(135deg, var(--success), #1b5e20);
    color: var(--cacao-white);
    box-shadow: 0 3px 8px rgba(46, 125, 50, 0.25);
}

.btn-success-professional:hover {
    background: linear-gradient(135deg, #1b5e20, var(--success));
    color: var(--cacao-white);
    transform: translateY(-1px);
}

.btn-danger-professional {
    background: linear-gradient(135deg, var(--danger), #b71c1c);
    color: var(--cacao-white);
    box-shadow: 0 3px 8px rgba(198, 40, 40, 0.25);
}

.btn-danger-professional:hover {
    background: linear-gradient(135deg, #b71c1c, var(--danger));
    color: var(--cacao-white);
    transform: translateY(-1px);
}

/* Cards de estadísticas */
.stats-card {
    background: var(--cacao-white);
    border: none;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    margin-bottom: 1rem;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.stats-card-primary {
    background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary));
}

.stats-card-success {
    background: linear-gradient(135deg, var(--success), #1b5e20);
}

.stats-card-info {
    background: linear-gradient(135deg, var(--info), #0d47a1);
}

.stats-card-warning {
    background: linear-gradient(135deg, var(--warning), #e65100);
}

.stats-card .card-body {
    padding: 1.5rem;
    color: var(--cacao-white);
}

.stats-number {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 0.3rem;
}

.stats-label {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-bottom: 0;
}

.stats-icon {
    font-size: 2rem;
    opacity: 0.7;
}

/* Tabla profesional */
.table-professional {
    margin: 0;
    font-size: 0.9rem;
    border-collapse: separate;
    border-spacing: 0;
}

.table-professional thead th {
    background: var(--cacao-primary);
    color: var(--cacao-white);
    border: none;
    padding: 1rem 0.8rem;
    font-weight: 600;
    font-size: 0.85rem;
    text-align: center;
    vertical-align: middle;
    border-bottom: 2px solid var(--cacao-secondary);
    white-space: nowrap;
}

.table-professional tbody td {
    padding: 1rem 0.8rem;
    vertical-align: middle;
    border-color: var(--cacao-light);
    text-align: center;
    font-size: 0.85rem;
    border-top: 1px solid var(--cacao-light);
}

.table-professional tbody tr {
    transition: all 0.2s ease;
}

.table-professional tbody tr:hover {
    background-color: rgba(139, 111, 71, 0.05);
    transform: translateY(-1px);
}

/* Cards de secciones */
.section-card {
    background: var(--cacao-white);
    border: 1px solid var(--cacao-light);
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.section-header {
    background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary));
    color: var(--cacao-white);
    padding: 0.8rem 1.2rem;
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* Badges profesionales */
.badge-professional {
    padding: 0.3rem 0.6rem;
    border-radius: 4px;
    font-weight: 500;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.badge-success-professional {
    background-color: var(--success);
    color: var(--cacao-white);
}

.badge-warning-professional {
    background-color: var(--warning);
    color: var(--cacao-white);
}

.badge-info-professional {
    background-color: var(--info);
    color: var(--cacao-white);
}

/* Estado vacío profesional */
.empty-state {
    text-align: center;
    padding: 3rem 1.5rem;
    color: var(--cacao-muted);
    background: linear-gradient(135deg, rgba(139, 111, 71, 0.02), rgba(139, 111, 71, 0.05));
    border-radius: 8px;
    margin: 1rem;
}

.empty-state-icon {
    font-size: 4rem;
    margin-bottom: 1.5rem;
    opacity: 0.5;
    color: var(--cacao-primary);
}

.empty-state h5 {
    color: var(--cacao-primary);
    margin-bottom: 1rem;
    font-size: 1.3rem;
    font-weight: 600;
}

.empty-state p {
    color: var(--cacao-muted);
    margin-bottom: 1.5rem;
    font-size: 1rem;
}

/* Estados responsivos */
@media (max-width: 768px) {
    .main-container {
        margin: 0.5rem;
        border-radius: 8px;
    }
    
    .header-professional {
        padding: 1.2rem;
        margin: -1rem -1rem 1.2rem -1rem;
    }
    
    .main-title {
        font-size: 1.3rem;
        text-align: center;
    }
    
    .filters-card {
        padding: 1rem;
    }
    
    .table-professional {
        font-size: 0.8rem;
    }
    
    .table-professional thead th,
    .table-professional tbody td {
        padding: 0.7rem 0.5rem;
    }
    
    .btn-professional {
        padding: 0.6rem 1rem;
        font-size: 0.8rem;
        margin-bottom: 0.5rem;
    }
    
    .stats-number {
        font-size: 1.5rem;
    }
    
    .stats-icon {
        font-size: 1.7rem;
    }
    
    .stats-card .card-body {
        padding: 1.2rem;
    }
}

@media (max-width: 576px) {
    .header-professional {
        padding: 1rem;
    }
    
    .main-title {
        font-size: 1.2rem;
    }
    
    .stats-card .card-body {
        padding: 1rem;
    }
    
    .stats-number {
        font-size: 1.3rem;
    }
    
    .stats-label {
        font-size: 0.8rem;
    }
    
    .filters-card .btn-professional {
        width: 100%;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }
}

/* Animaciones profesionales */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="main-container">
                <!-- Header profesional -->
                <div class="header-professional">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="main-title">
                                <i class="fas fa-chart-line"></i>
                                Reportes de Ventas
                            </h1>
                            <p class="main-subtitle">
                                Análisis detallado y estadísticas de ventas del sistema
                            </p>
                            
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-professional mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('ventas.index') }}">
                                            <i class="fas fa-shopping-cart me-1"></i>Ventas
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <i class="fas fa-chart-line me-1"></i>Reportes
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('ventas.reporte.pdf', request()->all()) }}" 
                               class="btn btn-danger-professional">
                                <i class="fas fa-file-pdf"></i>
                                Descargar PDF
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sección de Filtros -->
                <div class="filters-card fade-in-up">
                    <h5 class="section-title text-primary mb-3">
                        <i class="fas fa-filter me-2"></i>Filtros de Búsqueda
                    </h5>
                    
                    <form method="GET" action="{{ route('ventas.reporte') }}">
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label-professional">
                                    <i class="fas fa-calendar-alt"></i>
                                    Fecha Desde
                                </label>
                                <input type="date" 
                                       name="fecha_desde" 
                                       class="form-control form-control-professional" 
                                       value="{{ request('fecha_desde') }}">
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label-professional">
                                    <i class="fas fa-calendar-alt"></i>
                                    Fecha Hasta
                                </label>
                                <input type="date" 
                                       name="fecha_hasta" 
                                       class="form-control form-control-professional" 
                                       value="{{ request('fecha_hasta') }}">
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label-professional">
                                    <i class="fas fa-credit-card"></i>
                                    Estado de Pago
                                </label>
                                <select name="estado_pago" class="form-select form-select-professional">
                                    <option value="">Todos los estados</option>
                                    <option value="pagado" {{ request('estado_pago') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                                    <option value="pendiente" {{ request('estado_pago') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label-professional">
                                    <i class="fas fa-search"></i>
                                    Buscar Cliente
                                </label>
                                <input type="text" 
                                       name="search" 
                                       class="form-control form-control-professional" 
                                       placeholder="Nombre del cliente..." 
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-primary-professional">
                                        <i class="fas fa-filter"></i>
                                        Filtrar
                                    </button>
                                    <a href="{{ route('ventas.reporte') }}" class="btn btn-outline-professional">
                                        <i class="fas fa-undo"></i>
                                        Limpiar
                                    </a>
                                    <a href="{{ route('ventas.index') }}" class="btn btn-success-professional">
                                        <i class="fas fa-arrow-left"></i>
                                        Volver a Ventas
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Tabla de Ventas -->
                <div class="section-card fade-in-up">
                    <div class="section-header">
                        <span>
                            <i class="fas fa-list me-2"></i>
                            Listado de Ventas ({{ $ventas->count() }} registros)
                        </span>
                    </div>
                    <div class="p-0">
                        @if($ventas->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-professional mb-0">
                                    <thead>
                                        <tr>
                                            <th><i class="fas fa-calendar me-1"></i>Fecha</th>
                                            <th><i class="fas fa-user me-1"></i>Cliente</th>
                                            <th><i class="fas fa-seedling me-1"></i>Lote</th>
                                            <th><i class="fas fa-weight me-1"></i>Cantidad (kg)</th>
                                            <th><i class="fas fa-dollar-sign me-1"></i>Precio/kg</th>
                                            <th><i class="fas fa-calculator me-1"></i>Total</th>
                                            <th><i class="fas fa-credit-card me-1"></i>Estado</th>
                                            <th><i class="fas fa-money-bill me-1"></i>Método</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ventas as $venta)
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-column align-items-center">
                                                        <strong class="text-primary">
                                                            {{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}
                                                        </strong>
                                                        <small class="text-muted">
                                                            {{ \Carbon\Carbon::parse($venta->fecha_venta)->locale('es')->isoFormat('dddd') }}
                                                        </small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column align-items-center">
                                                        <strong class="text-dark">{{ $venta->cliente }}</strong>
                                                        @if($venta->telefono_cliente)
                                                            <small class="text-muted">
                                                                <i class="fas fa-phone me-1"></i>{{ $venta->telefono_cliente }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column align-items-center">
                                                        <strong class="text-success">
                                                            {{ $venta->recoleccion->produccion->lote->nombre ?? 'Sin lote' }}
                                                        </strong>
                                                        <small class="text-muted">
                                                            {{ $venta->recoleccion->produccion->tipo_cacao ?? 'N/A' }}
                                                        </small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info-professional">
                                                        {{ number_format($venta->cantidad_vendida, 2) }} kg
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold text-success fs-6">
                                                        ${{ number_format($venta->precio_por_kg, 2) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold text-primary fs-5">
                                                        ${{ number_format($venta->total_venta, 2) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($venta->estado_pago === 'pagado')
                                                        <span class="badge badge-success-professional">
                                                            <i class="fas fa-check-circle me-1"></i>Pagado
                                                        </span>
                                                    @else
                                                        <span class="badge badge-warning-professional">
                                                            <i class="fas fa-clock me-1"></i>Pendiente
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @switch($venta->metodo_pago)
                                                        @case('efectivo')
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                <i class="fas fa-money-bill text-success me-2"></i>
                                                                <span class="small">Efectivo</span>
                                                            </div>
                                                            @break
                                                        @case('transferencia')
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                <i class="fas fa-university text-primary me-2"></i>
                                                                <span class="small">Transferencia</span>
                                                            </div>
                                                            @break
                                                        @case('cheque')
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                <i class="fas fa-money-check text-info me-2"></i>
                                                                <span class="small">Cheque</span>
                                                            </div>
                                                            @break
                                                    @endswitch
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Paginación -->
                            @if($ventas->hasPages())
                                <div class="d-flex justify-content-center py-4">
                                    {{ $ventas->appends(request()->query())->links() }}
                                </div>
                            @endif
                        @else
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h5>No hay ventas para mostrar</h5>
                                <p>Ajusta los filtros para ver resultados diferentes o<br>
                                   verifica que existan ventas registradas en el sistema.</p>
                                <a href="{{ route('ventas.index') }}" class="btn btn-primary-professional">
                                    <i class="fas fa-plus me-2"></i>Crear Nueva Venta
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animaciones de entrada
    const elements = document.querySelectorAll('.fade-in-up');
    elements.forEach((element, index) => {
        element.style.animationDelay = `${index * 0.1}s`;
    });

    // Tooltips para estadísticas
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(-2px)';
        });
    });

    // Validación de fechas
    const fechaDesde = document.querySelector('input[name="fecha_desde"]');
    const fechaHasta = document.querySelector('input[name="fecha_hasta"]');
    
    if (fechaDesde && fechaHasta) {
        fechaDesde.addEventListener('change', function() {
            if (fechaHasta.value && this.value > fechaHasta.value) {
                fechaHasta.value = this.value;
            }
            fechaHasta.min = this.value;
        });
        
        fechaHasta.addEventListener('change', function() {
            if (fechaDesde.value && this.value < fechaDesde.value) {
                fechaDesde.value = this.value;
            }
            fechaDesde.max = this.value;
        });
    }

    // Búsqueda en tiempo real
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const searchTerm = this.value.toLowerCase();
            
            if (searchTerm.length > 2) {
                searchTimeout = setTimeout(() => {
                    // Aquí podrías implementar búsqueda AJAX si fuera necesario
                    console.log('Buscando:', searchTerm);
                }, 300);
            }
        });
    }

    // Atajos de teclado
    document.addEventListener('keydown', function(e) {
        // Ctrl + F para enfocar búsqueda
        if (e.ctrlKey && e.key === 'f') {
            e.preventDefault();
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        }
        
        // Ctrl + P para generar PDF
        if (e.ctrlKey && e.key === 'p') {
            e.preventDefault();
            const pdfBtn = document.querySelector('a[href*="pdf"]');
            if (pdfBtn) {
                pdfBtn.click();
            }
        }
        
        // Escape para limpiar filtros
        if (e.key === 'Escape') {
            const clearBtn = document.querySelector('a[href*="reporte"]:not([href*="pdf"])');
            if (clearBtn && (fechaDesde.value || fechaHasta.value || searchInput.value)) {
                if (confirm('¿Deseas limpiar todos los filtros?')) {
                    clearBtn.click();
                }
            }
        }
    });

    // Efecto de carga suave para la tabla
    const table = document.querySelector('.table-professional');
    if (table) {
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                row.style.transition = 'all 0.3s ease';
                row.style.opacity = '1';
                row.style.transform = 'translateY(0)';
            }, index * 50);
        });
    }

    // Mostrar/ocultar información adicional en móviles
    if (window.innerWidth <= 768) {
        const tableRows = document.querySelectorAll('.table-professional tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('click', function() {
                this.classList.toggle('active');
            });
        });
    }
});

// Función para imprimir reporte
function printReport() {
    const printWindow = window.open('', '_blank');
    const content = document.querySelector('.main-container').innerHTML;
    
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Reporte de Ventas</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                @media print {
                    .btn, .filters-card { display: none !important; }
                    .main-container { box-shadow: none !important; }
                    body { background: white !important; }
                }
            </style>
        </head>
        <body>
            ${content}
        </body>
        </html>
    `);
    
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}
</script>
@endsection
