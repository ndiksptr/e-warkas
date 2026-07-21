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
            'title'    => 'Users | Owner',
            'judul'    => 'Master Data',
            'subjudul' => 'Produk',
            'menu'     => 'masterdata',
            'submenu'  => 'produk'
        ];

        $data['produk']   = $this->ProductModel->getAll();
        $data['satuan']   = $this->UnitsModel->findAll();
        $data['kategori'] = $this->CategoriesModel->findAll();

        return view('owner/pages/v_produk', $data);
    }

    //insert data + gambar
    public function store()
    {
        $request = $this->request;

        $img = $request->getFile('product_img');
        $imgName = null;

        if ($img && $img->isValid() && !$img->hasMoved()) {
            $imgName = $img->getRandomName();
            $img->move(FCPATH . 'assets/uploads', $imgName);
        }

        $data = [
            'product_name'   => $request->getPost('product_name'),
            'category_id'    => $request->getPost('category_id'),
            'unit_id'        => $request->getPost('unit_id'),
            'purchase_price' => $request->getPost('purchase_price'),
            'selling_price'  => $request->getPost('selling_price'),
            'product_img'    => $imgName,
        ];

        $this->ProductModel->insert($data);

        return redirect()->to(base_url('owner/produk'))
                         ->with('success', 'Produk berhasil ditambahkan');
    }

    //update data
    public function update($id)
    {
    $request = $this->request;

    // ambil data lama, klo mau update satu doang
    $oldData = $this->ProductModel->find($id);

    if (!$oldData) {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    // ambil file gambar
    $img = $request->getFile('product_img');
    $imgName = $oldData['product_img']; // default gambar lama

    // kalau upload gambar baru
    if ($img && $img->isValid() && !$img->hasMoved()) {
        $imgName = $img->getRandomName();
        $img->move(FCPATH . 'assets/uploads', $imgName);

        // hapus gambar lama
        if ($oldData['product_img'] && file_exists(FCPATH . 'assets/uploads/' . $oldData['product_img'])) {
            unlink(FCPATH . 'assets/uploads/' . $oldData['product_img']);
        }
    }

    // update data- cuma ganti yang diisi
    $data = [
        'product_name'   => $request->getPost('product_name')   ?: $oldData['product_name'],
        'category_id'    => $request->getPost('category_id')    ?: $oldData['category_id'],
        'unit_id'        => $request->getPost('unit_id')        ?: $oldData['unit_id'],
        'purchase_price' => $request->getPost('purchase_price') ?: $oldData['purchase_price'],
        'selling_price'  => $request->getPost('selling_price')  ?: $oldData['selling_price'],
        'product_img'    => $imgName
    ];

    $this->ProductModel->update($id, $data);

    return redirect()->to(base_url('owner/produk'))
                     ->with('success', 'Produk berhasil diupdate');
}

    //delete
    public function hapus($id)
{
    $produk = $this->ProductModel->find($id);
    if($produk && $produk['product_img']) {
        @unlink(FCPATH.'assets/uploads/'.$produk['product_img']);
    }
    $this->ProductModel->delete($id);
    return $this->response->setJSON(['status' => 'success']);
}
}
