<!-- views/penilaian/rekap.php -->
<div class="content-wrapper p-4">
    <h3>Rekap Penilaian</h3>
    <table class="table table-bordered">
        <tr>
            <th>Kode MK</th>
            <th>Nama MK</th>
            <th>Total Skor</th>
            <th>Status</th>
        </tr>
        <?php foreach ($matkulResults as $r): ?>
        <tr>
            <td><?= $r['kode'] ?></td>
            <td><?= $r['nama'] ?></td>
            <td><?= $r['total_skor'] ?></td>
            <td>
                <?= $r['total_skor'] == 100 ? 'Lengkap' : 'Belum Lengkap' ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>