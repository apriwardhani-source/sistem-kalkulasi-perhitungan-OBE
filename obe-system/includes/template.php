<?php
// includes/template.php

function load_template($title = 'Sistem OBE', $content = '') {
    // Mulai session jika belum
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Cek login
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../../views/auth/login.php');
        exit;
    }

    // Ambil role
    $role = $_SESSION['role'];

    // Load header
    include 'header.php';

    // Load sidebar
    include 'sidebar.php';
    ?>

    <!-- Konten Utama -->
    <div class="content-wrapper p-4">
        <?= $content ?>
        <head>    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css"></head>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    </div>

    <?php
    // Load footer
    include 'footer.php';
}
?>