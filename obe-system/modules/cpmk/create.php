<?php
session_start();
if (!in_array($_SESSION['role'], ['admin', 'akademik'])) {
    die("Akses ditolak!");
}
include '../../config/config.php';
include '../../includes/template.php';

// Ambil data CPL dan Matkul
try {
    $cplStmt = $pdo->query("SELECT * FROM cpl");
    $cplList = $cplStmt->fetchAll();

    $matkulStmt = $pdo->query("SELECT * FROM matkul");
    $matkulList = $matkulStmt->fetchAll();
} catch (PDOException $e) {
    die("Error database: " . $e->getMessage());
}

// Proses simpan jika POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode = $_POST['kode'];
    $deskripsi = $_POST['deskripsi'];
    $cpl_id = $_POST['cpl_id'];
    $matkul_id = !empty($_POST['matkul_id']) ? $_POST['matkul_id'] : null;

    try {
        $stmt = $pdo->prepare("INSERT INTO cpmk (kode, deskripsi, cpl_id, matkul_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$kode, $deskripsi, $cpl_id, $matkul_id]);
        header('Location: read.php?success=1');
        exit;
    } catch (PDOException $e) {
        $error = "Gagal menyimpan CPMK: " . $e->getMessage();
    }
}

// Buat konten form
$content = '
    <h3>Tambah CPMK</h3>';

if (isset($error)) {
    $content .= '<div class="alert alert-danger">' . $error . '</div>';
}

$content .= '
    <form method="POST">
        <div class="mb-3">
            <label>Kode CPMK</label>
            <input type="text" name="kode" value="' . (isset($kode) ? htmlspecialchars($kode) : '') . '" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" required>' . (isset($deskripsi) ? htmlspecialchars($deskripsi) : '') . '</textarea>
        </div>
        <div class="mb-3">
            <label>CPL Terkait</label>
            <select name="cpl_id" class="form-control" required>
                <option value="">-- Pilih CPL --</option>';

foreach ($cplList as $cpl) {
    $selected = (isset($cpl_id) && $cpl_id == $cpl['id']) ? 'selected' : '';
    $content .= '<option value="' . $cpl['id'] . '" ' . $selected . '>' . htmlspecialchars($cpl['kode']) . ' - ' . htmlspecialchars($cpl['deskripsi']) . '</option>';
}

$content .= '
            </select>
        </div>
        <div class="mb-3">
            <label>Mata Kuliah (Opsional)</label>
            <select name="matkul_id" class="form-control">
                <option value="">Tidak terkait</option>';

foreach ($matkulList as $m) {
    $selected = (isset($matkul_id) && $matkul_id == $m['matkul_id']) ? 'selected' : '';
    $content .= '<option value="' . $m['matkul_id'] . '" ' . $selected . '>' . htmlspecialchars($m['kode']) . ' - ' . htmlspecialchars($m['nama']) . '</option>';
}

$content .= '
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan CPMK</button>
        <a href="read.php" class="btn btn-secondary">Kembali</a>
    </form>';

// Tampilkan halaman dengan template
load_template('Tambah CPMK', $content);
?>