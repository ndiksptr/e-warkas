<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CategoriesModel;
use App\Models\UnitsModel;
use App\Models\ProductModel;

class ProdukControl extends BaseController
{
    protected $CategoriesModel;
    protected $UnitsModel;
    protected $ProductModel;
    public function __construct()
    {
        $this->CategoriesModel = new CategoriesModel();
        $this->UnitsModel = new UnitsModel();
        $this->ProductModel = new ProductModel();
    }
    public function index()
    {
        $data = [
            'title'=>'Users | Owner',
            'judul'=>'Master Data',
            'subjudul'=>'Produk',
            'menu'=>'masterdata',
            'submenu'=>'produk'
        ];
        $data['produk'] = $this->ProductModel->getAll();
        $data['satuan'] = $this->UnitsModel->findAll();
        $data['kategori'] = $this->CategoriesModel->findAll();

        return view('owner/pages/v_produk',$data);
    }


    // BARU SAMPE MODEL, CONTROLLER, NGETEST DI VIEW APAKAH DATA NYA KELUAR
    // DI LANJUTIN LAGI BEGO BIAR CPT SELESAI
}
