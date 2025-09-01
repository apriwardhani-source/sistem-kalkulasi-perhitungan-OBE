<?php
session_start();
if (!in_array($_SESSION['role'], ['admin', 'akademik'])) {
    die("Akses ditolak!");
}
include '../../config/config.php';
include '../../includes/template.php';

// Ambil data angkatan + nama prodi
try {
    $stmt = $pdo->query("
        SELECT a.*, p.nama as prodi_nama 
        FROM angkatan a 
        JOIN prodi p ON a.prodi_id = p.id
    ");
    $angkatan = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error database: " . $e->getMessage());
}

// Buat konten dinamis
$content = '
    <h3>Tahun Angkatan</h3>
    <a href="create.php" class="btn btn-primary mb-3">+ Tambah Angkatan</a>';

// Tampilkan pesan sukses/hapus
if (isset($_GET['success'])) {
    $content .= '<div class="alert alert-success">Berhasil disimpan!</div>';
}
if (isset($_GET['deleted'])) {
    $content .= '<div class="alert alert-warning">Data dihapus!</div>';
}

$content .= '
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Tahun</th>
                <th>Prodi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>';

foreach ($angkatan as $a) {
    $content .= '
            <tr>
                <td>' . htmlspecialchars($a['tahun']) . '</td>
                <td>' . htmlspecialchars($a['prodi_nama']) . '</td>
                <td>
                    <a href="update.php?id=' . $a['id'] . '" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete.php?id=' . $a['id'] . '" class="btn btn-sm btn-danger"
                       onclick="return confirm(\'Hapus?\')">Hapus</a>
                </td>
            </tr>';
}

$content .= '
        </tbody>
    </table>';

// Tampilkan halaman dengan template
load_template('Tahun Angkatan', $content);
?>