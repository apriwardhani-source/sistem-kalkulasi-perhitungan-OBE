<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}
include '../../config/config.php';
include '../../includes/template.php';

// Proses simpan jika POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];

    try {
        $stmt = $pdo->prepare("INSERT INTO prodi (nama) VALUES (?)");
        $stmt->execute([$nama]);
        header('Location: read.php?success=1');
        exit;
    } catch (PDOException $e) {
        $error = "Gagal menyimpan: " . $e->getMessage();
    }
}

// Buat konten form
$content = '
    <h3>Tambah Program Studi</h3>';

// Tampilkan error jika ada
if (isset($error)) {
    $content .= '<div class="alert alert-danger">' . $error . '</div>';
}

$content .= '
    <form method="POST">
        <div class="mb-3">
            <label>Nama Program Studi</label>
            <input type="text" name="nama" class="form-control" value="' . (isset($nama) ? htmlspecialchars($nama) : '') . '" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="read.php" class="btn btn-secondary">Kembali</a>
    </form>';

// Tampilkan halaman dengan template
load_template('Tambah Prodi', $content);
?>