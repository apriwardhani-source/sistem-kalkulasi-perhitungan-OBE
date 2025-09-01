<!-- views/angkatan/list.php -->
<div class="content-wrapper p-4">
    <h3>Tahun Angkatan</h3>
    <a href="../modules/angkatan/create.php" class="btn btn-primary mb-3">+ Tambah Angkatan</a>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Berhasil disimpan!</div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tahun</th>
                <th>Prodi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($angkatans as $a): ?>
            <tr>
                <td><?= htmlspecialchars($a['tahun']) ?></td>
                <td><?= htmlspecialchars($a['prodi_nama']) ?></td>
                <td>
                    <a href="../modules/angkatan/update.php?id=<?= $a['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="../modules/angkatan/delete.php?id=<?= $a['id'] ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('Hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>