<?php
session_start();
if (!in_array($_SESSION['role'], ['akademik', 'kaprodi', 'wadir1'])) {
    die("Akses ditolak!");
}
include '../../config/config.php';
include '../../includes/template.php';

$stmt = $pdo->query("
    SELECT 
        cpl.id,
        cpl.kode,
        cpl.deskripsi,
        AVG(p.skor) as rata_rata
    FROM cpl
    JOIN cpmk ON cpl.id = cpmk.cpl_id
    JOIN penilaian p ON cpmk.id = p.cpmk_id
    GROUP BY cpl.id
");
$cplResults = $stmt->fetchAll();

$content = '
    <h3>Rumusan Akhir Capaian Pembelajaran Lulusan (CPL)</h3>
    <p>Rekap berdasarkan rata-rata pencapaian CPMK terkait.</p>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Kode CPL</th>
                <th>Deskripsi</th>
                <th>Rata-rata Pencapaian</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>';

foreach ($cplResults as $c) {
    $status = '';
    if ($c['rata_rata'] >= 80) {
        $status = '<span class="badge badge-success">Tercapai</span>';
    } elseif ($c['rata_rata'] >= 60) {
        $status = '<span class="badge badge-warning">Perlu Evaluasi</span>';
    } else {
        $status = '<span class="badge badge-danger">Tidak Tercapai</span>';
    }

    $content .= '
            <tr>
                <td>' . htmlspecialchars($c['kode']) . '</td>
                <td>' . htmlspecialchars($c['deskripsi']) . '</td>
                <td>' . number_format($c['rata_rata'], 2) . '%</td>
                <td>' . $status . '</td>
            </tr>';
}

$content .= '
        </tbody>
    </table>';

load_template('Rumusan Akhir CPL', $content);
?>