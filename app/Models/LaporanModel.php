<?php 
namespace App\Models;
use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table = 'sales';

    public function DataHarian($tgl)
{
    return $this->db->table('sales_detail')
        ->select('
            sales.sales_date,
            products.product_id as kode_barang, 
            products.product_name as nama_produk, 
            sales_detail.price as harga_jual, 
            
            sales_detail.current_capital as harga_beli, 
            
            sales_detail.quantity as qty
        ')
        ->join('sales', 'sales.sales_id = sales_detail.sales_id')
        ->join('products', 'products.product_id = sales_detail.product_id')
        ->where('DATE(sales.sales_date)', $tgl)
        ->get()
        ->getResultArray();
}




  public function DataBulanan($tahun, $bulan)
{
    // 1. Ambil rincian produk + Laba Kotor per produk (Harga Jual - Modal)
    $penjualan = $this->db->table('sales')
        ->select('
            products.product_id, 
            products.product_name, 
            SUM(sales_detail.quantity) as total_qty, 
            SUM(sales_detail.subtotal) as total_omzet_produk,
            
            -- laba kotor per produk
            SUM((sales_detail.price - sales_detail.current_capital) * sales_detail.quantity) as laba_produk
        ')
        ->join('sales_detail', 'sales_detail.sales_id = sales.sales_id')
        ->join('products', 'products.product_id = sales_detail.product_id')
        ->where('YEAR(sales.sales_date)', $tahun)
        ->where('MONTH(sales.sales_date)', $bulan)
        ->groupBy('products.product_id')
        ->get()->getResultArray();

    // 2. Ambil Total Belanja Stok (Modal Awal) dari tabel purchase
    $modal = $this->db->table('purchase')
        ->selectSum('total_amount', 'total_belanja')
        ->where('YEAR(purchase_date)', $tahun)
        ->where('MONTH(purchase_date)', $bulan)
        ->get()->getRowArray();

    $total_modal_belanja = $modal['total_belanja'] ?? 0;

    // 3. SUM semua laba produk untuk dapet Total Laba Kotor
    $total_laba_produk = 0;
    foreach ($penjualan as $p) {
        $total_laba_produk += $p['laba_produk'];
    }

    // 4. Hitung Laba Bersih: Total Laba Produk - Modal
    $laba_bersih_final = $total_laba_produk - $total_modal_belanja;

    return [
        'produk'            => $penjualan,
        'total_modal_awal'  => $total_modal_belanja,
        'total_laba_produk' => $total_laba_produk,
        'laba_bersih_final' => $laba_bersih_final
    ];
}
    public function DataTahunan($tahun)
{
    return $this->db->table('sales')
        ->select('
            MONTH(sales.sales_date) as bulan, 
            COUNT(DISTINCT sales.sales_id) as total_transaksi,  
            SUM(sales_detail.subtotal) as omzet_bulanan, 
    
            SUM((sales_detail.price - sales_detail.current_capital) * sales_detail.quantity) as laba_bersih_bulanan
        ')
        ->join('sales_detail', 'sales_detail.sales_id = sales.sales_id')
        ->where('YEAR(sales.sales_date)', $tahun)
        ->groupBy('MONTH(sales.sales_date)')
        ->orderBy('MONTH(sales.sales_date)', 'ASC')
        ->get()
        ->getResultArray();
}

public function DataStok($tahun, $bulan)
{
    // Batas akhir bulan yang dipilih
    $lastDateOfMonth = date("Y-m-t 23:59:59", strtotime("$tahun-$bulan-01"));

    return $this->db->table('products p')
        ->select('p.product_name, p.selling_price, c.category_name')
        ->join('categories c', 'c.category_id = p.category_id', 'left')
        // Menjumlahkan semua riwayat IN dikurangi OUT sampai akhir bulan tersebut
        ->select("IFNULL((
            SELECT SUM(CASE 
                WHEN transaction_type = 'in' THEN quantity 
                WHEN transaction_type = 'out' THEN -quantity 
                WHEN transaction_type = 'adjust' THEN quantity
                ELSE 0 
            END)
            FROM inventory i
            WHERE i.product_id = p.product_id 
            AND i.created_at <= '$lastDateOfMonth'
        ), 0) AS stock")
        ->get()
        ->getResultArray();
}
}