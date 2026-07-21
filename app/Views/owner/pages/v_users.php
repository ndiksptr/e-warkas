<?= $this->extend('owner/layout/v_home') ?>
<?= $this->section('content') ?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-2">
    <h1 class="h3 text-gray-800"><?= $judul; ?></h1>
    <p><?= $judul; ?></p>
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
          id="UsersTable"
          width="100%"
          cellspacing="0"
        >
          <thead>
            <tr>
              <th>No</th>
              <th>Username</th>
              <th>Role</th>
              <th>Email</th>
              <th>Status</th>
              <th>Created At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($users as $items): ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $items['user_name']; ?></td>
              <td><?= $items['name']; ?></td>
              <td><?= $items['user_email']; ?></td>
              <td><span class="badge badge-success"><?= ($items['is_active'] == 1) ? 'active' : 'off'; ?></span></td>
              <td><?= $items['created_at']; ?></td>
              <td>
                <a href="javascript:void(0)" class="btn btn-sm btn-warning edit-btn" 
                data-user-id="<?= $items['user_id']; ?>">
                  Edit
                </a>
                <a href="javascript:void(0)" class="btn btn-sm btn-danger delete-btn" data-user-id="<?= $items['user_id']; ?>">
                  Hapus
                </a>
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
  id="usersModal"
  tabindex="1"
  role="dialog"
  aria-labelledby="usersModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!-- modal header -->
      <div class="modal-header">
        <h5 class="modal-title" id="usersModalLabel">Form Users</h5>
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
        <form id="usersForm">
          <input type="hidden" name="user_id" id="user_id" />
          <input type="hidden" name="is_active" id="is_active" />
          <div class="form-group">
            <label for="user_name">Username</label>
            <input
              type="text"
              name="user_name"
              id="user_name"
              class="form-control"
              required
            />
            <div class="invalid-feedback" id="user_name-error"></div>
          </div>

          <div class="form-group">
            <label for="password_hash">Password</label>
            <input
              type="password"
              name="password_hash"
              id="password_hash"
              class="form-control"
            />
            <div class="invalid-feedback" id="password_hash-error"></div>
          </div>

          <div class="form-group">
            <label for="user_email">Email</label>
            <input
              type="text"
              name="user_email"
              id="user_email"
              class="form-control"
              required
            />
            <div class="invalid-feedback" id="user_email-error"></div>
          </div>
          <select name="roles_id" id="roles_id" class="form-control">
            <option value="">Pilih Role</option>
            <?php foreach ($roles as $role): ?>
              <option value="<?= $role['roles_id'] ?>">
                <?= $role['name'] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </form>
      </div>
      <!-- modal footer -->
      <div class="modal-footer">
        <button
          type="submit"
          class="btn btn-primary"
          id="save-btn"
          form="usersForm"
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
    if ($('#UsersTable').length === 0) {
        return;
    }
    // CSRF Token (Penting di CI4)
    var csrfName = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';

    var table = $('#UsersTable').DataTable();

    // 1. TAMBAH DATA (Membuka Modal)
    $('#add-btn').on('click', function() {
        $('#usersForm')[0].reset(); // Reset form
        $('#usersModalLabel').text('Tambah Data User');
        $('#user_id').val(''); // Pastikan ID kosong untuk operasi tambah
        $('.invalid-feedback').text('').hide(); // Bersihkan pesan error
        $('#usersModal').modal('show');
    });
    // 2. SIMPAN DATA (Tambah dan Edit)
    $('#usersForm').on('submit', function(x){
      // ... (Kode pencegahan default dan persiapan FormData)
      x.preventDefault();
      var formData = new FormData(this);
      formData.append(csrfName, csrfHash);
      
      $.ajax({
        url: "<?= site_url('owner/users/save'); ?>",
        type: "POST",
        data: formData,
        dataType: "JSON",
        contentType: false,
        processData: false,
        success: function(response) {
          // Update CSRF Hash
          csrfHash = response.token; 
            if (response.status) {
              $('#usersModal').modal('hide');
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
    $('#UsersTable').on('click', '.edit-btn', function() {
        var user_id = $(this).data('user-id');
        
        $('#usersForm')[0].reset();
        $('#usersModalLabel').text('Ubah Data Users');
        $('.invalid-feedback').removeClass('d-block').hide();
        $('.form-control').removeClass('is-invalid');

        // Ambil data barang dari controller menggunakan AJAX
        $.ajax({
            url: "<?= site_url('owner/users/get'); ?>/" + user_id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                // Isi form dengan data yang didapatkan
                $('#user_id').val(data.user_id);
                $('#user_name').val(data.user_name);
                $('#roles_id').val(data.roles_id);
                $('#password_hash').val();
                $('#user_email').val(data.user_email);
                $('#usersModal').modal('show');
            },
            error: function(xhr, status, error) {
                alert('Gagal mengambil data untuk Edit: ' + xhr.responseText);
            }
        });
    });
      // 4. HAPUS DATA
      $('#UsersTable').on('click', '.delete-btn', function() {
          var user_id = $(this).data('user-id');

          // Mengganti confirm() standar dengan SweetAlert2
          Swal.fire({
              title: 'Apakah Anda yakin?',
              text: "Data yang dihapus tidak dapat dikembalikan!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33', // Merah untuk hapus
              cancelButtonColor: '#6c757d', // Abu-abu untuk batal
              confirmButtonText: 'Ya, Hapus!',
              cancelButtonText: 'Batal',
              allowOutsideClick: false
          }).then((result) => {
              // Jika user klik "Ya, Hapus!"
              if (result.isConfirmed) {
                  $.ajax({
                      url: "<?= site_url('owner/users/hapus'); ?>/" + user_id,
                      type: "POST",
                      dataType: "JSON",
                      data: {
                          [csrfName]: csrfHash
                      },
                      success: function(response) {
                          updateCsrfToken(response); // Update CSRF Hash agar token tidak expired

                          if (response.status) {
                              Swal.fire({
                                  icon: 'success',
                                  title: 'Terhapus!',
                                  text: response.msg,
                                  confirmButtonColor: '#28a745'
                              }).then(() => {
                                  location.reload(); // Reload halaman setelah klik Oke
                              });
                          } else {
                              Swal.fire({
                                  icon: 'error',
                                  title: 'Gagal!',
                                  text: response.msg
                              });
                          }
                      },
                      error: function(xhr) {
                          Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Terjadi kesalahan sistem saat menghapus data.'
                          });
                      }
                  });
              }
          });
      });

  });
</script>
<?= $this->endSection() ?>
