  // Sales Chart
        var salesCtx = document.getElementById('salesChart');
        if (salesCtx) {
            var salesChart = new Chart(salesCtx.getContext('2d'), {
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
        }

        // Production Chart
        var productionCtx = document.getElementById('productionChart');
        if (productionCtx) {
            var productionChart = new Chart(productionCtx.getContext('2d'), {
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
        }
   
    
   
        // Configuración global para AJAX con CSRF
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Asegurar que el contenido tenga suficiente altura para mantener el footer abajo
        $(document).ready(function() {
            function adjustContentHeight() {
                var windowHeight = $(window).height();
                var navbarHeight = $('.main-header').outerHeight();
                var footerHeight = $('.main-footer').outerHeight();
                var minContentHeight = windowHeight - (navbarHeight + footerHeight);
                
                $('.content-wrapper').css('min-height', minContentHeight + 'px');
            }
            
            // Ajustar altura inicialmente y al cambiar el tamaño de la ventana
            adjustContentHeight();
            $(window).resize(function() {
                adjustContentHeight();
            });
        });
    