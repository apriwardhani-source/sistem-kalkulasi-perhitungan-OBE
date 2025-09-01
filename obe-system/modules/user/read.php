<?php
// modules/user/read.php

// Jalankan session
session_start();

// Cek role
if (!in_array($_SESSION['role'], ['admin'])) {
    die("Akses ditolak! Harus login sebagai admin.");
}

// Sambung ke database
include '../../config/config.php';

// Hapus user
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header('Location: read.php?deleted=1');
    exit;
}

// Ambil data
$stmt = $pdo->query("
    SELECT u.*, p.nama as prodi_nama 
    FROM users u 
    LEFT JOIN prodi p ON u.prodi_id = p.id
");
$users = $stmt->fetchAll();

// Buat konten
$content = '
    <h3>Manajemen Pengguna</h3>
    <a href="create.php" class="btn btn-primary mb-3">+ Tambah Pengguna</a>';

if (isset($_GET['success'])) {
    $content .= '<div class="alert alert-success">Berhasil disimpan!</div>';
}
if (isset($_GET['deleted'])) {
    $content .= '<div class="alert alert-warning">Pengguna dihapus!</div>';
}

$content .= '<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Username</th>
            <th>Nama</th>
            <th>Role</th>
            <th>Prodi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>';

foreach ($users as $u) {
    $content .= '
    <tr>
        <td>' . htmlspecialchars($u['username']) . '</td>
        <td>' . htmlspecialchars($u['nama_lengkap']) . '</td>
        <td>' . ucfirst($u['role']) . '</td>
        <td>' . ($u['prodi_nama'] ?? '-') . '</td>
        <td>
            <a href="update.php?id=' . $u['id'] . '" class="btn btn-sm btn-warning">Edit</a>
            <a href="?delete=' . $u['id'] . '" class="btn btn-sm btn-danger"
               onclick="return confirm(\'Hapus?\')">Hapus</a>
        </td>
    </tr>';
}

$content .= '</tbody></table>';
?>

<!-- ✅ Gunakan template dari includes -->
<?php include '../../includes/template.php'; ?>
<?php load_template('Manajemen Pengguna', $content); ?>