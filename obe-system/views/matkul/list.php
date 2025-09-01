<!-- views/matkul/list.php -->
<div class="content-wrapper p-4">
    <h3>Daftar Mata Kuliah</h3>
    <a href="../modules/matkul/create.php" class="btn btn-primary mb-3">+ Tambah Mata Kuliah</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Dosen Pengampu</th>
                <th>Angkatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($matkuls as $m): ?>
            <tr>
                <td><?= htmlspecialchars($m['kode']) ?></td>
                <td><?= htmlspecialchars($m['nama']) ?></td>
                <td><?= htmlspecialchars($m['dosen_pengampu']) ?></td>
                <td><?= htmlspecialchars($m['tahun_angkatan']) ?></td>
                <td>
                    <a href="../modules/matkul/update.php?id=<?= $m['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="../modules/matkul/delete.php?id=<?= $m['id'] ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('Hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>