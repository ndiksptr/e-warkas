<?php 
namespace App\Controllers\Auth;
use App\Controllers\BaseController;
use App\Models\UsersModel;

class Auth extends BaseController {
    public function index() { 
        return view('auth/login_view'); 
    }

   // app/Controllers/Auth/Auth.php
        public function loginProcess() {
        $model = new UsersModel();
        // PERBAIKAN TYPO:
        $email = $this->request->getPost('user_email');
        $pass  = $this->request->getPost('password_hash'); 
        $user = $model->where('user_email', $email)->first();

        if ($user && password_verify($pass, $user['password_hash'])) {
            if ($user['is_active'] != 1) {
                return redirect()->back()->with('error', 'Akun tidak aktif!');
            }

            // Ambil data user lengkap (termasuk join role dari model)
            // Kita cari data spesifik user ini saja agar efisien
            $db = \Config\Database::connect();
            $userData = $db->table('users')
                        ->join('roles', 'roles.roles_id = users.roles_id')
                        ->where('users.user_id', $user['user_id'])
                        ->get()->getRowArray();
            $sessionData = [
                'user_id'    => $user['user_id'],
                'user_name'  => $user['user_name'],
                'roles_id'   => $user['roles_id'],
                'name'       => $userData['name'],
                'isLoggedIn' => true
            ];
            session()->set($sessionData);

            if (session()->get('roles_id') == 1) {
                // Role 1 ke Owner
                return redirect()->to(base_url('owner/dashboard'));
            } elseif (session()->get('roles_id') == 2) {
                // Role 2 ke Kasir
                return redirect()->to(base_url('kasir'));
            } else {
                // Jaga-jaga kalau role gak jelas
                return redirect()->to('/login')->with('error', 'Role tidak dikenali!');
            }

            // Arahkan berdasarkan angka roles_id
            // if ($sessionData['name'] == 'owner') {
            //     return redirect()->to(base_url('owner/dashboard'));
            // } else {
            //     return redirect()->to(base_url('kasir'));
            // }
        }
        return redirect()->back()->with('error', 'Email atau Password salah!');
    }

    public function logout() 
    { 
        session()->destroy(); return redirect()->to('/login'); 
    }
}