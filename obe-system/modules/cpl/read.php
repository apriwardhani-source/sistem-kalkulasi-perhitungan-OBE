<?php
session_start();
if (!in_array($_SESSION['role'], ['admin', 'akademik'])) {
    die("Akses ditolak!");
}
include '../../config/config.php';
include '../../includes/template.php';

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM cpl WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header('Location: read.php?deleted=1');
    exit;
}

$stmt = $pdo->query("
    SELECT c.*, a.tahun 
    FROM cpl c 
    JOIN angkatan a ON c.angkatan_id = a.id
");
$cpls = $stmt->fetchAll();

$content = '
    <h3>Data CPL</h3>
    <a href="create.php" class="btn btn-primary mb-3">+ Tambah CPL</a>';

if (isset($_GET['success'])) {
    $content .= '<div class="alert alert-success">Berhasil disimpan!</div>';
}
if (isset($_GET['deleted'])) {
    $content .= '<div class="alert alert-warning">CPL dihapus!</div>';
}

$content .= '<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Deskripsi</th>
            <th>Angkatan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>';

foreach ($cpls as $c) {
    $content .= '
    <tr>
        <td>' . htmlspecialchars($c['kode']) . '</td>
        <td>' . htmlspecialchars($c['deskripsi']) . '</td>
        <td>' . htmlspecialchars($c['tahun']) . '</td>
        <td>
            <a href="update.php?id=' . $c['id'] . '" class="btn btn-sm btn-warning">Edit</a>
            <a href="?delete=' . $c['id'] . '" class="btn btn-sm btn-danger"
               onclick="return confirm(\'Hapus?\')">Hapus</a>
        </td>
    </tr>';
}

$content .= '</tbody></table>';

load_template('Data CPL', $content);
?>