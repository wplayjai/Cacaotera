// SISTEMA DE GESTIÓN CACAOTERA - JAVASCRIPT MEJORADO
let reporteActual = "lote"
const filtrosActivos = {}
let bootstrap // Declare the bootstrap variable

// Configuración de módulos
const modulosConfig = {
  lote: {
    icon: "fas fa-map-marked-alt",
    title: "Gestión de Lotes",
    description: "Administración de terrenos y cultivos de cacao",
    details: "Control de áreas, capacidades, tipos de cacao y estado de los lotes",
    color: "var(--cacao-primary)",
  },
  inventario: {
    icon: "fas fa-boxes",
    title: "Control de Inventario",
    description: "Gestión de insumos y materiales agrícolas",
    details: "Seguimiento de fertilizantes, pesticidas, herramientas y semillas",
    color: "var(--cacao-secondary)",
  },
  ventas: {
    icon: "fas fa-shopping-cart",
    title: "Análisis de Ventas",
    description: "Control de ingresos y relaciones comerciales",
    details: "Monitoreo de ventas, clientes, precios y métodos de pago",
    color: "var(--cacao-accent)",
  },
  produccion: {
    icon: "fas fa-seedling",
    title: "Control de Producción",
    description: "Supervisión de cultivos y rendimiento",
    details: "Seguimiento de ciclos productivos, rendimiento y progreso de cultivos",
    color: "var(--cacao-light)",
  },
  trabajadores: {
    icon: "fas fa-users",
    title: "Recursos Humanos",
    description: "Administración de personal y nómina",
    details: "Control de trabajadores, contratos, asistencia y métodos de pago",
    color: "#5D4037",
  },
}

// Inicialización mejorada
document.addEventListener("DOMContentLoaded", () => {
  inicializarDashboard()
  cargarReporte("lote")
})

function inicializarDashboard() {
  // Agregar animaciones de entrada
  const elementos = document.querySelectorAll(".fade-in")
  elementos.forEach((el, index) => {
    el.style.animationDelay = `${index * 0.1}s`
  })

  // Configurar tooltips si están disponibles
  if (typeof window.bootstrap !== "undefined" && window.bootstrap.Tooltip) {
    bootstrap = window.bootstrap // Assign the bootstrap variable
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map((tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl))
  }
}

function cambiarReporte(tipo) {
  // Actualizar pestañas
  document.querySelectorAll(".nav-tab-item").forEach((tab) => {
    tab.classList.remove("active")
  })

  // Activar pestaña seleccionada
  event.target.closest(".nav-tab-item").classList.add("active")

  // Actualizar indicador de módulo
  actualizarIndicadorModulo(tipo)

  reporteActual = tipo
  cargarReporte(tipo)
}

function actualizarIndicadorModulo(tipo) {
  const config = modulosConfig[tipo]
  if (config) {
    document.getElementById("module-icon").className = config.icon
    document.getElementById("module-title").textContent = config.title
    document.getElementById("module-description").textContent = config.description
    document.getElementById("module-details").textContent = config.details
  }
}

async function cargarReporte(tipo) {
  mostrarCarga(true)

  try {
    const response = await fetch(`/reportes/data/${tipo}`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
      },
      body: JSON.stringify(filtrosActivos),
    })

    if (!response.ok) {
      throw new Error(`HTTP Error: ${response.status}`)
    }

    const data = await response.json()

    if (data.success) {
      renderizarReporte(tipo, data.data)
    } else {
      console.warn("Error en respuesta del servidor:", data.message)
      mostrarAlerta("Error al cargar datos: " + data.message)
      cargarDatosEjemplo(tipo)
    }
  } catch (error) {
    console.error("Error al cargar reporte:", error)
    mostrarAlerta("Error de conexión. Mostrando datos de ejemplo...")
    cargarDatosEjemplo(tipo)
  } finally {
    mostrarCarga(false)
  }
}

function cargarDatosEjemplo(tipo) {
  const datosEjemplo = {
    lote: {
      items: [
        {
          nombre: "Lote Norte A",
          fecha_inicio: "2025-07-15",
          area: 50000.0,
          capacidad: "2500 plantas",
          tipo_cacao: "Trinitario",
          estado: "Activo",
          observaciones: "Lote principal en excelente estado productivo",
        },
        {
          nombre: "Lote Sur",
          fecha_inicio: "2025-07-20",
          area: 30000.0,
          capacidad: "1500 plantas",
          tipo_cacao: "Forastero",
          estado: "Activo",
          observaciones: "Requiere mantenimiento de sistema de drenaje",
        },
        {
          nombre: "Lote Este",
          fecha_inicio: "2025-07-10",
          area: 40000.0,
          capacidad: "2000 plantas",
          tipo_cacao: "Criollo",
          estado: "Activo",
          observaciones: "Producción orgánica certificada",
        },
      ],
    },
    inventario: {
      items: [
        {
          id: 1,
          producto: "Fertilizante Orgánico Premium",
          fecha: "2025-07-21",
          cantidad: 500,
          unidad: "kg",
          precio_unitario: 5220.0,
          valor_total: 2610000,
          tipo: "Fertilizantes",
          estado: "Disponible",
        },
        {
          id: 2,
          producto: "Pesticida Ecológico",
          fecha: "2025-07-29",
          cantidad: 50,
          unidad: "litros",
          precio_unitario: 45000.0,
          valor_total: 2250000,
          tipo: "Pesticidas",
          estado: "Disponible",
        },
      ],
    },
    ventas: {
      items: [
        {
          id: 1,
          fecha: "2025-07-25",
          cliente: "Chocolatería Premium S.A.",
          lote_produccion: "Norte A",
          cantidad: 1000,
          precio_kg: 25000.0,
          total: 25000000.0,
          estado: "pagado",
          metodo: "transferencia",
        },
      ],
    },
    produccion: {
      items: [
        {
          id: 1,
          cultivo: "Cacao Trinitario",
          lote: "Norte A",
          fecha_inicio: "2025-07-18",
          fecha_fin_esperada: "2025-12-15",
          area: 50000.0,
          estado: "en_progreso",
          rendimiento: 1.2,
          progreso: 65,
        },
      ],
    },
    trabajadores: {
      items: [
        {
          id: 1,
          nombre: "Juan David Cangrejo Quintero",
          direccion: "Calle 32 #16-35",
          email: "cangrejiito23@gmail.com",
          telefono: "3043667236",
          contrato: "Permanente",
          estado: "Activo",
          pago: "Quincenal",
        },
      ],
    },
  }

  renderizarReporte(tipo, datosEjemplo[tipo] || { items: [] })
}

function renderizarReporte(tipo, data) {
  const container = document.getElementById("reporte-data")
  const count = data.items ? data.items.length : 0

  // Actualizar contador
  document.getElementById("module-count").textContent = count

  if (!data.items || data.items.length === 0) {
    container.innerHTML = generarEstadoVacio(tipo)
    return
  }

  let html = ""

  switch (tipo) {
    case "lote":
      html = generarTablaLotes(data.items)
      break
    case "inventario":
      html = generarTablaInventario(data.items)
      break
    case "ventas":
      html = generarTablaVentas(data.items)
      break
    case "produccion":
      html = generarTablaProduccion(data.items)
      break
    case "trabajadores":
      html = generarTablaTrabajadores(data.items)
      break
  }

  container.innerHTML = html
}

function generarEstadoVacio(tipo) {
  const config = modulosConfig[tipo]
  return `
        <div class="data-table-container">
            <div class="empty-state">
                <i class="${config.icon} empty-state-icon"></i>
                <h5>Sin datos disponibles</h5>
                <p class="text-muted">No hay registros de ${config.title.toLowerCase()} para mostrar.</p>
            </div>
        </div>
    `
}

function generarTablaLotes(items) {
  return `
        <div class="data-table-container">
            <div class="data-table-header">
                <div>
                    <h5 class="data-table-title">
                        <i class="fas fa-map-marked-alt me-2"></i>Gestión de Lotes
                    </h5>
                    <p class="data-table-subtitle mb-0">
                        Administración de ${items.length} lotes de cultivo de cacao
                    </p>
                </div>
                <!-- Botón de exportar PDF individual eliminado -->
            </div>
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th><i class="fas fa-tag me-1"></i>Nombre del Lote</th>
                            <th><i class="fas fa-calendar me-1"></i>Fecha Inicio</th>
                            <th><i class="fas fa-ruler-combined me-1"></i>Área (m²)</th>
                            <th><i class="fas fa-seedling me-1"></i>Capacidad</th>
                            <th><i class="fas fa-leaf me-1"></i>Tipo Cacao</th>
                            <th><i class="fas fa-check-circle me-1"></i>Estado</th>
                            <th><i class="fas fa-sticky-note me-1"></i>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${items
                          .map(
                            (item, index) => `
                            <tr>
                                <td class="fw-semibold" style="color: var(--cacao-primary);">
                                    <span class="badge badge-secondary me-2">#${index + 1}</span>
                                    ${item.nombre}
                                </td>
                                <td>${formatearFecha(item.fecha_inicio)}</td>
                                <td class="fw-semibold">${Number(item.area).toLocaleString()} m²</td>
                                <td>${item.capacidad}</td>
                                <td>
                                    <span class="badge badge-info">${item.tipo_cacao}</span>
                                </td>
                                <td>
                                    <span class="badge ${item.estado === "Activo" ? "badge-success" : "badge-warning"}">
                                        ${item.estado === "Activo" ? "✅" : "🚧"} ${item.estado}
                                    </span>
                                </td>
                                <td class="text-muted">${item.observaciones}</td>
                            </tr>
                        `,
                          )
                          .join("")}
                    </tbody>
                </table>
            </div>
        </div>
    `
}

function generarTablaInventario(items) {
  return `
        <div class="data-table-container">
            <div class="data-table-header">
                <div>
                    <h5 class="data-table-title">
                        <i class="fas fa-boxes me-2"></i>Control de Inventario
                    </h5>
                    <p class="data-table-subtitle mb-0">
                        Gestión de ${items.length} productos en inventario
                    </p>
                </div>
                <!-- Botón de exportar PDF individual eliminado -->
            </div>
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th><i class="fas fa-box me-1"></i>Producto</th>
                            <th><i class="fas fa-calendar me-1"></i>Fecha</th>
                            <th><i class="fas fa-sort-numeric-up me-1"></i>Cantidad</th>
                            <th><i class="fas fa-balance-scale me-1"></i>Unidad</th>
                            <th><i class="fas fa-dollar-sign me-1"></i>Precio Unit.</th>
                            <th><i class="fas fa-calculator me-1"></i>Valor Total</th>
                            <th><i class="fas fa-tags me-1"></i>Tipo</th>
                            <th><i class="fas fa-check-circle me-1"></i>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${items
                          .map(
                            (item) => `
                            <tr>
                                <td>
                                    <span class="badge badge-secondary">#${item.id}</span>
                                </td>
                                <td class="fw-semibold">${item.producto}</td>
                                <td>${formatearFecha(item.fecha)}</td>
                                <td class="fw-semibold">${Number(item.cantidad).toLocaleString()}</td>
                                <td>${item.unidad}</td>
                                <td class="fw-bold text-success">$${Number(item.precio_unitario).toLocaleString()}</td>
                                <td class="fw-bold" style="color: var(--cacao-primary);">$${Number(item.valor_total).toLocaleString()}</td>
                                <td>
                                    <span class="badge badge-info">${item.tipo}</span>
                                </td>
                                <td>
                                    <span class="badge ${item.estado === "Disponible" ? "badge-success" : "badge-warning"}">
                                        ${item.estado === "Disponible" ? "✅" : "⚠️"} ${item.estado}
                                    </span>
                                </td>
                            </tr>
                        `,
                          )
                          .join("")}
                    </tbody>
                </table>
            </div>
        </div>
    `
}

function generarTablaVentas(items) {
  return `
        <div class="data-table-container">
            <div class="data-table-header">
                <div>
                    <h5 class="data-table-title">
                        <i class="fas fa-shopping-cart me-2"></i>Análisis de Ventas
                    </h5>
                    <p class="data-table-subtitle mb-0">
                        Control de ${items.length} transacciones comerciales
                    </p>
                </div>
                <!-- Botón de exportar PDF individual eliminado -->
            </div>
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th><i class="fas fa-calendar me-1"></i>Fecha</th>
                            <th><i class="fas fa-user-tie me-1"></i>Cliente</th>
                            <th><i class="fas fa-map-marker me-1"></i>Lote</th>
                            <th><i class="fas fa-weight me-1"></i>Cantidad (kg)</th>
                            <th><i class="fas fa-dollar-sign me-1"></i>Precio/kg</th>
                            <th><i class="fas fa-calculator me-1"></i>Total</th>
                            <th><i class="fas fa-check-circle me-1"></i>Estado</th>
                            <th><i class="fas fa-credit-card me-1"></i>Método Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${items
                          .map(
                            (item) => `
                            <tr>
                                <td>
                                    <span class="badge badge-secondary">#${item.id}</span>
                                </td>
                                <td>${formatearFecha(item.fecha)}</td>
                                <td class="fw-semibold">${item.cliente}</td>
                                <td>
                                    <span class="badge badge-info">${item.lote_produccion}</span>
                                </td>
                                <td class="fw-semibold">${Number(item.cantidad).toLocaleString()} kg</td>
                                <td class="fw-bold text-success">$${Number(item.precio_kg).toLocaleString()}</td>
                                <td class="fw-bold" style="color: var(--cacao-primary); font-size: 1.1em;">$${Number(item.total).toLocaleString()}</td>
                                <td>
                                    <span class="badge ${item.estado === "pagado" ? "badge-success" : "badge-warning"}">
                                        ${item.estado === "pagado" ? "✅" : "⏳"} ${item.estado}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-info">${item.metodo}</span>
                                </td>
                            </tr>
                        `,
                          )
                          .join("")}
                    </tbody>
                </table>
            </div>
        </div>
    `
}

function generarTablaProduccion(items) {
  return `
        <div class="data-table-container">
            <div class="data-table-header">
                <div>
                    <h5 class="data-table-title">
                        <i class="fas fa-seedling me-2"></i>Control de Producción
                    </h5>
                    <p class="data-table-subtitle mb-0">
                        Seguimiento de ${items.length} procesos productivos
                    </p>
                </div>
                <!-- Botón de exportar PDF individual eliminado -->
            </div>
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th><i class="fas fa-seedling me-1"></i>Cultivo</th>
                            <th><i class="fas fa-map-marker me-1"></i>Lote</th>
                            <th><i class="fas fa-play me-1"></i>F. Inicio</th>
                            <th><i class="fas fa-flag-checkered me-1"></i>F. Fin Esperada</th>
                            <th><i class="fas fa-ruler me-1"></i>Área (m²)</th>
                            <th><i class="fas fa-check-circle me-1"></i>Estado</th>
                            <th><i class="fas fa-chart-line me-1"></i>Rendimiento</th>
                            <th><i class="fas fa-percentage me-1"></i>Progreso</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${items
                          .map(
                            (item) => `
                            <tr>
                                <td>
                                    <span class="badge badge-secondary">#${item.id}</span>
                                </td>
                                <td>
                                    <span class="badge badge-info">${item.cultivo}</span>
                                </td>
                                <td class="fw-semibold">${item.lote}</td>
                                <td>${formatearFecha(item.fecha_inicio)}</td>
                                <td>${formatearFecha(item.fecha_fin_esperada)}</td>
                                <td class="fw-semibold">${Number(item.area).toLocaleString()} m²</td>
                                <td>
                                    <span class="badge ${getEstadoProduccionClass(item.estado)}">
                                        ${getEstadoProduccionIcon(item.estado)} ${item.estado.replace("_", " ")}
                                    </span>
                                </td>
                                <td class="fw-bold" style="color: var(--cacao-primary);">
                                    ${Number(item.rendimiento).toFixed(2)} kg/m²
                                </td>
                                <td style="min-width: 120px;">
                                    <div class="progress" style="height: 20px; background-color: #f0f0f0; border-radius: 10px;">
                                        <div class="progress-bar"
                                             style="background: linear-gradient(135deg, var(--cacao-accent) 0%, var(--cacao-primary) 100%);
                                                    width: ${item.progreso}%;
                                                    color: white;
                                                    font-size: 0.75rem;
                                                    font-weight: bold;
                                                    border-radius: 10px;
                                                    display: flex;
                                                    align-items: center;
                                                    justify-content: center;"
                                             role="progressbar">
                                            ${item.progreso}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `,
                          )
                          .join("")}
                    </tbody>
                </table>
            </div>
        </div>
    `
}

function generarTablaTrabajadores(items) {
  return `
        <div class="data-table-container">
            <div class="data-table-header">
                <div>
                    <h5 class="data-table-title">
                        <i class="fas fa-users me-2"></i>Recursos Humanos
                    </h5>
                    <p class="data-table-subtitle mb-0">
                        Administración de ${items.length} trabajadores
                    </p>
                </div>
                <!-- Botón de exportar PDF individual eliminado -->
            </div>
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th><i class="fas fa-user me-1"></i>Nombre Completo</th>
                            <th><i class="fas fa-home me-1"></i>Dirección</th>
                            <th><i class="fas fa-envelope me-1"></i>Email</th>
                            <th><i class="fas fa-phone me-1"></i>Teléfono</th>
                            <th><i class="fas fa-file-contract me-1"></i>Contrato</th>
                            <th><i class="fas fa-check-circle me-1"></i>Estado</th>
                            <th><i class="fas fa-money-bill me-1"></i>Forma Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${items
                          .map(
                            (item) => `
                            <tr>
                                <td>
                                    <span class="badge badge-secondary">#${item.id}</span>
                                </td>
                                <td class="fw-semibold">${item.nombre}</td>
                                <td>${item.direccion}</td>
                                <td>
                                    <a href="mailto:${item.email}" class="text-decoration-none" style="color: var(--cacao-primary);">
                                        ${item.email}
                                    </a>
                                </td>
                                <td>
                                    <a href="tel:${item.telefono}" class="text-decoration-none" style="color: var(--cacao-primary);">
                                        ${item.telefono}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge badge-info">${item.contrato}</span>
                                </td>
                                <td>
                                    <span class="badge ${item.estado === "Activo" ? "badge-success" : "badge-warning"}">
                                        ${item.estado === "Activo" ? "✅" : "⚠️"} ${item.estado}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-info">${item.pago}</span>
                                </td>
                            </tr>
                        `,
                          )
                          .join("")}
                    </tbody>
                </table>
            </div>
        </div>
    `
}

// Funciones auxiliares
function formatearFecha(fecha) {
  return new Date(fecha).toLocaleDateString("es-ES", {
    year: "numeric",
    month: "short",
    day: "numeric",
  })
}

function getEstadoProduccionClass(estado) {
  switch (estado) {
    case "completado":
      return "badge-success"
    case "en_progreso":
      return "badge-warning"
    case "planificado":
      return "badge-info"
    default:
      return "badge-secondary"
  }
}

function getEstadoProduccionIcon(estado) {
  switch (estado) {
    case "completado":
      return "✅"
    case "en_progreso":
      return "🚧"
    case "planificado":
      return "📋"
    default:
      return "⏸️"
  }
}

function descargarPDF(tipo) {
  try {
    const url = `/reportes/pdf/${tipo}`
    const link = document.createElement("a")
    link.href = url
    link.target = "_blank"
    link.click()

    mostrarAlerta(`Descargando reporte PDF de ${modulosConfig[tipo].title}...`)
  } catch (error) {
    console.error("Error al descargar PDF:", error)
    mostrarAlerta("Error al descargar el PDF. Por favor, intente nuevamente.")
  }
}

function generarReporteGeneral() {
  // Show loading state
  const button = event.target
  const originalText = button.innerHTML
  button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando PDF...'
  button.disabled = true

  try {
    // Create a temporary form to handle the download
    const form = document.createElement("form")
    form.method = "GET"
  form.action = window.urlReporteGeneral;
    form.style.display = "none"
    document.body.appendChild(form)
    form.submit()
    document.body.removeChild(form)

    // Reset button after a delay
    setTimeout(() => {
      button.innerHTML = originalText
      button.disabled = false
    }, 3000)
  } catch (error) {
    console.error("Error al generar PDF:", error)

    // Reset button
    button.innerHTML = originalText
    button.disabled = false

    // Show error message
    mostrarAlerta("Error al generar el PDF. Por favor, inténtalo de nuevo.", "error")
  }
}

function mostrarAlerta(mensaje, tipo = "info") {
  const alertContent = document.getElementById("alertContent")
  const alertModal = window.bootstrap.Modal(document.getElementById("alertModal"))

  alertContent.innerHTML = `
        <div class="alert alert-${tipo === "error" ? "danger" : "info"} border-0">
            <i class="fas fa-${tipo === "error" ? "exclamation-triangle" : "info-circle"} me-2"></i>
            ${mensaje}
        </div>
    `

  alertModal.show()
}

function mostrarCarga(mostrar) {
  const loading = document.getElementById("loading")
  const content = document.getElementById("reporte-data")

  if (mostrar) {
    loading.classList.remove("d-none")
    content.classList.add("d-none")
  } else {
    loading.classList.add("d-none")
    content.classList.remove("d-none")
  }
}

function mostrarAlerta(mensaje) {
  document.getElementById("alertContent").innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle me-3 text-primary" style="font-size: 1.5rem;"></i>
            <div>
                <p class="mb-0">${mensaje}</p>
            </div>
        </div>
    `

  const modal = new bootstrap.Modal(document.getElementById("alertModal"))
  modal.show()
}

// Manejo de errores global
window.addEventListener("error", (e) => {
  console.error("Error global:", e.error)
  mostrarAlerta("Ocurrió un error inesperado. Por favor, recarga la página.")
})

// Manejo de promesas rechazadas
window.addEventListener("unhandledrejection", (e) => {
  console.error("Promesa rechazada:", e.reason)
  mostrarAlerta("Error de conexión. Verificando estado del servidor...")
})
