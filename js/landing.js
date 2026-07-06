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
        const initialLabels = ['Profil PPDI', 'Regulasi', 'Laporan', 'Standar Layanan', 'Informasi Publik'];
        document.querySelector('.chart-wrapper').style.width = Math.max(initialLabels.length * 100, document.querySelector('.chart-scroll').clientWidth) + 'px';
        
        kepatuhanChartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: initialLabels,
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

    // --- Simulated Realtime Update for Statistics ---
    // Mensimulasikan data dari backend secara realtime setiap 3.5 detik
    setInterval(function() {
        // Ambil elemen Card Atas
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
            var currentTotal = parseInt(elTotal3.innerText);
            var currentSelesai = parseInt(elSelesai.innerText);
            
            if(Math.random() > 0.5) {
                currentTotal += Math.floor(Math.random() * 2); 
                currentSelesai += Math.floor(Math.random() * 3);
                
                if (currentSelesai > currentTotal) {
                    currentSelesai = currentTotal;
                }
                
                var currentBelum = currentTotal - currentSelesai;
                var persenSelesai = (currentSelesai / currentTotal) * 100;
                var persenBelum = (currentBelum / currentTotal) * 100;
                var kepatuhan = Math.min(100, Math.floor(persenSelesai + (Math.random() * 5)));
                
                elTotal1.innerText = currentTotal;
                elTotal2.innerText = currentTotal;
                elTotal3.innerText = currentTotal;
                elSelesai.innerText = currentSelesai;
                elBelum.innerText = currentBelum;
                elKepatuhan.innerText = kepatuhan + '%';
                
                barSelesai.style.width = persenSelesai + '%';
                barBelum.style.width = persenBelum + '%';
                barKepatuhan.style.width = kepatuhan + '%';
            }
        }

        // Simulasi Realtime untuk Chart (Penambahan Kategori Baru)
        if (kepatuhanChartInstance) {
            if (Math.random() > 0.6) { // 40% chance tambah chart bar
                var labelCounter = kepatuhanChartInstance.data.labels.length + 1;
                kepatuhanChartInstance.data.labels.push('Kategori ' + labelCounter);
                kepatuhanChartInstance.data.datasets[0].data.push(Math.floor(Math.random() * 40) + 60); // random 60-100
                
                // Set wrapper width dynamically for scroll
                var newWidth = kepatuhanChartInstance.data.labels.length * 110; 
                document.querySelector('.chart-wrapper').style.width = Math.max(newWidth, document.querySelector('.chart-scroll').clientWidth) + 'px';
                
                kepatuhanChartInstance.update();
            }
        }

        // Simulasi Realtime untuk Item Belum Update (Penambahan List)
        var listContainer = document.getElementById('containerBelumUpdate');
        if (listContainer) {
            if (Math.random() > 0.5) { // 50% chance tambah item
                var itemsCount = listContainer.children.length + 1;
                var newItemHTML = `
                <div class="list-row-item py-3 border-bottom d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-exclamation-triangle text-danger" style="font-size: 18px;"></i>
                    </div>
                    <div class="title fw-semibold text-dark flex-grow-1" style="font-size: 14px;">
                        Item Dokumen Baru #${itemsCount}
                    </div>
                    <div class="text-secondary" style="font-size: 13px; width: 120px;">
                        Kategori Baru
                    </div>
                    <div class="text-end text-secondary" style="font-size: 13px; width: 30px;">
                        -
                    </div>
                </div>`;
                
                listContainer.insertAdjacentHTML('afterbegin', newItemHTML);
            }
        }
    }, 3500);
});
