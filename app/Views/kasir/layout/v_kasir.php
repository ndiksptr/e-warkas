<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Kasir</title>

    <link
      href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet"
    />
    <!-- Custom fonts for this template-->
    <link
      rel="stylesheet"
      href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>"
    />
    <link
      rel="stylesheet"
      href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>"
    />

    <!-- bootstrap 5 -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    <!-- DataTables -->
    <link
      rel="stylesheet"
      href="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.css'); ?>"
    />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>

  <body id="page-top">
    <!-- Main Content -->
    <div id="content">
      <!-- Topbar -->
      <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
        <div>
          <a class="sidebar-brand d-flex align-items-center justify-content-center" 
          href="<?= base_url('kasir'); ?>">
            <div class="sidebar-brand-icon">
              <img
                class="img-fluid"
                src="<?= base_url('assets/img/logo-warkas.png'); ?>"
                width="40"
                height="34"
              />
            </div>
            <div class="mx-3 text-decoration-none text-dark font-weight-bold">
              Warkas
            </div>
          </a>
        </div>
        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">
          <!-- Nav Item - User Information -->
          <li class="nav-item dropdown no-arrow">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="userDropdown"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <strong class="mx-3">Hi, <?= session()->get('user_name') ?></strong>
              <img
                class="img-profile rounded-circle"
                src="<?= base_url('assets/img/undraw_profile.svg'); ?>"
              />
            </a>
            <!-- START | Dropdown - User Information -->
<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in p-2" aria-labelledby="userDropdown">
    <a class="dropdown-item p-3 border-0 rounded d-flex align-items-center justify-content-between" 
       href="<?= base_url('logout'); ?>">
        
        <div class="d-flex align-items-center">
            <div class="border border-danger rounded-circle d-flex align-items-center justify-content-center mr-3" 
                 style="width: 35px; height: 35px;">
                <i class="fas fa-sign-out-alt text-danger"></i>
            </div>
            
            <div>
                <span class="d-block font-weight-bold text-dark mb-0">Logout</span>
                <small class="text-muted">Keluar aplikasi</small>
            </div>
        </div>

        <i class="fas fa-chevron-right fa-xs text-light"></i>
    </a>
</div>
            <!-- END | Dropdown - User Information -->
          </li>
        </ul>
      </nav>
      <!-- End of Topbar -->

      <!-- Begin Page Content -->
      <!-- CONTENT NYA DI SINI YAA  -->
      <div class="container-fluid">
      <?php if(session()->getFlashdata('error')): ?>
        <div class="swal-data" data-type="error" data-title="Peringatan !!" 
        data-pesan="<?= session()->getFlashdata('error') ?>"></div>
      <?php endif; ?>

      <?php if(session()->getFlashdata('success')): ?>
          <div class="swal-data" data-type="success" data-title="Berhasil" 
          data-pesan="<?= session()->getFlashdata('success') ?>"></div>
      <?php endif; ?>
        <div class="row mb-2">
          <div class="col-sm-7">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-3">
                    <div class="form-group">
                        <label>Nomor Penjualan</label>
                        <input type="text" name="sales_id" form="form-kasir" class="form-control form-control-sm" value="<?= $no_penjualan; ?>" readonly>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <label for="tanggal">Tanggal</label>
                      <label
                        class="form-control form-control-sm"
                        id="tanggal"
                      ></label>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <label for="jam">Jam</label>
                      <label
                        class="form-control form-control-sm"
                        id="jam"
                      ></label>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <label for="kasir">Kasir</label>
                      <label class="form-control form-control-sm" id="kasir"><?= session()->get('user_name') ?></label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="card">
              <div class="card-body" style="background-color: black">
                <h1 class="display-4 text-right text-success font-weight-bold">
                  Rp.
                  <?= number_format($cart->total(), 0, ',', '.') ?>
                </h1>
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-sm-8">
            <div class="card">
              <div class="card-body px-4">
                <div class="row mb-3">
                  <div class="d-flex justify-content-between w-100">
                    <div class="col-sm-4">
                      <h5 class="font-weight-bolder">List Produk WarKas</h5>
                    </div>
                    <div class="col-sm-4">
                      <form action="<?= base_url('kasir'); ?>" method="get">
                        <div class="input-group">
                          <input
                            type="text"
                            name="keyword"
                            class="form-control bg-light border-0 small"
                            placeholder="Search product..."
                            value="<?= esc($keyword ?? '') ?>"
                          />
                          <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                              <i class="fas fa-search fa-sm"></i>
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div
                      class="d-flex flex-wrap overflow-auto"
                      style="max-height: 55vh"
                    >
                      <?php foreach($produk as $items): ?>
                      <?php 
                                  echo form_open('kasir/add');
                                  echo form_hidden('product_id',$items['product_id'] ?? '');
                                  echo form_hidden('category_id',$items['category_id'] ?? '');
                                  echo form_hidden('unit_id',$items['unit_id'] ?? '');
                                  echo form_hidden('product_name',$items['product_name'] ?? '');
                                  echo form_hidden('purchase_price',$items['purchase_price'] ?? 0);
                                  echo form_hidden('selling_price',$items['selling_price'] ?? 0);
                                  echo form_hidden('product_img',$items['product_img'] ?? '');
                                  ?>
                      <div
                        class="card mx-3 mb-3 p-2 text-center border-1 shadow-sm"
                        style="width: 12rem; height: 17rem; line-height: 15px"
                      >
                        <?php if ($items['product_img']): ?>
                        <img
                          src="<?= base_url('assets/uploads/'.$items['product_img']); ?>"
                          width="55px"
                          class="img-fluid d-block mx-auto mt-2"
                        />
                        <?php else: ?>
                        <span class="text-muted">-</span>
                        <?php endif; ?>
                        <div class="card-body">
                          <div style="line-height: 15px;">
                            <p class="card-text text-center p-0">
                              <?= $items['product_name']; ?>
                            </p>
                            <p class="card-text text-center">
                              <?= $items['category_name']; ?>
                            </p>
                          </div>
                          <?php $is_out_of_stock = ($items['stock'] <= 0); ?>

                          <p class="card-text text-center mb-1">
                              <small class="text-muted">Stok:</small> 
                              <span class="font-weight-bold <?= $is_out_of_stock ? 'text-danger' : 'text-success' ?>">
                                  <?= $items['stock']; ?>
                              </span>
                          </p>

                          <p class="card-text text-center font-weight-bold text-primary mb-3">
                              Rp. <?= number_format($items['selling_price'], 0, ',', '.'); ?>
                          </p>
                          <button
                              type="submit"
                              class="btn <?= $is_out_of_stock ? 'btn-secondary' : 'btn-primary' ?> btn-sm w-100 rounded-pill mt-auto"
                              <?= $is_out_of_stock ? 'disabled' : '' ?>>
                              <?= $is_out_of_stock ? 'Habis' : 'Add to Cart' ?>
                          </button>
                        </div>
                      </div>
                      <?php echo form_close(); ?>
                      <?php endforeach;?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <!-- lokasi kasir update -->
            <?php echo form_open('kasir/update', ['id' => 'form-kasir']); ?>
            <div class="card">
              <div class="card-body">
                <h5 class="font-weight-bolder">List Order</h5>
                <div
                  class="table-responsive"
                  style="max-height: 300px; overflow-y: auto"
                >
                  <table class="table table-striped mb-0">
                    <thead class="sticky-top bg-dark text-light">
                      <tr>
                        <th style="width: 150px" scope="col">Nama</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Total</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1; foreach($cart->contents() as $items) :?>
                      <tr>
                        <td><?= $items['name']; ?></td>
                        <td>
                          <input
                            type="number"
                            min="1"
                            name="qty<?= $no++; ?>"
                            class="form-control form-control-sm"
                            value="<?= $items['qty']; ?>"
                            style="width: 60px"
                          />
                        </td>
                        <td>
                          Rp.<?= number_format($items['price'], 0, ',', '.')?>
                        </td>
                        <td>
                          Rp.<?= number_format($items['subtotal'], 0, ',', '.')?>
                        </td>
                        <td>
                          <a
                            href="<?= base_url('kasir/delete/'.$items['rowid']); ?>"
                            class="btn btn-danger btn-sm"
                            ><i class="fas fa-trash"></i
                          ></a>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
                <div class="mt-3 border-top pt-3">
                    <div class="form-group mb-2">
                        <label class="small font-weight-bold">Total Tagihan</label>
                        <input type="text" class="form-control form-control-sm bg-light font-weight-bold text-dark" 
                              id="grand_total_display" value="Rp. <?= number_format($cart->total(), 0, ',', '.') ?>" readonly>
                        
                        <input type="hidden" id="grand_total_raw" value="<?= $cart->total() ?>">
                    </div>

                    <div class="form-group mb-2">
                        <label class="small font-weight-bold">Bayar (Cash)</label>
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" name="bayar" id="input_bayar" class="form-control border-primary" placeholder="0">
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="small font-weight-bold">Kembalian</label>
                        <input type="text" id="input_kembalian" class="form-control form-control-sm bg-light" value="Rp. 0" readonly>
                    </div>
                </div>
                <div class="row gx-2">
                <div class="col-6">
                    <button type="submit" class="btn btn-secondary btn-block">
                        <i class="fas fa-sync-alt"></i> Update
                    </button>
                </div>
                <div class="col-6">
                    <button type="submit" formaction="<?= base_url('kasir/checkout'); ?>" class="btn btn-success btn-block" form="form-kasir">
                        <i class="fas fa-check-circle"></i> Checkout
                    </button>
                </div>
            </div>
              </div>
            </div>

            <!-- lokasi kasir update -->
          </div>
        </div>
        <?php echo form_close(); ?>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/js/sb-admin-2.min.js'); ?>"></script>

    <!-- DataTables -->
    <script src="<?= base_url('assets/vendor/datatables/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js'); ?>"></script>

    <!-- bootstra 5 -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->

    <!-- JS NYA DI SINI YAA  -->
    <?= $this->renderSection('script')?>

    <!-- js -->
    <script>
      window.onload = function () {
        startTime();
        setTanggalSekarang();
      };

      function startTime() {
        var today = new Date(); // Menggunakan 'new Date()' dengan D kapital
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = CheckTime(m);
        s = CheckTime(s);
        document.getElementById("jam").innerHTML = h + ":" + m + ":" + s; // Menggunakan 's' untuk detik
        var t = setTimeout(function () {
          startTime();
        }, 1000);
      }

      function CheckTime(i) {
        if (i < 10) {
          i = "0" + i;
        }
        return i;
      }

      function setTanggalSekarang() {
        const label = document.getElementById("tanggal");

        const now = new Date();

        const hari = now.getDate();
        const bulan = now.toLocaleString("en-US", { month: "short" });
        const tahun = now.getFullYear();

        label.textContent = hari + " " + bulan + " " + tahun;
      }

      setTanggalSekarang();

      // kembalian
    document.getElementById('input_bayar').addEventListener('input', function() {
        // Ambil total tagihan dari hidden input (angka murni)
        const total = parseFloat(document.getElementById('grand_total_raw').value) || 0;
        
        // Ambil jumlah bayar
        const bayar = parseFloat(this.value) || 0;
        
        // Hitung kembalian
        const kembali = bayar - total;
        
        const displayKembalian = document.getElementById('input_kembalian');

        if (bayar > 0) {
            // Format ke Rupiah
            const formatRupiah = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(kembali).replace("IDR", "Rp.");

            displayKembalian.value = formatRupiah;

            // Beri warna merah jika uang kurang, hijau jika cukup
            if (kembali < 0) {
                displayKembalian.classList.add('text-danger');
                displayKembalian.classList.remove('text-success');
            } else {
                displayKembalian.classList.add('text-success');
                displayKembalian.classList.remove('text-danger');
            }
        } else {
            displayKembalian.value = "Rp. 0";
            displayKembalian.classList.remove('text-danger', 'text-success');
        }
    });

    // Sweealert2
    document.addEventListener("DOMContentLoaded", function() {
        // Mencari elemen dengan class .swal-data
        const swalData = document.querySelector('.swal-data');

        if (swalData) {
            const type = swalData.getAttribute('data-type'); // error atau success
            const title = swalData.getAttribute('data-title');
            const pesan = swalData.getAttribute('data-pesan');

            Swal.fire({
                icon: type,
                title: title,
                text: pesan,
                confirmButtonText: 'Oke Siap!', // Tulisan di tombol
                confirmButtonColor: type === 'success' ? '#28a745' : '#d33', // Hijau jika sukses, merah jika error
                showCancelButton: false, // Set true jika butuh tombol cancel tambahan
                allowOutsideClick: false // User wajib klik tombol untuk menutup
            });
        }
    });
    </script>
  </body>
</html>
