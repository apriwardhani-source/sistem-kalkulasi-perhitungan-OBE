<?php
session_start();
if (!in_array($_SESSION['role'], ['admin', 'akademik'])) {
    die("Akses ditolak!");
}
include '../../config/config.php';
include '../../includes/template.php';

// Proses simpan jika POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];

    try {
        $stmt = $pdo->prepare("INSERT INTO teknik_penilaian (nama) VALUES (?)");
        $stmt->execute([$nama]);
        header('Location: read.php?success=1');
        exit;
    } catch (PDOException $e) {
        $error = "Gagal menyimpan: " . $e->getMessage();
    }
}

// Buat konten form
$content = '
    <h3>Tambah Teknik Penilaian</h3>';

if (isset($error)) {
    $content .= '<div class="alert alert-danger">' . $error . '</div>';
}

$content .= '
    <form method="POST">
        <div class="mb-3">
            <label>Nama Teknik (UTS, UAS, Tugas, dll)</label>
            <input type="text" name="nama" value="' . (isset($nama) ? htmlspecialchars($nama) : '') . '" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="read.php" class="btn btn-secondary">Kembali</a>
    </form>';

// Tampilkan halaman dengan template
load_template('Tambah Teknik Penilaian', $content);
?>