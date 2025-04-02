<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Maha Prasad Timeline</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f9f9f9;
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

        .timeline {
            max-width: 800px;
            margin: 50px auto;
            position: relative;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #ddd;
            transform: translateX(-50%);
        }

        .timeline-item {
            position: relative;
            width: 50%;
            padding: 30px 40px;
            box-sizing: border-box;
        }

        .timeline-item.left {
            left: 0;
        }

        .timeline-item.right {
            left: 50%;
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            top: 40px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #ccc;
            border: 4px solid white;
            left: calc(100% - 10px);
            transform: translateX(-50%);
        }

        .timeline-item.right::after {
            left: 0;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-left: 6px solid #ccc;
        }

        .darshan-img-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 130px;
        }

        .darshan-img-wrapper img {
            display: block;
            width: 150px;
            height: 100%;
            border-radius: 15px;
            margin: 0 auto 15px;
            object-fit: cover;
        }

        .card h3 {
            color: #db4d30;
            text-align: center;
            margin-bottom: 8px;
        }

        .card p {
            font-size: 14px;
            color: #444;
            margin: 5px 0;
        }

        .card .price {
            color: #28a745;
            font-weight: 600;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Status Colors */
        .timeline-item.running .card {
            border-left-color: #28a745;
        }

        .timeline-item.completed .card {
            border-left-color: #6f42c1;
        }

        .timeline-item.pending .card {
            border-left-color: #ffc107;
        }

        .timeline-item.running::after {
            background-color: #28a745;
        }

        .timeline-item.completed::after {
            background-color: #6f42c1;
        }

        .timeline-item.pending::after {
            background-color: #ffc107;
        }

        .badge.running {
            background-color: #d4edda;
            color: #28a745;
        }

        .badge.completed {
            background-color: #e9d8fd;
            color: #6f42c1;
        }

        .badge.pending {
            background-color: #fff3cd;
            color: #856404;
        }

        @media (max-width: 768px) {
            .timeline::before {
                left: 10px;
            }

            .timeline-item,
            .timeline-item.right {
                left: 0;
                width: 100%;
                padding-left: 30px;
                padding-right: 15px;
            }

            .timeline-item::after,
            .timeline-item.right::after {
                left: 10px;
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
            <h1>Maha Prasad Timeline</h1>
            <p>Explore sacred offerings, their time and items served</p>
        </div>
    </div>


    <div class="timeline">
        @foreach ($prasads as $index => $prasad)
            @php
                $side = $index % 2 === 0 ? 'left' : 'right';

                $now = \Carbon\Carbon::now();

                // Force today's date + prasad time
$startTime = \Carbon\Carbon::today()->setTimeFromTimeString($prasad->prasad_time);
$endTime = $startTime->copy()->addHour(); // You can make this dynamic

if ($now->between($startTime, $endTime)) {
    $status = 'running';
} elseif ($now->lt($startTime)) {
    $status = 'pending';
} else {
    $status = 'completed';
                }
            @endphp

            <div class="timeline-item {{ $side }} {{ $status }}">
                <div class="card">
                    <span class="badge {{ $status }}">{{ ucfirst($status) }}</span>

                    @if ($prasad->prasad_photo)
                        <div class="darshan-img-wrapper">
                            <img src="{{ asset($prasad->prasad_photo) }}" alt="{{ $prasad->prasad_name }}">
                        </div>
                    @endif

                    <h3>{{ $prasad->prasad_name }}</h3>
                    <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($prasad->prasad_time)->format('h:i A') }}</p>
                    <p><strong>Items:</strong> {{ $prasad->prasad_item }}</p>
                    <p class="price">Price: ₹{{ $prasad->prasad_price }}</p>

                    @if ($prasad->description)
                        <p>{{ $prasad->description }}</p>
                    @endif

                    <p>
                        @if ($prasad->online_order)
                            ✅ Online Order Available
                        @endif
                        @if ($prasad->pre_order)
                            | 🛍️ Pre-Order Allowed
                        @endif
                        @if ($prasad->offline_order)
                            | 🕉️ Offline Booking
                        @endif
                    </p>
                </div>
            </div>
        @endforeach


    </div>

</body>

</html>
