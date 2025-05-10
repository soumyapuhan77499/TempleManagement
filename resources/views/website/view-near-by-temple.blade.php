<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $temple->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/dham-header.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/footer.css') }}">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #fefefe;
        }

        /* Tabs Container */
        .tab-buttons {
            display: flex;
            border-bottom: 2px solid #e0e0e0;
            gap: 30px;
            margin-bottom: 30px;
            padding: 0 0 10px;
            position: relative;
            overflow-x: auto;
        }

        /* Hide default scrollbar on horizontal scroll */
        .tab-buttons::-webkit-scrollbar {
            display: none;
        }

        .tab-buttons {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Tab Buttons */
        .tab-buttons button {
            background: none;
            border: none;
            font-size: 15px;
            font-weight: 600;
            color: #555;
            padding: 8px 0;
            position: relative;
            cursor: pointer;
            transition: color 0.3s ease;
            white-space: nowrap;
        }

        .tab-buttons button:hover {
            color: #b31e25;
        }

        /* Active Tab Highlight */
        .tab-buttons button.active {
            color: #b31e25;
        }

        .tab-buttons button.active::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -10px;
            width: 100%;
            height: 3px;
            background-color: #b31e25;
            border-radius: 2px;
            transition: all 0.3s ease-in-out;
        }

        /* Icon Support */
        .tab-buttons button i {
            margin-right: 6px;
            font-size: 14px;
            color: #b31e25;
            vertical-align: middle;
        }

        /* Tab Content */
        .tab-content {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Set a fixed height for the temple section */
        .temple-section-tabs {
            display: flex;
            max-width: 1250px;
            height: 500px;
            /* Fixed height for consistency */
            margin: 60px auto;
            background: #fff;
            border-radius: 12px;
            border: 1px solid rgb(213, 213, 213);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .temple-image {
            width: 45%;
            height: 100%;
            background: #f5f5f5;
            overflow: hidden;
        }

        .temple-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0;
        }


        .temple-tabs {
            width: 55%;
            padding: 30px;
            height: 100%;
            overflow-y: auto;
            box-sizing: border-box;
        }

        @media screen and (max-width: 768px) {
            .temple-section-tabs {
                flex-direction: column;
                height: auto;
                margin: 20px 10px;
                border-radius: 8px;
            }

            .temple-image,
            .temple-tabs {
                width: 100%;
                height: auto;
            }

            .temple-image img {
                height: 200px;
                object-fit: cover;
                border-radius: 8px 8px 0 0;
            }

            .temple-tabs {
                padding: 20px;
                max-height: unset;
                overflow-y: visible;
            }

            .tab-buttons {
                gap: 12px;
                padding-bottom: 8px;
                margin-bottom: 20px;
                overflow-x: auto;
                white-space: nowrap;
            }

            .tab-buttons button {
                font-size: 14px;
                padding: 6px 0;
            }

            .tab-buttons button i {
                font-size: 12px;
            }

            .tab-content p,
            .info-list li {
                font-size: 14px;
                line-height: 1.5;
            }

            .map-button {
                font-size: 13px;
                padding: 6px 12px;
            }

            .tab-content .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .tab-content .gallery-grid img {
                height: 140px;
            }

            .temple-left,
            .temple-right {
                padding: 20px;
            }

            .temple-left h3,
            .temple-right h3 {
                font-size: 18px;
            }

            .temple-left p,
            .temple-right p,
            .temple-right ul li {
                font-size: 14px;
            }

            .btn-details {
                font-size: 14px;
                padding: 8px 16px;
            }
        }

        /* Info list */
        .info-list {
            list-style: none;
            padding: 0;
        }

        .info-list li {
            margin-bottom: 10px;
            font-size: 15px;
            line-height: 1.6;
        }

        .info-list li strong {
            color: #b31e25;
        }

        /* Gallery grid */
        .tab-content .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
        }

        .tab-content .gallery-grid img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 6px;
            background: #f8f8f8;
            border: 1px solid #ddd;
        }

        /* Footer and extras */
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

        .map-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: #b31e25;
            color: #fff;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-top: 5px;
        }

        .map-button:hover {
            background-color: #991b1b;
            text-decoration: none;
            color: #fff;
        }
    </style>

</head>

<body>

    @include('partials.header-puri-dham')

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

    <section class="temple-section-tabs">
        <div class="temple-image">
            <img src="{{ asset($firstPhoto) }}" alt="{{ $temple->name }}">
        </div>
        <div class="temple-tabs">
            <h2 class="text-2xl font-bold text-[#b31e25] mb-4">{{ $temple->name }}</h2>

            <div class="tab-buttons">
                <button class="tab-link active" onclick="showTab(event, 'details')">
                    <i class="fa fa-info-circle"></i> Temple Details
                </button>
                <button class="tab-link" onclick="showTab(event, 'history')">
                    <i class="fa fa-book"></i> History
                </button>
                <button class="tab-link" onclick="showTab(event, 'address')">
                    <i class="fa fa-map-marker-alt"></i> Address
                </button>
                <button class="tab-link" onclick="showTab(event, 'gallery')">
                    <i class="fa fa-images"></i> Photo Gallery
                </button>
            </div>

            <div id="address" class="tab-content">
                <ul class="info-list">
                    @if ($temple->distance_from_temple)
                        <li><strong>Distance:</strong> {{ $temple->distance_from_temple }}</li>
                    @endif
                    @if ($temple->city_village || $temple->district || $temple->state)
                        <li><strong>Location:</strong> {{ $temple->city_village }}, {{ $temple->district }},
                            {{ $temple->state }}</li>
                    @endif
                    @if ($temple->google_map_link)
                        <li>
                            <a href="{{ $temple->google_map_link }}" target="_blank" class="map-button">
                                <i class="fa fa-map-marked-alt"></i> View on Google Map
                            </a>
                        </li>
                    @endif

                </ul>
            </div>


            <div id="history" class="tab-content">
                <p>{{ $temple->history ?? 'No historical data available.' }}</p>
                <p>{{ $temple->description ?? 'No description available.' }}</p>

            </div>

            <div id="details" class="tab-content active">
                <ul class="info-list">
                    @if ($temple->estd_date)
                        <li><strong>Established:</strong> {{ $temple->estd_date }}</li>
                    @endif
                    @if ($temple->estd_by)
                        <li><strong>Established By:</strong> {{ $temple->estd_by }}</li>
                    @endif
                    @if ($temple->committee_name)
                        <li><strong>Committee:</strong> {{ $temple->committee_name }}</li>
                    @endif
                    @if ($temple->contact_no)
                        <li><strong>Contact:</strong> {{ $temple->contact_no }}</li>
                    @endif
                    @if ($temple->whatsapp_no)
                        <li><strong>WhatsApp:</strong> {{ $temple->whatsapp_no }}</li>
                    @endif
                    @if ($temple->email)
                        <li><strong>Email:</strong> {{ $temple->email }}</li>
                    @endif
                    @if ($temple->priest_name)
                        <li><strong>Priest:</strong> {{ $temple->priest_name }}</li>
                    @endif
                    @if ($temple->priest_contact_no)
                        <li><strong>Priest Contact:</strong> {{ $temple->priest_contact_no }}</li>
                    @endif
                </ul>
            </div>

            <div id="gallery" class="tab-content">
                @php
                    $photos = json_decode($temple->photo, true);
                @endphp

                @if (!empty($photos))
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px;">
                        @foreach ($photos as $photo)
                            <div
                                style="border-radius: 8px; overflow: hidden; border: 1px solid #ddd; background: #fafafa;">
                                <img src="{{ asset($photo) }}" alt="Temple Photo"
                                    style="width: 100%; height: 180px; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No photos available.</p>
                @endif
            </div>
        </div>
    </section>

    @include('partials.website-footer')

    <script>
        function showTab(evt, tabId) {
            const tabs = document.querySelectorAll('.tab-content');
            const buttons = document.querySelectorAll('.tab-link');

            tabs.forEach(tab => tab.classList.remove('active'));
            buttons.forEach(btn => btn.classList.remove('active'));

            document.getElementById(tabId).classList.add('active');
            evt.currentTarget.classList.add('active');
        }
    </script>
</body>

</html>