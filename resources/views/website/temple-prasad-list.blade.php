<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Maha Prasad Timeline</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/dham-header.css') }}">

    <style>
        * {
            box-sizing: border-box;
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
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #fff;
            border: 4px solid #ff5722;
            transform: translateX(-50%);
            animation: glow-pulse 2s ease-in-out infinite;
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

        .card .price {
            color: #28a745;
            font-weight: 600;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Status Colors */
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
    @include('partials.header-puri-dham')


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
        @foreach ($prasadList as $index => $prasad)
            @php
                $side = $index % 2 === 0 ? 'left' : 'right';
             
                // Use today's recorded status if available
                $prasad_status = $prasad->today_status;

            @endphp

            <div class="timeline-item {{ $side }} {{ $prasad_status }}">
                <div class="card">
                    <span class="badge {{ $prasad_status }}">{{ ucfirst($prasad_status) }}</span>

                    @if ($prasad->prasad_photo)
                        <div class="darshan-img-wrapper">
                            <img src="{{ asset('website/prasad.png') }}" alt="{{ $prasad->prasad_name }}">
                        </div>
                    @endif

                    <h3>{{ $prasad->prasad_name }}</h3>

                    <p><strong>Start Time:</strong>
                        {{ $prasad->start_time ? \Carbon\Carbon::parse($prasad->start_time)->format('h:i A') : 'N/A' }}
                    </p>

                    <p><strong>Date:</strong>
                        {{ $prasad->date ? \Carbon\Carbon::parse($prasad->date)->format('jS M, Y') : 'N/A' }}
                    </p>

                    <p><strong>Status:</strong>
                        @if ($prasad_status == 'Started')
                            <span style="color:#28a745;"><i class="fa fa-play-circle"></i> Started</span>
                        @elseif($prasad_status == 'Upcoming')
                            <span style="color:#ffc107;"><i class="fa fa-clock"></i> Upcoming</span>
                        @elseif($prasad_status == 'Completed')
                            <span style="color:#6f42c1;"><i class="fa fa-check-circle"></i> Completed</span>
                        @else
                            <span style="color:#999;">Not Available</span>
                        @endif
                    </p>

                    @if ($prasad->description)
                        <p>{{ $prasad->description }}</p>
                    @endif

                </div>
            </div>
        @endforeach
    </div>


</body>

</html>
