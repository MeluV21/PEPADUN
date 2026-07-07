<?php

namespace App\Controllers;

use App\Models\User;

class Users extends BaseController
{
    public function index()
    {
        $userModel = new User();
        $data['users'] = $userModel->orderBy('fullname', 'ASC')->findAll();
        $data['title'] = 'Manajemen Pengguna';
        return view('users/index', $data);
    }

    public function store()
    {
        $userModel = new User();

        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'fullname' => 'required|min_length[3]|max_length[100]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[admin,karyawan]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Validasi gagal. Pastikan username unik (min 3 karakter) dan password minimal 6 karakter.')->withInput();
        }

        $userModel->save([
            'username' => $this->request->getPost('username'),
            'fullname' => $this->request->getPost('fullname'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'     => $this->request->getPost('role'),
        ]);

        return redirect()->to('/users')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update($id)
    {
        $userModel = new User();

        $rules = [
            'username' => "required|min_length[3]|max_length[50]|is_unique[users.username,id,{$id}]",
            'fullname' => 'required|min_length[3]|max_length[100]',
            'password' => 'permit_empty|min_length[6]',
            'role'     => 'required|in_list[admin,karyawan]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Validasi gagal.')->withInput();
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'fullname' => $this->request->getPost('fullname'),
            'role'     => $this->request->getPost('role'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $userModel->update($id, $data);

        // Update session if editing self
        if (session()->get('id') == $id) {
            session()->set([
                'username' => $data['username'],
                'fullname' => $data['fullname'],
                'role'     => $data['role'],
            ]);
        }

        return redirect()->to('/users')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function delete($id)
    {
        $userModel = new User();

        if (session()->get('id') == $id) {
            return redirect()->to('/users')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        try {
            $userModel->delete($id);
            return redirect()->to('/users')->with('success', 'Pengguna berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/users')->with('error', 'Gagal menghapus pengguna. Pengguna ini mungkin memiliki data monitoring.');
        }
    }
}
