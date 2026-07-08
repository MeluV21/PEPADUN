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
                    label: 'Kepatuhan',
                    data: initialData,
                    backgroundColor: '#3882F6',
                    borderRadius: 4,
                    barThickness: 48
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
                            callback: function(value) {
                                return value + '%';
                            },
                            font: {
                                family: "'Poppins', sans-serif",
                                size: 12
                            }
                        },
                        grid: {
                            borderDash: [5, 5],
                            color: '#E2E8F0',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                family: "'Poppins', sans-serif",
                                size: 12
                            }
                        },
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    }
                }
            }
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
