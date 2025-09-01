<!-- views/prodi/form.php -->
<div class="content-wrapper p-4">
    <h3><?= $title ?></h3>
    <form method="POST">
        <div class="mb-3">
            <label>Nama Program Studi</label>
            <input type="text" name="nama" value="<?= $prodi['nama'] ?? '' ?>" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="../modules/prodi/read.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>