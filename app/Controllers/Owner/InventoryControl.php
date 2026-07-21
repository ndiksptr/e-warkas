<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductModel;
use App\Models\UsersModel;
use App\Models\InventoryModel;


class InventoryControl extends BaseController
{
    protected $ProductModel;
    protected $UsersModel;
    protected $InventoryModel;
    public function __construct()
    {
        $this->ProductModel = new ProductModel();
        $this->UsersModel = new UsersModel();
        $this->InventoryModel = new InventoryModel();
    }
    public function index()
    {
      $inventory = $this->InventoryModel
        ->select('
            inventory.*,
            products.product_name,
            users.user_name
        ')
        ->join('products', 'products.product_id = inventory.product_id', 'left')
        ->join('users', 'users.user_id = inventory.user_id', 'left')
        ->orderBy('inventory.inventory_id', 'DESC')
        ->findAll();
      // 2. Ambil produk yang HANYA stoknya <= 0 untuk dropdown input
      $product_kosong = $this->ProductModel
        ->select('product_id, product_name, stock')
        ->where('stock >', 0)
        ->findAll();
        $data = [
            'title'=>'Inventory | Owner',
            'judul'=>'Transaksi',
            'subjudul'=>'Inventory',
            'menu'=>'transaksi',
            'submenu'=>'inventory',
            'inventory' => $inventory,
            'product'=> $product_kosong
        ];
        return view('owner/pages/v_inventory',$data);
    }

    public function save(){
        $inventory_id = $this->request->getPost('inventory_id');
        $product_id = $this->request->getPost('product_id');
        $quantity_rusak = $this->request->getPost('quantity');
        $description = $this->request->getPost('description');
        $user_id = session()->get('user_id');
        $product = $this->ProductModel->find($product_id);
        if ($product['stock'] < $quantity_rusak) {
            return $this->response->setJSON(
                ['status' => false, 'msg'=>'Stok tidak cukup! Stok saat ini: ' . $product['stock']]
            );
        }
        $db = \Config\Database::connect();
        $db->transStart();
        // 1. Kurangi Stok di Tabel Products
        $this->ProductModel->update($product_id, ['stock' => $product['stock'] - $quantity_rusak]);
        // 2. Catat ke Inventory sebagai 'out' atau 'adjust'
        $this->InventoryModel->insert([
            'product_id'       => $product_id,
            'user_id'          => $user_id,
            'transaction_type' => 'out',
            'quantity'         => $quantity_rusak,
            'description'      => $description,
            'created_at'       => date('Y-m-d H:i:s')
        ]);
        $db->transComplete();
        $msg = 'Data kerusakan berhasil dicatat !!';
        return $this->response->setJSON(['status'=>true,'msg'=>$msg]);
    }
}