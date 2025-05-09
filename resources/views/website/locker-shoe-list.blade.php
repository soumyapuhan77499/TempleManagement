<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Locker & Shoe Stands</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/web-service.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/footer.css') }}">

    <style>
        .service-card img,
        .service-card-bhakta img {
            width: 100%;
            border-radius: 10px;
            object-fit: cover;
            height: 270px;
        }
    </style>

</head>

<body>
    @includeIf('partials.web-header')
    <div class="hero">
        <img class="hero-bg" src="{{ asset('website/parking.jpeg') }}" alt="Visitor Parking Background" />
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-left">
                <h1>Locker & Shoes</h1>
                <p></p>
            </div>
        </div>
    </div>
    
    <div class="hero-right">
        <div class="view-buttons">
            <button class="list-view-btn">List View</button>
            <button class="map-view-btn">Map View</button>
        </div>
    </div>
    <div class="container">
        <div class="service-grid">
            @foreach ($services as $item)
                <div class="service-card">
                    <h5>{{ $item->service_name }}</h5>

                    @php
                        $photoArray = json_decode($item->photo, true);
                        $firstPhoto = $photoArray[0] ?? null;
                    @endphp

                    <img src="{{ $firstPhoto ? asset($firstPhoto) : asset('website/stand.png') }}" alt="{{ $item->service_name }}">

                    <div class="service-info" style="display: flex; justify-content: space-between;">
                        <div>
                            <div class="info-line">
                                <span class="icon">📍</span>
                                {{ $item->landmark ? $item->landmark . ', ' : '' }}
                                {{ $item->city_village ? $item->city_village . ', ' : '' }}
                            </div>

                            <div class="info-line">
                                <span class="icon">⏰</span> {{ $item->opening_time ?? 'N/A' }} - {{ $item->closing_time ?? 'N/A' }}
                            </div>

                            <div class="info-line">
                                <span class="icon">📞</span> {{ $item->contact_no ?? 'Not Available' }}
                            </div>

                            @if($item->google_map_link)
                                <div class="info-line">
                                    <span class="icon">🗺️</span>
                                    <a class="btn btn-sm btn-info" style="color: white" href="{{ $item->google_map_link }}" target="_blank">View Map</a>
                                </div>
                            @endif
                        </div>

                        <div style="margin-top: 84px;">
                            <a href="tel:{{ $item->contact_no }}">
                                <button class="booking-btn">Call</button>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('partials.website-footer')

</body>

</html>
