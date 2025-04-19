<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nearby Temple - Festivals</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #fefefe;
        }

        .header-area {
            background: white;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
            height: 70px;
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
            <h1>Temple Festival</h1>
            <p>Discover sacred places close to your journey.</p>
        </div>
    </section>

    <section class="py-10 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-[#db4d30] mb-8">Festival Calendar</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-xl overflow-hidden">
                    <thead class="bg-gradient-to-r from-orange-200 to-yellow-300 text-gray-800 text-left">
                        <tr>
                            <th class="py-3 px-4 text-sm font-semibold">Festival Name</th>
                            <th class="py-3 px-4 text-sm font-semibold">Date</th>
                            <th class="py-3 px-4 text-sm font-semibold">Day</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <!-- Add rows dynamically or statically here -->
                        <tr class="border-t">
                            <td class="py-3 px-4">Mahabishuba Sankranti, Hanuman Jayanti, RabanaBadha Prastab</td>
                            <td class="py-3 px-4">14/04/2025</td>
                            <td class="py-3 px-4">Monday</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="py-3 px-4">SriMandirare Ramabhiseka</td>
                            <td class="py-3 px-4">22/04/2025</td>
                            <td class="py-3 px-4">Tuesday</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4">SriMandirare Rukmani Amabassya</td>
                            <td class="py-3 px-4">27/04/2025</td>
                            <td class="py-3 px-4">Sunday</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="py-3 px-4">SriMandirare AkhyaTrutiya, Chandan Yatra Arambha</td>
                            <td class="py-3 px-4">30/04/2025</td>
                            <td class="py-3 px-4">Wednesday</td>
                        </tr>
                        <!-- Continue listing all festivals -->
                        <!-- You can use a loop in Blade to render them from a database -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="text-center text-sm text-gray-400 mt-10 mb-6">
        © {{ date('Y') }} Temple Management System. All rights reserved.
    </div>
</body>

</html>
