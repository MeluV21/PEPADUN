<div class="page-header">
    <h2>Dashboard</h2>
    <div style="color: var(--text-muted); font-size: 0.9rem; font-weight: 500;">
        <i class="bi bi-calendar3"></i> Hari ini: <?= date('d M Y') ?>
    </div>
</div>

<!-- Stats Grid (Aligned to Section 06. CARD) -->
<div class="stats-grid">
    <!-- Card 1: Tingkat Kepatuhan (Radial Progress Bar) -->
    <div class="card">
        <div class="metric-card-content">
            <div class="metric-text">
                <h4>Tingkat Kepatuhan</h4>
                <h2>85%</h2>
                <p>Kepatuhan Informasi Publik</p>
            </div>
            <div class="radial-progress-wrapper">
                <svg width="64" height="64" class="radial-progress-svg">
                    <circle cx="32" cy="32" r="28" class="radial-progress-bg"></circle>
                    <circle cx="32" cy="32" r="28" class="radial-progress-fill" style="stroke-dasharray: 176; stroke-dashoffset: calc(176 - (176 * 85) / 100);"></circle>
                </svg>
                <div class="radial-progress-text">85%</div>
            </div>
        </div>
    </div>
    
    <!-- Card 2: Selesai / Update -->
    <div class="card">
        <div class="metric-card-content">
            <div class="metric-text">
                <h4>Selesai / Update</h4>
                <h2><?= esc($statusCompleted) ?></h2>
                <p>Dari <?= esc($totalMonitoring) ?> item</p>
            </div>
            <div class="metric-icon-wrapper success">
                <i class="bi bi-check-circle-fill"></i>
            </div>
        </div>
    </div>
    
    <!-- Card 3: Belum Update -->
    <div class="card">
        <div class="metric-card-content">
            <div class="metric-text">
                <h4>Belum Update</h4>
                <h2><?= esc($statusPending) ?></h2>
                <p>Dari <?= esc($totalMonitoring) ?> item</p>
            </div>
            <div class="metric-icon-wrapper danger">
                <i class="bi bi-exclamation-circle-fill"></i>
            </div>
        </div>
    </div>

    <!-- Card 4: Total Item -->
    <div class="card">
        <div class="metric-card-content">
            <div class="metric-text">
                <h4>Total Item</h4>
                <h2><?= esc($totalMonitoring) ?></h2>
                <p>Item Laporan Terdaftar</p>
            </div>
            <div class="metric-icon-wrapper primary">
                <i class="bi bi-files"></i>
            </div>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    <!-- Left Column: Recent Activities -->
    <div class="card" style="padding: 1.75rem;">
        <div class="section-header-title">
            <i class="bi bi-clock-history"></i>
            <h3>Aktivitas Monitoring Terbaru</h3>
        </div>
        
        <div class="table-responsive" style="border: none; box-shadow: none;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 15%;">Tanggal</th>
                        <th style="width: 40%;">Laporan Kerja</th>
                        <th style="width: 25%;">Kategori</th>
                        <th style="width: 20%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentMonitoring)): ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 2rem;">Belum ada laporan monitoring yang terekam.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($recentMonitoring as $item): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($item['activity_date'])) ?></td>
                                <td>
                                    <div style="font-weight: 600; color: var(--text-dark);"><?= esc($item['title']) ?></div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted); max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= esc($item['description']) ?></div>
                                </td>
                                <td>
                                    <span style="font-size: 0.85rem; padding: 0.15rem 0.5rem; background: var(--secondary); color: var(--primary); border-radius: 5px; font-weight: 500;">
                                        <?= esc($item['category_name']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($item['status'] === 'completed'): ?>
                                        <span class="badge badge-selesai">
                                            <i class="bi bi-check-circle-fill"></i> Selesai
                                        </span>
                                    <?php elseif ($item['status'] === 'progress'): ?>
                                        <span class="badge badge-proses">
                                            <i class="bi bi-clock-fill"></i> Dalam Proses
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-belum-update">
                                            <i class="bi bi-exclamation-circle-fill"></i> Belum Update
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 1.5rem; text-align: right;">
            <a href="<?= base_url('monitoring') ?>" class="btn btn-secondary btn-sm">
                <span>Daftar Lengkap</span> <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Right Column: Category Distribution Chart -->
    <div class="card" style="display: flex; flex-direction: column; padding: 1.75rem;">
        <div class="section-header-title">
            <i class="bi bi-pie-chart-fill"></i>
            <h3>Distribusi Kategori</h3>
        </div>
        <div style="position: relative; flex-grow: 1; min-height: 250px; display: flex; justify-content: center; align-items: center;">
            <canvas id="categoryChartCanvas" style="max-width: 230px; max-height: 230px;"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('categoryChartCanvas').getContext('2d');
        
        const chartData = <?= json_encode($categoryChart) ?>;
        
        const labels = chartData.map(item => item.category_name);
        const dataVals = chartData.map(item => item.total);
        
        // Chart colors matching design system
        const systemColors = [
            '#0A4D9E', // Deep Blue (Primary)
            '#3882F6', // Blue (Primary Light)
            '#60A5FA', // Light Blue
            '#93C5FD', // Light Blue 2
            '#22C55E', // Green (Success)
            '#F59E0B', // Yellow (Warning)
            '#EF4444', // Red (Danger)
            '#64748B'  // Grey (Neutral)
        ];
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: dataVals,
                    backgroundColor: systemColors.slice(0, labels.length),
                    borderColor: '#ffffff',
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#64748b',
                            font: {
                                size: 11,
                                family: "'Poppins', sans-serif"
                            },
                            padding: 12
                        }
                    }
                },
                cutout: '72%'
            }
        });
    });
</script>
