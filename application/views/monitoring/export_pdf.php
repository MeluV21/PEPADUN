<?php
// Function for Indonesian date format
function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

$tanggal_sekarang = tgl_indo(date('Y-m-d'));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Export PDF - Data Monitoring</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        #loading {
            text-align: center;
            font-size: 16px;
            margin-bottom: 20px;
            color: #0c3d79;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            #loading {
                display: none;
            }
            #pdf-wrapper {
                width: 100%;
                margin: 0;
                padding: 0;
            }
            @page {
                size: landscape;
                margin: 1cm;
            }
        }
        
        /* Wrapper for the PDF content with white background */
        #pdf-wrapper {
            background: white;
            padding: 20px;
            width: 1000px;
            margin: 0 auto;
        }
        h2, h3 {
            text-align: center;
            margin: 5px 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        
        .signature-container {
            width: 100%;
            page-break-inside: avoid;
        }
        
        .signature-table {
            border: none;
            width: 100%;
            margin: 0;
            padding: 0;
        }
        .signature-table td {
            border: none;
            padding: 0;
        }
        
        .signature-box {
            width: 300px;
            float: right;
            text-align: left;
        }
    </style>
</head>
<body>
    <div id="loading">Mempersiapkan PDF... Harap tunggu sebentar.</div>

    <div id="pdf-wrapper">
        <div id="pdf-content">
            <h2>DATA MONITORING KETERBUKAAN INFORMASI</h2>
            <h3>Triwulan <?= esc($triwulan) ?> Tahun <?= esc($year) ?></h3>
            
            <table>
                <thead>
                    <tr>
                        <th style="width: 4%;">No.</th>
                        <th style="width: 20%;">Nama Informasi</th>
                        <th style="width: 12%;">Kategori</th>
                        <th style="width: 12%;">PJ</th>
                        <th style="width: 10%;">Timeline</th>
                        <th style="width: 12%;">Status</th>
                        <th style="width: 15%;">Keterangan</th>
                        <th style="width: 15%;">Tautan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($monitoringList)): ?>
                        <?php $no = 1; foreach ($monitoringList as $item): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= esc($item['custom_name'] ?: $item['name']) ?></td>
                                <td><?= esc($item['category_name'] ?: 'Tanpa Kategori') ?></td>
                                <td><?= esc($item['pj'] ?: '-') ?></td>
                                <td><?= esc($item['timeline'] ?: '-') ?></td>
                                <td>
                                    <?php 
                                        $status = $item['status'];
                                        if ($status == 'completed') echo 'Selesai (Completed)';
                                        elseif ($status == 'progress') echo 'Dalam Proses';
                                        else echo 'Belum Update';
                                    ?>
                                </td>
                                <td><?= esc($item['description'] ?: '-') ?></td>
                                <td style="word-break: break-all;">
                                    <?php if (!empty($item['tautan'])): ?>
                                        <a href="<?= esc($item['tautan']) ?>" target="_blank" style="color: blue; text-decoration: none;"><?= esc($item['tautan']) ?></a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center" style="padding: 20px;">Belum ada data monitoring.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <div class="signature-container">
                <table class="signature-table">
                    <tr>
                        <td></td>
                        <td style="width: 300px;">
                            <div class="signature-box">
                                Bandar Lampung, <?= $tanggal_sekarang ?><br>
                                Kepala Balai Besar Pengawas Obat<br>
                                dan Makanan di Bandar Lampung,<br>
                                <br><br>
                                ${ttd_pengirim}<br><br>
                                Bagus Heri Purnomo, S.Si, Apt
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            var element = document.getElementById('pdf-content');
            var opt = {
                margin:       [0.5, 0.5, 0.5, 0.5], // top, left, bottom, right in inches
                filename:     'Data_Monitoring_Triwulan_<?= esc($triwulan) ?>_<?= esc($year) ?>.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true },
                jsPDF:        { unit: 'in', format: 'legal', orientation: 'landscape' }
            };
            
            html2pdf().set(opt).from(element).save().then(function() {
                document.getElementById('loading').innerHTML = 'Unduhan selesai! File PDF telah disimpan.<br><button onclick="window.print()" style="margin-top:10px; margin-right:10px; padding:8px 16px; cursor:pointer; background-color: #0c3d79; color: white; border: none; border-radius: 4px;">Cetak Dokumen (Print)</button><button onclick="window.close()" style="margin-top:10px; padding:8px 16px; cursor:pointer; background-color: #6c757d; color: white; border: none; border-radius: 4px;">Tutup Halaman</button>';
            });
        };
    </script>
</body>
</html>
