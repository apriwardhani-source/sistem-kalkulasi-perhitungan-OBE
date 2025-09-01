<!-- views/prodi/list.php -->
<div class="content-wrapper p-4">
    <h3>Daftar Program Studi</h3>
    <a href="../modules/prodi/create.php" class="btn btn-primary mb-3">+ Tambah Prodi</a>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Berhasil disimpan!</div>
    <?php endif; ?>
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-warning">Data dihapus!</div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Prodi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($prodis as $p): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($p['nama']) ?></td>
                <td>
                    <a href="../modules/prodi/update.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="../modules/prodi/delete.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('Hapus prodi ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>