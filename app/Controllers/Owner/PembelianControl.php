<?php

  namespace App\Controllers\Owner;

  use App\Controllers\BaseController;
  use CodeIgniter\HTTP\ResponseInterface;
  use App\Models\PurchaseModel;
  use App\Models\PurchaseDetailModel; 
  use App\Models\InventoryModel;
  use App\Models\ProductModel;
  use App\Models\UsersModel;

  class PembelianControl extends BaseController
  {
      protected $PurchaseModel;
      protected $PurchaseDetailModel;
      protected $InventoryModel;
      protected $ProductModel;
      protected $UsersModel;

      public function __construct()
      {
          $this->PurchaseModel = new PurchaseModel();
          $this->PurchaseDetailModel = new PurchaseDetailModel();
          $this->InventoryModel = new InventoryModel();
          $this->ProductModel = new ProductModel();
          $this->UsersModel = new UsersModel();
      }
      public function index()
      {
        $dataPurchase = $this->PurchaseModel
            ->select('purchase.*, users.user_name')
            ->join('users', 'users.user_id = purchase.user_id')
            ->orderBy('purchase.purchase_date', 'DESC') // Lebih disarankan untuk laporan
            ->findAll();
          $data = [
              'title'=>'Transaksi | Owner',
              'judul'=>'Transaksi',
              'subjudul'=>'Pembelian',
              'menu'=>'transaksi',
              'submenu'=>'pembelian',
              'purchase'=> $dataPurchase
          ];
          $data['users'] = $this->UsersModel->getAll();
          return view('owner/pages/v_pembelian',$data);
      }
      // Metode untuk Tambah atau Update data (Create/Update)
      public function save()
      {
          $data = [
              'purchase_id'=>$this->request->getPost('purchase_id'),
              'user_id'=>$this->request->getPost('user_id'),
              'purchase_date'=>$this->request->getPost('purchase_date'),
              'total_amount'=>$this->request->getPost('total_amount')

          ];
          // Tambah Baru
              $this->PurchaseModel->insert($data);
              $msg = 'Data berhasil Ditambahkan!';
              return $this->response->setJSON(['status'=>true,'msg'=>$msg]);
      }
      public function detail($purchase_id)
      {
        // Melakukan double join dari PurchaseDetailModel
        $detailPembelian = $this->PurchaseDetailModel
          ->select('purchase_detail.*, products.product_name, purchase.purchase_date')
          ->join('products', 'products.product_id = purchase_detail.product_id', 'left')
          ->join('purchase', 'purchase.purchase_id = purchase_detail.purchase_id', 'left')
          ->where('purchase_detail.purchase_id', $purchase_id)
          ->findAll();
           $data = [
              'title'=>'Transaksi | Owner',
              'judul'=>'Transaksi',
              'purchase_id' => $purchase_id,
              'subjudul'=>'Pembelian',
              'menu'=>'transaksi',
              'submenu'=>'pembelian'
          ];
          $data['detail']= $detailPembelian;
          $data['product'] = $this->ProductModel->getAll();
          return view('owner/pages/v_detailPembelian',$data);
      }

    public function savedetail()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        // Ambil nilai dari input terlebih dahulu
        $purchase_id = $this->request->getPost('purchase_id');
        $price = (float)$this->request->getPost('price');
        $quantity_baru = (int)$this->request->getPost('quantity');
        $product_id = $this->request->getPost('product_id');

        // Hitung subtotal
        $subtotal = $price * $quantity_baru;

        $purchase_detail_id = $this->request->getPost('purchase_detail_id');

        // AMBIL USER_ID DARI TABEL PURCHASE
        $purchaseRow = $this->PurchaseModel->find($purchase_id);
        $userId = $purchaseRow['user_id']; // Mengambil ID user pembuat nota

        if($purchase_detail_id){
            // UPDATE
            $detail_lama = $this->PurchaseDetailModel->find($purchase_detail_id);
            $quantity_lama = (int)$detail_lama['quantity'];

            $this->PurchaseDetailModel->update($purchase_detail_id,[
                'product_id' => $product_id,
                'price'      => $price,
                'quantity'   => $quantity_baru,
                'subtotal'   => $subtotal
            ]);

            // Update Stok Produk: (Stok Sekarang - Qty Lama) + Qty Baru
            $productModel = $this->ProductModel->find($product_id);
            $stok_fix = ($productModel['stock'] - $quantity_lama) + $quantity_baru;
            $this->ProductModel->update($product_id, ['stock' => $stok_fix]);
            $msg = 'Data Berhasil diubah!';

            // Log Inventory Adjust
            $selisih = $quantity_baru - $quantity_lama;
            $this->InventoryModel->insert([
                'product_id'  => $product_id,
                'user_id'     => $userId,
                'transaction_type'        => 'adjust',
                'quantity'    => $selisih,
                'description' => "Edit Pembelian ID #$purchase_id (Qty $quantity_lama -> $quantity_baru)"
            ]);
        } else {
            // --- LOGIKA INSERT ---
            $this->PurchaseDetailModel->insert([
                'purchase_id' => $purchase_id,
                'product_id'  => $product_id,
                'price'       => $price,
                'quantity'    => $quantity_baru,
                'subtotal'    => $subtotal
            ]);
            // Tambah Stok Produk
            $product = $this->ProductModel->find($product_id);
            $this->ProductModel->update($product_id, ['stock' => $product['stock'] + $quantity_baru]);

            // Log Inventory In
            $this->InventoryModel->insert([
                'product_id'  => $product_id,
                'user_id'     => $userId,
                'transaction_type'        => 'in',
                'quantity'    => $quantity_baru,
                'description' => "Masuk dari Pembelian ID #$purchase_id"
            ]);
            $msg = 'Data berhasil Ditambahkan!';
        }
        // HITUNG ULANG TOTAL AMOUNT UNTUK TABEL PURCHASE
        // Ambil semua subtotal yang memiliki purchase_id yang sama
        $total_baru = $this->PurchaseDetailModel
                        ->where('purchase_id', $purchase_id)
                        ->selectSum('subtotal')
                        ->first();

        // 4. UPDATE TABEL PURCHASE
        $this->PurchaseModel->update($purchase_id, [
            'total_amount' => $total_baru['subtotal']
        ]);
        $db->transComplete(); // Selesai transaksi
        return $this->response->setJSON(['status'=>true,'msg'=>$msg]);
    }
    // Metode untuk mendapatkan data tunggal (untuk form edit)
    public function get($purchase_detail_id = null)
    {
        $data = $this->PurchaseDetailModel->find($purchase_detail_id);
        return $this->response->setJSON($data);
    }

    // Metode untuk Hapus data (Delete)
    public function hapusdetail($purchase_detail_id = null)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Ambil data detail sebelum dihapus untuk mendapatkan purchase_id
        $detail = $this->PurchaseDetailModel->find($purchase_detail_id);

        if (!$detail) {
            return $this->response->setJSON(['status' => false, 'msg' => 'Data tidak ditemukan!']);
        }
        $purchase_id = $detail['purchase_id'];
        $product_id  = $detail['product_id'];
        $quantity_hapus   = $detail['quantity'];

        // AMBIL USER_ID DARI TABEL PURCHASE
        $purchaseRow = $this->PurchaseModel->find($purchase_id);
        $userId = $purchaseRow['user_id']; // Mengambil ID user pembuat nota

        // 1. Kurangi Stok Produk (karena pembelian dibatalkan)
        $productModel = $this->ProductModel->find($product_id);
        $this->ProductModel->update($product_id, ['stock' => $productModel['stock'] - $quantity_hapus]);

        // 2. Log Inventory Out (Koreksi)
        $this->InventoryModel->insert([
            'product_id'  => $product_id,
            'user_id'     => $userId,
            'transaction_type'        => 'out',
            'quantity'    => $quantity_hapus,
            'description' => "Hapus Detail Pembelian ID #$purchase_id"
        ]);
        
        if ($this->PurchaseDetailModel->delete($purchase_detail_id)) {
            // 3. HITUNG ULANG TOTAL SUBTOBTAL YANG TERSISA
             $total_baru = $this->PurchaseDetailModel
                           ->where('purchase_id', $purchase_id)
                           ->selectSum('subtotal')
                           ->first();
            // 4. UPDATE TABEL PURCHASE DENGAN TOTAL BARU
            // Jika semua barang dihapus, total_baru['subtotal'] akan null, maka set ke 0
            $this->PurchaseModel->update($purchase_id, [
                'total_amount' => $total_baru['subtotal'] ?? 0
            ]);
            $db->transComplete();
            return $this->response->setJSON(['status' => true, 'msg' => 'Data berhasil dihapus!']);
        } else {
            return $this->response->setJSON(['status' => false, 'msg' => 'Gagal menghapus data!']);
        }
    }
  }