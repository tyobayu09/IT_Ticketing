<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Tiket IT - Sistem JMI</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Pengaturan Dasar */
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #f4f7fe 0%, #e1eafc 100%); min-height: 100vh; color: #2d3748; }

        /* Navigasi Glassmorphism */
        .navbar-glass { background: rgba(255, 255, 255, 0.75); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); padding: 15px 0; position: sticky; top: 0; z-index: 1000; }
        .form-container { max-width: 750px; margin: 40px auto; padding: 0 15px; }
        
        /* Desain Kartu Formulir Premium */
        .card-custom { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 1); border-radius: 24px; box-shadow: 0 20px 50px rgba(26, 86, 219, 0.08); padding: 40px; }

        /* Styling Input Modern */
        .form-control { border-radius: 12px; padding: 14px 18px; border: 1.5px solid #e2e8f0; background-color: #f8fafc; font-size: 1rem; color: #1a202c; transition: all 0.3s ease; }
        .form-control::placeholder { color: #a0aec0; font-weight: 400; }
        .form-control:focus { border-color: #1a56db; box-shadow: 0 0 0 4px rgba(26, 86, 219, 0.1); background-color: #ffffff; outline: none; }

        /* Tombol Utama */
        .btn-submit { background-color: #1a56db; color: white; font-weight: 700; padding: 14px 28px; border-radius: 12px; font-size: 1rem; transition: all 0.3s ease; border: none; white-space: nowrap; }
        .btn-submit:hover { background-color: #1545b0; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(26, 86, 219, 0.2); color: white; }
        
        /* Tombol Interaktif Tambahan */
        .btn-hover-scale { transition: all 0.3s ease; }
        .btn-hover-scale:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08); }

        /* Animasi Muncul (Fade In Up) */
        .fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; transform: translateY(20px); }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }

        /* CSS UNTUK TRACKER ALA SHOPEE */
        .stepper-wrapper { display: flex; justify-content: space-between; margin-bottom: 35px; position: relative; }
        .stepper-item { position: relative; display: flex; flex-direction: column; align-items: center; flex: 1; z-index: 1; transition: all 0.3s; }
        .stepper-item::before { position: absolute; content: ""; border-bottom: 4px solid #e2e8f0; width: 100%; top: 22px; left: -50%; z-index: -1; transition: all 0.4s; }
        .stepper-item:first-child::before { content: none; }
        .stepper-item.completed::before { border-bottom-color: #10b981; } 
        .step-counter { width: 48px; height: 48px; background-color: #f1f5f9; color: #94a3b8; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 20px; margin-bottom: 10px; border: 4px solid white; transition: all 0.4s; }
        .stepper-item.completed .step-counter { background-color: #10b981; color: white; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2); }
        .step-name { font-size: 13px; font-weight: 600; color: #94a3b8; text-align: center; }
        .stepper-item.completed .step-name { color: #10b981; }
        
        .timeline-box { border-left: 3px solid #e2e8f0; padding-left: 20px; position: relative; margin-left: 10px; }
        .timeline-box::before { content: ''; position: absolute; left: -9px; top: 0; width: 15px; height: 15px; border-radius: 50%; background-color: #1a56db; box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.2);}
        
        /* Box Informasi Detail */
        .info-box { background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 15px; }
    </style>
</head>
<body>

    <div class="navbar-glass">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="/" class="text-decoration-none text-dark fw-bold d-flex align-items-center gap-2 btn-hover-scale">
                <i class="fa-solid fa-arrow-left bg-white rounded-circle p-2 shadow-sm border text-primary"></i> 
                <span class="ms-1">Kembali</span>
            </a>
            <span class="text-muted fw-bold small">Pusat Bantuan IT Perusahaan</span>
        </div>
    </div>

    <div class="form-container">
        
        <?php if(session()->getFlashdata('pesan_sukses')): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 text-center mb-4 p-3 fade-in-up" style="background-color: #d1fae5; color: #065f46;">
                <i class="fa-solid fa-circle-check fs-4 text-success mb-2 d-block"></i>
                <span class="fw-bold"><?= session()->getFlashdata('pesan_sukses'); ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="top: 10px;"></button>
            </div>
        <?php endif; ?>

        <div class="text-center mb-4 fade-in-up">
            <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3 shadow-sm" style="width: 70px; height: 70px;">
                <i class="fa-solid fa-magnifying-glass fa-2x"></i>
            </div>
            <h3 class="fw-bolder text-dark mb-1">Lacak Status Perbaikan</h3>
            <p class="text-muted">Masukkan Nomor Tiket Anda untuk melihat progress penanganan oleh Tim IT.</p>
        </div>

        <div class="card-custom mb-4 border border-primary border-opacity-10 p-4 fade-in-up delay-1">
            <form action="/tiket/lacak" method="get" class="d-flex gap-2">
                <input type="text" name="keyword" class="form-control text-uppercase fw-bold" placeholder="Contoh: KRN-001-2026" value="<?= esc($keyword ?? ''); ?>" required autocomplete="off">
                <button type="submit" class="btn btn-submit shadow-sm"><i class="fa-solid fa-search me-2"></i>Cari</button>
            </form>
        </div>

        <?php if(isset($keyword)): ?>
            <?php if(!empty($tiket)): ?>
                
                <div class="card-custom border border-success border-opacity-25 fade-in-up delay-2">
                    
                    <div class="stepper-wrapper mt-2 mb-5 pb-4 border-bottom">
                        <div class="stepper-item <?= in_array($tiket['status'], ['New', 'On Progress', 'On Hold', 'Resolved', 'Closed']) ? 'completed' : '' ?>">
                            <div class="step-counter"><i class="fa-solid fa-file-signature"></i></div>
                            <div class="step-name">Tiket Dibuat</div>
                        </div>
                        <div class="stepper-item <?= in_array($tiket['status'], ['On Progress', 'On Hold', 'Resolved', 'Closed']) ? 'completed' : '' ?>">
                            <div class="step-counter"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                            <div class="step-name">Diproses IT</div>
                        </div>
                        <div class="stepper-item <?= in_array($tiket['status'], ['Resolved', 'Closed']) ? 'completed' : '' ?>">
                            <div class="step-counter"><i class="fa-solid fa-user-check"></i></div>
                            <div class="step-name">Menunggu Validasi</div>
                        </div>
                        <div class="stepper-item <?= in_array($tiket['status'], ['Closed']) ? 'completed' : '' ?>">
                            <div class="step-counter"><i class="fa-solid fa-flag-checkered"></i></div>
                            <div class="step-name">Selesai</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                        <div>
                            <p class="text-muted small fw-semibold mb-1">Nomor Referensi Tiket</p>
                            <h3 class="fw-bolder text-primary mb-0" style="letter-spacing: 1px;"><?= $tiket['kode_tiket']; ?></h3>
                        </div>
                        <div class="text-end">
                            <p class="text-muted small fw-semibold mb-1">Status Internal</p>
                            <?php if($tiket['status'] == 'New'): ?>
                                <span class="badge bg-danger px-3 py-2 rounded-pill shadow-sm"><i class="fa-solid fa-asterisk me-1"></i> Baru Masuk</span>
                            <?php elseif($tiket['status'] == 'On Progress'): ?>
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm"><i class="fa-solid fa-gear fa-spin-pulse me-1"></i> Sedang Dikerjakan</span>
                            <?php elseif($tiket['status'] == 'On Hold'): ?>
                                <span class="badge bg-secondary px-3 py-2 rounded-pill shadow-sm"><i class="fa-solid fa-hand me-1"></i> Ditunda / Tunggu Part</span>
                            <?php elseif($tiket['status'] == 'Resolved'): ?>
                                <span class="badge bg-info text-dark px-3 py-2 rounded-pill shadow-sm"><i class="fa-solid fa-user-clock me-1"></i> Menunggu Konfirmasi Anda</span>
                            <?php elseif($tiket['status'] == 'Closed'): ?>
                                <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm" style="background-color: #10b981 !important;"><i class="fa-solid fa-check-double me-1"></i> Ditutup Selesai</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if($tiket['status'] == 'Resolved'): ?>
                        <div class="bg-warning bg-opacity-10 border border-warning rounded-4 p-4 mb-4 text-center shadow-sm">
                            <div class="d-inline-flex align-items-center justify-content-center bg-warning text-dark rounded-circle mb-3 shadow-sm" style="width: 60px; height: 60px;">
                                <i class="fa-solid fa-clipboard-question fs-3"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-2">Apakah perbaikan sudah selesai?</h4>
                            <p class="text-muted mb-4" style="font-size: 0.95rem;">Tim IT telah memperbaiki masalah ini. Silakan cek peralatan Anda, dan klik tombol di bawah ini untuk mengonfirmasi bahwa semuanya sudah normal kembali.</p>
                            
                            <form id="formKonfirmasiKlien" action="/tiket/konfirmasi/<?= $tiket['id']; ?>" method="post">
                                <?= csrf_field(); ?>
                                <button type="button" class="btn btn-success btn-lg fw-bold px-5 rounded-pill shadow-sm btn-hover-scale" style="background-color: #10b981; border:none;" data-bs-toggle="modal" data-bs-target="#clientConfirmModal">
                                    <i class="fa-solid fa-check-double me-2"></i> Ya, Perangkat Sudah Normal
                                </button>
                            </form>
                        </div>
                    <?php elseif($tiket['status'] == 'Closed'): ?>
                        <div class="bg-success bg-opacity-10 border border-success rounded-4 p-4 mb-4 text-center shadow-sm" style="background-color: #f0fdf4 !important; border-color: #bbf7d0 !important;">
                            <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle mb-3 shadow-sm" style="width: 60px; height: 60px; background-color: #10b981 !important;">
                                <i class="fa-solid fa-shield-check fs-3"></i>
                            </div>
                            <h5 class="fw-bolder mb-1" style="color: #065f46;">Tiket Telah Selesai & Ditutup</h5>
                            <p class="mb-0 small" style="color: #047857;">Terima kasih atas konfirmasi Anda. Semoga layanan IT kami memuaskan.</p>
                        </div>
                    <?php endif; ?>

                    <div class="row mb-4 g-3">
                        <div class="col-md-6">
                            <div class="info-box h-100">
                                <p class="text-muted small fw-semibold mb-1">Nama Pelapor</p>
                                <h6 class="fw-bold text-dark mb-0"><?= strtoupper($tiket['nama_pelapor']); ?></h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box h-100">
                                <p class="text-muted small fw-semibold mb-1">Tanggal Dilaporkan</p>
                                <h6 class="fw-bold text-dark mb-0"><?= date('d M Y, H:i', strtotime($tiket['created_at'])); ?></h6>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-box">
                                <p class="text-muted small fw-semibold mb-2">Deskripsi Kendala</p>
                                <p class="text-dark mb-0 lh-base"><?= nl2br(esc($tiket['deskripsi'])); ?></p>
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark mb-3 mt-2"><i class="fa-solid fa-user-doctor text-primary me-2"></i> Update dari Tim IT</h6>
                    <div class="timeline-box">
                        <h6 class="fw-bold mb-1 text-dark"><?= $tiket['nama_teknisi'] ? 'Ditangani oleh: ' . strtoupper($tiket['nama_teknisi']) : 'Belum ada teknisi yang ditugaskan'; ?></h6>
                        <p class="text-muted small mb-3">
                            <?php if($tiket['waktu_mulai']): ?>Mulai dilakukan pengecekan pada: <?= date('d M Y, H:i', strtotime($tiket['waktu_mulai'])); ?><?php else: ?>Menunggu antrean pengecekan tim IT.<?php endif; ?>
                        </p>
                        
                        <?php if(!empty($tiket['catatan_admin'])): ?>
                            <div class="alert border-0 p-3 rounded-3 mt-2 shadow-sm" style="background-color: #eff6ff; color: #1e3a8a; border-left: 4px solid #3b82f6 !important;">
                                <strong><i class="fa-solid fa-comment-dots me-1"></i> Catatan Teknisi:</strong><br><span class="mt-1 d-block"><?= nl2br(esc($tiket['catatan_admin'])); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if($tiket['status'] == 'New'): ?>
                        <div class="alert border-0 p-4 rounded-4 mt-5 shadow-sm" style="background-color: #f8fafc; border: 1px solid #e2e8f0 !important; border-left: 5px solid #1a56db !important;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center shadow-sm" style="width: 55px; height: 55px; flex-shrink: 0;">
                                    <i class="fa-solid fa-users-gear fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">Informasi Antrean Tim IT</h6>
                                    <?php if(isset($antrean) && $antrean > 0): ?>
                                        <p class="mb-0 small text-muted" style="font-size: 0.95rem;">Saat ini Tim IT <b>Plant <?= $tiket['lokasi']; ?></b> sedang sibuk menangani <b class="text-danger"><?= $antrean; ?> antrean tiket lainnya</b>. <br>Mohon kesediaannya menunggu sejenak, tiket Anda akan segera diproses setelah giliran sebelumnya selesai.</p>
                                    <?php else: ?>
                                        <p class="mb-0 small text-muted" style="font-size: 0.95rem;">Saat ini antrean di <b>Plant <?= $tiket['lokasi']; ?></b> sedang kosong. Tim IT kami akan merespons tiket Anda sebentar lagi!</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            <?php else: ?>
                <div class="alert alert-danger border-0 shadow-sm rounded-4 p-5 text-center fade-in-up delay-2" style="background-color: #fef2f2; color: #991b1b;">
                    <i class="fa-solid fa-triangle-exclamation fa-3x text-danger mb-3 opacity-75"></i>
                    <h5 class="fw-bold">Tiket Tidak Ditemukan!</h5>
                    <p class="mb-0">Pastikan nomor referensi tiket yang Anda masukkan sudah benar (Contoh: KRN-001-2026).</p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="modal fade" id="clientConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center pb-5 px-4">
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle shadow-sm" style="width: 80px; height: 80px; color: #10b981 !important; background-color: #d1fae5 !important;">
                            <i class="fa-solid fa-check-double" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">Konfirmasi Penyelesaian</h4>
                    <p class="text-muted mb-4" style="font-size: 0.95rem;">
                        Apakah Anda yakin masalah sudah benar-benar selesai? <br>
                        Setelah dikonfirmasi, tiket ini akan <b class="text-danger">ditutup secara permanen</b>.
                    </p>
                    
                    <div class="d-flex justify-content-center gap-3 mt-2">
                        <button type="button" class="btn btn-light border px-4 py-2 fw-bold text-muted shadow-sm rounded-pill btn-hover-scale" data-bs-dismiss="modal">Batal</button>
                        <button type="button" onclick="submitKonfirmasiKlien()" class="btn btn-success px-4 py-2 fw-bold shadow-sm rounded-pill btn-hover-scale" style="background-color: #10b981; border:none;">Ya, Tutup Tiket</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function submitKonfirmasiKlien() {
            document.getElementById('formKonfirmasiKlien').submit();
        }
    </script>
</body>
</html>