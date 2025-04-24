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
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .card h3 {
            margin: 0 0 12px;
            font-size: 22px;
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
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .badge i {
            font-size: 14px;
        }

        /* Badge and Card Color Themes */
        .badge.Completed {
            background-color: #fef3ec;
            color: #db4d30;
        }

        .badge.GoingOn {
            background-color: #fef6e7;
            color: #e07c00;
        }

        .badge.Upcoming {
            background-color: #f5f5f5;
            color: #777;
        }

        .Completed .card {
            border-left: 8px solid #db4d30;
        }

        .GoingOn .card {
            border-left: 8px solid #f59e0b;
        }

        .Upcoming .card {
            border-left: 8px solid #d1d5db;
        }

        .badge.Started {
            background-color: #fff3f0;
            color: #db4d30;
        }

        .badge.Upcoming {
            background-color: #f5f5f5;
            color: #555;
        }

        .badge.Completed {
            background-color: #e9f7ec;
            color: #2e7d32;
        }


        /* Time icons */
        .niti-times i {
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

        .sub-nitis {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #ddd;
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
                $status = $niti['niti_status']; // Already capitalized as 'Started', 'Completed', etc.
                $side = $index % 2 === 0 ? 'left' : 'right';

                // Icon and style for each status
                $icon = match ($status) {
                    'Completed' => 'fa-check-circle',
                    'Started' => 'fa-play-circle',
                    'Upcoming' => 'fa-bell',
                };

                $cardBgStyle = $status === 'Started' ? 'background-color: #db4d30; color: #fff;' : '';
                $iconColor = $status === 'Started' ? 'text-white' : '';
            @endphp

            <div class="timeline-item {{ $side }} {{ $status }}">
                <div class="card timeline-content" style="{{ $cardBgStyle }}">
                    <span class="badge {{ $status }}">
                        <i class="fas {{ $icon }}"></i> {{ $status }}
                    </span>

                    <h3>{{ $niti['niti_name'] }}</h3>

                    <div class="niti-times">
                        @if ($status === 'Started')
                            <p><i class="fas fa-play-circle {{ $iconColor }}"></i>
                                <strong>Started:</strong>
                                {{ $start ? \Carbon\Carbon::parse($start)->format('h:i a') : 'Not Recorded' }}
                            </p>
                        @endif
                    
                        @if ($status === 'Completed')
                            <p><i class="fas fa-stop-circle text-danger"></i>
                                <strong>Completed:</strong>
                                {{ $end ? \Carbon\Carbon::parse($end)->format('h:i a') : 'Not Recorded' }}
                            </p>
                        @endif
                    </div>
                    

                    @if (!empty($niti['running_sub_niti']) && count($niti['running_sub_niti']) > 0)
                        <div class="sub-nitis">
                            <strong>Sub Nitis:</strong>
                            <ul style="padding-left: 20px;">
                                @foreach ($niti['running_sub_niti'] as $sub)
                                    @if (!empty($sub['sub_niti_name']))
                                        <li>{{ $sub['sub_niti_name'] }} ({{ $sub['status'] ?? 'Pending' }})</li>
                                    @endif
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
