<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Maha Prasad Timeline</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/dham-header.css') }}">

    <style>
         body {
            font-family: Arial, sans-serif;
            background: #fff;
            margin: 0;
            padding: 0;
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
            background: linear-gradient(to bottom, #db4d30, #f59e0b, #1d4ed8);
            transform: translateX(-50%);
            z-index: 0;
            border-radius: 3px;
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
            width: 14px;
            height: 14px;
            background-color: #fff;
            border: 4px solid #db4d30;
            border-radius: 50%;
            z-index: 2;
            left: calc(100% - 14px);
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
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            position: relative;
            transition: all 0.3s ease;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .card-header .darshan-img-wrapper {
            flex-shrink: 0;
        }

        .card-header img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 10px;
        }

        .card-header .prasad-name {
            flex-grow: 1;
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            color: #db4d30;
            margin-left: 20px;
        }

        .card-header .badge {
            white-space: nowrap;
        }


        .card h3 {
            margin: 0 0 12px;
            font-size: 20px;
            font-weight: 600;
            color: #db4d30;
        }

        .card p {
            margin: 8px 0;
            font-size: 15px;
            color: #333;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .badge i {
            font-size: 14px;
        }

        .badge.Completed {
            background-color: #fef3ec;
            color: #db4d30;
        }

        .badge.Started {
            background-color: #fef3ec;
            color: #2e5b02;
        }

        .badge.Upcoming {
            background-color: #f5f5f5;
            color: #db4d30;
        }

        .Completed .card {
            background: #fffaf3;
            border-left: 6px solid #db4d30;
        }

        .Started .card {
            background: #db4d30;
            color: #ffae35;
            border-left: 6px solid #fff;
        }

        .Started .card h3 {
            color: #ffae35;
        }

        .Started .card p,
        .Started .darshan-times i {
            color: #fff;
        }

        .Upcoming .card {
            background: #ffffff;
            border-left: 6px solid #db4d30;
        }

        .darshan-times i {
            width: 17px;
            display: inline-block;
            text-align: center;
            margin-right: 8px;
            font-size: 14px;
            color: #999;
        }

        .darshan-times p:hover i {
            transform: scale(1.2);
            filter: drop-shadow(0 0 3px rgba(0, 0, 0, 0.3));
        }

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
    @include('partials.header-puri-dham')

    <!-- Hero Section -->
    <div class="hero">
        <img class="hero-bg" src="{{ asset('website/prsd.jpg') }}" alt="Mandir Background" />
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Maha Prasad Timeline</h1>
            <p>Explore sacred offerings, their time and items served</p>
        </div>
    </div>

    <div class="timeline">
        @foreach ($prasadList as $index => $prasad)
            @php
                $start = $prasad->start_time;
                $status = $prasad->today_status;
                $side = $index % 2 === 0 ? 'left' : 'right';

                $icon = match ($status) {
                    'Completed' => 'fa-check-circle',
                    'Started' => 'fa-sun',
                    'Upcoming' => 'fa-bell',
                    default => 'fa-clock',
                };

                $statusClass = $status; // For CSS
            @endphp

            <div class="timeline-item {{ $side }} {{ $statusClass }}">
                <div class="card timeline-content">

                    <div class="card-header">

                        @if ($prasad->prasad_name)
                            <div class="darshan-img-wrapper" style="margin-bottom: 10px;">
                                <img src="{{ asset('website/prasad.png') }}" alt="{{ $prasad->prasad_name }}"
                                    style="width: 100%; max-width: 300px; border-radius: 10px;">
                            </div>
                        @endif

                        <div>
                            <span class="badge {{ $statusClass }}">
                                <i class="fas {{ $icon }}"></i>
                                {{ $status === 'Started' ? 'Going On' : $status }}
                            </span>
                            <h3 class="prasad-name">{{ $prasad->prasad_name }}</h3>

                        </div>

                    </div>

                    <div class="prasad-times">
                        @if ($status === 'Started' && $start)
                            <p class="right-align"><strong>Started:</strong>
                                {{ \Carbon\Carbon::parse($start)->format('h:i a') }}</p>
                        @endif

                        @if ($status === 'Completed')
                            @if ($start)
                                <p class="right-align"><strong>Started:</strong>
                                    {{ \Carbon\Carbon::parse($start)->format('h:i a') }}</p>
                            @endif
                            
                        @endif

                        @if ($status === 'Upcoming')
                            <p class="right-align"><strong>Starts:</strong> Not yet started</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @include('partials.website-footer')

   
</body>

</html>
