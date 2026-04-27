<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Tiket IT Baru - Sistem JMI</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.css" rel="stylesheet">
    
    <style>
        /* Pengaturan Dasar */
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #f4f7fe 0%, #e1eafc 100%); min-height: 100vh; color: #2d3748; }

        /* Navigasi Glassmorphism */
        .navbar-glass { background: rgba(255, 255, 255, 0.75); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); padding: 15px 0; position: sticky; top: 0; z-index: 1000; }
        .form-container { max-width: 800px; margin: 40px auto; padding: 0 15px; }
        
        /* Desain Kartu Formulir Premium */
        .card-custom { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 1); border-radius: 24px; box-shadow: 0 20px 50px rgba(26, 86, 219, 0.08); padding: 45px; }

        /* Styling Input Modern */
        .form-label { font-weight: 700; color: #4a5568; font-size: 0.85rem; letter-spacing: 0.3px; margin-bottom: 8px; }
        .form-control, .form-select { border-radius: 12px; padding: 14px 18px; border: 1.5px solid #e2e8f0; background-color: #f8fafc; font-size: 0.95rem; color: #1a202c; transition: all 0.3s ease; box-shadow: none; }
        .form-control::placeholder { color: #a0aec0; font-weight: 400; }
        .form-control:focus, .form-select:focus { border-color: #1a56db; box-shadow: 0 0 0 4px rgba(26, 86, 219, 0.1); background-color: #ffffff; outline: none; }

        /* Icon Wrapper di dalam input */
        .input-with-icon { position: relative; }
        .input-with-icon > i { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: #a0aec0; font-size: 1.1rem; z-index: 10; }
        .input-with-icon .form-control, .input-with-icon .form-select { padding-left: 48px; }

        /* PENYESUAIAN KHUSUS UNTUK TOM SELECT (Dropdown Search) */
        .input-with-icon .ts-wrapper { width: 100%; }
        .ts-control { border-radius: 12px; padding: 14px 18px 14px 48px !important; border: 1.5px solid #e2e8f0; background-color: #f8fafc; font-size: 0.95rem; color: #1a202c; transition: all 0.3s ease; box-shadow: none; }
        .ts-wrapper.focus .ts-control { border-color: #1a56db; box-shadow: 0 0 0 4px rgba(26, 86, 219, 0.1); background-color: #ffffff; }
        .ts-wrapper.disabled .ts-control { background-color: #edf2f7; cursor: not-allowed; opacity: 0.8; border-color: #e2e8f0; }
        .ts-dropdown { border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 10px 25px rgba(0,0,0,0.1); overflow: hidden; font-size: 0.95rem; font-weight: 600; }
        .ts-dropdown .option { padding: 10px 15px; }
        .ts-dropdown .option.active { background-color: #f0f4ff; color: #1a56db; }

        /* Tombol Utama */
        .btn-submit { background-color: #1a56db; color: white; font-weight: 700; padding: 16px 28px; border-radius: 12px; font-size: 1.05rem; transition: all 0.3s ease; border: none; width: 100%; margin-top: 20px; }
        .btn-submit:hover { background-color: #1545b0; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(26, 86, 219, 0.2); color: white; }
        
        .btn-hover-scale { transition: all 0.3s ease; }
        .btn-hover-scale:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08); }

        /* Animasi Muncul (Fade In Up) */
        .fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; transform: translateY(20px); }
        .delay-1 { animation-delay: 0.1s; }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
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

    <div class="form-container fade-in-up">
        
        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3 shadow-sm" style="width: 75px; height: 75px;">
                <i class="fa-solid fa-headset fa-2x"></i>
            </div>
            <h3 class="fw-bolder text-dark mb-1">Laporkan Masalah IT</h3>
            <p class="text-muted">Isi formulir di bawah ini agar Tim IT dapat segera membantu Anda.</p>
        </div>

        <?php if(session()->getFlashdata('pesan_error')): ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" style="background-color: #ffe2e5; color: #f64e60;">
                <i class="fa-solid fa-triangle-exclamation me-2"></i><?= session()->getFlashdata('pesan_error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card-custom mb-5 delay-1">
            <form action="/tiket/simpan" method="post">
                <?= csrf_field(); ?>
                
                <div class="row g-4 mb-4 pb-3 border-bottom border-light">
                    <div class="col-md-6">
                        <label class="form-label"><i class="fa-solid fa-building me-1 text-primary"></i> Lokasi Plant <span class="text-danger">*</span></label>
                        <select class="form-select fw-semibold" name="lokasi" id="lokasi" required>
                            <option value="">-- Pilih Lokasi Plant Anda --</option>
                            <option value="Mojoagung">Plant Mojoagung</option>
                            <option value="Krian">Plant Krian</option>
                            <option value="Batang">Plant Batang</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><i class="fa-solid fa-users-rectangle me-1 text-primary"></i> Divisi / Departemen <span class="text-danger">*</span></label>
                        <div class="input-with-icon">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <select name="departemen" id="departemen" placeholder="-- Pilih Lokasi Dulu --" required disabled>
                                <option value="">-- Pilih Lokasi Dulu --</option>
                            </select>
                        </div>
                        <small id="deptHelp" class="form-text text-muted" style="font-size: 0.75rem; margin-top: 6px; display: none;">
                            <i class="fa-solid fa-circle-info me-1 opacity-75"></i>Pilih lokasi plant untuk memunculkan divisi.
                        </small>
                    </div>
                </div>

                <div class="row g-4 mb-4 pb-3 border-bottom border-light">
                    <div class="col-md-6">
                        <label class="form-label"><i class="fa-solid fa-user me-1 text-primary"></i> Nama Lengkap <span class="text-danger">*</span></label>
                        <div class="input-with-icon">
                            <i class="fa-regular fa-id-badge"></i>
                            <input type="text" class="form-control text-uppercase" name="nama_pelapor" placeholder="MISAL: BUDI SANTOSO" required autocomplete="name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><i class="fa-brands fa-whatsapp me-1 text-success fs-6"></i> No. WhatsApp (Aktif) <span class="text-danger">*</span></label>
                        <div class="input-with-icon">
                            <i class="fa-solid fa-phone"></i>
                            <input type="number" class="form-control" name="whatsapp" placeholder="Misal: 08123456789" required>
                        </div>
                    </div>
                </div>

                <div class="mb-4 mt-3">
                    <label class="form-label"><i class="fa-solid fa-desktop me-1 text-primary"></i> Jelaskan Kendala Anda <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="deskripsi" rows="4" placeholder="Jelaskan secara detail masalah yang Anda alami. &#10;Misal: Printer Epson tidak bisa merespon print dari komputer, atau jaringan internet tiba-tiba mati..." required></textarea>
                </div>

                <button type="submit" class="btn btn-submit shadow-sm mt-3">
                    <i class="fa-regular fa-paper-plane me-2"></i> Kirim Tiket Laporan
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const dataDepartemen = <?= json_encode($departemen ?? []); ?>;
        
        const selectLokasi = document.getElementById('lokasi');
        const deptHelp = document.getElementById('deptHelp');

        // 1. Inisialisasi Tom Select (Fitur Search)
        const deptSelectInstance = new TomSelect("#departemen", {
            create: false,
            sortField: { field: "text", direction: "asc" },
            placeholder: "-- Pilih Lokasi Plant Dulu --"
        });

        // Tampilkan teks bantuan saat form pertama dimuat
        if(selectLokasi.value === "") {
            deptHelp.style.display = 'block';
        }

        // 2. Event saat lokasi plant dipilih/diubah
        selectLokasi.addEventListener('change', function() {
            const lokasiDipilih = this.value;
            
            // Bersihkan data dropdown yang lama
            deptSelectInstance.clear();
            deptSelectInstance.clearOptions();
            
            if (lokasiDipilih === "") {
                deptSelectInstance.disable();
                deptHelp.style.display = 'block';
                return;
            }

            // Buka dropdown, set placeholder baru agar klien mencari
            deptSelectInstance.enable();
            deptSelectInstance.settings.placeholder = "Ketik / Cari Divisi Anda...";
            deptSelectInstance.inputState(); // Update tampilan input
            deptHelp.style.display = 'none';
            
            // Filter divisi sesuai plant
            const filteredDept = dataDepartemen.filter(d => d.lokasi_plant.toLowerCase() === lokasiDipilih.toLowerCase());
            
            if (filteredDept.length > 0) {
                // Masukkan opsi baru ke dalam Tom Select
                filteredDept.forEach(d => {
                    deptSelectInstance.addOption({ value: d.nama_departemen, text: d.nama_departemen.toUpperCase() });
                });
            } else {
                deptSelectInstance.addOption({ value: "Umum", text: "LAINNYA / UMUM" });
            }
        });
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>