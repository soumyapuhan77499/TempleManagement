<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $temple->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #fefefe;
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
            color: white;
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
        }

        .hero-content p {
            font-size: 17px;
            color: #f5f5f5;
        }

        .temple-section {
            display: flex;
            max-width: 1250px;
            margin: 60px auto;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgb(213, 213, 213);
        }

        .temple-left,
        .temple-right {
            flex: 1;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .temple-left img,
        .temple-right img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .temple-left h3,
        .temple-right h3 {
            font-size: 22px;
            margin-bottom: 12px;
            color: #b31e25;
        }

        .temple-left p,
        .temple-right p {
            font-size: 15px;
            color: #333;
            margin-bottom: 15px;
            line-height: 1.7;
        }

        .temple-right ul {
            list-style: none;
            padding: 0;
        }

        .temple-right ul li {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .temple-right ul li i {
            margin-right: 10px;
            color: #b31e25;
        }

        .btn-details {
            padding: 10px 20px;
            background: #b31e25;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            width: fit-content;
            font-weight: bold;
            margin-top: 10px;
        }

        .timeline-footer {
            text-align: center;
            font-size: 13px;
            color: #aaa;
            margin: 30px 0;
        }

        @media screen and (max-width: 768px) {
            .temple-section {
                flex-direction: column;
            }

            .temple-left,
            .temple-right {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <header class="header-area">
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
    </header>

    <section class="hero">
        <img class="hero-bg" src="{{ asset('website/parking.jpeg') }}" alt="Mandir Background" />
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>{{ $temple->name }}</h1>
            <p>Discover sacred places close to your journey.</p>
        </div>
    </section>

    @php
        $photos = json_decode($temple->photo, true);
        $firstPhoto = $photos[0] ?? 'website/default-temple.jpg';
    @endphp

    <section class="temple-section">
        <div class="temple-left">
            <img src="{{ asset($firstPhoto) }}" alt="{{ $temple->name }}">
        </div>
        <div class="temple-right">
            <h3><i class="fa fa-eye"></i> Temple Overview</h3>
            <p>{{ $temple->description ?? 'No description available.' }}</p>

            <h3><i class="fa fa-map-marker-alt"></i> Location</h3>
            <ul>
                @if ($temple->distance_from_temple)
                    <li><i class="fa fa-road"></i> {{ $temple->distance_from_temple }} from Jagannath Temple</li>
                @endif
                @if ($temple->city_village)
                    <li><i class="fa fa-location-dot"></i> {{ $temple->city_village }}, {{ $temple->district }},
                        {{ $temple->state }}</li>
                @endif
                @if ($temple->contact_no)
                    <li><i class="fa fa-phone"></i> Contact: {{ $temple->contact_no }}</li>
                @endif
                @if ($temple->whatsapp_no)
                    <li><i class="fab fa-whatsapp"></i> WhatsApp: {{ $temple->whatsapp_no }}</li>
                @endif
                @if ($temple->google_map_link)
                    <li><i class="fa fa-map"></i>
                        <a href="{{ $temple->google_map_link }}" target="_blank">View on Map</a>
                    </li>
                @endif
            </ul>

            <a href="{{ url()->previous() }}" class="btn-details">← Back</a>
        </div>
    </section>

    @php
        $secondPhoto = $photos[1] ?? null;
    @endphp

    @if ($secondPhoto && ($temple->history || $temple->description))
        <section class="temple-section">
            <div class="temple-left">
                <h3><i class="fa fa-book-open"></i> History</h3>
                <p>{{ $temple->history ?? 'No historical data available.' }}</p>

                <h3><i class="fa fa-align-left"></i> Description</h3>
                <p>{{ $temple->description ?? 'No description provided.' }}</p>
            </div>
            <div class="temple-right">
                <img src="{{ asset($secondPhoto) }}" alt="Temple Image">
            </div>
        </section>
    @endif


    <div class="timeline-footer">
        © {{ date('Y') }} Temple Management System. All rights reserved.
    </div>
</body>

</html>
