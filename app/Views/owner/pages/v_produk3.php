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
        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
          id="add-btn">Tambah Data
        </button>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table
          class="table table-bordered" id="ProdukTable" width="100%" cellspacing="0">
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
                    <?php if($items['product_img']): ?>
                      <img src="<?= base_url('assets/uploads/'.$items['product_img']); ?>" alt="Gambar Produk" width="60">
                    <?php else : ?>
                      <span class="text-muted">-</span>
                    <?php endif;?>
                  </td>
                  <td><?= $items['product_name']; ?></td>
                  <td><?= $items['category_name']; ?></td>
                  <td><?= $items['purchase_price']; ?></td>
                  <td><?= $items['selling_price']; ?></td>
                  <td><?= $items['stock']; ?></td>
                  <td>
                    <a href="javascript:void(0)" class="btn btn-sm btn-warning edit-btn" data-produk-id="<?= $items['product_id']; ?>">Edit</a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger delete-btn" data-produk-id="<?= $items['product_id']; ?>">Hapus</a>
                  </td>
                </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?= print_r($produk); ?>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

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
        <form id="produkForm">
          <input type="hidden" name="product_id" id="product_id" />
          <div class="form-group">
            <label for="product_name">Nama Produk</label>
            <input
              type="text"
              name="product_name"
              id="product_name"
              class="form-control"
              required
            />
            <div class="invalid-feedback" id="product_name-error"></div>
          </div>
          <select name="category_id" id="category_id" class="form-control">
            <option value="">Pilih Kategori</option>
            <?php foreach ($kategori as $kat): ?>
              <option value="<?= $kat['category_id'] ?>">
                <?= $kat['category_name'] ?>
              </option>
            <?php endforeach; ?>
          </select>
          <select name="unit_id" id="unit_id" class="form-control">
            <option value="">Pilih Satuan</option>
            <?php foreach ($satuan as $sat): ?>
              <option value="<?= $sat['unit_id'] ?>">
                <?= $sat['unit_name'] ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div class="form-group">
            <label for="purchase_price">Harga Beli</label>
            <input
              type="number"
              name="purchase_price"
              id="purchase_price"
              class="form-control"
            />
            <div class="invalid-feedback" id="purchase_price-error"></div>
          </div>
          <div class="form-group">
            <label for="selling_price">Harga Jual</label>
            <input
              type="number"
              name="selling_price"
              id="selling_price"
              class="form-control"
            />
            <div class="invalid-feedback" id="selling_price-error"></div>
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
        </form>
      </div>
      <!-- modal footer -->
      <div class="modal-footer">
        <button
          type="submit"
          class="btn btn-primary"
          id="save-btn"
          form="produkForm"
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
<?= $this->endSection() ?>
