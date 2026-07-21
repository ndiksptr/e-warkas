<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CategoriesModel;

class KategoriControl extends BaseController
{
    protected $CategoriesModel;
    public function __construct()
    {
        $this->CategoriesModel = new CategoriesModel();
    }
    public function index()
    {
        $data = [
            'title'=>'Kategori | Owner',
            'judul'=>'Master Data',
            'subjudul'=>'Kategori',
            'menu'=>'masterdata',
            'submenu'=>'kategori'
        ];
        $data['kategori'] = $this->CategoriesModel->findAll();
        return view('owner/pages/v_kategori',$data);
    }

    // Metode untuk Tambah atau Update data (Create/Update)
    public function save()
    {
        $validation = \Config\Services::validation();
        $rules = [
            'category_name' => [
                'rules'  => 'required|min_length[1]',
                'errors' => [
                    'required'   => 'Kategori wajib diisi',
                    'min_length' => 'Kategori minimal 1 karakter'
                ]
            ]
        ];
        
        if(!$this->validate($rules))
        {
            return $this->response->setJSON(['status'=>false,'errors'=>$this->validator->getErrors()]);
        }

        $data = [
            'category_name'=>$this->request->getPost('category_name')
        ];
        $category_id = $this->request->getPost('category_id');

        if($category_id){
        // UPDATE
            $this->CategoriesModel->update($category_id,$data);
            $msg = 'Data Berhasil diubah!';
        } else {
        // Tambah Baru
            $this->CategoriesModel->insert($data);
            $msg = 'Data berhasil Ditambahkan!';
        }

        return $this->response->setJSON(['status'=>true,'msg'=>$msg]);
    }

    // Metode untuk mendapatkan data tunggal (untuk form edit)
    public function get($category_id = null)
    {
        $data = $this->CategoriesModel->find($category_id);
        return $this->response->setJSON($data);
    }

    // Metode untuk Hapus data (Delete)
    public function hapus($category_id = null)
    {
        if ($this->CategoriesModel->delete($category_id)) {
            return $this->response->setJSON(['status' => true, 'msg' => 'Data berhasil dihapus!']);
        } else {
            return $this->response->setJSON(['status' => false, 'msg' => 'Gagal menghapus data!']);
        }
    }
}
