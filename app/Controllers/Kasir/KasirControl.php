<?php
    namespace App\Controllers\Kasir;

    use App\Controllers\BaseController;
    use CodeIgniter\HTTP\ResponseInterface;
    use App\Models\CategoriesModel;
    use App\Models\UnitsModel;
    use App\Models\ProductModel;
    use App\Models\SalesModel;
    use App\Models\SalesDetailModel;
    use App\Models\InventoryModel;

    class KasirControl extends BaseController
    {
        protected $CategoriesModel;
        protected $UnitsModel;
        protected $ProductModel;
        protected $SalesModel;
        protected $SalesDetailModel;
        protected $InventoryModel;
        public function __construct()
        {
            $this->CategoriesModel = new CategoriesModel();
            $this->UnitsModel = new UnitsModel();
            $this->ProductModel = new ProductModel();
            $this->SalesModel = new SalesModel();
            $this->SalesDetailModel = new SalesDetailModel();
            $this->InventoryModel = new InventoryModel();
        }
        public function index()
        {
            $keyword = $this->request->getGet('keyword');

            if ($keyword) {
                $produk = $this->ProductModel->search($keyword);
            } else {
                $produk = $this->ProductModel->getAll();
            }

            // Generate Nomor Otomatis (Format: YYYYMMDD + Urutan)
            $tanggal = date('Ymd');
            $lastTransaction = $this->SalesModel
            ->where('DATE(sales_date)', date('Y-m-d'))
            ->orderBy('sales_id', 'DESC')
            ->first();

            if ($lastTransaction) {
                $lastNoStr = (string)$lastTransaction['sales_id'];
                $lastOrder = substr($lastNoStr, 8); // Ambil angka setelah tanggal
                $nextOrder = (int)$lastOrder + 1;
            } else {
                $nextOrder = 1;
            }

            $no_penjualan_otomatis = $tanggal . $nextOrder;

            $data = [
                'title'    => 'Dashboard | Owner',
                'judul'    => 'Dashboard',
                'subjudul' => '',
                'menu'     => 'dashboard',
                'submenu'  => '',
                'produk'   => $produk,
                'kategori' => $this->CategoriesModel->findAll(),
                'keyword'  => $keyword,
                'cart'     =>\Config\Services::cart(),
                'no_penjualan' => $no_penjualan_otomatis
            ];
            helper('form');
            helper('number');
            return view('kasir/layout/v_kasir', $data);
        }
        // CRUD CART
        public function cek()
        {
            $cart = \Config\Services::cart();
            $response = $cart->contents();
            $data = json_encode($response);
            echo '<pre>';
            print_r($data);
            echo '</pre>';
        }
        public function add()
        {
            $cart = \Config\Services::cart();

            $cart->insert([
                'id'    => $this->request->getPost('product_id'),
                'qty'   => 1,
                'price' => $this->request->getPost('selling_price'),
                'name'  => $this->request->getPost('product_name'),
                'options' => [
                    'category_id'    => $this->request->getPost('category_id'),
                    'unit_id'        => $this->request->getPost('unit_id'),
                    'purchase_price' => $this->request->getPost('purchase_price'),
                    'product_img'    => $this->request->getPost('product_img')
                ]
            ]);

            return redirect()->to(base_url('kasir'));
        }
        public function clear(){
            $cart = \Config\Services::cart();
            // Clear the shopping cart
            $cart->destroy();
        }
        public function update()
        {
            $cart = \Config\Services::cart();
            $no = 1;
            foreach($cart->contents() as $items){
                $cart->update(array(
                    'rowid'=>$items['rowid'],
                    'qty'  => $this->request->getPost('qty'.$no++)
                ));
            }
            return redirect()->to('kasir');
        }
        public function delete($rowid)
        {
            $cart = \Config\Services::cart();
            // Remove an item using its `rowid`
            $cart->remove($rowid);
            return redirect()->to('kasir');
        }

        public function checkout()
        {
            $cart = \Config\Services::cart();
            $contents = $cart->contents();

            if (empty($contents)) {
                return redirect()->to('kasir')->with('error', 'Keranjang masih kosong!');
            }

            $sales_id = $this->request->getPost('sales_id');
    
            // Validasi: Jika sales_id kosong, hentikan proses
            if (empty($sales_id)) {
                return redirect()->to('kasir')->with('error', 'Nomor Penjualan tidak terdeteksi!');
            }

            $db = \Config\Database::connect();

            // --- VALIDASI STOK SEBELUM TRANSAKSI MULAI ---
            foreach ($contents as $items) {
                $product = $this->ProductModel->find($items['id']);
                
                // Cek apakah stok mencukupi
                if ($product['stock'] < $items['qty']) {
                    return redirect()->to('kasir')->with('error', 
                        'Gagal! Stok ' . $items['name'] . ' tidak mencukupi. (Tersedia: ' . $product['stock'] . ')'
                    );
                }
            }
            $db->transStart(); // Proteksi transaksi database

            // 1. Ambil data dari form (Hidden input atau post)
            // $sales_id = $this->request->getPost('sales_id'); 
            $bayar = $this->request->getPost('bayar');
            if ($bayar === null || $bayar === '') {
                return redirect()->to('kasir')->with('error', 'Masukkan jumlah bayar!');
            }
            $bayar = (float)$bayar;
            $total    = (float)$cart->total();

            // Validasi: Uang harus pas atau lebih
            if ($bayar < $total) {
                return redirect()->to('kasir')->with('error', 
                    'Gagal! Uang bayar (Rp ' . number_format($bayar, 0, ',', '.') . 
                    ') kurang dari total tagihan (Rp ' . number_format($total, 0, ',', '.') . ')'
                );
            }
            $kembali  = $bayar - $total;
            $user_id = session()->get('user_id');
            date_default_timezone_set('Asia/Jakarta');

            // 2. Simpan ke tabel SALES
            $dataSales = [
                'sales_id'       => $sales_id,
                'user_id'        => $user_id,
                'sales_date'     => date('Y-m-d H:i:s'),
                'total_amount'   => $total,
                'amount_paid'    => $bayar,
                'cash_return'    => $kembali,
                'payment_method' => 'cash'
            ];
            $this->SalesModel->insert($dataSales);

            foreach ($contents as $items) {
            // Ambil purchase_price dari dalam array 'options' yang kamu buat di fungsi add()
            $purchase_price = isset($items['options']['purchase_price']) ? $items['options']['purchase_price'] : 0;
                // A. Simpan Sales Detail
                $this->SalesDetailModel->insert([
                    'sales_id'   => $sales_id,
                    'product_id' => $items['id'],
                    'current_capital'=> $purchase_price,
                    'price'      => $items['price'],
                    'quantity'   => $items['qty'],
                    'subtotal'   => $items['subtotal']
                ]);

                // B. Update Stok di tabel Products
                $product = $this->ProductModel->find($items['id']);
                $newStock = $product['stock'] - $items['qty'];
                $this->ProductModel->update($items['id'], ['stock' => $newStock]);

                // C. Catat di Inventory (Stock Out)
                $this->InventoryModel->insert([
                    'product_id'       => $items['id'],
                    'user_id'          => $user_id,
                    'transaction_type' => 'out',
                    'quantity'         => $items['qty'],
                    'description'      => "Penjualan Kasir Nota #$sales_id",
                    'created_at'       => date('Y-m-d H:i:s')
                ]);
            }

            $db->transComplete(); // Selesai transaksi

            if ($db->transStatus() === FALSE) {
                $dbError = $db->error();
                // Tambahkan ['message'] agar yang dikirim adalah STRING pesan errornya, bukan ARRAY
                return redirect()->to('kasir')->with('error', 'DB Error: ' . $dbError['message']);
            } else {
                $cart->destroy(); // Kosongkan keranjang jika berhasil
                return redirect()->to('kasir')->with('success', 'Transaksi Berhasil! Nota: ' . $sales_id);
            }
        }

    }
