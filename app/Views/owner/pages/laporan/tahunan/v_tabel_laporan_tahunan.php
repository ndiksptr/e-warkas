<table class="table table-bordered table-striped">
  <thead>
    <tr class="text-center bg-light">
      <th>No</th>
      <th>Bulan</th>
      <th>Omzet (Uang Masuk)</th>
      <th>Laba Bersih (Untung)</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $no = 1; 
    $totalOmzetTahunIni = 0;
    $totalLabaTahunIni = 0;

    $bulanIDN = [
        '1' => 'Januari', '2' => 'Februari', '3' => 'Maret',
        '4' => 'April', '5' => 'Mei', '6' => 'Juni',
        '7' => 'Juli', '8' => 'Agustus', '9' => 'September',
        '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];

    foreach($datatahunan as $row): 
      $totalOmzetTahunIni += (float)$row["omzet_bulanan"];
      $totalLabaTahunIni += (float)$row["laba_bersih_bulanan"];
      $namaBulan = $bulanIDN[(int)$row['bulan']];
    ?>
    <tr>
      <td class="text-center"><?= $no++; ?></td>
      <td class="text-center"><?= $namaBulan ?></td> 
      <td class="text-right">Rp <?= number_format($row['omzet_bulanan'], 0, ',', '.'); ?></td>
      <td class="text-right text-success font-weight-bold">
        Rp <?= number_format($row['laba_bersih_bulanan'], 0, ',', '.'); ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr class="font-weight-bold bg-danger">
      <td class="text-center bg-danger text-white" colspan="2">TOTAL TAHUNAN</td>
      <td class="text-right text-white">Rp <?= number_format($totalOmzetTahunIni, 0, ',', '.'); ?></td>
      <td class="text-right text-white">Rp <?= number_format($totalLabaTahunIni, 0, ',', '.'); ?></td>
    </tr>
  </tfoot>
</table>