<?php
session_start();
if (!in_array($_SESSION['role'], ['admin'])) {
    die("Akses ditolak!");
}
include '../../config/config.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM matkul WHERE id = ?");
$stmt->execute([$id]);
$matkul = $stmt->fetch();

$angkatanStmt = $pdo->query("SELECT * FROM angkatan");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $dosen = $_POST['dosen_pengampu'];
    $angkatan_id = $_POST['angkatan_id'];

    $stmt = $pdo->prepare("UPDATE matkul SET kode = ?, nama = ?, dosen_pengampu = ?, angkatan_id = ? WHERE id = ?");
    $stmt->execute([$kode, $nama, $dosen, $angkatan_id, $id]);
    header('Location: read.php?success=1');
    exit;
}
?>

<h3>Edit Mata Kuliah</h3>
<form method="POST">
    <div class="mb-3">
        <label>Kode</label>
        <input type="text" name="kode" value="<?= $matkul['kode'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" value="<?= $matkul['nama'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Dosen Pengampu</label>
        <input type="text" name="dosen_pengampu" value="<?= $matkul['dosen_pengampu'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Tahun Angkatan</label>
        <select name="angkatan_id" class="form-control" required>
            <?php 
            $angkatanStmt = $pdo->query("SELECT * FROM angkatan");
            while ($a = $angkatanStmt->fetch()): ?>
                <option value="<?= $a['id'] ?>" <?= $matkul['angkatan_id'] == $a['id'] ? 'selected' : '' ?>>
                    <?= $a['tahun'] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="read.php" class="btn btn-secondary">Kembali</a>
</form>