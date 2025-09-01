<!-- includes/sidebar.php -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="./dashboard.php" class="brand-link text-center">
        <span class="brand-text font-weight-bold">SISTEM OBE</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="../../dashboard.php" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Master Data -->
                <?php if (in_array($_SESSION['role'], ['admin', 'akademik'])): ?>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../../modules/user/read.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manajemen Pengguna</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../modules/prodi/read.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Prodi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../modules/angkatan/read.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tahun Angkatan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- CPL & CPMK -->
                <?php if (in_array($_SESSION['role'], ['admin', 'akademik'])): ?>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>
                            Capaian Pembelajaran
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../../modules/cpl/read.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data CPL</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../modules/cpmk/read.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data CPMK</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- Mata Kuliah -->
                <?php if (in_array($_SESSION['role'], ['admin', 'akademik'])): ?>
                <li class="nav-item">
                    <a href="../../modules/matkul/read.php" class="nav-link">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>Mata Kuliah</p>
                    </a>
                </li>
                <?php endif; ?>

                <!-- Teknik Penilaian -->
                <?php if (in_array($_SESSION['role'], ['admin', 'akademik'])): ?>
                <li class="nav-item">
                    <a href="../../modules/teknik_penilaian/read.php" class="nav-link">
                        <i class="nav-icon fas fa-list-ol"></i>
                        <p>Teknik Penilaian</p>
                    </a>
                </li>
                <?php endif; ?>

                <!-- Penilaian (Dosen) -->
                <?php if ($_SESSION['role'] == 'dosen'): ?>
                <li class="nav-item">
                    <a href="../../modules/penilaian/input.php" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>Input Penilaian</p>
                    </a>
                </li>
                <?php endif; ?>

                <!-- Hasil OBE -->
                <?php if ($_SESSION['role'] != 'dosen'): ?>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Hasil OBE
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../../modules/hasil_obe/rumusan_matkul.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rumusan Akhir MK</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../modules/hasil_obe/rumusan_cpl.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rumusan Akhir CPL</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- Laporan (Kaprodi & Wadir) -->
                <?php if (in_array($_SESSION['role'], ['kaprodi', 'wadir1'])): ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Laporan OBE</p>
                    </a>
                </li>
                <?php endif; ?>

                <!-- Logout -->
                <li class="nav-item">
                    <a href="../../modules/auth/logout.php" class="nav-link text-danger">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>