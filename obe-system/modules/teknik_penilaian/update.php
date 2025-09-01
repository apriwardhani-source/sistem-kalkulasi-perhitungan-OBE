// modules/teknik_penilaian/update.php
<?php
session_start();
if (!in_array($_SESSION['role'], ['admin', 'akademik'])) {
    die("Akses ditolak!");
}
include '../../config/config.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM teknik_penilaian WHERE id = ?");
$stmt->execute([$id]);
$t = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $stmt = $pdo->prepare("UPDATE teknik_penilaian SET nama = ? WHERE id = ?");
    $stmt->execute([$nama, $id]);
    header('Location: read.php?success=1');
    exit;
}
?>
<form method="POST">
    <div class="mb-3">
        <label>Nama Teknik</label>
        <input type="text" name="nama" value="<?= $t['nama'] ?>" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>