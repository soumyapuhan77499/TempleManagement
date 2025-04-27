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
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/dham-header.css') }}">

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
    </style>
</head>

<body>

    @include('partials.header-puri-dham')


    <section class="hero">
        
        <img class="hero-bg" src="{{ asset('website/parking.jpeg') }}" alt="Mandir Background" />
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Panji Details</h1>
            <p> This is the detailed view of the Panji where you can explore historic and sacred schedules maintained
                for centuries.
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
                    <div class="mt-6 space-y-4 font-[Inter,sans-serif] text-sm md:text-base" id="panjiContent">
                        @if ($todayPanji)
                            <div class="flex items-start gap-3">
                                <i class="fas fa-calendar-day text-green-600 mt-1 w-5 h-5"></i>
                                <p class="text-gray-800">{{ $todayPanji->event_name ?? 'No Event' }}</p>
                            </div>

                            <div class="flex items-start gap-3">
                                <i class="fas fa-star text-purple-600 mt-1 w-5 h-5"></i>
                                <p class="text-gray-800">Tithi: <span
                                        class="font-medium">{{ $todayPanji->tithi ?? '-' }}</span></p>
                            </div>

                            <div class="flex items-start gap-3">
                                <i class="fas fa-smile text-yellow-500 mt-1 w-5 h-5"></i>
                                <p class="text-gray-800">Yoga: <span
                                        class="font-medium">{{ $todayPanji->yoga ?? '-' }}</span></p>
                            </div>

                            <div class="flex items-start gap-3">
                                <i class="fas fa-adjust text-blue-600 mt-1 w-5 h-5"></i>
                                <p class="text-gray-800">Paksha: <span
                                        class="font-medium">{{ $todayPanji->pakshya ?? '-' }}</span></p>
                            </div>

                            <div class="flex items-start gap-3">
                                <i class="fas fa-clock text-red-400 mt-1 w-5 h-5"></i>
                                <p class="text-gray-800">Sunrise: <span
                                        class="font-medium">{{ $todayPanji->sun_rise ?? '-' }}</span></p>
                            </div>

                            <div class="flex items-start gap-3">
                                <i class="fas fa-moon text-indigo-600 mt-1 w-5 h-5"></i>
                                <p class="text-gray-800">Sunset: <span
                                        class="font-medium">{{ $todayPanji->sun_set ?? '-' }}</span></p>
                            </div>

                            @if ($todayPanji->description)
                                <hr class="border-dashed border-gray-300 my-4">
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-info-circle text-gray-600 mt-1 w-5 h-5"></i>
                                    <p class="text-gray-800">{{ $todayPanji->description }}</p>
                                </div>
                            @endif
                        @else
                            <p class="text-center text-gray-500">No Panji Details Available for Today.</p>
                        @endif
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


    <!-- Calendar Script -->
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
                    html += `
                    <div class="p-2 rounded-full cursor-pointer ${isToday ? "bg-red-500 text-white" : "hover:bg-gray-200"}" data-day="${day}">
                        ${day}
                    </div>
                `;
                }

                html += `</div>`;
                calendarContainer.innerHTML = html;

                document.getElementById("prevMonth").addEventListener("click", () => updateCalendar(year, month -
                    1));
                document.getElementById("nextMonth").addEventListener("click", () => updateCalendar(year, month +
                    1));

                document.querySelectorAll("#calendar div[data-day]").forEach(dayEl => {
                    dayEl.addEventListener("click", function() {
                        // Reset background
                        document.querySelectorAll("#calendar div[data-day]").forEach(el => el
                            .classList.remove("bg-red-500", "text-white"));
                        this.classList.add("bg-red-500", "text-white");

                        const selectedDay = this.getAttribute("data-day");
                        const selectedDate = formatDate(year, month + 1,
                        selectedDay); // month+1 because JS month starts from 0
                        loadPanjiDetails(selectedDate); // 👈 load panji event on date click
                    });
                });
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

            function formatDate(year, month, day) {
                // Format as YYYY-MM-DD (pad zeroes)
                const m = month < 10 ? '0' + month : month;
                const d = day < 10 ? '0' + day : day;
                return `${year}-${m}-${d}`;
            }

            // Ajax Load Panji Details
            function loadPanjiDetails(selectedDate) {
                fetch('{{ route('get.panji.details') }}', {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            date: selectedDate
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        const panjiContent = document.getElementById('panjiContent');
                        if (data) {
                            panjiContent.innerHTML = `
                        <div class="flex items-start gap-3">
                            <i class="fas fa-calendar-day text-green-600 mt-1 w-5 h-5"></i>
                            <p class="text-gray-800">${data.event_name ?? 'No Event'}</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-star text-purple-600 mt-1 w-5 h-5"></i>
                            <p class="text-gray-800">Tithi: <span class="font-medium">${data.tithi ?? '-'}</span></p>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-smile text-yellow-500 mt-1 w-5 h-5"></i>
                            <p class="text-gray-800">Yoga: <span class="font-medium">${data.yoga ?? '-'}</span></p>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-adjust text-blue-600 mt-1 w-5 h-5"></i>
                            <p class="text-gray-800">Paksha: <span class="font-medium">${data.pakshya ?? '-'}</span></p>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-clock text-red-400 mt-1 w-5 h-5"></i>
                            <p class="text-gray-800">Sunrise: <span class="font-medium">${data.sun_rise ?? '-'}</span></p>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-moon text-indigo-600 mt-1 w-5 h-5"></i>
                            <p class="text-gray-800">Sunset: <span class="font-medium">${data.sun_set ?? '-'}</span></p>
                        </div>
                        ${data.description ? `
                            <hr class="border-dashed border-gray-300 my-4">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-info-circle text-gray-600 mt-1 w-5 h-5"></i>
                                <p class="text-gray-800">${data.description}</p>
                            </div>` : ''}
                    `;
                        } else {
                            panjiContent.innerHTML =
                                `<p class="text-center text-gray-500">No Panji Details Available for selected date.</p>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching Panji details:', error);
                    });
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
        < /body>

        <
        /html>
