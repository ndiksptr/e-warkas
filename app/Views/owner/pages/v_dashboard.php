<?= $this->extend('owner/layout/v_home') ?>
<?= $this->section('content') ?>
<!-- container-fluid -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $judul; ?></h1>
  </div>

  <!-- Content Row -->
  <div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div
                class="text-xs font-weight-bold text-primary text-uppercase mb-1"
              >
                Total Produk
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_produk; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div
                class="text-xs font-weight-bold text-success text-uppercase mb-1"
              >
                Total Penjualan Per Bulan
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($penjualan_bulan, 0, ',', '.') ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div
                class="text-xs font-weight-bold text-info text-uppercase mb-1"
              >
                Total Keuntungan Per Minggu
              </div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                    Rp <?= number_format($keuntungan_minggu, 0, ',', '.') ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div
                class="text-xs font-weight-bold text-danger text-uppercase mb-1"
              >
                Total Pengeluaran Per Minggu
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($pengeluaran_minggu, 0, ',', '.') ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-comments fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Rekap Transaksi Keuangan</h1>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tabel Rekap</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table
          class="table table-bordered"
          id="RekapTable"
          width="100%"
          cellspacing="0"
        >
           <thead>
              <tr>
                  <th>Tanggal</th>
                  <th>ID Transaksi</th>
                  <th>Tipe</th>
                  <th>Total Amout</th>
              </tr>
          </thead>
          <tbody>
              <?php foreach($rekap_transaksi as $row): ?>
              <tr>
                  <td><?= date('d/m/Y H:i', strtotime($row['tanggal'])); ?></td>
                  <td>#<?= $row['id_transaksi'] ?></td>
                  <td>
                      <span class="badge badge-<?= $row['warna_label'] ?>">
                          <?= $row['tipe'] ?>
                      </span>
                  </td>
                  <td class="font-weight-bold text-<?= $row['warna_label'] ?>">
                      <?= $row['tipe'] == 'Pembelian' ? '-' : '+' ?> 
                      Rp <?= number_format($row['total'], 0, ',', '.') ?>
                  </td>
              </tr>
              <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<!-- JS -->
<script>
  $(document).ready(function () {
    var table = $('#RekapTable').DataTable();
  });
</script>
<?= $this->endSection() ?>