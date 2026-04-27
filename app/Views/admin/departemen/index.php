<?= $this->extend('layout/admin_template'); ?>
<?= $this->section('content'); ?>

<?php if(session()->getFlashdata('pesan')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" style="background-color: #c9f7f5; color: #1bc5bd;">
        <div class="d-flex align-items-center">
            <i class="fa-solid fa-circle-check me-2 fs-5"></i>
            <div><?= session()->getFlashdata('pesan'); ?></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('pesan_error')): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" style="background-color: #ffe2e5; color: #f64e60;">
        <div class="d-flex align-items-center">
            <i class="fa-solid fa-triangle-exclamation me-2 fs-5"></i>
            <div><?= session()->getFlashdata('pesan_error'); ?></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-header bg-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center rounded-top-4 border-bottom gap-3">
        <h5 class="mb-0 fw-bold text-dark">
            <i class="fa-solid fa-building-user text-primary me-2"></i> Data Divisi & Departemen
        </h5>
        
        <div class="d-flex align-items-center gap-2">
            <form action="<?= site_url('admin/departemen'); ?>" method="get" class="d-flex align-items-center m-0">
                <div class="input-group shadow-sm rounded-pill overflow-hidden" style="width: 250px; border: 1.5px solid #e4e6ef;">
                    <span class="input-group-text bg-white border-0 text-muted ps-3 pe-2"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" class="form-control border-0 shadow-none bg-white ps-0 fw-medium" name="search" placeholder="Cari divisi / lokasi..." value="<?= esc($search ?? ''); ?>">
                    <button class="btn btn-primary fw-bold px-3 border-0" type="submit" style="border-radius: 0 50rem 50rem 0;">Cari</button>
                </div>
                
                <?php if(!empty($search)): ?>
                    <a href="<?= site_url('admin/departemen'); ?>" class="btn btn-light rounded-circle shadow-sm border text-danger d-flex align-items-center justify-content-center ms-2" style="width: 38px; height: 38px;" title="Reset Pencarian">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                <?php endif; ?>
            </form>

            <button type="button" class="btn btn-primary btn-sm fw-bold shadow-sm rounded-pill px-4 py-2 ms-2 btn-hover-scale" data-bs-toggle="modal" data-bs-target="#tambahDivisiModal">
                <i class="fa-solid fa-plus me-1"></i> Tambah Divisi
            </button>
        </div>
    </div>
    
    <div class="card-body p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle table-modern mb-0" style="border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr>
                        <th class="ps-4 text-center" width="8%" style="font-size: 0.75rem; color: #a1a5b7; border-bottom: 1px dashed #e4e6ef; padding-bottom: 15px;">NO</th>
                        <th style="font-size: 0.75rem; color: #a1a5b7; border-bottom: 1px dashed #e4e6ef; padding-bottom: 15px;">NAMA DIVISI / DEPARTEMEN</th>
                        <th class="text-center" style="font-size: 0.75rem; color: #a1a5b7; border-bottom: 1px dashed #e4e6ef; padding-bottom: 15px;">LOKASI PLANT</th>
                        <th class="text-center pe-4" width="15%" style="font-size: 0.75rem; color: #a1a5b7; border-bottom: 1px dashed #e4e6ef; padding-bottom: 15px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($departemen)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted border-bottom-0">
                                <i class="fa-solid fa-folder-open fa-3x mb-3 opacity-25"></i>
                                <br><span class="fw-semibold">Tidak ada data divisi yang ditemukan.</span>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $i = 1; foreach($departemen as $d): ?>
                        <tr>
                            <td class="ps-4 text-center fw-bold text-muted border-bottom-dashed"><?= $i++; ?></td>
                            
                            <td class="border-bottom-dashed">
                                <span class="fw-bold text-dark d-block"><?= strtoupper(esc($d['nama_departemen'])); ?></span>
                            </td>
                            
                            <td class="text-center border-bottom-dashed">
                                <?php 
                                    $bg = 'bg-light text-dark';
                                    if(strtolower($d['lokasi_plant']) == 'mojoagung') $bg = 'badge-soft-info';
                                    elseif(strtolower($d['lokasi_plant']) == 'krian') $bg = 'badge-soft-orange';
                                    elseif(strtolower($d['lokasi_plant']) == 'batang') $bg = 'badge-soft-success';
                                    elseif(strtolower($d['lokasi_plant']) == 'pusat') $bg = 'badge-soft-danger';
                                ?>
                                <span class="badge <?= $bg ?> px-3 py-2 rounded-pill fw-bold">
                                    <i class="fa-solid fa-location-dot me-1 opacity-75"></i> <?= strtoupper(esc($d['lokasi_plant'])); ?>
                                </span>
                            </td>
                            
                            <td class="text-center pe-4 border-bottom-dashed">
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-sm btn-light border text-warning shadow-sm btn-hover-scale" data-bs-toggle="modal" data-bs-target="#editDivisiModal<?= $d['id']; ?>" title="Edit Data">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    
                                    <button type="button" class="btn btn-sm btn-light border text-danger shadow-sm btn-hover-scale" title="Hapus Data" onclick="hapusDivisi(<?= $d['id']; ?>, '<?= esc($d['nama_departemen']); ?>')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="editDivisiModal<?= $d['id']; ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <div class="modal-header border-bottom-0 pt-4 px-4">
                                        <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-pen-to-square text-warning me-2"></i>Edit Divisi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="<?= site_url('admin/departemen/update/' . $d['id']); ?>" method="post" onsubmit="konfirmasiEdit(event, this, '<?= esc($d['nama_departemen']); ?>')">
                                        <?= csrf_field(); ?>
                                        <div class="modal-body px-4 pb-4">
                                            <div class="mb-3 text-start">
                                                <label class="form-label fw-bold text-muted small mb-1">Nama Divisi / Departemen <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control bg-light-focus" name="nama_departemen" value="<?= esc($d['nama_departemen']); ?>" required autocomplete="off">
                                            </div>
                                            <div class="mb-2 text-start">
                                                <label class="form-label fw-bold text-muted small mb-1">Lokasi Plant <span class="text-danger">*</span></label>
                                                <select class="form-select bg-light-focus" name="lokasi_plant" required>
                                                    <option value="Mojoagung" <?= strtolower($d['lokasi_plant']) == 'mojoagung' ? 'selected' : '' ?>>Plant Mojoagung</option>
                                                    <option value="Krian" <?= strtolower($d['lokasi_plant']) == 'krian' ? 'selected' : '' ?>>Plant Krian</option>
                                                    <option value="Batang" <?= strtolower($d['lokasi_plant']) == 'batang' ? 'selected' : '' ?>>Plant Batang</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0 px-4 pb-4">
                                            <button type="button" class="btn btn-light fw-bold px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning text-dark fw-bold px-4 rounded-pill shadow-sm">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahDivisiModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-folder-plus text-primary me-2"></i>Tambah Divisi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= site_url('admin/departemen/store'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body px-4 pb-4">
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold text-muted small mb-1">Nama Divisi / Departemen <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-light-focus" name="nama_departemen" placeholder="Contoh: HRD, Keuangan, dll" required autocomplete="off">
                    </div>
                    <div class="mb-2 text-start">
                        <label class="form-label fw-bold text-muted small mb-1">Lokasi Plant <span class="text-danger">*</span></label>
                        <select class="form-select bg-light-focus" name="lokasi_plant" required>
                            <option value="">-- Pilih Lokasi --</option>
                            <option value="Mojoagung">Plant Mojoagung</option>
                            <option value="Krian">Plant Krian</option>
                            <option value="Batang">Plant Batang</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0 px-4 pb-4">
                    <button type="button" class="btn btn-light fw-bold px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4 rounded-pill shadow-sm">Simpan Divisi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .btn-hover-scale { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .btn-hover-scale:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
    .border-bottom-dashed { border-bottom: 1px dashed #e4e6ef; padding: 15px 10px; }
    
    .input-group:focus-within { border-color: #0d6efd !important; box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1) !important; }
    .form-control:focus { outline: none; box-shadow: none; }

    .badge-soft-danger { background-color: #ffe2e5; color: #f64e60; border: 1px solid #ffe2e5; }
    .badge-soft-info { background-color: #e1f0ff; color: #3699ff; border: 1px solid #e1f0ff; }
    .badge-soft-success { background-color: #c9f7f5; color: #1bc5bd; border: 1px solid #c9f7f5; }
    .badge-soft-orange { background-color: #ffe8cc; color: #fd7e14; border: 1px solid #ffe8cc; }

    .bg-light-focus { background-color: #f8fafc; border: 1.5px solid #e2e8f0; transition: all 0.3s ease; }
    .bg-light-focus:focus { background-color: #ffffff; border-color: #0d6efd; box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1); outline: none;}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // --- FUNGSI VALIDASI HAPUS DATA ---
    function hapusDivisi(id, nama) {
        Swal.fire({
            title: 'Hapus Divisi?',
            html: `Anda yakin ingin menghapus divisi <b>${nama}</b>?<br><small class="text-danger">Tindakan ini tidak dapat dibatalkan!</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#858796',
            confirmButtonText: '<i class="fa-solid fa-trash me-1"></i> Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-4 shadow-lg border-0',
                confirmButton: 'rounded-pill px-4',
                cancelButton: 'rounded-pill px-4'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Form Virtual POST untuk mencegah Error 404
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?= site_url('admin/departemen/delete/'); ?>' + id;
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '<?= csrf_token() ?>';
                csrfInput.value = '<?= csrf_hash() ?>';
                
                form.appendChild(csrfInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // --- FUNGSI VALIDASI UPDATE / EDIT DATA ---
    function konfirmasiEdit(event, formElement, nama) {
        // 1. Mencegah form untuk langsung loading/tersubmit
        event.preventDefault(); 
        
        // 2. Munculkan Pop-up Moderen warna Kuning Warning
        Swal.fire({
            title: 'Simpan Perubahan?',
            html: `Apakah Anda yakin ingin memperbarui data divisi <b>${nama}</b>?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ffc107', 
            cancelButtonColor: '#858796',
            confirmButtonText: '<i class="fa-solid fa-check me-1"></i> Ya, Simpan!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-4 shadow-lg border-0',
                confirmButton: 'rounded-pill px-4 fw-bold text-dark shadow-sm', // Text dark agar terbaca di kuning
                cancelButton: 'rounded-pill px-4 fw-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // 3. Lanjutkan submit form secara otomatis jika diklik "Ya"
                formElement.submit();
            }
        });
    }
</script>

<?= $this->endSection(); ?>