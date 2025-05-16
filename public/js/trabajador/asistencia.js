document.addEventListener('DOMContentLoaded', function() {
        // Establecer hora actual en el campo de entrada
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        document.getElementById('hora_entrada').value = `${hours}:${minutes}`;
        
        // Añadir clases adicionales para mejorar la interfaz
        const labels = document.querySelectorAll('label');
        labels.forEach(label => {
            label.style.fontWeight = '500';
            label.style.color = '#3B2314';
        });
        
        // Añadir color a los encabezados
        document.querySelectorAll('.card-header').forEach(header => {
            header.style.backgroundColor = '#76523B';
            header.style.color = 'white';
        });
        
        // Estilizar los botones
        document.querySelectorAll('.btn-primary').forEach(btn => {
            btn.style.backgroundColor = '#76523B';
            btn.style.borderColor = '#76523B';
        });
        
        document.querySelectorAll('.btn-info').forEach(btn => {
            btn.style.backgroundColor = '#C8A27C';
            btn.style.borderColor = '#C8A27C';
            btn.style.color = '#3B2314';
        });
        
        // Añadir fondo general
        document.body.style.backgroundColor = '#f9f6f3';
        
        // Estilizar los inputs cuando reciben foco
        document.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('focus', function() {
                this.style.borderColor = '#BA8C63';
                this.style.boxShadow = '0 0 0 0.2rem rgba(186, 140, 99, 0.25)';
            });
            
            input.addEventListener('blur', function() {
                this.style.boxShadow = 'none';
            });
        });
    });