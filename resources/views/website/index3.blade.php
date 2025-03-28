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
                    <div class="card-icon">
                        <img src="{{ asset('website/tv.png') }}" style="height: 60px;width: 65px"
                            alt="Shree Jagannatha Dham">
                        <h3 style="color: #db4d30">TV</h3>
                    </div>
                    <p class="para">Watch all the live broadcasts from Shree Mandira</p>
                    <p style="margin-top: 10px">🕒 03:17 pm</p>
                    <p style="margin-top: 10px">📅 4th Mar</p>
                </div>
                <div class="video-container">
                    <img src="{{ asset('website/60.png') }}" style="height: 250px;width: 400px;border-radius: 10px"
                        alt="Shree Jagannatha Dham">
                </div>
            </div>

            <!-- Radio Section -->
            <div class="radio-card">
                <div class="card-content">
                    <div class="card-icon">
                        <img src="{{ asset('website/radio.png') }}" style="height: 60px;width: 65px"
                            alt="Shree Jagannatha Dham">
                        <h3 style="color: #db4d30">Radio</h3>
                    </div>
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

    <div class="max-w-6xl mx-auto text-center">

        <div class="flex justify-center items-center gap-5 mt-12">
            <img src="{{ asset('website/left.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
            <h2 class="text-2xl text-[#db4d30] flex items-center font-sans">
                Temple Information
            </h2>
            <img src="{{ asset('website/right.png') }}" alt="Shree Jagannatha Dham" class="w-36 h-5">
        </div>

        <!-- Navigation Tabs -->
        <div class="flex justify-center items-center gap-6" style="margin-bottom: 50px;margin-top: 20px">
            <div id="navContainer" class="flex gap-10 overflow-x-auto no-scrollbar">
                <!-- Tab Items -->
                <div class="tab-item text-center min-w-[100px] cursor-pointer active-tab" data-tab="aboutTemple">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-red-600 font-semibold mt-3">About Temple</p>
                    <div class="h-1 bg-red-500 w-full mt-1"></div>
                </div>
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="shreeKhetra">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500 mt-3">Shree Khetra</p>
                </div>
                <div class="tab-item text-center min-w-[100px] cursor-pointer inactive-tab" data-tab="mathaAshram">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500 mt-3">Matha & Ashram</p>
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
                <div id="contentImageContainer" style="height: 350px;width: 450px;margin-top: 50px">
                    <img id="contentImage" src="website/12.jpg" alt="Temple Image" class="rounded-xl shadow-lg">
                </div>
                <div style="margin-left: -100px">
                    <h2 id="contentTitle" class="text-2xl font-bold" style="color: #db4d30;">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit
                    </h2>
                    <h3 id="contentSubtitle" class="text-xl text-gray-600 mt-2">
                        Lorem ipsum dolor sit amet
                    </h3>
                    <p id="contentDescription" class="text-gray-500 mt-4 leading-relaxed">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                        aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur.
                    </p>
                    <button
                        class="mt-6 px-6 py-2 bg-red-100 text-red-600 rounded-lg shadow-md hover:bg-red-200 transition">
                        Read More
                    </button>
                </div>
            </div>
        </div>
    </section>
    
    <section class="bg-100 p-10 relative">
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
