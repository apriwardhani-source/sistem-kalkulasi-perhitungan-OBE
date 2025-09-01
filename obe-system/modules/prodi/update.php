<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}
include '../../config/config.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM prodi WHERE id = ?");
$stmt->execute([$id]);
$prodi = $stmt->fetch();

if (!$prodi) {
    die("Prodi tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $stmt = $pdo->prepare("UPDATE prodi SET nama = ? WHERE id = ?");
    $stmt->execute([$nama, $id]);
    header('Location: read.php?success=1');
    exit;
}
?>

<h3>Edit Prodi</h3>
<form method="POST">
    <div class="mb-3">
        <label>Nama Prodi</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($prodi['nama']) ?>" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="read.php" class="btn btn-secondary">Kembali</a>
</form>