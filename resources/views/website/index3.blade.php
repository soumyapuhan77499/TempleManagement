@extends('website.web-layouts')

@section('content')
    <section class="banner-sections">
        <!-- Video Banner -->
        <div class="banner-video">
            <video id="bannerVideo" autoplay loop playsinline muted preload="metadata" poster="{{ asset('website/d.png') }}">
                <source src="{{ asset('website/1.mkv') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
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

        <!-- Play/Pause Button (Centered) -->
        <button id="playPauseButton" class="play-pause-button"><i class="fa fa-pause"></i></button>
        <!-- Mute/Unmute Button (Bottom Center) -->
        <button id="muteToggle" class="mute-toggle"><i style="height:18px;width: 18px"
                class="fa fa-volume-mute"></i></button>
    </section>

    <div class="niti-cards-scroll">
        <div class="niti-cards">
            <div class="niti-card active">
                <div class="niti-content">
                    <h3 style="font-size: 22px;padding-bottom:5px">Dwara Phita</h3>
                    <p style="padding-top: 5px"><strong>Mangala Alati</strong></p>
                </div>
                <div class="niti-icons">
                    <p style="color: rgb(139, 137, 137)"><ion-icon name="time-outline"
                            style=" margin: 6px;color: #ff0011;font-size: 16px;"></ion-icon> 05:00
                        AM
                    </p>
                    <p style="color: rgb(139, 137, 137)"><ion-icon name="calendar-outline"
                            style=" margin: 6px;color: #ff0011;font-size: 16px;"></ion-icon>
                        20th
                        Mar</p>
                </div>
            </div>
            <div class="niti-card ">
                <div class="niti-content">
                    <h3 style="font-size: 22px;padding-bottom:5px">Mailama</h3>
                    <p style="padding-top: 5px"><strong>Abakasha</strong></p>
                </div>
                <div class="niti-icons">
                    <p style="color: rgb(139, 137, 137)"><ion-icon name="time-outline"
                            style=" margin: 6px;font-size: 16px;"></ion-icon> 06:00 AM</p>
                    <p style="color: rgb(139, 137, 137)"><ion-icon name="calendar-outline"
                            style=" margin: 6px;font-size: 16px;"></ion-icon>20th Mar</p>
                </div>

            </div>
            <div class="niti-card ">
                <div class="niti-content">
                    <h3 style="font-size: 22px;padding-bottom:5px">View All Niti</h3>
                </div>

            </div>
        </div>
    </div>

    <section class="shree-mandir-section mt-12 w-full">
        <div class="flex justify-center items-center gap-5 mt-12">
            <img src="{{ asset('website/left.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
            <h2 class="text-2xl text-[#db4d30] flex items-center font-sans">
                Shree Mandir
                <span
                    class="ml-2 text-sm font-bold text-white px-3 py-1 rounded-md flex items-center bg-gradient-to-r from-[#ff4e00] to-[#ff9800] shadow-md">
                    <i class="fa fa-bolt mr-1"></i>Live
                </span>
            </h2>
            <img src="{{ asset('website/right.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-12 px-4">
            <!-- TV Section -->
            <div class="flex flex-col md:flex-row bg-white rounded-lg border border-gray-300 max-w-full overflow-hidden">
                <div class="flex-1 px-6 py-4">
                    <div class="flex items-center gap-3 mb-6">
                        <img src="{{ asset('website/tv.png') }}" class="h-16 w-16" alt="TV">
                        <h3 class="text-[#db4d30] text-lg font-semibold">TV</h3>
                    </div>
                    <p class="text-gray-600 text-base mb-2">Watch all the live broadcasts from Shree Mandira</p>
                    <p class="text-sm mt-2">🕒 03:17 pm</p>
                    <p class="text-sm mt-2">📅 4th Mar</p>
                </div>
                <div class="bg-gray-100 p-4">
                    <img src="{{ asset('website/60.png') }}" class="h-64 w-full md:w-[400px] rounded-lg object-cover"
                        alt="TV Stream">
                </div>
            </div>

            <!-- Radio Section -->
            <div class="flex flex-col md:flex-row bg-white rounded-lg border border-gray-300 max-w-full overflow-hidden">
                <div class="flex-1 px-6 py-4">
                    <div class="flex items-center gap-3 mb-6">
                        <img src="{{ asset('website/radio.png') }}" class="h-16 w-16" alt="Radio">
                        <h3 class="text-[#db4d30] text-lg font-semibold">Radio</h3>
                    </div>
                    <p class="text-gray-600 text-base mb-2">Listen all the live broadcasts from Shree Mandira</p>
                    <p class="text-sm mt-2">🕒 03:17 pm</p>
                    <p class="text-sm mt-2">📅 4th Mar</p>
                </div>
                <div class="bg-gray-100 p-4 w-full md:w-[400px]">
                    <div class="bg-[#1e1e2d] text-white py-4 px-6 rounded-t-lg text-center font-semibold relative">
                        <span class="absolute top-2 left-1/2 -translate-x-1/2 w-8 h-1.5 bg-gray-400 rounded-full"></span>
                        Jay Jagannath
                    </div>

                    <div
                        class="flex justify-around items-center text-sm text-gray-800 py-3 border border-gray-300 bg-white">
                        <span class="flex flex-col items-center">
                            <i class="fa fa-compass"></i>
                            <p class="text-xs">Explore</p>
                        </span>
                        <span class="flex flex-col items-center">
                            <i class="fa fa-heart"></i>
                            <p class="text-xs">Favorites</p>
                        </span>
                        <span class="flex flex-col items-center text-green-600 font-bold">
                            <i class="fa fa-map"></i>
                            <p class="text-xs">Browse</p>
                        </span>
                        <span class="flex flex-col items-center">
                            <i class="fa fa-search"></i>
                            <p class="text-xs">Search</p>
                        </span>
                        <span class="flex flex-col items-center">
                            <i class="fa fa-bars"></i>
                            <p class="text-xs">Settings</p>
                        </span>
                    </div>

                    <div class="bg-white border border-gray-300 rounded-lg p-4 mt-4">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="text-[#db4d30] text-base font-bold">Bhajans Name</h4>
                            <div class="flex items-center gap-2 text-gray-500">
                                <i class="fas fa-heart cursor-pointer"></i>
                                <i class="fas fa-ellipsis-h cursor-pointer"></i>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('website/12.png') }}" class="w-5 h-5 cursor-pointer" alt="Prev">
                                <img src="{{ asset('website/11.png') }}" class="w-5 h-5 cursor-pointer" alt="Play">
                                <img src="{{ asset('website/10.png') }}" class="w-5 h-5 cursor-pointer" alt="Next">
                            </div>
                            <input type="range" min="0" max="100"
                                class=" ml-4 accent-[#db4d30] h-1 rounded">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="services-section">

        <div class="flex justify-center items-center gap-5 mt-12">
            <img src="{{ asset('website/left.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
            <h2 class="text-2xl text-[#db4d30] flex items-center font-sans">
                Quick Services

            </h2>
            <img src="{{ asset('website/right.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
        </div>

        <div class="services-container" style="margin-top: 50px">
            <!-- Accommodation -->
            <div class="service-card accommodation-card">
                <div class="icon-container">
                    <img src="{{ asset('website/1000.png') }}" alt="Shree Jagannatha Dham">
                </div>
                <div class="service-content">
                    <h3 style="color: #db4d30">Darshan</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua.</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
            </div>

            <!-- Donations -->
            <div class="service-card donations-card">
                <div class="icon-container">
                    <img src="{{ asset('website/1001.png') }}" alt="Shree Jagannatha Dham">
                </div>
                <div class="service-content">
                    <h3 style="color: #db4d30">Maha Prasad</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua.</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
            </div>

            <!-- Darshan Booking -->
            <div class="service-card darshan-card">
                <div class="icon-container">
                    <img src="{{ asset('website/1002.png') }}" alt="Shree Jagannatha Dham">
                </div>
                <div class="service-content">
                    <h3 style="color: #db4d30">Panji</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua.</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
            </div>

            <!-- Gifts & Offerings -->
            <div class="service-card gifts-card">
                <div class="icon-container">
                    <img src="{{ asset('website/1003.png') }}" alt="Shree Jagannatha Dham">
                </div>
                <div class="service-content">
                    <h3 style="color: #db4d30">Offering</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua.</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
            </div>
        </div>

    </section>

    <section class="services-sections">
        <!-- Bhakta Nibas -->
        <div class="service-cards">
            <div class="card-top">
                <div class="card-text">
                    <div class="card-title">Bhakta Nibas</div>
                    <div class="card-desc">Temple owned <br>properties for<br>pilgrim stay</div>
                </div>
                <i data-lucide="arrow-right" class="arrow-icon"></i>
            </div>
            <div class="card-bottom">
                <i data-lucide="building" class="card-icons" style="color:#c27462;"></i>
                <div class="footer-bar bar-orange"></div>
            </div>
        </div>

        <!-- Parking Areas -->
        <div class="service-cards">
            <div class="card-top">
                <div class="card-text">
                    <div class="card-title">Parking Areas</div>
                    <div class="card-desc">2, 3, 4 Wheelers</div>
                </div>
                <i data-lucide="arrow-right" class="arrow-icon"></i>
            </div>
            <div class="card-bottom">
                <div
                    style="margin-right:5%; height: 50px;width: 50px;margin-bottom: 25px;display: flex;align-items: center;justify-content: center; padding: 5px; border-radius: 50%; background-color: #e75230;">
                    <span style="color: white;font-size: 35px;font-weight: bold; ">P</span>
                </div>

                <div class="footer-bar bar-red"></div>
            </div>
        </div>

        <!-- Locker & Shoes -->
        <div class="service-cards">
            <div class="card-top">
                <div class="card-text">
                    <div class="card-title">Locker & Shoes Stands</div>
                    <div class="card-desc">Shoes, Mobile <br>Phones etc</div>
                </div>
                <i data-lucide="arrow-right" class="arrow-icon"></i>
            </div>
            <div class="card-bottom">
                <i data-lucide="server" class="card-icons" style="color:#6577e6;"></i>
                <div class="footer-bar bar-blue"></div>
            </div>
        </div>

        <!-- Online Donations -->
        <div class="service-cards">
            <div class="card-top">
                <div class="card-text">
                    <div class="card-title">Online Donations</div>
                    <div class="card-desc" style="color:#22c5ee; font-weight: 500;">Donate Now</div>
                </div>
                <i data-lucide="arrow-right" class="arrow-icon"></i>
            </div>
            <div class="card-bottom">
                <i data-lucide="wallet" class="card-icons" style="color:#22c5ee;"></i>
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
                <i data-lucide="arrow-right" class="arrow-icon"></i>
            </div>
            <div class="card-bottom">
                <i data-lucide="layers" class="card-icons" style="color:#6bbf84;"></i>
                <div class="footer-bar bar-green"></div>
            </div>
        </div>
    </section>

    <section class="temple-slider">


        <div class="flex justify-center items-center gap-5 mt-12">
            <img src="{{ asset('website/left.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
            <h2 class="text-2xl text-[#db4d30] flex items-center font-sans">
                Nearby Temples
            </h2>
            <img src="{{ asset('website/right.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
        </div>

        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="{{ asset('website/11.jpg') }}" alt="Temple"></div>
                <div class="swiper-slide"><img src="{{ asset('website/11.jpg') }}" alt="Temple"></div>
                <div class="swiper-slide"><img src="{{ asset('website/11.jpg') }}" alt="Temple"></div>
                <div class="swiper-slide"><img src="{{ asset('website/11.jpg') }}" alt="Temple"></div>
                <div class="swiper-slide"><img src="{{ asset('website/11.jpg') }}" alt="Temple"></div>
                <div class="swiper-slide"><img src="{{ asset('website/11.jpg') }}" alt="Temple"></div>

            </div>

            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </section>

    <section class="temple-convenience">

        <div class="flex justify-center items-center gap-5 mt-12">
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
                <p>Drinking Water</p>
            </div>

            <div class="conv">
                <div class="convenience-item">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <p>Emergency Contacts</p>
            </div>

            <div class="conv">
                <div class="convenience-item">
                    <i class="fas fa-wheelchair"></i>
                </div>
                <p>Handicap &<br>Senior Citizens</p>
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

    <section class="bg-100 p-10">
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

    <div class="max-w-6xl mx-auto text-center px-4">
        <!-- Header -->
        <div class="flex flex-wrap justify-center items-center gap-3 mt-10">
            <img src="{{ asset('website/left.png') }}" alt="Shree Jagannatha Dham" class="w-28 sm:w-36 h-5">
            <h2 class="text-xl sm:text-2xl text-[#db4d30] font-sans font-semibold">Temple Information</h2>
            <img src="{{ asset('website/right.png') }}" alt="Shree Jagannatha Dham" class="w-28 sm:w-36 h-5">
        </div>
    
        <!-- Navigation Tabs -->
        <div class="flex justify-center items-center mt-6 mb-10 px-2">
            <div id="navContainer" class="flex gap-5 overflow-x-auto no-scrollbar w-full max-w-full">
                <!-- Tab Items -->
                <div class="tab-item text-center min-w-[100px] cursor-pointer active-tab" data-tab="aboutTemple">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-red-600 font-semibold text-sm mt-2">About Temple</p>
                    <div class="h-1 bg-red-500 w-full mt-1"></div>
                </div>
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="shreeKhetra">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500 text-sm mt-2">Shree Khetra</p>
                </div>
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="mathaAshram">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500 text-sm mt-2">Matha & Ashram</p>
                </div>
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="festivals">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500 text-sm mt-2">Festivals</p>
                </div>
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="nijoga">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500 text-sm mt-2">36 Nijoga</p>
                </div>
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="besha">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500 text-sm mt-2">Besha</p>
                </div>
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="darshan">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500 text-sm mt-2">Darshan Facility</p>
                </div>
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="prasad">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500 text-sm mt-2">Maha Prasad</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Content Section -->
    <section id="dynamicContent" class="bg-100 px-4 pb-10">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <!-- Image -->
                <div id="contentImageContainer" class="w-full h-auto mt-6 flex justify-center">
                    <img id="contentImage" src="website/12.jpg" alt="Temple Image" class="rounded-xl shadow-lg w-full max-w-md">
                </div>
    
                <!-- Text Content -->
                <div class="mt-6 md:mt-0 md:ml-0">
                    <h2 id="contentTitle" class="text-xl sm:text-2xl font-bold text-[#db4d30]">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit
                    </h2>
                    <h3 id="contentSubtitle" class="text-lg text-gray-600 mt-2">
                        Lorem ipsum dolor sit amet
                    </h3>
                    <p id="contentDescription" class="text-gray-500 mt-4 leading-relaxed text-sm sm:text-base">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                        aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur.
                    </p>
                    <button class="mt-6 px-6 py-2 bg-red-100 text-red-600 rounded-lg shadow-md hover:bg-red-200 transition">
                        Read More
                    </button>
                </div>
            </div>
        </div>
    </section>
    
    <section class="bg-100 p-6 sm:p-10 relative">
        <div class="max-w-6xl mx-auto text-center relative">
            
            <!-- Section Header -->
            <div class="flex justify-center items-center flex-wrap gap-3 mt-6">
                <img src="{{ asset('website/left.png') }}" alt="Shree Jagannatha Dham" class="w-24 sm:w-36 h-5">
                <h2 class="text-xl sm:text-2xl text-[#db4d30] font-semibold font-sans">
                    Jagannatha Temples Worldwide
                </h2>
                <img src="{{ asset('website/right.png') }}" alt="Shree Jagannatha Dham" class="w-24 sm:w-36 h-5">
            </div>
    
            <!-- Tabs Container -->
            <div class="flex justify-center sm:absolute sm:top-28 sm:right-0 mt-6 sm:mt-0 px-2 space-x-2 sm:space-x-3">
                <button class="tab-buttons active-tabs" onclick="showContent('worldwide', this)">
                    Worldwide
                </button>
                <button class="tab-buttons" onclick="showContent('india', this)">
                    India
                </button>
                <button class="tab-buttons" onclick="showContent('odisha', this)">
                    Odisha
                </button>
            </div>
    
            <!-- Banner Image -->
            <div class="dynamic-image mt-8 sm:mt-16">
                <img id="dynamicImage" src="{{ asset('website/18.png') }}" alt="Shree Jagannatha Dham"
                    class="mx-auto w-full max-w-xl rounded-lg shadow-md">
            </div>
        </div>
    </section>
    
@endsection
