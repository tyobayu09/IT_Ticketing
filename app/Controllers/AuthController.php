<?php

namespace App\Controllers;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        $data = ['title' => 'Login System'];
        return view('auth/login', $data);
    }

    public function process()
    {
        $session = session();
        $model = new UserModel();
        
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $ses_data = [
                    'id'         => $user['id'],
                    'nama'       => $user['nama'],
                    'role'       => $user['role'],
                    'lokasi'     => $user['lokasi'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/admin');
            } else {
                $session->setFlashdata('error', 'Password salah!');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'Email tidak ditemukan!');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}