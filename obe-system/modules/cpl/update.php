<?php
session_start();
if (!in_array($_SESSION['role'], ['admin', 'akademik'])) {
    die("Akses ditolak!");
}
include '../../config/config.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM cpl WHERE id = ?");
$stmt->execute([$id]);
$cpl = $stmt->fetch();

$angkatanStmt = $pdo->query("SELECT * FROM angkatan");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode = $_POST['kode'];
    $deskripsi = $_POST['deskripsi'];
    $angkatan_id = $_POST['angkatan_id'];
    $stmt = $pdo->prepare("UPDATE cpl SET kode = ?, deskripsi = ?, angkatan_id = ? WHERE id = ?");
    $stmt->execute([$kode, $deskripsi, $angkatan_id, $id]);
    header('Location: read.php?success=1');
    exit;
}
?>

<h3>Edit CPL</h3>
<form method="POST">
    <div class="mb-3">
        <label>Kode CPL</label>
        <input type="text" name="kode" value="<?= $cpl['kode'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control" required><?= $cpl['deskripsi'] ?></textarea>
    </div>
    <div class="mb-3">
        <label>Tahun Angkatan</label>
        <select name="angkatan_id" class="form-control" required>
            <?php 
            $angkatanStmt = $pdo->query("SELECT * FROM angkatan");
            while ($a = $angkatanStmt->fetch()): ?>
                <option value="<?= $a['id'] ?>" <?= $cpl['angkatan_id'] == $a['id'] ? 'selected' : '' ?>>
                    <?= $a['tahun'] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="read.php" class="btn btn-secondary">Kembali</a>
</form>