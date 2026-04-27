<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System - JMI IT Ticketing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            /* Latar belakang selaras dengan halaman depan */
            background: linear-gradient(135deg, #f0f4ff 0%, #e1eafc 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            margin: 20px;
        }
        .login-left {
            /* Background panel kiri dengan gradien biru elegan */
            background: linear-gradient(135deg, #1a56db 0%, #0d3b9e 100%);
            color: white;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-right {
            padding: 50px;
        }
        .form-control {
            background-color: #f8fbff;
            border: 1px solid #d1e3ff;
            padding: 12px 15px;
            border-radius: 8px;
        }
        .form-control:focus {
            background-color: #fff;
            border-color: #1a56db;
            box-shadow: 0 0 0 0.25rem rgba(26, 86, 219, 0.15);
        }
        .input-group-text {
            background-color: #f8fbff;
            border: 1px solid #d1e3ff;
            border-right: none;
            color: #6c757d;
            border-radius: 8px 0 0 8px;
        }
        .form-control {
            border-left: none;
        }
        .btn-login {
            background-color: #1a56db;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background-color: #1543ab;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 86, 219, 0.3);
        }
        .back-link {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }
        .back-link:hover {
            color: white;
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center">
        <div class="row login-card">
            
            <div class="col-md-5 login-left d-none d-md-flex">
                <div class="mb-4">
                    <i class="fa-solid fa-shield-halved fa-3x mb-3 text-white opacity-75"></i>
                    <h3 class="fw-bolder mb-3">JMI Ticketing</h3>
                    <p class="mb-4" style="line-height: 1.6; opacity: 0.9;">
                        Masuk ke panel administrator untuk mengelola tiket, memantau performa teknisi, dan mengatur hak akses pengguna aplikasi IT Helpdesk secara terpusat.
                    </p>
                </div>
                
                <div class="mt-auto">
                    <a href="/" class="back-link">
                        <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>

            <div class="col-md-7 login-right">
                
                <div class="d-flex align-items-center gap-3 mb-4 pb-2 border-bottom">
                    <img src="/assets/img/logo-jmi.png" alt="JMI" style="height: 35px; object-fit: contain;">
                    <span class="text-secondary opacity-25" style="font-size: 1.5rem; line-height: 1;">|</span>
                    <img src="/assets/img/onemed-logo.png" alt="OneMed" style="height: 28px; object-fit: contain;">
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold text-dark mb-1">Selamat Datang Kembali</h4>
                    <p class="text-muted small">Silakan masuk menggunakan akun IT atau Admin Anda.</p>
                </div>

                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger py-2 small fw-bold">
                        <i class="fa-solid fa-circle-exclamation me-1"></i> <?= session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <form action="/login/process" method="post">
                    <?= csrf_field(); ?>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold small mb-1">Email Perusahaan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" class="form-control" name="email" placeholder="superadmin@jmi.com" required autofocus>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted fw-bold small mb-1">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" class="form-control" name="password" placeholder="Masukkan password Anda" required>
                        </div>
                    </div>

                    <!-- <div class="d-flex justify-content-between align-items-center mb-4 small">
                        <div class="form-check">
                            <input class="form-check-input shadow-sm" type="checkbox" id="ingatSaya">
                            <label class="form-check-label text-muted" for="ingatSaya">Ingat Saya</label>
                        </div>
                        <a href="#" class="text-primary text-decoration-none fw-bold">Lupa Password?</a>
                    </div> -->

                    <button type="submit" class="btn btn-primary btn-login w-100 text-white shadow">
                        Masuk ke Sistem <i class="fa-solid fa-arrow-right-to-bracket ms-1"></i>
                    </button>
                </form>

                <div class="mt-4 text-center d-block d-md-none">
                    <a href="/" class="text-muted text-decoration-none small">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>

            </div>
        </div>
    </div>

</body>
</html>