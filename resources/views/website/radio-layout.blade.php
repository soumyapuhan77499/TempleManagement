<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shree Mandira Radio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to bottom, #141e30, #243b55);
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

        .radio-content {
            max-width: 720px;
            margin: 40px auto;
            background: #1e1e2f;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 0 30px rgba(255, 82, 103, 0.3);
        }

        .radio-top {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .radio-top img {
            height: 70px;
            width: 75px;
            border-radius: 12px;
        }

        .radio-top h2 {
            font-size: 22px;
            margin: 0;
            color: #ff6e7f;
        }

        .radio-top p {
            font-size: 13px;
            margin-top: 4px;
        }

        .radio-controls {
            margin-top: 25px;
            text-align: center;
        }

        .radio-controls img {
            height: 45px;
            margin: 0 15px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .radio-controls img:hover {
            transform: scale(1.1);
        }

        .progress-bar {
            margin: 15px 0;
        }

        .progress-bar input[type="range"] {
            width: 80%;
        }

        .radio-nav {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #444;
        }

        .radio-nav span {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #ffc107;
            font-size: 12px;
        }

        .radio-nav span i {
            font-size: 18px;
            margin-bottom: 4px;
        }

        .footer {
            margin-top: 50px;
            background: #121212;
            color: #aaa;
            text-align: center;
            padding: 20px 10px;
            font-size: 14px;
            border-top: 1px solid #333;
        }

        @media (max-width: 600px) {
            .radio-content {
                margin: 20px 15px;
                padding: 20px;
            }

            .radio-top h2 {
                font-size: 18px;
            }

            .radio-controls img {
                height: 36px;
                margin: 0 10px;
            }
        }
    </style>
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
                    <span class="separator">SM <a href="#" class="live-badges"><i class="fa fa-bolt"></i>
                            Live</a></span>
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
            <h1>Shree Mandira Radio</h1>
            <p>Tune in to the divine sounds of Shree Jagannatha Dham</p>
        </div>
    </div>

    <div class="radio-content">
        <div class="radio-top">
            <img src="{{ asset('website/radio.png') }}" alt="Radio Icon" />
            <div>
                <h2>Live Bhajans</h2>
                <p>🕒 03:17 PM &nbsp;&nbsp; 📅 4th Mar</p>
            </div>
        </div>

        <div class="radio-controls">
            <div>
                <img src="{{ asset('website/12.png') }}" alt="Previous" />
                <img src="{{ asset('website/11.png') }}" alt="Play" />
                <img src="{{ asset('website/10.png') }}" alt="Next" />
            </div>
            <div class="progress-bar">
                <input type="range" min="0" max="100" />
            </div>
        </div>

        <div class="radio-nav">
            <span><i class="fa fa-compass"></i> Explore</span>
            <span><i class="fa fa-heart"></i> Favorites</span>
            <span><i class="fa fa-music"></i> Browse</span>
            <span><i class="fa fa-search"></i> Search</span>
            <span><i class="fa fa-cog"></i> Settings</span>
        </div>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Shree Mandira Radio. All rights reserved.
    </div>
</body>

</html>
