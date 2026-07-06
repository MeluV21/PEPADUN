<?php

namespace App\Controllers;

use App\Models\Category;

class Categories extends BaseController
{
    public function index()
    {
        $categoryModel = new Category();
        $data['categories'] = $categoryModel->orderBy('name', 'ASC')->findAll();
        $data['title'] = 'Manajemen Kategori';
        return view('categories/index', $data);
    }

    public function store()
    {
        $categoryModel = new Category();

        $rules = [
            'name'        => 'required|min_length[3]|max_length[100]',
            'description' => 'permit_empty|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Validasi gagal. Nama kategori minimal 3 karakter.')->withInput();
        }

        $categoryModel->save([
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/categories')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update($id)
    {
        $categoryModel = new Category();

        $rules = [
            'name'        => 'required|min_length[3]|max_length[100]',
            'description' => 'permit_empty|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Validasi gagal.')->withInput();
        }

        $categoryModel->update($id, [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/categories')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete($id)
    {
        $categoryModel = new Category();
        
        try {
            $categoryModel->delete($id);
            return redirect()->to('/categories')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/categories')->with('error', 'Gagal menghapus kategori. Kategori ini mungkin masih digunakan oleh data monitoring.');
        }
    }
}
