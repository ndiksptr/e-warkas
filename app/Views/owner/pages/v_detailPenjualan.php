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
        <h6 class="font-weight-bold text-primary">
          <?php echo "Detail Penjualan ID"?>
        </h6>
        <a href="<?= base_url('owner/penjualan'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">Kembali</a>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="DetailJualTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Sales ID</th>
              <th>Nama Produk</th>
              <th>Harga Beli</th>
              <th>Harga Jual</th>
              <th>Quantity</th>
              <th>Sub Total</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($detail as $items): ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $items['sales_id']; ?></td>
              <td><?= $items['product_name']; ?></td>
              <td>Rp. <?= number_format($items['current_capital'], 0, ',', '.'); ?></td>
              <td>Rp. <?= number_format($items['price'], 0, ',', '.'); ?></td>
              <td><?= $items['quantity']; ?></td>
              <td>
                  Rp. <?= number_format($items['price'] * $items['quantity'], 0, ',', '.'); ?>
              </td>
              <td>
                <a href="javascript:void(0)" class="btn btn-sm btn-warning edit-btn" 
                data-detailjual-id="<?= $items['sales_detail_id']; ?>">Edit</a>
                <!-- <a href="javascript:void(0)" class="btn btn-sm btn-danger delete-btn" 
                data-detailjual-id="<?= $items['sales_detail_id']; ?>">Hapus</a> -->
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
    id="detailjualModal"
    tabindex="1"
    role="dialog"
    aria-labelledby="detailjualModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <!-- modal header -->
        <div class="modal-header">
          <h5 class="modal-title" id="detailjualModalLabel">Form Detail Penjualan</h5>
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
          <form id="detailjualForm">
            <input type="hidden" name="sales_detail_id" id="sales_detail_id" />
            <div class="form-group">
              <label for="sales_id">ID Pembelian</label>
              <input type="number" name="sales_id" id="sales_id" class="form-control" readonly/>
              <div class="invalid-feedback" id="sales_id-error"></div>
            </div>
            <select name="product_id" id="product_id" class="form-control mb-3">
              <option value="">Nama Produk</option>
              <?php foreach ($product as $row): ?>
                <option value="<?= $row['product_id'] ?>">
                  <?= $row['product_name'] ?>
                </option>
              <?php endforeach; ?>
            </select>
            <div class="form-group">
              <label for="current_capital">Harga Beli</label>
              <input
                type="number"
                name="current_capital"
                id="current_capital"
                class="form-control"
                required
              />
              <div class="invalid-feedback" id="current_capital-error"></div>
            </div>
            <div class="form-group">
              <label for="price">Harga Jual</label>
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
            form="detailjualForm"
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
    if ($('#DetailJualTable').length === 0) {
        return;
    }
    // CSRF Token (Penting di CI4)
    var csrfName = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';

    var table = $('#DetailJualTable').DataTable();

    // 2. SIMPAN DATA (Tambah dan Edit)
    $('#detailjualForm').on('submit', function(x){
      // ... (Kode pencegahan default dan persiapan FormData)
      x.preventDefault();
      var formData = new FormData(this);
      formData.append(csrfName, csrfHash);
      
      $.ajax({
        url: "<?= site_url('/detailjual/savedetail'); ?>",
        type: "POST",
        data: formData,
        dataType: "JSON",
        contentType: false,
        processData: false,
        success: function(response) {
          // Update CSRF Hash
          csrfHash = response.token; 
            if (response.status) {
              $('#detailjualModal').modal('hide');
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
    $('#DetailJualTable').on('click', '.edit-btn', function() {
        var sales_detail_id = $(this).data('detailjual-id');
        
        $('#detailjualForm')[0].reset();
        $('#detailjualModalLabel').text('Ubah Data Detail');
        $('.invalid-feedback').removeClass('d-block').hide();
        $('.form-control').removeClass('is-invalid');

        // Ambil data barang dari controller menggunakan AJAX
        $.ajax({
            url: "<?= site_url('/detailjual/get'); ?>/" + sales_detail_id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                // Isi form dengan data yang didapatkan
                $('#sales_detail_id').val(data.sales_detail_id);
                $('#sales_id').val(data.sales_id);
                $('#product_id').val(data.product_id);
                $('#current_capital').val(data.current_capital);
                $('#price').val(data.price);
                $('#quantity').val(data.quantity);
                $('#subtotal').val(data.subtotal);
                $('#detailjualModal').modal('show');
            },
            error: function(xhr, status, error) {
                alert('Gagal mengambil data untuk Edit: ' + xhr.responseText);
            }
        });
    });

    // // DELETE
    //   $('#DetailJualTable').on('click', '.delete-btn', function() {
    //     var sales_detail_id = $(this).data('detailjual-id');

    //     // Pakai SweetAlert2 untuk konfirmasi
    //     Swal.fire({
    //         title: 'Apakah anda yakin?',
    //         text: "Data detail penjualan akan dihapus permanen!",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#e74a3b', // Warna merah sesuai tema bootstrap danger
    //         cancelButtonColor: '#858796', // Warna abu-abu
    //         confirmButtonText: 'Ya, Hapus!',
    //         cancelButtonText: 'Batal'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             // Lakukan AJAX Delete
    //             $.ajax({
    //                 url: "<?= site_url('/detailjual/hapusdetail'); ?>/" + sales_detail_id,
    //                 type: "POST", 
    //                 dataType: "JSON",
    //                 data: {
    //                     [csrfName]: csrfHash 
    //                 },
    //                 success: function(response) {
    //                     updateCsrfToken(response);

    //                     if (response.status) {
    //                         Swal.fire({
    //                             icon: 'success',
    //                             title: 'Terhapus!',
    //                             text: response.msg,
    //                             showConfirmButton: false,
    //                             timer: 1500
    //                         }).then(() => {
    //                             location.reload(); 
    //                         });
    //                     } else {
    //                         Swal.fire('Gagal!', response.msg, 'error');
    //                     }
    //                 },
    //                 error: function(xhr) {
    //                     Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
    //                 }
    //             });
    //         }
    //     });
    // });

  });
</script>
<?= $this->endSection() ?>
