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

    <title><?= $title; ?></title>

    <link
      href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet"
    />
    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>">

    <!-- bootstrap 5 -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.css'); ?>">

        <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css">
    
  </head>

  <body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
      <!-- Sidebar -->
      <ul
        class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion"
        id="accordionSidebar"
      >
        <!-- Sidebar - Brand -->
        <a
          class="sidebar-brand d-flex align-items-center justify-content-center"
          href="<?= base_url('owner/dashboard'); ?>"
        >
          <div class="sidebar-brand-icon">
            <img class="img-fluid" src="<?= base_url('assets/img/logo-warkas.png'); ?>" width="40" height="34"/>
          </div>
          <div class="sidebar-brand-text mx-3">Warkas</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0" />

        <!-- Nav Item - Dashboard -->
        <li class="nav-item <?= $menu=='dashboard' ? 'active': '' ?>">
          <a class="nav-link" href="<?= base_url('owner/dashboard'); ?>">
            <i class="fas fa-solid fa-inbox"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item <?= $menu=='users' ? 'active': '' ?>">
          <a class="nav-link" href="<?= base_url('owner/users'); ?>">
            <i class="fas fa-solid fa-user"></i>
            <span>Users</span>
          </a>
        </li>
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item <?= $menu=='masterdata' ? 'active': '' ?>">
          <a
            class="nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#masterData"
            aria-expanded="true"
            aria-controls="masterData"
          >
            <i class="fas fa-solid fa-box-open"></i>
            <span>Master Data</span>
          </a>
          <div
            id="masterData"
            class="collapse"
            aria-labelledby="masterData"
            data-parent="#accordionSidebar"
          >
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Master Data</h6>
              <a class="collapse-item <?= $submenu=='kategori' ? 'active': '' ?>" 
              href="<?= base_url('owner/kategori'); ?>">Kategori</a>
              <a class="collapse-item <?= $submenu=='produk' ? 'active': '' ?>" 
              href="<?= base_url('owner/produk'); ?>">Produk</a>
              <a class="collapse-item <?= $submenu=='satuan' ? 'active': '' ?>" 
              href="<?= base_url('owner/satuan'); ?>">Satuan</a>
            </div>
          </div>
        </li>
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item <?= $menu=='transaksi' ? 'active': '' ?>">
          <a
            class="nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#nav_transaksi"
            aria-expanded="true"
            aria-controls="nav_transaksi"
          >
            <i class="fas fa-solid fa-tag"></i>
            <span>Transaksi</span>
          </a>
          <div
            id="nav_transaksi"
            class="collapse"
            aria-labelledby="nav_transaksi"
            data-parent="#accordionSidebar"
          >
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Transaksi</h6>
              <a class="collapse-item <?= $menu=='pembelian' ? 'active': '' ?>" 
              href="<?= base_url('owner/pembelian'); ?>">Transaksi Pembelian</a>
              <a class="collapse-item <?= $menu=='penjualan' ? 'active': '' ?>" 
              href="<?= base_url('owner/penjualan'); ?>">Transaksi Penjualan</a>
              <a class="collapse-item <?= $menu=='inventory' ? 'active': '' ?>" 
              href="<?= base_url('owner/inventory'); ?>">Inventory</a>
            </div>
          </div>
        </li>
        <!-- Nav Item - Pages Collapse Menu -->
       <li class="nav-item <?= $menu=='laporan' ? 'active': '' ?>">
          <a
            class="nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#nav_laporan"
            aria-expanded="true"
            aria-controls="nav_laporan"
          >
            <i class="fas fa-solid fa-file"></i>
            <span>Laporan</span>
          </a>
          <div
            id="nav_laporan"
            class="collapse"
            aria-labelledby="nav_laporan"
            data-parent="#accordionSidebar"
          >
          <!-- ini bagian laporan -->
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Laporan</h6>
              <a class="collapse-item <?= $submenu=='laporanHarian' ? 'active': '' ?>" 
              href="<?= base_url('owner/laporan/laporanharian'); ?>">Laporan Harian</a>
               <a class="collapse-item <?= $submenu=='laporanBulanan' ? 'active': '' ?>" 
              href="<?= base_url('owner/laporan/laporanbulanan'); ?>">Laporan Bulanan</a>
              <a class="collapse-item <?= $submenu=='laporanTahunan' ? 'active': '' ?>" 
              href="<?= base_url('owner/laporan/laporantahunan'); ?>">Laporan Tahunan</a>
               <a class="collapse-item <?= $submenu=='laporanStok' ? 'active': '' ?>" 
              href="<?= base_url('owner/laporan/laporanstok'); ?>">Laporan Stok</a>
            <!-- diganti sampe sini aja -->
            </div>
          </div>
        </li>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
          <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-solid fa-share"></i>
            <span>Sign Out</span>
          </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block" />

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
      </ul>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
          <!-- Topbar -->
          <nav
            class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"
          >
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
              <i class="fa fa-bars"></i>
            </button>

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
              </li>
            </ul>
          </nav>
          <!-- End of Topbar -->

          <!-- Begin Page Content -->
           <!-- CONTENT NYA DI SINI YAA  -->
           <?= $this->renderSection('content')?>
          <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright &copy; WarKas 2026</span>
            </div>
          </div>
        </footer>
        <!-- End of Footer -->
      </div>
      <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div
      class="modal fade"
      id="logoutModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Log out</h5>
            <button
              class="close"
              type="button"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            Anda Yakin Ingin Logout ?
          </div>
          <div class="modal-footer">
            <a class="btn btn-primary" href="<?= base_url('logout'); ?>">Logout</a>
            <button
              class="btn btn-secondary"
              type="button"
              data-dismiss="modal">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>

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

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- JS NYA DI SINI YAA  -->
    <?= $this->renderSection('script')?>

  </body>
</html>
