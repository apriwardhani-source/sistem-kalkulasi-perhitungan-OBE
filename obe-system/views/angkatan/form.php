<!-- views/angkatan/form.php -->
<div class="content-wrapper p-4">
    <h3><?= $title ?></h3>
    <form method="POST">
        <div class="mb-3">
            <label>Tahun (contoh: 2020/2021)</label>
            <input type="text" name="tahun" value="<?= $angkatan['tahun'] ?? '' ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Program Studi</label>
            <select name="prodi_id" class="form-control" required>
                <?php while ($p = $prodiStmt->fetch()): ?>
                    <option value="<?= $p['id'] ?>" <?= (isset($angkatan['prodi_id']) && $angkatan['prodi_id'] == $p['id']) ? 'selected' : '' ?>>
                        <?= $p['nama'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="../modules/angkatan/read.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>