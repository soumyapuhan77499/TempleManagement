@extends('templeuser.layouts.app')

@section('styles')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

    <style>
        #calendar {
            width: 100%;
            margin: 0 auto;
            position: relative;
            top: 20px;
        }

        /* Event Count Styling */
        .fc-daygrid-day .event-count {
            background-color: #7e33ff;
            color: white;
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 14px;
            position: absolute;
            top: 5px;
            right: 5px;
            text-align: center;
            font-weight: bold;
            width: 80px;
            box-sizing: border-box;
            z-index: 10;
        }

        /* Event Title Font Size */
        .fc-event-title {
            font-size: 10px;
            color: #fff;
            padding: 5px;
        }

        /* Day Number Font Size */
        .fc-daygrid-day-number {
            font-size: 14px;
        }

        /* Day Name Font Size */
        .fc-daygrid-day-top {
            font-size: 14px;
        }
    </style>
@endsection

@section('content')
    <div class="col-xl-12 mt-4">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-9">
                                <h3 class="text-dark">
                                    {{ Auth::guard('temples')->user()->temple_title }}
                                    <span class="text-primary">
                                        {{ \Illuminate\Support\Str::title(Auth::guard('temples')->user()->temple_name) }}!
                                    </span>
                                </h3>
                                <p>Your temple profile completion is {{ $completionPercentage }}%. Upgrade to access
                                    exclusive features.</p>
                                <button class="btn btn-primary">Upgrade Profile</button>
                            </div>
                            <div class="col-xl-3 d-flex justify-content-center">
                                <div class="chart-circle" data-value="{{ $completionPercentage / 100 }}">
                                    <canvas width="100" height="100"></canvas>
                                    <div class="chart-circle-value">{{ $completionPercentage }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center" style="font-family: fantasy;">POOJA CALENDAR</h4>
                        <hr>
                        <div class="text-center mb-3">
                            <button id="showSpecialRituals" class="btn btn-warning">Show Special Rituals</button>
                            <button id="showDailyRituals" class="btn btn-info">Show Daily Rituals</button>
                        </div>
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body" style="background-color: rgba(0,10,80,0.2)">
                        <div class="text-center">
                            <h4 style="font-family: fantasy; letter-spacing: 1px;">EVENTS FOR {{ \Carbon\Carbon::today()->format('d M Y') }}</h4>

                        </div>
                        <hr>
            
                        @if($festivals->isEmpty() && $specialRituals->isEmpty())
                            <p>No events or special rituals today.</p>
                        @else
                            <h5 style="font-family: cursive; color:red">Festivals</h5>
                            @if($festivals->isEmpty())
                                <p>No festivals today.</p>
                            @else
                                <ul>
                                    @foreach($festivals as $festival)
                                        <li>
                                            <strong>Festival Name:</strong> {{ $festival->festival_name }}<br>
                                        </li>
                                        <hr>
                                    @endforeach
                                </ul>
                            @endif
            
                            <h5 style="font-family: cursive;color: red">Special Rituals</h5>
                            @if($specialRituals->isEmpty())
                                <p>No special rituals today.</p>
                            @else
                                <ul>
                                    @foreach($today_rituals as $today_ritual)
                                        <li>
                                             {{ $today_ritual->spcl_ritual_name }}<br>
                                        </li>
                                        <hr>
                                    @endforeach
                                </ul>
                            @endif

                            
                            <h5 style="font-family: cursive;color: red">Daily Rituals</h5>
                            @if($specialRituals->isEmpty())
                                <p>No rituals today.</p>
                            @else
                                <ul>
                                    @foreach($rituals as $ritual)
                                        <li>
                                            {{ $ritual->ritual_name }}-<span style="color: blue">({{ $ritual->ritual_start_time }})</span><br>
                                        </li>
                                        <hr>
                                    @endforeach
                                </ul>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Ritual Modal -->
    <div class="modal fade" id="ritualModal" tabindex="-1" aria-labelledby="ritualModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ritualModalLabel">Ritual Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul id="ritualList"></ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var rituals = @json($rituals);
            var specialRituals = @json($specialRituals);
            var assetBaseUrl = "{{ asset('') }}";

            // Initialize FullCalendar with month view for special rituals
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Set to month view initially for special rituals
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [], // Events to be set later dynamically
                eventClick: function(info) {
                    var rituals = info.event.extendedProps.rituals ||
                []; // Get rituals from extendedProps
                    if (rituals.length === 0) { // Special ritual case
                        var ritualDetails = `
                            <strong>Special Ritual Name:</strong> ${info.event.title}<br>
                            <strong>Time:</strong> ${info.event.extendedProps.time}<br>
                            <strong>Tithi:</strong> ${info.event.extendedProps.tithi}<br><br>
                            <img src="${assetBaseUrl}${info.event.extendedProps.image}" style="width: 100px; height: 100px;" alt="${info.event.title}">
                        `;
                        document.getElementById('ritualList').innerHTML = ritualDetails;
                    } else { // Daily ritual case
                        var ritualList = document.getElementById('ritualList');
                        ritualList.innerHTML = ''; // Clear previous data

                        rituals.forEach(function(ritual) {
                            var listItem = document.createElement('li');
                            listItem.innerHTML = `
                        <strong>Ritual Name:</strong> ${ritual.ritual_name}<br>
                        <strong>Time:</strong> ${ritual.ritual_start_time} - ${ritual.ritual_end_time}<br>
                        <strong>Duration:</strong> ${ritual.ritual_duration}<br><br>
                        <img src="${assetBaseUrl}${ritual.ritual_image}" style="width: 100px; height: 100px; object-fit: cover;" alt="${ritual.ritual_name}">
                    `;
                            ritualList.appendChild(listItem);
                        });

                    }
                    var modal = new bootstrap.Modal(document.getElementById('ritualModal'));
                    modal.show();
                }
            });

            // Load daily rituals and special rituals
            function loadDailyRituals() {
                var dayGroupedRituals = groupRitualsByDay(rituals);
                var dailyEventArray = prepareDailyEvents(dayGroupedRituals);
                calendar.removeAllEvents();
                calendar.addEventSource(dailyEventArray);
            }

            function loadSpecialRituals() {
                var specialEventArray = prepareSpecialEvents(specialRituals);
                calendar.removeAllEvents();
                calendar.addEventSource(specialEventArray);
            }

            function groupRitualsByDay(rituals) {
                return rituals.reduce(function(acc, ritual) {
                    var day = ritual.ritual_day_name;
                    if (!acc[day]) acc[day] = [];
                    acc[day].push(ritual);
                    return acc;
                }, {});
            }

            function prepareDailyEvents(dayGroupedRituals) {
                return Object.keys(dayGroupedRituals).map(function(day) {
                    return {
                        title: dayGroupedRituals[day].length + ' Rituals on ' + day,
                        startRecur: day, // Recurring event based on day
                        allDay: true,
                        daysOfWeek: [getDayNumber(day)], // FullCalendar day number
                        extendedProps: {
                            rituals: dayGroupedRituals[day] // Attach rituals for modal
                        }
                    };
                });
            }

            function prepareSpecialEvents(specialRituals) {
                return specialRituals.map(function(ritual) {
                    return {
                        title: ritual.spcl_ritual_name,
                        start: ritual.spcl_ritual_date,
                        allDay: true,
                        extendedProps: {
                            time: ritual.spcl_ritual_time,
                            tithi: ritual.spcl_ritual_tithi,
                            image: ritual.spcl_ritual_image,
                            description: ritual.description
                        }
                    };
                });
            }

            function getDayNumber(dayName) {
                const days = {
                    Sunday: 0,
                    Monday: 1,
                    Tuesday: 2,
                    Wednesday: 3,
                    Thursday: 4,
                    Friday: 5,
                    Saturday: 6
                };
                return days[dayName];
            }

            // Button Event Listeners
            document.getElementById('showDailyRituals').addEventListener('click', function() {
                calendar.changeView('timeGridWeek'); // Switch to weekly view for daily rituals
                loadDailyRituals();
            });

            document.getElementById('showSpecialRituals').addEventListener('click', function() {
                calendar.changeView('dayGridMonth'); // Switch to month view for special rituals
                loadSpecialRituals();
            });

            calendar.render();
            loadSpecialRituals(); // Load special rituals by default on initial load
        });
    </script>
@endsection
