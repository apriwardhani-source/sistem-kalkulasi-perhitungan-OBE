<!-- views/cpl/list.php -->
<div class="content-wrapper p-4">
    <h3>Daftar CPL</h3>
    <a href="../modules/cpl/create.php" class="btn btn-primary mb-3">+ Tambah CPL</a>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Berhasil disimpan!</div>
    <?php endif; ?>
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-warning">CPL dihapus!</div>
    <?php endif; ?>

    <table class="table table-bordered">
        <tr>
            <th>Kode</th>
            <th>Deskripsi</th>
            <th>Angkatan</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($cpls as $c): ?>
        <tr>
            <td><?= $c['kode'] ?></td>
            <td><?= $c['deskripsi'] ?></td>
            <td><?= $c['tahun'] ?></td>
            <td>
                <a href="../modules/cpl/update.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="../modules/cpl/delete.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-danger"
                   onclick="return confirm('Hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>