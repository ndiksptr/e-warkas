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
        <label class="col-sm-2 col-form-label">Tahun:</label>
        <div class="col-sm-6 input-group">
            <input type="number" class="form-control" id="tahun" name="tahun" min="2000" max="2099" placeholder="YYYY">


          <div class="input-group-append">
            <button type="button" class="btn btn-primary" onclick="ViewLaporanTahunan()">
              <i class="fas fa-file-alt"></i> Lihat Laporan
            </button>

            <a href="<?=base_url('owner/print-Tahunan'); ?>" 
              class="btn btn-danger" id="btn-print" target="_blank">
              <i class="fas fa-print"></i> Print Laporan
            </a>
          </div>
        </div>
      </div>

      <hr>

      <div id="table-view">
        <!-- Table laporan tahunan muncul di sini -->
      </div>

    </div>
  </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
function ViewLaporanTahunan(){
  let tahun=$('#tahun').val();
    $.ajax({
        type: "post",
        url: "<?= base_url('owner/laporan/viewlaporantahunan'); ?>",
        data : {tahun:tahun},
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
  $('#btn-print').on('click', function(print_tahunan){
print_tahunan.preventDefault();
let tahun = $('#tahun').val();
if(tahun){
  let url = "<?= base_url('owner/print-Tahunan?tahun=') ?>" + tahun;
  window.open(url, '_blank');
} else {
  alert('Pilih Tahunnya dulu ey');
}
});
</script>
<?= $this->endSection() ?>
