<?= $this->extend('layout/admin_template'); ?>
<?= $this->section('content'); ?>

<div class="card shadow-sm" style="max-width: 800px; margin: auto;">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0"><i class="fa-solid fa-user-pen text-primary me-2"></i> Form Edit Data User</h5>
    </div>
    <div class="card-body p-4">

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="fa-solid fa-triangle-exclamation me-2"></i><?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('admin/users/update/' . $user['id']); ?>" method="post">
            <?= csrf_field(); ?>
            <div class="row">
                
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted fw-bold small">Lokasi Penugasan (Plant)</label>
                    <select class="form-select bg-light border-primary" name="lokasi" id="lokasiPabrik" required onchange="generateNamaOtomatis()">
                        <option value="Krian" <?= ($user['lokasi'] == 'Krian') ? 'selected' : ''; ?>>Plant Krian</option>
                        <option value="Mojoagung" <?= ($user['lokasi'] == 'Mojoagung') ? 'selected' : ''; ?>>Plant Mojoagung</option>
                        <option value="Batang" <?= ($user['lokasi'] == 'Batang') ? 'selected' : ''; ?>>Plant Batang</option>
                        </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted fw-bold small">Nama Akun</label>
                    <input type="text" class="form-control bg-light" name="nama" id="namaAkun" value="<?= esc($user['nama']); ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted fw-bold small">Email Login</label>
                    <input type="email" class="form-control bg-light" name="email" value="<?= esc($user['email']); ?>" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted fw-bold small">Hak Akses (Role)</label>
                    <select class="form-select bg-light" name="role" required>
                        <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : ''; ?>>IT Support (Admin Plant)</option>
                        <option value="superadmin" <?= ($user['role'] == 'superadmin') ? 'selected' : ''; ?>>Super Admin</option>
                        </select>
                </div>
                
                <div class="col-md-6 mb-4">
                    <label class="form-label text-muted fw-bold small">Departemen / Area</label>
                    <input type="text" class="form-control bg-light" name="departemen" value="<?= esc($user['departemen']); ?>" required>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label text-muted fw-bold small">Ganti Password Login</label>
                    <input type="password" class="form-control bg-light" name="password" placeholder="Kosongkan jika tidak diganti...">
                </div>
            </div>
            
            <hr class="text-muted mt-0 mb-4">
            <div class="d-flex justify-content-end gap-2">
                <a href="<?= site_url('admin/users'); ?>" class="btn btn-light border px-4">Batal</a>
                <button type="submit" class="btn btn-primary px-4" style="background-color: #6f42c1; border: none;">
                    <i class="fa-solid fa-save me-1"></i> Update Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Fitur ganti nama otomatis tetap berjalan jika nama mengandung kata "IT Support"
    function generateNamaOtomatis() {
        var lokasi = document.getElementById("lokasiPabrik").value;
        var inputNama = document.getElementById("namaAkun");
        if(lokasi !== "" && inputNama.value.includes("IT Support")) {
            inputNama.value = "IT Support " + lokasi;
        }
    }
</script>

<?= $this->endSection(); ?>