<?php
session_start();
if (!in_array($_SESSION['role'], ['admin', 'akademik'])) {
    die("Akses ditolak!");
}
include '../../config/config.php';
include '../../includes/template.php';

// Hapus data jika ada permintaan
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM teknik_penilaian WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header('Location: read.php?deleted=1');
    exit;
}

// Ambil data teknik penilaian
try {
    $stmt = $pdo->query("SELECT * FROM teknik_penilaian");
    $teknik = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error database: " . $e->getMessage());
}

// Buat konten dinamis
$content = '
    <h3>Manajemen Teknik Penilaian</h3>
    <a href="create.php" class="btn btn-primary mb-3">+ Tambah Teknik Penilaian</a>';

// Tampilkan pesan
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
                <th>Nama Teknik</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>';

foreach ($teknik as $t) {
    $content .= '
            <tr>
                <td>' . htmlspecialchars($t['nama']) . '</td>
                <td>
                    <a href="update.php?id=' . $t['id'] . '" class="btn btn-sm btn-warning">Edit</a>
                    <a href="?delete=' . $t['id'] . '" class="btn btn-sm btn-danger"
                       onclick="return confirm(\'Hapus?\')">Hapus</a>
                </td>
            </tr>';
}

$content .= '
        </tbody>
    </table>';

// Tampilkan dengan template
load_template('Teknik Penilaian', $content);
?>