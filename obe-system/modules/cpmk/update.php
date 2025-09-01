<?php
session_start();
if (!in_array($_SESSION['role'], ['admin', 'akademik'])) {
    die("Akses ditolak!");
}
include '../../config/config.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM cpmk WHERE id = ?");
$stmt->execute([$id]);
$cpmk = $stmt->fetch();

$cplStmt = $pdo->query("SELECT * FROM cpl");
$matkulStmt = $pdo->query("SELECT * FROM matkul");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode = $_POST['kode'];
    $deskripsi = $_POST['deskripsi'];
    $cpl_id = $_POST['cpl_id'];
    $matkul_id = $_POST['matkul_id'] ?: null;

    $stmt = $pdo->prepare("UPDATE cpmk SET kode = ?, deskripsi = ?, cpl_id = ?, matkul_id = ? WHERE id = ?");
    $stmt->execute([$kode, $deskripsi, $cpl_id, $matkul_id, $id]);
    header('Location: read.php?success=1');
    exit;
}
?>

<h3>Edit CPMK</h3>
<form method="POST">
    <div class="mb-3">
        <label>Kode CPMK</label>
        <input type="text" name="kode" value="<?= $cpmk['kode'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control" required><?= $cpmk['deskripsi'] ?></textarea>
    </div>
    <div class="mb-3">
        <label>CPL Terkait</label>
        <select name="cpl_id" class="form-control" required>
            <?php 
            $cplStmt = $pdo->query("SELECT * FROM cpl");
            while ($c = $cplStmt->fetch()): ?>
                <option value="<?= $c['id'] ?>" <?= $cpmk['cpl_id'] == $c['id'] ? 'selected' : '' ?>>
                    <?= $c['kode'] ?> - <?= $c['deskripsi'] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Mata Kuliah (Opsional)</label>
        <select name="matkul_id" class="form-control">
            <option value="">Tidak terkait</option>
            <?php 
            $matkulStmt = $pdo->query("SELECT * FROM matkul");
            while ($m = $matkulStmt->fetch()): ?>
                <option value="<?= $m['id'] ?>" <?= $cpmk['matkul_id'] == $m['id'] ? 'selected' : '' ?>>
                    <?= $m['kode'] ?> - <?= $m['nama'] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="read.php" class="btn btn-secondary">Kembali</a>
</form>