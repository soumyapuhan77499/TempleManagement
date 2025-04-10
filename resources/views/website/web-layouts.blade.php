<!DOCTYPE html>
<html lang="en">

<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('meta-description')">
    <meta name="keywords" content="@yield('meta-keywords')">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @yield('og-meta')
    <!--====== Title ======-->
    <title>@yield('pagename')</title>
    <!--====== Favicon Icon ======-->
    {{-- <link rel="shortcut icon" href="{{ asset('assets/front/img/' . $bs->favicon) }}" type="image/png"> --}}
    <link rel="stylesheet" href="{{ asset('assets/front/css/plugin.min.css') }}">
    {{-- <!--====== Bootstrap css ======-->
    <!--====== Default css ======-->
    <link rel="stylesheet" href="{{asset('assets/front/css/default.css')}}">
    <!--====== Style css ======-->
    <link rel="stylesheet" href="{{asset('assets/front/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/cookie-alert.css')}}">
    @if ($rtl == 1)
        <link rel="stylesheet" href="{{asset('assets/front/css/rtl-style.css')}}">
    @endif --}}
    <!-- base color change -->
    {{-- <link href="{{ asset('assets/front/css/style-base-color.php') . '?color=' . $bs->base_color }}" rel="stylesheet"> --}}
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/bootstrap.min.css') }}">
    <!-- Fontawesome Icon CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/fonts/fontawesome/css/all.min.css') }}">
    <!-- Swiper Slider -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/swiper-bundle.min.css') }}">
    <!-- Kreativ Icon -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/fonts/icomoon/style.css') }}">
    {{-- Toastr css  --}}
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/toastr.min.css') }}">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/magnific-popup.min.css') }}">
    <!-- AOS Animation CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/aos.min.css') }}">
    <!-- Nice Select -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/nice-select.css') }}">
    <!-- Main Style CSS -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- summernote Style CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/summernote-content.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/responsive.css') }}">

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400&display=swap" rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/puri-dhams.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/banner.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/niti.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/shree-mandir.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/service.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/temple-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/convience.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/calendar.css') }}">

</head>

<body>


    <!-- Content -->
    @yield('content')
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Jquery JS -->
    <script src="front-assets/frontend/js/jquery.min.js"></script>
    <script src="assets/front/js/plugin.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="front-assets/frontend/js/bootstrap.min.js"></script>
    <!-- Nice Select JS -->
    <script src="front-assets/frontend/js/jquery.nice-select.min.js"></script>
    <!-- Magnific Popup JS -->
    <script src="front-assets/frontend/js/jquery.magnific-popup.min.js"></script>
    <!-- Swiper Slider JS -->
    <script src="front-assets/frontend/js/swiper-bundle.min.js"></script>
    <!-- Lazysizes -->
    <script src="front-assets/frontend/js/lazysizes.min.js"></script>
    <!-- SVG loader -->
    <script src="front-assets/frontend/js/svg-loader.min.js"></script>
    <!-- AOS JS -->
    <script src="front-assets/frontend/js/aos.min.js"></script>
    <script src="front-assets/frontend/js/toastr.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        "use strict";
        var rtl = false; // Hardcoded for static version
    </script>

    <!-- Main script JS -->
    <script src="front-assets/frontend/js/script.js"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <script>
        const swiper = new Swiper(".mySwiper", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            loop: true,
            slidesPerView: 4, // show 7 slides total
            initialSlide: 3, // make sure the center one is visible initially
            coverflowEffect: {
                rotate: 0,
                stretch: 0,
                depth: 150,
                modifier: 2.5,
                slideShadows: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>

    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const calendarContainer = document.getElementById("calendar");
            const eventsContainer = document.getElementById("events");

            function generateCalendar(year, month) {
                const today = new Date();
                const firstDay = new Date(year, month, 1);
                const lastDay = new Date(year, month + 1, 0);
                const daysInMonth = lastDay.getDate();
                const startDay = firstDay.getDay();

                let html = `
            <div class="flex justify-between items-center mb-4">
                <button id="prevMonth" class="text-gray-600">◀</button>
                <h2 class="text-lg font-bold">${firstDay.toLocaleString('default', { month: 'long' })} ${year}</h2>
                <button id="nextMonth" class="text-gray-600">▶</button>
            </div>
            <div class="grid grid-cols-7 gap-2 text-center text-gray-500 font-semibold">
                <div>S</div><div>M</div><div>T</div><div>W</div><div>T</div><div>F</div><div>S</div>
            </div>
            <div class="grid grid-cols-7 gap-2 mt-2 text-center">
        `;

                for (let i = 0; i < startDay; i++) {
                    html += `<div></div>`; // Empty slots for previous month
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    const isToday = today.getDate() === day && today.getMonth() === month && today.getFullYear() ===
                        year;
                    html +=
                        `<div class="p-2 rounded-full cursor-pointer ${isToday ? "bg-red-500 text-white" : "hover:bg-gray-200"}" data-day="${day}">${day}</div>`;
                }

                html += `</div>`;
                calendarContainer.innerHTML = html;

                document.getElementById("prevMonth").addEventListener("click", () => updateCalendar(year, month -
                    1));
                document.getElementById("nextMonth").addEventListener("click", () => updateCalendar(year, month +
                    1));

                document.querySelectorAll("#calendar div[data-day]").forEach(dayEl => {
                    dayEl.addEventListener("click", function() {
                        document.querySelectorAll("#calendar div[data-day]").forEach(el => el
                            .classList.remove("bg-red-500", "text-white"));
                        this.classList.add("bg-red-500", "text-white");

                        const selectedDay = this.getAttribute("data-day");
                        updateEvents(selectedDay, month + 1, year);
                    });
                });
            }

            function updateEvents(day, month, year) {
                const eventTypes = ["Sankranti", "Amavasya", "Pournami"];
                const eventDay = parseInt(day);

                const eventsHtml = eventTypes.map(event => `
            <div class="text-gray-400 ${eventDay % 5 === 0 ? "opacity-100 text-black" : "opacity-40"}">
                <img src="website/11.jpg" class="mx-auto w-10 h-10">
                <p>${event}</p>
            </div>
        `).join("");

                eventsContainer.innerHTML = `<div class="grid grid-cols-3 gap-4 text-center">${eventsHtml}</div>`;
            }

            function updateCalendar(year, month) {
                if (month < 0) {
                    year -= 1;
                    month = 11;
                } else if (month > 11) {
                    year += 1;
                    month = 0;
                }
                generateCalendar(year, month);
            }

            const now = new Date();
            generateCalendar(now.getFullYear(), now.getMonth());
        });
    </script>

    <script>
        // Auto-activate About Temple tab when page loads
        document.addEventListener("DOMContentLoaded", function() {
            const defaultTab = document.querySelector('.tab-item[data-tab="aboutTemple"]');
            if (defaultTab) {
                defaultTab.click();
            }
        });
    </script>

    <script>
        const tabData = {
            aboutTemple: {
                title: "About Temple",
                subtitle: @json(strip_tags($aboutTemple->temple_about ?? 'No about content available')),
                description: @json(strip_tags($aboutTemple->temple_history ?? 'No history available')),
                image: "website/ss.jpg"
            },

            shreeKhetra: {
                title: "Shree Khetra",
                subtitle: "The Holy Land of Lord Jagannath",
                description: "Shree Kshetra, also known as Puri, is one of the holiest pilgrimage sites in India and one of the sacred Char Dham (four divine abodes) established by Adi Shankaracharya. It is the eternal home of Lord Jagannath, the Lord of the Universe, along with his siblings Balabhadra and Subhadra.",
                image: "website/sankha.png"
            },

            mathaAshram: {
                title: "Matha & Ashram",
                subtitle: @json($matha->matha_name ?? 'No matha info'),
                description: @json($matha->description ?? 'No description available'),
                image: "website/ashram.png"
            },

            festivals: {
                title: "Festivals",
                subtitle: @json($festival->festival_name ?? 'No festivals'),
                description: @json($festival->description ?? 'No description available'),
                image: "website/dipa.png"
            },

            nijoga: {
                title: "36 Nijoga",
                subtitle: @json($nijoga->nijoga_name ?? 'No nijoga data'),
                description: @json($nijoga->description ?? 'No description available'),
                image: "website/nijoga.png"
            },
            besha: {
                title: "Besha",
                subtitle: @json($besha->besha_name ?? 'No besha available'),
                description: @json($besha->description ?? 'No description available'),
                image: "website/besha.jpg"
            },
            darshan: {
                title: "Darshan Facility",
                subtitle: @json($darshan->darshan_name ?? 'No darshan info'),
                description: @json($darshan->description ?? 'No description available'),
                image: "website/dsn.png"
            },
            prasad: {
                title: "Maha Prasad",
                subtitle: @json($prasad->prasad_name ?? 'No prasad info'),
                description: @json($prasad->description ?? 'No description available'),
                image: "website/mp.png"
            }
        };
    </script>

    <script>
        document.querySelectorAll(".tab-item").forEach(tab => {
            tab.addEventListener("click", function() {
                const selectedTab = this.getAttribute("data-tab");
                const data = tabData[selectedTab];

                if (!data) return;

                document.getElementById("contentTitle").innerText = data.title;
                document.getElementById("contentSubtitle").innerText = data.subtitle;
                document.getElementById("contentDescription").innerText = data.description;
                document.getElementById("contentImage").src = data.image;

                document.querySelectorAll(".tab-item").forEach(t => {
                    t.classList.remove("active-tab");
                    t.classList.add("inactive-tab");
                    t.querySelector("p").classList.replace("text-red-600", "text-gray-500");
                    t.querySelector("div")?.remove();
                });

                this.classList.add("active-tab");
                this.classList.remove("inactive-tab");
                this.querySelector("p").classList.replace("text-gray-500", "text-red-600");

                const underline = document.createElement("div");
                underline.classList.add("h-1", "bg-red-500", "w-full", "mt-1");
                this.appendChild(underline);
            });
        });
    </script>

    <script>
        function toggleMobileNav() {
            const mobileNav = document.getElementById("mobileNav");
            mobileNav.classList.toggle("hidden");
        }
    </script>

    <script>
        function showContent(tab, element) {
            // Remove active class from all buttons
            document.querySelectorAll(".tab-buttons").forEach(button => {
                button.classList.remove("active-tabs");
                button.classList.remove("underline-effect");
            });

            // Add active class to clicked button
            element.classList.add("active-tabs");
            element.classList.add("underline-effect");

            // Update image based on selected tab
            let imagePath = "";
            let altText = "";

            if (tab === "worldwide") {
                imagePath = "{{ asset('website/18.png') }}";
                altText = "Jagannatha Temples Worldwide";
            } else if (tab === "india") {
                imagePath = "{{ asset('website/india.png') }}";
                altText = "Jagannatha Temples in India";
            } else if (tab === "odisha") {
                imagePath = "{{ asset('website/odisha.png') }}"; // You can also switch this to .svg if available
                altText = "Jagannatha Temples in Odisha";
            }

            // Change the image source and alt
            const imgEl = document.getElementById("dynamicImage");
            imgEl.src = imagePath;
            imgEl.alt = altText;
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const video = document.getElementById("bannerVideo");
            const playPauseButton = document.getElementById("playPauseButton");
            const muteToggle = document.getElementById("muteToggle");
            const hamburger = document.querySelector(".hamburger-icon");
            const navMenu = document.querySelector(".nav-menu");
            const navClose = document.querySelector(".nav-close");

            // Play/Pause Toggle
            playPauseButton.addEventListener("click", function() {
                if (video.paused) {
                    video.play();
                    this.innerHTML = '<i class="fa fa-pause"></i>';
                } else {
                    video.pause();
                    this.innerHTML = '<i class="fa fa-play"></i>';
                }
            });

            // Mute/Unmute Toggle
            muteToggle.addEventListener("click", function() {
                video.muted = !video.muted;
                this.innerHTML = video.muted ?
                    '<i class="fa fa-volume-mute"></i>' :
                    '<i class="fa fa-volume-up"></i>';
            });

            // Scroll-triggered pause
            function checkScroll() {
                const rect = video.getBoundingClientRect();
                const inView = rect.top < window.innerHeight && rect.bottom > 0;
                if (!inView) {
                    video.pause();
                    playPauseButton.innerHTML = '<i class="fa fa-play"></i>';
                }
            }
            window.addEventListener("scroll", checkScroll);

            // Navigation Toggle
            hamburger.addEventListener("click", function() {
                hamburger.classList.toggle("active");
                navMenu.classList.toggle("active");
                console.log("Hamburger clicked, nav toggled");
            });

            navClose.addEventListener("click", function() {
                navMenu.classList.remove("active");
                hamburger.classList.remove("active");
            });
        });
    </script>

    <script>
        lucide.createIcons();
    </script>

</body>


</html>
