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