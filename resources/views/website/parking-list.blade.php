<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Visitor Parking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/web-service.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    @includeIf('partials.web-header')

    <div class="hero">
        <img class="hero-bg" src="{{ asset('website/parkings.jpg') }}" alt="Visitor Parking Background" />
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-left">
                <h1>Visitor Parking</h1>
                <p>Park your two, three & four Wheelers with <br> ease at the following spaces</p>
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
            @foreach ($parking as $item)
                <div class="service-card">
                    <h5>{{ $item->parking_name }}</h5>
                    <img src="{{ $item->parking_photo ? asset($item->parking_photo) : asset('website/parking.jpeg') }}" alt="{{ $item->parking_name }}">
                    <div class="service-info" style="display: flex; justify-content: space-between;">
                        <div>
                            <div class="info-line">
                                <span class="icon">📍</span> 
                                {{ $item->landmark ? $item->landmark . ', ' : '' }}
                                {{ $item->city_village ? $item->city_village . ', ' : '' }}
                            </div>
                            
                            <div class="info-line">
                                <span class="icon">⏰</span> 24/7
                            </div>
                            <div class="info-line availability {{ $item->parking_availability > 50 ? 'green' : 'red' }}">
                                <span class="icon">🅿️</span> {{ $item->parking_availability }}/250 Spots Available
                            </div>
                        </div>
    
                        <div style="margin-top: 45px;">
                            <button class="booking-btn">Confirm Booking</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
</body>

</html>
