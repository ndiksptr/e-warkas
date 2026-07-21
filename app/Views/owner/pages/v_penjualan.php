<?= $this->extend('owner/layout/v_home') ?>
<?= $this->section('content') ?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-2">
    <h1 class="h3 text-gray-800"><?= $subjudul; ?></h1>
    <p><?php echo"$judul / $subjudul"; ?></p>
  </div>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="d-sm-flex align-items-center justify-content-between m-0 p-0">
        <h6 class="font-weight-bold text-primary mb-2 p-0">
          <?php echo "Tabel $judul"; ?>
        </h6>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table
          class="table table-bordered"
          id="PurchaseTable"
          width="100%"
          cellspacing="0"
        >
          <thead>
            <tr>
              <th>No</th>
              <th>Sales ID</th>
              <th>Nama</th>
              <th>Tanggal Pembelian</th>
              <th>Total Tagihan</th>
              <th>Bayar</th>
              <th>Total Kembalian</th>
              <th>Pembayaran</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($sales as $items): ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $items['sales_id']; ?></td>
              <td><?= $items['user_name']; ?></td>
              <td><?= $items['sales_date']; ?></td>
              <td>Rp. <?= number_format($items['total_amount'], 0, ',', '.'); ?></td>
              <td>Rp. <?= number_format($items['amount_paid'], 0, ',', '.'); ?></td>
              <td>Rp. <?= number_format($items['cash_return'], 0, ',', '.'); ?></td>
              <td><?= $items['payment_method']; ?></td>
              <td>
                <a href="<?= base_url('detailjual/'.$items['sales_id']); ?>"
                class="btn btn-sm btn-info">Detail Penjualan</a>
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
    var table = $('#PurchaseTable').DataTable();
  });
</script>
<?= $this->endSection() ?>
