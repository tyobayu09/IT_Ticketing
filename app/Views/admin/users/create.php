<?= $this->extend('layout/admin_template'); ?>
<?= $this->section('content'); ?>

<div class="card shadow-sm" style="max-width: 800px; margin: auto;">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0"><i class="fa-solid fa-user-plus text-primary me-2"></i> Form Tambah Tim IT Plant</h5>
    </div>
    <div class="card-body p-4">

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <form action="/admin/users/store" method="post">
            <?= csrf_field(); ?>
            <div class="row">
                
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted fw-bold small">Lokasi Penugasan (Plant)</label>
                    <select class="form-select bg-light border-primary" name="lokasi" id="lokasiPabrik" required onchange="generateNamaOtomatis()">
                        <option value="" disabled selected>-- Pilih Lokasi Plant --</option>
                        <option value="Krian">Plant Krian</option>
                        <option value="Mojoagung">Plant Mojoagung</option>
                        <option value="Batang">Plant Batang</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted fw-bold small">Nama Akun</label>
                    <input type="text" class="form-control bg-light" name="nama" id="namaAkun" placeholder="Pilih lokasi plant terlebih dahulu..." required readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted fw-bold small">Email Login</label>
                    <input type="email" class="form-control bg-light" name="email" placeholder="it.krian@jmi.com" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted fw-bold small">Hak Akses (Role)</label>
                    <select class="form-select bg-light" name="role" required>
                        <option value="admin" selected>IT Support</option>
                    </select>
                </div>

                <div class="col-md-12 mb-4">
                    <label class="form-label text-muted fw-bold small">Password Login</label>
                    <input type="password" class="form-control bg-light" name="password" placeholder="Buat password untuk tim IT..." required>
                </div>
            </div>
            
            <input type="hidden" name="departemen" value="IT Support">

            <hr class="text-muted">
            <div class="d-flex justify-content-end gap-2">
                <a href="/admin/users" class="btn btn-light border px-4">Batal</a>
                <button type="submit" class="btn btn-primary px-4" style="background-color: #6f42c1; border: none;">
                    <i class="fa-solid fa-save me-1"></i> Simpan Akun IT
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function generateNamaOtomatis() {
        var lokasi = document.getElementById("lokasiPabrik").value;
        var inputNama = document.getElementById("namaAkun");
        
        if(lokasi !== "") {
            inputNama.value = "IT Support " + lokasi;
        }
    }
</script>

<?= $this->endSection(); ?>