<?php

namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode_tiket'   => ['type' => 'VARCHAR', 'constraint' => '50'],
            'lokasi'       => ['type' => 'ENUM', 'constraint' => ['Pusat', 'Krian', 'Mojoagung', 'Batang']],
            'nama_pelapor' => ['type' => 'VARCHAR', 'constraint' => '100'],
            'departemen'   => ['type' => 'VARCHAR', 'constraint' => '100'],
            'no_wa'        => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true], 
            'kategori'     => ['type' => 'VARCHAR', 'constraint' => '100', 'default' => 'Umum'],
            'deskripsi'    => ['type' => 'TEXT'],
            'status'       => ['type' => 'ENUM', 'constraint' => ['Open', 'On Progress', 'Resolved', 'Closed'], 'default' => 'Open'],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tickets');
    }

    public function down() { $this->forge->dropTable('tickets'); }
}