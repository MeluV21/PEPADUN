// Landing Page Javascript - PEPADUN

$(document).ready(function() {
    console.log("PEPADUN Landing Page initialized.");

    // --- Navbar Scroll Behavior ---
    function checkScroll() {
        if ($(window).scrollTop() > 30) {
            $('.navbar').addClass('scrolled');
        } else {
            $('.navbar').removeClass('scrolled');
        }
    }
    checkScroll();
    // --- Manual ScrollSpy & Navbar Interaction ---
    var sections = $('section[id]');
    
    // Update menu aktif saat di-scroll
    function checkActiveSection() {
        var scrollPos = $(window).scrollTop() + 100; // offset untuk navbar
        sections.each(function() {
            var top = $(this).offset().top;
            var bottom = top + $(this).outerHeight();
            if (scrollPos >= top && scrollPos <= bottom) {
                $('.navbar-nav .nav-link').removeClass('active');
                $('.navbar-nav .nav-link[href="#' + $(this).attr('id') + '"]').addClass('active');
            }
        });
    }
    
    $(window).scroll(function() {
        checkScroll();
        checkAnimation();
        checkActiveSection();
    });
    
    // Tutup menu mobile jika link di-klik
    $('.navbar-nav .nav-link').on('click', function(e) {
        var navbarCollapse = $('.navbar-collapse');
        if (navbarCollapse.hasClass('show')) {
            navbarCollapse.collapse('hide');
        }
    });

    // --- Intersection Observer for Animations ---
    function checkAnimation() {
        $('.animate-on-scroll').each(function() {
            var elementTop = $(this).offset().top;
            var windowBottom = $(window).scrollTop() + $(window).height();
            if (elementTop < windowBottom - 50) {
                $(this).addClass('visible');
            }
        });
    }
    setTimeout(checkAnimation, 300);

    // --- Chart.js Initialization ---
    let kepatuhanChartInstance = null;
    const ctx = document.getElementById('kepatuhanChart');
    if (ctx) {
        // Set initial width
        let initialLabels = ['Profil PPDI', 'Regulasi', 'Laporan', 'Standar Layanan', 'Informasi Publik'];
        let initialData = [100, 90, 75, 80, 70];

        if (window.kepatuhanChartData && window.kepatuhanChartData.length > 0) {
            initialLabels = window.kepatuhanChartData.map(item => item.label);
            initialData = window.kepatuhanChartData.map(item => item.value);
        }

        document.querySelector('.chart-wrapper').style.width = Math.max(initialLabels.length * 100, document.querySelector('.chart-scroll').clientWidth) + 'px';
        
        kepatuhanChartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: initialLabels,
                datasets: [{
                    label: 'Presentase Kepatuhan',
                    data: initialData,
                    backgroundColor: '#0A4D9E',
                    hoverBackgroundColor: '#3882F6',
                    borderRadius: 2,
                    barPercentage: 0.7,
                    categoryPercentage: 0.8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + '%';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            stepSize: 20,
                            callback: function(value) {
                                return value + '%';
                            },
                            font: {
                                family: "'Poppins', sans-serif",
                                size: 11
                            },
                            color: '#64748B'
                        },
                        border: {
                            dash: [5, 5],
                            display: false
                        },
                        grid: {
                            color: '#E2E8F0',
                            tickBorderDash: [5, 5],
                            tickLength: 0
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                family: "'Poppins', sans-serif",
                                size: 11
                            },
                            color: '#64748B',
                            padding: 10
                        },
                        border: {
                            display: true,
                            color: '#E2E8F0'
                        }
                    }
                },
                layout: {
                    padding: {
                        top: 20
                    }
                }
            },
            plugins: [{
                id: 'customDatalabels',
                afterDatasetsDraw: function(chart, args, options) {
                    const ctx = chart.ctx;
                    chart.data.datasets.forEach((dataset, i) => {
                        const meta = chart.getDatasetMeta(i);
                        meta.data.forEach((bar, index) => {
                            const data = dataset.data[index];
                            ctx.fillStyle = '#0F172A';
                            ctx.font = '500 11px "Poppins", sans-serif';
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            ctx.fillText(data + '%', bar.x, bar.y - 8);
                        });
                    });
                }
            }]
        });
    }

    // Smooth scroll and collapse navbar for mobile
    $('.nav-link').on('click', function(e) {
        if (this.hash !== "") {
            // Biarkan native CSS (scroll-behavior: smooth) yang menangani animasi scroll
            // Kita hanya perlu menutup navbar jika sedang terbuka (di mobile)
            var navbarCollapse = $('.navbar-collapse');
            if (navbarCollapse.hasClass('show')) {
                navbarCollapse.collapse('hide');
            }
        }
    });

});
