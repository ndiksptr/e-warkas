<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Warkas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; height: 100vh; display: flex; align-items: center; }
        .card-login { width: 100%; max-width: 400px; padding: 20px; border-radius: 15px; shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="card card-login bg-white shadow">
        <div class="card-body">
            <h3 class="text-center mb-4">E-WARKAS LOGIN</h3>
            
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger p-2 small text-center">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('loginProcess') ?>" method="post">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="user_email" class="form-control" placeholder="nama@email.com" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password_hash" class="form-control" placeholder="Masukkan password" required>
                </div>
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Masuk ke Sistem</button>
                </div>
            </form>
            
            <p class="text-center mt-3 text-muted small">&copy; 2025 E-Warkas System</p>
        </div>
    </div>
</div>

</body>
</html>