<h3>Laporan Penjualan Bulan <?= ucfirst($bulan) . ' ' . $tahun; ?></h3>
<table border="1" cellpadding="2" cellspacing="0" width="100%">
  <thead>
    <tr style="text-align:center; font-weight:bold; background-color:#f2f2f2;">
      <th style="width: 50px;">No</th>
      <th style="width: 310px;">Nama Produk</th>
      <th>Qty</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $no = 1; 
    $totalOmzetFinal = 0;
    $totalLabaBersihFinal = 0;
    $totalQtyFinal = 0; 

    if (!empty($databulanan['produk'])):
        foreach($databulanan['produk'] as $iki): 
            $totalOmzetFinal += (float)$iki["total_omzet_produk"];
            $totalLabaBersihFinal += (float)$iki["laba_produk"];
            $totalQtyFinal += (int)$iki['total_qty']; 
    ?>
    <tr>
      <td align="center" style="width: 50px;"><?= $no++; ?>.</td>
      <td style="padding-left: 10px; width: 310px;"><?= ucwords(strtolower($iki['product_name'])); ?></td>
      <td align="center"><?= $iki['total_qty']; ?></td>
    </tr>
    <?php 
        endforeach; 
    endif; 
    ?>

    <tr style="background-color:#e2f0fb; font-weight:bold;">
      <td colspan="2" align="right" style="padding-right: 15px;">Total Produk Terjual</td>
      <td align="right" style="padding-right: 10px;">
        <?= number_format($totalQtyFinal, 0, ',', '.'); ?> Pcs
      </td>
    </tr>

    <tr style="background-color:#ffcccc; font-weight:bold;">
      <td colspan="2" align="right" style="padding-right: 15px;">Modal Belanja (Stok)</td>
      <td align="right" style="padding-right: 10px;">
        Rp <?= number_format($databulanan['total_modal_awal'], 0, ',', '.'); ?>
      </td>
    </tr>

    <tr style="background-color:#ffcccc; font-weight:bold;">
      <td colspan="2" align="right" style="padding-right: 15px;">Omzet (Uang Masuk)</td>
      <td align="right" style="padding-right: 10px;">
        Rp <?= number_format($totalOmzetFinal, 0, ',', '.'); ?>
      </td>
    </tr>

    <tr style="background-color:#ffcccc; font-weight:bold;">
      <td colspan="2" align="right" style="padding-right: 15px;">Laba Bersih (Untung Jualan)</td>
      <td align="right" style="padding-right: 10px;">
        Rp <?= number_format($totalLabaBersihFinal, 0, ',', '.'); ?>
      </td>
    </tr>
  </tbody>
</table>