<!-- views/matkul/form.php -->
<div class="content-wrapper p-4">
    <h3><?= $title ?></h3>
    <form method="POST">
        <div class="mb-3">
            <label>Kode Mata Kuliah</label>
            <input type="text" name="kode" value="<?= $matkul['kode'] ?? '' ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nama Mata Kuliah</label>
            <input type="text" name="nama" value="<?= $matkul['nama'] ?? '' ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Dosen Pengampu</label>
            <input type="text" name="dosen_pengampu" value="<?= $matkul['dosen_pengampu'] ?? '' ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tahun Angkatan</label>
            <select name="angkatan_id" class="form-control" required>
                <?php while ($a = $angkatanStmt->fetch()): ?>
                    <option value="<?= $a['id'] ?>" <?= (isset($matkul['angkatan_id']) && $matkul['angkatan_id'] == $a['id']) ? 'selected' : '' ?>>
                        <?= $a['tahun'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="../modules/matkul/read.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>