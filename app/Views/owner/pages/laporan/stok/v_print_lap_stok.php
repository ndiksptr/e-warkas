<h3>Laporan Stok - <?= $bulan. ' ' . $tahun; ?></h3>
<table border="1" cellpadding="5" cellspacing="0" width="100%" style="border-collapse: collapse;">
  <thead>
    <tr style="text-align:center; font-weight:bold; background-color:#f2f2f2;">
      <th>No</th> 
      <th>Nama</th>
      <th>Harga</th>
      <th>Kategori</th>
      <th>Stock</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1; 
      foreach($datastok as $iki): 
    ?>
    <tr>
      <td align="center"><?= $no++; ?></td>
      <td><?= $iki['product_name']; ?></td>
      <td align="left">Rp. <?= number_format($iki['selling_price'], 0, ',', '.'); ?></td>
      <td><?= $iki['category_name']; ?></td>
      <td align="center" style="font-weight: bold;"><?= $iki['stock']; ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>