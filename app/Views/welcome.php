<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Tiket IT JMI</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Pengaturan Dasar & Tipografi */
        body { 
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(135deg, #f4f7fe 0%, #e1eafc 100%); 
            min-height: 100vh; 
            display: flex; 
            flex-direction: column; 
            overflow-x: hidden;
            color: #2d3748;
        }

        /* Navigasi Glassmorphism */
        .navbar-glass { 
            background: rgba(255, 255, 255, 0.75); 
            backdrop-filter: blur(12px); 
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
            padding-top: 15px; 
            padding-bottom: 15px; 
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .hero-section { flex: 1; display: flex; align-items: center; padding-top: 40px; padding-bottom: 60px; }
        
        /* Desain Kartu Ilustrasi Premium */
        .illustration-card { 
            background: rgba(255, 255, 255, 0.85); 
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 1);
            border-radius: 24px; 
            box-shadow: 0 20px 50px rgba(26, 86, 219, 0.08); 
            padding: 50px 40px; 
            text-align: center; 
            position: relative; 
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }
        .illustration-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(26, 86, 219, 0.12);
        }

        /* Lingkaran Ikon di dalam Kartu */
        .icon-circle {
            background: linear-gradient(135deg, #e1eafc 0%, #c3d6fc 100%);
            width: 110px;
            height: 110px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            color: #1a56db;
            box-shadow: inset 0 4px 10px rgba(255, 255, 255, 0.5);
        }

        /* Badge Melayang */
        .badge-floating { 
            position: absolute; 
            background: white; 
            padding: 10px 18px; 
            border-radius: 50px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.06); 
            font-weight: 700; 
            font-size: 0.85rem; 
            display: flex; 
            align-items: center; 
            gap: 8px; 
            border: 1px solid #f0f0f0;
        }
        .badge-star { top: -20px; right: 20px; color: #ffc107; }
        .badge-respon { bottom: 25px; left: -25px; color: #198754; }

        /* Animasi Tombol Interaktif */
        .btn-hover-scale { transition: all 0.3s ease; }
        .btn-hover-scale:hover { 
            transform: translateY(-3px); 
            box-shadow: 0 10px 20px rgba(26, 86, 219, 0.2) !important; 
        }
        
        /* Animasi Muncul (Fade In Up) */
        .fade-in-up { animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; transform: translateY(25px); }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }

        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-glass">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3 fade-in-up" href="/">
                <img src="/assets/img/logo-jmi.png" alt="JMI" style="height: 35px; object-fit: contain;">
                <span class="text-secondary opacity-25" style="font-size: 1.5rem; line-height: 1;">|</span>
                <img src="/assets/img/onemed-logo.png" alt="OneMed" style="height: 28px; object-fit: contain;">
                <span class="fw-bolder text-dark ms-1" style="font-size: 1.2rem; letter-spacing: 0.2px; margin-top: 2px;">
                    Sistem Tiket <span style="color: #1a56db;">IT</span>
                </span>
            </a>
        </div>
    </nav>

    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                
                <div class="col-lg-6 mb-5 mb-lg-0 pe-lg-5">
                    <div class="d-inline-flex align-items-center bg-white rounded-pill px-3 py-2 mb-4 shadow-sm border border-primary border-opacity-25 fade-in-up delay-1">
                        <i class="fa-solid fa-building-circle-check text-primary me-2"></i>
                        <span class="text-primary fw-bold" style="font-size: 0.85rem;">Sistem Internal JMI Terpadu</span>
                    </div>
                    
                    <h1 class="display-4 fw-bolder text-dark mb-4 fade-in-up delay-2" style="line-height: 1.2; letter-spacing: -1px;">
                        Aplikasi Layanan <br>Bantuan Tiket <br><span style="color: #1a56db;">IT Perusahaan</span>
                    </h1>
                    
                    <p class="text-secondary mb-5 fade-in-up delay-3" style="font-size: 1.15rem; line-height: 1.7; font-weight: 400;">
                        Solusi terbaik untuk melaporkan, melacak, dan menyelesaikan kendala IT (Perangkat Lunak, Perangkat Keras, maupun Jaringan) di lingkungan Perusahaan secara cepat, transparan, dan terpusat.
                    </p>
                    
                    <div class="d-flex flex-wrap gap-3 fade-in-up delay-4">
                        <a href="/tiket/buat" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm text-white fw-bold d-flex align-items-center gap-2 btn-hover-scale" style="background-color: #1a56db; border: none;">
                            <i class="fa-solid fa-plus-circle"></i> Buat Tiket Baru
                        </a>
                        <a href="/tiket/lacak" class="btn btn-white btn-lg rounded-pill px-5 shadow-sm bg-white border fw-bold text-primary d-flex align-items-center gap-2 btn-hover-scale">
                            <i class="fa-solid fa-magnifying-glass"></i> Lacak Tiket
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-5 position-relative fade-in-up delay-3">
                    <div class="illustration-card">
                        <div class="badge-floating badge-star">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        </div>
                        
                        <div class="icon-circle">
                            <i class="fa-solid fa-headset" style="font-size: 3.5rem;"></i>
                        </div>
                        
                        <h4 class="fw-bolder text-dark mb-2">Dasbor Dukungan IT</h4>
                        <p class="text-secondary small mb-4 fw-medium">Pusat Layanan Bantuan IT Internal</p>
                        
                        <div class="mt-4 pt-4 border-top border-light d-flex justify-content-center gap-4 align-items-center">
                            <img src="/assets/img/logo-jmi.png" height="22" style="filter: grayscale(100%) opacity(60%); transition: all 0.3s;" onmouseover="this.style.filter='none'">
                            <span class="text-muted opacity-50">|</span>
                            <img src="/assets/img/onemed-logo.png" height="16" style="filter: grayscale(100%) opacity(60%); transition: all 0.3s;" onmouseover="this.style.filter='none'">
                        </div>
                        
                        <div class="badge-floating badge-respon">
                            <i class="fa-solid fa-circle-check fs-6"></i> Respon Cepat
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>