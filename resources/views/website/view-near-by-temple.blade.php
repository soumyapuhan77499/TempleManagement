<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Niti Timeline</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f7f7f7;
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
            font-size: 17px;
            color: #f5f5f5;
        }

       
    </style>
</head>

<body>

    <header class="header-area">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <img src="{{ asset('website/logo.png') }}" alt="logo">
                </div>
                <nav class="nav-menu">
                    <a href="#">Nitis</a>
                    <span class="separator">SM <a href="#" class="live-badges"><i class="fa fa-bolt"></i>
                            Live</a></span>
                    <a href="#">Services</a>
                    <a href="#">Nearby Temples</a>
                    <a href="#">Conveniences</a>
                    <a href="#">Temple Information</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <div class="hero">
        <img class="hero-bg" src="{{ asset('website/parking.jpeg') }}" alt="Mandir Background" />
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Near By Temple</h1>
            <p>Rituals & their importance – live updates</p>
        </div>
    </div>



</body>

</html>
