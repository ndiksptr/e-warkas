<?php
    namespace App\Controllers\Owner;

    use App\Controllers\BaseController;
    use CodeIgniter\HTTP\ResponseInterface;
    use App\Models\CategoriesModel;
    use App\Models\UnitsModel;
    use App\Models\ProductModel;
    use App\Models\SalesModel;
    use App\Models\SalesDetailModel;
    use App\Models\InventoryModel;
    use App\Models\UsersModel;

  class PenjualanControl extends BaseController
  {
    protected $CategoriesModel;
    protected $UnitsModel;
    protected $ProductModel;
    protected $SalesModel;
    protected $SalesDetailModel;
    protected $InventoryModel;
    protected $UsersModel;
    public function __construct()
    {
      $this->CategoriesModel = new CategoriesModel();
      $this->UnitsModel = new UnitsModel();
      $this->ProductModel = new ProductModel();
      $this->SalesModel = new SalesModel();
      $this->SalesDetailModel = new SalesDetailModel();
      $this->UsersModel = new UsersModel();
      $this->InventoryModel = new InventoryModel();
    }
    public function index()
    {
      $dataSales = $this->SalesModel
        ->select('sales.*, users.user_name')
        ->join('users', 'users.user_id = sales.user_id')
        ->orderBy('sales.sales_date', 'DESC')
        ->findAll();
        $data = [
          'title'=>'Transaksi | Owner',
          'judul'=>'Transaksi',
          'subjudul'=>'Penjualan',
          'menu'=>'transaksi',
          'submenu'=>'penjualan',
          'sales'=> $dataSales
        ];
        $data['users'] = $this->UsersModel->getAll();
        return view('owner/pages/v_penjualan',$data);
    }

    public function detail($sales_id)
    {
        // Melakukan double join dari SalesDetailModel
        $detailPenjualan = $this->SalesDetailModel
          ->select('sales_detail.*, products.product_name, sales.sales_date')
          ->join('products', 'products.product_id = sales_detail.product_id', 'left')
          ->join('sales', 'sales.sales_id = sales_detail.sales_id', 'left')
          ->where('sales_detail.sales_id', $sales_id)
          ->findAll();
           $data = [
              'title'=>'Transaksi | Owner',
              'judul'=>'Transaksi',
              'sales_id' => $sales_id,
              'subjudul'=>'Penjualan',
              'menu'=>'transaksi',
              'submenu'=>'penjualan'
          ];
          $data['detail']= $detailPenjualan;
          $data['product'] = $this->ProductModel->getAll();
          return view('owner/pages/v_detailPenjualan',$data);
    }

    public function savedetail()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        // Ambil nilai dari input terlebih dahulu
        $sales_id = $this->request->getPost('sales_id');
        $price = (float)$this->request->getPost('price');
        $quantity_baru = (int)$this->request->getPost('quantity');
        $product_id = $this->request->getPost('product_id');
        // Hitung subtotal
        $subtotal = $price * $quantity_baru; 
        $sales_detail_id = $this->request->getPost('sales_detail_id');
        // AMBIL USER_ID DARI TABEL sales
        $salesRow = $this->SalesModel->find($sales_id);
        $userId = $salesRow['user_id']; // Mengambil ID user pembuat nota

        if($sales_detail_id){
            // UPDATE
            $detail_lama = $this->SalesDetailModel->find($sales_detail_id);
            $quantity_lama = (int)$detail_lama['quantity'];

            $this->SalesDetailModel->update($sales_detail_id,[
                'product_id' => $product_id,
                'price'      => $price,
                'quantity'   => $quantity_baru,
                'subtotal'   => $subtotal
            ]);

            // Perbaikan Stok: Stok dikembalikan dulu ke semula, baru dikurangi qty baru (Penjualan = Stok Berkurang)
            // Rumus: Stok Sekarang + Qty Lama - Qty Baru
            $product = $this->ProductModel->find($product_id);
            $stok_fix = ($product['stock'] + $quantity_lama) - $quantity_baru;
            $this->ProductModel->update($product_id, ['stock' => $stok_fix]);

            // Log Inventory Adjust
            $selisih = $quantity_lama - $quantity_baru; // Jika qty baru lebih besar, selisih negatif (stok keluar)
            $this->InventoryModel->insert([
                'product_id'       => $product_id,
                'user_id'          => $userId,
                'transaction_type' => 'adjust',
                'quantity'         => $selisih,
                'description'      => "Edit Penjualan #$sales_id (Qty $quantity_lama -> $quantity_baru)"
            ]);
            $msg = 'Data Berhasil diubah!';
        } else {
            // --- LOGIKA INSERT ---
            $this->SalesDetailModel->insert([
                'sales_id' => $sales_id,
                'product_id'  => $product_id,
                'price'       => $price,
                'quantity'    => $quantity_baru,
                'subtotal'    => $subtotal
            ]);
            // Kurangi Stok Produk (Karena ini Penjualan/Sales)
            $product = $this->ProductModel->find($product_id);
            $this->ProductModel->update($product_id, ['stock' => $product['stock'] - $quantity_baru]);

            // Log Inventory Out
            $this->InventoryModel->insert([
                'product_id'       => $product_id,
                'user_id'          => $userId,
                'transaction_type' => 'out',
                'quantity'         => $quantity_baru,
                'description'      => "Keluar dari Penjualan Baru #$sales_id"
            ]);
            $msg = 'Data berhasil Ditambahkan!';
        }
            // --- SINKRONISASI TOTAL & KEMBALIAN ---
            // 1. Hitung total_amount baru dari semua detail nota ini
            $total_baru = $this->SalesDetailModel
                            ->where('sales_id', $sales_id)
                            ->selectSum('subtotal')
                            ->first()['subtotal'] ?? 0;
            // 2. Ambil data bayar untuk hitung kembalian baru
            $amount_paid = (float)$salesRow['amount_paid'];
            $cash_return_baru = $amount_paid - $total_baru;

            // 3. Update tabel Sales
            $this->SalesModel->update($sales_id, ['total_amount' => $total_baru,'cash_return'  => $cash_return_baru]);
            $db->transComplete(); // Selesai transaksi
            return $this->response->setJSON(['status'=>true,'msg'=>$msg]);
    }

    // Metode untuk mendapatkan data tunggal (untuk form edit)
    public function get($sales_detail_id = null)
    {
        $data = $this->SalesDetailModel->find($sales_detail_id);
        return $this->response->setJSON($data);
    }

    // // Metode untuk Hapus data (Delete)
    // public function hapusdetail($sales_detail_id = null)
    // {
    //     $db = \Config\Database::connect();
    //     $db->transStart();

    //     // 1. Ambil data detail sebelum dihapus untuk mendapatkan sales_id
    //     $detail = $this->SalesDetailModel->find($sales_detail_id);

    //     if (!$detail) {
    //         return $this->response->setJSON(['status' => false, 'msg' => 'Data tidak ditemukan!']);
    //     }
    //     $sales_id = $detail['sales_id'];
    //     $product_id  = $detail['product_id'];
    //     $quantity_hapus   = $detail['quantity'];

    //     // AMBIL USER_ID DARI TABEL PURCHASE
    //     $salesRow = $this->SalesModel->find($sales_id);
    //     $userId = $salesRow['user_id']; // Mengambil ID user pembuat nota

    //     // 1. Kurangi Stok Produk (karena pembelian dibatalkan)
    //     $productModel = $this->ProductModel->find($product_id);
    //     $this->ProductModel->update($product_id, ['stock' => $productModel['stock'] - $quantity_hapus]);

    //     // 2. Log Inventory Out (Koreksi)
    //     $this->InventoryModel->insert([
    //         'product_id'  => $product_id,
    //         'user_id'     => $userId,
    //         'transaction_type'        => 'out',
    //         'quantity'    => $quantity_hapus,
    //         'description' => "Hapus Detail Pembelian ID #$sales_id"
    //     ]);
        
    //     if ($this->SalesDetailModel->delete($sales_detail_id)) {
    //         // 3. HITUNG ULANG TOTAL SUBTOBTAL YANG TERSISA
    //          $total_baru = $this->SalesDetailModel
    //                        ->where('sales_id', $sales_id)
    //                        ->selectSum('subtotal')
    //                        ->first();
    //         // 4. UPDATE TABEL PURCHASE DENGAN TOTAL BARU
    //         // Jika semua barang dihapus, total_baru['subtotal'] akan null, maka set ke 0
    //         $this->SalesModel->update($sales_id, [
    //             'total_amount' => $total_baru['subtotal'] ?? 0
    //         ]);
    //         $db->transComplete();
    //         return $this->response->setJSON(['status' => true, 'msg' => 'Data berhasil dihapus!']);
    //     } else {
    //         return $this->response->setJSON(['status' => false, 'msg' => 'Gagal menghapus data!']);
    //     }
    // }
  }