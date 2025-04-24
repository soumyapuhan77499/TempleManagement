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

        .timeline-content {
            position: relative;
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
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
            gap: 20px;
            flex-wrap: wrap;
        }

        .niti-title {
            max-width: 60%;
        }

        .niti-title h3 {
            font-size: 20px;
            font-weight: 600;
            color: #db4d30;
            margin: 0;
        }

        .niti-title .underline {
            width: 50px;
            height: 2px;
            background-color: #db4d30;
            margin-top: 4px;
        }

        .status-block {
            text-align: right;
            flex-grow: 1;
        }

        .status-block .badge {
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
            white-space: nowrap;
        }

        .status-block .badge.Completed {
            background-color: #fef3ec;
            color: #db4d30;
        }

        .status-block .badge.Started {
            background-color: #db4d30;
            color: #fff;
        }

        .status-block .badge.Upcoming {
            background-color: #f5f5f5;
            color: #db4d30;
        }

        .niti-times {
            font-size: 14px;
            color: #333;
        }

        .niti-times p {
            margin: 2px 0;
            font-weight: 500;
        }

        .niti-times p strong {
            margin-right: 4px;
            color: #666;
        }

        .card {
            background: #fff;
            padding: 25px 30px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            position: relative;
            transition: all 0.3s ease;
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
        .Started .niti-times i {
            color: #fff;
        }

        .Upcoming .card {
            background: #ffffff;
            border-left: 6px solid #db4d30;
        }

        /* .niti-times i {
            width: 17px;
            display: inline-block;
            text-align: center;
            margin-right: 8px;
            font-size: 14px;
            color: #999;
        }

        .niti-times p:hover i {
            transform: scale(1.2);
            filter: drop-shadow(0 0 3px rgba(0, 0, 0, 0.3));
        } */

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

    <div class="card timeline-content {{ $side }}">
        <div class="card-header">
            <div class="niti-title">
                <h3>{{ $niti['niti_name'] }}</h3>
                <div class="underline"></div>
            </div>
            <div class="status-block">
                <span class="badge {{ $statusClass }}">
                    <i class="fas {{ $icon }}"></i> {{ $status === 'Started' ? 'Going On' : $status }}
                </span>

                <div class="niti-times">
                    @if ($status === 'Started' && $start)
                        <p><strong>Started:</strong> {{ \Carbon\Carbon::parse($start)->format('h:i a') }}</p>
                    @endif
                    @if ($status === 'Completed')
                        @if ($start)
                            <p><strong>Started:</strong> {{ \Carbon\Carbon::parse($start)->format('h:i a') }}</p>
                        @endif
                        @if ($end)
                            <p><strong>Completes:</strong> {{ \Carbon\Carbon::parse($end)->format('h:i a') }}</p>
                        @endif
                    @endif
                    @if ($status === 'Upcoming')
                        <p><strong>Starts:</strong> {{ \Carbon\Carbon::parse($niti['date_time'])->format('h:i a') }}
                        </p>
                        <p><strong>Completes:</strong> 06:30 am</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

</body>

</html>
