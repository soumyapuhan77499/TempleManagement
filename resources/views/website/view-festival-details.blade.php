<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nearby Temple - Festivals</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/dham-header.css') }}">
</head>

<body>
    @include('partials.header-puri-dham')

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
