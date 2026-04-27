<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Dashboard'; ?> - IT Helpdesk JMI</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-blue: #0d6efd;
            --sidebar-bg: #ffffff;
            --body-bg: #f8f9fc;
            --text-dark: #343a40;
            --text-muted: #858796;
        }

        body {
            background-color: var(--body-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* --- SIDEBAR MODERN & RESPONSIVE SCROLL --- */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--sidebar-bg);
            border-right: 1px solid #eaecf4;
            z-index: 1050; /* Diperbesar agar di atas overlay saat di HP */
            padding-top: 20px;
            transition: transform 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            overflow-y: auto; 
            overflow-x: hidden;
        }

        /* CUSTOM SCROLLBAR ELEGAN */
        .sidebar::-webkit-scrollbar { width: 5px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(160, 174, 192, 0.3); border-radius: 10px; }
        .sidebar::-webkit-scrollbar-thumb:hover { background: rgba(160, 174, 192, 0.6); }

        .brand-logo {
            padding: 10px 25px 30px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            flex-shrink: 0; 
        }

        .menu-label {
            font-size: 0.75rem;
            font-weight: 800;
            color: #b7b9cc;
            text-transform: uppercase;
            letter-spacing: 0.1rem;
            padding: 0 25px 10px;
            margin-top: 10px;
        }

        .nav-link {
            padding: 12px 20px;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            margin: 4px 15px;
            border-radius: 10px;
        }

        .nav-link i {
            width: 30px;
            font-size: 1.1rem;
            text-align: center;
        }

        .nav-link.active, .nav-link:hover {
            background-color: var(--primary-blue);
            color: #ffffff !important;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2);
        }

        /* Animasi Rotasi Ikon Panah Dropdown */
        .nav-link[data-bs-toggle="collapse"] .fa-chevron-down { transition: transform 0.3s ease; }
        .nav-link[data-bs-toggle="collapse"].collapsed .fa-chevron-down { transform: rotate(-90deg); }

        /* --- SUBMENU SIDEBAR --- */
        .custom-submenu {
            padding: 10px 20px;
            margin: 2px 15px 2px 40px;
            border-radius: 8px;
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .custom-submenu .icon-menu { width: 25px; text-align: center; font-size: 12px; }
        .custom-submenu:hover { color: var(--primary-blue); background-color: #f0f4ff; }
        .custom-submenu.active-submenu { color: var(--primary-blue); background-color: #f0f4ff; font-weight: 700; }

        /* --- KONTEN UTAMA & TOPBAR --- */
        .main-content {
            margin-left: 260px;
            padding: 25px 35px;
            min-height: 100vh;
            transition: margin-left 0.3s ease-in-out;
        }

        .topbar {
            background: transparent;
            padding: 10px 0 30px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title h4 {
            font-weight: 800;
            color: #2e384d;
            font-size: 1.5rem;
            margin: 0;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
            background: white;
            padding: 8px 15px;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            border: 1px solid #eaecf4;
        }

        .avatar-circle {
            width: 38px;
            height: 38px;
            background-color: var(--primary-blue);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
        }

        /* Pembungkus Tombol Keluar */
        .logout-wrapper { margin-top: auto; padding: 25px; flex-shrink: 0; }
        .btn-logout { background-color: transparent; color: #e74a3b; border: 1px solid #e74a3b; font-weight: bold; border-radius: 10px; padding: 10px; width: 100%; transition: all 0.3s; }
        .btn-logout:hover { background-color: #e74a3b; color: white; box-shadow: 0 4px 12px rgba(231, 74, 59, 0.2); }

        /* Tombol Hamburger & Overlay (Sembunyi di Layar Besar) */
        .mobile-toggle { display: none; background: white; border: 1px solid #eaecf4; border-radius: 8px; padding: 8px 12px; color: var(--primary-blue); cursor: pointer; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.4); z-index: 1040; backdrop-filter: blur(2px); opacity: 0; transition: opacity 0.3s ease; }

        /* ========================================================
           RESPONSIVE DESIGN (UNTUK LAYAR HP & TABLET)
           ======================================================== */
        @media (max-width: 992px) {
            /* 1. Sembunyikan sidebar ke luar layar kiri */
            .sidebar { transform: translateX(-100%); }
            
            /* 2. Jika punya class .show-sidebar, luncurkan ke dalam */
            .sidebar.show-sidebar { transform: translateX(0); box-shadow: 5px 0 25px rgba(0,0,0,0.1); }
            
            /* 3. Main content jadi full width */
            .main-content { margin-left: 0; padding: 20px 15px; }
            
            /* 4. Tampilkan tombol Hamburger & Overlay */
            .mobile-toggle { display: flex; align-items: center; justify-content: center; }
            .sidebar-overlay.show-overlay { display: block; opacity: 1; }

            /* 5. Penyesuaian Topbar di HP */
            .topbar { padding-bottom: 20px; gap: 10px; }
            .page-title { display: flex; align-items: center; gap: 12px; }
            .page-title h4 { font-size: 1.25rem; }
            .user-profile { padding: 6px; }
            .avatar-circle { width: 35px; height: 35px; font-size: 1rem; }
        }
    </style>
</head>

<body>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <aside class="sidebar" id="mainSidebar">
        <div class="brand-logo d-flex justify-content-between align-items-center">
            <img src="/assets/img/logo-jmi.png" alt="Logo JMI" style="max-height: 45px; width: auto; object-fit: contain;">
            <img src="/assets/img/onemed-logo.png" alt="Logo JMI" style="max-height: 45px; width: auto; object-fit: contain;">
            <button class="btn btn-sm btn-light d-lg-none border-0 text-muted" onclick="toggleSidebar()"><i class="fa-solid fa-xmark fs-5"></i></button>
        </div>

        <div class="menu-label">MENU</div>
        <ul class="nav flex-column mb-auto">
            <li class="nav-item">
                <a class="nav-link <?= (url_is('admin')) ? 'active' : '' ?>" href="/admin">
                    <i class="fa-solid fa-border-all"></i> Dashboard
                </a>
            </li>

            <?php if (session('role') == 'superadmin') : ?>
                <li class="nav-item">
                    <a class="nav-link <?= (url_is('admin/users*')) ? 'active' : '' ?>" href="/admin/users">
                        <i class="fa-solid fa-users"></i> Kelola User
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?= (url_is('admin/teknisi*')) ? 'active' : '' ?>" href="/admin/teknisi">
                        <i class="fa-solid fa-user-gear"></i> Data Teknisi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= (url_is('admin/departemen*')) ? 'active' : '' ?>" href="/admin/departemen">
                        <i class="fa-solid fa-building-user"></i> Kelola Divisi
                    </a>
                </li>
            <?php endif; ?>

            <?php 
                $ticketModel = new \App\Models\TicketModel();
                $isSuperAdmin = session('role') == 'superadmin';
                $lokasiAdmin = session('lokasi');

                $newCount = $isSuperAdmin ? $ticketModel->where('status', 'New')->countAllResults() : $ticketModel->where(['status' => 'New', 'lokasi' => $lokasiAdmin])->countAllResults();
                $progressCount = $isSuperAdmin ? $ticketModel->where('status', 'On Progress')->countAllResults() : $ticketModel->where(['status' => 'On Progress', 'lokasi' => $lokasiAdmin])->countAllResults();
                $holdCount = $isSuperAdmin ? $ticketModel->where('status', 'On Hold')->countAllResults() : $ticketModel->where(['status' => 'On Hold', 'lokasi' => $lokasiAdmin])->countAllResults();
                $resolvedCount = $isSuperAdmin ? $ticketModel->where('status', 'Resolved')->countAllResults() : $ticketModel->where(['status' => 'Resolved', 'lokasi' => $lokasiAdmin])->countAllResults();
            ?>

            <li class="nav-item mt-2">
                <a class="nav-link d-flex align-items-center justify-content-between <?= (url_is('admin/tickets*')) ? 'text-primary' : 'collapsed' ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTiket">
                    <div class="d-flex align-items-center">
                        <i class="fa-regular fa-bell"></i> 
                        <span>Notifikasi / Tiket</span>
                        <?php if($newCount > 0): ?>
                            <span class="badge bg-primary rounded-circle ms-2 shadow-sm" style="width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; font-size: 11px;">
                                <?= $newCount; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <i class="fa-solid fa-chevron-down fs-xs opacity-50" style="width: auto;"></i>
                </a>
                
                <div id="collapseTiket" class="collapse <?= (url_is('admin/tickets*')) ? 'show' : '' ?>">
                    <div class="d-flex flex-column pb-2">
                        <?php $status_aktif = isset($_GET['status']) ? $_GET['status'] : (url_is('admin/tickets') && !isset($_GET['status']) ? 'All' : ''); ?>
                        <a class="custom-submenu <?= ($status_aktif == 'All') ? 'active-submenu' : '' ?>" href="/admin/tickets"><i class="fa-solid fa-list icon-menu"></i> Semua Tiket</a>
                        <a class="custom-submenu <?= ($status_aktif == 'New') ? 'active-submenu' : '' ?>" href="/admin/tickets?status=New">
                            <div><i class="fa-solid fa-asterisk text-danger icon-menu"></i> New</div>
                            <?php if($newCount > 0): ?><span class="badge bg-danger rounded-pill ms-auto px-2 py-1" style="font-size: 0.65rem;"><?= $newCount; ?></span><?php endif; ?>
                        </a>
                        <a class="custom-submenu <?= ($status_aktif == 'On Progress') ? 'active-submenu' : '' ?>" href="/admin/tickets?status=On Progress">
                            <div><i class="fa-solid fa-gear text-warning icon-menu"></i> On Progress</div>
                            <?php if($progressCount > 0): ?><span class="badge bg-warning text-dark rounded-pill ms-auto px-2 py-1" style="font-size: 0.65rem;"><?= $progressCount; ?></span><?php endif; ?>
                        </a>
                        <a class="custom-submenu <?= ($status_aktif == 'On Hold') ? 'active-submenu' : '' ?>" href="/admin/tickets?status=On Hold">
                            <div><i class="fa-solid fa-hand text-secondary icon-menu"></i> On Hold</div>
                            <?php if($holdCount > 0): ?><span class="badge bg-secondary rounded-pill ms-auto px-2 py-1" style="font-size: 0.65rem;"><?= $holdCount; ?></span><?php endif; ?>
                        </a>
                        <a class="custom-submenu <?= ($status_aktif == 'Resolved') ? 'active-submenu' : '' ?>" href="/admin/tickets?status=Resolved">
                            <div><i class="fa-solid fa-user-clock text-info icon-menu"></i> Resolved</div>
                            <?php if($resolvedCount > 0): ?><span class="badge bg-info text-dark rounded-pill ms-auto px-2 py-1" style="font-size: 0.65rem;"><?= $resolvedCount; ?></span><?php endif; ?>
                        </a>
                        <a class="custom-submenu <?= ($status_aktif == 'Closed') ? 'active-submenu' : '' ?>" href="/admin/tickets?status=Closed">
                            <div><i class="fa-solid fa-check-double text-success icon-menu"></i> Closed</div>
                        </a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= (url_is('admin/reports*')) ? 'active' : '' ?>" href="/admin/reports">
                    <i class="fa-solid fa-file-invoice"></i> Laporan
                </a>
            </li>
        </ul>

        <div class="logout-wrapper">
            <button class="btn btn-logout" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <i class="fa-solid fa-right-from-bracket me-2"></i> Keluar Sistem
            </button>
        </div>
    </aside>

    <main class="main-content">
        <div class="topbar">
            <div class="page-title">
                <button class="mobile-toggle" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars fs-5"></i>
                </button>
                
                <?php 
                    $judulHalaman = $title ?? 'Dashboard';
                    if ($judulHalaman == 'Data Admin IT Pabrik') {
                        $judulHalaman = 'Data Admin';
                    }
                ?>
                <h4 class="mb-0 text-dark"><?= $judulHalaman; ?></h4>
            </div>
            
            <div class="user-profile">
                <div class="text-end d-none d-sm-block" style="line-height: 1.2;">
                    <span class="fw-bold d-block text-dark" style="font-size: 0.9rem;"><?= session('nama') ?? 'Administrator'; ?></span>
                    <span class="text-muted" style="font-size: 0.75rem;"><?= session('role') == 'superadmin' ? 'Super Administrator' : 'Admin IT Plant'; ?></span>
                </div>
                <div class="avatar-circle shadow-sm">
                    <?= strtoupper(substr(session('nama') ?? 'U', 0, 1)); ?>
                </div>
            </div>
        </div>

        <?= $this->renderSection('content'); ?>
    </main>

    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered px-3">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-body text-center p-5">
                    <i class="fa-solid fa-circle-question fa-4x text-danger mb-4 opacity-25"></i>
                    <h4 class="fw-bold mb-2">Konfirmasi Keluar</h4>
                    <p class="text-muted mb-4">Apakah Anda yakin ingin mengakhiri sesi pengerjaan ini?</p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-light px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                        <a href="/logout" class="btn btn-danger px-4 fw-bold">Ya, Keluar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('mainSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            // Toggle class 'show-sidebar' dan 'show-overlay'
            sidebar.classList.toggle('show-sidebar');
            overlay.classList.toggle('show-overlay');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>