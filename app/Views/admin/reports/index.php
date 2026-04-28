<?= $this->extend('layout/admin_template'); ?>
<?= $this->section('content'); ?>
<?php
// LOGIKA ALAMAT DINAMIS 
$lokasi_login = session('lokasi') ?: 'Pusat';
$alamat = "Jl. Bypass Krian, Ds. Sidomojo, Krian Sidoarjo";
$telp   = "(031) 8982349";

if ($lokasi_login == 'Mojoagung') { $alamat = "Jl. Raya Mojoagung No. 123, Jombang, Jawa Timur"; $telp = "(0321) 489222"; } 
elseif ($lokasi_login == 'Batang') { $alamat = "Kawasan Industri Terpadu Batang (KITB), Jawa Tengah"; $telp = "(0285) 394829"; } 
elseif ($lokasi_login == 'Pusat') { $alamat = "Jl. Taman Sidoarjo No. 1, Sidoarjo, Jawa Timur"; $telp = "(031) 8073333"; }
?>

<div class="print-header mb-4">
    <table width="100%" style="margin-bottom: 8px;">
        <tr>
            <td width="20%" class="text-start align-middle"><img src="/assets/img/logo-jmi.png" alt="JMI Logo" style="height: 50px; object-fit: contain;"></td>
            <td width="60%" class="text-center align-middle" style="font-family: 'Times New Roman', Times, serif; color: #000;">
                <h4 style="margin: 0; font-weight: bold; font-size: 18px; letter-spacing: 0.5px;">PT JAYAMAS MEDICA INDUSTRI TBK</h4>
                <p style="margin: 0; font-size: 14px; margin-top: 3px;"><?= $alamat; ?></p>
                <p style="margin: 0; font-size: 14px;">Telp. <?= $telp; ?></p>
                <p style="margin: 0; font-size: 14px; text-decoration: underline;">Website: https://www.onemed.co.id/</p>
            </td>
            <td width="20%" class="text-end align-middle"><img src="/assets/img/onemed-logo.png" alt="OneMed Logo" style="height: 40px; object-fit: contain;"></td>
        </tr>
    </table>
    <div style="border-bottom: 4px solid #4a4a4a; margin-bottom: 2px;"></div>
    <div class="text-center mt-4 mb-3">
        <h5 style="font-weight: bold; margin-bottom: 5px; font-family: Arial, Helvetica, sans-serif; font-size: 15px;" id="print-title">LAPORAN REKAPITULASI TIKET IT</h5>
        <?php if(!empty($_GET['start_date']) && !empty($_GET['end_date'])): ?>
            <p style="font-size: 11px; margin: 0; font-family: Arial, Helvetica, sans-serif;">Periode: <?= date('d/m/Y', strtotime($_GET['start_date'])); ?> s/d <?= date('d/m/Y', strtotime($_GET['end_date'])); ?></p>
        <?php endif; ?>
    </div>
    <div class="text-end mb-2"><p style="font-size: 11px; margin: 0; font-family: Arial, Helvetica, sans-serif;">Tanggal Cetak: <b><?= date('d/m/Y'); ?></b></p></div>
</div>

<div class="card shadow-sm border-0 rounded-4 mb-4" id="reportCard">
    
    <div class="card-header bg-white p-4 d-flex flex-wrap justify-content-between align-items-center rounded-top-4 border-bottom-0 header-title gap-2">
        <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-file-invoice text-primary me-2"></i> Laporan Tiket IT</h5>
        <button onclick="window.print()" class="btn btn-success px-4 py-2 fw-bold shadow-sm btn-print btn-hover-scale rounded-pill" style="background-color: #10b981; border: none;">
            <i class="fa-solid fa-print me-2"></i> Cetak PDF Laporan
        </button>
    </div>
    
    <div class="px-4 pb-3 no-print">
        <div class="bg-light rounded-4 p-4 border border-light shadow-sm">
            <form action="/admin/reports" method="get">
                <div class="row g-3">
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label small fw-bolder text-muted mb-2 text-uppercase" style="letter-spacing: 0.5px;"><i class="fa-solid fa-magnifying-glass me-1"></i> Cari Tiket</label>
                        <input type="text" class="form-control form-control-modern text-uppercase" name="kode_tiket" value="<?= isset($_GET['kode_tiket']) ? esc($_GET['kode_tiket']) : ''; ?>">
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label small fw-bolder text-muted mb-2 text-uppercase" style="letter-spacing: 0.5px;"><i class="fa-regular fa-calendar-days me-1"></i> Mulai Tanggal</label>
                        <input type="date" class="form-control form-control-modern" name="start_date" value="<?= isset($_GET['start_date']) ? esc($_GET['start_date']) : ''; ?>">
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <label class="form-label small fw-bolder text-muted mb-2 text-uppercase" style="letter-spacing: 0.5px;"><i class="fa-regular fa-calendar-check me-1"></i> Sampai Tanggal</label>
                        <input type="date" class="form-control form-control-modern" name="end_date" value="<?= isset($_GET['end_date']) ? esc($_GET['end_date']) : ''; ?>">
                    </div>

                    <div class="col-12"><hr class="my-1 border-secondary opacity-10"></div>

                    <?php 
                        // Menangkap data URL agar dropdown juga lengket
                        $get_status = isset($_GET['status']) ? $_GET['status'] : 'All';
                        $get_prioritas = isset($_GET['prioritas']) ? $_GET['prioritas'] : 'All';
                        $get_teknisi = isset($_GET['teknisi_id']) ? $_GET['teknisi_id'] : 'All';
                    ?>

                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bolder text-muted mb-2 text-uppercase" style="letter-spacing: 0.5px;"><i class="fa-solid fa-tags me-1"></i> Status</label>
                        <select class="form-select form-control-modern fw-semibold" name="status">
                            <option value="All">-- Semua Status --</option>
                            <option value="New" <?= ($get_status == 'New') ? 'selected' : ''; ?>>New</option>
                            <option value="On Progress" <?= ($get_status == 'On Progress') ? 'selected' : ''; ?>>On Progress</option>
                            <option value="On Hold" <?= ($get_status == 'On Hold') ? 'selected' : ''; ?>>On Hold</option>
                            <option value="Resolved" <?= ($get_status == 'Resolved') ? 'selected' : ''; ?>>Resolved</option>
                            <option value="Closed" <?= ($get_status == 'Closed') ? 'selected' : ''; ?>>Closed (Selesai)</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bolder text-muted mb-2 text-uppercase" style="letter-spacing: 0.5px;"><i class="fa-solid fa-layer-group me-1"></i> Prioritas</label>
                        <select class="form-select form-control-modern fw-semibold" name="prioritas">
                            <option value="All">-- Semua Prioritas --</option>
                            <option value="Low" <?= ($get_prioritas == 'Low') ? 'selected' : ''; ?>>Low</option>
                            <option value="Medium" <?= ($get_prioritas == 'Medium') ? 'selected' : ''; ?>>Medium</option>
                            <option value="High" <?= ($get_prioritas == 'High') ? 'selected' : ''; ?>>High</option>
                            <option value="Urgent" <?= ($get_prioritas == 'Urgent') ? 'selected' : ''; ?>>Urgent</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-8">
                        <label class="form-label small fw-bolder text-muted mb-2 text-uppercase" style="letter-spacing: 0.5px;"><i class="fa-solid fa-user-gear me-1"></i> Teknisi IT</label>
                        <select class="form-select form-control-modern fw-semibold" name="teknisi_id">
                            <option value="All">-- Semua Teknisi --</option>
                            <?php if(isset($teknisi)): foreach($teknisi as $tek): ?>
                                <option value="<?= $tek['id']; ?>" <?= ($get_teknisi == $tek['id']) ? 'selected' : ''; ?>><?= strtoupper($tek['nama']); ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    
                    <div class="col-lg-3 col-md-4 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary fw-bold flex-grow-1 shadow-sm btn-hover-scale py-2 rounded-3" style="background-color: #0d6efd;">
                            <i class="fa-solid fa-filter me-1"></i> Terapkan
                        </button>
                        <a href="/admin/reports" class="btn btn-outline-danger shadow-sm btn-hover-scale py-2 rounded-3 px-3" title="Reset Filter">
                            <i class="fa-solid fa-rotate-right"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card-body p-0 overflow-hidden">
        <div class="table-responsive custom-scrollbar px-4 pb-2">
            <table class="table table-hover align-middle table-modern mb-0" style="min-width: 1000px;">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 12%;">NO. TIKET</th>
                        <th class="text-center" style="width: 9%;">TANGGAL</th>
                        <th style="width: 16%;">PELAPOR & DIVISI</th>
                        <th style="width: 23%;">KENDALA AWAL</th>
                        <th style="width: 22%;">TINDAKAN & PENANGANAN</th>
                        <th class="text-center" style="width: 10%;">STATUS</th>
                        <th class="text-center no-print" style="width: 8%;">AKSI</th>
                    </tr>
                </thead>
                <tbody id="ticket-tbody">
                    <?php if(empty($tiket)): ?>
                        <tr><td colspan="7" class="text-center py-5 text-muted border-bottom-0"><i class="fa-solid fa-folder-open fa-3x mb-3 opacity-25"></i><br><span class="fw-semibold">Tidak ada data tiket yang sesuai filter.</span></td></tr>
                    <?php else: foreach($tiket as $t) : ?>
                        <tr class="ticket-row" id="row-<?= $t['id']; ?>">
                            
                            <td class="text-center align-middle">
                                <span class="fw-bolder text-primary print-text-dark d-block mb-1" style="font-size: 0.85rem;"><?= $t['kode_tiket']; ?></span>
                                <?php 
                                if(isset($t['prioritas']) && $t['prioritas'] != 'Low') {
                                    $prioClass = 'badge-soft-secondary';
                                    if($t['prioritas'] == 'Medium') $prioClass = 'badge-soft-warning';
                                    if($t['prioritas'] == 'High') $prioClass = 'badge-soft-orange';
                                    if($t['prioritas'] == 'Urgent') $prioClass = 'badge-soft-danger';
                                    echo '<span class="badge '.$prioClass.' print-prio rounded-1 fw-bold px-2 py-0" style="font-size: 0.65rem;">'.strtoupper($t['prioritas']).'</span>';
                                }
                                ?>
                            </td>
                            
                            <td class="text-center align-middle text-nowrap"><span class="print-text-date text-muted fw-semibold" style="font-size: 0.8rem;"><?= date('d/m/Y', strtotime($t['created_at'])); ?></span></td>
                            
                            <td class="align-middle">
                                <span class="fw-bold text-dark d-block print-text-dark text-nowrap" style="font-size: 0.85rem; line-height: 1.2;"><?= strtoupper($t['nama_pelapor']); ?></span>
                                <span class="text-muted print-text-dark" style="font-size: 0.75rem;"><i class="fa-regular fa-building me-1 opacity-50"></i><?= $t['departemen']; ?></span>
                            </td>
                            
                            <td style="max-width: 200px;">
                             <div class="text-dark fw-medium" style="font-size: 0.85rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" title="<?= esc($t['deskripsi']); ?>">
                                  <?= esc($t['deskripsi']); ?>
                             </div>
                            </td>
                            
                            <td class="align-middle py-2">
                                <?php if($t['waktu_mulai']): ?>
                                    <span class="fw-bold text-success print-text-dark d-block" style="font-size: 0.8rem;"><i class="fa-solid fa-user-check me-1"></i> <?= strtoupper($t['nama_teknisi'] ?? '-'); ?></span>
                                    <span class="text-muted print-text-dark d-block mb-1" style="font-size: 0.7rem;">
                                        <?= date('d/m H:i', strtotime($t['waktu_mulai'])); ?> - <?= $t['waktu_selesai'] ? date('d/m H:i', strtotime($t['waktu_selesai'])) : '...'; ?>
                                    </span>
                                    <?php if(!empty($t['catatan_admin'])): ?>
                                        <div class="p-1 px-2 mt-1 rounded-2 print-no-bg print-text-desc fw-medium" style="background-color: #f8f9fc; border: 1px solid #edf2f9; font-size: 0.75rem; color: #4a5568; line-height: 1.2;">
                                            <span class="fw-bold text-dark">Catatan:</span> <?= esc($t['catatan_admin']); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if(isset($t['ganti_hardware']) && $t['ganti_hardware'] == 'Iya'): ?>
                                        <div class="mt-1"><span class="badge badge-soft-danger rounded-pill print-hw-alert px-2 py-0" style="font-size: 0.65rem;"><i class="fa-solid fa-microchip me-1 print-hide-icon"></i> Ganti Hardware</span></div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted fst-italic print-text-dark small opacity-75" style="font-size: 0.8rem;">Belum ditangani tim IT</span>
                                <?php endif; ?>
                            </td>
                            
                            <td class="text-center align-middle">
                                <?php if($t['status'] == 'New'): ?>
                                    <span class="badge badge-soft-danger print-status px-2 py-1 rounded-pill">NEW</span>
                                <?php elseif($t['status'] == 'On Progress'): ?>
                                    <span class="badge badge-soft-warning print-status px-2 py-1 rounded-pill">PROGRESS</span>
                                <?php elseif($t['status'] == 'On Hold'): ?>
                                    <span class="badge badge-soft-secondary print-status px-2 py-1 rounded-pill">HOLD</span>
                                <?php elseif($t['status'] == 'Resolved'): ?>
                                    <span class="badge badge-soft-info print-status px-2 py-1 rounded-pill">RESOLVED</span>
                                <?php elseif($t['status'] == 'Closed'): ?>
                                    <span class="badge badge-soft-success print-status px-2 py-1 rounded-pill">CLOSED</span>
                                <?php endif; ?>
                            </td>
                            
                            <td class="text-center align-middle no-print">
                                <button onclick="cetakSatuTiket('row-<?= $t['id']; ?>', '<?= $t['kode_tiket']; ?>')" class="btn btn-sm btn-light border text-secondary fw-bold btn-hover-scale py-1 px-2" style="font-size: 0.75rem;" title="Cetak Baris Ini">
                                    <i class="fa-solid fa-print me-1"></i> Cetak
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="card-footer bg-white border-top-0 p-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-center no-print rounded-bottom-4">
        <span class="text-muted small fw-semibold mb-3 mb-md-0" id="page-info">Menampilkan 0 tiket</span>
        <nav><ul class="pagination pagination-sm mb-0 shadow-sm" id="pagination"></ul></nav>
    </div>
</div>

<div class="print-footer mt-4 pt-3">
    <table width="100%"><tr><td width="65%"></td><td width="35%" class="text-center"><p style="margin-bottom: 70px; font-size: 12px; font-family: Arial, Helvetica, sans-serif;">Mengetahui,</p><p style="margin: 0; font-weight: bold; text-decoration: underline; font-size: 13px; font-family: Arial, Helvetica, sans-serif;"><?= strtoupper(session('nama') ?: 'ADMIN IT PUSAT'); ?></p><p style="margin: 0; font-size: 12px; font-family: Arial, Helvetica, sans-serif;">IT Support <?= strtoupper($lokasi_login); ?></p></td></tr></table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const rowsPerPage = 7; 
    const rows = document.querySelectorAll('.ticket-row');
    const totalRows = rows.length;
    const totalPages = Math.ceil(totalRows / rowsPerPage);
    const paginationUl = document.getElementById('pagination');
    const pageInfo = document.getElementById('page-info');
    let currentPage = 1;

    if (totalRows === 0) { if(pageInfo) pageInfo.innerHTML = "Tidak ada data tiket."; return; }

    function displayPage(page) {
        currentPage = page; const start = (page - 1) * rowsPerPage; const end = start + rowsPerPage;
        rows.forEach((row, index) => { row.style.display = (index >= start && index < end) ? '' : 'none'; });
        pageInfo.innerHTML = `Menampilkan <span class="fw-bold text-dark">${start + 1} - ${end > totalRows ? totalRows : end}</span> dari <span class="fw-bold text-primary">${totalRows}</span> tiket`;
        setupPagination();
    }

    function setupPagination() {
        paginationUl.innerHTML = '';
        paginationUl.innerHTML += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage - 1}">&laquo;</a></li>`;
        for (let i = 1; i <= totalPages; i++) paginationUl.innerHTML += `<li class="page-item ${currentPage === i ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
        paginationUl.innerHTML += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage + 1}">&raquo;</a></li>`;
        paginationUl.querySelectorAll('.page-link').forEach(link => {
            link.addEventListener('click', function(e) { e.preventDefault(); let page = parseInt(this.getAttribute('data-page')); if (page >= 1 && page <= totalPages) displayPage(page); });
        });
    }
    displayPage(1); 
});

function cetakSatuTiket(rowId, kodeTiket) {
    document.getElementById('print-title').innerHTML = "DOKUMEN KERJA TIKET: " + kodeTiket;
    document.body.classList.add('print-single-mode');
    document.getElementById(rowId).classList.add('print-active-row');
    window.print();
    document.body.classList.remove('print-single-mode');
    document.getElementById(rowId).classList.remove('print-active-row');
    document.getElementById('print-title').innerHTML = "LAPORAN REKAPITULASI TIKET IT";
}
</script>

<style>
    .btn-hover-scale { transition: all 0.2s ease; }
    .btn-hover-scale:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    .print-header, .print-footer { display: none; }
    
    .pagination .page-item.active .page-link { background-color: #0d6efd; border-color: #0d6efd; color: white; }
    .pagination .page-link { color: #0d6efd; font-weight: 600; border: none; border-radius: 5px; margin: 0 2px; }
    
    .badge-soft-danger { background-color: #ffe2e5; color: #f64e60; border: 1px solid #ffe2e5; }
    .badge-soft-warning { background-color: #fff4de; color: #ffa800; border: 1px solid #fff4de; }
    .badge-soft-secondary { background-color: #e4e6ef; color: #7e8299; border: 1px solid #e4e6ef; }
    .badge-soft-info { background-color: #e1f0ff; color: #3699ff; border: 1px solid #e1f0ff; }
    .badge-soft-success { background-color: #c9f7f5; color: #1bc5bd; border: 1px solid #c9f7f5; }
    .badge-soft-orange { background-color: #ffe8cc; color: #fd7e14; border: 1px solid #ffe8cc; }
    
    .form-control-modern { background-color: #f8f9fc; border: 1px solid #e3e6f0; border-radius: 8px; padding: 8px 12px; font-size: 0.85rem; transition: all 0.2s; }
    .form-control-modern:focus { background-color: #fff; border-color: #0d6efd; box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15); }
    
    .table-modern { border-collapse: separate; border-spacing: 0; }
    .table-modern thead th { font-size: 0.7rem; color: #a1a5b7; text-transform: uppercase; letter-spacing: 1px; padding-bottom: 10px; border-bottom: 1px dashed #e4e6ef; background: transparent; font-weight: 700; }
    .table-modern tbody td { border-bottom: 1px dashed #e4e6ef; padding: 10px 8px; }
    .table-modern tbody tr:last-child td { border-bottom: none; }
    .table-modern tbody tr:hover { background-color: #f8f9fc; }
    
    @media screen {
        .custom-scrollbar::-webkit-scrollbar { height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 4px; }
    }

    @media print {
        @page { size: A4 landscape; margin: 10mm 15mm; } 
        body { background-color: #fff !important; color: #000 !important; font-family: Arial, Helvetica, sans-serif !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        
        .ticket-row { display: table-row !important; }
        body.print-single-mode .ticket-row { display: none !important; } 
        body.print-single-mode .ticket-row.print-active-row { display: table-row !important; } 

        .no-print { display: none !important; }
        .sidebar, .topbar, .btn-print, .header-title { display: none !important; }
        .main-content { margin: 0 !important; width: 100% !important; padding: 0 !important; }
        .card { box-shadow: none !important; border: none !important; }
        .card-body { padding: 0 !important; }
        .print-header, .print-footer { display: block !important; }
        
        .table { border-collapse: collapse !important; width: 100% !important; min-width: auto !important; border: 1px solid #000 !important; margin-bottom: 0 !important; }
        .table th, .table td { border: 1px solid #000 !important; padding: 5px 6px !important; color: #000 !important; vertical-align: top !important; }
        .table-light { background-color: #f2f2f2 !important; }
        .table-light th, .table thead th { color: #000 !important; font-weight: bold !important; font-size: 11px !important; text-align: center !important; vertical-align: middle !important; border-bottom: 1px solid #000 !important;}
        
        .table td { line-height: 1.4 !important; border-bottom: 1px solid #000 !important; }
        .print-text-dark { color: #000 !important; font-size: 11px !important; white-space: normal !important; }
        .print-text-date, .print-text-desc { font-size: 11px !important; }
        
        tr { page-break-inside: avoid !important; }
        .print-footer { page-break-inside: avoid !important; }
        .print-no-bg { background: none !important; border: none !important; padding: 0 !important; margin-top: 3px !important;}
        
        .badge { background: none !important; color: #000 !important; border: none !important; padding: 0 !important; font-size: 11px !important; }
        .print-status { font-weight: bold !important; text-transform: uppercase !important; }
        .print-hw-alert { display: inline-block !important; border: 1px solid #000 !important; padding: 2px 4px !important; font-weight: bold !important; margin-top: 3px !important; border-radius: 2px !important; font-size: 9px !important; }
        .print-prio { display: inline-block !important; border: 1px solid #000 !important; padding: 1px 4px !important; font-weight: bold !important; margin-top: 3px !important; font-size: 8.5px !important; letter-spacing: 0.5px;}
        .print-hide-icon { display: none !important; }
    }
</style>
<?= $this->endSection(); ?>