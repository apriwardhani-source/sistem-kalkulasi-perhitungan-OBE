<?php
session_start();
if (!in_array($_SESSION['role'], ['admin', 'akademik'])) {
    die("Akses ditolak!");
}
include '../../config/config.php';
include '../../includes/template.php';

$stmt = $pdo->query("
    SELECT m.*, a.tahun as tahun_angkatan
    FROM matkul m
    JOIN angkatan a ON m.angkatan_id = a.id
");
$matkuls = $stmt->fetchAll();

$content = '
    <h3>Daftar Mata Kuliah</h3>
    <a href="create.php" class="btn btn-primary mb-3">+ Tambah Mata Kuliah</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Dosen Pengampu</th>
                <th>Angkatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>';

foreach ($matkuls as $m) {
    $content .= '
            <tr>
                <td>' . htmlspecialchars($m['kode']) . '</td>
                <td>' . htmlspecialchars($m['nama']) . '</td>
                <td>' . htmlspecialchars($m['dosen_pengampu']) . '</td>
                <td>' . htmlspecialchars($m['tahun_angkatan']) . '</td>
                <td>
                    <a href="update.php?id=' . $m['matkul_id'] . '" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete.php?id=' . $m['matkul_id'] . '" class="btn btn-sm btn-danger"
                       onclick="return confirm(\'Hapus?\')">Hapus</a>
                </td>
            </tr>';
}

$content .= '
        </tbody>
    </table>';

load_template('Data Mata Kuliah', $content);
?>