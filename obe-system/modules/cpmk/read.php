<?php
session_start();
if (!in_array($_SESSION['role'], ['admin', 'akademik'])) {
    die("Akses ditolak!");
}
include '../../config/config.php';
include '../../includes/template.php';

$stmt = $pdo->query("
    SELECT cp.*, c.kode as cpl_kode, c.deskripsi as cpl_deskripsi, m.nama as matkul_nama
    FROM cpmk cp
    LEFT JOIN cpl c ON cp.cpl_id = c.id
    LEFT JOIN matkul m ON cp.matkul_id = m.matkul_id
");
$cpmks = $stmt->fetchAll();

$content = '
    <h3>Data CPMK</h3>
    <a href="create.php" class="btn btn-primary mb-3">+ Tambah CPMK</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Deskripsi</th>
                <th>CPL Terkait</th>
                <th>Mata Kuliah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>';

foreach ($cpmks as $cp) {
    $content .= '
            <tr>
                <td>' . htmlspecialchars($cp['kode']) . '</td>
                <td>' . htmlspecialchars($cp['deskripsi']) . '</td>
                <td>' . htmlspecialchars($cp['cpl_kode']) . ' - ' . htmlspecialchars($cp['cpl_deskripsi']) . '</td>
                <td>' . htmlspecialchars($cp['matkul_nama'] ?? '-') . '</td>
                <td>
                    <a href="update.php?id=' . $cp['id'] . '" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete.php?id=' . $cp['id'] . '" class="btn btn-sm btn-danger"
                       onclick="return confirm(\'Hapus?\')">Hapus</a>
                </td>
            </tr>';
}

$content .= '
        </tbody>
    </table>';

load_template('Data CPMK', $content);
?>