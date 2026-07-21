<table class="table table-bordered table-striped">
  <thead>
    <tr class="text-center">
      <th>No</th>
      <th>Nama Produk</th>
      <th>Qty</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $no = 1;
    $totalOmzetFinal = 0;
    $totalLabaBersihFinal = 0;
    $totalQtyFinal = 0; // Tambahkan variabel penampung total Qty

    if (!empty($databulanan['produk'])):
        foreach ($databulanan['produk'] as $row):
            $totalOmzetFinal += (float)$row['total_omzet_produk'];
            $totalLabaBersihFinal += (float)$row['laba_produk'];
            $totalQtyFinal += (int)$row['total_qty']; // Jumlahkan Qty per produk
    ?>
        <tr>
          <td class="text-center"><?= $no++; ?>.</td>
          <td class="text-center"><?= $row['product_name']; ?></td>
          <td class="text-center"><?= $row['total_qty']; ?></td>
        </tr>
    <?php 
        endforeach; 
    endif; 
    ?>

    <tr>
      <td colspan="2" class="text-left text-white bg-primary">Total Produk Terjual</td>
      <td class="text-left">
        <strong><?= number_format($totalQtyFinal, 0, ',', '.'); ?> Pcs</strong>
      </td>
    </tr>

    <tr>
      <td colspan="2" class="text-left text-white bg-danger">Modal Belanja (Stok Baru)</td>
      <td class="text-left">
        Rp <?= number_format($databulanan['total_modal_awal'], 0, ',', '.'); ?>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="text-left text-white bg-danger">Omzet (Uang Masuk)</td>
      <td class="text-left">
        Rp <?= number_format($totalOmzetFinal, 0, ',', '.'); ?>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="text-left text-white bg-danger">Laba Bersih (Produk Terjual)</td>
      <td class="text-left">
        <strong>RP. <?= number_format($totalLabaBersihFinal, 0, ',', '.'); ?></strong>
      </td>
    </tr>
  </tbody>
</table>