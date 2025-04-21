<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Darshan Timeline</title>
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo img {
            height: 60px;
            width: 70px;
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
            color: white !important;
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
            text-shadow: 1px 2px 5px rgba(0, 0, 0, 0.6);
        }

        .hero-content p {
            font-size: 20px;
            color: #f5f5f5;
        }

        .timeline {
            max-width: 900px;
            margin: 60px auto;
            position: relative;
            padding: 0 15px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(to bottom, #ff5722, #ffc107);
            transform: translateX(-50%);
            animation: pulse-line 3s ease infinite;
        }

        @keyframes pulse-line {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .timeline-item {
            position: relative;
            width: 50%;
            padding: 30px;
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
            top: 30px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: white;
            border: 4px solid #ff5722;
            z-index: 5;
            animation: glow-pulse 2s infinite ease-in-out;
        }

        .timeline-item.right::after {
            left: 0;
        }

        .timeline-item.left::after {
            right: 0;
        }

        @keyframes glow-pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 87, 34, 0.7);
            }

            70% {
                box-shadow: 0 0 0 12px rgba(255, 87, 34, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(255, 87, 34, 0);
            }
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-left: 6px solid #ccc;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .darshan-img-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 130px;
            margin-bottom: 15px;
        }

        .darshan-img-wrapper img {
            width: 150px;
            height: 100%;
            border-radius: 15px;
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

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .timeline-item.Started .card {
            border-left-color: #28a745;
        }

        .timeline-item.Completed .card {
            border-left-color: #6f42c1;
        }

        .timeline-item.Upcoming .card {
            border-left-color: #ffc107;
        }

        .timeline-item.Started::after {
            background-color: #28a745;
        }

        .timeline-item.Completed::after {
            background-color: #6f42c1;
        }

        .timeline-item.Upcoming::after {
            background-color: #ffc107;
        }

        .badge.Started {
            background-color: #d4edda;
            color: #28a745;
        }

        .badge.Completed {
            background-color: #e9d8fd;
            color: #6f42c1;
        }

        .badge.Upcoming {
            background-color: #fff3cd;
            color: #856404;
        }

        @media (max-width: 768px) {
            .timeline::before {
                left: 10px;
            }

            .timeline-item,
            .timeline-item.right,
            .timeline-item.left {
                left: 0;
                width: 100%;
                padding-left: 30px;
                padding-right: 15px;
            }

            .timeline-item::after,
            .timeline-item.right::after,
            .timeline-item.left::after {
                left: 10px;
                right: auto;
                transform: none;
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
            <h1>Temple Darshan Timeline</h1>
            <p>Discover sacred timings and rituals visually</p>
        </div>
    </div>

    <div class="timeline">
        @foreach ($darshanList as $index => $darshan)
            @php
                $side = $index % 2 === 0 ? 'left' : 'right';
                $status = $darshan->today_status ?? 'Not Available';
            @endphp
    
            <div class="timeline-item {{ $side }} {{ $status }}">
                <div class="card timeline-content">
                    <span class="badge {{ $status }}">{{ ucfirst($status) }}</span>
    
                    @if ($darshan->darshan_image)
                        <div class="darshan-img-wrapper">
                            <img src="{{ asset($darshan->darshan_image) }}" alt="{{ $darshan->darshan_name }}">
                        </div>
                    @endif
    
                    <h3>{{ $darshan->darshan_name }}</h3>
    
                    <p><strong>Day:</strong> {{ $darshan->darshan_day }}</p>
    
                    <p><strong>Time:</strong>
                        {{ $darshan->start_time ? \Carbon\Carbon::parse($darshan->start_time)->format('h:i A') : 'N/A' }}
                        -
                        {{ $darshan->end_time ? \Carbon\Carbon::parse($darshan->end_time)->format('h:i A') : 'N/A' }}
                    </p>
    
                    <p><strong>Duration:</strong> {{ $darshan->duration ?? 'N/A' }}</p>
    
                    <p><strong>Status:</strong>
                        @if ($status == 'Started')
                            <span style="color:#28a745;"><i class="fa fa-play-circle"></i> Started</span>
                        @elseif($status == 'Upcoming')
                            <span style="color:#ffc107;"><i class="fa fa-clock"></i> Upcoming</span>
                        @elseif($status == 'Completed')
                            <span style="color:#6f42c1;"><i class="fa fa-check-circle"></i> Completed</span>
                        @else
                            <span style="color:#999;">Not Available</span>
                        @endif
                    </p>
    
                    @if ($darshan->description)
                        <p>{{ $darshan->description }}</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
</body>

</html>
