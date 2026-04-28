<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\TicketModel;

class AdminController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

   public function index()
    {
        $ticketModel = new \App\Models\TicketModel();
        $userModel   = new \App\Models\UserModel();

        $role   = session('role');
        $lokasi = session('lokasi');

        // LOGIKA FILTERING (SUPER ADMIN VS ADMIN PABRIK)
        if ($role == 'superadmin') {
            // Super Admin melihat semua
            $total_tiket   = $ticketModel->countAllResults();
            $tiket_pending = $ticketModel->whereIn('status', ['Open', 'On Progress'])->countAllResults();
            $tiket_selesai = $ticketModel->where('status', 'Resolved')->countAllResults();
            $total_user    = $userModel->countAllResults();

            // Data untuk Grafik (Menghitung jumlah tiket per kategori)
            $grafik_kategori = $ticketModel->select('kategori, COUNT(id) as total')->groupBy('kategori')->findAll();
            
            // Data untuk Grafik Teknisi (Menghitung siapa yang paling banyak menyelesaikan tiket)
            $grafik_teknisi = $ticketModel->select('users.nama, COUNT(tickets.id) as total')
                                          ->join('users', 'users.id = tickets.teknisi_id')
                                          ->where('tickets.status', 'Resolved')
                                          ->groupBy('tickets.teknisi_id')
                                          ->findAll();
        } else {
            // Admin Pabrik HANYA melihat data pabriknya
            $total_tiket   = $ticketModel->where('lokasi', $lokasi)->countAllResults();
            $tiket_pending = $ticketModel->where('lokasi', $lokasi)->whereIn('status', ['Open', 'On Progress'])->countAllResults();
            $tiket_selesai = $ticketModel->where('lokasi', $lokasi)->where('status', 'Resolved')->countAllResults();
            $total_user    = $userModel->where('lokasi', $lokasi)->countAllResults();

            $grafik_kategori = $ticketModel->select('kategori, COUNT(id) as total')
                                           ->where('lokasi', $lokasi)
                                           ->groupBy('kategori')->findAll();
            
            $grafik_teknisi = $ticketModel->select('users.nama, COUNT(tickets.id) as total')
                                          ->join('users', 'users.id = tickets.teknisi_id')
                                          ->where('tickets.lokasi', $lokasi)
                                          ->where('tickets.status', 'Resolved')
                                          ->groupBy('tickets.teknisi_id')
                                          ->findAll();
        }

        $data = [
            'title'           => 'Dashboard',
            'menu'            => 'dashboard',
            'total_tiket'     => $total_tiket,
            'tiket_pending'   => $tiket_pending,
            'tiket_selesai'   => $tiket_selesai,
            'total_user'      => $total_user,
            'grafik_kategori' => $grafik_kategori,
            'grafik_teknisi'  => $grafik_teknisi
        ];

        return view('admin/dashboard', $data);
    }

    // --- KELOLA USER ---
    // --- FITUR KELOLA USER (ADMIN PABRIK) ---
    public function users()
    {
        if (session('role') == 'superadmin') {
            // Tarik semua data, KECUALI yang role-nya 'teknisi'
            $users = $this->userModel->where('role !=', 'teknisi')->findAll();
        } else {
            // Tarik data sesuai lokasi pabrik, KECUALI yang role-nya 'teknisi'
            $users = $this->userModel->where('lokasi', session('lokasi'))
                                     ->where('role !=', 'teknisi')
                                     ->findAll();
        }

        $data = [
            'title' => 'Data Admin IT', 
            'menu'  => 'users', 
            'users' => $users
        ];
        
        return view('admin/users/index', $data);
    }
    public function createUser()
    {
        // CEGAH ADMIN PABRIK MENGAKSES HALAMAN INI
        if(session('role') != 'superadmin') {
            return redirect()->to('/admin/users')->with('error', 'Akses Ditolak! Hanya Super Admin yang dapat menambahkan user.');
        }

        $data = ['title' => 'Tambah User Baru', 'menu' => 'users'];
        return view('admin/users/create', $data);
    }

   public function storeUser()
    {
        if(session('role') != 'superadmin') return redirect()->to('/admin');

        $emailBaru = $this->request->getPost('email');

        // 1. CEK DULU: Apakah email sudah terdaftar di database?
        $cekEmail = $this->userModel->where('email', $emailBaru)->first();
        
        if ($cekEmail) {
            // Jika sudah ada, kembalikan ke form dan bawa pesan error
            return redirect()->back()->with('error', 'Gagal! Email <b>' . $emailBaru . '</b> sudah digunakan oleh akun lain.');
        }

        // 2. Jika email aman (belum ada), baru simpan ke database
        $this->userModel->save([
            'nama'       => $this->request->getPost('nama'),
            'email'      => $emailBaru,
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'       => $this->request->getPost('role'),
            'departemen' => $this->request->getPost('departemen'),
            'lokasi'     => $this->request->getPost('lokasi')
        ]);

        return redirect()->to('/admin/users')->with('pesan', 'Data Tim IT berhasil ditambahkan.');
    }

    // --- FITUR EDIT USER ---
    public function editUser($id)
    {
        if(session('role') != 'superadmin') return redirect()->to('/admin/users');

        $data = [
            'title' => 'Edit User',
            'menu' => 'users',
            'user' => $this->userModel->find($id)
        ];

        return view('admin/users/edit', $data);
    }

    // --- FITUR UPDATE USER ---
    public function updateUser($id)
    {
        if(session('role') != 'superadmin') return redirect()->to('/admin/users');

        $emailBaru = $this->request->getPost('email');

        // Cek apakah email sudah dipakai oleh user LAIN
        $cekEmail = $this->userModel->where('email', $emailBaru)->where('id !=', $id)->first();
        if ($cekEmail) {
            return redirect()->back()->with('error', 'Gagal! Email <b>' . $emailBaru . '</b> sudah digunakan akun lain.');
        }

        // Siapkan data untuk diupdate
        $dataUpdate = [
            'nama'       => $this->request->getPost('nama'),
            'email'      => $emailBaru,
            'role'       => $this->request->getPost('role'),
            'departemen' => $this->request->getPost('departemen'),
            'lokasi'     => $this->request->getPost('lokasi')
        ];

        // Jika password diisi, berarti ingin ganti password. Jika kosong, biarkan password lama.
        $passwordBaru = $this->request->getPost('password');
        if (!empty($passwordBaru)) {
            $dataUpdate['password'] = password_hash($passwordBaru, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $dataUpdate);

        return redirect()->to('/admin/users')->with('pesan', 'Data berhasil diperbarui.');
    }

    // --- FITUR HAPUS USER ---
    public function deleteUser($id)
    {
        if(session('role') != 'superadmin') return redirect()->to('/admin/users');

        $this->userModel->delete($id);
        return redirect()->to('/admin/users')->with('pesan', 'Data berhasil dihapus dari sistem.');
    }
    // --- KELOLA TIKET ---
   public function tickets()
    {
        $ticketModel = new \App\Models\TicketModel();
        
        // Ambil parameter dari URL
        $statusFilter  = $this->request->getGet('status');
        $searchKeyword = $this->request->getGet('search'); 
        
        $builder = $ticketModel;

        // 1. Filter Lokasi (Khusus Admin Pabrik)
        if (session('role') != 'superadmin') {
            $builder = $builder->where('lokasi', session('lokasi'));
        }

        // 2. Filter Status (Jika diklik dari sidebar)
        if (!empty($statusFilter) && strtolower($statusFilter) != 'all') {
            $builder = $builder->where('status', $statusFilter);
        }

        // 3. Filter Pencarian Kode Tiket
        if (!empty($searchKeyword)) {
            $builder = $builder->like('kode_tiket', $searchKeyword);
        }

        $data = [
            'title'   => 'Daftar Tiket Masuk',
            'menu'    => 'tickets',
            'filter'  => empty($statusFilter) ? 'all' : $statusFilter,
            'search'  => $searchKeyword, 
            'tickets' => $builder->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('admin/tickets/index', $data);
    }
   // --- FITUR KELOLA TEKNISI ---
    public function teknisi()
    {
        if(session('role') != 'superadmin') return redirect()->to('/admin/users');

        // Menangkap input pencarian dari form
        $searchKeyword = $this->request->getGet('search');
        
        // Mulai query, pastikan HANYA mengambil role teknisi
        $builder = $this->userModel->where('role', 'teknisi');

        // Logika Pencarian Ganda (Nama ATAU Lokasi Plant)
        if (!empty($searchKeyword)) {
            $builder->groupStart()
                    ->like('nama', $searchKeyword)
                    ->orLike('lokasi', $searchKeyword)
                    ->groupEnd();
        }

        $data = [
            'title'   => 'Data Teknisi Lapangan', 
            'menu'    => 'teknisi', 
            'search'  => $searchKeyword, // Kirim variabel search ke View
            'teknisi' => $builder->orderBy('id', 'DESC')->findAll()
        ];
        
        return view('admin/users/teknisi_index', $data);
    }

    // 2. Menampilkan Form Tambah Teknisi
    public function createTeknisi()
    {
        if(session('role') != 'superadmin') return redirect()->to('/admin/users');

        $data = [
            'title' => 'Tambah Teknisi Baru', 
            'menu'  => 'teknisi' 
        ];
        
        return view('admin/users/teknisi_create', $data);
    }

    // 3. Proses Menyimpan Data Teknisi
    public function storeTeknisi()
    {
        if(session('role') != 'superadmin') return redirect()->to('/admin/users');

        $nama = $this->request->getPost('nama');
        $emailDummy = strtolower(str_replace(' ', '', $nama)) . '.' . time() . '@teknisi.jmi';
        $passwordDummy = password_hash('rahasia123', PASSWORD_DEFAULT);

        $this->userModel->save([
            'nama'       => $nama,
            'email'      => $emailDummy,
            'password'   => $passwordDummy,
            'role'       => 'teknisi',
            'departemen' => $this->request->getPost('departemen'),
            'lokasi'     => $this->request->getPost('lokasi')
        ]);

        // Setelah simpan, kembali ke tabel teknisi
        return redirect()->to('/admin/teknisi')->with('pesan', 'Teknisi Lapangan berhasil ditambahkan.');
    }
    public function teknisiUpdate($id)
{
    $id = (int) $id;
    $userModel = new \App\Models\UserModel();
    
    // Pastikan data yang diupdate sesuai dengan kolom di database Anda
    $data = [
        'nama'       => $this->request->getPost('nama'),
        'lokasi'     => $this->request->getPost('lokasi'),
        'departemen' => $this->request->getPost('departemen')
    ];

    $userModel->update($id, $data);
    
    return redirect()->to(site_url('admin/teknisi'))->with('pesan', 'Data Teknisi berhasil diperbarui!');
}

    // 4. Proses Menghapus Teknisi
    public function deleteTeknisi($id)
    {
        if(session('role') != 'superadmin') return redirect()->to('/admin/users');
        $id = (int) $id;

        $this->userModel->delete($id);
        return redirect()->to('/admin/teknisi')->with('pesan', 'Data Teknisi berhasil dihapus.');
    }
    // --- FITUR LIHAT DETAIL TIKET ---
    public function showTicket($id)
    {
        $ticketModel = new TicketModel();
        
        // Gunakan method join yang baru dibuat
        $tiket = $ticketModel->getTicketWithTeknisi($id);

        if (!$tiket) {
            return redirect()->to('/admin/tickets')->with('error', 'Tiket tidak ditemukan.');
        }

        if (session('role') != 'superadmin' && $tiket['lokasi'] != session('lokasi')) {
            return redirect()->to('/admin/tickets')->with('error', 'Akses Ditolak!');
        }

        // AMBIL DAFTAR TEKNISI SESUAI LOKASI PABRIK TIKET INI
        $daftarTeknisi = $this->userModel->where('lokasi', $tiket['lokasi'])
                                         ->where('role', 'teknisi') // Pastikan role teknisi ada di DB
                                         ->findAll();

        $data = [
            'title'   => 'Detail Tiket ' . $tiket['kode_tiket'],
            'menu'    => 'tickets',
            'tiket'   => $tiket,
            'teknisi' => $daftarTeknisi // Kirim ke View
        ];

        return view('admin/tickets/show', $data);
    }

    // --- FITUR UPDATE STATUS TIKET ---
    // --- FITUR UPDATE STATUS TIKET ---
    public function updateTicketStatus($id)
    {
        $ticketModel = new \App\Models\TicketModel();
        $tiketLama   = $ticketModel->find($id);
        
        $statusBaru  = $this->request->getPost('status');
        $teknisiId   = $this->request->getPost('teknisi_id');

        $dataUpdate = [
            'status'     => $statusBaru,
            'teknisi_id' => ($teknisiId != '') ? $teknisiId : null,
            'catatan_admin'  => $this->request->getPost('catatan_admin'),
            'ganti_hardware' => $this->request->getPost('ganti_hardware'),
            'prioritas'      => $this->request->getPost('prioritas')
        ];

        // LOGIKA PENCATATAN WAKTU OTOMATIS (YANG DIPERBARUI)
        
        // 1. Jika diubah ke On Progress dan waktu_mulai masih kosong (belum pernah dikerjakan)
        if ($statusBaru == 'On Progress' && empty($tiketLama['waktu_mulai'])) {
            $dataUpdate['waktu_mulai'] = date('Y-m-d H:i:s');
        } 
        // 2. Jika diubah ke Resolved dan sebelumnya belum Resolved
        elseif ($statusBaru == 'Resolved' && $tiketLama['status'] != 'Resolved') {
            $dataUpdate['waktu_selesai'] = date('Y-m-d H:i:s');
        } 
        // 3. Jika tiket dikembalikan ke status New (Batal dikerjakan)
        elseif ($statusBaru == 'New') {
            $dataUpdate['teknisi_id'] = null;
            $dataUpdate['waktu_mulai'] = null;
            $dataUpdate['waktu_selesai'] = null;
        }

        $ticketModel->update($id, $dataUpdate);

        return redirect()->to('/admin/tickets/show/' . $id)->with('pesan', 'Status & Penugasan berhasil diperbarui.');
    }

    // FITUR LAPORAN TIKET
    // ==========================================
    // FITUR LAPORAN TIKET (UPDATE UNTUK CETAK)
    // ==========================================
    // ==========================================
    // FITUR LAPORAN TIKET (DENGAN FILTER)
    // ==========================================
    public function reports()
    {
        $ticketModel = new \App\Models\TicketModel();
        $userModel = new \App\Models\UserModel(); // Untuk mengambil data teknisi

       
        $start_date = $this->request->getGet('start_date');
        $end_date   = $this->request->getGet('end_date');
        $status     = $this->request->getGet('status');
        $prioritas  = $this->request->getGet('prioritas');  
        $teknisi_id = $this->request->getGet('teknisi_id'); 
        $kode_tiket = $this->request->getGet('kode_tiket');

        $builder = $ticketModel->select('tickets.*, users.nama as nama_teknisi')
                               ->join('users', 'tickets.teknisi_id = users.id', 'left');

        // Terapkan Filter Tanggal
        if (!empty($start_date) && !empty($end_date)) {
            $builder->where('DATE(tickets.created_at) >=', $start_date)
                    ->where('DATE(tickets.created_at) <=', $end_date);
        }

        // Terapkan Filter Status
        if (!empty($status) && $status != 'All') {
            $builder->where('tickets.status', $status);
        }

        // Terapkan Filter Prioritas (KODE BARU)
        if (!empty($prioritas) && $prioritas != 'All') {
            $builder->where('tickets.prioritas', $prioritas);
        }

        // Terapkan Filter Teknisi (KODE BARU)
        if (!empty($teknisi_id) && $teknisi_id != 'All') {
            $builder->where('tickets.teknisi_id', $teknisi_id);
        }

        // Filter lokasi untuk admin pabrik
        if (session('role') != 'superadmin') {
            $builder->where('tickets.lokasi', session('lokasi'));
        }
        if (!empty($kode_tiket)) {
    $builder->like('kode_tiket', $kode_tiket);
}

        $data = [
            'title'      => 'Laporan Tiket IT',
            'tiket'      => $builder->orderBy('tickets.id', 'DESC')->findAll(),
            'teknisi'    => $userModel->where('role', 'teknisi')->findAll(), // Kirim data teknisi ke dropdown
            'start_date' => $start_date,
            'end_date'   => $end_date,
            'status'     => $status,
            'prioritas'  => $prioritas,
            'teknisi_id' => $teknisi_id
        ];

        return view('admin/reports/index', $data);
    }
    // ==========================================
    // FITUR CEK TIKET BARU SECARA REAL-TIME
    // ==========================================
    public function getNewTicketCount()
    {
        $ticketModel = new \App\Models\TicketModel();
        
        // Hitung tiket berstatus 'New'
        $builder = $ticketModel->where('status', 'New');
        
        // Filter khusus untuk admin pabrik
        if (session('role') != 'superadmin') {
            $builder = $builder->where('lokasi', session('lokasi'));
        }
        
        $count = $builder->countAllResults();
        
        // Kembalikan data dalam format JSON
        return $this->response->setJSON(['count' => $count]);
    }
}