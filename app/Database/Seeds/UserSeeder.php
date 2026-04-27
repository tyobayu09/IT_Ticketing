<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nama'       => 'Super Administrator',
            'email'      => 'superadmin@jmi.com',
            // Password dienkripsi dengan hash agar aman
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'role'       => 'superadmin',
            'departemen' => 'IT Pusat',
            'lokasi'     => 'Pusat'
        ];

        // Masukkan data ke tabel users
        $this->db->table('users')->insert($data);
    }
}