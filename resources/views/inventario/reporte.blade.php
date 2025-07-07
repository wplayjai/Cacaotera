@extends('layouts.masterr')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" defer></script>

<style>
    :root {
        --cacao-dark: #3e2723;
        --cacao-medium: #5d4037;
        --cacao-light: #8d6e63;
        --cacao-cream: #efebe9;
        --cacao-beige: #d7ccc8;
        --cacao-accent: #a1887f;
    }
    body {
        background: linear-gradient(135deg, var(--cacao-cream) 0%, var(--cacao-beige) 100%);
        min-height: 100vh;
        font-size: 0.95rem;
    }
    .main-container {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(62, 39, 35, 0.1);
        backdrop-filter: blur(10px);
        margin-bottom: 2rem;
    }
    .header-title {
        color: var(--cacao-dark);
        font-weight: 700;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
        font-size: 1.75rem;
    }
    .header-title i {
        color: var(--cacao-medium);
        margin-right: 10px;
    }
    .btn-pdf {
        background: linear-gradient(145deg, #d32f2f, #b71c1c);
        color: white;
        font-size: 0.9rem;
        padding: 10px 20px;
        font-weight: 600;
        border-radius: 10px;
        border: none;
    }
    .btn-pdf:hover:not(:disabled) {
        background: linear-gradient(145deg, #b71c1c, #d32f2f);
        color: white;
    }
    .table-header {
        background: linear-gradient(145deg, var(--cacao-dark), var(--cacao-medium));
        color: white;
    }
    .table-header th,
    .table tbody td {
        font-size: 0.85rem;
        text-align: center;
        vertical-align: middle;
    }
    .section-title {
        color: var(--cacao-medium);
        font-size: 1.2rem;
        font-weight: 600;
        margin-top: 2rem;
        margin-bottom: 1rem;
        letter-spacing: 1px;
    }
    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="main-container p-4" id="reporteModulo">
                <div class="text-center mb-4">
                    <h1 class="header-title">
                        <i class="fas fa-boxes"></i>
                        Reporte de Inventario
                    </h1>
                    <p class="text-muted">Consulta y descarga el inventario y las salidas registradas</p>
                </div>

                <div class="text-end mb-3 no-print">
                    <a href="{{ route('inventario.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Volver a Inventario
                    </a>
                </div>

                <!-- Listado de Inventarios -->
                <div>
                    <div class="section-title">
                        <i class="fas fa-clipboard-list me-2"></i>Listado de Inventarios
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-4">
                            <thead class="table-header">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Tipo</th>
                                    <th class="text-center">Cantidad (por unidad)</th>
                                    <th class="text-center">Unidad de Medida</th>
                                    <th class="text-center">Precio Unitario</th>
                                    <th class="text-center">Fecha Registro</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="detalleInventario">
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <i class="fas fa-search fa-2x text-muted mb-2"></i><br>
                                        <span class="text-muted">Cargando inventario...</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Lista de Salida de Inventario -->
                <div>
                    <div class="section-title">
                        <i class="fas fa-dolly me-2"></i>Lista de Salida de Inventario
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-4">
                            <thead class="table-header">
                                <tr>
                                    <th>#</th>
                                    <th>Lote</th>
                                    <th>Tipo de Cacao</th>
                                    <th>Tipo</th>
                                    <th>Cantidad</th>
                                    <th>Unidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Insumo</th>
                                </tr>
                            </thead>
                            <tbody id="detalleSalida">
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <i class="fas fa-search fa-2x text-muted mb-2"></i><br>
                                        <span class="text-muted">Cargando salidas...</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-end no-print">
                    <button id="btnDescargarReporte" class="btn btn-pdf">
                        <i class="fas fa-file-pdf me-2"></i>
                        Descargar PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let inventarioData = [];

    function renderInventarioTabla(data) {
        const detalleInventario = document.getElementById('detalleInventario');
        if (!data.length) {
            detalleInventario.innerHTML = `<tr><td colspan="9" class="text-center text-muted">No hay productos en inventario.</td></tr>`;
            return;
        }
        detalleInventario.innerHTML = '';
        data.forEach(producto => {
            detalleInventario.innerHTML += `
                <tr>
                    <td class="text-center">${producto.id}</td>
                    <td class="text-center">${producto.nombre}</td>
                    <td class="text-center">${producto.tipo}</td>
                    <td class="text-center">${producto.cantidad}</td>
                    <td class="text-center">${producto.unidad_medida}</td>
                    <td class="text-center">$${parseFloat(producto.precio_unitario).toFixed(2)}</td>
                    <td class="text-center">${producto.fecha_registro}</td>
                    <td class="text-center">${producto.estado}</td>
                    <td class="text-center"></td>
                </tr>
            `;
        });
    }

    fetch('/inventario/lista')
        .then(res => res.json())
        .then(data => {
            inventarioData = data;
            renderInventarioTabla(inventarioData);
        })
        .catch(() => {
            document.getElementById('detalleInventario').innerHTML = `<tr><td colspan="8" class="text-center text-muted">Error al cargar inventario.</td></tr>`;
        });

    // Salidas
    const detalleSalida = document.getElementById('detalleSalida');
    fetch('/salida-inventario/lista')
        .then(res => res.json())
        .then(data => {
            if (!data.length) {
                detalleSalida.innerHTML = `<tr><td colspan="10" class="text-center text-muted">No hay salidas registradas.</td></tr>`;
                return;
            }
            detalleSalida.innerHTML = '';
            data.forEach((item, i) => {
                detalleSalida.innerHTML += `
                    <tr>
                        <td>${i+1}</td>
                        <td>${item.lote_nombre || ''}</td>
                        <td>${item.tipo_cacao || ''}</td>
                        <td>${item.tipo || ''}</td>
                        <td>${item.cantidad || ''}</td>
                        <td>${item.unidad_medida || ''}</td>
                        <td>$${item.precio_unitario || ''}</td>
                        <td>${item.estado || ''}</td>
                        <td>${item.fecha_registro || ''}</td>
                        <td>${item.insumo_nombre || ''}</td>
                    </tr>
                `;
            });
        })
        .catch(() => {
            detalleSalida.innerHTML = `<tr><td colspan="10" class="text-center text-muted">Error al cargar salidas.</td></tr>`;
        });

    // PDF
    document.getElementById('btnDescargarReporte').addEventListener('click', () => {
        const fecha = new Date().toLocaleDateString('es-ES').replaceAll('/', '-');
        const opciones = {
            margin: 0.5,
            filename: `reporte_inventario_${fecha}.pdf`,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'a3', orientation: 'landscape' }
        };
        html2pdf().set(opciones).from(document.getElementById('reporteModulo')).save();
    });

    // Filtros
    document.getElementById('filtroNombre').addEventListener('input', filtrarInventario);
    document.getElementById('filtroTipo').addEventListener('input', filtrarInventario);
    document.getElementById('btnLimpiarFiltros').addEventListener('click', () => {
        document.getElementById('filtroNombre').value = '';
        document.getElementById('filtroTipo').value = '';
        renderInventarioTabla(inventarioData);
    });

    function filtrarInventario() {
        const nombre = document.getElementById('filtroNombre').value.toLowerCase();
        const tipo = document.getElementById('filtroTipo').value.toLowerCase();
        const filtrados = inventarioData.filter(p =>
            p.nombre.toLowerCase().includes(nombre) &&
            p.tipo.toLowerCase().includes(tipo)
        );
        renderInventarioTabla(filtrados);
    }
});
</script>

@endsection