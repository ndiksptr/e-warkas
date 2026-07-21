<table class="table table-bordered table-striped">
  <thead>
    <tr class="text-center bg-light">
      <th>No</th>
      <th>Kode Barang</th>
      <th>Nama Produk</th>
      <th>Harga Jual</th>
      <th>Harga Beli</th>
      <th>Qty</th>
      <th>Total Untung Per Produk</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $no = 1; 
    $totalKeuntungan = 0; 
    $totalKejual = 0;
    foreach($dataharian as $row): 
        $untungPerItem = ($row['harga_jual'] - $row['harga_beli']) * $row['qty'];
        $totalKejual += $row['qty'];
        $totalKeuntungan += $untungPerItem;
    ?>
    <tr>
      <td class="text-center"><?= $no++; ?></td>
      <td class="text-center"><?= $row['kode_barang']; ?></td>
      <td><?= $row['nama_produk']; ?></td>
      <td class="text-right">Rp <?= number_format($row['harga_jual'], 0, ',', '.'); ?></td>
      <td class="text-right">Rp <?= number_format($row['harga_beli'], 0, ',', '.'); ?></td>
      <td class="text-center"><?= $row['qty']; ?></td>
      <td class="text-right">
        Rp <?= number_format($untungPerItem, 0, ',', '.'); ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
      <th class="text-center text-white bg-danger" colspan="6">LABA BERSIH</th>
      <th class="text-right bg-warning">
        <strong>Rp <?= number_format($totalKeuntungan, 0, ',', '.'); ?></strong>
      </th>
    </tr>
    <tr>
      <th class="text-center text-white bg-danger" colspan="6">TOTAL BARANG TERJUAL</th>
      <th class="text-right bg-warning">
        <strong><?= $totalKejual ?></strong>
      </th>
    </tr>
  </tfoot>
</table>