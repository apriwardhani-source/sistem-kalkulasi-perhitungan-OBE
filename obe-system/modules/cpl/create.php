<?php
session_start();
if (!in_array($_SESSION['role'], ['admin', 'akademik'])) {
    die("Akses ditolak!");
}
include '../../config/config.php';
include '../../includes/template.php';

// Proses simpan jika POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode = $_POST['kode'];
    $deskripsi = $_POST['deskripsi'];
    $angkatan_id = $_POST['angkatan_id'];

    $stmt = $pdo->prepare("INSERT INTO cpl (kode, deskripsi, angkatan_id) VALUES (?, ?, ?)");
    $stmt->execute([$kode, $deskripsi, $angkatan_id]);

    header('Location: read.php?success=1');
    exit;
}

// Ambil daftar angkatan
try {
    $angkatanStmt = $pdo->query("SELECT * FROM angkatan");
    $angkatanList = $angkatanStmt->fetchAll();
} catch (PDOException $e) {
    die("Error database: " . $e->getMessage());
}

// Buat konten form
$content = '
    <h3>Tambah CPL</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Kode CPL</label>
            <input type="text" name="kode" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi CPL</label>
            <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label>Tahun Angkatan</label>
            <select name="angkatan_id" class="form-control" required>
                <option value="">-- Pilih Tahun Angkatan --</option>';

foreach ($angkatanList as $a) {
    $content .= '<option value="' . $a['id'] . '">' . htmlspecialchars($a['tahun']) . '</option>';
}

$content .= '
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="read.php" class="btn btn-secondary">Kembali</a>
    </form>';

// Tampilkan halaman dengan template
load_template('Tambah CPL', $content);
?>