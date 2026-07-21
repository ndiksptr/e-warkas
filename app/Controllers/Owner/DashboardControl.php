<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardControl extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // 1. Total Produk: Menghitung semua baris di tabel 'products'
        $totalProduk = $db->table('products')->countAllResults();

        // 2. Total Penjualan Per Bulan: Menggunakan field 'total_amount' dari tabel 'sales'
        $totalPenjualanBulan = $db->table('sales')
            ->where('MONTH(sales_date)', date('m'))
            ->where('YEAR(sales_date)', date('Y'))
            ->selectSum('total_amount')
            ->get()->getRow()->total_amount;

        // Menentukan rentang waktu minggu ini
        $startOfWeek = date('Y-m-d 00:00:00', strtotime('monday this week'));
        $endOfWeek   = date('Y-m-d 23:59:59', strtotime('sunday this week'));

        // 3. Total Keuntungan Per Minggu: (price - purchase_price) * quantity
        $keuntunganMinggu = $db->table('sales_detail') // Tabel detail transaksi
            ->join('sales', 'sales.sales_id = sales_detail.sales_id')
            ->join('products', 'products.product_id = sales_detail.product_id')
            ->where('sales.sales_date >=', $startOfWeek)
            ->where('sales.sales_date <=', $endOfWeek)
            // Rumus profit: harga jual di detail dikurangi harga beli di master produk
            ->select('SUM((sales_detail.price - products.purchase_price) * sales_detail.quantity) as profit')
            ->get()->getRow()->profit;

        // 4. Total Pengeluaran Per Minggu: Dari tabel 'purchase' (pembelian stok)
        $pengeluaranMinggu = $db->table('purchase')
            ->where('purchase_date >=', $startOfWeek)
            ->where('purchase_date <=', $endOfWeek)
            ->selectSum('total_amount') // Field total dari pembelian
            ->get()->getRow()->total_amount;

        // Query Union untuk menggabungkan Sales (Penjualan) dan Purchase (Pembelian)
        // Kita buat label 'tipe' untuk membedakan di View nanti
        $sql = "
            SELECT * FROM (
                SELECT 
                    sales_id AS id_transaksi, 
                    sales_date AS tanggal, 
                    total_amount AS total, 
                    'Penjualan' AS tipe,
                    'success' AS warna_label
                FROM sales
                
                UNION ALL
                
                SELECT 
                    purchase_id AS id_transaksi, 
                    purchase_date AS tanggal, 
                    total_amount AS total, 
                    'Pembelian' AS tipe,
                    'danger' AS warna_label
                FROM purchase
            ) AS gabungan 
            ORDER BY tanggal DESC 
            LIMIT 10";

        $rekapGabungan = $db->query($sql)->getResultArray();

        $data = [
            'title'=>'Dashboard | Owner',
            'judul'=>'Dashboard',
            'subjudul'=>'',
            'menu'=>'dashboard',
            'submenu'=>'',
            'total_produk'      => $totalProduk,
            'penjualan_bulan'   => $totalPenjualanBulan ?? 0,
            'keuntungan_minggu' => $keuntunganMinggu ?? 0,
            'pengeluaran_minggu'=> $pengeluaranMinggu ?? 0,
            'rekap_transaksi' => $rekapGabungan
        ];
        return view('owner/pages/v_dashboard',$data);
    }
}
