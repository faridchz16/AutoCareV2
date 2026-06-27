<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoCare | Gestión de Mantenimiento Vehicular</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <style>
        :root {
            --bg-dark: #08142F;
            --bg-dark-2: #0B1736;

            --primary: #06B6D4;
            --primary-hover: #22D3EE;
            --primary-2: #2563EB;

            --text-title: #0F172A;
            --text-body: #475569;
            --text-light: #E2E8F0;
            --text-muted: #94A3B8;

            --bg-light: #DCEBFF;
            --section-soft: #E8F2FF;
            --card-bg: #FFFFFF;
            --border: #C7D8EE;

            --card-shadow: 0 14px 34px rgba(15, 23, 42, 0.10);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg-light);
            color: var(--text-title);
            line-height: 1.6;
        }

        a {
            text-decoration: none;
        }

        .container {
            width: min(1180px, 92%);
            margin: 0 auto;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: rgba(8, 20, 47, 0.96);
            border-bottom: 1px solid rgba(226, 232, 240, 0.08);
            backdrop-filter: blur(10px);
        }

        .navbar-inner {
            height: 82px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-light);
            font-weight: 700;
            font-size: 20px;
        }

        .brand-logo{
            width:85px;
            height:85px;
            object-fit:contain;
            border-radius:50%;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .nav-links a {
            color: #E2E8F0;
            font-size: 14px;
            font-weight: 600;

            padding: 12px 24px;

            border-radius: 14px;

            border: 1px solid rgba(6, 182, 212, 0.45);

            background: transparent;

            transition: all .3s ease;
        }

        .nav-links a:hover {
            color: #FFFFFF;

            background: rgba(6, 182, 212, 0.12);

            border: 1px solid #06B6D4;

            transform: translateY(-2px);

            box-shadow: 0 0 15px rgba(6,182,212,.20);
        }

        .nav-links a.active {
            color: #FFFFFF;

            background: rgba(6,182,212,.15);

            border: 1px solid #06B6D4;

            box-shadow: 0 0 15px rgba(6,182,212,.20);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            transition: .3s;
            cursor: pointer;
        }

        .btn-outline {
            border: 1px solid rgba(6, 182, 212, 0.7);
            color: var(--text-light);
            background: transparent;
        }

        .btn-outline:hover {
            background: rgba(6, 182, 212, 0.14);
            color: #FFFFFF;
        }

        .btn-primary {
            background: var(--primary);
            color: #071B2C;
            border: none;
            box-shadow: 0 8px 18px rgba(6, 182, 212, 0.24);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            background: var(--primary-hover);
        }

        .btn-white {
            background: #F8FAFC;
            color: var(--primary-2);
            border: none;
        }

        .btn-white:hover {
            transform: translateY(-2px);
            background: #E2E8F0;
        }

        .menu-toggle {
            display: none;
            background: transparent;
            border: 1px solid rgba(226,232,240,0.14);
            color: var(--text-light);
            border-radius: 10px;
            width: 42px;
            height: 42px;
            cursor: pointer;
        }

        .menu-toggle svg {
            width: 22px;
            height: 22px;
        }

        .mobile-menu {
            display: none;
            background: var(--bg-dark);
            border-top: 1px solid rgba(226,232,240,0.08);
            padding: 18px 0 20px;
        }

        .mobile-menu.active {
            display: block;
        }

        .mobile-menu a {
            display: block;
            color: var(--text-light);
            padding: 10px 0;
            font-size: 15px;
        }

        .mobile-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 16px;
        }

        .hero {
            background:
                radial-gradient(circle at 10% 10%, rgba(6,182,212,.16), transparent 25%),
                radial-gradient(circle at 90% 90%, rgba(37,99,235,.18), transparent 26%),
                linear-gradient(135deg, var(--bg-dark) 0%, var(--bg-dark-2) 100%);
            min-height: 760px;
            padding-top: 120px;
            display: flex;
            align-items: center;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero-content h1 {
            color: #F8FAFC;
            font-size: clamp(42px, 5vw, 68px);
            line-height: 1.1;
            font-weight: 800;
            margin-bottom: 28px;
            letter-spacing: -1px;
        }

        .hero-content h1 span {
            color: var(--primary-hover);
        }

        .hero-content p {
            color: var(--text-light);
            max-width: 560px;
            font-size: 18px;
            margin-bottom: 32px;
        }

        .hero-button {
            margin-bottom: 38px;
        }

        .hero-stats {
            display: flex;
            gap: 34px;
            flex-wrap: wrap;
        }

        .hero-stats .item strong {
            display: block;
            font-size: 22px;
            color: var(--primary-hover);
            margin-bottom: 4px;
        }

        .hero-stats .item span {
            color: var(--text-muted);
            font-size: 14px;
        }

        .hero-card-wrap {
            position: relative;
        }

        .floating-top {
            position: absolute;
            top: -18px;
            right: -10px;
            background: var(--primary);
            color: #071B2C;
            font-weight: 700;
            font-size: 13px;
            padding: 10px 18px;
            border-radius: 999px;
            box-shadow: 0 12px 25px rgba(6,182,212,.25);
            z-index: 2;
        }

        .floating-bottom {
            position: absolute;
            bottom: -18px;
            left: -18px;
            background: var(--primary-2);
            color: #F8FAFC;
            font-weight: 700;
            font-size: 13px;
            padding: 10px 18px;
            border-radius: 999px;
            box-shadow: 0 12px 25px rgba(37,99,235,.25);
            z-index: 2;
        }

        .hero-image-card {
            border-radius: 30px;
            padding: 12px;
            background: linear-gradient(180deg, rgba(6,182,212,.22), rgba(37,99,235,.14));
            border: 1px solid rgba(6,182,212,0.20);
            box-shadow: 0 30px 70px rgba(0,0,0,.28);
        }

        .hero-image-card img {
            width: 100%;
            height: 430px;
            display: block;
            object-fit: cover;
            border-radius: 24px;
        }

        .section-light {
            background: var(--bg-light);
            padding: 100px 0;
        }

        .section-white {
            background: var(--section-soft);
            padding: 100px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 52px;
        }

        .section-title h2 {
            font-size: 46px;
            font-weight: 800;
            color: var(--text-title);
            margin-bottom: 10px;
        }

        .section-title p {
            color: var(--text-body);
            font-size: 18px;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .service-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 22px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: .3s;
        }

        .service-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 45px rgba(15,23,42,.14);
        }

        .service-img {
            height: 165px;
            overflow: hidden;
            background: var(--bg-dark-2);
        }

        .service-img img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            transition: .4s;
        }

        .service-card:hover .service-img img {
            transform: scale(1.06);
        }

        .service-body {
            padding: 24px;
        }

        .service-icon {
            width: 52px;
            height: 52px;
            margin-top: -50px;
            margin-bottom: 18px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #F8FAFC;
            position: relative;
            box-shadow: 0 12px 25px rgba(6,182,212,.28);
        }

        .service-icon svg {
            width: 24px;
            height: 24px;
        }

        .service-card h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: var(--text-title);
        }

        .service-card p {
            font-size: 14px;
            color: var(--text-body);
        }

        .numbers-section {
            background: var(--bg-dark);
            padding: 80px 0;
        }

        .numbers-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            text-align: center;
        }

        .number-item .icon {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            margin: 0 auto 18px;
            background: rgba(6,182,212,0.10);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-hover);
        }

        .number-item .icon svg {
            width: 32px;
            height: 32px;
        }

        .number-item h3 {
            color: #F8FAFC;
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .number-item p {
            color: var(--text-muted);
            font-size: 18px;
        }

        .benefits-layout {
            display: grid;
            grid-template-columns: .95fr 1.05fr;
            gap: 36px;
            align-items: center;
        }

        .benefit-image {
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 22px 50px rgba(15,23,42,.16);
            border: 1px solid var(--border);
        }

        .benefit-image img {
            width: 100%;
            height: 520px;
            object-fit: cover;
            display: block;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .benefit-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 26px;

            display: flex;
            gap: 18px;
            align-items: flex-start;

            box-shadow: var(--card-shadow);

            transition: all 0.35s ease;

            cursor: default;
            position: relative;
            overflow: hidden;
        }

        .benefit-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;

            width: 100%;
            height: 100%;

            background: linear-gradient(
                90deg,
                transparent,
                rgba(6, 182, 212, 0.12),
                transparent
            );

            transition: 0.6s;
        }

        .benefit-card:hover::before {
            left: 100%;
        }

        .benefit-card:hover {
            transform: translateY(-10px) scale(1.03);

            border-color: #06B6D4;

            box-shadow:
                0 25px 50px rgba(6,182,212,.20),
                0 15px 30px rgba(15,23,42,.12);
        }

        .benefit-icon {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            background: var(--primary);
            color: #F8FAFC;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .benefit-icon svg {
            width: 24px;
            height: 24px;
        }

        .benefit-text h3 {
            font-size: 18px;
            color: var(--text-title);
            margin-bottom: 8px;
        }

        .benefit-text p {
            font-size: 15px;
            color: var(--text-body);
        }

        .cta-section {
            position: relative;
            overflow: hidden;
            text-align: center;
            padding: 105px 0;
            background-image:
                linear-gradient(135deg, rgba(6,182,212,.92), rgba(37,99,235,.92)),
                url("{{ asset('images/autocare/cta-autocare.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .cta-section h2 {
            color: #F8FAFC;
            font-size: 52px;
            font-weight: 800;
            margin-bottom: 14px;
        }

        .cta-section p {
            color: #E2E8F0;
            font-size: 18px;
            max-width: 760px;
            margin: 0 auto 34px;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .footer {
            background: var(--bg-dark);
            padding: 64px 0 20px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr 1fr 1fr;
            gap: 30px;
            padding-bottom: 34px;
            border-bottom: 1px solid rgba(226,232,240,.08);
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #F8FAFC;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .footer p,
        .footer a,
        .footer li {
            color: var(--text-muted);
            font-size: 15px;
            list-style: none;
            margin-bottom: 10px;
            display: block;
        }

        .footer h4 {
            color: #F8FAFC;
            font-size: 18px;
            margin-bottom: 18px;
        }

        .footer-contact p{
            display:flex;
            align-items:center;
            gap:14px;
            margin-bottom:18px;
            color:var(--text-muted);
            font-size:15px;
        }

        .footer-contact i{
            width:22px;
            color:var(--primary);
            font-size:18px;
        }

        .socials {
            display: flex;
            gap: 12px;
        }

        .socials span {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(6,182,212,0.10);
            color: var(--primary-hover);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px;
        }

        .copyright {
            text-align: center;
            color: var(--text-muted);
            font-size: 14px;
            padding-top: 20px;
        }
        .contact-section {
            background: var(--bg-dark);
            padding: 100px 0;
        }

        .contact-section .section-title h2 {
            color: #F8FAFC;
        }

        .contact-section .section-title p {
            color: var(--text-muted);
        }

        .contact-layout{
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .contact-info{
            width:100%;
            max-width:1100px;
            text-align:center;

            background:rgba(255,255,255,.04);
            border:1px solid rgba(6,182,212,.25);
            border-radius:28px;
            padding:50px;
            box-shadow:0 24px 55px rgba(0,0,0,.22);
        }

        .contact-info h3{
            font-size:34px;
            color:#fff;
            margin-bottom:18px;
            text-align:center;
        }

        .contact-info > p{
            color:#CBD5E1;
            font-size:18px;
            max-width:700px;
            margin:0 auto 45px;
            text-align:center;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }

        .contact-item{
            display:flex;
            align-items:center;
            gap:18px;

            padding:28px;
            border-radius:22px;

            background:rgba(255,255,255,.05);
            border:1px solid rgba(6,182,212,.16);

            transition:.35s;
        }

        .contact-item div:last-child{
            text-align:left;
        }

        .contact-item:hover {
            transform: translateY(-6px);
            border-color: #06B6D4;
            box-shadow: 0 18px 35px rgba(6,182,212,.16);
        }

        .contact-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .contact-icon svg {
            width: 24px;
            height: 24px;
        }

        .contact-item strong {
            display: block;
            color: #F8FAFC;
            margin-bottom: 5px;
            font-size: 16px;
        }

        .contact-item p {
            color: #CBD5E1;
            margin: 0;
            font-size: 15px;
        }

        @media (max-width: 768px) {
            .contact-grid {
                grid-template-columns: 1fr;
            }
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: var(--text-title);
            font-weight: 700;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 14px 16px;
            font-size: 15px;
            color: var(--text-title);
            background: #F8FAFC;
            outline: none;
            transition: .3s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: var(--primary);
            background: #FFFFFF;
            box-shadow: 0 0 0 4px rgba(6,182,212,.12);
        }

        .contact-btn {
            width: 100%;
            margin-top: 6px;
        }
        @media (max-width: 1024px) {
            .hero-grid,
            .benefits-layout {
                grid-template-columns: 1fr;
            .contact-layout {
                grid-template-columns: 1fr;
            }
            }

            .services-grid,
            .numbers-grid,
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero-image-card img,
            .benefit-image img {
                height: 420px;
            }
        }

        @media (max-width: 768px) {
            .nav-links,
            .nav-actions {
                display: none;
            }

            .menu-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .hero {
                min-height: auto;
                padding-top: 130px;
                padding-bottom: 70px;
            }

            .services-grid,
            .numbers-grid,
            .footer-grid {
                grid-template-columns: 1fr;
            }

            .section-title h2,
            .cta-section h2 {
                font-size: 34px;
            }

            .hero-content h1 {
                font-size: 42px;
            }

            .hero-image-card img,
            .benefit-image img {
                height: 300px;
            }

            .benefit-card {
                flex-direction: column;
            }
            .socials{
                display:flex;
                gap:14px;
            }

            .socials a{
                width:52px;
                height:52px;

                display:flex;
                justify-content:center;
                align-items:center;

                border-radius:14px;

                background:rgba(6,182,212,.08);

                color:#FFFFFF;

                font-size:22px;

                transition:.35s;
            }

            .socials a:hover{

                background:linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary-2)
                );

                transform:translateY(-5px);

                box-shadow:0 15px 25px rgba(6,182,212,.30);
            }
        }
    </style>
</head>
<body>

<header class="navbar">
    <div class="container navbar-inner">
        <a href="#inicio" class="brand">
            <img src="{{ asset('images/autocare/logo.png') }}" alt="AutoCare Logo" class="brand-logo">
            <span>AutoCare</span>
        </a>

        <nav class="nav-links">
            <a href="#">Inicio</a>
            <a href="#servicios">Servicios</a>
            <a href="#beneficios">Beneficios</a>
            <a href="#contacto">Contacto</a>
        </nav>

        <div class="nav-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-outline">Panel</a>
            @else
                <a href="/login" class="btn btn-outline">Iniciar Sesión</a>
                <a href="/register" class="btn btn-primary">Registrarse</a>
            @endauth
        </div>

        <button class="menu-toggle" id="menuToggle" aria-label="Abrir menú">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16"/>
            </svg>
        </button>
    </div>

    <div class="mobile-menu" id="mobileMenu">
        <div class="container">
            <a href="#inicio">Inicio</a>
            <a href="#servicios">Servicios</a>
            <a href="#vehiculos">Beneficios</a>
            <a href="#contacto">Contacto</a>

            <div class="mobile-buttons">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-outline">Panel</a>
                @else
                    <a href="/login" class="btn btn-outline">Iniciar Sesión</a>
                    <a href="/register" class="btn btn-primary">Registrarse</a>
                @endauth
            </div>
        </div>
    </div>
</header>

<main>
    <section class="hero" id="inicio">
        <div class="container hero-grid">
            <div class="hero-content">
                <h1>
                    Gestiona el mantenimiento de tu vehículo de manera
                    <span>rápida y segura</span>
                </h1>

                <p>
                    Plataforma integral para el control y seguimiento del mantenimiento vehicular. Agenda servicios, consulta historial y realiza pagos en línea de forma sencilla.
                </p>

                <div class="hero-button">
                    <a href="/register" class="btn btn-primary">Solicitar Mantenimiento</a>
                </div>

                <div class="hero-stats">
                    <div class="item">
                        <strong>24/7</strong>
                        <span>Soporte</span>
                    </div>
                    <div class="item">
                        <strong>100%</strong>
                        <span>Seguro</span>
                    </div>
                    <div class="item">
                        <strong>850+</strong>
                        <span>Clientes</span>
                    </div>
                </div>
            </div>

            <div class="hero-card-wrap">
                <div class="floating-top">✓ Certificado</div>
                <div class="floating-bottom">✓ Confiable</div>

                <div class="hero-image-card">
                    <img src="{{ asset('images/autocare/hero-autocare.png') }}" alt="Taller moderno de mantenimiento vehicular AutoCare">
                </div>
            </div>
        </div>
    </section>

    <section class="section-light" id="servicios">
        <div class="container">
            <div class="section-title">
                <h2>Nuestros Servicios</h2>
                <p>Soluciones completas para el cuidado de tu vehículo</p>
            </div>

            <div class="services-grid">
                <div class="service-card">
                    <div class="service-img">
                        <img src="{{ asset('images/autocare/servicio-aceite.png') }}" alt="Cambio de aceite vehicular">
                    </div>
                    <div class="service-body">
                        <div class="service-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3s6 6 6 11a6 6 0 01-12 0c0-5 6-11 6-11z"/>
                            </svg>
                        </div>
                        <h3>Cambio de Aceite</h3>
                        <p>Servicio profesional para mantener el motor en excelentes condiciones y asegurar su buen rendimiento.</p>
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-img">
                        <img src="{{ asset('images/autocare/servicio-preventivo.png') }}" alt="Mantenimiento preventivo vehicular">
                    </div>
                    <div class="service-body">
                        <div class="service-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a4 4 0 01-5 5l-4.4 4.4a2 2 0 102.8 2.8l4.4-4.4a4 4 0 005-5l-2.5 2.5-2.8-2.8 2.5-2.5z"/>
                            </svg>
                        </div>
                        <h3>Mantenimiento Preventivo</h3>
                        <p>Revisión periódica y ajuste general para evitar fallas, prolongar la vida útil y garantizar seguridad.</p>
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-img">
                        <img src="{{ asset('images/autocare/servicio-historial.png') }}" alt="Historial vehicular digital">
                    </div>
                    <div class="service-body">
                        <div class="service-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3>Historial Vehicular</h3>
                        <p>Accede al historial completo de servicios realizados, revisiones previas y próximas atenciones programadas.</p>
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-img">
                        <img src="{{ asset('images/autocare/servicio-pagos.png') }}" alt="Pago en línea de servicio vehicular">
                    </div>
                    <div class="service-body">
                        <div class="service-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"/>
                            </svg>
                        </div>
                        <h3>Pagos en Línea</h3>
                        <p>Realiza pagos seguros y rápidos desde la plataforma para agilizar tu experiencia de atención.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="numbers-section" id="vehiculos">
        <div class="container">
            <div class="numbers-grid">
                <div class="number-item">
                    <div class="icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.5l1.7-4.2A3 3 0 017.5 7.5h6.8a3 3 0 012.4 1.2l1.8 2.4H20a2 2 0 012 2v3h-2.2a2.8 2.8 0 01-5.6 0H9.8a2.8 2.8 0 01-5.6 0H3v-3z"/>
                            <circle cx="7" cy="16.5" r="1.8"/>
                            <circle cx="17" cy="16.5" r="1.8"/>
                        </svg>
                    </div>
                    <h3>1,250+</h3>
                    <p>Vehículos Registrados</p>
                </div>

                <div class="number-item">
                    <div class="icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/>
                            <circle cx="12" cy="12" r="9"/>
                        </svg>
                    </div>
                    <h3>3,800+</h3>
                    <p>Servicios Completados</p>
                </div>

                <div class="number-item">
                    <div class="icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11c1.7 0 3-1.3 3-3s-1.3-3-3-3-3 1.3-3 3 1.3 3 3 3zm-8 0c1.7 0 3-1.3 3-3S9.7 5 8 5 5 6.3 5 8s1.3 3 3 3zm0 2c-2.7 0-5 1.3-5 3v1h10v-1c0-1.7-2.3-3-5-3zm8 0c-.3 0-.7 0-1 .1 1.2.8 2 1.8 2 2.9v1h6v-1c0-1.7-2.3-3-5-3z"/>
                        </svg>
                    </div>
                    <h3>850+</h3>
                    <p>Clientes Activos</p>
                </div>

                <div class="number-item">
                    <div class="icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a4 4 0 01-5 5l-4.4 4.4a2 2 0 102.8 2.8l4.4-4.4a4 4 0 005-5l-2.5 2.5-2.8-2.8 2.5-2.5z"/>
                        </svg>
                    </div>
                    <h3>25+</h3>
                    <p>Mecánicos Disponibles</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-light" id="beneficios">
        <div class="container">
            <div class="section-title">
                <h2>¿Por qué elegir AutoCare?</h2>
            </div>

            <div class="benefits-layout">
                <div class="benefit-image">
                    <img src="{{ asset('images/autocare/beneficio-tecnologia.png') }}" alt="Tecnología para seguimiento de mantenimiento vehicular">
                </div>

                <div class="benefits-grid">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div class="benefit-text">
                            <h3>Gestión Rápida</h3>
                            <p>Agenda y administra tus servicios en pocos pasos desde cualquier dispositivo con una experiencia intuitiva.</p>
                        </div>
                    </div>

                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 4h10a2 2 0 012 2v14l-4-2-3 2-3-2-4 2V6a2 2 0 012-2z"/>
                            </svg>
                        </div>
                        <div class="benefit-text">
                            <h3>Historial Organizado</h3>
                            <p>Mantén un registro detallado de todo el mantenimiento y seguimiento técnico de tus vehículos.</p>
                        </div>
                    </div>

                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8a4 4 0 100 8 4 4 0 000-8zm0-5v2m0 14v2m9-9h-2M5 12H3m15.4 6.4l-1.4-1.4M7 7l-1.4-1.4m12.8 0L17 7M7 17l-1.4 1.4"/>
                            </svg>
                        </div>
                        <div class="benefit-text">
                            <h3>Atención Eficiente</h3>
                            <p>Contamos con personal especializado y procesos optimizados para ofrecer una atención confiable y oportuna.</p>
                        </div>
                    </div>

                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 4v5c0 5-3.4 9.7-7 11-3.6-1.3-7-6-7-11V7l7-4z"/>
                            </svg>
                        </div>
                        <div class="benefit-text">
                            <h3>Seguridad de Información</h3>
                            <p>Tus datos y operaciones se encuentran protegidos bajo altos estándares de seguridad y control.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <<section class="contact-section" id="contacto">
        <div class="container">
            <div class="section-title">
                <h2>Contáctanos</h2>
                <p>Estamos listos para ayudarte con la gestión y mantenimiento de tu vehículo</p>
            </div>

            <div class="contact-layout">
                <div class="contact-info">
                    <h3>Información de contacto</h3>
                    <p>
                        Comunícate con AutoCare para recibir orientación sobre nuestros servicios.
                    </p>

                    <div class="contact-grid">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16v12H4z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7l8 6 8-6"/>
                                </svg>
                            </div>
                            <div>
                                <strong>Correo</strong>
                                <p>info@autocare.com</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5.5A2.5 2.5 0 015.5 3h2L10 8l-2 1.5a12 12 0 006.5 6.5L16 14l5 2.5v2A2.5 2.5 0 0118.5 21h-1C9.5 21 3 14.5 3 6.5v-1z"/>
                                </svg>
                            </div>
                            <div>
                                <strong>Teléfono</strong>
                                <p>+51 995 846 768</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-5.2 7-11a7 7 0 10-14 0c0 5.8 7 11 7 11z"/>
                                    <circle cx="12" cy="10" r="2.5"/>
                                </svg>
                            </div>
                            <div>
                                <strong>Ubicación</strong>
                                <p>Santa Anita, Av. Cascanueces 2350, Lima 15011</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                                </svg>
                            </div>
                            <div>
                                <strong>Horario</strong>
                                <p>Lunes a sábado: 8:00 a.m. - 6:00 p.m.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
   <section class="cta-section">
        <div class="container">
            <h2>¿Listo para comenzar?</h2>
            <p>
                Únete a cientos de usuarios que ya confían en AutoCare para el mantenimiento de sus vehículos.
            </p>

            <div class="cta-buttons">
                <a href="/register" class="btn btn-white">Crear Cuenta Gratis</a>
                <a href="/login" class="btn btn-outline">Iniciar Sesión</a>
            </div>
        </div>
    </section>
</main>

<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">
                    <img src="{{ asset('images/autocare/logo.png') }}" alt="AutoCare Logo" class="brand-logo">
                    <span>AutoCare</span>
                </div>
                <p></p>
            </div>

            <div class="footer-contact">
                <h4>Contacto y Dirección</h4>

                <p>
                    <i class="fa-regular fa-envelope"></i>
                    info@autocare.com
                </p>

                <p>
                    <i class="fa-solid fa-phone"></i>
                    +51 995 846 768
                </p>

                <p>
                    <i class="fa-solid fa-location-dot"></i>
                    Santa Anita, Av. Cascanueces 2350, Lima 15011
                </p>

            </div>

            <div>
                <h4>Acesso Rápido</h4>
                <a href="#servicios">Servicios</a>
                <a href="#vehiculos">Beneficios</a>
                <a href="#contacto">Contacto</a>
            </div>

            <div>
                <h4>Redes Sociales</h4>
                <div class="socials">
                    <span><i class="fab fa-facebook-f"></i></span>
                    <span><i class="fab fa-x-twitter"></i></span>
                    <span><i class="fab fa-instagram"></i></span>
                    <span><i class="fab fa-linkedin-in"></i></span>
                </div>
            </div>
        </div>

        <div class="copyright">
            © 2026 AutoCare. Todos los derechos reservados.
        </div>
    </div>
</footer>

<script>
    const menuToggle = document.getElementById('menuToggle');
    const mobileMenu = document.getElementById('mobileMenu');

    if (menuToggle) {
        menuToggle.addEventListener('click', function () {
            mobileMenu.classList.toggle('active');
        });
    }
</script>

</body>
</html>