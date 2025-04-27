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
        <img class="hero-bg" src="{{ asset('website/fest.jpg') }}" alt="Mandir Background" />
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Temple Festival</h1>
            <p>Complete List Of Festival In The Temple</p>
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
                      <!-- Existing rows -->
                      <tr>
                        <td class="py-3 px-4">SriMandirare Dolo Purnima & Rajadhiraj Besha</td>
                        <td class="py-3 px-4">03/03/2026</td>
                        <td class="py-3 px-4">Tuesday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Holi Uttsaba, Chandan Anukula</td>
                        <td class="py-3 px-4">04/03/2026</td>
                        <td class="py-3 px-4">Wednesday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Papa Mochini Ekadashi & Mina Sankranti</td>
                        <td class="py-3 px-4">15/03/2026</td>
                        <td class="py-3 px-4">Sunday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Badi Nrusingha Bije</td>
                        <td class="py-3 px-4">22/03/2026</td>
                        <td class="py-3 px-4">Sunday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Jeuta Bhoga & Ashokastami</td>
                        <td class="py-3 px-4">26/03/2026</td>
                        <td class="py-3 px-4">Thursday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare SriRamanabami</td>
                        <td class="py-3 px-4">27/03/2026</td>
                        <td class="py-3 px-4">Friday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Jangyarakhya</td>
                        <td class="py-3 px-4">28/03/2026</td>
                        <td class="py-3 px-4">Saturday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Sita Bibaha & Kamada Ekadashi</td>
                        <td class="py-3 px-4">29/03/2026</td>
                        <td class="py-3 px-4">Sunday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Kandarp Adhibasa, Banabasa</td>
                        <td class="py-3 px-4">30/03/2026</td>
                        <td class="py-3 px-4">Monday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Dayanachori & Ananga Troyadashi</td>
                        <td class="py-3 px-4">31/03/2026</td>
                        <td class="py-3 px-4">Tuesday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Damanaka Chaturdashi, Dayana Bedha, Mayamruga & Sita Chori</td>
                        <td class="py-3 px-4">01/04/2026</td>
                        <td class="py-3 px-4">Wednesday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Lanka Podi</td>
                        <td class="py-3 px-4">03/04/2026</td>
                        <td class="py-3 px-4">Friday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Setu Bandha</td>
                        <td class="py-3 px-4">04/04/2026</td>
                        <td class="py-3 px-4">Saturday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Rabana Badha</td>
                        <td class="py-3 px-4">05/04/2026</td>
                        <td class="py-3 px-4">Sunday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Ramabhiseka</td>
                        <td class="py-3 px-4">12/04/2026</td>
                        <td class="py-3 px-4">Sunday</td>
                      </tr>
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
