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
          id="KategoriTable"
          width="100%"
          cellspacing="0"
        >
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Kategori</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($kategori as $items): ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $items['category_name']; ?></td>
              <td>
                <a href="javascript:void(0)" class="btn btn-sm btn-warning edit-btn" 
                data-kategori-id="<?= $items['category_id']; ?>">Edit</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-danger delete-btn" 
                data-kategori-id="<?= $items['category_id']; ?>">Hapus</a>
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
    id="kategoriModal"
    tabindex="1"
    role="dialog"
    aria-labelledby="kategoriModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <!-- modal header -->
        <div class="modal-header">
          <h5 class="modal-title" id="kategoriModalLabel">Form Kategori</h5>
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
          <form id="kategoriForm">
            <input type="hidden" name="category_id" id="category_id" />
            <div class="form-group">
              <label for="category_name">Nama Kategori</label>
              <input
                type="text"
                name="category_name"
                id="category_name"
                class="form-control"
                required
              />
              <div class="invalid-feedback" id="category_name-error"></div>
            </div>
          </form>
        </div>
        <!-- modal footer -->
        <div class="modal-footer">
          <button
            type="submit"
            class="btn btn-primary"
            id="save-btn"
            form="kategoriForm"
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
    if ($('#KategoriTable').length === 0) {
        return;
    }
    // CSRF Token (Penting di CI4)
    var csrfName = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';

    var table = $('#KategoriTable').DataTable();

    // 1. TAMBAH DATA (Membuka Modal)
    $('#add-btn').on('click', function() {
        $('#kategoriForm')[0].reset(); // Reset form
        $('#kategoriModalLabel').text('Tambah Data Kategori');
        $('#category_id').val(''); // Pastikan ID kosong untuk operasi tambah
        $('.invalid-feedback').text('').hide(); // Bersihkan pesan error
        $('#kategoriModal').modal('show');
    });
    // 2. SIMPAN DATA (Tambah dan Edit)
    $('#kategoriForm').on('submit', function(x){
      // ... (Kode pencegahan default dan persiapan FormData)
      x.preventDefault();
      var formData = new FormData(this);
      formData.append(csrfName, csrfHash);
      
      $.ajax({
        url: "<?= site_url('owner/kategori/save'); ?>",
        type: "POST",
        data: formData,
        dataType: "JSON",
        contentType: false,
        processData: false,
        success: function(response) {
          // Update CSRF Hash
          csrfHash = response.token; 
            if (response.status) {
              $('#kategoriModal').modal('hide');
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
    $('#KategoriTable').on('click', '.edit-btn', function() {
        var category_id = $(this).data('kategori-id');
        
        $('#kategoriForm')[0].reset();
        $('#kategoriModalLabel').text('Ubah Data Kategori');
        $('.invalid-feedback').removeClass('d-block').hide();
        $('.form-control').removeClass('is-invalid');

        // Ambil data barang dari controller menggunakan AJAX
        $.ajax({
            url: "<?= site_url('owner/kategori/get'); ?>/" + category_id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                // Isi form dengan data yang didapatkan
                $('#category_id').val(data.category_id);
                $('#category_name').val(data.category_name);
                $('#kategoriModal').modal('show');
            },
            error: function(xhr, status, error) {
                alert('Gagal mengambil data untuk Edit: ' + xhr.responseText);
            }
        });
    });

      $('#KategoriTable').on('click', '.delete-btn', function() {
        var category_id = $(this).data('kategori-id');

        // SweetAlert2 Konfirmasi
        Swal.fire({
            title: 'Hapus Kategori?',
            text: "Kategori yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b', // Warna merah (danger)
            cancelButtonColor: '#858796', // Warna abu-abu (secondary)
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('owner/kategori/hapus'); ?>/" + category_id,
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        [csrfName]: csrfHash 
                    },
                    success: function(response) {
                        updateCsrfToken(response);

                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.msg,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload(); 
                            });
                        } else {
                            // Jika gagal karena Foreign Key (masih ada produk)
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Menghapus',
                                text: response.msg
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Terjadi kesalahan sistem: ' + xhr.responseText, 'error');
                    }
                });
            }
        });
    });
  });
</script>
<?= $this->endSection() ?>
