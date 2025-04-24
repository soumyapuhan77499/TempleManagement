<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Niti Timeline</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/dham-header.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        .timeline {
            max-width: 1000px;
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
            border-radius: 3px;
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
            top: 80px;
            width: 14px;
            height: 14px;
            background-color: #fff;
            border: 4px solid #db4d30;
            border-radius: 50%;
            left: calc(100% - 14px);
            transform: translateX(-50%);
        }

        .timeline-item.right::after {
            left: 0;
            transform: translateX(-50%);
        }

        .timeline-content {
            position: relative;
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid rgb(213, 213, 213);
            height: 80px;
        }

        .timeline-content.left::before,
        .timeline-content.right::before {
            content: "";
            position: absolute;
            top: 20px;
            width: 0;
            height: 0;
            border: 10px solid transparent;
        }

        .timeline-content.left::before {
            left: -20px;
            border-right-color: #fff;
        }

        .timeline-content.right::before {
            right: -20px;
            border-left-color: #fff;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 10px;
        }

        .niti-title {
            flex: 1;
        }

        .niti-title h3 {
            font-size: 26px;
            font-weight: 600;
            color: #db4d30;
            margin: 0;
        }

        .niti-title .underline {
            width: 60px;
            height: 4px;
            background-color: #b0aeae;
            margin-top: 4px;
        }

        .status-block {
            text-align: right;
            white-space: nowrap;
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
            letter-spacing: 0.6px;
        }

        .badge.Completed {
            background-color: #fef3ec;
            color: #db4d30;
            font-size: 17px;
        }

        .badge.Started {
            background-color: #db4d30;
            color: #fff;
            font-size: 16px;

        }

        .badge.Upcoming {
            background-color: #f5f5f5;
            color: #db4d30;
            font-size: 16px;

        }

        .niti-times p:hover i {
            transform: scale(1.2);
            filter: drop-shadow(0 0 3px rgba(0, 0, 0, 0.3));
        }

        .niti-times {
            font-size: 14px;
        }

        .niti-times p {
            margin: 2px 0;
            font-weight: 500;
            color: #444;
        }

        .niti-times p strong {
            margin-right: 4px;
            color: #666;
        }

        /* Completed Niti */
        .Completed .timeline-content {
            background: #fff7e9;
        }

        /* Started Niti */
        .Started .timeline-content {
            background: #db4d30;
            color: #fff;
        }

        .Started .niti-title .underline {
            width: 80px;
            height: 3px;
            background-color: #f0ebeb;
            margin-top: 4px;
        }

        .Started .niti-title h3 {
            color: #ffae35;
        }

        .Started .niti-times p,
        .Started .niti-times strong {
            color: #fff;
        }

        /* Upcoming Niti */
        .Upcoming .timeline-content {
            background: #ffffff;
        }

        /* Shared styles */
        .niti-times i {
            width: 17px;
            display: inline-block;
            text-align: center;
            margin-right: 8px;
            font-size: 14px;
            color: #999;
        }

        .niti-title .underline {
            width: 60px;
            height: 2px;
            background-color: #db4d30;
            margin-top: 4px;
        }

        @media (max-width: 768px) {
            .timeline::before {
                left: 10px;
            }

            .timeline-item,
            .timeline-item.right {
                width: 100%;
                left: 0;
                padding: 20px;
            }

            .timeline-item::after,
            .timeline-item.right::after {
                left: 10px;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .status-block {
                text-align: left;
                width: 100%;
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
                $start = $niti['start_time'] ?? null;
                $end = $niti['end_time'] ?? null;
                $status = $niti['niti_status'];
                $side = $index % 2 === 0 ? 'left' : 'right';

                $icon = match ($status) {
                    'Completed' => 'fa-check-circle',
                    'Started' => 'fa-sun',
                    'Upcoming' => 'fa-bell',
                };

                $statusClass = $status;
            @endphp

            <div class="timeline-item {{ $side }} {{ $statusClass }}">
                <div class="timeline-content {{ $side }}">
                    <div class="card-header">
                        <div class="niti-title">
                            <h3>{{ $niti['niti_name'] }}</h3>
                            <div class="underline"></div>
                        </div>

                        <div class="status-block">
                            <span class="badge {{ $statusClass }}">
                                <i class="fas {{ $icon }}"></i>
                                {{ $status === 'Started' ? 'Going On' : $status }}
                            </span>

                            <div class="niti-times">
                                @if ($status === 'Started' && $start)
                                    <p><strong>Started:</strong> {{ \Carbon\Carbon::parse($start)->format('h:i a') }}
                                    </p>
                                @endif
                                @if ($status === 'Completed')
                                        <p><strong>Started:</strong>
                                            {{ \Carbon\Carbon::parse($start)->format('h:i a') }}</p>
                                 
                                        <p><strong>Completes:</strong>
                                            {{ \Carbon\Carbon::parse($end)->format('h:i a') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>



</body>

</html>
