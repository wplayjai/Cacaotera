# Módulo del Trabajador - Sistema de Cacaotera

## Descripción General

El módulo del trabajador es una interfaz especializada diseñada para que los trabajadores de la cacaotera puedan gestionar sus tareas diarias de manera eficiente. Este módulo permite a los trabajadores interactuar con lotes, retirar insumos del inventario y registrar cosechas.

## Características Principales

### 🏠 Dashboard Principal
- **Vista general**: Resumen de lotes activos, producciones en curso e insumos disponibles
- **Acciones rápidas**: Acceso directo a las funciones más utilizadas
- **Estadísticas en tiempo real**: Contadores de lotes, producciones e insumos

### 🌱 Gestión de Lotes
- **Lista de lotes**: Visualización de todos los lotes activos asignados
- **Filtros avanzados**: Por estado, tipo de cultivo y área
- **Detalle del lote**: Información completa incluyendo producciones e historial de insumos
- **Retiro de insumos**: Funcionalidad integrada para retirar insumos directamente desde el lote

### 📦 Gestión de Inventario
- **Catálogo de insumos**: Lista completa de insumos disponibles
- **Filtros por tipo**: Fertilizantes, pesticidas, herramientas, semillas, etc.
- **Control de stock**: Validación automática de cantidades disponibles
- **Historial de retiros**: Seguimiento de todos los retiros realizados por el trabajador

### 🌿 Gestión de Producción
- **Estado de producciones**: Visualización del progreso de cada producción
- **Registro de cosechas**: Formulario para documentar cantidades cosechadas
- **Actualización de estados**: Cambio de estados de producción (siembra → crecimiento → maduración → cosecha)
- **Alertas de cosecha**: Notificaciones de producciones listas para cosecha

### 📊 Reportes Personales
- **Estadísticas individuales**: Total cosechado, insumos retirados, lotes trabajados
- **Actividad reciente**: Historial de las últimas actividades realizadas
- **Resumen mensual**: Estadísticas del mes actual
- **Exportación**: Funcionalidad para generar reportes en PDF

## Estructura de Archivos

```
app/Http/Controllers/Trabajador/
├── ModuloController.php          # Controlador principal del módulo
└── DashboardController.php       # Controlador del dashboard

resources/views/trabajador/
├── modulo.blade.php              # Vista principal del módulo
├── dashboard.blade.php           # Dashboard del trabajador
├── lotes/
│   ├── index.blade.php           # Lista de lotes
│   └── detalle.blade.php         # Detalle de un lote específico
├── inventario/
│   └── index.blade.php           # Gestión de inventario
├── produccion/
│   └── index.blade.php           # Gestión de producción
└── reportes/
    └── index.blade.php           # Reportes del trabajador

public/css/trabajador/
└── modulo.css                    # Estilos personalizados del módulo
```

## Rutas del Módulo

### Rutas Principales
- `GET /trabajador/modulo` - Módulo principal
- `GET /trabajador/dashboard` - Dashboard del trabajador

### Gestión de Lotes
- `GET /trabajador/lotes` - Lista de lotes
- `GET /trabajador/lotes/{id}` - Detalle de un lote

### Gestión de Inventario
- `GET /trabajador/inventario` - Vista de inventario
- `POST /trabajador/retirar-insumo` - Retirar insumo

### Gestión de Producción
- `GET /trabajador/produccion` - Vista de producción
- `POST /trabajador/registrar-cosecha` - Registrar cosecha
- `POST /trabajador/actualizar-estado` - Actualizar estado de producción

### Reportes
- `GET /trabajador/reportes` - Reportes del trabajador

## Funcionalidades Técnicas

### Validaciones
- **Stock disponible**: Verificación automática de cantidades antes de retirar insumos
- **Estados de producción**: Validación de transiciones de estado permitidas
- **Fechas**: Validación de fechas de cosecha y retiros

### Transacciones de Base de Datos
- **Retiro de insumos**: Transacción que actualiza inventario y crea registro de salida
- **Registro de cosecha**: Transacción que actualiza producción y crea registro de recolección

### Seguridad
- **Middleware de autenticación**: Todas las rutas requieren autenticación
- **Middleware de roles**: Acceso restringido solo a usuarios con rol 'trabajador'
- **Validación de datos**: Sanitización y validación de todos los inputs

## Interfaz de Usuario

### Diseño Responsivo
- **Bootstrap 5**: Framework CSS para diseño responsivo
- **Font Awesome**: Iconografía consistente
- **CSS personalizado**: Estilos específicos para el módulo

### Características de UX
- **Navegación intuitiva**: Menús y botones claramente identificados
- **Feedback visual**: Alertas y notificaciones para acciones del usuario
- **Filtros dinámicos**: Búsqueda y filtrado en tiempo real
- **Modales interactivos**: Formularios en ventanas emergentes

### Componentes Reutilizables
- **Tarjetas de estadísticas**: Diseño consistente para métricas
- **Tablas responsivas**: Visualización de datos con scroll horizontal
- **Barras de progreso**: Indicadores visuales de progreso
- **Badges de estado**: Identificación rápida de estados

## Configuración y Uso

### Requisitos Previos
1. Laravel 8 instalado y configurado
2. Base de datos configurada con las tablas necesarias
3. Sistema de autenticación funcionando
4. Middleware de roles configurado

### Instalación
1. Copiar los archivos del controlador a `app/Http/Controllers/Trabajador/`
2. Copiar las vistas a `resources/views/trabajador/`
3. Copiar el CSS a `public/css/trabajador/`
4. Agregar las rutas al archivo `routes/web.php`
5. Ejecutar `php artisan route:cache` para optimizar las rutas

### Configuración de Roles
Asegúrate de que el middleware de roles esté configurado correctamente:

```php
// En routes/web.php
Route::prefix('trabajador')->middleware(['auth', 'role:trabajador'])->group(function () {
    // Rutas del módulo...
});
```

## Mantenimiento y Mejoras

### Logs y Monitoreo
- **Logs de actividad**: Registro de todas las acciones del trabajador
- **Validación de datos**: Verificación de integridad de datos
- **Manejo de errores**: Captura y reporte de errores

### Posibles Mejoras Futuras
- **Notificaciones push**: Alertas en tiempo real
- **App móvil**: Versión móvil del módulo
- **GPS tracking**: Ubicación de trabajadores en lotes
- **Fotos de cosecha**: Captura de imágenes como evidencia
- **Sincronización offline**: Funcionamiento sin conexión

## Soporte y Contacto

Para soporte técnico o reportar problemas:
- Revisar los logs de Laravel en `storage/logs/`
- Verificar la configuración de la base de datos
- Comprobar los permisos de archivos y directorios

---

**Versión**: 1.0.0  
**Última actualización**: Diciembre 2024  
**Desarrollado para**: Sistema de Cacaotera


