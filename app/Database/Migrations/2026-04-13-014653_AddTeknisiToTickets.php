<?php

namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddTeknisiToTickets extends Migration
{
    public function up()
    {
        $fields = [
            'teknisi_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'after' => 'status'],
            'waktu_mulai'    => ['type' => 'DATETIME', 'null' => true, 'after' => 'teknisi_id'],
            'waktu_selesai'  => ['type' => 'DATETIME', 'null' => true, 'after' => 'waktu_mulai'],
        ];
        $this->forge->addColumn('tickets', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tickets', ['teknisi_id', 'waktu_mulai', 'waktu_selesai']);
    }
}