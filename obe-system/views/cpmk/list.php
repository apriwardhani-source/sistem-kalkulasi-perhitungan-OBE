<!-- views/cpmk/list.php -->
<div class="content-wrapper p-4">
    <h3>Daftar CPMK</h3>
    <a href="../modules/cpmk/create.php" class="btn btn-primary mb-3">+ Tambah CPMK</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Deskripsi</th>
                <th>CPL Terkait</th>
                <th>Mata Kuliah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cpmks as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['kode']) ?></td>
                <td><?= htmlspecialchars($c['deskripsi']) ?></td>
                <td><?= htmlspecialchars($c['cpl_kode']) ?> - <?= htmlspecialchars($c['cpl_deskripsi']) ?></td>
                <td><?= htmlspecialchars($c['matkul_nama'] ?? '-') ?></td>
                <td>
                    <a href="../modules/cpmk/update.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="../modules/cpmk/delete.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('Hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>