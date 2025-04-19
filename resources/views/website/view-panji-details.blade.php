<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nearby Temple</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
     <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/bootstrap.min.css') }}">
     <!-- Fontawesome Icon CSS -->
   
     <!-- summernote Style CSS -->
     <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/summernote-content.css') }}">
     <!-- Responsive CSS -->
     <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/responsive.css') }}">
 <!-- Bootstrap 5 CSS CDN -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
 
     <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
 
     <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400&display=swap" rel="stylesheet">
 
     <!-- Swiper CSS -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
 
     <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/puri-dhams.css') }}">
    
     <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/calendar.css') }}">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f7f7f7;
        }

        .header-area {
            background: white;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo img {
            height: 60px;
            width: auto;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-menu a {
            color: #4d6189;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
        }

        .separator {
            font-weight: bold;
            color: #ff4b2b;
        }

        .live-badges {
            background: red;
            color: white;
            padding: 2px 10px;
            border-radius: 10px;
            margin-left: 5px;
        }

        .hero {
            position: relative;
            height: 320px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, rgba(0, 0, 0, 0.8), rgba(153, 32, 13, 0.8));
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 0 20px;
        }

        .hero-content h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #fff;
        }

        .hero-content p {
            font-size: 17px;
            color: #f5f5f5;
        }


    </style>
</head>

<body>
<header class="header-area">
    <div class="header-content">
        <div class="logo">
            <img src="{{ asset('website/logo.png') }}" alt="logo">
        </div>
        <nav class="nav-menu">
            <a href="#">Nitis</a>
            <span class="separator">SM <a href="#" class="live-badges"><i class="fa fa-bolt"></i> Live</a></span>
            <a href="#">Services</a>
            <a href="#">Nearby Temples</a>
            <a href="#">Conveniences</a>
            <a href="#">Temple Information</a>
        </nav>
    </div>
</header>

<section class="hero">
    <img class="hero-bg" src="{{ asset('website/parking.jpeg') }}" alt="Mandir Background" />
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Panji Details</h1>
        <p>        This is the detailed view of the Panji where you can explore historic and sacred schedules maintained for centuries.
        </p>
    </div>
</section>
<section class="py-10 bg-gradient-to-br from-orange-50 via-yellow-50 to-pink-100">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header row -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div class="flex items-center gap-3">
                <h2 class="text-2xl font-bold text-[#db4d30]">Panji Calendar</h2>
                <img src="{{ asset('website/right.png') }}" class="h-5 w-28" alt="Decor">
            </div>
            <div class="hidden md:flex items-center gap-3">
                <h2 class="text-2xl font-bold text-[#db4d30]">Events</h2>
                <img src="{{ asset('website/right.png') }}" class="h-5 w-28" alt="Decor">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Calendar Card -->
            <div class="bg-white shadow p-6 rounded-xl border border-yellow-300">
                <h3 class="text-md font-semibold text-red-500 mb-3">Select Date</h3>
                <div id="calendar"></div>

                <div class="flex justify-center items-center gap-4 mt-10 mb-4">
                    <img src="{{ asset('website/left.png') }}" class="h-4 w-24" alt="Decor">
                    <h3 class="text-md font-bold uppercase tracking-wider text-[#db4d30]">Today Occasion</h3>
                    <img src="{{ asset('website/right.png') }}" class="h-4 w-24" alt="Decor">
                </div>

                <div class="space-y-3 text-sm text-gray-700">
                    <div class="flex items-start gap-3"><i class="fas fa-spa text-green-600"></i><p>Gruha Devi & Basantika Mrunmayee Devi nka Saptami Puja Arambha</p></div>
                    <div class="flex items-start gap-3"><i class="fas fa-fire text-red-500"></i><p>Pithe Astami Puja</p></div>
                    <div class="flex items-start gap-3"><i class="fas fa-clock text-blue-600"></i><p>Tithi: 4th Apr Friday, Chaitra, Mina day 22</p></div>

                    <hr class="my-4 border-dashed border-gray-300">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="flex items-start gap-2"><i class="fas fa-sun text-orange-400"></i><p>Sunrise: <strong>05:38 AM</strong></p></div>
                        <div class="flex items-start gap-2"><i class="fas fa-moon text-indigo-500"></i><p>Moonrise: <strong>10:26 AM</strong></p></div>
                        <div class="flex items-start gap-2"><i class="fas fa-sun text-red-500"></i><p>Sunset: <strong>06:02 PM</strong></p></div>
                        <div class="flex items-start gap-2"><i class="fas fa-moon text-blue-600"></i><p>Moonset: <strong>12:30 AM, Apr 05</strong></p></div>
                        <div class="flex items-start gap-2"><i class="fas fa-calendar-week text-teal-600"></i><p>Weekday: <strong>Shukrawara</strong></p></div>
                        <div class="flex items-start gap-2"><i class="fas fa-adjust text-yellow-500"></i><p>Paksha: <strong>Shukla Paksha</strong></p></div>
                        <div class="flex items-start gap-2"><i class="fas fa-star text-purple-600"></i><p>Tithi: <strong>Saptami upto 08:12 PM</strong></p></div>
                        <div class="flex items-start gap-2"><i class="fas fa-smile text-green-600"></i><p>Yoga: <strong>Shobhana upto 09:45 PM</strong></p></div>
                        <div class="flex items-start gap-2"><i class="fas fa-sun-plant-wilt text-yellow-500"></i><p>Sunsign: <strong>Meena</strong></p></div>
                        <div class="flex items-start gap-2"><i class="fas fa-moon-stars text-indigo-600"></i><p>Moonsign: <strong>Mithuna</strong></p></div>
                    </div>
                </div>
            </div>

            <!-- Events Section -->
            <div class="bg-white shadow p-6 rounded-xl border border-gray-300">
                <div class="md:hidden flex items-center gap-2 mb-4">
                    <h3 class="text-xl font-semibold text-[#db4d30]">Events</h3>
                    <img src="{{ asset('website/right.png') }}" alt="Events Decor" class="h-5 w-28">
                </div>
                <div id="events">
                    <img src="{{ asset('website/astami.png') }}" class="rounded-lg w-full">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Calendar Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const calendarContainer = document.getElementById("calendar");
        const eventsContainer = document.getElementById("events");

        function generateCalendar(year, month) {
            const today = new Date();
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startDay = firstDay.getDay();
            const daysInMonth = lastDay.getDate();

            let html = `<div class='flex justify-between items-center mb-3'>
                <button id='prevMonth' class='text-gray-600'>&larr;</button>
                <h4 class='font-bold text-lg'>${firstDay.toLocaleString('default', { month: 'long' })} ${year}</h4>
                <button id='nextMonth' class='text-gray-600'>&rarr;</button>
            </div>
            <div class='grid grid-cols-7 text-center font-semibold text-gray-500'>
                <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
            </div><div class='grid grid-cols-7 gap-2 text-center mt-2'>`;

            for (let i = 0; i < startDay; i++) html += `<div></div>`;
            for (let day = 1; day <= daysInMonth; day++) {
                const isToday = today.getDate() === day && today.getMonth() === month && today.getFullYear() === year;
                html += `<div class='p-2 rounded-full cursor-pointer ${isToday ? "bg-red-500 text-white" : "hover:bg-gray-200"}' data-day='${day}'>${day}</div>`;
            }
            html += `</div>`;

            calendarContainer.innerHTML = html;
            document.getElementById("prevMonth").onclick = () => updateCalendar(year, month - 1);
            document.getElementById("nextMonth").onclick = () => updateCalendar(year, month + 1);

            document.querySelectorAll("#calendar div[data-day]").forEach(el => {
                el.addEventListener("click", function () {
                    document.querySelectorAll("#calendar div[data-day]").forEach(day => day.classList.remove("bg-red-500", "text-white"));
                    this.classList.add("bg-red-500", "text-white");
                    updateEvents(this.dataset.day, month + 1, year);
                });
            });
        }

        function updateEvents(day, month, year) {
            const types = ["Sankranti", "Amavasya", "Pournami"];
            const eventsHtml = types.map(e => `<div class='text-center text-sm'><img src='website/11.jpg' class='mx-auto w-10 h-10'><p>${e}</p></div>`).join('');
            eventsContainer.innerHTML = `<div class='grid grid-cols-3 gap-4'>${eventsHtml}</div>`;
        }

        function updateCalendar(year, month) {
            if (month < 0) {
                year--;
                month = 11;
            } else if (month > 11) {
                year++;
                month = 0;
            }
            generateCalendar(year, month);
        }

        const now = new Date();
        generateCalendar(now.getFullYear(), now.getMonth());
    });
</script>

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

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>

</body>

</html>