<?= $this->extend('owner/layout/v_home') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-2">
    <h1 class="h3 text-gray-800"><?= $subjudul; ?></h1>
    <p><?= "$judul / $subjudul"; ?></p>
  </div>

  <!-- DataTables Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="d-sm-flex align-items-center justify-content-between m-0 p-0">
        <h6 class="font-weight-bold text-primary m-0 p-0">
          <?= "Tabel $judul"; ?>
        </h6>

        <!-- Tombol langsung trigger modal -->
        <button
          type="button"
          id="btnTambah"
          class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
          data-toggle="modal"
          data-target="#usersModal">
          Tambah Data
        </button>
      </div>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="ProdukTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Gambar Produk</th>
              <th>Nama Produk</th>
              <th>Kategori</th>
              <th>Harga Beli</th>
              <th>Harga Jual</th>
              <th>Stok</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($produk as $items): ?>
              <tr>
                <td><?= $no++; ?></td>
                <td>
                  <?php if ($items['product_img']): ?>
                    <img src="<?= base_url('assets/uploads/'.$items['product_img']); ?>" width="60">
                  <?php else: ?>
                    <span class="text-muted">-</span>
                  <?php endif; ?>
                </td>
                <td><?= $items['product_name']; ?></td>
                <td><?= $items['category_name']; ?></td>
                <td>Rp. <?= number_format($items['purchase_price'], 0, ',', '.'); ?></td>
                <td>Rp. <?= number_format($items['selling_price'], 0, ',', '.'); ?></td>
                <td><?= $items['stock']; ?></td>
                <td>
                  <!-- Tombol Edit -->
                  <a href="javascript:void(0)"
                     class="btn btn-sm btn-warning btn-edit"
                     data-toggle="modal"
                     data-target="#usersModal"
                     data-id="<?= $items['product_id']; ?>"
                     data-name="<?= $items['product_name']; ?>"
                     data-category="<?= $items['category_id']; ?>"
                     data-unit="<?= $items['unit_id']; ?>"
                     data-purchase="<?= $items['purchase_price']; ?>"
                     data-selling="<?= $items['selling_price']; ?>"
                     data-img="<?= $items['product_img']; ?>">
                     Edit
                  </a>

                  <!-- Tombol Hapus -->
                  <a href="javascript:void(0)"
                     class="btn btn-sm btn-danger delete-btn"
                     data-produk-id="<?= $items['product_id']; ?>">
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
<!-- /.container-fluid -->

<!-- Form Modal -->
<div class="modal fade" id="usersModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <!-- modal header -->
      <div class="modal-header">
        <h5 class="modal-title" id="usersModalLabel">Form Produk</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <!-- modal body -->
      <div class="modal-body">
        <form id="produkForm" action="<?= base_url('owner/produk/store'); ?>" method="post" enctype="multipart/form-data">

          <div class="form-group">
            <label for="product_name">Nama Produk</label>
            <input type="text" name="product_name" id="product_name" class="form-control" required />
            <div class="invalid-feedback" id="product_name-error"></div>
          </div>

          <div class="form-group">
            <label>Kategori</label>
            <select name="category_id" id="category_id" class="form-control" required>
              <option value="">Pilih Kategori</option>
              <?php foreach ($kategori as $kat): ?>
                <option value="<?= $kat['category_id']; ?>"><?= $kat['category_name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Satuan</label>
            <select name="unit_id" id="unit_id" class="form-control" required>
              <option value="">Pilih Satuan</option>
              <?php foreach ($satuan as $sat): ?>
                <option value="<?= $sat['unit_id']; ?>"><?= $sat['unit_name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label for="purchase_price">Harga Beli</label>
            <input type="number" name="purchase_price" id="purchase_price" class="form-control" step="0.01" required/>
            <div class="invalid-feedback" id="purchase_price-error"></div>
          </div>

          <div class="form-group">
            <label for="selling_price">Harga Jual</label>
            <input type="number" name="selling_price" id="selling_price" class="form-control" step="0.01" required/>
            <div class="invalid-feedback" id="selling_price-error"></div>
          </div>

          <!-- Upload Gambar -->
          <div class="form-group">
            <label for="product_img">Gambar Produk</label>
            <input type="file"
                   name="product_img"
                   id="product_img"
                   class="form-control-file"
                   accept="image/*" required>
          </div>

          <!-- Preview Gambar -->
          <div class="form-group">
            <img id="previewImg" src="" class="img-thumbnail d-none" width="120">
          </div>

        </form>
      </div>

      <!-- modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" form="produkForm">Simpan</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>
<!-- End Form Modal -->

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function () {
    var table = $('#ProdukTable').DataTable();
 // Mode Tambah Produk
  $('#btnTambah').on('click', function () {
    $('#usersModalLabel').text('Tambah Produk');
    $('#produkForm')[0].reset();
    $('#produkForm').attr('action', '<?= base_url('owner/produk/store'); ?>');
    $('#previewImg').attr('src', '').addClass('d-none');
  });

  // Mode Edit Produk
  $(document).on('click', '.btn-edit', function () {
    $('#usersModalLabel').text('Edit Produk');
    const id = $(this).data('id');
    $('#produkForm').attr('action', '<?= base_url('owner/produk/update'); ?>/' + id);
    $('#product_name').val($(this).data('name'));
    $('#category_id').val($(this).data('category'));
    $('#unit_id').val($(this).data('unit'));
    $('#purchase_price').val($(this).data('purchase'));
    $('#selling_price').val($(this).data('selling'));

    const img = $(this).data('img');
    if (img) {
      $('#previewImg').attr('src', '<?= base_url('assets/uploads'); ?>/' + img).removeClass('d-none');
    } else {
      $('#previewImg').attr('src', '').addClass('d-none');
    }
  });

  // Preview Gambar
  $('#product_img').on('change', function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        $('#previewImg').attr('src', e.target.result).removeClass('d-none');
      };
      reader.readAsDataURL(file);
    }
  });

 // Hapus Produk
  $(document).on('click', '.delete-btn', function() {
    const id = $(this).data('produk-id');
    if(confirm('Apakah yakin ingin menghapus produk ini?')) {
      $.ajax({
        url: '<?= base_url('owner/produk/hapus'); ?>/' + id,
        type: 'POST',
        success: function(res) {
          location.reload();
        },
        error: function() {
          alert('Gagal menghapus produk');
        }
      });
    }
  });

});
</script>
<?= $this->endSection() ?>
