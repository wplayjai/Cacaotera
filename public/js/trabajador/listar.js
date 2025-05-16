
    document.addEventListener('DOMContentLoaded', function() {
        // Aplicar colores a los elementos
        document.querySelectorAll('.card-header').forEach(header => {
            header.style.backgroundColor = '#76523B';
            header.style.color = 'white';
        });
        
        document.querySelectorAll('.btn-primary').forEach(btn => {
            btn.style.backgroundColor = '#76523B';
            btn.style.borderColor = '#76523B';
        });
        
        document.querySelectorAll('.btn-secondary').forEach(btn => {
            btn.style.backgroundColor = '#C8A27C';
            btn.style.borderColor = '#C8A27C';
            btn.style.color = '#3B2314';
        });
        
        // Añadir estilos a la tabla
        document.querySelectorAll('thead th').forEach(th => {
            th.style.backgroundColor = '#E6D2B5';
            th.style.color = '#3B2314';
        });
        
        // Mejora de accesibilidad para enlaces de la tabla
        document.querySelectorAll('.table tr').forEach(row => {
            row.style.cursor = 'pointer';
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'rgba(186, 140, 99, 0.1)';
            });
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
        
        // Efecto hover para los botones
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                if (this.classList.contains('btn-primary')) {
                    this.style.backgroundColor = '#3B2314';
                    this.style.borderColor = '#3B2314';
                } else if (this.classList.contains('btn-secondary')) {
                    this.style.backgroundColor = '#BA8C63';
                    this.style.borderColor = '#BA8C63';
                    this.style.color = 'white';
                }
            });
            
            btn.addEventListener('mouseleave', function() {
                if (this.classList.contains('btn-primary')) {
                    this.style.backgroundColor = '#76523B';
                    this.style.borderColor = '#76523B';
                } else if (this.classList.contains('btn-secondary')) {
                    this.style.backgroundColor = '#C8A27C';
                    this.style.borderColor = '#C8A27C';
                    this.style.color = '#3B2314';
                }
            });
        });
    });
