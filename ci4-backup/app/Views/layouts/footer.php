<!-- Dark Blue Corporate Footer matching mockup -->
<footer class="footer-panel">
    <div class="footer-content">
        <div class="footer-brand">
            <img src="<?= base_url('images/logo_only.png') ?>" alt="Logo BADAN POM" style="filter: brightness(0) invert(1); width: 45px; height: auto;">
            <h3 class="footer-brand-title">PEPADUN</h3>
            <p style="font-size: 0.8rem; line-height: 1.4; color: rgba(255,255,255,0.7);">
                Percepatan Pantau Dokumen serta Update Data dan Informasi BBPOM di Bandar Lampung.
            </p>
        </div>
        
        <div class="footer-section">
            <h4>Tautan</h4>
            <ul class="footer-links">
                <li><a href="<?= base_url('dashboard') ?>">Beranda</a></li>
                <li><a href="<?= base_url('monitoring') ?>">Informasi</a></li>
                <li><a href="https://bbpom-bandarlampung.pom.go.id" target="_blank">Tentang PEPADUN</a></li>
                <li><a href="https://bbpom-bandarlampung.pom.go.id/kontak" target="_blank">Kontak</a></li>
            </ul>
        </div>

        <div class="footer-section" style="grid-column: span 2;">
            <h4>Kontak Kami</h4>
            <div class="footer-contact">
                <div class="footer-contact-item">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>Jl. Dr. Susilo No.12, Sumur Batu, Kec. Tlk. Betung Utara, Kota Bandar Lampung, Lampung 35124</span>
                </div>
                <div class="footer-contact-item">
                    <i class="bi bi-telephone-fill"></i>
                    <span>(0721) 778652</span>
                </div>
                <div class="footer-contact-item">
                    <i class="bi bi-envelope-fill"></i>
                    <span>bbpom_lampung@pom.go.id</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        <span>© <?= date('Y') ?> BBPOM di Bandar Lampung. All rights reserved.</span>
        <span>Monitoring Keterbukaan Informasi Publik - Version 1.0</span>
    </div>
</footer>
