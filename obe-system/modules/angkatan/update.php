<?php
session_start();
if (!in_array($_SESSION['role'], ['admin', 'akademik'])) {
    die("Akses ditolak!");
}
include '../../config/config.php';
include '../../includes/template.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM angkatan WHERE id = ?");
$stmt->execute([$id]);
$angkatan = $stmt->fetch();

$prodiStmt = $pdo->query("SELECT * FROM prodi");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tahun = $_POST['tahun'];
    $prodi_id = $_POST['prodi_id'];
    $stmt = $pdo->prepare("UPDATE angkatan SET tahun = ?, prodi_id = ? WHERE id = ?");
    $stmt->execute([$tahun, $prodi_id, $id]);
    header('Location: read.php?success=1');
    exit;
}
?>

<h3>Edit Tahun Angkatan</h3>
<form method="POST">
    <div class="mb-3">
        <label>Tahun (contoh: 2020/2021)</label>
        <input type="text" name="tahun" value="<?= $angkatan['tahun'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Prodi</label>
        <select name="prodi_id" class="form-control" required>
            <?php 
            $prodiStmt = $pdo->query("SELECT * FROM prodi");
            while ($p = $prodiStmt->fetch()): ?>
                <option value="<?= $p['id'] ?>" <?= $angkatan['prodi_id'] == $p['id'] ? 'selected' : '' ?>>
                    <?= $p['nama'] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="read.php" class="btn btn-secondary">Kembali</a>
</form>