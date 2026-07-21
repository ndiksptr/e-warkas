<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use App\Models\RolesModel;

class UsersControl extends BaseController
{
    protected $UsersModel;
    protected $RolesModel;
    public function __construct()
    {
        $this->UsersModel = new UsersModel();
        $this->RolesModel = new RolesModel();
    }
    public function index()
    {
        $data = [
            'title'=>'Users | Owner',
            'judul'=>'Users',
            'subjudul'=>'',
            'menu'=>'users',
            'submenu'=>''
        ];
        $data['users'] = $this->UsersModel->getAll();
        $data['roles'] = $this->RolesModel->findAll();
        return view('owner/pages/v_users',$data);
    }

    // Metode untuk Tambah atau Update data (Create/Update)
    public function save()
    {
        $validation = \Config\Services::validation();
        $user_id = $this->request->getPost('user_id');
        $rules = [
            'user_name' => [
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => 'Username wajib diisi',
                    'min_length' => 'Username minimal 3 karakter'
                ]
            ],

            'user_email' => [
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'    => 'Email wajib diisi',
                    'valid_email' => 'Format email tidak valid'
                ]
            ],
            // Password dibuat 'permit_empty' jika sedang EDIT ($user_id ada)
            'password_hash' => [
                'rules'  => $user_id ? 'permit_empty|min_length[6]' : 'required|min_length[6]',
                'errors' => [
                    'required'   => 'Password wajib diisi untuk pengguna baru',
                    'min_length' => 'Password minimal 6 karakter'
                ]
            ],
            'roles_id' => [
                'rules'  => 'required|integer',
                'errors' => [
                    'required' => 'Role wajib dipilih'
                ]
            ],
            'is_active' => [
                'rules' => 'permit_empty|in_list[0,1]'
            ]
        ];

        if(!$this->validate($rules))
        {
            return $this->response->setJSON(['status'=>false,'errors'=>$this->validator->getErrors()]);
        }

        $data = [
            'user_name'     => $this->request->getPost('user_name'),
            'user_email'    => $this->request->getPost('user_email'),
            'roles_id'      => $this->request->getPost('roles_id'),
            'is_active'     => 1
        ];

        // 3. LOGIKA PASSWORD
        $inputPassword = $this->request->getPost('password_hash');
        if($user_id){
            // --- PROSES UPDATE ---
            if (!empty($inputPassword)) {
                // Jika password diisi saat edit, maka hash password baru
                $data['password_hash'] = password_hash($inputPassword, PASSWORD_DEFAULT);
            }
            // Jika password kosong, field password_hash tidak masuk ke array $data, 
            // sehingga database tetap menggunakan password yang lama.
            $this->UsersModel->update($user_id, $data);
            $msg = 'Data Berhasil diubah!';
        } else {
        // --- PROSES TAMBAH BARU ---
            $data['password_hash'] = password_hash($inputPassword, PASSWORD_DEFAULT);
            $this->UsersModel->insert($data);
            $msg = 'Data berhasil Ditambahkan!';
        }
        return $this->response->setJSON(['status'=>true,'msg'=>$msg]);
    }


  // Metode untuk mendapatkan data tunggal (untuk form edit)
    public function get($user_id = null)
    {
        $data = $this->UsersModel->find($user_id);
        return $this->response->setJSON($data);
    }

  // Metode untuk Hapus data (Delete)
    public function hapus($user_id = null)
    {
        if ($this->UsersModel->delete($user_id)) {
            return $this->response->setJSON(['status' => true, 'msg' => 'Data berhasil dihapus!']);
        } else {
            return $this->response->setJSON(['status' => false, 'msg' => 'Gagal menghapus data!']);
        }
    }
}
