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
    const ctx = document.getElementById('kepatuhanChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Profil PPDI', 'Regulasi', 'Laporan', 'Standar Layanan', 'Informasi Publik'],
                datasets: [{
                    label: 'Kepatuhan',
                    data: [100, 90, 75, 80, 70],
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
    // --- Simulated Realtime Update for Statistics ---
    // Mensimulasikan data dari backend secara realtime setiap 3.5 detik
    setInterval(function() {
        // Ambil elemen
        var elTotal1 = document.getElementById('val-total1');
        var elTotal2 = document.getElementById('val-total2');
        var elTotal3 = document.getElementById('val-total3');
        var elSelesai = document.getElementById('val-selesai');
        var elBelum = document.getElementById('val-belum');
        var elKepatuhan = document.getElementById('val-kepatuhan');
        
        var barSelesai = document.getElementById('bar-selesai');
        var barBelum = document.getElementById('bar-belum');
        var barKepatuhan = document.getElementById('bar-kepatuhan');

        if(elTotal1 && elSelesai && elBelum) {
            // Generate dummy update (misalnya total nambah 1-2, atau status berubah)
            var currentTotal = parseInt(elTotal3.innerText);
            var currentSelesai = parseInt(elSelesai.innerText);
            
            // Random chance ada update baru
            if(Math.random() > 0.5) {
                currentTotal += Math.floor(Math.random() * 2); 
                currentSelesai += Math.floor(Math.random() * 3);
                
                if (currentSelesai > currentTotal) {
                    currentSelesai = currentTotal;
                }
                
                var currentBelum = currentTotal - currentSelesai;
                
                // Hitung persen
                var persenSelesai = (currentSelesai / currentTotal) * 100;
                var persenBelum = (currentBelum / currentTotal) * 100;
                var kepatuhan = Math.min(100, Math.floor(persenSelesai + (Math.random() * 5))); // fake calculation
                
                // Animasi update teks
                elTotal1.innerText = currentTotal;
                elTotal2.innerText = currentTotal;
                elTotal3.innerText = currentTotal;
                elSelesai.innerText = currentSelesai;
                elBelum.innerText = currentBelum;
                elKepatuhan.innerText = kepatuhan + '%';
                
                // Update CSS lebar bar
                barSelesai.style.width = persenSelesai + '%';
                barBelum.style.width = persenBelum + '%';
                barKepatuhan.style.width = kepatuhan + '%';
            }
        }
    }, 3500);
});
