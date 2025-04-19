<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nearby Temple</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #fefefe;
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo img {
            height: 60px;
            width: auto;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 30px;
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
            color: white;
            padding: 2px 10px;
            border-radius: 10px;
            margin-left: 5px;
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
            font-size: 17px;
            color: #f5f5f5;
        }

        .temple-section {
            display: flex;
            max-width: 1100px;
            margin: 60px auto;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
        }

        .temple-left,
        .temple-right {
            flex: 1;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .temple-left img,
        .temple-right img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .temple-left h3,
        .temple-right h3 {
            font-size: 22px;
            margin-bottom: 12px;
            color: #b31e25;
        }

        .temple-left p,
        .temple-right p {
            font-size: 15px;
            color: #333;
            margin-bottom: 15px;
            line-height: 1.7;
        }

        .temple-right ul {
            list-style: none;
            padding: 0;
        }

        .temple-right ul li {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .temple-right ul li i {
            margin-right: 10px;
            color: #b31e25;
        }

        .btn-details {
            padding: 10px 20px;
            background: #b31e25;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            width: fit-content;
            font-weight: bold;
            margin-top: 10px;
        }

        .timeline-footer {
            text-align: center;
            font-size: 13px;
            color: #aaa;
            margin: 30px 0;
        }

        @media screen and (max-width: 768px) {
            .temple-section {
                flex-direction: column;
            }

            .temple-left,
            .temple-right {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <header class="header-area">
        <div class="header-content">
            <div class="logo">
                <img src="{{ asset('website/logo.png') }}" alt="logo">
            </div>
            <nav class="nav-menu">
                <a href="#">Nitis</a>
                <span class="separator">SM <a href="#" class="live-badges"><i class="fa fa-bolt"></i> Live</a></span>
                <a href="#">Services</a>
                <a href="#">Nearby Temples</a>
                <a href="#">Conveniences</a>
                <a href="#">Temple Information</a>
            </nav>
        </div>
    </header>

    <section class="hero">
        <img class="hero-bg" src="{{ asset('website/parking.jpeg') }}" alt="Mandir Background" />
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Nearby Temples</h1>
            <p>Discover sacred places close to your journey.</p>
        </div>
    </section>

    <section class="temple-section">
        <div class="temple-left">
            <img src="{{ asset('website/59.jpg') }}" alt="Temple Photo">
        </div>
        <div class="temple-right">
            <h3><i class="fa fa-eye"></i> Darshan</h3>
            <p>Experience spiritual tranquility through peaceful darshan, guided by tradition and culture.</p>
            <h3><i class="fa fa-utensils"></i> Mahaprasad</h3>
            <p>Enjoy the divine offering of Mahaprasad, prepared with sanctity and served with devotion.</p>
            <ul>
                <li><i class="fa fa-map-marker-alt"></i> 2.5 KM from Jagannath Temple</li>
                <li><i class="fa fa-clock"></i> Open from 5 AM to 9 PM</li>
                <li><i class="fa fa-phone"></i> Contact: +91-9876543210</li>
            </ul>
            <a href="#" class="btn-details">FIND OUT MORE</a>
        </div>
    </section>

    <section class="temple-section">
        <div class="temple-left">
            <div class="temple-content">
                <h3><i class="fa fa-eye" style="color: #b31e25;"></i> Darshan</h3>
                <p>Spacious temple with traditional architecture and serene surroundings for meditation and prayer.</p>
                <h3><i class="fa fa-utensils" style="color: #b31e25;"></i> Mahaprasad</h3>
                <p>Delicious prasad prepared freshly every day in a sacred kitchen with community participation.</p>
                
              
            </div>
        </div>
        <div class="temple-right">
            <img src="{{ asset('website/1000.jpg') }}" alt="Temple Photo">
        </div>
    </section>
    

    <div class="timeline-footer">
        © {{ date('Y') }} Temple Management System. All rights reserved.
    </div>
</body>
</html>
