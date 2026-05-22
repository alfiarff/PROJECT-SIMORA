<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI-MORA — Sistem Informasi Monitoring dan Resep Obat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --maroon: #75162d;
            --maroon-dark: #3b010b;
            --maroon-light: #9b2d45;
            --cream: #f2d9a0;
            --cream-light: #f2e5c6;
            --cream-bg: #f3e9d7;
            --white: #ffffff;
            --dark: #1a1a1a;
            --gray-700: #555566;
            --gray-500: #777788;
            --gray-400: #9999AA;
            --gray-200: #e0e0e8;
            --gray-100: #f0f0f5;
            --light-bg: #f8f7f4;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            overflow-x: hidden;
            background: var(--white);
        }

        ::selection { background: var(--maroon); color: var(--white); }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--gray-100); }
        ::-webkit-scrollbar-thumb { background: var(--maroon); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--maroon-dark); }

        /* NAVBAR */
        .navbar-landing {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            padding: 16px 0; transition: all 0.4s cubic-bezier(0.25,0.46,0.45,0.94);
        }
        .navbar-landing.scrolled {
            background: rgba(255,255,255,0.95); backdrop-filter: blur(20px);
            box-shadow: 0 4px 30px rgba(117,22,45,0.08); padding: 10px 0;
        }
        .navbar-landing.scrolled .nav-link { color: var(--gray-700) !important; }
        .navbar-landing.scrolled .nav-link:hover { color: var(--maroon) !important; }
        .navbar-landing.scrolled .logo-text { color: var(--maroon) !important; }

        .logo-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-img { height: 44px; width: auto; transition: all 0.4s; }
        .logo-text { font-weight: 800; font-size: 1.5rem; color: var(--white); letter-spacing: -0.02em; transition: color 0.4s; }

        .nav-link {
            color: rgba(255,255,255,0.85) !important; font-weight: 500; font-size: 0.9rem;
            padding: 8px 18px !important; border-radius: 8px; transition: all 0.3s;
        }
        .nav-link:hover { color: var(--white) !important; background: rgba(255,255,255,0.1); }

        .btn-login-nav {
            background: rgba(255,255,255,0.15); border: 1.5px solid rgba(255,255,255,0.3);
            color: var(--white) !important; padding: 8px 28px !important; border-radius: 50px !important;
            font-weight: 600; font-size: 0.9rem; transition: all 0.3s;
        }
        .btn-login-nav:hover { background: var(--white); color: var(--maroon) !important; border-color: var(--white); transform: translateY(-1px); }
        .navbar-landing.scrolled .btn-login-nav { background: var(--maroon); border-color: var(--maroon); color: var(--white) !important; }
        .navbar-landing.scrolled .btn-login-nav:hover { background: var(--maroon-dark); border-color: var(--maroon-dark); color: var(--white) !important; }

        .navbar-toggler { border: none !important; padding: 4px 8px !important; }
        .navbar-toggler:focus { box-shadow: none !important; }
        .navbar-toggler-icon-custom { display: flex; flex-direction: column; gap: 5px; padding: 4px; }
        .navbar-toggler-icon-custom span { display: block; width: 24px; height: 2.5px; background: var(--white); border-radius: 2px; transition: all 0.3s; }
        .navbar-landing.scrolled .navbar-toggler-icon-custom span { background: var(--maroon); }

        @media (max-width: 991px) {
            .navbar-collapse {
                background: rgba(255,255,255,0.98); backdrop-filter: blur(20px);
                border-radius: 16px; padding: 20px; margin-top: 12px; box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            }
            .navbar-collapse .nav-link { color: var(--gray-700) !important; padding: 12px 16px !important; }
            .navbar-collapse .nav-link:hover { color: var(--maroon) !important; background: rgba(117,22,45,0.05); }
            .navbar-collapse .btn-login-nav { background: var(--maroon) !important; border-color: var(--maroon) !important; color: var(--white) !important; text-align: center; margin-top: 8px; }
        }

        /* HERO + STATS */
        .hero-section {
            background: linear-gradient(135deg, var(--maroon-dark) 0%, var(--maroon) 50%, var(--maroon-light) 100%);
            position: relative; overflow: hidden; padding-bottom: 100px;
        }
        .hero-section::before {
            content: ''; position: absolute; top: -50%; right: -20%; width: 80%; height: 200%;
            background: radial-gradient(ellipse, rgba(242,217,160,0.06) 0%, transparent 60%);
            animation: heroGlow 8s ease-in-out infinite alternate;
        }
        @keyframes heroGlow { 0% { transform: translate(0,0) scale(1); } 100% { transform: translate(-5%,3%) scale(1.1); } }

        .hero-particles { position: absolute; inset: 0; overflow: hidden; z-index: 1; }
        .particle { position: absolute; background: rgba(242,217,160,0.08); border-radius: 50%; animation: floatParticle linear infinite; }
        @keyframes floatParticle {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; } 90% { opacity: 1; }
            100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
        }

        .hero-content { position: relative; z-index: 3; padding-top: 120px; max-width: 720px; }
        .hero-title {
            font-size: clamp(2.5rem,5.5vw,4.2rem); font-weight: 800; color: var(--white);
            line-height: 1.08; letter-spacing: -0.03em; margin-bottom: 24px; animation: fadeInUp 0.8s ease-out;
            text-shadow: 0 0 20px rgba(255,255,255,0.15), 0 0 40px rgba(255,255,255,0.08), 0 0 80px rgba(255,255,255,0.04), 0 2px 4px rgba(0,0,0,0.2);
        }
        .hero-title .highlight {
            background: linear-gradient(135deg, var(--cream), var(--cream-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-shadow: none;
        }
        .hero-desc {
            font-size: 1.1rem; color: rgba(255,255,255,0.85); line-height: 1.7; max-width: 560px;
            margin-bottom: 0; font-weight: 300; animation: fadeInUp 0.8s ease-out 0.15s both;
            text-shadow: 0 0 15px rgba(255,255,255,0.12), 0 0 30px rgba(255,255,255,0.06), 0 1px 3px rgba(0,0,0,0.15);
        }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

        /* STATS */
        .stats-bar { position: relative; z-index: 5; margin-top: 60px; }
        .stats-card {
            background: var(--white); border-radius: 30px; padding: 48px 40px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.15); display: grid; grid-template-columns: repeat(3,1fr); gap: 0;
        }
        .stat-item { text-align: center; padding: 10px 20px; border-right: 1px solid var(--gray-200); }
        .stat-item:last-child { border-right: none; }
        .stat-number { font-size: 2.8rem; font-weight: 800; color: var(--maroon); line-height: 1; margin-bottom: 8px; }
        .stat-label { font-size: 0.88rem; color: var(--gray-500); font-weight: 400; }

        /* SECTION COMMON */
        .section-tag { display: inline-flex; align-items: center; gap: 8px; background: rgba(117,22,45,0.06); color: var(--maroon); padding: 6px 18px; border-radius: 50px; font-size: 0.8rem; font-weight: 600; margin-bottom: 16px; }
        .section-title { font-size: clamp(1.8rem,3.5vw,2.6rem); font-weight: 800; color: var(--dark); line-height: 1.15; letter-spacing: -0.02em; margin-bottom: 16px; }
        .section-desc { font-size: 1.05rem; color: var(--gray-700); line-height: 1.7; max-width: 600px; font-weight: 300; }

        /* FEATURES */
        .features-section { padding: 80px 0 100px; background: var(--white); }
        .feature-card {
            background: var(--white); border: 1px solid var(--gray-200); border-radius: 20px; padding: 36px 28px;
            transition: all 0.4s cubic-bezier(0.25,0.46,0.45,0.94); height: 100%; position: relative; overflow: hidden;
        }
        .feature-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--cream), var(--maroon)); transform: scaleX(0); transform-origin: left; transition: transform 0.4s; }
        .feature-card:hover::before { transform: scaleX(1); }
        .feature-card:hover { transform: translateY(-8px); box-shadow: 0 20px 50px rgba(117,22,45,0.1); border-color: transparent; }

        .feature-icon { width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; margin-bottom: 20px; transition: transform 0.3s; }
        .feature-card:hover .feature-icon { transform: scale(1.1); }
        .feature-icon.maroon { background: rgba(117,22,45,0.08); color: var(--maroon); }
        .feature-icon.cream { background: rgba(242,217,160,0.35); color: var(--maroon-dark); }
        .feature-title { font-size: 1.15rem; font-weight: 700; color: var(--dark); margin-bottom: 10px; }
        .feature-text { font-size: 0.9rem; color: var(--gray-700); line-height: 1.65; font-weight: 300; }

        /* AKTOR */
        .actors-section { padding: 100px 0; background: var(--light-bg); }
        .actor-card {
            background: var(--white); border-radius: 24px; padding: 48px 32px; text-align: center;
            transition: all 0.4s cubic-bezier(0.25,0.46,0.45,0.94); height: 100%; border: 1px solid transparent;
            position: relative; overflow: hidden; box-shadow: 0 3px 15px rgba(0,0,0,0.04);
        }
        .actor-card::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--cream), var(--maroon)); transform: scaleX(0); transition: transform 0.4s; }
        .actor-card:hover::after { transform: scaleX(1); }
        .actor-card:hover { transform: translateY(-10px); box-shadow: 0 25px 60px rgba(117,22,45,0.1); }

        .actor-avatar { width: 80px; height: 80px; border-radius: 24px; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 24px; }
        .actor-avatar.pmik { background: rgba(117,22,45,0.08); color: var(--maroon); }
        .actor-avatar.dokter { background: linear-gradient(135deg, var(--cream-light), var(--cream)); color: var(--maroon-dark); }
        .actor-avatar.apoteker { background: rgba(117,22,45,0.05); color: var(--maroon); }
        .actor-name { font-size: 1.4rem; font-weight: 700; color: var(--dark); margin-bottom: 8px; }
        .actor-role { font-size: 0.9rem; color: var(--maroon); font-weight: 500; }

        /* ALUR */
        .flow-section { padding: 100px 0; background: var(--white); }
        .flow-container { position: relative; max-width: 900px; margin: 0 auto; }
        .flow-line { position: absolute; left: 40px; top: 0; bottom: 0; width: 3px; background: linear-gradient(180deg, var(--cream), var(--maroon)); border-radius: 3px; }
        .flow-step { display: flex; gap: 32px; margin-bottom: 48px; position: relative; opacity: 0; transform: translateY(30px); transition: all 0.6s ease-out; }
        .flow-step.visible { opacity: 1; transform: translateY(0); }
        .flow-step:last-child { margin-bottom: 0; }

        .flow-number { width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800; flex-shrink: 0; position: relative; z-index: 2; }
        .flow-number.step-1 { background: linear-gradient(135deg, #E3F2FD, #BBDEFB); color: #1565C0; box-shadow: 0 8px 25px rgba(21,101,192,0.15); }
        .flow-number.step-2 { background: linear-gradient(135deg, var(--maroon), var(--maroon-light)); color: var(--white); box-shadow: 0 8px 25px rgba(117,22,45,0.2); }
        .flow-number.step-3 { background: linear-gradient(135deg, var(--cream), var(--cream-light)); color: var(--maroon-dark); box-shadow: 0 8px 25px rgba(242,217,160,0.35); }

        .flow-content { background: var(--white); border: 1px solid var(--gray-200); border-radius: 20px; padding: 28px 32px; flex: 1; transition: all 0.3s; }
        .flow-content:hover { box-shadow: 0 15px 40px rgba(117,22,45,0.08); border-color: rgba(117,22,45,0.1); }

        .flow-actor { font-size: 0.78rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 6px; }
        .flow-actor.pmik { color: #1565C0; }
        .flow-actor.dokter { color: var(--maroon); }
        .flow-actor.apoteker { color: var(--maroon-dark); }
        .flow-title { font-size: 1.25rem; font-weight: 700; color: var(--dark); margin-bottom: 10px; }
        .flow-desc { font-size: 0.9rem; color: var(--gray-700); line-height: 1.65; font-weight: 300; }
        .flow-steps-list { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 14px; }
        .flow-step-tag { background: rgba(117,22,45,0.06); color: var(--maroon); padding: 4px 14px; border-radius: 50px; font-size: 0.78rem; font-weight: 500; }

        /* CTA */
        .cta-section { padding: 100px 0; background: var(--white); }
        .cta-card {
            background: linear-gradient(135deg, var(--maroon-dark), var(--maroon)); border-radius: 32px;
            padding: 72px 60px; text-align: center; position: relative; overflow: hidden;
        }
        .cta-card::before { content: ''; position: absolute; top: -100px; right: -100px; width: 350px; height: 350px; background: radial-gradient(circle, rgba(242,217,160,0.1), transparent 60%); border-radius: 50%; }
        .cta-card::after { content: ''; position: absolute; bottom: -80px; left: -80px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(255,255,255,0.03), transparent 60%); border-radius: 50%; }
        .cta-title { font-size: clamp(1.8rem,3.5vw,2.6rem); font-weight: 800; color: var(--white); margin-bottom: 16px; position: relative; z-index: 2; }
        .cta-desc { font-size: 1.05rem; color: rgba(255,255,255,0.65); max-width: 520px; margin: 0 auto 36px; font-weight: 300; line-height: 1.7; position: relative; z-index: 2; }
        .btn-cta {
            background: var(--white); color: var(--maroon-dark); padding: 16px 44px; border-radius: 50px;
            font-weight: 700; font-size: 1rem; border: none; cursor: pointer; transition: all 0.3s;
            display: inline-flex; align-items: center; gap: 10px; text-decoration: none;
            position: relative; z-index: 2; box-shadow: 0 8px 30px rgba(255,255,255,0.15);
        }
        .btn-cta:hover { transform: translateY(-3px); box-shadow: 0 15px 45px rgba(255,255,255,0.25); color: var(--maroon-dark); background: var(--white); }

        /* FOOTER */
        .footer {
            background: var(--maroon-dark);
            padding: 30px 0;
            text-align: center;
        }
        .footer-copyright {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.5);
            margin: 0;
            font-weight: 300;
        }

        /* ANIMATIONS */
        .animate-on-scroll { opacity: 0; transform: translateY(30px); transition: all 0.7s ease-out; }
        .animate-on-scroll.visible { opacity: 1; transform: translateY(0); }

        /* RESPONSIVE */
        @media (max-width: 991px) { .cta-card { padding: 50px 30px; } }
        @media (max-width: 767px) {
            .stats-card { grid-template-columns: 1fr; padding: 30px 24px; gap: 0; }
            .stat-item { border-right: none !important; border-bottom: 1px solid var(--gray-200); padding: 20px 10px; }
            .stat-item:last-child { border-bottom: none; }
            .flow-step { flex-direction: column; align-items: center; text-align: center; }
            .flow-line { display: none; }
            .flow-steps-list { justify-content: center; }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar-landing" id="mainNav">
        <div class="container">
            <nav class="navbar navbar-expand-lg p-0">
                <a href="#" class="logo-brand">
                    <img src="{{ asset('images/logosimora.png') }}" alt="SI-MORA" class="logo-img">
                    <span class="logo-text">SI-MORA</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                    <div class="navbar-toggler-icon-custom"><span></span><span></span><span></span></div>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navMenu">
                    <div class="d-flex align-items-center gap-1">
                        <a href="#fitur" class="nav-link">Fitur</a>
                        <a href="#aktor" class="nav-link">Aktor</a>
                        <a href="#alur" class="nav-link">Alur Kerja</a>
                        <a href="{{ route('login') }}" class="nav-link btn-login-nav ms-2">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </nav>

    <!-- HERO + STATS -->
    <section class="hero-section">
        <div class="hero-particles" id="particles"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 hero-content">
                    <h1 class="hero-title">Pelayanan Resep Obat <span class="highlight">Terintegrasi</span> & Digital</h1>
                    <p class="hero-desc">SI-MORA hadir sebagai sistem informasi yang terintegrasi antara PMIK, dokter, dan farmasi dalam satu sistem untuk pelayanan resep yang lebih cepat, tepat, dan efisien.</p>
                </div>
            </div>
        </div>
        <div class="container stats-bar">
            <div class="stats-card">
                <div class="stat-item">
                    <div class="stat-number" data-count="3">0</div>
                    <div class="stat-label">Aktor Terintegrasi</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" data-count="100">0</div>
                    <div class="stat-label">% Digital</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" data-count="1">0</div>
                    <div class="stat-label">Sistem Terpadu</div>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="features-section" id="fitur">
        <div class="container">
            <div class="text-center mb-5 animate-on-scroll">
                <div class="section-tag"><i class="bi bi-grid-3x3-gap-fill"></i> Fitur Unggulan</div>
                <h2 class="section-title">Dirancang untuk Pelayanan<br>Kesehatan yang Lebih Baik</h2>
                <p class="section-desc mx-auto">Setiap fitur SI-MORA dibangun untuk menjawab tantangan nyata dalam pelayanan resep obat — dari pencatatan hingga penyelesaian.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 animate-on-scroll">
                    <div class="feature-card">
                        <div class="feature-icon maroon"><i class="bi bi-speedometer2"></i></div>
                        <h3 class="feature-title">Pelayanan Lebih Cepat</h3>
                        <p class="feature-text">Eliminasi proses manual dan paper-based. Resep elektronik dikirim secara instan dari dokter ke farmasi tanpa delay.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 animate-on-scroll">
                    <div class="feature-card">
                        <div class="feature-icon cream"><i class="bi bi-shield-check"></i></div>
                        <h3 class="feature-title">Resep Akurat</h3>
                        <p class="feature-text">Validasi resep otomatis oleh apoteker mengurangi risiko kesalahan pencatatan dan pemberian obat yang tidak sesuai.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 animate-on-scroll">
                    <div class="feature-card">
                        <div class="feature-icon maroon"><i class="bi bi-activity"></i></div>
                        <h3 class="feature-title">Monitoring Real-time</h3>
                        <p class="feature-text">Pantau status pelayanan obat dari diagnosa hingga obat diberikan kepada pasien secara real-time dalam satu dashboard.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 animate-on-scroll">
                    <div class="feature-card">
                        <div class="feature-icon cream"><i class="bi bi-link-45deg"></i></div>
                        <h3 class="feature-title">Integrasi Alur Kerja</h3>
                        <p class="feature-text">PMIK, Dokter, dan Apoteker bekerja dalam satu sistem terhubung — tidak ada data yang terlewat atau terduplikasi.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 animate-on-scroll">
                    <div class="feature-card">
                        <div class="feature-icon maroon"><i class="bi bi-database-check"></i></div>
                        <h3 class="feature-title">Data Pasien Digital</h3>
                        <p class="feature-text">Pengelolaan identitas dan riwayat pasien secara digital. Pencarian cepat, data lengkap, dan selalu terkini.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 animate-on-scroll">
                    <div class="feature-card">
                        <div class="feature-icon cream"><i class="bi bi-printer"></i></div>
                        <h3 class="feature-title">Cetak Resep Mudah</h3>
                        <p class="feature-text">Resep yang sudah tervalidasi dapat dicetak langsung dari sistem — rapi, legal, dan siap diberikan kepada pasien.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- AKTOR -->
    <section class="actors-section" id="aktor">
        <div class="container">
            <div class="text-center mb-5 animate-on-scroll">
                <div class="section-tag"><i class="bi bi-people-fill"></i> Aktor Sistem</div>
                <h2 class="section-title">Tiga Pilar Pelayanan<br>yang Terhubung</h2>
                <p class="section-desc mx-auto">Setiap aktor memiliki peran khusus dalam alur pelayanan — semuanya terintegrasi dalam satu ekosistem SI-MORA.</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 animate-on-scroll">
                    <div class="actor-card">
                        <div class="actor-avatar pmik"><i class="bi bi-clipboard2-pulse"></i></div>
                        <h3 class="actor-name">PMIK</h3>
                        <p class="actor-role">Pengelola Data Pasien</p>
                    </div>
                </div>
                <div class="col-lg-4 animate-on-scroll">
                    <div class="actor-card">
                        <div class="actor-avatar dokter"><i class="bi bi-heart-pulse"></i></div>
                        <h3 class="actor-name">Dokter</h3>
                        <p class="actor-role">Diagnosa & Resep Elektronik</p>
                    </div>
                </div>
                <div class="col-lg-4 animate-on-scroll">
                    <div class="actor-card">
                        <div class="actor-avatar apoteker"><i class="bi bi-capsule-pill"></i></div>
                        <h3 class="actor-name">Apoteker</h3>
                        <p class="actor-role">Validasi & Pelayanan Obat</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ALUR -->
    <section class="flow-section" id="alur">
        <div class="container">
            <div class="text-center mb-5 animate-on-scroll">
                <div class="section-tag"><i class="bi bi-arrow-down-up"></i> Alur Kerja</div>
                <h2 class="section-title">Dari Pendaftaran<br>hingga Obat Diberikan</h2>
                <p class="section-desc mx-auto">Alur pelayanan yang jelas dan terintegrasi — setiap langkah terhubung secara otomatis dalam sistem.</p>
            </div>
            <div class="flow-container">
                <div class="flow-line"></div>
                <div class="flow-step">
                    <div class="flow-number step-1">1</div>
                    <div class="flow-content">
                        <div class="flow-actor pmik">PMIK — Pendaftaran</div>
                        <h3 class="flow-title">Input & Perbarui Data Pasien</h3>
                        <p class="flow-desc">PMIK mendaftarkan pasien baru atau memperbarui data pasien yang sudah terdaftar. Data tersimpan secara digital dan siap diakses oleh dokter.</p>
                        <div class="flow-steps-list">
                            <span class="flow-step-tag">Registrasi</span>
                            <span class="flow-step-tag">Verifikasi Data</span>
                            <span class="flow-step-tag">Rekam Medis</span>
                        </div>
                    </div>
                </div>
                <div class="flow-step">
                    <div class="flow-number step-2">2</div>
                    <div class="flow-content">
                        <div class="flow-actor dokter">Dokter — Pemeriksaan</div>
                        <h3 class="flow-title">Diagnosa & Resep Elektronik</h3>
                        <p class="flow-desc">Dokter memeriksa pasien, menginput hasil diagnosa, dan membuat resep obat elektronik. Resep otomatis dikirim ke bagian farmasi tanpa perlu media fisik.</p>
                        <div class="flow-steps-list">
                            <span class="flow-step-tag">Pemeriksaan</span>
                            <span class="flow-step-tag">Diagnosa</span>
                            <span class="flow-step-tag">E-Resep</span>
                            <span class="flow-step-tag">Kirim ke Farmasi</span>
                        </div>
                    </div>
                </div>
                <div class="flow-step">
                    <div class="flow-number step-3">3</div>
                    <div class="flow-content">
                        <div class="flow-actor apoteker">Apoteker — Pelayanan Obat</div>
                        <h3 class="flow-title">Validasi, Siapkan & Berikan Obat</h3>
                        <p class="flow-desc">Apoteker menerima resep dari dokter, melakukan validasi, mengecek ketersediaan stok, menyiapkan obat, dan menyelesaikan pelayanan. Resep dapat dicetak sebagai bukti.</p>
                        <div class="flow-steps-list">
                            <span class="flow-step-tag">Terima Resep</span>
                            <span class="flow-step-tag">Validasi</span>
                            <span class="flow-step-tag">Cek Stok</span>
                            <span class="flow-step-tag">Siapkan Obat</span>
                            <span class="flow-step-tag">Selesai</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-card animate-on-scroll">
                <h2 class="cta-title">Siap Memulai Pelayanan Digital?</h2>
                <p class="cta-desc">Bergabung dengan SI-MORA dan rasakan kemudahan pelayanan resep obat yang terintegrasi, cepat, dan akurat.</p>
                <a href="{{ route('login') }}" class="btn-cta">Masuk ke SI-MORA <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <p class="footer-copyright">&copy; 2026 Sistem Informasi Monitoring dan Resep Obat (SI-MORA)</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => { nav.classList.toggle('scrolled', window.scrollY > 50); });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    const navCollapse = document.getElementById('navMenu');
                    const bsCollapse = bootstrap.Collapse.getInstance(navCollapse);
                    if (bsCollapse) bsCollapse.hide();
                }
            });
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) { setTimeout(() => { entry.target.classList.add('visible'); }, index * 100); observer.unobserve(entry.target); }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
        document.querySelectorAll('.animate-on-scroll, .flow-step').forEach(el => observer.observe(el));

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = entry.target.querySelectorAll('[data-count]');
                    counters.forEach(counter => {
                        const target = parseInt(counter.dataset.count); let current = 0; const increment = target / 40;
                        const timer = setInterval(() => { current += increment; if (current >= target) { counter.textContent = target; clearInterval(timer); } else { counter.textContent = Math.ceil(current); } }, 40);
                    });
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        document.querySelectorAll('.stats-card').forEach(el => counterObserver.observe(el));

        const particlesContainer = document.getElementById('particles');
        for (let i = 0; i < 20; i++) {
            const particle = document.createElement('div'); particle.classList.add('particle');
            const size = Math.random() * 6 + 2; particle.style.width = size + 'px'; particle.style.height = size + 'px';
            particle.style.left = Math.random() * 100 + '%'; particle.style.animationDuration = (Math.random() * 15 + 10) + 's';
            particle.style.animationDelay = (Math.random() * 10) + 's'; particlesContainer.appendChild(particle);
        }
    </script>
</body>
</html>