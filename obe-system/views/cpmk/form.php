<!-- views/cpmk/form.php -->
<div class="content-wrapper p-4">
    <h3><?= $title ?></h3>
    <form method="POST">
        <div class="mb-3">
            <label>Kode CPMK</label>
            <input type="text" name="kode" value="<?= $cpmk['kode'] ?? '' ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" required><?= $cpmk['deskripsi'] ?? '' ?></textarea>
        </div>
        <div class="mb-3">
            <label>CPL Terkait</label>
            <select name="cpl_id" class="form-control" required>
                <?php while ($cpl = $cplStmt->fetch()): ?>
                    <option value="<?= $cpl['id'] ?>" <?= (isset($cpmk['cpl_id']) && $cpmk['cpl_id'] == $cpl['id']) ? 'selected' : '' ?>>
                        <?= $cpl['kode'] ?> - <?= $cpl['deskripsi'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Mata Kuliah (Opsional)</label>
            <select name="matkul_id" class="form-control">
                <option value="">Tidak terkait</option>
                <?php while ($m = $matkulStmt->fetch()): ?>
                    <option value="<?= $m['id'] ?>" <?= (isset($cpmk['matkul_id']) && $cpmk['matkul_id'] == $m['id']) ? 'selected' : '' ?>>
                        <?= $m['kode'] ?> - <?= $m['nama'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="../modules/cpmk/read.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>