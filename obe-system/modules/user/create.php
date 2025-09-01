<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}
include '../../config/config.php';

$prodiStmt = $pdo->query("SELECT * FROM prodi");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama = $_POST['nama_lengkap'];
    $role = $_POST['role'];
    $prodi_id = $_POST['prodi_id'] ?? null;

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, nama_lengkap, role, prodi_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $password, $nama, $role, $prodi_id]);
        header('Location: read.php?success=1');
        exit;
    } catch (Exception $e) {
        $error = "Username sudah ada!";
    }
}
?>

<h3>Tambah Pengguna</h3>
<form method="POST">
    <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Nama Lengkap</label>
        <input type="text" name="nama_lengkap" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Role</label>
        <select name="role" class="form-control" required>
            <option value="dosen">Dosen</option>
            <option value="akademik">Akademik Prodi</option>
            <option value="kaprodi">Kaprodi</option>
            <option value="wadir1">Wadir 1</option>
            <option value="admin">Admin</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Prodi (jika relevan)</label>
        <select name="prodi_id" class="form-control">
            <option value="">-- Pilih Prodi --</option>
            <?php while ($p = $prodiStmt->fetch()): ?>
                <option value="<?= $p['id'] ?>"><?= $p['nama'] ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="read.php" class="btn btn-secondary">Kembali</a>
</form>