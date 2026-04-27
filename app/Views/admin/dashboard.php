<?= $this->extend('layout/admin_template'); ?>
<?= $this->section('content'); ?>

<?php
    // ========================================================================
    // LOGIKA PENGAMBILAN DATA REAL-TIME DARI DATABASE UNTUK GRAFIK & KARTU
    // ========================================================================
    $db           = \Config\Database::connect();
    $ticketModel  = new \App\Models\TicketModel();
    $isSuperAdmin = session('role') == 'superadmin';
    $lokasiAdmin  = session('lokasi');

    // 0. MENGHITUNG TOTAL TIM IT (Kecuali Super Admin)
    // Pastikan 'superadmin' ini sesuai dengan role Anda di database
    $qTotalTim = $db->table('users')->where('role !=', 'superadmin'); 
    
    // Jika yang login bukan Super Admin, hitung tim IT di plant-nya saja
    if (!$isSuperAdmin) { 
        $qTotalTim->where('lokasi', $lokasiAdmin); 
    }
    $total_tim_it = $qTotalTim->countAllResults();

    // 1. DATA GRAFIK PIE (Kategori Prioritas)
    $qPrioritas = $db->table('tickets');
    if (!$isSuperAdmin) { $qPrioritas->where('lokasi', $lokasiAdmin); }
    $dataPrioritas = $qPrioritas->select('prioritas, COUNT(id) as total')->groupBy('prioritas')->get()->getResultArray();

    $prioLow = 0; $prioMedium = 0; $prioHigh = 0; $prioUrgent = 0;
    foreach($dataPrioritas as $p) {
        if($p['prioritas'] == 'Low') $prioLow = $p['total'];
        if($p['prioritas'] == 'Medium') $prioMedium = $p['total'];
        if($p['prioritas'] == 'High') $prioHigh = $p['total'];
        if($p['prioritas'] == 'Urgent') $prioUrgent = $p['total'];
    }

    // 2. DATA GRAFIK BAR (Performa Teknisi - Tiket Selesai & Closed)
    $qTeknisi = $db->table('tickets');
    $qTeknisi->select('users.nama as nama_teknisi, COUNT(tickets.id) as total_selesai')
             ->join('users', 'tickets.teknisi_id = users.id', 'left')
             ->whereIn('tickets.status', ['Resolved', 'Closed'])
             // Pastikan teknisi yang muncul di grafik juga bukan superadmin (Opsional tapi direkomendasikan)
             ->where('users.role !=', 'superadmin');
             
    if (!$isSuperAdmin) { $qTeknisi->where('tickets.lokasi', $lokasiAdmin); }
    $qTeknisi->groupBy('tickets.teknisi_id')->orderBy('total_selesai', 'DESC')->limit(5); 
    
    $dataPerforma = $qTeknisi->get()->getResultArray();
    $namaTeknisi = [];
    $totalSelesai = [];
    foreach($dataPerforma as $dp) {
        $namaTeknisi[]  = strtoupper($dp['nama_teknisi'] ?? 'Tim IT');
        $totalSelesai[] = $dp['total_selesai'];
    }
?>

<style>
    /* DESAIN KARTU STATISTIK MODERN */
    .stat-card { background: #ffffff; border: none; border-radius: 15px; box-shadow: 0 2px 15px rgba(0,0,0,0.02); position: relative; overflow: hidden; margin-bottom: 25px; }
    .stat-card-body { padding: 25px 25px 10px 25px; }
    .stat-title { font-size: 0.85rem; font-weight: 600; color: #858796; margin-bottom: 5px; }
    .stat-value { font-size: 2rem; font-weight: 800; color: #2e384d; margin-bottom: 0; }

    /* Garis Warna Atas */
    .border-top-blue { border-top: 4px solid #0d6efd; }
    .border-top-orange { border-top: 4px solid #fd7e14; }
    .border-top-red { border-top: 4px solid #e83e8c; }
    .border-top-purple { border-top: 4px solid #6f42c1; }

    .sparkline-svg { width: 100%; height: 50px; display: block; margin-top: 10px; }

    /* Container Grafik & Tabel Utama */
    .chart-container-modern { background: #ffffff; border-radius: 15px; box-shadow: 0 2px 15px rgba(0,0,0,0.02); padding: 25px; border: none; height: 100%; }
    .chart-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .chart-title { font-weight: 700; font-size: 1.1rem; color: #2e384d; margin: 0; }

    /* Kustomisasi Tabel Modern */
    .table-modern th { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 2px solid #eaecf4; padding-bottom: 15px; font-weight: 700; }
    .table-modern td { vertical-align: middle; padding: 15px 10px; color: #2e384d; font-size: 0.9rem; font-weight: 600; border-bottom: 1px solid #eaecf4; }
    .table-modern tbody tr:hover { background-color: #f8f9fc; }
</style>

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card border-top-blue">
            <div class="stat-card-body">
                <div class="stat-title">Total Tiket</div>
                <div class="stat-value"><?= esc($total_tiket ?? '0'); ?></div>
            </div>
            <svg class="sparkline-svg" preserveAspectRatio="none" viewBox="0 0 100 30"><path d="M0,20 C20,30 40,0 60,15 C80,30 100,10 100,10 L100,30 L0,30 Z" fill="rgba(13, 110, 253, 0.1)"></path><path d="M0,20 C20,30 40,0 60,15 C80,30 100,10 100,10" fill="none" stroke="#0d6efd" stroke-width="2"></path></svg>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card border-top-orange">
            <div class="stat-card-body">
                <div class="stat-title">Tiket Pending</div>
                <div class="stat-value"><?= esc($tiket_pending ?? '0'); ?></div>
            </div>
            <svg class="sparkline-svg" preserveAspectRatio="none" viewBox="0 0 100 30"><path d="M0,15 C20,5 40,25 60,10 C80,-5 100,20 100,20 L100,30 L0,30 Z" fill="rgba(253, 126, 20, 0.1)"></path><path d="M0,15 C20,5 40,25 60,10 C80,-5 100,20 100,20" fill="none" stroke="#fd7e14" stroke-width="2"></path></svg>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card border-top-red">
            <div class="stat-card-body">
                <div class="stat-title">Tiket Selesai</div>
                <div class="stat-value"><?= esc($tiket_selesai ?? '0'); ?></div>
            </div>
            <svg class="sparkline-svg" preserveAspectRatio="none" viewBox="0 0 100 30"><path d="M0,10 C15,30 35,5 55,20 C75,35 90,5 100,15 L100,30 L0,30 Z" fill="rgba(232, 62, 140, 0.1)"></path><path d="M0,10 C15,30 35,5 55,20 C75,35 90,5 100,15" fill="none" stroke="#e83e8c" stroke-width="2"></path></svg>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card border-top-purple">
            <div class="stat-card-body">
                <div class="stat-title">Total Tim IT</div>
                <div class="stat-value"><?= esc($total_tim_it ?? '0'); ?></div>
            </div>
            <svg class="sparkline-svg" preserveAspectRatio="none" viewBox="0 0 100 30"><path d="M0,25 C25,5 50,25 75,5 C85,25 100,15 100,15 L100,30 L0,30 Z" fill="rgba(111, 66, 193, 0.1)"></path><path d="M0,25 C25,5 50,25 75,5 C85,25 100,15 100,15" fill="none" stroke="#6f42c1" stroke-width="2"></path></svg>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="chart-container-modern">
            <div class="chart-header">
                <h5 class="chart-title">Kategori Tiket Prioritas</h5>
                <i class="fa-solid fa-ellipsis text-muted"></i>
            </div>
            
            <div style="height: 250px; position: relative;">
                <canvas id="prioChart"></canvas>
            </div>
            
            <div class="d-flex justify-content-center flex-wrap gap-3 mt-4">
                <div class="d-flex align-items-center gap-2"><span style="width:12px; height:12px; background:#0dcaf0; border-radius:3px;"></span> <small class="fw-bold text-muted">Low</small></div>
                <div class="d-flex align-items-center gap-2"><span style="width:12px; height:12px; background:#ffc107; border-radius:3px;"></span> <small class="fw-bold text-muted">Medium</small></div>
                <div class="d-flex align-items-center gap-2"><span style="width:12px; height:12px; background:#fd7e14; border-radius:3px;"></span> <small class="fw-bold text-muted">High</small></div>
                <div class="d-flex align-items-center gap-2"><span style="width:12px; height:12px; background:#dc3545; border-radius:3px;"></span> <small class="fw-bold text-muted">Urgent</small></div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="chart-container-modern">
            <div class="chart-header">
                <h5 class="chart-title">Performa Teknisi (Tiket Selesai)</h5>
                <i class="fa-solid fa-ellipsis text-muted"></i>
            </div>
            
            <div style="height: 300px; width: 100%; position: relative;">
                <?php if(empty($namaTeknisi)): ?>
                    <div class="d-flex align-items-center justify-content-center h-100 text-muted fw-bold">Belum ada data tiket yang diselesaikan.</div>
                <?php else: ?>
                    <canvas id="teknisiChart"></canvas>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-12">
        <div class="chart-container-modern">
            <div class="chart-header mb-4">
                <h5 class="chart-title">Tiket Selesai Dikerjakan (Terbaru)</h5>
                <a href="/admin/tickets?status=Closed" class="btn btn-sm btn-light border fw-bold text-primary px-3 rounded-pill">Lihat Semua</a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-borderless table-modern w-100">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">No Tiket</th>
                            <th width="25%">Pelapor & Departemen</th>
                            <th width="25%">Teknisi IT</th>
                            <th width="15%">Tgl Selesai</th>
                            <th width="15%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($isSuperAdmin) {
                                $tiket_terbaru = $ticketModel->select('tickets.*, users.nama as nama_teknisi')
                                             ->join('users', 'tickets.teknisi_id = users.id', 'left')
                                             ->whereIn('tickets.status', ['Resolved', 'Closed'])
                                             ->orderBy('tickets.updated_at', 'DESC')->limit(5)->findAll();
                            } else {
                                $tiket_terbaru = $ticketModel->select('tickets.*, users.nama as nama_teknisi')
                                             ->join('users', 'tickets.teknisi_id = users.id', 'left')
                                             ->where('tickets.lokasi', session('lokasi'))
                                             ->whereIn('tickets.status', ['Resolved', 'Closed'])
                                             ->orderBy('tickets.updated_at', 'DESC')->limit(5)->findAll();
                            }
                        ?>
                        <?php if(empty($tiket_terbaru)): ?>
                            <tr><td colspan="6" class="text-center text-muted py-4">Belum ada tiket yang diselesaikan.</td></tr>
                        <?php else: ?>
                            <?php $no = 1; foreach($tiket_terbaru as $t): ?>
                                <tr>
                                    <td class="text-muted"><?= $no++; ?></td>
                                    <td class="text-primary fw-bold"><?= $t['kode_tiket']; ?></td>
                                    <td>
                                        <span class="d-block fw-bold text-dark"><?= strtoupper($t['nama_pelapor']); ?></span>
                                        <small class="text-muted" style="font-size: 0.75rem;"><?= strtoupper($t['departemen']); ?></small>
                                    </td>
                                    <td class="text-dark fw-medium"><?= strtoupper($t['nama_teknisi'] ?? 'Tim IT'); ?></td>
                                    <td class="text-muted small">
                                        <?= $t['waktu_selesai'] ? date('d M Y, H:i', strtotime($t['waktu_selesai'])) : date('d M Y, H:i', strtotime($t['updated_at'])); ?>
                                    </td>
                                    <td>
                                        <?php if($t['status'] == 'Closed'): ?>
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill">Selesai (Closed)</span>
                                        <?php else: ?>
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-2 rounded-pill">Menunggu Validasi</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Inisialisasi Grafik Pie (Prioritas)
    const prioCtx = document.getElementById('prioChart');
    if(prioCtx) {
        new Chart(prioCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Low', 'Medium', 'High', 'Urgent'],
                datasets: [{
                    data: [<?= $prioLow ?>, <?= $prioMedium ?>, <?= $prioHigh ?>, <?= $prioUrgent ?>],
                    backgroundColor: ['#0dcaf0', '#ffc107', '#fd7e14', '#dc3545'],
                    borderWidth: 0,
                    hoverOffset: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%', // Ketebalan donat
                plugins: {
                    legend: { display: false }, 
                    tooltip: {
                        callbacks: {
                            label: function(context) { return ' ' + context.label + ': ' + context.raw + ' Tiket'; }
                        }
                    }
                }
            }
        });
    }

    // 2. Inisialisasi Grafik Bar (Performa Teknisi)
    const tekCtx = document.getElementById('teknisiChart');
    if(tekCtx) {
        // Menerima array dari PHP ke Javascript
        const labelTeknisi = <?= json_encode($namaTeknisi); ?>;
        const dataTeknisi = <?= json_encode($totalSelesai); ?>;

        new Chart(tekCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: labelTeknisi,
                datasets: [{
                    label: 'Tiket Diselesaikan',
                    data: dataTeknisi,
                    backgroundColor: '#6f42c1',
                    borderRadius: 6, // Sudut melengkung atas
                    barPercentage: 0.5 // Ketebalan batang
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { 
                        beginAtZero: true, 
                        ticks: { precision: 0, color: '#a1a5b7' }, // precision 0 agar tidak ada desimal
                        grid: { color: '#f1f1f4', drawBorder: false }
                    },
                    x: { 
                        ticks: { color: '#5e6278', font: { weight: 'bold' } },
                        grid: { display: false, drawBorder: false }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#2e384d',
                        padding: 10,
                        callbacks: {
                            label: function(context) { return ' Tiket Diselesaikan: ' + context.raw; }
                        }
                    }
                }
            }
        });
    }

});
</script>

<?= $this->endSection(); ?>