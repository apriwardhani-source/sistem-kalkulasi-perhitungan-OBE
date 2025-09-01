<!-- views/user/list.php -->
<div class="content-wrapper p-4">
    <h3>Manajemen Pengguna</h3>
    <a href="../modules/user/create.php" class="btn btn-primary mb-3">+ Tambah Pengguna</a>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Berhasil disimpan!</div>
    <?php endif; ?>
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-warning">Pengguna dihapus!</div>
    <?php endif; ?>

    <table class="table table-bordered">
        <tr>
            <th>Username</th>
            <th>Nama</th>
            <th>Role</th>
            <th>Prodi</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u['username'] ?></td>
            <td><?= $u['nama_lengkap'] ?></td>
            <td><?= ucfirst($u['role']) ?></td>
            <td><?= $u['prodi_nama'] ?? '-' ?></td>
            <td>
                <a href="../modules/user/update.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="../modules/user/delete.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-danger"
                   onclick="return confirm('Hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>