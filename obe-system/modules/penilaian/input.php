<?php
session_start();
if ($_SESSION['role'] != 'dosen') {
    die("Hanya dosen yang bisa mengakses!");
}
include '../../config/config.php';
include '../../includes/template.php';

// Ambil matkul yang diajar dosen ini
try {
    $dosenNama = $_SESSION['nama']; // Pastikan nama sesuai dengan yang di tabel `matkul.dosen_pengampu`

    $matkulStmt = $pdo->prepare("SELECT * FROM matkul WHERE dosen_pengampu = ?");
    $matkulStmt->execute([$dosenNama]);
    $matkulList = $matkulStmt->fetchAll();

    // Default: belum pilih MK
    $matkul_id = null;
    $cpmkList = [];
    $teknikList = [];
    $totalSkor = 0;

    // Jika pilih MK
    if (isset($_POST['matkul_id'])) {
        $matkul_id = $_POST['matkul_id'];

        // Ambil CPMK untuk MK ini
        $cpmkStmt = $pdo->prepare("SELECT * FROM cpmk WHERE matkul_id = ?");
        $cpmkStmt->execute([$matkul_id]);
        $cpmkList = $cpmkStmt->fetchAll();

        // Ambil teknik penilaian
        $teknikStmt = $pdo->query("SELECT * FROM teknik_penilaian");
        $teknikList = $teknikStmt->fetchAll();

        // Proses simpan
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
            $totalSkor = 0;
            foreach ($cpmkList as $cpmk) {
                foreach ($teknikList as $tk) {
                    $inputName = "skor_{$cpmk['id']}_{$tk['id']}";
                    $skor = (int)($_POST[$inputName] ?? 0);
                    $totalSkor += $skor;

                    // Simpan atau update
                    $stmt = $pdo->prepare("
                        INSERT INTO penilaian (matkul_id, cpmk_id, teknik_id, skor) 
                        VALUES (?, ?, ?, ?) 
                        ON DUPLICATE KEY UPDATE skor = ?
                    ");
                    $stmt->execute([$matkul_id, $cpmk['id'], $tk['id'], $skor, $skor]);
                }
            }
        }
    }

} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
}

// Buat konten
$content = '
    <h3>Input Penilaian</h3>
    <p><strong>Dosen:</strong> ' . htmlspecialchars($_SESSION['nama']) . '</p>';

if (isset($error)) {
    $content .= '<div class="alert alert-danger">' . $error . '</div>';
}

// Form pilih MK
$content .= '
    <form method="POST">
        <div class="mb-3">
            <label>Pilih Mata Kuliah</label>
            <select name="matkul_id" onchange="this.form.submit()" class="form-control">
                <option value="">-- Pilih Mata Kuliah --</option>';

foreach ($matkulList as $m) {
    $selected = ($matkul_id == $m['matkul_id']) ? 'selected' : '';
    $content .= '<option value="' . $m['matkul_id'] . '" ' . $selected . '>' . htmlspecialchars($m['kode']) . ' - ' . htmlspecialchars($m['nama']) . '</option>';
}

$content .= '
            </select>
        </div>
    </form>';

// Tampilkan form input jika MK dipilih
if ($matkul_id && !empty($cpmkList)) {
    $content .= '
    <form method="POST">
        <input type="hidden" name="matkul_id" value="' . $matkul_id . '">
        <table class="table table-bordered table-striped">
            <thead class="thead-light">
                <tr>
                    <th>CPMK</th>';

    foreach ($teknikList as $t) {
        $content .= '<th>' . htmlspecialchars($t['nama']) . '</th>';
    }

    $content .= '
                </tr>
            </thead>
            <tbody>';

    foreach ($cpmkList as $cpmk) {
        $content .= '<tr><td><strong>' . htmlspecialchars($cpmk['kode']) . '</strong><br>' . htmlspecialchars($cpmk['deskripsi']) . '</td>';
        foreach ($teknikList as $t) {
            $inputName = "skor_{$cpmk['id']}_{$t['id']}";
            $value = isset($_POST[$inputName]) ? $_POST[$inputName] : 0;
            $content .= '<td><input type="number" name="' . $inputName . '" value="' . $value . '" min="0" max="100" class="form-control" style="width:80px"></td>';
        }
        $content .= '</tr>';
    }

    $content .= '
            </tbody>
        </table>
        <button type="submit" name="save" class="btn btn-primary">Simpan Penilaian</button>
    </form>';

    // Tampilkan pesan validasi
    if (isset($_POST['save'])) {
        if ($totalSkor != 100) {
            $content .= '<div class="alert alert-warning mt-3">Total skor harus 100! Saat ini: <strong>' . $totalSkor . '</strong></div>';
        } else {
            $content .= '<div class="alert alert-success mt-3">✅ Penilaian berhasil disimpan!</div>';
        }
    }

} elseif ($matkul_id) {
    $content .= '<div class="alert alert-info">Tidak ada CPMK terkait untuk mata kuliah ini.</div>';
}

if (empty($matkulList)) {
    $content .= '<div class="alert alert-warning">Anda belum memiliki mata kuliah yang dikelola.</div>';
}

// Tampilkan dengan template
load_template('Input Penilaian', $content);
?>