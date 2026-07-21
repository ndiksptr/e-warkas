<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login WarKas</title>
    <link
      rel="stylesheet"
      type="text/css"
      href="<?= base_url('assets/css/style.css'); ?>"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap"
      rel="stylesheet"
    />
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body>
    <img class="wave" src="<?= base_url('assets/img/wave2.png'); ?>" />
    <div class="container">
      <div class="img">
        <img src="<?= base_url('assets/img/icon-warkas.png'); ?>" />
      </div>
      <div class="login-content">
        <form action="<?= base_url('loginProcess') ?>" method="post">
          <img src="<?= base_url('assets/img/logo-warkas.png'); ?>" />
          <h2 class="title">Welcome WarKas</h2>
          <!-- test -->
            <?php if(session()->getFlashdata('error')): ?>
                <div class="swal-error" data-pesan="<?= session()->getFlashdata('error') ?>"></div>
            <?php endif; ?>
          <!-- test -->
          <div class="input-div one">
            <div class="i">
              <i class="fas fa-user"></i>
            </div>
            <div class="div">
              <h5>Username</h5>
              <input type="email" name="user_email" class="form-control input" required>
            </div>
          </div>
          <div class="input-div pass">
            <div class="i">
              <i class="fas fa-lock"></i>
            </div>
            <div class="div">
              <h5>Password</h5>
              <input type="password" name="password_hash" class="form-control input" required>
            </div>
          </div>
          <input type="submit" class="btn" value="Login" />
        </form>
      </div>
    </div>
    <script type="text/javascript" src="<?= base_url('assets/js/main.js') ?>"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
          // Ambil elemen pembawa pesan error
          const swalError = document.querySelector('.swal-error');

          if (swalError) {
              const pesan = swalError.getAttribute('data-pesan');
              Swal.fire({
                  icon: 'error',
                  title: 'Waduh...',
                  text: pesan,
                  timer: 2000, // Akan hilang otomatis dalam 3 detik
                  showConfirmButton: false, // Menghilangkan tombol OK agar bersih
                  timerProgressBar: true, // Menampilkan bar durasi di bawah
                  showClass: {
                      popup: 'animate__animated animate__fadeInDown'
                  },
                  hideClass: {
                      popup: 'animate__animated animate__fadeOutUp'
                  }
              });
          }
        });
    </script>
  </body>
</html>
