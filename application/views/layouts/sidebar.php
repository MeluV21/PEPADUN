<!-- Sidebar (Mockup Light Sidebar) -->
<aside class="sidebar">
    <div class="sidebar-header" style="position: relative;">
        <!-- Floating Sidebar Collapse Toggle Button -->
        <button id="sidebarToggle" class="sidebar-toggle-btn" title="Toggle Sidebar">
            <i class="bi bi-layout-sidebar"></i>
        </button>

        <div style="display: flex; flex-direction: column; align-items: stretch; width: 100%; max-width: 210px; margin: 0 auto; gap: 8px;">
            <div class="sidebar-brand-wrapper" id="sidebarBrand" style="justify-content: center; margin-bottom: 0;">
                <img src="<?= base_url('images/logo_pepadun.png') ?>" alt="Logo PEPADUN" style="width: 100%; height: auto; object-fit: contain;">
            </div>
            <span class="sidebar-badge" style="text-align: center; white-space: nowrap; padding: 0.4rem 0.6rem;">BBPOM di Bandar Lampung</span>
        </div>
    </div>

    <!-- Navigation Menu -->
    <ul class="sidebar-menu">
        <?php 
            $CI =& get_instance();
            $segment = $CI->uri->segment(1);
            
            // Dynamic years based on current year
            $currentYear = (int) date('Y');
            $years = [$currentYear, $currentYear - 1];
            
            $selectedYear = (int) ($CI->input->get('year') !== NULL ? $CI->input->get('year') : date('Y'));
            $selectedTriwulan = (int) ($CI->input->get('triwulan') !== NULL ? $CI->input->get('triwulan') : ceil(date('m') / 3));
        ?>
        <li class="sidebar-item <?= ($segment === 'dashboard' || empty($segment)) ? 'active' : '' ?>">
            <a href="<?= base_url("dashboard?year={$selectedYear}&triwulan={$selectedTriwulan}") ?>" class="sidebar-link" data-title="Dashboard">
                <div class="sidebar-link-content">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </div>
            </a>
        </li>
        
        <li class="sidebar-item <?= ($segment === 'monitoring') ? 'active' : '' ?>">
            <a href="<?= base_url("monitoring?year={$selectedYear}&triwulan={$selectedTriwulan}") ?>" class="sidebar-link sidebar-link-monitoring" data-title="Monitoring">
                <div class="sidebar-link-content">
                    <i class="bi bi-clipboard-check"></i>
                    <span>Monitoring</span>
                </div>
                <i class="bi <?= ($segment === 'monitoring') ? 'bi-chevron-up' : 'bi-chevron-down' ?> dropdown-chevron" style="font-size: 0.8rem;"></i>
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
            }
            
            toggleBtn.addEventListener('click', () => {
                document.body.classList.toggle('sidebar-collapsed');
                const isCollapsed = document.body.classList.contains('sidebar-collapsed');
                localStorage.setItem('sidebar-collapsed', isCollapsed);
            });
        }

        // Expand sidebar when clicking on the brand logo while collapsed
        const brandLogo = document.getElementById('sidebarBrand');
        if (brandLogo) {
            brandLogo.addEventListener('click', (e) => {
                if (document.body.classList.contains('sidebar-collapsed')) {
                    e.preventDefault();
                    document.body.classList.remove('sidebar-collapsed');
                    localStorage.setItem('sidebar-collapsed', 'false');
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
                    
                    // Toggle chevron icon direction
                    const chevron = monitoringLink.querySelector('.dropdown-chevron');
                    if (chevron) {
                        chevron.classList.toggle('bi-chevron-down');
                        chevron.classList.toggle('bi-chevron-up');
                    }
                }
            });
        }
    });
</script>
