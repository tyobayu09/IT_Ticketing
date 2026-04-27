<?php

namespace App\Controllers;

use App\Models\DepartemenModel;

class DepartemenController extends BaseController
{
    protected $departemenModel;

    public function __construct()
    {
        $this->departemenModel = new DepartemenModel();
    }

    // 1. Menampilkan Halaman Kelola Divisi (Dengan Fitur Pencarian)
    public function index()
    {
        // Pastikan hanya Super Admin yang bisa mengakses
        if (session('role') != 'superadmin') {
            return redirect()->to('/admin')->with('pesan_error', 'Akses Ditolak!');
        }

        // Menangkap kata kunci pencarian dari form (jika ada)
        $searchKeyword = $this->request->getGet('search');
        
        $builder = $this->departemenModel;

        // Logika Pencarian Ganda (Bisa mencari berdasarkan Nama Divisi ATAU Lokasi Plant)
        if (!empty($searchKeyword)) {
            $builder = $builder->groupStart()
                               ->like('nama_departemen', $searchKeyword)
                               ->orLike('lokasi_plant', $searchKeyword)
                               ->groupEnd();
        }

        $data = [
            'title'      => 'Kelola Divisi',
            'search'     => $searchKeyword, // Mengirim kata kunci ke View agar tetap tampil di input
            'departemen' => $builder->orderBy('lokasi_plant', 'ASC')->findAll()
        ];

        return view('admin/departemen/index', $data);
    }

    // 2. Menyimpan Data Divisi Baru
    public function store()
    {
        $this->departemenModel->save([
            'nama_departemen' => $this->request->getPost('nama_departemen'),
            'lokasi_plant'    => $this->request->getPost('lokasi_plant')
        ]);

        return redirect()->to('/admin/departemen')->with('pesan', 'Divisi/Departemen baru berhasil ditambahkan!');
    }

    // 3. Memperbarui Data Divisi
    public function update($id)
    {
        $this->departemenModel->update($id, [
            'nama_departemen' => $this->request->getPost('nama_departemen'),
            'lokasi_plant'    => $this->request->getPost('lokasi_plant')
        ]);

        return redirect()->to('/admin/departemen')->with('pesan', 'Data Divisi/Departemen berhasil diperbarui!');
    }

    // 4. Menghapus Data Divisi
    public function delete($id)
    {
        $this->departemenModel->delete($id);
        return redirect()->to('/admin/departemen')->with('pesan', 'Divisi/Departemen berhasil dihapus!');
    }
}