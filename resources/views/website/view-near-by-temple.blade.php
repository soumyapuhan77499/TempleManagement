<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $temple->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/dham-header.css') }}">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #fefefe;
        }

        /* Tabs */
        .tab-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 25px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            justify-content: space-between;
        }

        .tab-buttons button {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            font-size: 14px;
            font-weight: 600;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 6px;
            cursor: pointer;
            color: #444;
            transition: all 0.3s ease;
        }

        .tab-buttons button i {
            color: #b31e25;
            font-size: 15px;
        }

        .tab-buttons button:hover {
            background-color: #fff;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
        }

        .tab-buttons button.active {
            background-color: #fff;
            border-color: #b31e25;
            color: #b31e25;
        }

        .tab-buttons button.active i {
            color: #b31e25;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
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
            }

            .temple-image,
            .temple-tabs {
                width: 100%;
                height: auto;
            }

            .temple-tabs {
                max-height: unset;
                overflow-y: unset;
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
                <button class="tab-link" onclick="showTab(event, 'details')">Temple Details</button>
                <button class="tab-link" onclick="showTab(event, 'history')">History</button>
                <button class="tab-link active" onclick="showTab(event, 'address')">Address</button>
                <button class="tab-link" onclick="showTab(event, 'description')">Description</button>
                <button class="tab-link" onclick="showTab(event, 'gallery')">Photo Gallery</button>
            </div>

            <div id="address" class="tab-content active">
                <ul class="info-list">
                    @if ($temple->distance_from_temple)
                        <li><strong>Distance:</strong> {{ $temple->distance_from_temple }}</li>
                    @endif
                    @if ($temple->city_village || $temple->district || $temple->state)
                        <li><strong>Location:</strong> {{ $temple->city_village }}, {{ $temple->district }},
                            {{ $temple->state }}</li>
                    @endif
                    @if ($temple->google_map_link)
                        <li><strong>Map:</strong> <a href="{{ $temple->google_map_link }}" target="_blank">View on
                                Google Map</a></li>
                    @endif
                </ul>
            </div>

            <div id="description" class="tab-content">
                <p>{{ $temple->description ?? 'No description available.' }}</p>
            </div>

            <div id="history" class="tab-content">
                <p>{{ $temple->history ?? 'No historical data available.' }}</p>
            </div>

            <div id="details" class="tab-content">
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


    <div class="timeline-footer">
        © {{ date('Y') }} Temple Management System. All rights reserved.
    </div>

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
