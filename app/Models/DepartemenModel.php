<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartemenModel extends Model
{
    protected $table            = 'departemen';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama_departemen', 'lokasi_plant'];
    
    // Mengaktifkan fitur waktu otomatis
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}