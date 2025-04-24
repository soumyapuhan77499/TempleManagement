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
            <img src="{{ asset('website/d.png') }}" alt="Default Banner" style="width: 100%;">
        @endif

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

                        <p
                            style="padding-top: 5px; font-weight: bold; 
                        color: {{ $niti->niti_status == 'Started' ? '#28a745' : '#333' }};">
                            {{ $niti->niti_status }}
                        </p>
                    </div>

                    <div class="niti-icons">
                        <p style="color: rgb(139, 137, 137)">
                            <ion-icon name="time-outline" style="margin: 6px; color: #ff0011; font-size: 16px;"></ion-icon>
                            @if ($niti->niti_status === 'Upcoming')
                                Not Started
                            @else
                                {{ \Carbon\Carbon::parse($niti->start_time)->format('h:i A') }}
                            @endif
                        </p>
                        <p style="color: rgb(139, 137, 137)">
                            <ion-icon name="calendar-outline"
                                style="margin: 6px; color: #ff0011; font-size: 16px;"></ion-icon>
                            {{ \Carbon\Carbon::parse($niti->date)->format('jS M') }}
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
    {{-- 
    <section class="shree-mandir-section  bg-gradient-to-br from-orange-50 via-yellow-50 to-pink-100">

        <div class="section-container">
            <img src="{{ asset('website/left.png') }}" alt="Shree Jagannatha Dham">
            <h2 class="section-titles">Shree Mandir <span class="live-badge"><i class="fa fa-bolt"
                        style="margin-right: 6px"></i>Live</span></h2>
            <img src="{{ asset('website/right.png') }}" alt="Shree Jagannatha Dham">
        </div>

        <div class="mandir-content">

            <div class="radio-card">
                <div class="card-content">
                    <a href="{{ route('radio.layout') }}">
                        <div class="card-icon">
                            <img src="{{ asset('website/radio.png') }}" style="height: 60px;width: 65px"
                                alt="Shree Jagannatha Dham">
                            <h3 style="color: #db4d30">Radio</h3>
                        </div>
                    </a>
                    <p class="paras">Listen to all the live broadcasts from Shree Mandira</p>
                    <p style="margin-top: 10px">🕒 12:00 pm</p>
                    <p style="margin-top: 10px">📅 4th Apr</p>
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
                                <i style="color: #ff4e00" class="fas fa-heart"></i>
                                <i style="color: #ff4e00" class="fas fa-ellipsis-h"></i>
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
                    <p style="margin-top: 10px">🕒 12:00 pm</p>
                    <p style="margin-top: 10px">📅 4th Apr</p>
                </div>
                <a href="{{ route('tv.layout') }}">
                    <div class="video-container">
                        <img src="{{ asset('website/60.png') }}" style="height: 250px;width: 400px;border-radius: 10px"
                            alt="Shree Jagannatha Dham">
                    </div>
                </a>

            </div>

            <!-- Radio Section -->

        </div>
    </section> --}}

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
                    <img src="{{ asset('website/temple_info/supreme.jpeg') }}" class="mx-auto w-20 h-20" style="border-radius: 50%">
                    <p class="text-red-600 font-semibold mt-3">Lord Supreme</p>
                    <div class="h-1 bg-red-500 w-full mt-1"></div>
                </div>

                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="shreeKhetra">
                    <img src="{{ asset('website/temple_info/age.jpg') }}" class="mx-auto w-20 h-20"  style="border-radius: 50%">
                    <p class="text-gray-500 mt-3">Through The Ages</p>
                </div>

                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="nijoga">
                    <img src="{{ asset('website/temple_info/tradition.jpeg') }}"  class="mx-auto w-20 h-20" style="border-radius: 50%">
                    <p class="text-gray-500 mt-3">Living Tradition</p>
                </div>

                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="festivals">
                    <img src="{{ asset('website/temple_info/festival.jpeg') }}"  class="mx-auto w-20 h-20" style="border-radius: 50%">
                    <p class="text-gray-500 mt-3">Festivals</p>
                </div>

                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="besha">
                    <img src="{{ asset('website/temple_info/ratha.jpeg') }}"  class="mx-auto w-20 h-20" style="border-radius: 50%">
                    <p class="text-gray-500 mt-3">Ratha Yatra</p>
                </div>

                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="darshan">
                    <img src="{{ asset('website/temple_info/darashan.jpg') }}"  class="mx-auto w-20 h-20" style="border-radius: 50%">
                    <p class="text-gray-500 mt-3">Visitor Services</p>
                </div>
              
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="mathaAshram">
                    <img src="{{ asset('website/temple_info/management.jpg') }}"  class="mx-auto w-20 h-20" style="border-radius: 50%">
                    <p class="text-gray-500 mt-3">Management</p>
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

    <section class="services-section py-10 ">
        <!-- Section Title -->
        <div class="text-center mb-14">
            <div class="flex justify-center items-center gap-5 mt-12">
                <img src="{{ asset('website/left.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
                <h2 class="text-2xl text-[#db4d30] flex items-center font-sans">
                    Quick Services
                </h2>
                <img src="{{ asset('website/right.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
            </div>
        </div>

        <!-- Services Layout -->
        <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-start"
            style="max-width: 1290px !important;">
            <!-- Left Featured Card (Fixed height: 450px) -->
            <div class="p-8 flex flex-col justify-between transition-all duration-500 hover:scale-105 h-[455px]"
                style="border: 1px solid rgb(213, 213, 213);border-radius: 13px;">
                <a href="{{ route('darshan.timeline') }}" class="flex flex-col items-center text-center h-full">
                    <img src="{{ asset('website/darshan34.png') }}" alt="Darshan"
                        class="mb-2 transition-transform duration-300 "
                        style="width: 170px; height: 250px; border-radius: 25px;">
                    <h3 class="text-2xl font-bold text-[#db4d30] mb-2">Darshan</h3>
                    <p class="text-gray-700 mb-5 leading-relaxed">Darshan of Shree Jagannatha Mahaprabhu is available
                        almost throughout the day i.e. from early in the morning till late night excepting some festive
                        occasions.
                        Generally, Temple opens and darshan starts at around 5.30 A.M. After offering of the perpetual lamp
                        (Mangal Arati), devotees are allowed entry up to Jagamohan (Bhitara Kaatha) of the temple and
                        darshan from this point is available till completion of “Besha”.
                    </p>
                </a>
            </div>

            <!-- Right Side - 3 Fixed Cards (150px each) -->
            <div class="flex flex-col gap-6 justify-between h-[450px]">
                <!-- Maha Prasad -->
                <a href="{{ route('prasad.timeline') }}"
                    class="bg-white border-l-4 border-[#db4d30]  px-5 py-4 flex items-center gap-5 h-[150px]  hover:translate-x-1 duration-300"
                    style="border: 1px solid rgb(213, 213, 213);border-radius: 13px;">
                    <img src="{{ asset('website/prasad.png') }}" alt="Maha Prasad" style="height: 70px;width:70px">
                    <div>
                        <h3 class="text-lg font-semibold text-[#db4d30]">Mahaprasad</h3>
                        <p class="text-sm text-gray-600">Savor the sacred offering blessed by the divine presence.</p>
                    </div>
                </a>

                <!-- Panji -->
                <a href="{{ route('view.panji.details') }}">
                    <div class="bg-white border-l-4 border-[#db4d30] px-5 py-4 flex items-center gap-5 h-[150px] hover:shadow-lg transition-transform hover:translate-x-1 duration-300"
                        style="border: 1px solid rgb(213, 213, 213);border-radius: 13px;">
                        <img src="{{ asset('website/panji765.png') }}" alt="Panji" class="w-16 h-16">
                        <div>
                            <h3 class="text-lg font-semibold text-[#db4d30]">Panji</h3>
                            <p class="text-sm text-gray-600">
                                Explore traditional records and sacred schedules maintained over centuries.
                            </p>
                        </div>
                    </div>
                </a>

                <!-- Offering -->
                <a href="{{ route('view.festival.details') }}">
                    <div class="bg-white border-l-4 border-[#db4d30]  px-5 py-4 flex items-center gap-5 h-[140px] hover:shadow-lg transition-transform hover:translate-x-1 duration-300"
                        style="border: 1px solid rgb(213, 213, 213);border-radius: 13px;">
                        <img src="{{ asset('website/festival21.png') }}" alt="Offering" class="w-16 h-16 ">
                        <div>
                            <h3 class="text-lg font-semibold text-[#db4d30]">Temple Festival</h3>
                            <p class="text-sm text-gray-600">Make your humble offerings to the Lord with ease and devotion.
                            </p>
                        </div>
                    </div>
                </a>
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
                <div class="arrow-icon" style="font-size: 25px;"><i class="fa-solid fa-arrow-right"
                        style="color: #e9372b;"></i></div>
            </div>
            <div class="card-bottom">
                <div class="card-icons"><img src="{{ asset('website/niwas.png') }}" alt="Maha Prasad"
                        style="height: 40px; width: 40px;"></div>
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
                <div class="arrow-icon" style="font-size: 25px;"><i class="fa-solid fa-arrow-right"
                        style="color: #e9372b;"></i></div>
            </div>
            <div class="card-bottom">
                <div
                    style="margin-right:5%; height: 50px; width: 50px; margin-bottom: 25px; display: flex; align-items: center; justify-content: center;">
                    <span style="color: white; font-size: 40px;"><img src="{{ asset('website/park.png') }}"
                            alt="Maha Prasad" style="height: 40px; width: 40px;"></span>
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
                <div class="arrow-icon" style="font-size: 25px;"><i class="fa-solid fa-arrow-right"
                        style="color: #e9372b;"></i></div>
            </div>
            <div class="card-bottom">
                <div class="card-icons" style="font-size: 40px; color: #6577e6;"><img
                        src="{{ asset('website/lck.png') }}" alt="Maha Prasad" style="height: 40px; width: 40px;"></div>
                <div class="footer-bar bar-blue"></div>
            </div>
        </a>

        <!-- Online Donations -->
        <div class="service-cards">
            <div class="card-top">
                <div class="card-text">
                    <div class="card-title">Online Donations</div>
                    <div class="card-desc" style="font-weight: 500;">Donate Now</div>
                </div>
                <div class="arrow-icon" style="font-size: 25px;"><i class="fa-solid fa-arrow-right"
                        style="color: #e9372b;"></i></div>
            </div>
            <div class="card-bottom">
                <div class="card-icons" style="font-size: 40px; color: #22c5ee;"><img
                        src="{{ asset('website/donation.png') }}" alt="Maha Prasad" style="height: 40px; width: 40px;">
                </div>
                <div class="footer-bar bar-cyan"></div>
            </div>
        </div>

        <!-- Hundi Collection -->
        <div class="service-cards">
            <div class="card-top">
                <div class="card-text">
                    <div class="card-title">Hundi Collection</div>
                    <div class="card-desc">
                        3rd Apr, 2025<br />
                        <span style="color:#e75230; font-weight:600;">₹4,67,973/-</span>
                    </div>
                </div>
                <div class="arrow-icon" style="font-size: 25px;margin-left: 20px"><i class="fa-solid fa-arrow-right"
                        style="color: #e9372b;"></i></div>
            </div>
            <div class="card-bottom">
                <div class="card-icons" style="font-size: 40px; color: #6bbf84;"><img
                        src="{{ asset('website/hundic.png') }}" alt="Maha Prasad" style="height: 40px; width: 40px;">
                </div>
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
                        <div class="swiper-slide rounded-xl overflow-hidden shadow-lg bg-white">
                            <a href="{{ url('view-near-by-temple/' . $temple->id) }}" class="block">
                                <img src="{{ asset($firstPhoto) }}" alt="{{ $temple->name }}"
                                     class="w-full h-48 object-cover hover:scale-105 transition duration-300">
                                <div class="p-3 text-center bg-white">
                                    <h3 class="text-base font-semibold text-[#db4d30]">{{ $temple->name }}</h3>
                                </div>
                            </a>
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
                    <img src="{{ asset('website/wtr.png') }}" alt="Shree Jagannatha Dham">
                </div>
                <p>Water</p>
            </div>

            <div class="conv">
                <div class="convenience-item">
                    <img src="{{ asset('website/ph.png') }}" alt="Shree Jagannatha Dham">
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
                    <img src="{{ asset('website/map.png') }}" alt="Shree Jagannatha Dham">
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
                    <img src="{{ asset('website/lost.png') }}" alt="Shree Jagannatha Dham">
                </div>
                <p>Lost & Found</p>
            </div>

            <div class="conv">
                <div class="convenience-item">
                    <img src="{{ asset('website/latin.png') }}" alt="Shree Jagannatha Dham">
                </div>
                <p>Toilet</p>
            </div>

            <div class="conv">
                <div class="convenience-item">
                    <img src="{{ asset('website/sea.png') }}" alt="Shree Jagannatha Dham">
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


                    <!-- Today Occasion Header -->
                    <div class="flex justify-center items-center gap-5 mt-12">
                        <img src="{{ asset('website/left.png') }}" alt="Shree Jagannatha Dham" class="w-25 h-4">
                        <h2 class="text-md text-[#db4d30] font-bold font-sans tracking-wide uppercase">Today Occasion</h2>
                        <img src="{{ asset('website/right.png') }}" alt="Shree Jagannatha Dham" class="w-25 h-4">
                    </div>

                    <!-- Today Occasion List -->
                    <div class="mt-6 space-y-4 font-[Inter,sans-serif] text-sm md:text-base">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-spa text-green-600 mt-1 w-5 h-5"></i>
                            <p class="text-gray-800">Gruha Devi & Basantika Mrunmayee Devi nka Saptami Puja Arambha</p>
                        </div>

                        <div class="flex items-start gap-3">
                            <i class="fas fa-fire text-red-500 mt-1 w-5 h-5"></i>
                            <p class="text-gray-800">Pithe Astami Puja</p>
                        </div>

                        <div class="flex items-start gap-3">
                            <i class="fas fa-clock text-blue-600 mt-1 w-5 h-5"></i>
                            <p class="text-gray-800">Tithi: 4th Apr Friday, Chaitra, Mina day 22</p>
                        </div>


                        <hr class="border-dashed border-gray-300 my-4">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-sun text-orange-400 w-5 h-5 mt-1"></i>
                                <p class="text-gray-800">Sunrise: <span class="font-medium">05:38 AM</span></p>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fas fa-moon text-indigo-500 w-5 h-5 mt-1"></i>
                                <p class="text-gray-800">Moonrise: <span class="font-medium">10:26 AM</span></p>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fas fa-sun text-red-500 w-5 h-5 mt-1"></i>
                                <p class="text-gray-800">Sunset: <span class="font-medium">06:02 PM</span></p>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fas fa-moon text-blue-600 w-5 h-5 mt-1"></i>
                                <p class="text-gray-800">Moonset: <span class="font-medium">12:30 AM, Apr 05</span></p>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fas fa-calendar-week text-teal-600 w-5 h-5 mt-1"></i>
                                <p class="text-gray-800">Weekday: <span class="font-medium">Shukrawara</span></p>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fas fa-adjust text-yellow-500 w-5 h-5 mt-1"></i>
                                <p class="text-gray-800">Paksha: <span class="font-medium">Shukla Paksha</span></p>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fas fa-star text-purple-600 w-5 h-5 mt-1"></i>
                                <p class="text-gray-800">Tithi: <span class="font-medium">Saptami upto 08:12 PM</span></p>
                            </div>

                            <div class="flex items-start gap-2">
                                <i class="fas fa-smile text-green-600 w-5 h-5 mt-1"></i>
                                <p class="text-gray-800">Yoga: <span class="font-medium">Shobhana upto 09:45 PM</span></p>
                            </div>

                            <div class="flex items-start gap-2">
                                <i class="fas fa-sun-plant-wilt text-yellow-500 w-5 h-5 mt-1"></i>
                                <p class="text-gray-800">Sunsign: <span class="font-medium">Meena</span></p>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fas fa-moon-stars text-indigo-600 w-5 h-5 mt-1"></i>
                                <p class="text-gray-800">Moonsign: <span class="font-medium">Mithuna</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Events Section -->
                <div class="bg-white p-6 rounded-xl border border-gray-300">
                    <div class="flex items-center gap-2 mb-4 md:hidden">
                        <p class="text-xl font-semibold text-[#db4d30] font-sans">
                            Events
                        </p>
                        <img src="{{ asset('website/right.png') }}" alt="Shree Jagannatha Dham" class="w-28 h-5">
                    </div>
                    <div id="events">
                        <img src="{{ asset('website/astami.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-100 p-2 relative bg-gradient-to-br from-orange-50 via-yellow-50 to-pink-100"
        style="margin-top: 50px">
        <div class="max-w-6xl mx-auto text-center relative">
            <!-- Tabs -->
            <div class="absolute top-14 right-0 flex space-x-3 p-3 rounded-lg">
                <button class="tab-buttons active-tabs" onclick="showContent('worldwide', this)">Worldwide</button>
                <button class="tab-buttons" onclick="showContent('india', this)">India</button>
                <button class="tab-buttons" onclick="showContent('odisha', this)">Odisha</button>
            </div>

            <!-- Title -->
            <div class="flex justify-center items-center gap-5 mt-12">
                <img src="{{ asset('website/left.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
                <h2 class="text-2xl text-[#db4d30] flex items-center font-sans">Jagannatha Temples Worldwide</h2>
                <img src="{{ asset('website/right.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
            </div>

            <!-- Image -->
            <div class="dynamic-image mt-10 flex justify-center">
                <img id="dynamicImage" src="{{ asset('website/18.png') }}" alt="Jagannatha Temples Worldwide"
                    class="w-[600px] h-[800px] object-contain rounded-xl shadow-md" />
            </div>

        </div>

        <div class="timeline-footer">
            © {{ date('Y') }} Temple Management System. All rights reserved.
        </div>
    </section>
@endsection
