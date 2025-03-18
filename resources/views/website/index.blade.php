@extends('website.web-layout')

@section('content')
    @includeIf('partials.web-header')

    <section class="banner-section">
        <div class="banner-image">
            <img src="{{ asset('website/banner.png') }}" alt="Shree Jagannatha Dham">
        </div>

    </section>
    <!-- Niti Cards Section -->
    <div class="niti-cards">
        <div class="niti-card active">
            <div class="niti-content">
                <h3 style="font-size: 22px;padding-bottom:5px">Panchami</h3>
                <p style="padding-top: 5px"><strong>Shukla Paksha</strong></p>
            </div>
            <div class="niti-icons">
                <p><i class="fa fa-clock"></i> 03:17 pm</p>
                <p><i class="fa fa-calendar"></i> 4th Mar</p>
            </div>
        </div>
        <div class="niti-card active">
            <div class="niti-content">
                <h3 style="font-size: 22px;padding-bottom:5px">Niti Name</h3>
                <p style="padding-top: 5px"><strong>Shukla Paksha</strong></p>
            </div>
            <div class="niti-icons">
                <p><i class="fa fa-clock"></i> 03:17 pm</p>
                <p><i class="fa fa-calendar"></i> 4th Mar</p>
            </div>

        </div>
        <div class="niti-card active">
            <div class="niti-content">
                <h3 style="font-size: 22px;padding-bottom:5px">Niti Name</h3>
                <p style="padding-top: 5px"><strong>Shukla Paksha</strong></p>
            </div>
            <div class="niti-icons">
                <p><i class="fa fa-clock"></i> 03:17 pm</p>
                <p><i class="fa fa-calendar"></i> 4th Mar</p>
            </div>

        </div>
    </div>

    <section class="shree-mandir-section">
        <h2 class="section-titles">Shree Mandir <span class="live-badge">⚡ Live</span></h2>
        <div class="mandir-content">
            <!-- TV Section -->

            <div class="mandir-card">
                <div class="card-content">
                    <div class="card-icon">
                        <img src="{{ asset('website/tv.png') }}" style="height: 60px;width: 70px" alt="Shree Jagannatha Dham">
                        <h3 style="color: #db4d30">TV</h3>
                    </div>
                    <p class="para" >Listen or Watch all the live broadcasts from Shree Mandira</p>
                    <p style="margin-top: 10px">🕒 03:17 pm</p>
                    <p style="margin-top: 10px">📅 4th Mar</p>
                </div>
                <div class="video-container">
                    <iframe width="700" height="315"
                        src="https://www.youtube.com/embed/TK8TkDG056I?si=9j455nUMHMNwmDti" title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                    </iframe>
                </div>
            </div>

            <!-- Radio Section -->
            <div class="radio-card">
                <div class="card-content">
                    <div class="card-icon">
                        <img src="{{ asset('website/radio.png') }}" style="height: 60px;width: 70px" alt="Shree Jagannatha Dham">
                        <h3 style="color: #db4d30">Radio</h3>
                    </div>
                    <p class="para">Listen or Watch all the live broadcasts from Shree Mandira</p>
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
                            <h4 >Bhajans Name</h4>
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
            <h2 class="section-quick">Quick Services</h2>
            <div class="image-container">
                <img src="{{ asset('website/v1.png') }}" alt="Shree Jagannatha Dham">
            </div>
        </div>
        <div class="services-container" style="margin-top: 50px">
            <!-- Accommodation -->
            <div class="service-card accommodation-card">
                <div class="icon-container">
                    <i class="fa fa-bed"></i>
                </div>
                <div class="service-content">
                    <h3>Accommodation</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua.</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
            </div>

            <!-- Donations -->
            <div class="service-card donations-card">
                <div class="icon-container">
                    <i class="fa fa-hand-holding-heart"></i>
                </div>
                <div class="service-content">
                    <h3>Donations</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua.</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
            </div>

            <!-- Darshan Booking -->
            <div class="service-card darshan-card">
                <div class="icon-container">
                    <i class="fa fa-calendar-alt"></i>
                </div>
                <div class="service-content">
                    <h3>Darshan Booking</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua.</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
            </div>

            <!-- Gifts & Offerings -->
            <div class="service-card gifts-card">
                <div class="icon-container">
                    <i class="fa fa-gift"></i>
                </div>
                <div class="service-content">
                    <h3>Donations</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua.</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
            </div>
        </div>

        <div class="menu-container">
            <div class="arrow left">
                <img src="{{ asset('website/v3.png') }}" alt="Shree Jagannatha Dham">
            </div>
            <div class="menu-items">
                <div class="para">
                    <div class="menu-item active">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <p style="margin-top: 10px;font-weight: bold; color: #555;">Bhakta Nibas</p>
                </div>

                <div class="para">
                    <div class="menu-item">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <p style="margin-top: 10px;font-weight: bold; color: #555;">Online Donation</p>
                </div>

                <div class="para">
                    <div class="menu-item">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <p style="margin-top: 10px;font-weight: bold; color: #555;">Hundi Collection</p>

                </div>

                <div class="para">
                    <div class="menu-item">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <p style="margin-top: 10px;font-weight: bold; color: #555;">Online Donation</p>
                </div>

                <div class="para">
                    <div class="menu-item">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <p style="margin-top: 10px;font-weight: bold; color: #555;">Hundi Collection</p>
                </div>

            </div>
            <div class="arrow right">
                <img src="{{ asset('website/v2.png') }}" alt="Shree Jagannatha Dham">
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
            <div class="convenience-item">
                <i class="fas fa-tint"></i>
                <p> Water</p>
            </div>
            <div class="convenience-item">
                <i class="fas fa-phone-alt"></i>
                <p> Contacts</p>
            </div>
            <div class="convenience-item">
                <i class="fas fa-wheelchair"></i>
                <p> Handicap </p>
            </div>
            <div class="convenience-item">
                <i class="fas fa-map-marked-alt"></i>
                <p>Route Map</p>
            </div>
            <div class="convenience-item">
                <i class="fas fa-utensils"></i>
                <p>Free Food</p>
            </div>
            <div class="convenience-item">
                <i class="fas fa-search"></i>
                <p>Lost & Found</p>
            </div>
            <div class="convenience-item">
                <i class="fas fa-toilet"></i>
                <p>Toilet</p>
            </div>
        </div>
    </section>


    <section class="bg-gray-100 p-10">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="flex justify-between">
                <div class="image-panji">
                    <h2 class="text-2xl font-bold" style="color: #7B54E3;">Panji Calendar</h2>

                    <img src="{{ asset('website/v4.png') }}" alt="Shree Jagannatha Dham">
                </div>
                <div class="image-event">
                    <h2 class="text-2xl font-bold" style="color: #7B54E3;">Events</h2>
                    <img src="{{ asset('website/v4.png') }}" alt="Shree Jagannatha Dham">
                </div>
                <h2 class="text-2xl font-bold text-red-600"></h2>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-5">
                <!-- Calendar Section -->
                <div class="bg-white p-6 rounded-xl shadow-lg border border-yellow-300">
                    <h3 class="text-md font-semibold text-red-500">Select date</h3>
                    <div id="calendar"></div>
                </div>

                <!-- Events Section -->
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-300">
                    <h3 class="text-lg font-semibold text-red-500 text-center">Upcoming Events</h3>
                    <div id="events" class="grid grid-cols-3 gap-4 mt-4">
                        <!-- Event Cards -->
                        <div class="bg-red-100 p-3 rounded-lg text-center shadow-md hover:shadow-xl transition">
                            <img src="website/1.png" class="mx-auto w-12 h-12">
                            <p class="text-red-600 font-semibold">Sankranti</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-lg text-center shadow-md hover:shadow-xl transition">
                            <img src="website/2.png" class="mx-auto w-12 h-12">
                            <p class="text-blue-600 font-semibold">Amavasya</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-lg text-center shadow-md hover:shadow-xl transition">
                            <img src="website/3.png" class="mx-auto w-12 h-12">
                            <p class="text-green-600 font-semibold">Pournami</p>
                        </div>
                        <div class="bg-red-100 p-3 rounded-lg text-center shadow-md hover:shadow-xl transition">
                            <img src="website/1.png" class="mx-auto w-12 h-12">
                            <p class="text-red-600 font-semibold">Sankranti</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-lg text-center shadow-md hover:shadow-xl transition">
                            <img src="website/2.png" class="mx-auto w-12 h-12">
                            <p class="text-blue-600 font-semibold">Amavasya</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-lg text-center shadow-md hover:shadow-xl transition">
                            <img src="{{ asset('website/3.png') }}" class="mx-auto w-12 h-12">
                            <p class="text-green-600 font-semibold">Pournami</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="max-w-6xl mx-auto text-center">
        <!-- Section Title -->
        <h2 class="convenience-title" style="margin-top:50px">About Puri</h2>
        <div class="image-container">
            <img src="{{ asset('website/v1.png') }}" alt="Shree Jagannatha Dham">
        </div>
        <div class="flex justify-center items-center gap-4" style="margin-bottom: 50px;margin-top: 20px">
            <!-- Left Scroll Button -->
            <button id="scrollLeft" class="hidden md:block text-gray-400 hover:text-gray-600 text-xl">◀</button>

            <!-- Navigation Items -->
            <div id="navContainer" class="flex gap-6 overflow-x-auto no-scrollbar">
                <!-- Tab Items -->
                <div class="text-center min-w-[100px] cursor-pointer active-tab">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-red-600 font-semibold" style="margin-top:12px">About Temple</p>
                    <div class="h-1 bg-red-500 w-full mt-1" style="margin-top:10px"></div>
                </div>
                <div class="text-center min-w-[100px] cursor-pointer inactive-tab">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500" style="margin-top:12px">Shree Khetra</p>
                </div>
                <div class="text-center min-w-[100px] cursor-pointer inactive-tab">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500" style="margin-top:12px">Matha & Ashram</p>
                </div>
                <div class="text-center min-w-[100px] cursor-pointer inactive-tab">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500" style="margin-top:12px">Festivals</p>
                </div>
                <div class="text-center min-w-[100px] cursor-pointer inactive-tab">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500" style="margin-top:12px">36 Nijoga</p>
                </div>
                <div class="text-center min-w-[100px] cursor-pointer inactive-tab">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500" style="margin-top:12px">Besha</p>
                </div>
                <div class="text-center min-w-[100px] cursor-pointer inactive-tab">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500" style="margin-top:12px">Darshan Facility</p>
                </div>
                <div class="text-center min-w-[100px] cursor-pointer inactive-tab">
                    <img src="website/6.png" class="mx-auto w-10 h-10">
                    <p class="text-gray-500" style="margin-top:12px">Maha Prasad</p>
                </div>
            </div>

            <!-- Right Scroll Button -->
            <button id="scrollRight" class="hidden md:block text-gray-400 hover:text-gray-600 text-xl">▶</button>
        </div>
    </div>

    <section class="bg-gray-100 p-10">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <!-- Image Section -->
                <div style="height: 350px;width: 450px;margin-top: 50px">
                    <img src="website/12.jpg" alt="Temple Image" class="rounded-xl shadow-lg">
                </div>

                <!-- Text Content Section -->
                <div style="margin-left: -100px">
                    <h2 class="text-2xl font-bold" style="color: #3A506B;">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit
                    </h2>
                    <h3 class="text-xl text-gray-600 mt-2">
                        Lorem ipsum dolor sit amet
                    </h3>
                    <p class="text-gray-500 mt-4 leading-relaxed">
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

    <section class="bg-gray-100 p-10">
        <div class="max-w-6xl mx-auto text-center">
            <!-- Section Title -->
            <h2 class="convenience-title">Jagannatha Temples Worldwide</h2>
            <div class="image-container" >
                <img src="{{ asset('website/v1.png') }}" alt="Shree Jagannatha Dham">
            </div>
            <div class="banner-image" style="margin-top: 30px">
                <img src="{{ asset('website/18.png') }}" alt="Shree Jagannatha Dham">
            </div>
        </div>

    </section>
@endsection
