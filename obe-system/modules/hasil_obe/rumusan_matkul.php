<?php
session_start();
if (!in_array($_SESSION['role'], ['akademik', 'kaprodi', 'wadir1'])) {
    die("Akses ditolak!");
}
include '../../config/config.php';
include_once '../../includes/template.php'; // ✅ Gunakan include_once

try {
    $stmt = $pdo->query("
        SELECT 
            m.kode,
            m.nama,
            COALESCE(SUM(p.skor), 0) as total_skor
        FROM matkul m
        LEFT JOIN penilaian p ON m.matkul_id = p.matkul_id
        GROUP BY m.matkul_id
    ");
    $matkulResults = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

$content = '
    <h3>Rumusan Akhir Mata Kuliah</h3>
    <p>Rekap total skor penilaian per mata kuliah.</p>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Total Skor (dari 100)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>';

if (empty($matkulResults)) {
    $content .= '<tr><td colspan="4" class="text-center text-muted">Belum ada data mata kuliah.</td></tr>';
} else {
    foreach ($matkulResults as $r) {
        $total_skor = (float)($r['total_skor'] ?? 0); // ✅ Pastikan angka

        if ($total_skor >= 100) {
            $status = '<span class="badge badge-success">Lengkap</span>';
        } elseif ($total_skor > 0) {
            $status = '<span class="badge badge-warning">Belum Lengkap</span>';
        } else {
            $status = '<span class="badge badge-danger">Belum Ada Penilaian</span>';
        }

        $content .= '
            <tr>
                <td><strong>' . htmlspecialchars($r['kode']) . '</strong></td>
                <td>' . htmlspecialchars($r['nama']) . '</td>
                <td><strong>' . number_format($total_skor, 2) . '</strong></td>
                <td>' . $status . '</td>
            </tr>';
    }
}

$content .= '
        </tbody>
    </table>';

load_template('Rumusan Akhir Mata Kuliah', $content);
?>