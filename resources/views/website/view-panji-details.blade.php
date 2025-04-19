<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nearby Temple</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
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

<div class="timeline-footer">
    © {{ date('Y') }} Temple Management System. All rights reserved.
</div>

</body>

</html>