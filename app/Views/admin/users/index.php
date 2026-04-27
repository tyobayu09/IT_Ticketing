<?= $this->extend('layout/admin_template'); ?>
<?= $this->section('content'); ?>

<?php if(session()->getFlashdata('pesan')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" style="background-color: #c9f7f5; color: #1bc5bd;">
        <i class="fa-solid fa-circle-check me-2"></i><?= session()->getFlashdata('pesan'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center rounded-top-4 border-bottom">
        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-users-gear text-primary me-2"></i> Data Akun Pengguna</h5>
        
        <a href="<?= site_url('admin/users/create'); ?>" class="btn btn-primary btn-sm fw-bold shadow-sm rounded-pill px-4 py-2 btn-hover-scale">
            <i class="fa-solid fa-plus me-1"></i> Tambah User
        </a>
    </div>
    
    <div class="card-body p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle table-modern mb-0" style="border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr>
                        <th class="ps-4 text-center" width="5%" style="font-size: 0.75rem; color: #a1a5b7; border-bottom: 1px dashed #e4e6ef; padding-bottom: 15px;">NO</th>
                        <th style="font-size: 0.75rem; color: #a1a5b7; border-bottom: 1px dashed #e4e6ef; padding-bottom: 15px;">NAMA LENGKAP</th>
                        <th style="font-size: 0.75rem; color: #a1a5b7; border-bottom: 1px dashed #e4e6ef; padding-bottom: 15px;">EMAIL / KONTAK</th>
                        <th style="font-size: 0.75rem; color: #a1a5b7; border-bottom: 1px dashed #e4e6ef; padding-bottom: 15px;">DEPARTEMEN</th>
                        <th class="text-center" style="font-size: 0.75rem; color: #a1a5b7; border-bottom: 1px dashed #e4e6ef; padding-bottom: 15px;">LOKASI (PLANT)</th>
                        <th class="text-center" style="font-size: 0.75rem; color: #a1a5b7; border-bottom: 1px dashed #e4e6ef; padding-bottom: 15px;">ROLE</th>
                        <th class="text-center pe-4" width="12%" style="font-size: 0.75rem; color: #a1a5b7; border-bottom: 1px dashed #e4e6ef; padding-bottom: 15px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($users)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted border-bottom-0">
                                <i class="fa-solid fa-user-xmark fa-3x mb-3 opacity-25"></i>
                                <br><span class="fw-semibold">Belum ada data admin terdaftar.</span>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $i = 1; foreach($users as $u): ?>
                        <tr>
                            <td class="ps-4 text-center fw-bold text-muted border-bottom-dashed"><?= $i++; ?></td>
                            <td class="border-bottom-dashed"><span class="fw-bold text-dark d-block"><?= esc($u['nama']); ?></span></td>
                            <td class="border-bottom-dashed"><span class="text-muted fw-medium" style="font-size: 0.85rem;"><i class="fa-regular fa-envelope me-1 opacity-50"></i> <?= esc($u['email'] ?? '-'); ?></span></td>
                            <td class="border-bottom-dashed"><span class="text-muted fw-medium" style="font-size: 0.85rem;"><i class="fa-solid fa-briefcase me-1 opacity-50"></i> <?= esc($u['departemen'] ?? 'IT Support'); ?></span></td>
                            
                            <td class="text-center border-bottom-dashed">
                                <?php 
                                    $bgLoc = 'bg-light text-dark';
                                    if(strtolower($u['lokasi']) == 'mojoagung') $bgLoc = 'badge-soft-info';
                                    elseif(strtolower($u['lokasi']) == 'krian') $bgLoc = 'badge-soft-orange';
                                    elseif(strtolower($u['lokasi']) == 'batang') $bgLoc = 'badge-soft-success';
                                    elseif(strtolower($u['lokasi']) == 'pusat') $bgLoc = 'badge-soft-danger';
                                ?>
                                <span class="badge <?= $bgLoc ?> px-3 py-2 rounded-pill fw-bold"><i class="fa-solid fa-location-dot me-1 opacity-75"></i> <?= strtoupper($u['lokasi']); ?></span>
                            </td>

                            <td class="text-center border-bottom-dashed">
                                <?php 
                                    $bgRole = 'badge-soft-secondary'; $roleText = 'Admin';
                                    if($u['role'] == 'superadmin') { $bgRole = 'badge-soft-danger'; $roleText = 'Super Admin'; }
                                    elseif($u['role'] == 'admin') { $bgRole = 'badge-soft-primary'; $roleText = 'Admin Plant'; }
                                ?>
                                <span class="badge <?= $bgRole ?> px-3 py-2 rounded-pill fw-bold"><?= $roleText; ?></span>
                            </td>
                            
                            <td class="text-center pe-4 border-bottom-dashed">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="<?= site_url('admin/users/edit/' . $u['id']); ?>" class="btn btn-sm btn-light border text-warning shadow-sm btn-hover-scale" title="Edit Data">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    
                                    <button type="button" class="btn btn-sm btn-light border text-danger shadow-sm btn-hover-scale" title="Hapus Data" onclick="confirmDelete(<?= $u['id']; ?>, '<?= esc($u['nama']); ?>')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
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
    .btn-hover-scale { transition: transform 0.2s ease; }
    .btn-hover-scale:hover { transform: translateY(-2px); }
    .border-bottom-dashed { border-bottom: 1px dashed #e4e6ef; padding: 15px 10px; }
    .badge-soft-danger { background-color: #ffe2e5; color: #f64e60; border: 1px solid #ffe2e5; }
    .badge-soft-info { background-color: #e1f0ff; color: #3699ff; border: 1px solid #e1f0ff; }
    .badge-soft-success { background-color: #c9f7f5; color: #1bc5bd; border: 1px solid #c9f7f5; }
    .badge-soft-orange { background-color: #ffe8cc; color: #fd7e14; border: 1px solid #ffe8cc; }
    .badge-soft-primary { background-color: #e1e9ff; color: #0d6efd; border: 1px solid #e1e9ff; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(idUser, itemName) {
        Swal.fire({
            title: 'Hapus Admin?',
            html: `Anda yakin ingin menghapus akun <b>${itemName}</b>?<br><small class="text-danger">Tindakan ini tidak dapat dibatalkan!</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#858796',
            confirmButtonText: '<i class="fa-solid fa-trash me-1"></i> Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-4 shadow-lg border-0' }
        }).then((result) => {
            if (result.isConfirmed) {
                // REDIRECT MENGGUNAKAN GET SESUAI ROUTE
                window.location.href = "<?= site_url('admin/users/delete/'); ?>" + idUser;
            }
        });
    }
</script>

<?= $this->endSection(); ?>