<!-- Filters Row -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; background: var(--white); padding: 1rem 1.5rem; border-radius: var(--br-12); box-shadow: var(--shadow-sm); border: 1px solid var(--neutral-light);">
    <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-dark); font-weight: 500; font-size: 0.9rem;">
        <i class="bi bi-calendar3"></i> Hari ini: <?= date('d M Y') ?>
    </div>
    
    <div style="display: flex; align-items: center; gap: 1rem;">
        <form id="filterForm" action="<?= base_url('dashboard') ?>" method="GET" style="display: flex; align-items: center; gap: 1rem; margin: 0;">
            <input type="hidden" name="year" value="<?= $selectedYear ?>">
            <label style="font-size: 0.9rem; font-weight: 600; color: var(--text-dark); margin: 0;">Triwulan Aktif:</label>
            <select name="triwulan" class="select-control" onchange="this.form.submit()" style="width: auto; padding: 0.4rem 2.25rem 0.4rem 1rem; border-color: var(--primary); color: var(--primary); font-weight: 500;">
                <option value="1" <?= $selectedTriwulan == 1 ? 'selected' : '' ?>>Triwulan I (01 Jan - 31 Mar <?= $selectedYear ?>)</option>
                <option value="2" <?= $selectedTriwulan == 2 ? 'selected' : '' ?>>Triwulan II (01 Apr - 30 Jun <?= $selectedYear ?>)</option>
                <option value="3" <?= $selectedTriwulan == 3 ? 'selected' : '' ?>>Triwulan III (01 Jul - 30 Sep <?= $selectedYear ?>)</option>
                <option value="4" <?= $selectedTriwulan == 4 ? 'selected' : '' ?>>Triwulan IV (01 Okt - 31 Des <?= $selectedYear ?>)</option>
            </select>
        </form>
    </div>

    <div style="color: var(--text-muted); font-size: 0.85rem;">
        <i class="bi bi-clock-history"></i> Terakhir diperbarui: 
        <?= !empty($lastUpdate) ? date('d M Y H:i', strtotime($lastUpdate)) . ' WIB' : 'Belum ada data' ?>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <!-- Card 1: Tingkat Kepatuhan -->
    <div class="card" style="display: flex; flex-direction: column; justify-content: space-between; padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <div>
                <h4 style="color: var(--text-muted); font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem;">Tingkat Kepatuhan</h4>
                <h2 style="font-size: 2.2rem; font-weight: 700; color: var(--text-dark); margin: 0; line-height: 1;"><?= esc($tingkatKepatuhan ?? 0) ?>%</h2>
                <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.5rem;">Kepatuhan Informasi Publik</p>
            </div>
            <div class="radial-progress-wrapper" style="width: 72px; height: 72px;">
                <svg width="72" height="72" class="radial-progress-svg">
                    <circle cx="36" cy="36" r="32" class="radial-progress-bg"></circle>
                    <circle cx="36" cy="36" r="32" class="radial-progress-fill" style="stroke-dasharray: 201; stroke-dashoffset: calc(201 - (201 * <?= esc($tingkatKepatuhan ?? 0) ?>) / 100);"></circle>
                </svg>
                <div class="radial-progress-text" style="font-size: 0.9rem;"><?= esc($tingkatKepatuhan ?? 0) ?>%</div>
            </div>
        </div>
    </div>
    
    <!-- Card 2: Selesai / Update -->
    <div class="card" style="display: flex; flex-direction: column; justify-content: space-between; padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <h4 style="color: var(--text-muted); font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem;">Selesai / Update</h4>
                <h2 style="font-size: 2.2rem; font-weight: 700; color: var(--text-dark); margin: 0; line-height: 1;"><?= esc($statusCompleted ?? 0) ?></h2>
                <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.5rem;">Dari <?= esc($totalMonitoring ?? 0) ?> Item</p>
            </div>
            <div style="width: 40px; height: 40px; border-radius: 50%; background-color: rgba(34, 197, 94, 0.1); display: flex; align-items: center; justify-content: center; color: var(--success); font-size: 1.25rem;">
                <i class="bi bi-check-lg" style="stroke: currentColor; stroke-width: 1;"></i>
            </div>
        </div>
        <div style="margin-top: 1rem;">
            <?php $percentCompleted = $totalMonitoring > 0 ? round(($statusCompleted / $totalMonitoring) * 100) : 0; ?>
            <div style="height: 6px; width: 100%; background-color: var(--neutral-light); border-radius: 3px; overflow: hidden; margin-bottom: 0.75rem;">
                <div style="height: 100%; width: <?= $percentCompleted ?>%; background-color: var(--success); border-radius: 3px;"></div>
            </div>
        </div>
    </div>
    
    <!-- Card 3: Belum Update -->
    <div class="card" style="display: flex; flex-direction: column; justify-content: space-between; padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <h4 style="color: var(--text-muted); font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem;">Belum Update</h4>
                <h2 style="font-size: 2.2rem; font-weight: 700; color: var(--text-dark); margin: 0; line-height: 1;"><?= esc($statusPending ?? 0) ?></h2>
                <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.5rem;">Dari <?= esc($totalMonitoring ?? 0) ?> Item</p>
            </div>
            <div style="width: 40px; height: 40px; border-radius: 50%; background-color: #fee2e2; display: flex; align-items: center; justify-content: center; color: var(--danger); font-size: 1.25rem;">
                <i class="bi bi-exclamation-lg" style="stroke: currentColor; stroke-width: 1;"></i>
            </div>
        </div>
        <div style="margin-top: 1rem;">
            <?php $percentPending = $totalMonitoring > 0 ? round(($statusPending / $totalMonitoring) * 100) : 0; ?>
            <div style="height: 6px; width: 100%; background-color: var(--neutral-light); border-radius: 3px; overflow: hidden; margin-bottom: 0.75rem;">
                <div style="height: 100%; width: <?= $percentPending ?>%; background-color: var(--danger); border-radius: 3px;"></div>
            </div>
        </div>
    </div>

    <!-- Card 4: Total Item -->
    <div class="card" style="display: flex; flex-direction: column; justify-content: space-between; padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <h4 style="color: var(--text-muted); font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem;">Total Item</h4>
                <h2 style="font-size: 2.2rem; font-weight: 700; color: var(--text-dark); margin: 0; line-height: 1;"><?= esc($totalMonitoring ?? 0) ?></h2>
                <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.5rem;">Item Informasi</p>
            </div>
            <div style="width: 40px; height: 40px; border-radius: 50%; background-color: var(--secondary); display: flex; align-items: center; justify-content: center; color: var(--primary-light); font-size: 1.25rem;">
                <i class="bi bi-folder-fill"></i>
            </div>
        </div>
        <div style="margin-top: 1rem;">
            <div style="height: 6px; width: 100%; background-color: var(--neutral-light); border-radius: 3px; overflow: hidden; margin-bottom: 0.75rem;"></div>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="card" style="margin-bottom: 1.5rem; padding: 1.75rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px dashed var(--neutral-light);">
        <div style="display: flex; align-items: center; gap: 0.75rem; color: var(--primary);">
            <i class="bi bi-bar-chart-fill" style="font-size: 1.25rem;"></i>
            <h3 style="font-size: 1.1rem; font-weight: 600; margin: 0;">Presentase Kepatuhan Per Kategori</h3>
        </div>
    </div>
    <div style="position: relative; height: 320px; width: 100%; padding: 0 1rem;">
        <canvas id="barChartCanvas"></canvas>
    </div>
</div>

<!-- Table Section -->
<div class="card" style="padding: 1.75rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem; color: var(--danger);">
            <div style="background-color: var(--danger); color: var(--white); width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem; font-weight: bold;">!</div>
            <h3 style="font-size: 1.1rem; font-weight: 600; margin: 0;">Item Belum Update</h3>
        </div>
        <a href="<?= base_url("monitoring?year={$selectedYear}&triwulan={$selectedTriwulan}&status=pending") ?>" class="btn btn-secondary btn-sm" style="border-radius: var(--br-full); padding: 0.35rem 1rem; font-size: 0.8rem; font-weight: 600; color: var(--primary); border-color: var(--neutral-light);">
            Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    
    <div class="table-responsive" style="border: none; box-shadow: none;">
        <table class="custom-table" style="border-top: 1px dashed var(--neutral-light);">
            <thead>
                <tr>
                    <th style="width: 45%; background: transparent; color: var(--text-muted); font-weight: 500; font-size: 0.8rem; border-bottom: 1px solid var(--neutral-light);">Item Informasi</th>
                    <th style="width: 35%; background: transparent; color: var(--text-muted); font-weight: 500; font-size: 0.8rem; border-bottom: 1px solid var(--neutral-light);">Kategori</th>
                    <th style="width: 20%; background: transparent; color: var(--text-muted); font-weight: 500; font-size: 0.8rem; border-bottom: 1px solid var(--neutral-light);">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $hasPending = false;
                if (isset($recentMonitoring) && !empty($recentMonitoring)): 
                    foreach ($recentMonitoring as $item): 
                        $hasPending = true;
                ?>
                        <tr>
                            <td style="padding: 1rem;">
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <i class="bi bi-exclamation-triangle" style="color: var(--danger); font-size: 1.1rem;"></i>
                                    <span style="font-weight: 500; color: var(--text-dark); font-size: 0.9rem;"><?= esc($item['title']) ?></span>
                                </div>
                            </td>
                            <td style="color: var(--text-muted); font-size: 0.9rem; padding: 1rem;"><?= esc($item['category_name'] ?: '-') ?></td>
                            <td style="color: var(--text-muted); font-size: 0.9rem; padding: 1rem;"><?= esc($item['description'] ?: '-') ?></td>
                        </tr>
                <?php 
                    endforeach;
                endif; 
                ?>
                
                <?php if (!$hasPending): ?>
                    <tr>
                        <td colspan="3" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                            Semua informasi pada Triwulan ini telah diperbarui!
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const barCtx = document.getElementById('barChartCanvas').getContext('2d');
        
        <?php if (isset($categoryChart) && !empty($categoryChart)): ?>
            const chartData = <?= json_encode($categoryChart) ?>;
            const labels = chartData.map(item => item.category_name);
            const dataVals = chartData.map(item => item.total);
        <?php else: ?>
            const labels = ['Profil PPID', 'Regulasi', 'Laporan', 'Standar Layanan', 'Informasi Publik', 'Layanan Informasi', 'Keuangan', 'Pengelolaan Informasi'];
            const dataVals = [0, 0, 0, 0, 0, 0, 0, 0];
        <?php endif; ?>
        
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Presentase Kepatuhan',
                    data: dataVals,
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
    });
</script>
