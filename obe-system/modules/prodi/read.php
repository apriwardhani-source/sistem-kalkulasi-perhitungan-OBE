<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}
include '../../config/config.php';
include '../../includes/template.php';

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM prodi WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header('Location: read.php?deleted=1');
    exit;
}

$stmt = $pdo->query("SELECT * FROM prodi");
$prodis = $stmt->fetchAll();

$content = '
    <h3>Daftar Program Studi</h3>
    <a href="create.php" class="btn btn-primary mb-3">+ Tambah Prodi</a>';

if (isset($_GET['success'])) {
    $content .= '<div class="alert alert-success">Berhasil disimpan!</div>';
}
if (isset($_GET['deleted'])) {
    $content .= '<div class="alert alert-warning">Prodi dihapus!</div>';
}

$content .= '
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Prodi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>';

$no = 1;
foreach ($prodis as $p) {
    $content .= '
            <tr>
                <td>' . $no++ . '</td>
                <td>' . htmlspecialchars($p['nama']) . '</td>
                <td>
                    <a href="update.php?id=' . $p['id'] . '" class="btn btn-sm btn-warning">Edit</a>
                    <a href="?delete=' . $p['id'] . '" class="btn btn-sm btn-danger"
                       onclick="return confirm(\'Hapus?\')">Hapus</a>
                </td>
            </tr>';
}

$content .= '
        </tbody>
    </table>';

load_template('Data Prodi', $content);
?>