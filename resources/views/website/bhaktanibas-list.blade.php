<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bhakta Niwas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/web-service.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/bootstrap.min.css') }}">

</head>

<body>
    @includeIf('partials.web-header')

    <div class="hero">
        <img class="hero-bg" src="{{ asset('website/59.jpg') }}" alt="Bhakta Niwas Background" />
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-left">
                <h1>Bhakta Niwas</h1>
                <p>Experience a peaceful and affordable stay in temple-owned Bhakta Niwas accommodations.</p>
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
            @foreach ($bhaktaNibas as $item)
                <div class="service-card-bhakta">
                    <h5>{{ $item->name }}</h5>
                    @php
                        $photoArray = json_decode($item->photo, true);
                        $firstPhoto = $photoArray[0] ?? null;
                    @endphp

                    <img src="{{ $firstPhoto ? asset($firstPhoto) : asset('website/bhakta.jpeg') }}"
                        alt="{{ $item->name }}">
                    <div class="service-info" style="display: flex; justify-content: space-between;">
                        <div>
                            <div class="info-line">
                                <span class="icon">📍</span>
                                {{ $item->landmark ? $item->landmark . ', ' : '' }}
                                {{ $item->city_village ? $item->city_village . ', ' : '' }}
                            </div>

                            <div class="info-line">
                                <span class="icon">⏰</span> Check In: {{ $item->check_in_time ?? 'N/A' }} | Out:
                                {{ $item->check_out_time ?? 'N/A' }}
                            </div>

                            <div class="info-line">
                                <span class="icon">📞</span> {{ $item->contact_no ?? 'Not Available' }}
                            </div>

                            @if ($item->google_map_link)
                                <div class="info-line">
                                    <span class="icon">🗺️</span>
                                    <a class="btn btn-info btn-sm" style="color:white" href="{{ $item->google_map_link }}" target="_blank">View Map</a>
                                </div>
                            @endif
                        </div>

                        <div style="margin-top: 87px;">
                            <a href="tel:{{ $item->contact_no }}">
                                <button class="booking-btn">Call to Book</button>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</body>

</html>
