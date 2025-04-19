<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Niti Timeline</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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
            font-size: 20px;
            color: #f5f5f5;
        }

.timeline {
    max-width: 1000px;
    margin: 50px auto;
    position: relative;
    padding: 0 20px;
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
    z-index: 0;
}

.timeline-item {
    position: relative;
    width: 50%;
    padding: 30px 40px;
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
    content: '';
    position: absolute;
    top: 40px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #ccc;
    border: 4px solid white;
    z-index: 2;
    left: calc(100% - 10px);
    transform: translateX(-50%);
}

.timeline-item.right::after {
    left: 0;
    transform: translateX(-50%);
}

.card {
    background: #fff;
    padding: 20px 25px;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    border-left: 6px solid #ccc;
    position: relative;
    transition: 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
}

.card h3 {
    margin: 0 0 10px;
    color: #db4d30;
    font-size: 20px;
}

.card p {
    margin: 6px 0;
    font-size: 14px;
    color: #555;
    line-height: 1.6;
}

.card ul {
    padding-left: 20px;
    margin-top: 5px;
}

.card ul li {
    font-size: 13px;
    margin-bottom: 4px;
    color: #444;
}

/* Badge Styles */
.badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
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

/* Colored Borders */
.running .card {
    border-left-color: #28a745;
}
.completed .card {
    border-left-color: #6f42c1;
}
.pending .card {
    border-left-color: #ffc107;
}

/* Timeline Dots Color */
.running::after {
    background-color: #28a745;
}
.completed::after {
    background-color: #6f42c1;
}
.pending::after {
    background-color: #ffc107;
}

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
                    <span class="separator">SM <a href="#" class="live-badges"><i class="fa fa-bolt"></i> Live</a></span>
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

    <!-- Niti Timeline Section -->
    <div class="timeline">
        @foreach ($nitis as $index => $niti)
                    @php
                        $now = \Carbon\Carbon::now();
                        $start = \Carbon\Carbon::parse($niti['date_time']);
                        $end = isset($niti['end_time'])
                            ? \Carbon\Carbon::parse($niti['end_time'])
                            : $start->copy()->addMinutes($niti['duration'] ?? 60);
                        $status = $now->between($start, $end) ? 'running' : ($now->gt($end) ? 'completed' : 'pending');
                        $side = $index % 2 === 0 ? 'left' : 'right';
                    @endphp


                    <div class="timeline-item {{ $side }} {{ $status }}">
                        <div class="card timeline-content">
                            <span class="badge {{ $status }}">{{ ucfirst($status) }}</span>
                            <h3>{{ $niti['niti_name'] }}</h3>
                            <p><strong>Type:</strong> {{ $niti['niti_type'] }}</p>
                            <p><strong>Start Time:</strong>
                                {{ \Carbon\Carbon::parse($niti['date_time'])->format('h:i A') }}</p>

                            @if ($niti['duration'])
                                <p><strong>Duration:</strong> {{ $niti['duration'] }} mins</p>
                            @endif

                            @if (!empty($niti['management_status']))
                                <p><strong>Management Status:</strong> {{ $niti['management_status'] }}</p>
                            @endif

                            @if (!empty($niti['after_special_niti_name']))
                                <p><strong>After Niti:</strong> {{ $niti['after_special_niti_name'] }}</p>
                            @endif

                            @if (!empty($niti['description']))
                                <p>{{ $niti['description'] }}</p>
                            @endif

                            @if (!empty($niti['running_sub_niti']) && count($niti['running_sub_niti']))
                                <div>
                                    <strong>Sub Nitis:</strong>
                                    <ul style="padding-left: 20px; margin-top: 5px;">
                                        @foreach ($niti['running_sub_niti'] as $sub)
                                            <li>
                                                {{ $sub['sub_niti_name'] }} –
                                                {{ \Carbon\Carbon::parse($sub['start_time'])->format('h:i A') ?? '—' }}
                                                ({{ $sub['status'] }})
                                            </li>
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
