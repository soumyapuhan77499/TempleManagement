@extends('website.web-layouts')

@section('content')
    <section class="banner-sections">
        <!-- Video Banner -->
        @if ($latestWebVideo && $latestWebVideo->banner_video)
            <div class="banner-video">
                <video id="bannerVideo" autoplay loop playsinline muted preload="metadata"
                    poster="{{ asset('storage/' . $latestWebVideo->banner_image ?? 'website/d.png') }}">
                    <source src="{{ asset('storage/' . $latestWebVideo->banner_video) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        @else
            <!-- Optional fallback image or message -->
            <img src="{{ asset('website/d.png') }}" alt="Default Banner" style="width: 100%;">
        @endif

        <!-- Logo (Top Left) -->
        <div class="logo">
            <img src="{{ asset('website/logo.png') }}" alt="logo">
        </div>
        <!-- Hamburger Icon -->
        <div class="hamburger-icon">
            <div class="hamburger-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="nav-menu">
            <div class="nav-close"><i class="fa fa-times"></i></div>
            <ul>
                <li><a href="#">Nitis</a></li>
                <li>
                    <a href="#">SM <span class="live-badges"><i class="fa fa-bolt"></i> Live</span></a>
                </li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Nearby Temples</a></li>
                <li><a href="#">Conveniences</a></li>
                <li><a href="#">Temple Information</a></li>
            </ul>
        </nav>

        <button id="playPauseButton" class="play-pause-button"><i class="fa fa-pause"></i></button>

        <button id="muteToggle" class="mute-toggle"><i style="height:18px;width: 18px"
                class="fa fa-volume-mute"></i></button>
    </section>

    <div class="niti-cards-scroll">
        <div class="niti-cards">
            @foreach ($nitis as $niti)
                <div class="niti-card {{ $loop->first ? 'active' : '' }}">
                    <div class="niti-content">
                        <h3 style="font-size: 22px; padding-bottom:5px;">{{ $niti->niti_name }}</h3>
                        <p style="padding-top: 5px;"><strong>{{ $niti->niti_type }}</strong></p>
                    </div>
                    <div class="niti-icons">
                        <p style="color: rgb(139, 137, 137)">
                            <ion-icon name="time-outline" style="margin: 6px; color: #ff0011; font-size: 16px;"></ion-icon>
                            {{ \Carbon\Carbon::parse($niti->date_time)->format('h:i A') }}
                        </p>
                        <p style="color: rgb(139, 137, 137)">
                            <ion-icon name="calendar-outline"
                                style="margin: 6px; color: #ff0011; font-size: 16px;"></ion-icon>
                            {{ \Carbon\Carbon::parse($niti->date_time)->format('jS M') }}
                        </p>
                    </div>
                </div>
            @endforeach

            <!-- View All Niti Card -->
            <div class="niti-card">
                <div class="niti-content text-center">
                    <h3 style="font-size: 22px; padding-bottom: 5px;"><a href="{{ route('all.niti') }}">View All Niti</a>
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <section class="shree-mandir-section">

        <div class="section-container">
            <img src="{{ asset('website/left.png') }}" alt="Shree Jagannatha Dham">
            <h2 class="section-titles">Shree Mandir <span class="live-badge"><i class="fa fa-bolt"
                        style="margin-right: 6px"></i>Live</span></h2>
            <img src="{{ asset('website/right.png') }}" alt="Shree Jagannatha Dham">
        </div>

        <div class="mandir-content">
            <!-- TV Section -->
            <div class="mandir-card">
                <div class="card-content">
                    <a href="{{ route('tv.layout') }}">
                        <div class="card-icon">
                            <img src="{{ asset('website/tv.png') }}" style="height: 60px;width: 65px"
                                alt="Shree Jagannatha Dham">
                            <h3 style="color: #db4d30">TV</h3>
                        </div>
                    </a>
                    <p class="para">Watch all the live broadcasts from Shree Mandira</p>
                    <p style="margin-top: 10px">🕒 03:17 pm</p>
                    <p style="margin-top: 10px">📅 4th Mar</p>
                </div>
                <a href="{{ route('tv.layout') }}">
                    <div class="video-container">
                        <img src="{{ asset('website/60.png') }}" style="height: 250px;width: 400px;border-radius: 10px"
                            alt="Shree Jagannatha Dham">
                    </div>
                </a>

            </div>

            <!-- Radio Section -->
            <div class="radio-card">
                <div class="card-content">
                    <a href="{{ route('radio.layout') }}">
                        <div class="card-icon">
                            <img src="{{ asset('website/radio.png') }}" style="height: 60px;width: 65px"
                                alt="Shree Jagannatha Dham">
                            <h3 style="color: #db4d30">Radio</h3>
                        </div>
                    </a>
                    <p class="paras">Listen all the live broadcasts from Shree Mandira</p>
                    <p style="margin-top: 10px">🕒 03:17 pm</p>
                    <p style="margin-top: 10px">📅 4th Mar</p>
                </div>
                <div class="radio-player">
                    <div class="radio-header">Jay Jagannath</div>
                    <div class="radio-nav">
                        <span><i class="fa fa-compass"></i>
                            <p style="font-size: 10px">Explore</p>
                        </span>
                        <span><i class="fa fa-heart"></i>
                            <p style="font-size: 10px">Favorites</p>
                        </span>
                        <span class="active"><i class="fa fa-map"></i>
                            <p style="font-size: 10px">Browse</p>
                        </span>
                        <span><i class="fa fa-search"></i>
                            <p style="font-size: 10px">Search</p>
                        </span>
                        <span><i class="fa fa-bars"></i>
                            <p style="font-size: 10px">Settings</p>
                        </span>
                    </div>
                    <div class="radio-station">
                        <!-- Header with Title & Icons -->
                        <div class="radio-headers">
                            <h4>Bhajans Name</h4>
                            <div class="radio-icons">
                                <i class="fas fa-heart"></i>
                                <i class="fas fa-ellipsis-h"></i>
                            </div>
                        </div>

                        <!-- Player Controls -->
                        <div class="radio-controls">
                            <div class="song">
                                <img src="{{ asset('website/12.png') }}" alt="Prev">
                                <img src="{{ asset('website/11.png') }}" alt="Play">
                                <img src="{{ asset('website/10.png') }}" alt="Next">
                            </div>
                            <div class="progress-bar">
                                <input type="range" min="0" max="100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="services-section py-10  bg-gradient-to-br from-orange-50 via-yellow-50 to-pink-100">
        <!-- Section Title -->
        <div class="text-center mb-14">
            <div class="flex justify-center items-center gap-4">
                <img src="{{ asset('website/left.png') }}" alt="Left Decor" class="w-36 h-5 animate-pulse">
                <h2 class="text-xl font-semibold text-[#db4d30] tracking-wide drop-shadow-md">Quick Services</h2>
                <img src="{{ asset('website/right.png') }}" alt="Right Decor" class="w-36 h-5 animate-pulse">
            </div>
        </div>
    
        <!-- Services Layout -->
        <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
            <!-- Left Featured Card (Fixed height: 450px) -->
            <div class="bg-gradient-to-r from-[#ffe4e1] to-[#fff7f0] rounded-3xl shadow-md p-8 flex flex-col justify-between transition-all duration-500 hover:scale-105 h-[450px]">
                <a href="{{ route('darshan.timeline') }}" class="flex flex-col items-center text-center h-full">
                    <img src="{{ asset('website/1000.jpg') }}" alt="Darshan"
                         class="mb-2 transition-transform duration-300 hover:rotate-12 p-2  shadow-md" style="width: 400px; height: 170px; border-radius: 25px;">
                    <h3 class="text-2xl font-bold text-[#db4d30] mb-2">Darshan</h3>
                    <p class="text-gray-700 mb-5 leading-relaxed">Experience the divine Darshan of Lord Jagannath in a seamless and sacred way the divine Darshan of Lord Jagannath in a seamless and sacred way.of Lord Jagannath in a seamless and sacred way. the divine Darshan of Lord Jagannath in a seamless and sacred way the divine Darshan </p>
                    <span class="inline-block mt-auto text-white bg-gradient-to-r from-[#db4d30] to-[#ff7f50] py-2 px-6 rounded-full text-sm font-semibold shadow hover:shadow-lg transition">Read More</span>
                </a>
            </div>
    
            <!-- Right Side - 3 Fixed Cards (150px each) -->
            <div class="flex flex-col gap-6 justify-between h-[450px]">
                <!-- Maha Prasad -->
                <div class="bg-white border-l-4 border-[#db4d30] rounded-xl shadow-md px-5 py-4 flex items-center gap-5 h-[150px] hover:shadow-lg transition-transform hover:translate-x-1 duration-300">
                    <img src="{{ asset('website/1001.png') }}" alt="Maha Prasad"
                         class="w-16 h-16 bg-gradient-to-r from-yellow-200 to-yellow-400 p-2 rounded-full shadow-md">
                    <div>
                        <h3 class="text-lg font-semibold text-[#db4d30]">Maha Prasad</h3>
                        <p class="text-sm text-gray-600">Savor the sacred offering blessed by the divine presence.</p>
                        <a href="{{ route('prasad.timeline') }}" class="text-sm text-[#db4d30] hover:underline mt-1 inline-block">Read More</a>
                    </div>
                </div>
    
                <!-- Panji -->
                <div class="bg-white border-l-4 border-[#db4d30] rounded-xl shadow-md px-5 py-4 flex items-center gap-5 h-[150px] hover:shadow-lg transition-transform hover:translate-x-1 duration-300">
                    <img src="{{ asset('website/1002.png') }}" alt="Panji"
                         class="w-16 h-16 bg-gradient-to-r from-blue-200 to-blue-400 p-2 rounded-full shadow-md">
                    <div>
                        <h3 class="text-lg font-semibold text-[#db4d30]">Panji</h3>
                        <p class="text-sm text-gray-600">Explore traditional records and sacred schedules maintained over centuries.</p>
                        <a href="#" class="text-sm text-[#db4d30] hover:underline mt-1 inline-block">Read More</a>
                    </div>
                </div>
    
                <!-- Offering -->
                <div class="bg-white border-l-4 border-[#db4d30] rounded-xl shadow-md px-5 py-4 flex items-center gap-5 h-[150px] hover:shadow-lg transition-transform hover:translate-x-1 duration-300">
                    <img src="{{ asset('website/1003.png') }}" alt="Offering"
                         class="w-16 h-16 bg-gradient-to-r from-pink-200 to-red-300 p-2 rounded-full shadow-md">
                    <div>
                        <h3 class="text-lg font-semibold text-[#db4d30]">Offering</h3>
                        <p class="text-sm text-gray-600">Make your humble offerings to the Lord with ease and devotion.</p>
                        <a href="#" class="text-sm text-[#db4d30] hover:underline mt-1 inline-block">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="services-sections">

        <!-- Bhakta Nibas -->
        <a href="{{ route('bhaktanibas.list') }}" class="service-cards" style="text-decoration: none;">
            <div class="card-top">
                <div class="card-text">
                    <div class="card-title">Bhakta Nibas</div>
                    <div class="card-desc">Temple owned <br>properties for<br>pilgrim stay</div>
                </div>
                <div class="arrow-icon" style="font-size: 20px;">➡️</div>
            </div>
            <div class="card-bottom">
                <div class="card-icons" style="font-size: 40px; color: #c27462;">🏠</div>
                <div class="footer-bar bar-orange"></div>
            </div>
        </a>
    
        <!-- Parking Areas -->
        <a href="{{ route('parking.list') }}" class="service-cards" style="text-decoration: none;">
            <div class="card-top">
                <div class="card-text">
                    <div class="card-title">Parking Areas</div>
                    <div class="card-desc">2, 3, 4 Wheelers</div>
                </div>
                <div class="arrow-icon" style="font-size: 20px;">➡️</div>
            </div>
            <div class="card-bottom">
                <div style="margin-right:5%; height: 50px; width: 50px; margin-bottom: 25px; display: flex; align-items: center; justify-content: center;">
                    <span style="color: white; font-size: 40px;">🅿️</span>
                </div>
                <div class="footer-bar bar-red"></div>
            </div>
            
        </a>
    
        <!-- Locker & Shoes -->
        <a href="{{ route('lockershoe.list') }}" class="service-cards" style="text-decoration: none;">
            <div class="card-top">
                <div class="card-text">
                    <div class="card-title">Locker & Shoes Stands</div>
                    <div class="card-desc">Shoes, Mobile <br>Phones etc</div>
                </div>
                <div class="arrow-icon" style="font-size: 20px;">➡️</div>
            </div>
            <div class="card-bottom">
                <div class="card-icons" style="font-size: 40px; color: #6577e6;">🧳</div>
                <div class="footer-bar bar-blue"></div>
            </div>
        </a>
    
        <!-- Online Donations -->
        <div class="service-cards">
            <div class="card-top">
                <div class="card-text">
                    <div class="card-title">Online Donations</div>
                    <div class="card-desc" style="color:#22c5ee; font-weight: 500;">Donate Now</div>
                </div>
                <div class="arrow-icon" style="font-size: 20px;">➡️</div>
            </div>
            <div class="card-bottom">
                <div class="card-icons" style="font-size: 40px; color: #22c5ee;">💳</div>
                <div class="footer-bar bar-cyan"></div>
            </div>
        </div>
    
        <!-- Hundi Collection -->
        <div class="service-cards">
            <div class="card-top">
                <div class="card-text">
                    <div class="card-title">Hundi Collection</div>
                    <div class="card-desc">
                        20th Mar, 25<br />
                        <span style="color:#e75230; font-weight:600;">₹5,30,000/-</span>
                    </div>
                </div>
                <div class="arrow-icon" style="font-size: 20px;">➡️</div>
            </div>
            <div class="card-bottom">
                <div class="card-icons" style="font-size: 40px; color: #6bbf84;">🪙</div>
                <div class="footer-bar bar-green"></div>
            </div>
        </div>
    
    </section>

    <section class="temple-slider bg-white  bg-gradient-to-br from-orange-50 via-yellow-50 to-pink-100">
        <div class="flex justify-center items-center gap-5 mt-12">
            <img src="{{ asset('website/left.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
            <h2 class="text-xl text-[#db4d30] font-semi-bold">Nearby Temples</h2>
            <img src="{{ asset('website/right.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
        </div>

        <div class="swiper mySwiper mt-12">
            <div class="swiper-wrapper">
                @foreach ($nearbyTemples as $temple)
                    @php
                        $photos = json_decode($temple->photo, true);
                        $firstPhoto = isset($photos[0]) ? $photos[0] : null;
                    @endphp
                    @if ($firstPhoto)
                        <div class="swiper-slide rounded-xl overflow-hidden shadow-lg">
                            <img src="{{ asset($firstPhoto) }}" alt="{{ $temple->temple_name }}"
                                class="w-full h-full object-cover">
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Navigation buttons -->
            <div class="swiper-button-next text-orange-500"></div>
            <div class="swiper-button-prev text-orange-500"></div>
        </div>
    </section>

    <section class="temple-convenience">

        <div class="flex justify-center items-center gap-5">
            <img src="{{ asset('website/left.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
            <h2 class="text-2xl text-[#db4d30] flex items-center font-sans">
                Conveniences
            </h2>
            <img src="{{ asset('website/right.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
        </div>

        <div class="convenience-container">
            <div class="conv">
                <div class="convenience-item active">
                    <i class="fas fa-tint"></i>
                </div>
                <p>Water</p>
            </div>

            <div class="conv">
                <div class="convenience-item">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <p>Emergency</p>
            </div>

            <div class="conv">
                <div class="convenience-item">
                    <i class="fas fa-wheelchair"></i>
                </div>
                <p>Handicap</p>
            </div>

            <div class="conv">
                <div class="convenience-item">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <p>Route Map</p>
            </div>

            <div class="conv">
                <div class="convenience-item">
                    <i class="fas fa-utensils"></i>
                </div>
                <p>Free Food</p>
            </div>

            <div class="conv">
                <div class="convenience-item">
                    <i class="fas fa-search"></i>
                </div>
                <p>Lost & Found</p>
            </div>

            <div class="conv">
                <div class="convenience-item">
                    <i class="fas fa-toilet"></i>
                </div>
                <p>Toilet</p>
            </div>

            <div class="conv">
                <div class="convenience-item">
                    <i class="fas fa-umbrella-beach"></i>
                </div>
                <p>Beaches</p>
            </div>

            <div class="conv">
                <div class="convenience-item">
                    <i class="fas fa-life-ring"></i>
                </div>
                <p>Life Guards</p>
            </div>
        </div>
    </section>

    <section class="bg-100 p-10  bg-gradient-to-br from-orange-50 via-yellow-50 to-pink-100">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 md:gap-0">
                <div class="image-panji flex items-center gap-2">
                    <p class="text-2xl text-[#db4d30] flex items-center font-sans">
                        Panji Calendar
                    </p>
                    <img src="{{ asset('website/right.png') }}" alt="Shree Jagannatha Dham" class="w-28 h-5">
                </div>
                <!-- Desktop-only: Events Header stays here on larger screens -->
                <div class="image-event flex items-center gap-2 hidden md:flex">
                    <p class="text-2xl text-[#db4d30] flex items-center font-sans">
                        Events
                    </p>
                    <img src="{{ asset('website/right.png') }}" alt="Shree Jagannatha Dham" class="w-28 h-5">
                </div>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Calendar Section -->
                <div class="bg-white p-6 rounded-xl border border-yellow-300">
                    <h3 class="text-md font-semibold text-red-500 mb-2">Select date</h3>
                    <div id="calendar"></div>
                </div>


                <!-- Events Section -->
                <div class="bg-white p-6 rounded-xl border border-gray-300">
                    <div class="flex items-center gap-2 mb-4 md:hidden">
                        <p class="text-xl font-semibold text-[#db4d30] font-sans">
                            Events
                        </p>
                        <img src="{{ asset('website/right.png') }}" alt="Shree Jagannatha Dham" class="w-28 h-5">
                    </div>
                    <div id="events" class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-4">
                        <!-- Event Cards -->
                        <div class="bg-100 p-3 rounded-lg text-center hover:shadow-xl transition">
                            <img src="website/6.png" class="mx-auto w-12 h-12">
                            <p class="text-600 font-semibold">Sankranti</p>
                        </div>
                        <div class="bg-100 p-3 rounded-lg text-center hover:shadow-xl transition">
                            <img src="website/6.png" class="mx-auto w-12 h-12">
                            <p class="text-600 font-semibold">Amavasya</p>
                        </div>
                        <div class="bg-100 p-3 rounded-lg text-center hover:shadow-xl transition">
                            <img src="website/6.png" class="mx-auto w-12 h-12">
                            <p class="text-600 font-semibold">Pournami</p>
                        </div>
                        <div class="bg-100 p-3 rounded-lg text-center hover:shadow-xl transition">
                            <img src="website/6.png" class="mx-auto w-12 h-12">
                            <p class="text-600 font-semibold">Sankranti</p>
                        </div>
                        <div class="bg-100 p-3 rounded-lg text-center hover:shadow-xl transition">
                            <img src="website/6.png" class="mx-auto w-12 h-12">
                            <p class="text-600 font-semibold">Amavasya</p>
                        </div>
                        <div class="bg-100 p-3 rounded-lg text-center hover:shadow-xl transition">
                            <img src="{{ asset('website/6.png') }}" class="mx-auto w-12 h-12">
                            <p class="text-600 font-semibold">Pournami</p>
                        </div>

                        <div class="bg-100 p-3 rounded-lg text-center hover:shadow-xl transition">
                            <img src="website/6.png" class="mx-auto w-12 h-12">
                            <p class="text-600 font-semibold">Sankranti</p>
                        </div>
                        <div class="bg-100 p-3 rounded-lg text-center hover:shadow-xl transition">
                            <img src="website/6.png" class="mx-auto w-12 h-12">
                            <p class="text-600 font-semibold">Amavasya</p>
                        </div>
                        <div class="bg-100 p-3 rounded-lg text-center hover:shadow-xl transition">
                            <img src="{{ asset('website/6.png') }}" class="mx-auto w-12 h-12">
                            <p class="text-600 font-semibold">Pournami</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-6xl mx-auto text-center">

        <div class="flex justify-center items-center gap-5 mt-12">
            <img src="{{ asset('website/left.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
            <h2 class="text-2xl text-[#db4d30] flex items-center font-sans">
                Temple Information
            </h2>
            <img src="{{ asset('website/right.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
        </div>

        <!-- Navigation Tabs -->
        <div class="flex justify-center items-center gap-6 mt-5 mb-12">
            <div id="navContainer" class="flex gap-5 overflow-x-auto no-scrollbar">
                <div class="tab-item text-center min-w-[100px] cursor-pointer active-tab" data-tab="aboutTemple">
                    <img src="{{ asset('website/6.png') }}" class="mx-auto w-10 h-10">
                    <p class="text-red-600 font-semibold mt-3">About Temple</p>
                    <div class="h-1 bg-red-500 w-full mt-1"></div>
                </div>

                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="mathaAshram">
                    <img src="{{ asset('website/6.png') }}" class="mx-auto w-10 h-10">
                    <p class="text-gray-500 mt-3">Matha & Ashram</p>
                </div>
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="shreeKhetra">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500 mt-3">Shree Khetra</p>
                </div>
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="festivals">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500 mt-3">Festivals</p>
                </div>
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="nijoga">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500 mt-3">36 Nijoga</p>
                </div>
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="besha">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500 mt-3">Besha</p>
                </div>
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="darshan">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500 mt-3">Darshan Facility</p>
                </div>
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="prasad">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500 mt-3">Maha Prasad</p>
                </div>
            </div>
        </div>
    </div>

    <section id="dynamicContent" class="bg-100">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <!-- Image -->
                <div id="contentImageContainer" class="mt-12" style="height: 350px; width: 450px;">
                    <img id="contentImage" src="{{ asset($photos->temple_images[0] ?? 'website/12.jpg') }}"
                        alt="Temple Image" class="rounded-xl shadow-lg object-cover w-full h-full" />
                </div>

                <!-- Text Content -->
                <div style="margin-left: -100px">
                    <h2 id="contentTitle" class="text-xl font-semi-bold">

                    </h2>
                    <h3 id="contentSubtitle" class="text-md text-gray-600 mt-2">

                    </h3>
                    <p id="contentDescription" class="text-gray-500 mt-4 leading-relaxed">

                    </p>

                    <button
                        class="mt-6 px-6 py-2 bg-red-100 text-red-600 rounded-lg shadow-md hover:bg-red-200 transition">
                        Read More
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-100 p-2 relative  bg-gradient-to-br from-orange-50 via-yellow-50 to-pink-100" style="margin-top: 50px">
        <div class="max-w-6xl mx-auto text-center relative">
            <!-- Tabs Container -->

            <div class="absolute top-28 right-0 flex space-x-3 p-3  rounded-lg">
                <!-- Worldwide Tab -->
                <button class="tab-buttons active-tabs" onclick="showContent('worldwide', this)">
                    Worldwide
                </button>
                <!-- India Tab -->
                <button class="tab-buttons" onclick="showContent('india', this)">
                    India
                </button>
                <!-- Odisha Tab -->
                <button class="tab-buttons" onclick="showContent('odisha', this)">
                    Odisha
                </button>
            </div>

            <div class="flex justify-center items-center gap-5 mt-12">
                <img src="{{ asset('website/left.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
                <h2 class="text-2xl text-[#db4d30] flex items-center font-sans">
                    Jagannatha Temples Worldwide
                </h2>
                <img src="{{ asset('website/right.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
            </div>

            <!-- Banner Image -->
            <div class="dynamic-image mt-10">
                <img id="dynamicImage" src="{{ asset('website/18.png') }}" alt="Shree Jagannatha Dham" class="mx-auto">
            </div>
        </div>
    </section>
@endsection
