<!-- views/hasil_obe/rumusan_matkul.php -->
<div class="content-wrapper p-4">
    <h3>Rumusan Akhir Mata Kuliah</h3>
    <p>Rekap total skor penilaian per mata kuliah.</p>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Mata Kuliah</th>
                <th>Total Skor</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($matkulResults as $r): ?>
            <tr>
                <td><?= $r['kode'] ?></td>
                <td><?= $r['nama'] ?></td>
                <td><?= number_format($r['total_skor'], 2) ?></td>
                <td>
                    <?php if ($r['total_skor'] == 100): ?>
                        <span class="badge badge-success">Lengkap</span>
                    <?php else: ?>
                        <span class="badge badge-warning">Belum Lengkap</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>