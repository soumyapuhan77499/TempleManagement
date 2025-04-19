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

        .timeline {
            max-width: 1100px;
            margin: 60px auto;
            position: relative;
            padding: 0 20px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 6px;
            background: linear-gradient(to bottom, #db4d30, #ffc107, #28a745);
            transform: translateX(-50%);
            z-index: 0;
            border-radius: 3px;
        }

        .timeline-item {
            position: relative;
            width: 50%;
            padding: 30px 45px;
            box-sizing: border-box;
            z-index: 1;
        }

        .timeline-item.left {
            left: 0;
        }

        .timeline-item.right {
            left: 50%;
        }

        .timeline-item::after {
            content: '\f111';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            top: 40px;
            font-size: 18px;
            color: #ccc;
            z-index: 2;
            left: calc(100% - 12px);
            transform: translateX(-50%);
        }

        .timeline-item.right::after {
            left: 0;
            transform: translateX(-50%);
        }

        .card {
            background: #fff;
            padding: 25px 30px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: all 0.3s ease;
            border-left: 8px solid #ccc;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .card h3 {
            margin: 0 0 12px;
            color: #db4d30;
            font-size: 22px;
        }

        .card p {
            margin: 8px 0;
            font-size: 15px;
            color: #333;
        }

        .card ul li {
            font-size: 14px;
            color: #555;
            margin-bottom: 4px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .badge::before {
            content: '\f0f3';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
        }

        .badge.Started {
            background-color: #fff3cd;
            color: #ff9800;
        }

        .badge.Completed {
            background-color: #e0f7e9;
            color: #28a745;
        }

        .badge.Upcoming {
            background-color: #dbeafe;
            color: #1d4ed8;
        }

        .Started .card {
            border-left-color: #ff9800;
        }

        .Completed .card {
            border-left-color: #28a745;
        }

        .Upcoming .card {
            border-left-color: #1d4ed8;
        }

        .Started::after {
            color: #ff9800;
        }

        .Completed::after {
            color: #28a745;
        }

        .Upcoming::after {
            color: #1d4ed8;
        }

        .niti-times i {
    width: 17px;
    display: inline-block;
    text-align: center;
    margin-right: 8px;
    font-size: 14px;
    transition: transform 0.2s ease-in-out, color 0.3s ease;
}

.niti-times i.text-success {
    color: #28a745; /* green */
}

.niti-times i.text-danger {
    color: #dc3545; /* red */
}

.niti-times i.text-warning {
    color: #ffc107; /* yellow/orange */
}

.niti-times i.text-primary {
    color: #007bff; /* blue */
}

.niti-times i.text-purple {
    color: #6f42c1; /* purple */
}

.niti-times p:hover i {
    transform: scale(1.2);
    filter: drop-shadow(0 0 3px rgba(0, 0, 0, 0.3));
}



        < !-- Your timeline blade content here -->
        /* Responsive */
        @media (max-width: 768px) {
            .timeline::before {
                left: 10px;
            }

            .timeline-item,
            .timeline-item.right {
                width: 100%;
                left: 0;
                padding: 30px 25px;
            }

            .timeline-item::after,
            .timeline-item.right::after {
                left: 10px;
            }

            .card {
                padding: 20px;
            }
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
            <h1>Complete List Of Nitis</h1>
            <p>Rituals & their importance – live updates</p>
        </div>
    </div>

    @php
        use Carbon\Carbon;
    @endphp

    <div class="timeline">
        @foreach ($mergedNitiList as $index => $niti)
            @php
                $now = now('Asia/Kolkata');
                $start = $niti['start_time'] ?? null;
                $end = $niti['end_time'] ?? null;
                $pause = $niti['pause_time'] ?? null;
                $resume = $niti['resume_time'] ?? null;
                $duration = $niti['duration'] ?? null;
                $status = $niti['niti_status'];
                $side = $index % 2 === 0 ? 'left' : 'right';
            @endphp

            <div class="timeline-item {{ $side }} {{ $status }}">
                <div class="card timeline-content">
                    <span class="badge {{ $status }}">{{ ucfirst($status) }}</span>
                    <h3>{{ $niti['niti_name'] }}</h3>


                    @if ($start || $end || $pause || $resume || $duration)
                    <div class="niti-times">

                        @if ($start)
                            <p>
                                <i class="fas fa-play-circle text-success"></i>
                                <strong>Start Time:</strong> {{ Carbon::parse($start)->format('h:i A') }}
                            </p>
                        @endif
                
                        @if ($end)
                            <p>
                                <i class="fas fa-stop-circle text-danger"></i>
                                <strong>End Time:</strong> {{ Carbon::parse($end)->format('h:i A') }}
                            </p>
                        @endif
                
                        @if ($pause)
                            <p>
                                <i class="fas fa-pause-circle text-warning"></i>
                                <strong>Pause Time:</strong> {{ Carbon::parse($pause)->format('h:i A') }}
                            </p>
                        @endif
                
                        @if ($resume)
                            <p>
                                <i class="fas fa-play text-primary"></i>
                                <strong>Resume Time:</strong> {{ Carbon::parse($resume)->format('h:i A') }}
                            </p>
                        @endif
                
                        @if ($duration)
                            <p>
                                <i class="fas fa-clock text-purple"></i>
                                <strong>Duration:</strong> {{ $duration }}
                            </p>
                        @endif
                    </div>
                @endif
                


                    @if (!empty($niti['description']))
                        <p>{{ $niti['description'] }}</p>
                    @endif

                    @if (!empty($niti['running_sub_niti']) && count($niti['running_sub_niti']) > 0)
                        <div>
                            <strong>Sub Nitis:</strong>
                            <ul style="padding-left: 20px;">
                                @foreach ($niti['running_sub_niti'] as $sub)
                                    <li>{{ $sub['sub_niti_name'] }} ({{ $sub['status'] ?? 'Pending' }})</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>



</body>

</html>
