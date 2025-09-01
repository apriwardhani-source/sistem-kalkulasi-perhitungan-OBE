<?php
session_start();
if (!in_array($_SESSION['role'], ['admin'])) {
    die("Akses ditolak!");
}
include '../../config/config.php';
include '../../includes/template.php';

// Ambil data angkatan
try {
    $angkatanStmt = $pdo->query("SELECT * FROM angkatan");
    $angkatanList = $angkatanStmt->fetchAll();
} catch (PDOException $e) {
    die("Error database: " . $e->getMessage());
}

// Proses simpan jika POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $dosen = $_POST['dosen_pengampu'];
    $angkatan_id = $_POST['angkatan_id'];

    try {
        $stmt = $pdo->prepare("INSERT INTO matkul (kode, nama, dosen_pengampu, angkatan_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$kode, $nama, $dosen, $angkatan_id]);
        header('Location: read.php?success=1');
        exit;
    } catch (PDOException $e) {
        $error = "Gagal menyimpan: " . $e->getMessage();
    }
}

// Buat konten form
$content = '
    <h3>Tambah Mata Kuliah</h3>';

if (isset($error)) {
    $content .= '<div class="alert alert-danger">' . $error . '</div>';
}

$content .= '
    <form method="POST">
        <div class="mb-3">
            <label>Kode Mata Kuliah</label>
            <input type="text" name="kode" value="' . (isset($kode) ? htmlspecialchars($kode) : '') . '" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nama Mata Kuliah</label>
            <input type="text" name="nama" value="' . (isset($nama) ? htmlspecialchars($nama) : '') . '" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Dosen Pengampu</label>
            <input type="text" name="dosen_pengampu" value="' . (isset($dosen) ? htmlspecialchars($dosen) : '') . '" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tahun Angkatan</label>
            <select name="angkatan_id" class="form-control" required>
                <option value="">-- Pilih Tahun Angkatan --</option>';

foreach ($angkatanList as $a) {
    $selected = (isset($angkatan_id) && $angkatan_id == $a['id']) ? 'selected' : '';
    $content .= '<option value="' . $a['id'] . '" ' . $selected . '>' . htmlspecialchars($a['tahun']) . '</option>';
}

$content .= '
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="read.php" class="btn btn-secondary">Kembali</a>
    </form>';

// Tampilkan halaman dengan template
load_template('Tambah Mata Kuliah', $content);
?>