<h3>Laporan Harian - <?= $tgl; ?></h3>
<table border="1" cellpadding="2" cellspacing="0" width="100%">
  <thead>
    <tr style="text-align:center; font-weight:bold; background-color:#f2f2f2;">
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
    <?php $no=1; 
    $totalKeuntungan=0; 
    $totalTerjual = 0;
    foreach($dataharian as $iki): 
      $untungPerItem  = ($iki['harga_jual'] - $iki['harga_beli']) * $iki['qty'];
      $totalKeuntungan += $untungPerItem;
      $totalTerjual += $iki['qty'];
    ?>
    <tr>
      <td align="center"><?= $no++; ?></td>
      <td><?= $iki['kode_barang']; ?></td>
      <td><?= $iki['nama_produk']; ?></td>
       <td align="right"><?= number_format($iki['harga_jual']); ?></td>
      <td align="right"><?= number_format($iki['harga_beli']); ?></td>
      <td align="center"><?= $iki['qty']; ?></td>
      <td align="right"><?= number_format($untungPerItem); ?></td>
    </tr>
    <?php endforeach; ?>
    <tr style="background-color:#ffcccc; font-weight:bold;">
      <td colspan="6" align="center">LABA BERSIH</td>
      <td colspan="2" align="right"><?= number_format($totalKeuntungan); ?></td>
    </tr>
    <tr style="background-color:#ffcccc; font-weight:bold;">
      <td colspan="6" align="center">TOTAL BARANG TERJUAL</td>
      <td colspan="2" align="right"><?= number_format($totalTerjual); ?></td>
    </tr>
  </tbody>
</table>