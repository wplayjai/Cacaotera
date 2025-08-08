@extends('layouts.masterr')

@section('styles')
    <!-- Múltiples fuentes de Font Awesome para asegurar carga -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
    <link rel="stylesheet" href="{{ asset('css/trabajador/listar.css') }}?v={{ time() }}">
    <style>
        /* Variables CSS para el tema café */
        :root {
            --cafe-oscuro: #4a3728;
            --cafe-medio: #6b4e3d;
            --cafe-claro: #8b6f47;
            --cafe-beige: #a0845c;
            --cafe-muy-claro: #d4c4a0;
            --cafe-fondo: #f5f3f0;
        }
        
        /* Forzar visibilidad de iconos Font Awesome */
        i[class*="fa"] {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", FontAwesome !important;
            font-style: normal !important;
            font-weight: 900 !important;
            display: inline-block !important;
            text-rendering: auto !important;
            -webkit-font-smoothing: antialiased !important;
            -moz-osx-font-smoothing: grayscale !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Específicamente para iconos far (regular) */
        i[class*="far"] {
            font-weight: 400 !important;
        }
        
        /* Específicamente para iconos fas (solid) */
        i[class*="fas"] {
            font-weight: 900 !important;
        }
        
        /* CSS específico para listar asistencias */
        .listar-asistencias-container {
            background-color: #f5f3f0 !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            min-height: 100vh !important;
        }
        
        .listar-asistencias-container .cafe-header-card {
            background: linear-gradient(135deg, #6b4e3d, #8b6f47) !important;
            color: white !important;
            border-radius: 15px !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
        }
        
        .listar-asistencias-container .card-header-cafe {
            background: linear-gradient(135deg, #6b4e3d, #8b6f47) !important;
            color: white !important;
            border-radius: 15px 15px 0 0 !important;
        }
        
        .listar-asistencias-container .btn-nav-primary,
        .listar-asistencias-container .btn-nav-asistencia,
        .listar-asistencias-container .btn-nav-reportes {
            background: linear-gradient(135deg, #6b4e3d, #8b6f47) !important;
            border: 2px solid #6b4e3d !important;
            color: white !important;
            border-radius: 20px !important;
            text-decoration: none !important;
            padding: 8px 16px !important;
            font-weight: 600 !important;
            display: inline-flex !important;
            align-items: center !important;
            transition: all 0.3s ease !important;
        }
        
        .listar-asistencias-container .btn-nav-primary:hover,
        .listar-asistencias-container .btn-nav-asistencia:hover,
        .listar-asistencias-container .btn-nav-reportes:hover {
            background: linear-gradient(135deg, #8b6f47, #a0845c) !important;
            color: white !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2) !important;
        }
        
        /* Sobrescribir estilos específicos de Bootstrap para botones */
        .listar-asistencias-container .btn.btn-nav-primary,
        .listar-asistencias-container .btn.btn-nav-asistencia,
        .listar-asistencias-container .btn.btn-nav-reportes {
            background: linear-gradient(135deg, #6b4e3d, #8b6f47) !important;
            border: 2px solid #6b4e3d !important;
            color: white !important;
            border-radius: 20px !important;
            text-decoration: none !important;
            padding: 8px 16px !important;
            font-weight: 600 !important;
            display: inline-flex !important;
            align-items: center !important;
        }
        
        .listar-asistencias-container .btn.btn-nav-primary:hover,
        .listar-asistencias-container .btn.btn-nav-asistencia:hover,
        .listar-asistencias-container .btn.btn-nav-reportes:hover {
            background: linear-gradient(135deg, #8b6f47, #a0845c) !important;
            color: white !important;
            border-color: #6b4e3d !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2) !important;
        }
        
        .listar-asistencias-container .thead-cafe {
            background: linear-gradient(135deg, #4a3728, #6b4e3d) !important;
        }
        
        .listar-asistencias-container .thead-cafe th {
            color: white !important;
            font-weight: 600 !important;
            padding: 15px !important;
        }
        
        /* Sobrescribir completamente los estilos de tabla Bootstrap */
        .listar-asistencias-container .table {
            background: white !important;
            border: none !important;
            margin-bottom: 0 !important;
        }
        
        .listar-asistencias-container .table thead th {
            background: linear-gradient(135deg, #4a3728, #6b4e3d) !important;
            background-color: #4a3728 !important;
            color: white !important;
            font-weight: 600 !important;
            padding: 15px !important;
            border: none !important;
            text-align: left !important;
            vertical-align: middle !important;
        }
        
        .listar-asistencias-container .table tbody tr {
            background: white !important;
            border-bottom: 1px solid #f5f3f0 !important;
        }
        
        .listar-asistencias-container .table tbody tr:hover {
            background-color: #f5f3f0 !important;
        }
        
        .listar-asistencias-container .table tbody td {
            padding: 12px 15px !important;
            vertical-align: middle !important;
            border: none !important;
            border-top: none !important;
        }
        
        .listar-asistencias-container .tabla-detalle {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            border-radius: 10px !important;
            overflow: hidden !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
        }
        
        .listar-asistencias-container .badge-entrada {
            background: linear-gradient(135deg, #28a745, #20c997) !important;
            color: white !important;
            padding: 8px 12px !important;
            border-radius: 15px !important;
        }
        
        .listar-asistencias-container .badge-salida {
            background: linear-gradient(135deg, #dc3545, #fd7e14) !important;
            color: white !important;
            padding: 8px 12px !important;
            border-radius: 15px !important;
        }
        
        .listar-asistencias-container .badge-horas {
            background: linear-gradient(135deg, #8b6f47, #a0845c) !important;
            color: white !important;
            padding: 8px 15px !important;
            border-radius: 20px !important;
        }
        
        .listar-asistencias-container .badge-contador {
            background: linear-gradient(135deg, #a0845c, #d4c4a0) !important;
            color: #4a3728 !important;
            padding: 8px 15px !important;
            border-radius: 20px !important;
        }
        
        .listar-asistencias-container .btn-exportar-pdf,
        .listar-asistencias-container .btn-generar-reportes {
            background: linear-gradient(135deg, #6b4e3d, #8b6f47) !important;
            color: white !important;
            border: none !important;
            border-radius: 25px !important;
            font-weight: 600 !important;
            padding: 10px 20px !important;
        }
        
        .listar-asistencias-container .btn-nuevo-reporte {
            background: linear-gradient(135deg, #d4c4a0, #a0845c) !important;
            border: 2px solid #a0845c !important;
            color: #4a3728 !important;
            border-radius: 20px !important;
            padding: 8px 16px !important;
            font-weight: 600 !important;
            display: inline-flex !important;
            align-items: center !important;
        }
        
        .listar-asistencias-container .btn-nuevo-reporte:hover {
            background: linear-gradient(135deg, #a0845c, #8b6f47) !important;
            color: white !important;
            transform: translateY(-2px) !important;
        }
        
        .listar-asistencias-container .titulo-principal {
            color: white !important;
            font-size: 2.5rem !important;
            font-weight: 700 !important;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3) !important;
        }
        
        .listar-asistencias-container .subtitulo-principal {
            color: #d4c4a0 !important;
            font-size: 1.2rem !important;
        }
        
        .listar-asistencias-container .icono-blanco {
            color: white !important;
            font-family: "Font Awesome 6 Free", FontAwesome !important;
            font-weight: 900 !important;
            display: inline-block !important;
        }
        
        .listar-asistencias-container .icono-cafe {
            color: #d4c4a0 !important;
            font-family: "Font Awesome 6 Free", FontAwesome !important;
            font-weight: 900 !important;
            display: inline-block !important;
        }
        
        .listar-asistencias-container .icono-cafe-medio {
            color: #a0845c !important;
            font-family: "Font Awesome 6 Free", FontAwesome !important;
            font-weight: 900 !important;
            display: inline-block !important;
        }
        
        .listar-asistencias-container .icono-cafe-oscuro {
            color: #4a3728 !important;
            font-family: "Font Awesome 6 Free", FontAwesome !important;
            font-weight: 900 !important;
            display: inline-block !important;
        }
        
        .listar-asistencias-container .texto-cafe-oscuro {
            color: #4a3728 !important;
            font-weight: 600 !important;
        }
        
        .listar-asistencias-container .texto-no-disponible {
            color: #6b4e3d !important;
            font-style: italic !important;
        }
        
        .listar-asistencias-container .card-contenido {
            background: white !important;
            border-radius: 15px !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08) !important;
            border: none !important;
        }
        
        .listar-asistencias-container .footer-cafe {
            background: linear-gradient(135deg, #f5f3f0, #d4c4a0) !important;
            border-top: 2px solid #a0845c !important;
            border-radius: 0 0 15px 15px !important;
            padding: 15px 20px !important;
        }
        
        .listar-asistencias-container .texto-actualizado {
            color: #6b4e3d !important;
            font-weight: 600 !important;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .listar-asistencias-container .titulo-principal {
                font-size: 2rem !important;
            }
        }
    </style>
@endsection

@section('content')
<div class="listar-asistencias-container">
    <div class="container-fluid">
        <!-- Header con diseño café -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm cafe-header-card">
                    <div class="card-body py-4">
                        <!-- Botones de navegación -->
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex gap-3">
                                <a href="{{ route('trabajadores.index') }}" class="btn btn-sm d-flex align-items-center btn-nav-primary">
                                    <i class="fas fa-users me-2" style="font-size: 0.9rem;"></i>
                                    <span>Trabajadores</span>
                                </a>
                                <a href="{{ route('trabajadores.asistencia') }}" class="btn btn-sm d-flex align-items-center btn-nav-asistencia">
                                    <i class="fas fa-arrow-left me-2" style="font-size: 0.9rem;"></i>
                                    <span>Volver a Asistencia</span>
                                </a>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('trabajadores.reportes') }}" class="btn btn-sm d-flex align-items-center btn-nav-reportes">
                                    <i class="fas fa-chart-bar me-1" style="font-size: 0.8rem;"></i>
                                    <span style="font-size: 0.9rem;">Reportes</span>
                                </a>
                            </div>
                        </div>
                    
                    <!-- Título principal centrado -->
                    <div class="text-center">
                        <h1 class="mb-2 titulo-principal">
                            <i class="fas fa-clipboard-list me-3 icono-cafe"></i>
                            Listado de Asistencias
                        </h1>
                        <p class="mb-0 subtitulo-principal">
                            Consulta y gestión de registros de asistencia
                        </p>
                        <div class="decoracion-emojis">
                            <span class="emoji-grande" style="color: #a0845c;">📋</span>
                            <span class="punto-separador">●</span>
                            <span class="emoji-grande" style="color: #6b4e3d;">⏰</span>
                            <span class="punto-separador">●</span>
                            <span class="emoji-grande" style="color: #a0845c;">📋</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filtro -->
    <div class="card mb-4 shadow-sm border-0 card-contenido">
        <div class="card-header d-flex justify-content-between align-items-center card-header-cafe">
            <span class="icono-blanco" style="font-weight: 600;">
                <i class="fas fa-filter me-2 icono-cafe"></i>Filtrar
            </span>
            <a href="{{ route('trabajadores.asistencia') }}" class="btn btn-sm btn-nuevo-reporte">
                <i class="fas fa-plus-circle me-1 icono-cafe-oscuro"></i>Registrar Nueva Asistencia
            </a>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('trabajadores.listar-asistencias') }}" method="GET">
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label class="form-label fw-bold" style="color: #4a3728;">
                            <i class="far fa-calendar-minus me-1 icono-cafe-medio"></i>Fecha Inicio
                        </label>
                        <input type="date" name="fecha_inicio" class="form-control border-2" value="{{ $fecha_inicio }}" style="border-color: #a0845c !important;">
                    </div>
                    <div class="col-md-5 mb-3">
                        <label class="form-label fw-bold" style="color: #4a3728;">
                            <i class="far fa-calendar-plus me-1 icono-cafe-medio"></i>Fecha Fin
                        </label>
                        <input type="date" name="fecha_fin" class="form-control border-2" value="{{ $fecha_fin }}" style="border-color: #a0845c !important;">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn w-100 btn-exportar-pdf">
                            <i class="fas fa-search me-1 icono-blanco"></i>Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Resultados -->
    <div class="card border-0 shadow-sm card-contenido">
        <div class="card-header d-flex justify-content-between align-items-center card-header-cafe">
            <span class="icono-blanco" style="font-weight: 600;">
                <i class="fas fa-clipboard-list me-2 icono-cafe"></i>Resultados 
                <span class="badge badge-contador">
                    {{ is_countable($asistencias) ? count($asistencias) : $asistencias->count() }} registros
                </span>
            </span>
        </div>

        <div class="card-body p-0">
            @if ((is_countable($asistencias) ? count($asistencias) : $asistencias->count()) > 0)
                <div class="table-responsive">
                    <table class="table tabla-detalle mb-0">
                        <thead class="thead-cafe">
                            <tr>
                                <th>
                                    <i class="fas fa-user me-1 icono-blanco"></i>Trabajador
                                </th>
                                <th>
                                    <i class="far fa-calendar me-1 icono-blanco"></i>Fecha
                                </th>
                                <th>
                                    <i class="far fa-clock me-1 icono-blanco"></i>Hora Entrada
                                </th>
                                <th>
                                    <i class="far fa-clock me-1 icono-blanco"></i>Hora Salida
                                </th>
                                <th>
                                    <i class="fas fa-clock me-1 icono-blanco"></i>Horas
                                </th>
                                <th>
                                    <i class="fas fa-file-alt me-1 icono-blanco"></i>Observaciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($asistencias as $asistencia)
                            <tr class="fila-detalle">
                                <td>
                                    <strong class="texto-cafe-oscuro">
                                        <i class="fas fa-user-tie me-1 icono-cafe-medio"></i>
                                        {{ $asistencia->trabajador->user->name }}
                                    </strong>
                                </td>
                                <td class="texto-cafe-oscuro">
                                    <i class="far fa-calendar-alt me-1 icono-cafe-medio"></i>
                                    {{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}
                                </td>
                                <td>
                                    <span class="badge badge-entrada">
                                        <i class="fas fa-sign-in-alt me-1"></i>
                                        {{ $asistencia->hora_entrada ? \Carbon\Carbon::parse($asistencia->hora_entrada)->format('H:i') : 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-salida">
                                        <i class="fas fa-sign-out-alt me-1"></i>
                                        {{ $asistencia->hora_salida ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('H:i') : 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    @if($asistencia->hora_entrada && $asistencia->hora_salida)
                                        @php
                                            $entrada = \Carbon\Carbon::parse($asistencia->hora_entrada);
                                            $salida = \Carbon\Carbon::parse($asistencia->hora_salida);
                                            $diferencia = $entrada->diff($salida);
                                            $horas = $diferencia->h;
                                            $minutos = $diferencia->i;
                                        @endphp
                                        <span class="badge badge-horas">
                                            <i class="far fa-clock me-1"></i>
                                            {{ $horas }}h {{ $minutos }}m
                                        </span>
                                    @else
                                        <span class="texto-no-disponible">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($asistencia->observaciones)
                                        <span class="texto-observaciones" title="{{ $asistencia->observaciones }}">
                                            <i class="fas fa-comment-alt me-1 icono-cafe-medio"></i>
                                            {{ \Illuminate\Support\Str::limit($asistencia->observaciones, 30) }}
                                        </span>
                                    @else
                                        <span class="texto-no-disponible">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="mensaje-sin-datos">
                                    <i class="fas fa-exclamation-circle me-2 icono-cafe-medio"></i>
                                    <span class="texto-cafe-oscuro fw-bold">No hay registros de asistencia en el periodo seleccionado.</span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                <div class="mensaje-sin-datos p-4">
                    <i class="fas fa-exclamation-circle me-2 icono-cafe-medio"></i>
                    <span class="texto-cafe-oscuro fw-bold">No hay registros de asistencia disponibles.</span>
                </div>
            @endif
        </div>
        <div class="card-footer footer-cafe">
            <small class="texto-actualizado">
                <i class="fas fa-info-circle me-1 icono-cafe-medio"></i>
                Actualizado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
            </small>
            <a href="{{ route('trabajadores.reportes') }}" class="btn btn-generar-reportes">
                <i class="fas fa-file-excel me-2 icono-blanco"></i>Generar Reportes
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Listado de asistencias cargado correctamente');
    
    // Función para verificar si Font Awesome está cargado
    function checkFontAwesome() {
        const testIcon = document.createElement('i');
        testIcon.className = 'fas fa-home';
        testIcon.style.position = 'absolute';
        testIcon.style.left = '-9999px';
        document.body.appendChild(testIcon);
        
        const computed = window.getComputedStyle(testIcon);
        const fontFamily = computed.getPropertyValue('font-family');
        
        document.body.removeChild(testIcon);
        
        return fontFamily.includes('Font Awesome') || computed.getPropertyValue('font-weight') === '900';
    }
    
    // Función para cargar Font Awesome de emergencia
    function loadEmergencyFontAwesome() {
        console.log('Cargando Font Awesome de emergencia...');
        
        // Crear múltiples enlaces de respaldo
        const fontAwesomeUrls = [
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
            'https://use.fontawesome.com/releases/v6.4.0/css/all.css',
            'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'
        ];
        
        fontAwesomeUrls.forEach(url => {
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = url;
            link.onerror = () => console.warn(`Falló cargar: ${url}`);
            document.head.appendChild(link);
        });
    }
    
    // Verificar Font Awesome después de un delay
    setTimeout(() => {
        if (!checkFontAwesome()) {
            console.warn('Font Awesome no detectado, cargando recursos de emergencia...');
            loadEmergencyFontAwesome();
        } else {
            console.log('Font Awesome cargado correctamente');
        }
        
        // Aplicar estilos forzados después de verificar Font Awesome
        applyForcedStyles();
    }, 500);
    
    function applyForcedStyles() {
        // Forzar estilos específicos para botones de navegación
        const navButtons = document.querySelectorAll('.btn-nav-primary, .btn-nav-asistencia, .btn-nav-reportes');
        navButtons.forEach(btn => {
            btn.style.setProperty('background', 'linear-gradient(135deg, #6b4e3d, #8b6f47)', 'important');
            btn.style.setProperty('border', '2px solid #6b4e3d', 'important');
            btn.style.setProperty('color', 'white', 'important');
            btn.style.setProperty('padding', '8px 16px', 'important');
            btn.style.setProperty('border-radius', '20px', 'important');
            btn.style.setProperty('font-weight', '600', 'important');
            btn.style.setProperty('display', 'inline-flex', 'important');
            btn.style.setProperty('align-items', 'center', 'important');
            btn.style.setProperty('text-decoration', 'none', 'important');
        });
        
        // Headers de tabla
        const tableHeaders = document.querySelectorAll('.thead-cafe th');
        tableHeaders.forEach(th => {
            th.style.setProperty('background', 'linear-gradient(135deg, #4a3728, #6b4e3d)', 'important');
            th.style.setProperty('background-color', '#4a3728', 'important');
            th.style.setProperty('color', 'white', 'important');
            th.style.setProperty('font-weight', '600', 'important');
            th.style.setProperty('padding', '15px', 'important');
            th.style.setProperty('border', 'none', 'important');
        });
        
        // Headers de cards
        const cardHeaders = document.querySelectorAll('.card-header-cafe');
        cardHeaders.forEach(header => {
            header.style.setProperty('background', 'linear-gradient(135deg, #6b4e3d, #8b6f47)', 'important');
            header.style.setProperty('color', 'white', 'important');
            header.style.setProperty('border-radius', '15px 15px 0 0', 'important');
        });
        
        // Header principal
        const mainHeader = document.querySelector('.cafe-header-card');
        if (mainHeader) {
            mainHeader.style.setProperty('background', 'linear-gradient(135deg, #6b4e3d, #8b6f47)', 'important');
            mainHeader.style.setProperty('color', 'white', 'important');
            mainHeader.style.setProperty('border-radius', '15px', 'important');
        }
        
        // Botón de nuevo reporte
        const btnNuevo = document.querySelector('.btn-nuevo-reporte');
        if (btnNuevo) {
            btnNuevo.style.setProperty('background', 'linear-gradient(135deg, #d4c4a0, #a0845c)', 'important');
            btnNuevo.style.setProperty('color', '#4a3728', 'important');
            btnNuevo.style.setProperty('border', '2px solid #a0845c', 'important');
        }
        
        // Forzar estilos específicos para TODOS los iconos
        const iconos = document.querySelectorAll('i[class*="fa"]');
        iconos.forEach(icono => {
            icono.style.setProperty('font-family', '"Font Awesome 6 Free", FontAwesome', 'important');
            icono.style.setProperty('font-style', 'normal', 'important');
            icono.style.setProperty('display', 'inline-block', 'important');
            icono.style.setProperty('text-rendering', 'auto', 'important');
            icono.style.setProperty('-webkit-font-smoothing', 'antialiased', 'important');
            icono.style.setProperty('visibility', 'visible', 'important');
            icono.style.setProperty('opacity', '1', 'important');
            
            // Aplicar font-weight según el tipo de icono
            if (icono.classList.contains('fas')) {
                icono.style.setProperty('font-weight', '900', 'important');
            } else if (icono.classList.contains('far')) {
                icono.style.setProperty('font-weight', '400', 'important');
            }
        });
        
        console.log(`Iconos procesados: ${iconos.length}`);
    }
    
    // Verificar iconos después de un delay más largo
    setTimeout(() => {
        const iconos = document.querySelectorAll('i[class*="fa"]');
        console.log(`Total iconos encontrados: ${iconos.length}`);
        
        // Contar iconos que no se están mostrando correctamente
        let iconosProblematicos = 0;
        iconos.forEach((icono, index) => {
            const computed = window.getComputedStyle(icono);
            const fontFamily = computed.getPropertyValue('font-family');
            
            if (!fontFamily.includes('Font Awesome') && !fontFamily.includes('FontAwesome')) {
                iconosProblematicos++;
                console.warn(`Icono ${index} con problema:`, icono.className, 'Font:', fontFamily);
                
                // Aplicar fix específico para este icono
                icono.style.setProperty('font-family', '"Font Awesome 6 Free"', 'important');
            }
        });
        
        if (iconosProblematicos > 0) {
            console.warn(`${iconosProblematicos} iconos con problemas detectados`);
        } else {
            console.log('Todos los iconos están funcionando correctamente');
        }
    }, 2000);
    
    console.log('Estilos aplicados correctamente');
});
</script>
@endsection
