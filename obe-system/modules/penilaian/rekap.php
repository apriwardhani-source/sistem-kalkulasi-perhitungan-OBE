<?php
session_start();
if (!in_array($_SESSION['role'], ['akademik', 'kaprodi', 'wadir1'])) {
    die("Akses ditolak!");
}
include '../../config/config.php';
include '../../includes/template.php';

$stmt = $pdo->query("
    SELECT 
        m.kode,
        m.nama,
        m.dosen_pengampu,
        SUM(p.skor) as total_skor
    FROM matkul m
    LEFT JOIN penilaian p ON m.id = p.matkul_id
    GROUP BY m.id
");
$matkulResults = $stmt->fetchAll();

$content = '
    <h3>Rekap Penilaian per Mata Kuliah</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Dosen</th>
                <th>Total Skor</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>';

foreach ($matkulResults as $r) {
    $status = $r['total_skor'] == 100 
        ? '<span class="badge badge-success">Lengkap</span>' 
        : '<span class="badge badge-warning">Belum Lengkap</span>';

    $content .= '
            <tr>
                <td>' . htmlspecialchars($r['kode']) . '</td>
                <td>' . htmlspecialchars($r['nama']) . '</td>
                <td>' . htmlspecialchars($r['dosen_pengampu']) . '</td>
                <td>' . number_format($r['total_skor'], 2) . '</td>
                <td>' . $status . '</td>
            </tr>';
}

$content .= '
        </tbody>
    </table>';

load_template('Rekap Penilaian', $content);
?>