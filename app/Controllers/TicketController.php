<?php

namespace App\Controllers;
use App\Models\TicketModel;

class TicketController extends BaseController
{
    // Menampilkan halaman form buat tiket
    public function create()
    {
        $data = ['title' => 'Buat Tiket IT Baru'];
        $deptModel = new \App\Models\DepartemenModel();
        $data['departemen'] = $deptModel->findAll();
        
        return view('tickets/create', $data);
    }

    // Memproses data tiket baru ke database
    public function store()
    {
        $model = new TicketModel();
        
        $lokasi = $this->request->getPost('lokasi'); 
        $tahunSekarang = date('Y');                  

        // 1. Menentukan Singkatan 3 Huruf berdasarkan lokasi
        $kodePrefix = 'PST'; 
        if (strtolower($lokasi) == 'krian') {
            $kodePrefix = 'KRN';
        } elseif (strtolower($lokasi) == 'mojoagung') {
            $kodePrefix = 'MJG';
        } elseif (strtolower($lokasi) == 'batang') {
            $kodePrefix = 'BTG';
        }

        // 2. Cari tiket terakhir di lokasi pabrik tersebut
        $tiketTerakhir = $model->where('lokasi', $lokasi)
                               ->orderBy('id', 'DESC')
                               ->first();

        // 3. Logika Penomoran Otomatis & Reset Tahun
        if ($tiketTerakhir) {
            $potongan = explode('-', $tiketTerakhir['kode_tiket']);
            if (count($potongan) == 3 && $potongan[2] == $tahunSekarang) {
                $angkaTerakhir = (int) $potongan[1];
                $nomorBaru = $angkaTerakhir + 1;
            } else {
                $nomorBaru = 1;
            }
        } else {
            $nomorBaru = 1;
        }

        // 4. Gabungkan format baru (Contoh: KRN-001-2026)
        $kode_tiket = $kodePrefix . '-' . str_pad($nomorBaru, 3, '0', STR_PAD_LEFT) . '-' . $tahunSekarang;
        
        $model->save([
            'kode_tiket'   => $kode_tiket,
            'lokasi'       => $lokasi,
            'nama_pelapor' => $this->request->getPost('nama_pelapor'),
            'departemen'   => $this->request->getPost('departemen'),
            'no_wa'        => $this->request->getPost('no_wa'),
            'kategori'     => 'Umum',
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'status'       => 'New' 
            
        ]);
        // ==============================================================
        // LOGIKA PENGIRIMAN NOTIFIKASI TELEGRAM
        // ==============================================================
        $telegramToken = '8537396500:AAHAUmNhdDNoo3Fx_8h1XcRCF9JbpUp-Hg8';
        $chatIds = [
            'Krian'     => '-1003825520009  ', // ID Grup IT Krian
            'Mojoagung' => '-1003943389236', // ID Grup IT Mojoagung
            'Batang'    => '-1003990490428', // ID Grup IT Batang
        ];

       
        $targetChatId = $chatIds[$lokasi] ?? null;

        
        if ($targetChatId) {
            $pesan = " *TIKET MASUK BARU!*\n\n";
            $pesan .= "----------------------------------------\n";
            $pesan .= " *No. Tiket:* `" . $kode_tiket . "`\n";
            $pesan .= " *Lokasi:* " . strtoupper($lokasi) . "\n";
            $pesan .= " *Pelapor:* " . $this->request->getPost('nama_pelapor') . " (" . $this->request->getPost('departemen') . ")\n";
            $pesan .= " *WhatsApp:* [wa.me/" . preg_replace('/[^0-9]/', '', $this->request->getPost('no_wa')) . "](https://wa.me/" . preg_replace('/[^0-9]/', '', $this->request->getPost('no_wa')) . ")\n\n";
            $pesan .= "----------------------------------------\n";
            $pesan .= " *Kendala:*\n_" . $this->request->getPost('deskripsi') . "_\n\n";
            $pesan .= " Segera login ke sistem untuk merespon tiket ini.";

            
            $this->sendTelegramMessage($telegramToken, $targetChatId, $pesan);
        }
        // ==============================================================
        
        return redirect()->to('/tiket/buat')->with('kode_tiket_baru', $kode_tiket);
    }

    // Menampilkan halaman pencarian & hasil lacak tiket
    // Menampilkan halaman pencarian & hasil lacak tiket
   // Menampilkan halaman pencarian & hasil lacak tiket
    public function lacak()
    {
        $keyword = $this->request->getGet('keyword');
        
        $data = [
            'title' => 'Lacak Status Tiket IT'
        ];

        if (!empty($keyword)) {
            $ticketModel = new \App\Models\TicketModel();
            
            // Ambil data tiket beserta nama teknisi yang menangani (jika ada)
            $tiket = $ticketModel->select('tickets.*, users.nama as nama_teknisi')
                                 ->join('users', 'tickets.teknisi_id = users.id', 'left')
                                 ->where('kode_tiket', strtoupper($keyword))
                                 ->first();

            if ($tiket) {
                $data['tiket'] = $tiket;
                
                // =========================================================
                // LOGIKA ANTREAN YANG DISEMPURNAKAN
                // Menghitung: 
                // 1. Semua tiket yang sedang dikerjakan tim IT (On Progress)
                // 2. Ditambah tiket 'New' yang masuk LEBIH DULU (ID lebih kecil)
                // =========================================================
                $antrean = $ticketModel->where('lokasi', $tiket['lokasi'])
                                       ->groupStart()
                                           ->where('status', 'On Progress')
                                           ->orGroupStart()
                                               ->where('status', 'New')
                                               ->where('id <', $tiket['id']) // Kunci utamanya di sini
                                           ->groupEnd()
                                       ->groupEnd()
                                       ->countAllResults();
                
                $data['antrean'] = $antrean;
            }
            
            $data['keyword'] = $keyword;
        }

        return view('tickets/lacak', $data);
    }
    // Fungsi baru untuk klien memvalidasi tiket selesai
    public function konfirmasiSelesai($id)
    {
        $model = new \App\Models\TicketModel();
        $tiket = $model->find($id);

        if ($tiket) {
            // Ubah status menjadi Closed (Selesai Validasi)
            $model->update($id, ['status' => 'Closed']);
            
            // Arahkan kembali ke halaman lacak dengan pesan sukses
            return redirect()->to('/tiket/lacak?keyword=' . $tiket['kode_tiket'])->with('pesan_sukses', 'Terima kasih! Tiket Anda telah dikonfirmasi dan resmi ditutup.');
        }
        return redirect()->back();
    }
    // Fungsi Khusus untuk menembak API Telegram
    private function sendTelegramMessage($token, $chatId, $message) 
    {
        $url = "https://api.telegram.org/bot" . $token . "/sendMessage";
        
        $data = [
            'chat_id'    => $chatId,
            'text'       => $message,
            'parse_mode' => 'Markdown' // Mengizinkan format tebal (*) dan miring (_)
        ];

        // Menggunakan cURL untuk mengirim data ke Telegram
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);
    }
}