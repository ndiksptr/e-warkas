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
      <h6 class="font-weight-bold text-primary mb-3">
        <?php echo "Detail Pembelian ID"?>
      </h6>
      <div class="d-sm-flex">
<button
  class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3"
  id="add-btn" 
  data-id="<?= $purchase_id; ?>"> Tambah Data
</button>
        <a href="<?= base_url('owner/pembelian'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">Kembali</a>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table
          class="table table-bordered"
          id="DetailBeliTable"
          width="100%"
          cellspacing="0"
        >
          <thead>
            <tr>
              <th>No</th>
              <th>Purchase ID</th>
              <th>Nama Produk</th>
              <th>Harga</th>
              <th>Quantity</th>
              <th>Sub Total</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($detail as $items): ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $items['purchase_id']; ?></td>
              <td><?= $items['product_name']; ?></td>
              <td>Rp. <?= number_format($items['price'], 0, ',', '.'); ?></td>
              <td><?= $items['quantity']; ?></td>
              <td>
                  Rp. <?= number_format($items['price'] * $items['quantity'], 0, ',', '.'); ?>
              </td>
              <td>
                <a href="javascript:void(0)" class="btn btn-sm btn-warning edit-btn" 
                data-detailBeli-id="<?= $items['purchase_detail_id']; ?>">Edit</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-danger delete-btn" 
                data-detailBeli-id="<?= $items['purchase_detail_id']; ?>">Hapus</a>
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
    id="detailbeliModal"
    tabindex="1"
    role="dialog"
    aria-labelledby="detailbeliModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <!-- modal header -->
        <div class="modal-header">
          <h5 class="modal-title" id="detailbeliModalLabel">Form Detail Pembelian</h5>
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
          <form id="detailbeliForm">
            <input type="hidden" name="purchase_detail_id" id="purchase_detail_id" />
            <div class="form-group">
              <label for="purchase_id">ID Pembelian</label>
              <input
                type="number"
                name="purchase_id"
                id="purchase_id"
                class="form-control" readonly
              />
              <div class="invalid-feedback" id="purchase_id-error"></div>
            </div>
                <select name="product_id" id="product_id" class="form-control select2-js mb-3">
                  <option value="">Nama Produk</option>
                  <?php foreach ($product as $row): ?>
                    <option value="<?= $row['product_id'] ?>">
                      <?= $row['product_name'] ?>
                    </option>
                  <?php endforeach; ?>
                </select>
            <div class="form-group">
              <label for="price">Harga Beli</label>
              <input
                type="number"
                name="price"
                id="price"
                class="form-control"
                required
              />
              <div class="invalid-feedback" id="price-error"></div>
            </div>
            <div class="form-group">
              <label for="quantity">Jumlah Produk</label>
              <input
                type="number"
                name="quantity"
                id="quantity"
                class="form-control"
                required
              />
              <div class="invalid-feedback" id="quantity-error"></div>
            </div>
          </form>
        </div>
        <!-- modal footer -->
        <div class="modal-footer">
          <button
            type="submit"
            class="btn btn-primary"
            id="save-btn"
            form="detailbeliForm"
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
    if ($('#DetailBeliTable').length === 0) {
        return;
    }
    // CSRF Token (Penting di CI4)
    var csrfName = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';

    // Inisialisasi Select2

    if ($.fn.select2) {
        $('#product_id').select2({
            theme: 'bootstrap4',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#detailbeliModal'),
            minimumResultsForSearch: 0 //buat mastiin kotak search muncul
        });
    }

    var table = $('#DetailBeliTable').DataTable();

// 1. TAMBAH DATA (Membuka Modal)
$('#add-btn').on('click', function() {
    // Ambil ID dari atribut data-id tombol yang baru saja kita tambahkan
    let current_purchase_id = $(this).data('id');

    $('#detailbeliForm')[0].reset(); // Reset form agar bersih
    $('#detailbeliModalLabel').text('Tambah Detail Pembelian'); // Perbaiki label

    // Reset Select2 agar kosong
    if ($.fn.select2) {
        $('#product_id').val(null).trigger('change');
    }
    
    // Masukkan ID pembelian ke input agar user tidak perlu ngetik
    $('#purchase_id').val(current_purchase_id); 
    
    $('#purchase_detail_id').val(''); // Kosongkan karena ini data baru
    $('.invalid-feedback').text('').hide();
    $('.form-control').removeClass('is-invalid');
    
    $('#detailbeliModal').modal('show');
});

// AUTO FOCUS SEARCH BOX SELECT2 KETIKA MODAL DIBUKA
$('#detailbeliModal').on('shown.bs.modal', function () {
    if ($.fn.select2) {
        $('#product_id').select2('open'); //maksa muncul ketik
    }
});

// Memaksa fokus ke kotak pencarian Select2
$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});

    // 2. SIMPAN DATA (Tambah dan Edit)
    $('#detailbeliForm').on('submit', function(x){
      // ... (Kode pencegahan default dan persiapan FormData)
      x.preventDefault();
      var formData = new FormData(this);
      formData.append(csrfName, csrfHash);
      
      $.ajax({
        url: "<?= site_url('/detailbeli/savedetail'); ?>",
        type: "POST",
        data: formData,
        dataType: "JSON",
        contentType: false,
        processData: false,
        success: function(response) {
          // Update CSRF Hash
          csrfHash = response.token; 
            if (response.status) {
              $('#detailbeliModal').modal('hide');
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
    $('#DetailBeliTable').on('click', '.edit-btn', function() {
        var purchase_detail_id = $(this).data('detailbeli-id');
        
        $('#detailbeliForm')[0].reset();
        $('#detailbeliModalLabel').text('Ubah Data Detail');
        $('.invalid-feedback').removeClass('d-block').hide();
        $('.form-control').removeClass('is-invalid');

        // Ambil data barang dari controller menggunakan AJAX
        $.ajax({
            url: "<?= site_url('/detailbeli/get'); ?>/" + purchase_detail_id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                // Isi form dengan data yang didapatkan
                $('#purchase_detail_id').val(data.purchase_detail_id);
                $('#purchase_id').val(data.purchase_id);
                $('#product_id').val(data.product_id);
                $('#price').val(data.price);
                $('#quantity').val(data.quantity);
                $('#subtotal').val(data.subtotal);
                $('#detailbeliModal').modal('show');
            },
            error: function(xhr, status, error) {
                alert('Gagal mengambil data untuk Edit: ' + xhr.responseText);
            }
        });
    });

      // 4. HAPUS DATA DETAIL BELI
      $('#DetailBeliTable').on('click', '.delete-btn', function() {
          // Pastikan di atribut HTML tombol anda menggunakan data-detailbeli-id
          var purchase_detail_id = $(this).data('detailbeli-id');
          
          Swal.fire({
              title: 'Hapus Item ini?',
              text: "Data detail pembelian akan dihapus secara permanen!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#6c757d',
              confirmButtonText: 'Ya, Hapus!',
              cancelButtonText: 'Batal',
              allowOutsideClick: false
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      url: "<?= site_url('/detailbeli/hapusdetail'); ?>/" + purchase_detail_id,
                      type: "POST", 
                      dataType: "JSON",
                      data: {
                          [csrfName]: csrfHash // Menggunakan token CSRF terbaru
                      },
                      beforeSend: function() {
                          Swal.fire({
                              title: 'Memproses...',
                              didOpen: () => { Swal.showLoading(); }
                          });
                      },
                      success: function(response) {
                          updateCsrfToken(response); // Selalu update token

                          if (response.status) {
                              Swal.fire({
                                  icon: 'success',
                                  title: 'Berhasil!',
                                  text: response.msg,
                                  confirmButtonColor: '#28a745'
                              }).then(() => {
                                  location.reload(); 
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
                          // Cek log di Console F12 untuk melihat pesan error asli dari server
                          console.log(xhr.responseText);
                          Swal.fire({
                              icon: 'error',
                              title: 'Error!',
                              text: 'Gagal menghapus. Cek koneksi atau izin akses server.',
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
