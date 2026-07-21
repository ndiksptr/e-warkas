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
        <button
          class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-2"
          id="add-btn"
        >
          Tambah Data
        </button>
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
              <th>Purchase ID</th>
              <th>Nama</th>
              <th>Tanggal Pembelian</th>
              <th>Total Harga</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($purchase as $items): ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $items['purchase_id']; ?></td>
              <td><?= $items['user_name']; ?></td>
              <td><?= $items['purchase_date']; ?></td>
              <td>Rp. <?= number_format($items['total_amount'], 0, ',', '.'); ?></td>
              <td>
                <a href="<?= base_url('detailbeli/'.$items['purchase_id']); ?>" 
                class="btn btn-sm btn-info">Detail Barang</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Start | Form Modal -->
<div
  class="modal fade"
  id="purchaseModal"
  tabindex="1"
  role="dialog"
  aria-labelledby="purchaseModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!-- modal header -->
      <div class="modal-header">
        <h5 class="modal-title" id="purchaseModalLabel">Form Pembelian</h5>
        <button
          type="button"
          class="close"
          data-dismiss="modal"
          aria-label="Close"
        >
          <span aria-hidden="true"> &times; </span>
        </button>
      </div>
      <!-- modal body -->
      <div class="modal-body">
        <form id="purchaseForm">
          <input type="hidden" name="purchase_id" id="purchase_id" />
          <input type="hidden" name="total_amount" id="total_amount" />
          <select name="user_id" id="user_id" class="form-control mb-3">
            <option value="">Nama</option>
            <?php foreach ($users as $user): ?>
              <option value="<?= $user['user_id'] ?>">
                <?= $user['user_name'] ?>
              </option>
            <?php endforeach; ?>
          </select>
            <div class="form-group">
              <label for="purchase_date">Tanggal Pembelian</label>
              <input
                type="datetime-local"
                name="purchase_date"
                id="purchase_date"
                class="form-control"
                required
              />
              <div class="invalid-feedback" id="purchase_date-error"></div>
            </div>
        </form>
      </div>
      <!-- modal footer -->
      <div class="modal-footer">
        <button
          type="submit"
          class="btn btn-primary"
          id="save-btn"
          form="purchaseForm"
        >
          Simpan
        </button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          Tutup
        </button>
      </div>
    </div>
  </div>
</div>
<!-- End | Form Modal -->
<!-- /.container-fluid -->
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<!-- JS -->
<script>
  $(document).ready(function () {
    if ($('#PurchaseTable').length === 0) {
        return;
    }
    // CSRF Token (Penting di CI4)
    var csrfName = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';

    var table = $('#PurchaseTable').DataTable();

    // 1. TAMBAH DATA (Membuka Modal)
    $('#add-btn').on('click', function() {
        $('#purchaseForm')[0].reset(); // Reset form
        $('#purchaseModalLabel').text('Tambah Data User');
        $('#purchase_id').val(''); // Pastikan ID kosong untuk operasi tambah
        $('.invalid-feedback').text('').hide(); // Bersihkan pesan error
        $('#purchaseModal').modal('show');
    });


    // 2. SIMPAN DATA (Tambah dan Edit)
    $('#purchaseForm').on('submit', function(x){
      // ... (Kode pencegahan default dan persiapan FormData)
      x.preventDefault();
      var formData = new FormData(this);
      formData.append(csrfName, csrfHash);
      
      $.ajax({
        url: "<?= site_url('owner/pembelian/save'); ?>",
        type: "POST",
        data: formData,
        dataType: "JSON",
        contentType: false,
        processData: false,
        success: function(response) {
          // Update CSRF Hash
          csrfHash = response.token;
          if (response.status) {
              $('#purchaseModal').modal('hide');
              // MENGGUNAKAN SWEETALERT2 UNTUK SUKSES
              Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: response.msg,
                confirmButtonText: 'Oke',
                confirmButtonColor: '#28a745',
                allowOutsideClick: false
              }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                  }
              }); 
            } else {
                // Validasi Gagal
                $('.invalid-feedback').text('').hide(); 
                $.each(response.errors, function(key, value) {
                  $('#' + key + '-error').text(value).show().prev().addClass('is-invalid');
                });
                // Opsional: Beri peringatan bahwa ada input yang salah
                Swal.fire({
                    icon: 'error',
                    title: 'Cek Kembali',
                    text: 'Pastikan semua form terisi dengan benar.',
                    confirmButtonText: 'Perbaiki'
                });
            }
          },
        error: function(xhr, status, error) {
            // MENGGUNAKAN SWEETALERT2 UNTUK ERROR SISTEM
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Gagal menghubungi server atau error sistem.',
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#d33'
            });
        }
      });
      // dasdasd
    });
    // Fungsi untuk memperbarui CSRF Token dari respon AJAX
    function updateCsrfToken(response) {
        // Cek jika ada token di respons (sesuai format CI4 standar)
        var tokenName = Object.keys(response).filter(key => key.length === 32)[0];
        
        if (tokenName) {
            csrfName = tokenName;
            csrfHash = response[tokenName];
        } else if (response.token) {
            // Jika Controller hanya mengirim hash dengan key 'token' (sesuai kode Anda sebelumnya)
            csrfHash = response.token; 
        }
    }
  });
</script>
<?= $this->endSection() ?>
