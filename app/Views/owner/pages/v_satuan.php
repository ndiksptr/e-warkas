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
        <h6 class="font-weight-bold text-primary m-0 p-0">
          <?php echo "Tabel $judul"; ?>
        </h6>
        <button
          class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
          id="add-btn">Tambah Data
        </button>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table
          class="table table-bordered"
          id="SatuanTable"
          width="100%"
          cellspacing="0"
        >
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Satuan</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($satuan as $items): ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $items['unit_name']; ?></td>
              <td>
                <a href="javascript:void(0)" class="btn btn-sm btn-warning edit-btn" 
                data-satuan-id="<?= $items['unit_id']; ?>">Edit</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-danger delete-btn" 
                data-satuan-id="<?= $items['unit_id']; ?>">Hapus</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

    <!-- Start | Form Modal -->
  <div
    class="modal fade"
    id="satuanModal"
    tabindex="1"
    role="dialog"
    aria-labelledby="satuanModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <!-- modal header -->
        <div class="modal-header">
          <h5 class="modal-title" id="satuanModalLabel">Form Satuan</h5>
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
          <form id="satuanForm">
            <input type="hidden" name="unit_id" id="unit_id" />
            <div class="form-group">
              <label for="unit_name">Nama Satuan</label>
              <input
                type="text"
                name="unit_name"
                id="unit_name"
                class="form-control"
                required
              />
              <div class="invalid-feedback" id="unit_name-error"></div>
            </div>
          </form>
        </div>
        <!-- modal footer -->
        <div class="modal-footer">
          <button
            type="submit"
            class="btn btn-primary"
            id="save-btn"
            form="satuanForm"
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

</div>
<!-- /.container-fluid -->
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<!-- JS -->
<script>
  $(document).ready(function () {
    if ($('#SatuanTable').length === 0) {
        return;
    }
    // CSRF Token (Penting di CI4)
    var csrfName = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';

    var table = $('#SatuanTable').DataTable();

    // 1. TAMBAH DATA (Membuka Modal)
    $('#add-btn').on('click', function() {
        $('#satuanForm')[0].reset(); // Reset form
        $('#satuanModalLabel').text('Tambah Data Kategori');
        $('#unit_id').val(''); // Pastikan ID kosong untuk operasi tambah
        $('.invalid-feedback').text('').hide(); // Bersihkan pesan error
        $('#satuanModal').modal('show');
    });
    // 2. SIMPAN DATA (Tambah dan Edit)
    $('#satuanForm').on('submit', function(x){
      // ... (Kode pencegahan default dan persiapan FormData)
      x.preventDefault();
      var formData = new FormData(this);
      formData.append(csrfName, csrfHash);
      
      $.ajax({
        url: "<?= site_url('owner/satuan/save'); ?>",
        type: "POST",
        data: formData,
        dataType: "JSON",
        contentType: false,
        processData: false,
        success: function(response) {
          // Update CSRF Hash
          csrfHash = response.token;
          $('#satuanModal').modal('hide');
            if (response.status) {
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

    // 3. EDIT DATA (Mengisi Form di Modal)
    $('#SatuanTable').on('click', '.edit-btn', function() {
        var unit_id = $(this).data('satuan-id');
        
        $('#satuanForm')[0].reset();
        $('#satuanModalLabel').text('Ubah Data Satuan');
        $('.invalid-feedback').removeClass('d-block').hide();
        $('.form-control').removeClass('is-invalid');

        // Ambil data barang dari controller menggunakan AJAX
        $.ajax({
            url: "<?= site_url('owner/satuan/get'); ?>/" + unit_id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                // Isi form dengan data yang didapatkan
                $('#unit_id').val(data.unit_id);
                $('#unit_name').val(data.unit_name);
                $('#satuanModal').modal('show');
            },
            error: function(xhr, status, error) {
                alert('Gagal mengambil data untuk Edit: ' + xhr.responseText);
            }
        });
    });
      // 4. HAPUS DATA SATUAN
      $('#SatuanTable').on('click', '.delete-btn', function() {
          var unit_id = $(this).data('satuan-id');

          Swal.fire({
              title: 'Hapus Satuan?',
              text: "Data ini akan dihapus secara permanen!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33', // Merah untuk hapus
              cancelButtonColor: '#6c757d', // Abu-abu untuk batal
              confirmButtonText: 'Ya, Hapus!',
              cancelButtonText: 'Batal',
              allowOutsideClick: false
          }).then((result) => {
              // Jika user mengklik tombol "Ya, Hapus!"
              if (result.isConfirmed) {
                  $.ajax({
                      url: "<?= site_url('owner/satuan/hapus'); ?>/" + unit_id,
                      type: "POST",
                      dataType: "JSON",
                      data: {
                          [csrfName]: csrfHash // Mengirimkan token CSRF
                      },
                      success: function(response) {
                          updateCsrfToken(response); // Selalu update token setelah request

                          if (response.status) {
                              Swal.fire({
                                  icon: 'success',
                                  title: 'Berhasil!',
                                  text: response.msg,
                                  confirmButtonColor: '#28a745'
                              }).then(() => {
                                  location.reload(); // Reload halaman agar data terupdate
                              });
                          } else {
                              Swal.fire({
                                  icon: 'error',
                                  title: 'Gagal!',
                                  text: response.msg,
                                  confirmButtonColor: '#d33'
                              });
                          }
                      },
                      error: function(xhr) {
                          Swal.fire({
                              icon: 'error',
                              title: 'Kesalahan Sistem',
                              text: 'Gagal menghapus data. Silakan coba lagi nanti.',
                              confirmButtonColor: '#d33'
                          });
                      }
                  });
              }
          });
      });

  });
</script>
<?= $this->endSection() ?>
