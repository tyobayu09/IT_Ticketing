<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT', 
                'constraint'     => 11, 
                'unsigned'       => true, 
                'auto_increment' => true
            ],
            'nama'        => [
                'type'       => 'VARCHAR', 
                'constraint' => '100'
            ],
            'email'       => [
                'type'       => 'VARCHAR', 
                'constraint' => '100', 
                'unique'     => true
            ],
            'password'    => [
                'type'       => 'VARCHAR', 
                'constraint' => '255'
            ],
            'role'        => [
                'type'       => 'ENUM', 
                'constraint' => ['superadmin', 'admin', 'teknisi', 'karyawan'], 
                'default'    => 'karyawan'
            ],
            'departemen'  => [
                'type'       => 'VARCHAR', 
                'constraint' => '100', 
                'null'       => true
            ],
            'lokasi'      => [
                'type'       => 'ENUM', 
                'constraint' => ['Pusat', 'Krian', 'Mojoagung', 'Batang'], 
                'default'    => 'Pusat'
            ],
            'created_at'  => [
                'type' => 'DATETIME', 
                'null' => true
            ],
            'updated_at'  => [
                'type' => 'DATETIME', 
                'null' => true
            ],
        ]);
        
        $this->forge->addKey('id', true);
        
        // Memastikan tabel yang dibuat adalah tabel 'users'
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}