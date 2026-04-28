<?php
namespace App\Models;
use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table = 'tickets';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    
protected $allowedFields = ['kode_tiket', 'lokasi', 'nama_pelapor', 'departemen', 'no_wa', 'kategori', 'deskripsi', 'status', 'teknisi_id', 'waktu_mulai', 'waktu_selesai', 'catatan_admin', 'ganti_hardware', 'prioritas'];
    // Fungsi untuk menarik data tiket sekaligus nama teknisinya
    public function getTicketWithTeknisi($id)
    {
        return $this->select('tickets.*, users.nama as nama_teknisi')
                    ->join('users', 'users.id = tickets.teknisi_id', 'left')
                    ->where('tickets.id', $id)
                    ->first();
    }
}