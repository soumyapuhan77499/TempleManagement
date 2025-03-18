<!DOCTYPE html>
<html lang="en" >
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
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

    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/puri-dham.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- summernote Style CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/summernote-content.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/responsive.css') }}">
    {{-- @if ($rtl == 1) --}}
        {{-- <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/rtl.css') }}"> --}}
    {{-- @endif --}}
    <!-- base color change -->
    {{-- <link href="{{ asset('front-assets/frontend/css/style-base-color.php') . '?color=' . $bs->base_color }}"
        rel="stylesheet"> --}}
           
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

</head>

<body>


    <!-- Content -->
    @yield('content')

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

    <script>
        "use strict";
        var rtl = false; // Hardcoded for static version
    </script>

    <!-- Main script JS -->
    <script src="front-assets/frontend/js/script.js"></script>

   
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
   var swiper = new Swiper(".mySwiper", {
    slidesPerView: 3,
    centeredSlides: true,
    loop: true,
    spaceBetween: 0, // ✅ Remove gap between images
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        1024: { slidesPerView: 3, spaceBetween: 0 }, // ✅ No space
        768: { slidesPerView: 2, spaceBetween: 0 },
        480: { slidesPerView: 1, spaceBetween: 0 }
    },
    on: {
        slideChangeTransitionEnd: function () {
            document.querySelectorAll(".swiper-slide img").forEach(img => {
                img.classList.remove("active-slide");
            });
            document.querySelector(".swiper-slide-active img").classList.add("active-slide");
        }
    }
});


</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
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
            const isToday = today.getDate() === day && today.getMonth() === month && today.getFullYear() === year;
            html += `<div class="p-2 rounded-full cursor-pointer ${isToday ? "bg-red-500 text-white" : "hover:bg-gray-200"}" data-day="${day}">${day}</div>`;
        }

        html += `</div>`;
        calendarContainer.innerHTML = html;

        document.getElementById("prevMonth").addEventListener("click", () => updateCalendar(year, month - 1));
        document.getElementById("nextMonth").addEventListener("click", () => updateCalendar(year, month + 1));

        document.querySelectorAll("#calendar div[data-day]").forEach(dayEl => {
            dayEl.addEventListener("click", function () {
                document.querySelectorAll("#calendar div[data-day]").forEach(el => el.classList.remove("bg-red-500", "text-white"));
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
    // Scroll functionality
    const navContainer = document.getElementById('navContainer');
    const scrollLeft = document.getElementById('scrollLeft');
    const scrollRight = document.getElementById('scrollRight');

    scrollLeft.addEventListener('click', () => {
        navContainer.scrollBy({ left: -200, behavior: 'smooth' });
    });

    scrollRight.addEventListener('click', () => {
        navContainer.scrollBy({ left: 200, behavior: 'smooth' });
    });

    // Tab Selection
    document.querySelectorAll(".inactive-tab").forEach(tab => {
        tab.addEventListener("click", function() {
            document.querySelectorAll(".active-tab").forEach(activeTab => {
                activeTab.classList.remove("active-tab");
                activeTab.classList.add("inactive-tab");
                activeTab.querySelector("p").classList.replace("text-red-600", "text-gray-500");
                activeTab.querySelector("img").src = "website/1.png";
                activeTab.querySelector("div")?.remove();
            });

            this.classList.add("active-tab");
            this.classList.remove("inactive-tab");
            this.querySelector("p").classList.replace("text-gray-500", "text-red-600");
            this.querySelector("img").src = "website/2.png";

            // Add underline effect
            const underline = document.createElement("div");
            underline.classList.add("h-1", "bg-red-500", "w-full", "mt-1");
            this.appendChild(underline);
        });
    });
</script>

    
</body>


</html>
