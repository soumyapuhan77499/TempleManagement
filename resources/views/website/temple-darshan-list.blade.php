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
            background: #f2f2f2;
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

        .timeline-item .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-left: 6px solid #ccc;
        }

        .darshan-img-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
            width: 100%;
            height: 130px;
        }

        .darshan-img-wrapper img {
            width: 200px;
            height: 130px;
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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

        .timeline-content h3 {
            margin: 0 0 5px;
            color: #db4d30;
        }

        .timeline-content p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Status colors */
        .running .card {
            border-left-color: #28a745;
        }

        .completed .card {
            border-left-color: #6f42c1;
        }

        .pending .card {
            border-left-color: #ffc107;
        }

        .running::after {
            background-color: #28a745;
        }

        .completed::after {
            background-color: #6f42c1;
        }

        .pending::after {
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
            <h1>Temple Darshan Timeline</h1>
            <p>Discover sacred timings and rituals visually</p>
        </div>
    </div>

    <div class="timeline">
        @foreach ($darshans as $index => $darshan)
            @php
                $now = \Carbon\Carbon::now();
                $start = \Carbon\Carbon::createFromFormat('H:i', $darshan->darshan_start_time);
                $end = \Carbon\Carbon::createFromFormat('H:i', $darshan->darshan_end_time);

                if ($now->between($start, $end)) {
                    $status = 'running';
                } elseif ($now->gt($end)) {
                    $status = 'completed';
                } else {
                    $status = 'pending';
                }

                $side = $index % 2 === 0 ? 'left' : 'right';
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
                        {{ \Carbon\Carbon::createFromFormat('H:i', $darshan->darshan_start_time)->format('h:i A') }} -
                        {{ \Carbon\Carbon::createFromFormat('H:i', $darshan->darshan_end_time)->format('h:i A') }}
                    </p>
                    <p><strong>Duration:</strong> {{ $darshan->darshan_duration }}</p>
                    @if ($darshan->description)
                        <p>{{ $darshan->description }}</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

</body>

</html>
