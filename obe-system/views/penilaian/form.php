<!-- views/penilaian/form.php -->
<div class="content-wrapper p-4">
    <h3>Input Penilaian - <?= $matkul['nama'] ?></h3>
    <p><strong>Kode:</strong> <?= $matkul['kode'] ?> | 
       <strong>Dosen:</strong> <?= $matkul['dosen_pengampu'] ?></p>

    <?php if ($totalSkor != 100 && isset($_POST['save'])): ?>
        <div class="alert alert-warning">Total skor harus 100! Saat ini: <?= $totalSkor ?></div>
    <?php elseif (isset($_POST['save'])): ?>
        <div class="alert alert-success">Penilaian berhasil disimpan!</div>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="matkul_id" value="<?= $matkul['id'] ?>">
        <table class="table table-bordered">
            <tr>
                <th>CPMK</th>
                <?php foreach ($teknikList as $t): ?>
                    <th><?= $t['nama'] ?></th>
                <?php endforeach; ?>
            </tr>
            <?php foreach ($cpmkList as $cpmk): ?>
                <tr>
                    <td><?= $cpmk['kode'] ?></td>
                    <?php foreach ($teknikList as $t): ?>
                        <td>
                            <input type="number" name="skor_<?= $cpmk['id'] ?>_<?= $t['id'] ?>"
                                   value="<?= $existingPenilaian[$cpmk['id']][$t['id']] ?? 0 ?>"
                                   class="form-control" min="0" max="100">
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
        <button type="submit" name="save" class="btn btn-primary">Simpan Penilaian</button>
        <a href="../modules/penilaian/input.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>