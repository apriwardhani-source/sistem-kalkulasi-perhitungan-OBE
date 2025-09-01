<?php
session_start();
if (!in_array($_SESSION['role'], ['admin', 'akademik'])) {
    die("Akses ditolak!");
}
include '../../config/config.php';
include '../../includes/template.php';

$prodiStmt = $pdo->query("SELECT * FROM prodi");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tahun = $_POST['tahun'];
    $prodi_id = $_POST['prodi_id'];

    $stmt = $pdo->prepare("INSERT INTO angkatan (tahun, prodi_id) VALUES (?, ?)");
    $stmt->execute([$tahun, $prodi_id]);

    header('Location: read.php?success=1');
    exit;
}

$content = '
    <h3>Tambah Tahun Angkatan</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Tahun (contoh: 2023/2024)</label>
            <input type="text" name="tahun" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Program Studi</label>
            <select name="prodi_id" class="form-control" required>
                <option value="">-- Pilih Prodi --</option>';

while ($p = $prodiStmt->fetch()) {
    $content .= '<option value="' . $p['id'] . '">' . htmlspecialchars($p['nama']) . '</option>';
}

$content .= '
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="read.php" class="btn btn-secondary">Kembali</a>
    </form>';

load_template('Tambah Angkatan', $content);
?>