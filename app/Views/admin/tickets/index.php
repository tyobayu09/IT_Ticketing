<?= $this->extend('layout/admin_template'); ?>
<?= $this->section('content'); ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" style="background-color: #ffe2e5; color: #f64e60;">
        <i class="fa-solid fa-triangle-exclamation me-2 fs-5"></i><?= session()->getFlashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-header bg-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center rounded-top-4 border-bottom gap-3">
        <h5 class="mb-0 fw-bold text-dark">
            <i class="fa-solid fa-list-check text-primary me-2"></i> Daftar Tiket Masuk
            <?php if(session('role') == 'superadmin'): ?>
                <span class="text-muted fw-normal" style="font-size: 0.9rem;">(Semua Plant)</span>
            <?php endif; ?>
        </h5>
        
        <form action="<?= site_url('admin/tickets'); ?>" method="get" class="d-flex align-items-center gap-2">
            
            <?php if(isset($_GET['status'])): ?>
                <input type="hidden" name="status" value="<?= esc($_GET['status']); ?>">
            <?php endif; ?>
            
            <div class="input-group shadow-sm rounded-pill overflow-hidden" style="width: 280px; border: 1.5px solid #e4e6ef;">
                <span class="input-group-text bg-white border-0 text-muted ps-3 pe-2"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" class="form-control border-0 shadow-none bg-white ps-0 fw-medium" name="search" placeholder="Cari ID Tiket..." value="<?= esc($search ?? ''); ?>">
                <button class="btn btn-primary fw-bold px-3 border-0" type="submit" style="border-radius: 0 50rem 50rem 0;">Cari</button>
            </div>
            
            <?php if(!empty($search)): ?>
                <a href="<?= site_url('admin/tickets' . (isset($_GET['status']) ? '?status=' . $_GET['status'] : '')); ?>" class="btn btn-light rounded-circle shadow-sm border text-danger d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;" title="Hapus Pencarian">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            <?php endif; ?>
        </form>
    </div>
    
    <div class="card-body p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle table-modern mb-0" style="border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr>
                        <th class="ps-4" style="font-size: 0.75rem; color: #a1a5b7; border-bottom: 1px dashed #e4e6ef; padding-bottom: 15px;">ID TIKET</th>
                        <th style="font-size: 0.75rem; color: #a1a5b7; border-bottom: 1px dashed #e4e6ef; padding-bottom: 15px;">PELAPOR</th>
                        <th style="font-size: 0.75rem; color: #a1a5b7; border-bottom: 1px dashed #e4e6ef; padding-bottom: 15px;">DEPARTEMEN</th>
                        <th style="font-size: 0.75rem; color: #a1a5b7; border-bottom: 1px dashed #e4e6ef; padding-bottom: 15px;">KENDALA / MASALAH</th>
                        <th class="text-center" style="font-size: 0.75rem; color: #a1a5b7; border-bottom: 1px dashed #e4e6ef; padding-bottom: 15px;">STATUS</th>
                        <th class="text-center pe-4" style="font-size: 0.75rem; color: #a1a5b7; border-bottom: 1px dashed #e4e6ef; padding-bottom: 15px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($tickets)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted border-bottom-0">
                                <i class="fa-solid fa-magnifying-glass fa-3x mb-3 opacity-25"></i>
                                <br><span class="fw-semibold">Tidak ada data tiket yang ditemukan.</span>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($tickets as $t): ?>
                        <tr>
                            <td class="ps-4 border-bottom-dashed">
                                <span class="fw-bolder text-primary"><?= esc($t['kode_tiket']); ?></span>
                            </td>
                            
                            <td class="border-bottom-dashed">
                                <span class="fw-bold text-dark d-block"><?= strtoupper(esc($t['nama_pelapor'])); ?></span>
                            </td>
                            
                            <td class="border-bottom-dashed">
                                <span class="text-muted fw-medium" style="font-size: 0.85rem;"><?= strtoupper(esc($t['departemen'])); ?></span>
                            </td>
                            
                            <td class="border-bottom-dashed" style="max-width: 250px;">
                                <div class="text-dark fw-medium" style="font-size: 0.85rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" title="<?= esc($t['deskripsi']); ?>">
                                    <?= esc($t['deskripsi']); ?>
                                </div>
                            </td>
                            
                            <td class="text-center border-bottom-dashed">
                                <?php 
                                    $bgStatus = 'bg-light text-dark';
                                    $icon = 'fa-circle-dot';
                                    if($t['status'] == 'New') { $bgStatus = 'badge-soft-danger'; $icon = 'fa-asterisk'; }
                                    elseif($t['status'] == 'On Progress') { $bgStatus = 'badge-soft-warning text-dark'; $icon = 'fa-gear fa-spin'; }
                                    elseif($t['status'] == 'On Hold') { $bgStatus = 'badge-soft-secondary'; $icon = 'fa-hand'; }
                                    elseif($t['status'] == 'Resolved') { $bgStatus = 'badge-soft-info text-dark'; $icon = 'fa-user-clock'; }
                                    elseif($t['status'] == 'Closed') { $bgStatus = 'badge-soft-success'; $icon = 'fa-check-double'; }
                                ?>
                                <span class="badge <?= $bgStatus ?> px-3 py-2 rounded-pill fw-bold" style="font-size: 0.75rem;">
                                    <i class="fa-solid <?= $icon ?> me-1 opacity-75"></i> <?= esc($t['status']); ?>
                                </span>
                            </td>
                            
                            <td class="text-center pe-4 border-bottom-dashed">
                                <a href="<?= site_url('admin/tickets/show/' . $t['id']); ?>" class="btn btn-sm btn-light border text-primary shadow-sm btn-hover-scale fw-bold px-3 rounded-pill">
                                    <i class="fa-regular fa-eye me-1"></i> Lihat
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Styling Kustom Elegan SaaS */
    .btn-hover-scale { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .btn-hover-scale:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
    .border-bottom-dashed { border-bottom: 1px dashed #e4e6ef; padding: 15px 10px; }
    
    /* Input Search Group Focus */
    .input-group:focus-within { border-color: #0d6efd !important; box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1) !important; }
    .form-control:focus { outline: none; box-shadow: none; }

    /* Soft Badges */
    .badge-soft-danger { background-color: #ffe2e5; color: #f64e60; border: 1px solid #ffe2e5; }
    .badge-soft-info { background-color: #e1f0ff; color: #3699ff; border: 1px solid #e1f0ff; }
    .badge-soft-success { background-color: #c9f7f5; color: #1bc5bd; border: 1px solid #c9f7f5; }
    .badge-soft-warning { background-color: #fff4de; color: #ffa800; border: 1px solid #fff4de; }
    .badge-soft-secondary { background-color: #f3f6f9; color: #7e8299; border: 1px solid #e4e6ef; }
</style>

<?= $this->endSection(); ?>