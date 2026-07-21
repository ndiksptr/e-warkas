<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class OwnerControl extends BaseController
{
    public function index()
    {
        return view('owner/layout/v_home');
    }
}
