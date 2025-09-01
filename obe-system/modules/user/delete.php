<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}
include '../../config/config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID tidak valid.");
}

$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$id]);

header('Location: read.php?deleted=1');
exit;
?>