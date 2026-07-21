<h3>Laporan Penjualan Tahun <?= $tahun; ?></h3>
<table border="1" cellpadding="2" cellspacing="0" width="100%">
  <thead>
    <tr style="text-align:center; font-weight:bold; background-color:#f2f2f2;">
      <th>No</th>
      <th>Bulan</th>
      <th>Omzet (Uang Masuk)</th> 
      <th>Laba Bersih (Untung)</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $no = 1; 
    $totalOmzetTahunan = 0;
    $totalLabaTahunan = 0;

    $bulanIDN = [
        '1' => 'Januari', '2' => 'Februari', '3' => 'Maret',
        '4' => 'April', '5' => 'Mei', '6' => 'Juni',
        '7' => 'Juli', '8' => 'Agustus', '9' => 'September',
        '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];

    foreach($datatahunan as $iki): 
        // Akumulasi untuk footer sesuai data database
        $totalOmzetTahunan += (float)$iki["omzet_bulanan"];
        $totalLabaTahunan += (float)$iki["laba_bersih_bulanan"];

        $angkaBulan = (int)$iki['bulan']; 
        $namaBulan = $bulanIDN[$angkaBulan];
    ?>
    <tr>
      <td align="center"><?= $no++; ?></td>
      <td align="center"><?= $namaBulan ?></td> 
      <td align="right">Rp <?= number_format($iki['omzet_bulanan'], 0, ',', '.'); ?></td>
      <td align="right">Rp <?= number_format($iki['laba_bersih_bulanan'], 0, ',', '.'); ?></td>
    </tr>
    <?php endforeach; ?>
    <tr style="background-color:#ffcccc; font-weight:bold;">
      <td colspan="2" align="center">TOTAL TAHUNAN</td>
      <td align="right">Rp <?= number_format($totalOmzetTahunan, 0, ',', '.'); ?></td>
      <td align="right">Rp <?= number_format($totalLabaTahunan, 0, ',', '.'); ?></td>
    </tr>
  </tbody>
</table>  