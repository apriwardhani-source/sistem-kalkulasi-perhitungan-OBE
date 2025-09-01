<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}
include '../../config/config.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    die("Pengguna tidak ditemukan.");
}

$prodiStmt = $pdo->query("SELECT * FROM prodi");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_lengkap'];
    $role = $_POST['role'];
    $prodi_id = $_POST['prodi_id'] ?? null;
    $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];

    $stmt = $pdo->prepare("UPDATE users SET nama_lengkap = ?, role = ?, prodi_id = ?, password = ? WHERE id = ?");
    $stmt->execute([$nama, $role, $prodi_id, $password, $id]);

    header('Location: read.php?success=1');
    exit;
}
?>

<h3>Edit Pengguna</h3>
<form method="POST">
    <div class="mb-3">
        <label>Username</label>
        <input type="text" class="form-control" value="<?= $user['username'] ?>" disabled>
    </div>
    <div class="mb-3">
        <label>Password (kosongkan jika tidak diubah)</label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="mb-3">
        <label>Nama Lengkap</label>
        <input type="text" name="nama_lengkap" value="<?= $user['nama_lengkap'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Role</label>
        <select name="role" class="form-control" required>
            <option value="dosen" <?= $user['role']=='dosen'?'selected':'' ?>>Dosen</option>
            <option value="akademik" <?= $user['role']=='akademik'?'selected':'' ?>>Akademik Prodi</option>
            <option value="kaprodi" <?= $user['role']=='kaprodi'?'selected':'' ?>>Kaprodi</option>
            <option value="wadir1" <?= $user['role']=='wadir1'?'selected':'' ?>>Wadir 1</option>
            <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Prodi</label>
        <select name="prodi_id" class="form-control">
            <option value="">-- Pilih --</option>
            <?php 
            $prodiStmt = $pdo->query("SELECT * FROM prodi");
            while ($p = $prodiStmt->fetch()): ?>
                <option value="<?= $p['id'] ?>" <?= $user['prodi_id']==$p['id']?'selected':'' ?>>
                    <?= $p['nama'] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="read.php" class="btn btn-secondary">Kembali</a>
</form>