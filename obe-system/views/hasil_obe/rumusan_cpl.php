<!-- views/hasil_obe/rumusan_cpl.php -->
<div class="content-wrapper p-4">
    <h3>Rumusan Akhir Capaian Pembelajaran Lulusan (CPL)</h3>
    <p>Rekap berdasarkan rata-rata CPMK yang terkait.</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode CPL</th>
                <th>Deskripsi</th>
                <th>Rata-rata Pencapaian</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cplResults as $c): ?>
            <tr>
                <td><?= $c['kode'] ?></td>
                <td><?= $c['deskripsi'] ?></td>
                <td><?= number_format($c['rata_rata'], 2) ?>%</td>
                <td>
                    <?php if ($c['rata_rata'] >= 80): ?>
                        <span class="badge badge-success">Tercapai</span>
                    <?php elseif ($c['rata_rata'] >= 60): ?>
                        <span class="badge badge-warning">Perlu Evaluasi</span>
                    <?php else: ?>
                        <span class="badge badge-danger">Tidak Tercapai</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>