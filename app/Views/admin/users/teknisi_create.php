<?= $this->extend('layout/admin_template'); ?>
<?= $this->section('content'); ?>

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-6">
        
        <?php if(session()->getFlashdata('pesan_error')): ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" style="background-color: #ffe2e5; color: #f64e60;">
                <i class="fa-solid fa-triangle-exclamation me-2"></i><?= session()->getFlashdata('pesan_error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0 rounded-4 mt-2">
            <div class="card-body p-4 p-md-5">
                
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 48px; height: 48px;">
                        <i class="fa-solid fa-user-plus fs-5"></i>
                    </div>
                    <h4 class="fw-bold mb-0 text-dark">Form Tambah Teknisi Baru</h4>
                </div>
                <p class="text-muted mb-4 pb-3 border-bottom" style="font-size: 0.9rem;">Daftarkan nama staf teknisi (tanpa akses login) untuk penugasan tiket.</p>

                <form action="/admin/teknisi/store" method="post">
                    <?= csrf_field(); ?>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small mb-2">Lokasi Penugasan Plant <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg fs-6 bg-light-focus" name="lokasi" required>
                            <option value="">-- Pilih Lokasi --</option>
                            <option value="Mojoagung">Mojoagung</option>
                            <option value="Krian">Krian</option>
                            <option value="Batang">Batang</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small mb-2">Nama Asli Teknisi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg fs-6 bg-light-focus" name="nama" placeholder="Contoh: Budi Santoso" required autocomplete="off">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small mb-2">Divisi / Departemen</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                            <input type="text" class="form-control form-control-lg fs-6 bg-light border-start-0 fw-bold text-primary" name="departemen" value="IT SUPPORT" readonly>
                        </div>
                        <small class="text-muted mt-2 d-block" style="font-size: 0.75rem;">Departemen teknisi dikunci secara otomatis oleh sistem.</small>
                    </div>

                    <hr class="my-4 border-light">

                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="/admin/teknisi" class="btn btn-light border fw-bold px-4 py-2 rounded-pill btn-hover-scale">Batal</a>
                        <button type="submit" class="btn fw-bold px-4 py-2 rounded-pill btn-hover-scale shadow-sm" style="background-color: #6f42c1; color: white;">
                            <i class="fa-solid fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<style>
    /* Styling Kustom Elegan */
    .bg-light-focus { background-color: #f8fafc; border: 1.5px solid #e2e8f0; transition: all 0.3s ease; }
    .bg-light-focus:focus { background-color: #ffffff; border-color: #6f42c1; box-shadow: 0 0 0 4px rgba(111, 66, 193, 0.1); }
    .input-group-text { border: 1.5px solid #e2e8f0; }
    .form-control[readonly] { opacity: 0.8; cursor: not-allowed; }
    .btn-hover-scale { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .btn-hover-scale:hover { transform: translateY(-2px); }
</style>

<?= $this->endSection(); ?>