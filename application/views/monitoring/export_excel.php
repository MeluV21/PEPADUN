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
    <title>Export Data Monitoring</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Data Monitoring Keterbukaan Informasi</h2>
    <h3 style="text-align: center;">Triwulan <?= esc($triwulan) ?> Tahun <?= esc($year) ?></h3>
    <br>
    
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Informasi</th>
                <th>Kategori</th>
                <th>PJ</th>
                <th>Timeline</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Tautan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($monitoringList)): ?>
                <?php $no = 1; foreach ($monitoringList as $item): ?>
                    <tr>
                        <td style="text-align: center; vertical-align: top;"><?= $no++ ?></td>
                        <td style="vertical-align: top;"><?= esc($item['custom_name'] ?: $item['name']) ?></td>
                        <td style="vertical-align: top;"><?= esc($item['category_name'] ?: 'Tanpa Kategori') ?></td>
                        <td style="vertical-align: top;"><?= esc($item['pj'] ?: '-') ?></td>
                        <td style="vertical-align: top;"><?= esc($item['timeline'] ?: '-') ?></td>
                        <td style="vertical-align: top;">
                            <?php 
                                $status = $item['status'];
                                if ($status == 'completed') echo 'Selesai (Completed)';
                                elseif ($status == 'progress') echo 'Dalam Proses';
                                else echo 'Belum Update';
                            ?>
                        </td>
                        <td style="vertical-align: top;"><?= esc($item['description'] ?: '-') ?></td>
                        <td style="vertical-align: top;">
                            <?php if (!empty($item['tautan'])): ?>
                                <?= esc($item['tautan']) ?>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;">Belum ada data monitoring.</td>
                </tr>
            <?php endif; ?>
            
            <!-- Spacing rows before signature -->
            <tr><td colspan="8" style="border: none;">&nbsp;</td></tr>
            <tr><td colspan="8" style="border: none;">&nbsp;</td></tr>
            
            <!-- Signature Block aligned to the right (Tautan column) -->
            <tr>
                <td colspan="7" style="border: none;"></td>
                <td style="border: none; text-align: left;">
                    Bandar Lampung, <?= $tanggal_sekarang ?><br>
                    Kepala Balai Besar Pengawas Obat<br>
                    dan Makanan di Bandar Lampung,<br>
                    <br>
                    ${ttd_pengirim}<br>
                    <br>
                    Bagus Heri Purnomo, S.Si, Apt
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
