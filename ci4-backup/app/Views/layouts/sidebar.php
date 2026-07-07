<!-- Sidebar (Mockup Light Sidebar) -->
<aside class="sidebar">
    <div class="sidebar-header" style="position: relative;">
        <!-- Floating Sidebar Collapse Toggle Button -->
        <button id="sidebarToggle" class="sidebar-toggle-btn" title="Toggle Sidebar">
            <i class="bi bi-chevron-left"></i>
        </button>

        <div class="sidebar-brand-wrapper">
            <img src="<?= base_url('images/logo_only.png') ?>" alt="Logo BADAN POM">
            <div>
                <h1 style="font-size: 1.25rem; margin: 0; line-height: 1.2;">PEPADUN</h1>
            </div>
        </div>
        <span class="sidebar-brand-desc">Percepatan Pantau Dokumen serta Update Data dan Informasi</span>
        <span class="sidebar-badge">BBPOM di Bandar Lampung</span>
    </div>

    <!-- Navigation Menu -->
    <ul class="sidebar-menu">
        <?php 
            $request = \Config\Services::request();
            $uri = service('uri');
            $segment = $uri->getSegment(1);
            
            // Dynamic years based on current year
            $currentYear = (int) date('Y');
            $years = [$currentYear, $currentYear - 1, $currentYear - 2];
            
            $selectedYear = (int) ($request->getGet('year') ?? '2026');
            $selectedTriwulan = (int) ($request->getGet('triwulan') ?? 1);
        ?>
        <li class="sidebar-item <?= ($segment === 'dashboard') ? 'active' : '' ?>">
            <a href="<?= base_url('dashboard') ?>" class="sidebar-link" data-title="Dashboard">
                <div class="sidebar-link-content">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </div>
            </a>
        </li>
        
        <li class="sidebar-item <?= ($segment === 'monitoring') ? 'active' : '' ?>">
            <a href="<?= base_url('monitoring?year=2026&triwulan=1') ?>" class="sidebar-link sidebar-link-monitoring" data-title="Monitoring">
                <div class="sidebar-link-content">
                    <i class="bi bi-clipboard-check"></i>
                    <span>Monitoring</span>
                </div>
            </a>
            
            <!-- 3 dynamic years sub-menu dropdown (based on current year) -->
            <ul class="sidebar-submenu <?= ($segment === 'monitoring') ? 'show' : '' ?>">
                <?php foreach ($years as $yr): ?>
                    <li class="sidebar-submenu-item <?= ($segment === 'monitoring' && $selectedYear === $yr) ? 'active' : '' ?>">
                        <a href="<?= base_url("monitoring?year={$yr}&triwulan={$selectedTriwulan}") ?>" class="sidebar-submenu-link">
                            <?= $yr ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>

        <?php if (session()->get('role') === 'admin'): ?>
            <li class="sidebar-item <?= ($segment === 'categories') ? 'active' : '' ?>">
                <a href="<?= base_url('categories') ?>" class="sidebar-link" data-title="Kategori">
                    <div class="sidebar-link-content">
                        <i class="bi bi-folder"></i>
                        <span>Kategori</span>
                    </div>
                </a>
            </li>
            
            <li class="sidebar-item <?= ($segment === 'users') ? 'active' : '' ?>">
                <a href="<?= base_url('users') ?>" class="sidebar-link" data-title="Pengguna">
                    <div class="sidebar-link-content">
                        <i class="bi bi-people"></i>
                        <span>Pengguna</span>
                    </div>
                </a>
            </li>
        <?php endif; ?>
    </ul>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <a href="<?= base_url('logout') ?>" class="btn-logout" data-title="Keluar">
            <i class="bi bi-box-arrow-right"></i>
            <span>Keluar</span>
        </a>
    </div>
</aside>

<!-- Self-contained Sidebar logic script -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Collapse / Expand Sidebar Toggle logic
        const toggleBtn = document.getElementById('sidebarToggle');
        if (toggleBtn) {
            const icon = toggleBtn.querySelector('i');
            
            // Restore collapsed state from localStorage
            if (localStorage.getItem('sidebar-collapsed') === 'true') {
                document.body.classList.add('sidebar-collapsed');
                if (icon) icon.className = 'bi bi-chevron-right';
            }
            
            toggleBtn.addEventListener('click', () => {
                document.body.classList.toggle('sidebar-collapsed');
                const isCollapsed = document.body.classList.contains('sidebar-collapsed');
                localStorage.setItem('sidebar-collapsed', isCollapsed);
                
                if (icon) {
                    icon.className = isCollapsed ? 'bi bi-chevron-right' : 'bi bi-chevron-left';
                }
            });
        }

        // 2. Monitoring Dropdown Year submenu Click-Toggle logic
        const monitoringLink = document.querySelector('.sidebar-link-monitoring');
        const submenu = document.querySelector('.sidebar-submenu');
        
        if (monitoringLink && submenu) {
            monitoringLink.addEventListener('click', (e) => {
                // If we are already on the monitoring page, toggle submenu without reloading
                if (window.location.pathname.includes('monitoring')) {
                    e.preventDefault();
                    submenu.classList.toggle('show');
                }
            });
        }
    });
</script>
