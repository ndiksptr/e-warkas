  <?= $this->extend('owner/layout/v_home') ?>
  <?= $this->section('content') ?>

  <div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-2">
      <h1 class="h3 text-gray-800"><?= $subjudul; ?></h1>
      <p><?= "$judul / $subjudul"; ?></p>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="font-weight-bold text-primary m-0">
          <?= "Tabel $judul"; ?>
        </h6>
      </div>

      <div class="card-body">

        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Bulan:</label>
          <div class="col-sm-6 input-group">
            <input type="month" class="form-control" id="bulan" name="bulan">

            <div class="input-group-append">
              <button type="button" class="btn btn-primary" onclick="ViewLaporanStok()">
                <i class="fas fa-file-alt"></i> Lihat Laporan
              </button>

              <a href="<?=base_url('owner/print-Stok'); ?>" 
                class="btn btn-danger" id="btn-print" target="_blank">
                <i class="fas fa-print"></i> Print Laporan
              </a>
            </div>
          </div>
        </div>

        <hr>

        <div id="table-view">
          <!-- Table laporan muncul di sini -->
        </div>

      </div>
    </div>

  </div>

  <?= $this->endSection() ?>

  <?= $this->section('script') ?>
  <script>
  function ViewLaporanStok(){
    let bulan=$('#bulan').val();

    // ini cuman buat cek udh kepanggil apa blm
    // if (!bulan) {
    //       alert('Pilih bulan dulu');
    //       return;
    //   }

      $.ajax({
          type: "post",
          url: "<?= base_url('owner/laporan/viewlaporanstok'); ?>",
          data : {bulan:bulan},
          dataType: "json",
          success: function (response) {
              if (response.data) {
                  $('#table-view').html(response.data);
              } else {
                  $('#table-view').html('<div class="alert alert-warning">Data tidak ditemukan</div>');
              }
          },
          error: function(xhr){
              console.log(xhr.responseText);
          }
      });
      
      
    }
    $('#btn-print').on('click', function(print_stok){
  print_stok  .preventDefault();
  let bulan = $('#bulan').val();
  if(bulan){
    let url = "<?= base_url('owner/print-Stok?bulan=') ?>" + bulan;
    window.open(url, '_blank');
  } else {
    alert('Pilih Bulannya dulu ey');
  }
  });
  </script>
  <?= $this->endSection() ?>
