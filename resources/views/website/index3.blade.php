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

        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('website/logo.png') }}" alt="logo">
        </a>
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
                {{-- <li>
                    <a href="#">SM <span class="live-badges"><i class="fa fa-bolt"></i> Live</span></a>
                </li> --}}
                <li><a href="#services">Services</a></li>
                <li><a href="#temple-slider">Nearby Temples</a></li>
                <li><a href="#convience">Conveniences</a></li>
                <li><a href="#panji">Panji</a></li>
                {{-- <li><a href="#">Temple Information</a></li> --}}
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
                            @php
                                $startTime = optional($niti->todayStartTime)->start_time;
                            @endphp

                            @if ($niti->niti_status === 'Upcoming' || !$startTime)
                                Not Started
                            @else
                                {{ \Carbon\Carbon::parse($startTime)->format('h:i A') }}
                            @endif
                        </p>

                        <p style="color: rgb(139, 137, 137)">
                            <ion-icon name="calendar-outline"
                                style="margin: 6px; color: #ff0011; font-size: 16px;"></ion-icon>
                            {{ \Carbon\Carbon::now()->format('jS M') }}
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

    {{-- <div class="max-w-6xl mx-auto text-center">

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
                
                <div class="tab-item text-center min-w-[100px] cursor-pointer active-tab" data-tab="lordSupreme">
                    <div class="image-wrapper mx-auto w-20 h-20 p-1 rounded-full bg-transparent duration-300">
                        <img src="{{ asset('website/temple_info/sup.png') }}" class="w-full h-full object-cover rounded-full" />
                    </div>
                    <p class="text-gray-500 mt-3">Lord Supreme</p>
                </div>
        
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="throughAges">
                    <div class="image-wrapper mx-auto w-20 h-20 p-1 rounded-full bg-transparent transition-all duration-300">
                        <img src="{{ asset('website/temple_info/age.png') }}" class="w-full h-full object-cover rounded-full" />
                    </div>
                    <p class="text-gray-500 mt-3">Through The Ages</p>
                </div>
        
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="tradition">
                    <div class="image-wrapper mx-auto w-20 h-20 p-1 rounded-full bg-transparent transition-all duration-300">
                        <img src="{{ asset('website/temple_info/tradition.png') }}" class="w-full h-full object-cover rounded-full" />
                    </div>
                    <p class="text-gray-500 mt-3">Living Tradition</p>
                </div>
        
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="festivals">
                    <div class="image-wrapper mx-auto w-20 h-20 p-1 rounded-full bg-transparent transition-all duration-300">
                        <img src="{{ asset('website/temple_info/festival.jpeg') }}" class="w-full h-full object-cover rounded-full" />
                    </div>
                    <p class="text-gray-500 mt-3">Festivals</p>
                </div>
        
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="ratha">
                    <div class="image-wrapper mx-auto w-20 h-20 p-1 rounded-full bg-transparent transition-all duration-300">
                        <img src="{{ asset('website/temple_info/ratha.png') }}" class="w-full h-full object-cover rounded-full" />
                    </div>
                    <p class="text-gray-500 mt-3">Ratha Yatra</p>
                </div>
        
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="services">
                    <div class="image-wrapper mx-auto w-20 h-20 p-1 rounded-full bg-transparent transition-all duration-300">
                        <img src="{{ asset('website/temple_info/devt.png') }}" class="w-full h-full object-cover rounded-full" />
                    </div>
                    <p class="text-gray-500 mt-3">Visitor Services</p>
                </div>
        
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="management">
                    <div class="image-wrapper mx-auto w-20 h-20 p-1 rounded-full bg-transparent transition-all duration-300">
                        <img src="{{ asset('website/temple_info/management.jpg') }}" class="w-full h-full object-cover rounded-full" />
                    </div>
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
                    <img id="contentImage" src="{{ asset('website/temple_info/sup.png') }}" alt="Temple Image"
                        class="rounded-xl shadow-lg object-cover w-full h-full" />
                </div>

                <!-- Text Content -->
                <div style="margin-left: -100px">
                    <h2 id="contentTitle" class="text-xl font-semi-bold"></h2>
                    <p id="contentDescription" class="text-gray-500 mt-4 leading-relaxed"></p>

                    <!-- ✅ New: Button area -->
                    <div id="buttonContainer" class="mt-6 flex flex-wrap gap-3"></div>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="services-section py-10 " id="services">
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
        <a href="{{ route('online.donation') }}" class="service-cards" style="text-decoration: none;">
            <div class="card-top">
                <div class="card-text">
                    <div class="card-title">Online Donations</div>
                    <div class="card-desc" style="font-weight: 500;">Donate Now</div>
                </div>
                <div class="arrow-icon" style="font-size: 25px;">
                    <i class="fa-solid fa-arrow-right" style="color: #e9372b;"></i>
                </div>
            </div>
            <div class="card-bottom">
                <div class="card-icons" style="font-size: 40px; color: #22c5ee;">
                    <img src="{{ asset('website/donation.png') }}" alt="Maha Prasad" style="height: 40px; width: 40px;">
                </div>
                <div class="footer-bar bar-cyan"></div>
            </div>
        </a>

        <!-- Hundi Collection -->
        <a href="{{ route('hundi.collection') }}" class="service-cards" style="text-decoration: none;">
            <div class="card-top">
                <div class="card-text">
                    <div class="card-title">Hundi Collection</div>
                    <div class="card-desc">
                        {{ \Carbon\Carbon::today()->format('jS M, Y') }}<br />
                        <span style="color:#e75230; font-weight:600;">
                            ₹{{ number_format($hundi->rupees ?? 0, 2) }}/-
                        </span>
                    </div>
                </div>
                <div class="arrow-icon" style="font-size: 25px;margin-left: 20px">
                    <i class="fa-solid fa-arrow-right" style="color: #e9372b;"></i>
                </div>
            </div>
            <div class="card-bottom">
                <div class="card-icons" style="font-size: 40px; color: #6bbf84;">
                    <img src="{{ asset('website/hundic.png') }}" alt="Hundi Collection"
                        style="height: 40px; width: 40px;">
                </div>
                <div class="footer-bar bar-green"></div>
            </div>
        </a>

    </section>

    <section class="temple-slider bg-white  bg-gradient-to-br from-orange-50 via-yellow-50 to-pink-100"
        id="temple-slider">
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

    <section class="temple-convenience" id="convience">

        <div class="flex justify-center items-center gap-5">
            <img src="{{ asset('website/left.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
            <h2 class="text-2xl text-[#db4d30] flex items-center font-sans">
                Conveniences
            </h2>
            <img src="{{ asset('website/right.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
        </div>

        <div class="convenience-container">
            <div class="conv">
                <a href="{{ route('services.byType', 'drinking_water') }}">
                    <div class="convenience-item" style="margin-left: 7px">
                        <img src="{{ asset('website/drinkingWater32.png') }}" alt="Water" style="height: 42px">
                    </div>
                    <p>Drinking Water</p>
                </a>
            </div>

            <div class="conv">
                <a href="{{ route('services.emergency') }}">
                    <div class="convenience-item">
                        <img src="{{ asset('website/ph.png') }}" alt="Emergency">
                    </div>
                    <p>Emergency</p>
                </a>
            </div>

            <div class="conv">
                <a href="{{ route('services.abled_person') }}">
                    <div class="convenience-item">
                        <img src="{{ asset('website/physical21.png') }}" alt="Physical">
                    </div>
                    <p>Special Abled Person</p>
                </a>
            </div>

            <div class="conv">
                <a href="{{ route('services.byType', 'ratha_yatra_mela') }}">
                    <div class="convenience-item">
                        <img src="{{ asset('website/map.png') }}" alt="Route Map">
                    </div>
                    <p>Route Map</p>
                </a>
            </div>

            <div class="conv">
                <a href="{{ route('services.byType', 'lost_and_found_booth') }}">
                    <div class="convenience-item">
                        <img src="{{ asset('website/lost.png') }}" alt="Lost and Found">
                    </div>
                    <p>Lost & Found</p>
                </a>
            </div>

            <div class="conv">
                <a href="{{ route('services.byType', 'toilet') }}">
                    <div class="convenience-item">
                        <img src="{{ asset('website/latin.png') }}" alt="Toilet">
                    </div>
                    <p>Toilet</p>
                </a>
            </div>

            <div class="conv">
                <a href="{{ route('services.byType', 'beach') }}">
                    <div class="convenience-item">
                        <img src="{{ asset('website/sea.png') }}" alt="Beach">
                    </div>
                    <p>Beaches</p>
                </a>
            </div>

            <div class="conv">
                <a href="{{ route('services.byType', 'life_guard_booth') }}">
                    <div class="convenience-item">
                        <img src="{{ asset('website/guard.png') }}" alt="Life Guards">
                    </div>
                    <p>Life Guards</p>
                </a>
            </div>
        </div>
    </section>

    <section class="bg-100 p-10  bg-gradient-to-br from-orange-50 via-yellow-50 to-pink-100" id="panji">
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
                    <div class="mt-6 space-y-4 font-[Inter,sans-serif] text-sm md:text-base" id="panjiContent">
                        @if ($todayPanji)
                            <div class="flex items-start gap-3">
                                <i class="fas fa-calendar-day text-green-600 mt-1 w-5 h-5"></i>
                                <p class="text-gray-800">{{ $todayPanji->event_name ?? 'No Event' }}</p>
                            </div>

                            <div class="flex items-start gap-3">
                                <i class="fas fa-star text-purple-600 mt-1 w-5 h-5"></i>
                                <p class="text-gray-800">Tithi: <span
                                        class="font-medium">{{ $todayPanji->tithi ?? '-' }}</span></p>
                            </div>

                            <div class="flex items-start gap-3">
                                <i class="fas fa-smile text-yellow-500 mt-1 w-5 h-5"></i>
                                <p class="text-gray-800">Yoga: <span
                                        class="font-medium">{{ $todayPanji->yoga ?? '-' }}</span></p>
                            </div>

                            <div class="flex items-start gap-3">
                                <i class="fas fa-adjust text-blue-600 mt-1 w-5 h-5"></i>
                                <p class="text-gray-800">Paksha: <span
                                        class="font-medium">{{ $todayPanji->pakshya ?? '-' }}</span></p>
                            </div>

                            <div class="flex items-start gap-3">
                                <i class="fas fa-clock text-red-400 mt-1 w-5 h-5"></i>
                                <p class="text-gray-800">Sunrise: <span
                                        class="font-medium">{{ $todayPanji->sun_rise ?? '-' }}</span></p>
                            </div>

                            <div class="flex items-start gap-3">
                                <i class="fas fa-moon text-indigo-600 mt-1 w-5 h-5"></i>
                                <p class="text-gray-800">Sunset: <span
                                        class="font-medium">{{ $todayPanji->sun_set ?? '-' }}</span></p>
                            </div>

                            @if ($todayPanji->description)
                                <hr class="border-dashed border-gray-300 my-4">
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-info-circle text-gray-600 mt-1 w-5 h-5"></i>
                                    <p class="text-gray-800">{{ $todayPanji->description }}</p>
                                </div>
                            @endif
                        @else
                            <p class="text-center text-gray-500">No Panji Details Available for Today.</p>
                        @endif
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

    {{-- <section class="bg-100 p-2 relative bg-gradient-to-br from-orange-50 via-yellow-50 to-pink-100">
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

        </div> --}}

    {{-- <div class="timeline-footer">
            © {{ date('Y') }} Temple Management System. All rights reserved. <a style="color: red"
                href="http://temple.mandirparikrama.com/puri-website/privacy-policy">privacy policy</a>
        </div> --}}
    {{-- </section> --}}

    @include('partials.website-footer')

@endsection
