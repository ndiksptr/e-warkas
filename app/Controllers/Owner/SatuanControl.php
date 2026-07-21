<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UnitsModel;

class SatuanControl extends BaseController
{
    protected $UnitsModel;
    public function __construct()
    {
        $this->UnitsModel = new UnitsModel();
    }
    public function index()
    {
        $data = [
            'title'=>'Satuan | Owner',
            'judul'=>'Master Data',
            'subjudul'=>'Satuan',
            'menu'=>'masterdata',
            'submenu'=>'satuan'
        ];
        $data['satuan'] = $this->UnitsModel->findAll();
        return view('owner/pages/v_satuan',$data);
    }

    // Metode untuk Tambah atau Update data (Create/Update)
    public function save()
    {
        $validation = \Config\Services::validation();
        $rules = [
            'unit_name' => [
                'rules'  => 'required|min_length[1]',
                'errors' => [
                    'required'   => 'Satuan wajib diisi',
                    'min_length' => 'Satuan minimal 1 karakter'
                ]
            ]
        ];
        
        if(!$this->validate($rules))
        {
            return $this->response->setJSON(['status'=>false,'errors'=>$this->validator->getErrors()]);
        }

        $data = [
            'unit_name'=>$this->request->getPost('unit_name')
        ];
        $unit_id = $this->request->getPost('unit_id');

        if($unit_id){
        // UPDATE
            $this->UnitsModel->update($unit_id,$data);
            $msg = 'Data Berhasil diubah!';
        } else {
        // Tambah Baru
            $this->UnitsModel->insert($data);
            $msg = 'Data berhasil Ditambahkan!';
        }

        return $this->response->setJSON(['status'=>true,'msg'=>$msg]);
    }

    // Metode untuk mendapatkan data tunggal (untuk form edit)
    public function get($unit_id = null)
    {
        $data = $this->UnitsModel->find($unit_id);
        return $this->response->setJSON($data);
    }

    // Metode untuk Hapus data (Delete)
    public function hapus($unit_id = null)
    {
        if ($this->UnitsModel->delete($unit_id)) {
            return $this->response->setJSON(['status' => true, 'msg' => 'Data berhasil dihapus!']);
        } else {
            return $this->response->setJSON(['status' => false, 'msg' => 'Gagal menghapus data!']);
        }
    }

}
