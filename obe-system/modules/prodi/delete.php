<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}
include '../../config/config.php';

$id = $_GET['id'] ?? null;
$stmt = $pdo->prepare("DELETE FROM prodi WHERE id = ?");
$stmt->execute([$id]);

header('Location: read.php?deleted=1');
exit;
?>