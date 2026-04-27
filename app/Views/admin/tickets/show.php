<?= $this->extend('layout/admin_template'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card shadow-sm h-100 border-0 rounded-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center rounded-top-4 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-ticket text-primary me-2"></i> Detail Tiket: <?= $tiket['kode_tiket']; ?></h5>
                    <?php if(isset($tiket['prioritas'])): ?>
                        <?php 
                            if($tiket['prioritas'] == 'Urgent') echo '<span class="badge bg-danger shadow-sm"><i class="fa-solid fa-triangle-exclamation me-1"></i> URGENT</span>';
                            elseif($tiket['prioritas'] == 'High') echo '<span class="badge" style="background-color: #fd7e14; color: white;"><i class="fa-solid fa-arrow-up me-1"></i> HIGH</span>';
                            elseif($tiket['prioritas'] == 'Medium') echo '<span class="badge bg-warning text-dark"><i class="fa-solid fa-equals me-1"></i> MEDIUM</span>';
                            else echo '<span class="badge bg-secondary"><i class="fa-solid fa-arrow-down me-1"></i> LOW</span>';
                        ?>
                    <?php else: ?>
                        <span class="badge bg-secondary"><i class="fa-solid fa-arrow-down me-1"></i> LOW</span>
                    <?php endif; ?>
                </div>
                <a href="/admin/tickets" class="btn btn-sm btn-light border"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
            </div>
            <div class="card-body p-4">
                <?php if(session()->getFlashdata('pesan')): ?><div class="alert alert-success alert-dismissible fade show"><i class="fa-solid fa-check-circle me-2"></i><?= session()->getFlashdata('pesan'); ?> <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
                <div class="row mb-4">
                    <div class="col-sm-6 mb-3"><p class="text-muted small fw-bold mb-1">Nama Pelapor</p><h6 class="fw-bold"><?= $tiket['nama_pelapor']; ?></h6></div>
                    <div class="col-sm-6 mb-3"><p class="text-muted small fw-bold mb-1">No. WhatsApp</p><h6><a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $tiket['no_wa']); ?>" target="_blank" class="text-success text-decoration-none fw-bold"><i class="fa-brands fa-whatsapp me-1"></i> <?= $tiket['no_wa']; ?></a></h6></div>
                    <div class="col-sm-6 mb-3"><p class="text-muted small fw-bold mb-1">Departemen / Area</p><h6><?= $tiket['departemen']; ?> (<?= $tiket['lokasi']; ?>)</h6></div>
                    <div class="col-sm-6 mb-3"><p class="text-muted small fw-bold mb-1">Kategori Masalah</p><h6><?= $tiket['kategori']; ?></h6></div>
                    <div class="col-12 mt-2"><p class="text-muted small fw-bold mb-2">Deskripsi Keluhan / Masalah:</p><div class="p-3 bg-light rounded border-start border-4 border-primary text-dark"><?= nl2br(esc($tiket['deskripsi'])); ?></div></div>
                </div>
                
                <?php if(!empty($tiket['catatan_admin']) || (isset($tiket['ganti_hardware']) && $tiket['ganti_hardware'] == 'Iya')): ?>
                <div class="alert alert-info border-0 shadow-sm mb-4">
                    <h6 class="fw-bold mb-2 text-dark"><i class="fa-solid fa-user-doctor text-primary me-2"></i>Hasil Analisis & Tindakan IT:</h6>
                    <p class="mb-3 text-dark" style="font-size: 14px;"><?= !empty($tiket['catatan_admin']) ? nl2br(esc($tiket['catatan_admin'])) : '<i class="text-muted">Tidak ada catatan.</i>'; ?></p>
                    <?php if(isset($tiket['ganti_hardware']) && $tiket['ganti_hardware'] == 'Iya'): ?>
                        <span class="badge bg-danger px-3 py-2"><i class="fa-solid fa-microchip me-1"></i> Memerlukan Pergantian Hardware</span>
                    <?php else: ?>
                        <span class="badge bg-success bg-opacity-25 text-success px-3 py-2"><i class="fa-solid fa-check me-1"></i> Tidak Perlu Ganti Hardware</span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <hr class="text-muted border-dashed">
                <div class="bg-light p-3 rounded">
                    <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-clipboard-check text-success me-2"></i> Riwayat Pengerjaan IT</h6>
                    <div class="row">
                        <div class="col-md-4 mb-2"><p class="text-muted small mb-1">Ditangani Oleh:</p><p class="fw-bold mb-0 text-primary"><?= $tiket['nama_teknisi'] ?? '<span class="text-muted fst-italic">Belum Ditugaskan</span>'; ?></p></div>
                        <div class="col-md-4 mb-2"><p class="text-muted small mb-1">Waktu Mulai:</p><p class="fw-bold mb-0"><?= ($tiket['waktu_mulai']) ? date('d M Y, H:i', strtotime($tiket['waktu_mulai'])) : '-'; ?></p></div>
                        <div class="col-md-4 mb-2"><p class="text-muted small mb-1">Waktu Selesai:</p><p class="fw-bold mb-0 text-success"><?= ($tiket['waktu_selesai']) ? date('d M Y, H:i', strtotime($tiket['waktu_selesai'])) : '-'; ?></p></div>
                    </div>
                </div>
                <div class="mt-3"><p class="text-muted small mb-0"><i class="fa-regular fa-clock me-1"></i> Tiket dibuat: <?= date('d F Y, H:i', strtotime($tiket['created_at'])); ?></p></div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-header bg-white py-3 rounded-top-4 border-bottom"><h5 class="mb-0 fw-bold"><i class="fa-solid fa-rotate text-warning me-2"></i> Update Status</h5></div>
            <div class="card-body p-4">
                
                <div class="mb-4 text-center">
                    <p class="text-muted small fw-bold mb-2">Status Saat Ini:</p>
                    <?php if($tiket['status'] == 'New'): ?><span class="badge bg-danger fs-6 px-3 py-2 rounded-pill shadow-sm">Baru Masuk</span>
                    <?php elseif($tiket['status'] == 'On Progress'): ?><span class="badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill shadow-sm">Sedang Dikerjakan</span>
                    <?php elseif($tiket['status'] == 'On Hold'): ?><span class="badge bg-secondary fs-6 px-3 py-2 rounded-pill shadow-sm">Ditunda / Tunggu Part</span>
                    <?php elseif($tiket['status'] == 'Resolved'): ?><span class="badge bg-info text-dark fs-6 px-3 py-2 rounded-pill shadow-sm">Menunggu Konfirmasi Klien</span>
                    <?php elseif($tiket['status'] == 'Closed'): ?><span class="badge bg-success fs-6 px-3 py-2 rounded-pill shadow-sm">Selesai (Closed)</span><?php endif; ?>
                </div>
                <hr class="text-muted">
                
                <form id="updateTicketForm" action="/admin/tickets/update-status/<?= $tiket['id']; ?>" method="post">
                    <?= csrf_field(); ?>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold small">Tugaskan Teknisi:</label>
                        <select class="form-select bg-light border-primary" name="teknisi_id" <?= in_array($tiket['status'], ['Resolved', 'Closed']) ? 'disabled' : ''; ?>>
                            <option value="">-- Belum Ditugaskan --</option>
                            <?php foreach($teknisi as $tek): ?><option value="<?= $tek['id']; ?>" <?= ($tiket['teknisi_id'] == $tek['id']) ? 'selected' : ''; ?>><?= $tek['nama']; ?></option><?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold small">Skala Prioritas:</label>
                        <select class="form-select bg-light" name="prioritas" <?= in_array($tiket['status'], ['Resolved', 'Closed']) ? 'disabled' : ''; ?>>
                            <option value="Low" <?= (isset($tiket['prioritas']) && $tiket['prioritas'] == 'Low') ? 'selected' : ''; ?>>🟢 Low (Bisa Ditunda)</option>
                            <option value="Medium" <?= (isset($tiket['prioritas']) && $tiket['prioritas'] == 'Medium') ? 'selected' : ''; ?>>🟡 Medium (Normal)</option>
                            <option value="High" <?= (isset($tiket['prioritas']) && $tiket['prioritas'] == 'High') ? 'selected' : ''; ?>>🟠 High (Segera Dikerjakan)</option>
                            <option value="Urgent" <?= (isset($tiket['prioritas']) && $tiket['prioritas'] == 'Urgent') ? 'selected' : ''; ?>>🔴 Urgent (Mendesak / Kritis)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold small">Catatan Penanganan IT:</label>
                        <textarea class="form-control bg-light" name="catatan_admin" rows="3" placeholder="Contoh: Perlu aktivasi lisensi..." <?= in_array($tiket['status'], ['Resolved', 'Closed']) ? 'readonly' : ''; ?>><?= esc($tiket['catatan_admin'] ?? ''); ?></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label text-muted fw-bold small">Perlu Ganti Hardware?</label>
                        <select class="form-select bg-light" name="ganti_hardware" <?= in_array($tiket['status'], ['Resolved', 'Closed']) ? 'disabled' : ''; ?>>
                            <option value="Tidak" <?= (isset($tiket['ganti_hardware']) && $tiket['ganti_hardware'] == 'Tidak') ? 'selected' : ''; ?>>Tidak</option>
                            <option value="Iya" <?= (isset($tiket['ganti_hardware']) && $tiket['ganti_hardware'] == 'Iya') ? 'selected' : ''; ?>>Iya</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label text-muted fw-bold small">Ubah Status Tiket:</label>
                        <select class="form-select border-warning bg-light fw-bold" name="status" id="statusSelect" required <?= in_array($tiket['status'], ['Resolved', 'Closed']) ? 'disabled' : ''; ?>>
                            <?php if($tiket['status'] == 'New'): ?>
                                <option value="New" selected>New (Baru Masuk)</option>
                                <option value="On Progress">On Progress (Mulai Dikerjakan)</option>
                            <?php elseif($tiket['status'] == 'On Progress'): ?>
                                <option value="On Progress" selected>On Progress (Sedang Dikerjakan)</option>
                                <option value="On Hold">On Hold (Tunda Pekerjaan)</option>
                                <option value="Resolved">Resolved (Selesai, Tunggu Klien)</option>
                            <?php elseif($tiket['status'] == 'On Hold'): ?>
                                <option value="On Hold" selected>On Hold (Sedang Ditunda)</option>
                                <option value="On Progress">On Progress (Lanjut Dikerjakan)</option>
                                <option value="Resolved">Resolved (Selesai, Tunggu Klien)</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <?php if(!in_array($tiket['status'], ['Resolved', 'Closed'])): ?>
                        <button type="button" class="btn btn-primary w-100 fw-bold shadow-sm btn-hover-scale" style="background-color: #1a56db;" data-bs-toggle="modal" data-bs-target="#confirmModal" onclick="updateModalText()">
                            <i class="fa-solid fa-save me-1"></i> Simpan & Update Tiket
                        </button>
                    
                    <?php elseif($tiket['status'] == 'Resolved'): ?>
                        <?php 
                            // Membersihkan dan merapikan nomor WA Klien
                            $nomorWA = preg_replace('/[^0-9]/', '', $tiket['no_wa']);
                            if(substr($nomorWA, 0, 1) == '0') { $nomorWA = '62' . substr($nomorWA, 1); }
                            
                            $linkLacak = base_url('/tiket/lacak?keyword=' . $tiket['kode_tiket']);
                            $pesanWa = "Halo *" . strtoupper($tiket['nama_pelapor']) . "*,%0A%0ATim IT telah selesai menangani kendala pada tiket Anda (*" . $tiket['kode_tiket'] . "*).%0A%0AMohon bantuannya untuk mengecek perangkat Anda. Jika sudah normal, silakan klik link di bawah ini untuk melakukan *Konfirmasi Penyelesaian* agar tiket dapat ditutup:%0A" . $linkLacak . "%0A%0ATerima kasih,%0A*IT Support JMI*";
                        ?>
                        <div class="alert alert-info small text-center mb-3 border-info bg-info bg-opacity-10 text-dark">
                            <i class="fa-solid fa-user-clock mb-2 fa-2x text-info"></i><br>
                            <b>Menunggu Konfirmasi Klien</b><br>
                            Silakan tekan tombol di bawah untuk memberitahu klien bahwa pekerjaannya sudah selesai.
                        </div>
                        
                        <a href="https://api.whatsapp.com/send?phone=<?= $nomorWA; ?>&text=<?= $pesanWa; ?>" target="_blank" class="btn btn-success w-100 fw-bold shadow-sm btn-hover-scale rounded-pill py-2" style="background-color: #25D366; border: none;">
                            <i class="fa-brands fa-whatsapp fs-5 me-1 align-middle"></i> Beritahu Klien via WA
                        </a>
                    
                    <?php elseif($tiket['status'] == 'Closed'): ?>
                        <div class="alert alert-success small text-center fw-bold mb-0 border-success bg-success bg-opacity-10 text-success rounded-4 p-4">
                            <i class="fa-solid fa-check-double fa-3x mb-2 d-block"></i>
                            Tiket Telah Selesai & Ditutup
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center pb-4 px-4">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle" style="width: 80px; height: 80px;">
                        <i class="fa-solid fa-clipboard-check" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
                <h4 class="fw-bold text-dark mb-2">Konfirmasi Pembaruan</h4>
                <p class="text-muted mb-3" style="font-size: 15px;">
                    Anda akan memperbarui data tiket ini. Status tiket akan disimpan sebagai:
                </p>
                <div class="mb-4">
                    <span id="modalNewStatus" class="badge fs-6 px-4 py-2 rounded-pill shadow-sm"></span>
                </div>
                <div class="d-flex justify-content-center gap-3 mt-2">
                    <button type="button" class="btn btn-light border px-4 py-2 fw-bold text-muted shadow-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="button" onclick="submitUpdateForm()" class="btn btn-primary px-4 py-2 fw-bold shadow-sm" style="background-color: #1a56db;">Ya, Update Tiket</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateModalText() {
        const statusSelect = document.getElementById('statusSelect');
        const selectedText = statusSelect.options[statusSelect.selectedIndex].text;
        const selectedValue = statusSelect.value;
        const badge = document.getElementById('modalNewStatus');
        
        badge.innerText = selectedText;
        badge.className = 'badge fs-6 px-4 py-2 rounded-pill shadow-sm ';
        
        if(selectedValue === 'New') { badge.classList.add('bg-danger'); } 
        else if(selectedValue === 'On Progress') { badge.classList.add('bg-warning', 'text-dark'); } 
        else if(selectedValue === 'On Hold') { badge.classList.add('bg-secondary'); } 
        else if(selectedValue === 'Resolved') { badge.classList.add('bg-info', 'text-dark'); }
    }
    function submitUpdateForm() { document.getElementById('updateTicketForm').submit(); }
</script>
<style>.btn-hover-scale { transition: transform 0.2s ease; } .btn-hover-scale:hover { transform: translateY(-2px); }</style>
<?= $this->endSection(); ?>