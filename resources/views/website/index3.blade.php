@extends('website.web-layouts')

@section('content')
<section class="banner-sections">
    <!-- Video Banner -->
    <div class="banner-video">
      <video id="bannerVideo" autoplay loop playsinline muted preload="metadata" poster="{{ asset('website/d.png') }}">
        <source src="{{ asset('website/480.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
    <!-- Logo (Top Left) -->
    <div class="logo">
      <img src="{{ asset('website/logo.png') }}" alt="logo">
    </div>
    <!-- Hamburger Icon (Top Right) -->
    <div class="hamburger-icon">
      <div class="hamburger-menu">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <!-- Navigation Menu (Hidden by default) -->
    <nav class="nav-menu">
      <!-- Close Icon -->
      <div class="nav-close"><i class="fa fa-times"></i></div>
      <ul>
        <li><a href="#">Nitis</a></li>
        <li>
          <a href="#">SM 
            <span class="live-badges"><i class="fa fa-bolt"></i> Live</span>
          </a>
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
    <button id="muteToggle" class="mute-toggle"><i class="fa fa-volume-mute"></i></button>
  </section>

    <div class="niti-cards">
        <div class="niti-card active">
            <div class="niti-content">
                <h3 style="font-size: 22px;padding-bottom:5px">Dwara Phita</h3>
                <p style="padding-top: 5px"><strong>Mangala Alati</strong></p>
            </div>
            <div class="niti-icons">
                <p><ion-icon name="time-outline" style=" margin: 6px;color: #ff0011;font-size: 16px;"></ion-icon> 05:00 AM</p>
                <p><ion-icon name="calendar-outline" style=" margin: 6px;color: #ff0011;font-size: 16px;"></ion-icon> 20th Mar</p>
            </div>
        </div>
        <div class="niti-card ">
            <div class="niti-content">
                <h3 style="font-size: 22px;padding-bottom:5px">Mailama</h3>
                <p style="padding-top: 5px"><strong>Abakasha</strong></p>
            </div>
            <div class="niti-icons">
                <p><ion-icon name="time-outline" style=" margin: 6px;font-size: 16px;"></ion-icon> 06:00 AM</p>
                <p><ion-icon name="calendar-outline" style=" margin: 6px;font-size: 16px;"></ion-icon>20th Mar</p>
            </div>

        </div>
        <div class="niti-card ">
            <div class="niti-content">
                <h3 style="font-size: 22px;padding-bottom:5px">Sahana Mala</h3>
                <p style="padding-top: 5px"><strong>Sarba Sadharana Darshan</strong></p>
            </div>
            <div class="niti-icons">
                <p><ion-icon name="time-outline" style=" margin: 6px;font-size: 16px;"></ion-icon> 07:00 AM</p>
                <p><ion-icon name="calendar-outline" style=" margin: 6px;font-size: 16px;"></ion-icon> 20th Mar</p>
            </div>

        </div>
    </div>

    <section class="shree-mandir-section">
        <h2 class="section-titles">Shree Mandir <span class="live-badge"><i class="fa fa-bolt" style="margin-right: 6px"></i>Live</span></h2>
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
                    <div class="radio-header">Browse</div>
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
        <div class="section-container">
            <h2 class="section-quick" style="color: #db4d30">Quick Services</h2>
            <div class="image-container">
                <img src="{{ asset('website/v1.png') }}" alt="Shree Jagannatha Dham">
            </div>
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

        <div class="menu-container">
            <div class="arrow left">
                <img src="{{ asset('website/v3.png') }}" alt="Shree Jagannatha Dham" style="height: 50px;width: 50px">
            </div>
            <div class="menu-items">
                <div class="service-icon">
                    <div class="menu-item active">
                        <img src="{{ asset('website/bhakta.png') }}" alt="Shree Jagannatha Dham" style="height: 50px;width: 50px">
                    </div>
                    <p style="margin-top: 10px;font-weight: bold; color: #db4d30;">Bhakta Nibas</p>
                </div>

                <div class="service-icon">
                    <div class="menu-item">
                        <img src="{{ asset('website/online.png') }}" alt="Shree Jagannatha Dham" style="height: 50px;width: 50px">
                    </div>
                    <p style="margin-top: 10px;font-weight: bold; color: #db4d30;">Online Donation</p>
                </div>

                <div class="service-icon">
                    <div class="menu-item">
                        <img src="{{ asset('website/parking.png') }}" alt="Shree Jagannatha Dham" style="height: 50px;width: 50px">
                    </div>
                    <p style="margin-top: 10px;font-weight: bold; color: #db4d30;">Parking</p>

                </div>

                <div class="service-icon">
                    <div class="menu-item">
                        <img src="{{ asset('website/locker.png') }}" alt="Shree Jagannatha Dham" style="height: 50px;width: 50px">
                    </div>
                    <p style="margin-top: 10px;font-weight: bold; color: #db4d30;">Locker & Shoes</p>
                </div>

                <div class="service-icon">
                    <div class="menu-item">
                        <img src="{{ asset('website/hundi.png') }}" alt="Shree Jagannatha Dham" style="height: 50px;width: 50px">
                    </div>
                    <p style="margin-top: 10px;font-weight: bold; color: #db4d30;">Hundi Collection</p>
                </div>

            </div>
            <div class="arrow right">
                <img src="{{ asset('website/v2.png') }}" alt="Shree Jagannatha Dham" style="height: 50px;width: 50px">
            </div>
        </div>

    </section>

    <section class="temple-slider">
        <h2 class="slider-title">Nearby Temples</h2>
        <div class="image-container">
            <img src="{{ asset('website/v1.png') }}" alt="Shree Jagannatha Dham">
        </div>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
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
        <h2 class="convenience-title">Conveniences</h2>
        <div class="image-container">
            <img src="{{ asset('website/v1.png') }}" alt="Shree Jagannatha Dham">
        </div>
        <div class="convenience-container">
            <div class="conv ">
                <div class="convenience-item active">
                    <i class="fas fa-tint"></i>
                </div>
                <p>Drinking Water</p>
            </div>
            <div class="conv">
                <div class="convenience-item">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <p> Contacts</p>
            </div>

            <div class="conv">
                <div class="convenience-item">
                    <i class="fas fa-wheelchair"></i>
                </div>
                <p> Handicap </p>
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

            </div>
    </section>

    <section class="bg-100 p-10">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="flex justify-between">
                <div class="image-panji">
                    <p class="text-2xl font-bold;" style="color: #db4d30;font-family: Arial, sans-serif;font-size: 24px;">
                        Panji Calendar</p>

                    <img src="{{ asset('website/v4.png') }}" alt="Shree Jagannatha Dham">
                </div>
                <div class="image-event">
                    <p style="color: #db4d30;font-family: Arial, sans-serif;font-size: 24px;">Events</p>
                    <img src="{{ asset('website/v4.png') }}" alt="Shree Jagannatha Dham">
                </div>
                <h2 class="text-2xl font-bold text-red-600"></h2>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-5">
                <!-- Calendar Section -->
                <div class="bg-white p-6 rounded-xl border border-yellow-300">
                    <h3 class="text-md font-semibold text-red-500">Select date</h3>
                    <div id="calendar"></div>
                </div>

                <!-- Events Section -->
                <div class="bg-white p-6 rounded-xl border border-300">
                    <div id="events" class="grid grid-cols-3 gap-4 mt-4">
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
        <!-- Section Title -->
        <h2 class="about-title" style="margin-top:50px">Temple Information</h2>
        <div class="image-container">
            <img src="{{ asset('website/v1.png') }}" alt="Shree Jagannatha Dham">
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
    
    <!-- Dynamic Content Section -->
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
                    <button class="mt-6 px-6 py-2 bg-red-100 text-red-600 rounded-lg shadow-md hover:bg-red-200 transition">
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

            <!-- Section Title -->
            <h2 class="map-title mt-12">Jagannatha Temples Worldwide</h2>

            <!-- Image Container -->
            <div class="image-container">
                <img src="{{ asset('website/v1.png') }}" alt="Shree Jagannatha Dham" class="mx-auto">
            </div>

            <!-- Banner Image -->
            <div class="dynamic-image mt-10">
                <img id="dynamicImage"  src="{{ asset('website/18.png') }}" alt="Shree Jagannatha Dham" class="mx-auto">
            </div>
        </div>
    </section>

@endsection
