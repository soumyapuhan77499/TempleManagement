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
            background: linear-gradient(to bottom, #db4d30, #ff9900, #1d4ed8);
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
            width: 12px;
            height: 12px;
            background-color: #db4d30;
            border: 3px solid white;
            border-radius: 50%;
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
    
        .badge.Completed {
            background-color: #fbe4dc;
            color: #db4d30;
        }
    
        .badge.Started {
            background-color: #ffd6a0;
            color: #ff6f00;
        }
    
        .badge.Upcoming {
            background-color: #fef3f0;
            color: #db4d30;
        }
    
        .Completed .card {
            border-left: 8px solid #db4d30;
        }
    
        .Started .card {
            border-left: 8px solid #ff6f00;
        }
    
        .Upcoming .card {
            border-left: 8px solid #db4d30;
        }
    
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
