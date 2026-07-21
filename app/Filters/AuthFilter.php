<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface {
   
    // app/Filters/AuthFilter.php

        public function before(RequestInterface $request, $arguments = null) {
        // $path = $request->getUri()->getPath();
        $path = trim($request->getUri()->getPath(), '/');

        // Abaikan filter untuk halaman login dan proses login
        // Tambahkan pengecekan jika path kosong (base URL)
        if ($path === 'login' || $path === 'auth/loginprocess' || $path === '') {
            return;
        }

        // 1. Cek Login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Sesi berakhir, silakan login ulang.');
        }

        $role_user = session()->get('roles_id');

        // 3. PROTEKSI OWNER (Role 1): Gak boleh masuk area Kasird
        if ($role_user == 1 && strpos($path, 'kasir') !== false) {
            return redirect()->to('/owner/dashboard')->with('error', 'Owner dilarang masuk area transaksi kasir!');
        }

        // 4. PROTEKSI KASIR (Role 2): Gak boleh masuk area Owner
        if ($role_user == 2 && strpos($path, 'owner') !== false) {
            return redirect()->to('/kasir')->with('error', 'Akses ditolak! Kasir dilarang masuk area Owner.');
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}