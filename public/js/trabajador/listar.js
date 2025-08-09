/**
 * JavaScript para el listado de asistencias de trabajadores
 * Módulo: Trabajadores - Listar Asistencias
 * Funcionalidades: Verificación Font Awesome, aplicación de estilos forzados, debugging
 */

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
