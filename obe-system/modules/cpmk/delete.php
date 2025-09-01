<?php
session_start();
if (!in_array($_SESSION['role'], ['admin', 'akademik'])) {
    die("Akses ditolak!");
}
include '../../config/config.php';

$id = $_GET['id'] ?? null;
$stmt = $pdo->prepare("DELETE FROM cpmk WHERE id = ?");
$stmt->execute([$id]);

header('Location: read.php?deleted=1');
exit;
?>