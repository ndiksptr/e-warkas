<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\CategoriesModel;
use App\Models\UnitsModel;
use App\Models\ProductModel;
use App\Models\LaporanModel;
use TCPDF;

class LaporanControl extends BaseController
{
    protected $CategoriesModel;
    protected $UnitsModel;
    protected $ProductModel;
    protected $LaporanModel;

    public function __construct()
    {
        $this->CategoriesModel = new CategoriesModel();
        $this->UnitsModel = new UnitsModel();
        $this->ProductModel = new ProductModel();
        $this->LaporanModel = new LaporanModel();
    }

    // ================== LAPORAN HARIAN ==================

    public function index()
    {
        $data = [
            'title'    => 'Owner | Laporan Harian',
            'judul'    => 'Laporan',
            'subjudul' => 'Laporan Harian',
            'menu'     => 'laporan',
            'submenu'  => 'laporanHarian'
        ];
        $tgl = date('Y-m-d');
        $data['dataharian'] = $this->LaporanModel->DataHarian($tgl);
        $data['tgl_sekarang'] = $tgl;

        return view('owner/pages/laporan/v_laporan_harian', $data);
    }

    public function ViewLaporanHarian()
    {
        $tglInput = $this->request->getPost('tgl');
        if (empty($tglInput)) {
            return $this->response->setJSON(['data' => '<div class="alert alert-warning">Pilih dulu tanggal yg mau dilihat</div>']);
        }

        $dataharian = $this->LaporanModel->DataHarian($tglInput);
        if (!empty($dataharian)) {
            return $this->response->setJSON([
                'data' => view('owner/pages/laporan/v_tabel_laporan_harian', ['dataharian' => $dataharian])
            ]);
        }

        return $this->response->setJSON(['data' => '<div class="alert alert-warning">Tidak ada data untuk tanggal ' . $tglInput . '</div>']);
    }

    public function printLaporanHarian()
    {
        $tgl = $this->request->getPost('tgl') ?? $this->request->getGet('tgl');
        $dataharian = $this->LaporanModel->DataHarian($tgl);

        if (empty($dataharian)) {
            return "Tidak ada data untuk tanggal $tgl";
        }

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle("Laporan Harian $tgl");
        $pdf->SetHeaderData('', 0, "Laporan Harian", "Tanggal: $tgl");
        $pdf->AddPage();

        $html = view('owner/pages/laporan/v_print_lap_harian', [
            'dataharian' => $dataharian,
            'tgl'        => $tgl
        ]);

        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output("laporan_harian_$tgl.pdf", 'I');
    }

    // ================== LAPORAN BULANAN ==================

    public function bulan()
    {
        $data = [
            'title'    => 'Owner | Laporan Bulanan',
            'judul'    => 'Laporan',
            'subjudul' => 'Laporan Bulanan',
            'menu'     => 'laporan',
            'submenu'  => 'laporanBulanan'
        ];
        $bulan = date('m');
        $tahun = date('Y');
        $data['databulanan'] = $this->LaporanModel->DataBulanan($tahun, $bulan);

        return view('owner/pages/laporan/bulanan/v_laporan_bulanan', $data);
    }

    public function ViewLaporanBulanan()
    {
        $bulanInput = $this->request->getPost('bulan');
        if (empty($bulanInput)) {
            return $this->response->setJSON(['data' => '<div class="alert alert-warning">Pilih dulu bulan yg mau dilihat</div>']);
        }

        $tahun = date('Y', strtotime($bulanInput));
        $bulan = date('m', strtotime($bulanInput));
        
        $databulanan = $this->LaporanModel->DataBulanan($tahun, $bulan);
        $bulanIDN = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        $namaBulan = $bulanIDN[$bulan];

        if (!empty($databulanan)) {
            return $this->response->setJSON([
                'data' => view('owner/pages/laporan/bulanan/v_tabel_laporan_bulanan', ['databulanan' => $databulanan])
            ]);
        }
        return $this->response->setJSON(['data' => '<div class="alert alert-warning">Tidak ada data untuk bulan ' . $namaBulan . '</div>']);
    }

    public function printLaporanBulanan()
    {
        $bulanInput = $this->request->getPost('bulan') ?? $this->request->getGet('bulan');
        $tahun = date('Y', strtotime($bulanInput));
        $bulan = date('m', strtotime($bulanInput));

        $databulanan = $this->LaporanModel->DataBulanan($tahun, $bulan);
        $bulanIDN = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        $namaBulan = $bulanIDN[$bulan];

        if (empty($databulanan)) return "Data Kosong";

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle("Laporan Bulanan $namaBulan $tahun");
        $pdf->SetHeaderData('', 0, "Laporan Bulanan", "Bulan: $namaBulan, Tahun: $tahun");
        $pdf->AddPage();

        $html = view('owner/pages/laporan/bulanan/v_print_lap_bulanan', [
            'databulanan' => $databulanan,
            'bulan'       => $namaBulan,
            'tahun'       => $tahun
        ]);

        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output("laporan_bulan_{$namaBulan}_{$tahun}.pdf", 'I');
    }

    // ================== LAPORAN TAHUNAN ==================

    public function tahun()
    {
        $data = [
            'title'    => 'Owner | Laporan Tahunan',
            'judul'    => 'Laporan',
            'subjudul' => 'Laporan Tahunan',
            'menu'     => 'laporan',
            'submenu'  => 'laporanTahunan'
        ];
        $tahun = date('Y');
        $data['datatahunan'] = $this->LaporanModel->DataTahunan($tahun);

        return view('owner/pages/laporan/tahunan/v_laporan_tahunan', $data);
    }

    public function ViewLaporanTahunan()
    {
    $tahunInput = $this->request->getPost('tahun');

    if (empty($tahunInput)) {
        return $this->response->setJSON([
            'data' => '<div class="alert alert-warning">Pilih dulu tahun yg mau dilihat</div>'
        ]);
    }
    $tahun = (int) $tahunInput;

    $datatahunan = $this->LaporanModel->DataTahunan($tahun);

    if (!empty($datatahunan)) {
        return $this->response->setJSON([
            'data' => view(
                'owner/pages/laporan/tahunan/v_tabel_laporan_tahunan',
                ['datatahunan' => $datatahunan]
            )
        ]);
    }

    return $this->response->setJSON([
        'data' => '<div class="alert alert-warning">Tidak ada data untuk tahun ' . $tahun . '</div>'
    ]);
    }

    public function printLaporanTahunan()
    {
        $tahunInput = $this->request->getPost('tahun') ?? $this->request->getGet('tahun');
        $datatahunan = $this->LaporanModel->DataTahunan($tahunInput);

        $tahun = date('Y', strtotime($tahunInput));
        $bulan = date('m', strtotime($tahunInput));
        $bulanEng = [
            '01' => 'January', '02' => 'February', '03' => 'March',
            '04' => 'April', '05' => 'May', '06' => 'June',
            '07' => 'July', '08' => 'August', '09' => 'September',
            '10' => 'October', '11' => 'November', '12' => 'December'
        ];

        $namaBulan = $bulanEng[$bulan];

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle("Laporan Tahunan $tahun");
        $pdf->SetHeaderData('', 0, "Laporan Tahunan", "Tahun: $tahun");
        $pdf->AddPage();

        $html = view('owner/pages/laporan/tahunan/v_print_lap_tahunan', [
            'datatahunan' => $datatahunan,
            'bulan'       => $namaBulan,
            'tahun'       => $tahun
        ]);

        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output("laporan_tahunan_{$tahun}.pdf", 'I');
    }

    // ================== LAPORAN STOK ==================

    public function stok()
    {
        $data = [
            'title'    => 'Owner | Laporan Stok',
            'judul'    => 'Laporan',
            'subjudul' => 'Laporan Stok',
            'menu'     => 'laporan',
            'submenu'  => 'laporanStok'
        ];
        $bulan = date('m');
        $tahun = date('Y');
        $data['datastok'] = $this->LaporanModel->DataStok($tahun, $bulan);

        return view('owner/pages/laporan/stok/v_laporan_stok', $data);
    }

    public function ViewLaporanStok()
    {
    $bulanInput = $this->request->getPost('bulan');
    if (empty($bulanInput)) {
        return $this->response->setJSON([
            'data' => '<div class="alert alert-warning">Pilih dulu data stok bulan berapa</div>'
        ]);
    }

    $tahun = date('Y', strtotime($bulanInput));
    $bulan = date('m', strtotime($bulanInput));
    
    // Ambil data dari model
    $datastok = $this->LaporanModel->DataStok($tahun, $bulan);
    
    // Nama bulan untuk pesan alert
    $bulanIDN = [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
        '04' => 'April', '05' => 'Mei', '06' => 'Juni',
        '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
        '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];
    $namaBulan = $bulanIDN[$bulan];
   
    if (!empty($datastok)) {
            return $this->response->setJSON([
                'data' => view('owner/pages/laporan/stok/v_tabel_laporan_stok', ['datastok' => $datastok])
            ]);
        }
        return $this->response->setJSON(['data' => '<div class="alert alert-warning">Tidak ada data untuk bulan ' . $namaBulan . '</div>']);
    }

    public function printLaporanStok()
    {
        $bulanInput = $this->request->getPost('bulan') ?? $this->request->getGet('bulan');
        $tahun = date('Y', strtotime($bulanInput));
        $bulan = date('m', strtotime($bulanInput));

        $datastok = $this->LaporanModel->DataStok($tahun, $bulan);

        $bulanIDN = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        $namaBulan = $bulanIDN[$bulan];


        if (empty($datastok)) return "Data Stok $namaBulan kosong";

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle("Laporan Stok $bulanInput");
        $pdf->SetHeaderData('', 0, "Laporan Stok", "Bulan: $bulanInput");
        $pdf->AddPage();

        $html = view('owner/pages/laporan/stok/v_print_lap_stok', [
            'datastok' => $datastok,
            'bulan'    => $namaBulan,
            'tahun'    => $tahun
        ]);

        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output("laporan_stok_$bulanInput.pdf", 'I');
    }
}