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
                      <!-- Additional dynamic rows -->
                      <tr>
                        <td class="py-3 px-4">SriMandirare Niladri Mahodyastami</td>
                        <td class="py-3 px-4">05/05/2025</td>
                        <td class="py-3 px-4">Monday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Mohini Ekadashi</td>
                        <td class="py-3 px-4">08/05/2025</td>
                        <td class="py-3 px-4">Thursday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Nursingha Janma</td>
                        <td class="py-3 px-4">11/05/2025</td>
                        <td class="py-3 px-4">Sunday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Bhaunri</td>
                        <td class="py-3 px-4">19/05/2025</td>
                        <td class="py-3 px-4">Monday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Jalakrida Ekadashi</td>
                        <td class="py-3 px-4">23/05/2025</td>
                        <td class="py-3 px-4">Friday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Sabitri Amabassya, Jalakrida & Sagar Bije</td>
                        <td class="py-3 px-4">27/05/2025</td>
                        <td class="py-3 px-4">Tuesday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">Siva Bibaha</td>
                        <td class="py-3 px-4">31/05/2025</td>
                        <td class="py-3 px-4">Saturday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare SitalaSasthi, Jalakrida</td>
                        <td class="py-3 px-4">01/06/2025</td>
                        <td class="py-3 px-4">Sunday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Rajendrabhiseka And Sudasha Brata</td>
                        <td class="py-3 px-4">05/06/2025</td>
                        <td class="py-3 px-4">Thursday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Rukmaniharan Ekadashi & Bibaha Mahosttaba & Jalakrida</td>
                        <td class="py-3 px-4">06/06/2025</td>
                        <td class="py-3 px-4">Friday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Champaka Dwadashi</td>
                        <td class="py-3 px-4">07/06/2025</td>
                        <td class="py-3 px-4">Saturday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Daitapati Prabesa</td>
                        <td class="py-3 px-4">09/06/2025</td>
                        <td class="py-3 px-4">Monday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Srijiunkara Chaturthi Homo, Senapata Lagi</td>
                        <td class="py-3 px-4">10/06/2025</td>
                        <td class="py-3 px-4">Tuesday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Snana Yatra, Gajanana Besha & Anabasara Arambha</td>
                        <td class="py-3 px-4">11/06/2025</td>
                        <td class="py-3 px-4">Wednesday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">Raja Sankranti</td>
                        <td class="py-3 px-4">15/06/2025</td>
                        <td class="py-3 px-4">Thursday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Anabasra Chakabije</td>
                        <td class="py-3 px-4">20/06/2025</td>
                        <td class="py-3 px-4">Friday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Anabasara Ekadashi & Khalilagi</td>
                        <td class="py-3 px-4">21/06/2025</td>
                        <td class="py-3 px-4">Saturday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Anabasara Dwadashi & Rajaprasad Bije</td>
                        <td class="py-3 px-4">22/06/2025</td>
                        <td class="py-3 px-4">Sunday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Anabasara Tryodashi & Ghanalagi</td>
                        <td class="py-3 px-4">23/06/2025</td>
                        <td class="py-3 px-4">Monday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">Banakalagi</td>
                        <td class="py-3 px-4">24/06/2025</td>
                        <td class="py-3 px-4">Tuesday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">Amabassya, Srijiunka Banakalagi</td>
                        <td class="py-3 px-4">25/06/2025</td>
                        <td class="py-3 px-4">Wednesday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Netrousttab, Nabajoubana Darsan & Ratha Angyamala Bije</td>
                        <td class="py-3 px-4">26/06/2025</td>
                        <td class="py-3 px-4">Thursday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriGundicha Yatra</td>
                        <td class="py-3 px-4">27/06/2025</td>
                        <td class="py-3 px-4">Friday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">Herapanchami</td>
                        <td class="py-3 px-4">01/07/2025</td>
                        <td class="py-3 px-4">Tuesday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriJiunka Sandhya Darsan</td>
                        <td class="py-3 px-4">04/07/2025</td>
                        <td class="py-3 px-4">Friday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriJiunka Bahuda Yatra</td>
                        <td class="py-3 px-4">05/07/2025</td>
                        <td class="py-3 px-4">Saturday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriJiunka Harisayan Ekadashi & BadaTadau Besha(Sunabesha)</td>
                        <td class="py-3 px-4">06/07/2025</td>
                        <td class="py-3 px-4">Sunday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">Ratha upare SriJiunka Adhara Pana & Srigaruda Sayan</td>
                        <td class="py-3 px-4">07/07/2025</td>
                        <td class="py-3 px-4">Monday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriJiunka Niladri Bije</td>
                        <td class="py-3 px-4">08/07/2025</td>
                        <td class="py-3 px-4">Tuesday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">Dakhinayan Sankranti</td>
                        <td class="py-3 px-4">16/07/2025</td>
                        <td class="py-3 px-4">Wednesday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Kamada Or Chakrabula Ekadashi</td>
                        <td class="py-3 px-4">21/07/2025</td>
                        <td class="py-3 px-4">Monday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Chitalagi Amabassya</td>
                        <td class="py-3 px-4">24/07/2025</td>
                        <td class="py-3 px-4">Thursday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Badi Nursingha Bije</td>
                        <td class="py-3 px-4">03/08/2025</td>
                        <td class="py-3 px-4">Sunday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Jhulana Yatra Arambha</td>
                        <td class="py-3 px-4">04/08/2025</td>
                        <td class="py-3 px-4">Monday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Putrada Ekadashi</td>
                        <td class="py-3 px-4">05/08/2025</td>
                        <td class="py-3 px-4">Tuesday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Balabhadra Janma & Rakhilagi</td>
                        <td class="py-3 px-4">09/08/2025</td>
                        <td class="py-3 px-4">Saturday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Jhulana Yatra Sesha</td>
                        <td class="py-3 px-4">10/08/2025</td>
                        <td class="py-3 px-4">Sunday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Rahurekha Lagi</td>
                        <td class="py-3 px-4">13/08/2025</td>
                        <td class="py-3 px-4">Wednesday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Garbhaudaka Bandapana(Jeuta Bhoga)</td>
                        <td class="py-3 px-4">14/08/2025</td>
                        <td class="py-3 px-4">Thursday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Janmastami</td>
                        <td class="py-3 px-4">15/08/2025</td>
                        <td class="py-3 px-4">Friday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Nandousttaba</td>
                        <td class="py-3 px-4">16/08/2025</td>
                        <td class="py-3 px-4">Saturday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Banabhoji Besha, Kolibika & Bakasurabadha Prasatab & Arghasurabadha Prastab</td>
                        <td class="py-3 px-4">18/08/2025</td>
                        <td class="py-3 px-4">Monday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Kaliyadalan Ekadashi, Kaliyadalan Besha & Dhenukasura Badha Prastab</td>
                        <td class="py-3 px-4">19/08/2025</td>
                        <td class="py-3 px-4">Tuesday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Pralambasura Badha Besha</td>
                        <td class="py-3 px-4">20/08/2025</td>
                        <td class="py-3 px-4">Wednesday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Krushnabalarama Besha, Arnnapratha Prastab</td>
                        <td class="py-3 px-4">21/08/2025</td>
                        <td class="py-3 px-4">Thursday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Satapuri Tada Bije</td>
                        <td class="py-3 px-4">22/08/2025</td>
                        <td class="py-3 px-4">Friday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Satapuri Amabassya & Bastraharana Lila</td>
                        <td class="py-3 px-4">23/08/2025</td>
                        <td class="py-3 px-4">Saturday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Dabagni Lila</td>
                        <td class="py-3 px-4">24/08/2025</td>
                        <td class="py-3 px-4">Sunday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Nikunjalila</td>
                        <td class="py-3 px-4">25/08/2025</td>
                        <td class="py-3 px-4">Monday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Andhalila Prastab & Balitrutiya</td>
                        <td class="py-3 px-4">26/08/2025</td>
                        <td class="py-3 px-4">Tuesday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare SriGanesha Chaturthi</td>
                        <td class="py-3 px-4">27/08/2025</td>
                        <td class="py-3 px-4">Wednesday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Rushipanchami & Dahalila</td>
                        <td class="py-3 px-4">28/08/2025</td>
                        <td class="py-3 px-4">Thursday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Bimbasura Badha Prastab</td>
                        <td class="py-3 px-4">29/08/2025</td>
                        <td class="py-3 px-4">Friday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Lalita Saptami, Kekesi Badha Lila & Kukutibrata</td>
                        <td class="py-3 px-4">30/08/2025</td>
                        <td class="py-3 px-4">Saturday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Radhastami, SriSudarsan Debanka Ashram Bije, Durga sayan</td>
                        <td class="py-3 px-4">31/08/2025</td>
                        <td class="py-3 px-4">Sunday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Kansabadha Prastab, Labanikhia & Mathurahat Jur</td>
                        <td class="py-3 px-4">02/09/2025</td>
                        <td class="py-3 px-4">Tuesday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Parswa Paribarttan Ekadashi</td>
                        <td class="py-3 px-4">03/09/2025</td>
                        <td class="py-3 px-4">Wednesday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Bamana Janma & Suniaan, Indradhwaja Pooja & Garuda Parswa Paribarttan</td>
                        <td class="py-3 px-4">04/09/2025</td>
                        <td class="py-3 px-4">Thursday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Balibamana Besha</td>
                        <td class="py-3 px-4">05/09/2025</td>
                        <td class="py-3 px-4">Friday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Ananta Brata</td>
                        <td class="py-3 px-4">06/09/2025</td>
                        <td class="py-3 px-4">Saturday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Indra Gobinda Bandapana, Indrahati Prastab</td>
                        <td class="py-3 px-4">07/09/2025</td>
                        <td class="py-3 px-4">Sunday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Sahasrakumbhabhiseka, Debi Utthapana, Sodashadinamtaka Puja Arambha</td>
                        <td class="py-3 px-4">14/09/2025</td>
                        <td class="py-3 px-4">Sunday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Indira Ekadashi</td>
                        <td class="py-3 px-4">17/09/2025</td>
                        <td class="py-3 px-4">Wednesday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Mahalaya Amabassya & Sagar Bije</td>
                        <td class="py-3 px-4">21/09/2025</td>
                        <td class="py-3 px-4">Sunday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Durgamadhabanka Bahar Bije</td>
                        <td class="py-3 px-4">22/09/2025</td>
                        <td class="py-3 px-4">Monday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Mahasaptami</td>
                        <td class="py-3 px-4">28/09/2025</td>
                        <td class="py-3 px-4">Sunday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Mahastami</td>
                        <td class="py-3 px-4">29/09/2025</td>
                        <td class="py-3 px-4">Monday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Mahanabami</td>
                        <td class="py-3 px-4">30/09/2025</td>
                        <td class="py-3 px-4">Tuesday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Dasahara & Ayudha Puja, Sudasha Brata</td>
                        <td class="py-3 px-4">02/10/2025</td>
                        <td class="py-3 px-4">Thursday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Radhadamodara Besha & Baladhupa Arambha</td>
                        <td class="py-3 px-4">03/10/2025</td>
                        <td class="py-3 px-4">Friday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Kumar Purnima, Srisudarsan Debanka Ashram Bije</td>
                        <td class="py-3 px-4">07/10/2025</td>
                        <td class="py-3 px-4">Tuesday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Rama Ekadashi & Garbhana Sankranti</td>
                        <td class="py-3 px-4">17/10/2025</td>
                        <td class="py-3 px-4">Friday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Amabassya & Sagarbije</td>
                        <td class="py-3 px-4">21/10/2025</td>
                        <td class="py-3 px-4">Tuesday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Amala Nabami</td>
                        <td class="py-3 px-4">31/10/2025</td>
                        <td class="py-3 px-4">Friday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Laxminarayana Besha & Hari Utthapana Niti</td>
                        <td class="py-3 px-4">02/11/2025</td>
                        <td class="py-3 px-4">Sunday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Srijiunka Dalakia Or Tribikrama Besha – Garuda Utthapana</td>
                        <td class="py-3 px-4">03/11/2025</td>
                        <td class="py-3 px-4">Monday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare SriJiunka Laxmi Nrusingha Besha</td>
                        <td class="py-3 px-4">04/11/2025</td>
                        <td class="py-3 px-4">Tuesday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Karttika Purnima & SriJiunka Rajadhiraja besha</td>
                        <td class="py-3 px-4">05/11/2025</td>
                        <td class="py-3 px-4">Wednesday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Prathamistami</td>
                        <td class="py-3 px-4">12/11/2025</td>
                        <td class="py-3 px-4">Wednesday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Uttapana Ekadashi</td>
                        <td class="py-3 px-4">15/11/2025</td>
                        <td class="py-3 px-4">Saturday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Deba Deepabali Arambha</td>
                        <td class="py-3 px-4">19/11/2025</td>
                        <td class="py-3 px-4">Wednesday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Deba Deepabali & Amabassya</td>
                        <td class="py-3 px-4">20/11/2025</td>
                        <td class="py-3 px-4">Thursday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Sesha Deba Deepabali</td>
                        <td class="py-3 px-4">21/11/2025</td>
                        <td class="py-3 px-4">Friday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Prabrana Or Odhani Sasthi</td>
                        <td class="py-3 px-4">26/11/2025</td>
                        <td class="py-3 px-4">Wednesday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Gomati Ekadashi</td>
                        <td class="py-3 px-4">01/12/2025</td>
                        <td class="py-3 px-4">Monday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Pandu Nrusingha Bije</td>
                        <td class="py-3 px-4">04/12/2025</td>
                        <td class="py-3 px-4">Thursday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Saphala Ekadashi</td>
                        <td class="py-3 px-4">15/12/2025</td>
                        <td class="py-3 px-4">Monday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Dhanu Sankranti & Pahali Bhoga Arambha</td>
                        <td class="py-3 px-4">16/12/2025</td>
                        <td class="py-3 px-4">Tuesday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Bakula Amabassya & Sagar Bije</td>
                        <td class="py-3 px-4">20/12/2025</td>
                        <td class="py-3 px-4">Saturday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Sambha Dashami, Putrada Ekadashi</td>
                        <td class="py-3 px-4">30/12/2025</td>
                        <td class="py-3 px-4">Tuesday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Debabhiseka & Pushyabhiseka Purnima</td>
                        <td class="py-3 px-4">03/01/2026</td>
                        <td class="py-3 px-4">Saturday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Dudha Melana</td>
                        <td class="py-3 px-4">12/01/2026</td>
                        <td class="py-3 px-4">Monday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Nabanka Besha</td>
                        <td class="py-3 px-4">13/01/2026</td>
                        <td class="py-3 px-4">Tuesday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Makara Sankranti & Satatila Ekadashi</td>
                        <td class="py-3 px-4">14/01/2026</td>
                        <td class="py-3 px-4">Wednesday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare SriJiunka Padma Besha</td>
                        <td class="py-3 px-4">21/01/2026</td>
                        <td class="py-3 px-4">Wednesday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Basant Panchami & Rathakatha Anukula Puja</td>
                        <td class="py-3 px-4">23/01/2026</td>
                        <td class="py-3 px-4">Friday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare</td>
                        <td class="py-3 px-4">29/01/2026</td>
                        <td class="py-3 px-4">Thursday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriJiunka Gaja Uddharana Besha</td>
                        <td class="py-3 px-4">01/02/2026</td>
                        <td class="py-3 px-4">Sunday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Kumbha Sankranti & Pankouddhara Ekadashi</td>
                        <td class="py-3 px-4">13/02/2026</td>
                        <td class="py-3 px-4">Friday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Mahasibaratri</td>
                        <td class="py-3 px-4">15/02/2026</td>
                        <td class="py-3 px-4">Sunday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriJiunka Phagu Dashami, Chacheri Besha, Sudasha Brata & Dolo Yatra Arambha</td>
                        <td class="py-3 px-4">26/02/2026</td>
                        <td class="py-3 px-4">Thursday</td>
                      </tr>
                      <tr class="bg-gray-50">
                        <td class="py-3 px-4">SriMandirare Papanasini Ekadashi</td>
                        <td class="py-3 px-4">27/02/2026</td>
                        <td class="py-3 px-4">Friday</td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">SriMandirare Rajagnuttsaba Or Mendhapodi</td>
                        <td class="py-3 px-4">02/03/2026</td>
                        <td class="py-3 px-4">Monday</td>
                      </tr>
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
