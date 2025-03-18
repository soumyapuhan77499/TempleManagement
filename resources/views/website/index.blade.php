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
                <h3>Panchami</h3>
                <p><strong>Shukla Paksha</strong></p>
            </div>
            <div class="niti-icons">
                <p><i class="fa fa-clock"></i> 03:17 pm</p>
                <p><i class="fa fa-calendar"></i> 4th Mar</p>
            </div>
        </div>
        <div class="niti-card">
            <div class="niti-content">
                <h3>Niti Name</h3>
                <p><strong>Shukla Paksha</strong></p>
            </div>
            <div class="niti-icons">
                <p><i class="fa fa-clock"></i> 03:17 pm</p>
                <p><i class="fa fa-calendar"></i> 4th Mar</p>
            </div>

        </div>
        <div class="niti-card">
            <div class="niti-content">
                <h3>Niti Name</h3>
                <p><strong>Shukla Paksha</strong></p>
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
                        <i class="fa fa-tv"></i>
                        <h3>TV</h3>
                    </div>
                    <p>Listen or Watch all thelive broadcasts from Shree Mandira</p>
                    <p>🕒 03:17 pm</p>
                    <p>📅 4th Mar</p>
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
                        <i class="fa fa-radio"></i>
                        <h3>Radio</h3>
                    </div>
                    <p>Listen or Watch all the live broadcasts from Shree Mandira</p>
                    <p>🕒 03:17 pm</p>
                    <p>📅 4th Mar</p>
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
                        <h4>Lifelight Radio</h4>
                        <p>Bengaluru, India</p>
                        <div class="radio-controls">
                            <button>⏮</button>
                            <button>⏯</button>
                            <button>⏭</button>
                            <input type="range" min="0" max="100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
   
<section class="services-section">
    <h2 class="section-title">Quick Services</h2>

    <div class="services-container">
        <!-- Accommodation -->
        <div class="service-card accommodation-card">
            <div class="icon-container">
                <i class="fa fa-bed"></i>
            </div>
            <div class="service-content">
                <h3>Accommodation</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
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
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
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
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
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
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <a href="#" class="read-more">Read More</a>
            </div>
        </div>
    </div>

</section>
<section class="temple-slider">
    <h2 class="slider-title">Nearby Temples</h2>
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

@endsection
