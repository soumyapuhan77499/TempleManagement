<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mandir Television</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        body {
            margin: 0;
            background: #121212;
            font-family: 'Segoe UI', sans-serif;
            color: white;
        }

        .header-area {
            background: white;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
            height: 70px;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 60px;
            width: 70px;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 40px;
            margin-right: 30px;
        }

        .nav-menu a {
            color: #4d6189;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
        }

        .separator {
            font-weight: bold;
            color: #ff4b2b;
        }

        .live-badges {
            background: red;
            color: white !important;
            padding: 2px 10px;
            border-radius: 10px;
            margin-left: 5px;
        }

        .hamburger-menu {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
        }

        .hamburger-menu span {
            width: 20px;
            height: 2px;
            background: purple;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .hero {
            position: relative;
            height: 320px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, rgba(0, 0, 0, 0.8), rgba(153, 32, 13, 0.8));
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 0 20px;
        }

        .hero-content h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #fff;
        }

        .hero-content p {
            font-size: 20px;
            color: #f5f5f5;
        }

        .screen {
            margin: 60px auto 30px;
            background-color: #000;
            width: 92%;
            max-width: 680px;
            border-radius: 22px;
            border: 6px solid #ff4b2b;
            box-shadow: 0 0 40px rgba(255, 75, 43, 0.6);
            overflow: hidden;
        }

        .screen iframe {
            width: 100%;
            height: 360px;
            display: block;
        }

        .tv-controls {
            text-align: center;
            margin-top: 30px;
        }

        .tv-controls button {
            background: linear-gradient(145deg, #ff4b2b, #ff1e00);
            color: white;
            border: none;
            padding: 12px 28px;
            margin: 0 12px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .tv-controls button:hover {
            background: #e63710;
            transform: translateY(-2px);
        }

        .icon-row {
            margin-top: 40px;
            text-align: center;
        }

        .icon-row ion-icon {
            font-size: 34px;
            margin: 0 16px;
            color: #ffcb05;
            transition: transform 0.3s ease;
        }

        .icon-row ion-icon:hover {
            transform: scale(1.2);
        }

        .footer {
            margin-top: 60px;
            background: #1a1a1a;
            color: #ccc;
            text-align: center;
            padding: 20px 10px;
            font-size: 14px;
            border-top: 1px solid #333;
        }

        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }

            .hamburger-menu {
                display: flex;
            }

            .hero-content h1 {
                font-size: 34px;
            }

            .hero-content p {
                font-size: 16px;
            }

            .screen iframe {
                height: 240px;
            }

            .tv-controls button {
                padding: 10px 20px;
                font-size: 13px;
                margin: 8px 6px;
            }
        }
    </style>

    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>

    <header class="header-area" data-aos="fade-down">
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <div class="logo">
                    <img src="{{ asset('website/logo.png') }}" alt="logo">
                </div>

                <!-- Navigation Menu -->
                <nav class="nav-menu">
                    <a href="#">Nitis</a>
                    <span class="separator">SM <a href="#" class="live-badges"><i class="fa fa-bolt"></i> Live</a></span>
                    <a href="#">Services</a>
                    <a href="#">Nearby Temples</a>
                    <a href="#">Conveniences</a>
                    <a href="#">Temple Information</a>
                    <div class="hamburger-menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <div class="hero">
        <img class="hero-bg" src="{{ asset('website/parking.jpeg') }}" alt="Mandir Background" />
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Mandir Live Television</h1>
            <p>Enjoy sacred broadcasts live from Shree Mandira</p>
        </div>
    </div>

    <!-- TV Screen -->
    <div class="screen">
        <iframe src="https://www.youtube.com/embed/pqCljQRmtVU?si=w6J1IjeIgkJR9dk7" title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
        </iframe>
    </div>

    <!-- Control Buttons -->
    <div class="tv-controls">
        <button>📺 Live</button>
        <button>📹 Recorded</button>
        <button>🔔 Upcoming</button>
    </div>

    <!-- Feature Icons -->
    <div class="icon-row">
        <ion-icon name="radio-outline"></ion-icon>
        <ion-icon name="musical-notes-outline"></ion-icon>
        <ion-icon name="videocam-outline"></ion-icon>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; {{ date('Y') }} Mandir Television. All rights reserved.
    </div>

</body>

</html>
