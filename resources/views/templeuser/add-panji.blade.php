@extends('templeuser.layouts.app')

@section('styles')
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <!-- Modal CSS (Bootstrap) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">ADD PANJI</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
              
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active tx-15" aria-current="page">PANJI</li>
            </ol>
        </div>
    </div>
    <!-- End Breadcrumb -->

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success" id="Message">
            {{ session()->get('success') }}
        </div>
    @endif

    @if ($errors->has('danger'))
        <div class="alert alert-danger" id="Message">
            {{ $errors->first('danger') }}
        </div>
    @endif

    <div class="pd-b-0 main-content-calendar pt-0">
        <!-- Row -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center" style="font-family: fantasy;padding:20px;">PANJI CALENDAR</h4>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header custom-header text-center" style="background-color: rgb(168, 245, 227)">
                    <h5 class="modal-title w-100" style="color: rgb(7, 7, 7);" id="addEventModalLabel">
                        PANJI DETAILS FOR <span id="selectedDate"></span>
                    </h5>
                </div>
                <!-- Body -->
                <div class="modal-body">
                    <form action="{{ route('templeuser.savePanji') }}" method="POST">
                        @csrf

                        <input type="hidden" id="eventDate" name="date">

                        <div class="row">
                            <!-- Language Selection -->
                            <div class="col-md-6 mb-3">
                                <label for="language" class="form-label">Select Language</label>
                                <select class="form-control" id="language" name="language">
                                    <option value="">Select language...</option>
                                    <option value="English">English</option>
                                    <option value="Hindi">Hindi</option>
                                    <option value="Odia">Odia</option>
                                </select>
                            </div>

                            <!-- Event Name -->
                            <div class="col-md-6 mb-3">
                                <label for="event_name" class="form-label">Event Name</label>
                                <input type="text" class="form-control" id="event_name" name="event_name" placeholder="Enter Event Name">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Tithi -->
                            <div class="col-md-6 mb-3">
                                <label for="tithi" class="form-label">Tithi</label>
                                <input type="text" class="form-control" id="tithi" name="tithi"
                                    placeholder="Enter Tithi">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nakshatra" class="form-label">Nakshatra</label>
                                <input type="text" class="form-control" id="nakshatra" name="nakshatra"
                                    placeholder="Enter Nakshatra">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Sun Set -->
                            <div class="col-md-6 mb-3">
                                <label for="sun_set" class="form-label">Sun Set</label>
                                <input type="time" class="form-control" id="sun_set" name="sun_set">
                            </div>
                            <!-- Sun Rise -->
                            <div class="col-md-6 mb-3">
                                <label for="sun_rise" class="form-label">Sun Rise</label>
                                <input type="time" class="form-control" id="sun_rise" name="sun_rise">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Good Time -->
                            <div class="col-md-6 mb-3">
                                <label for="good_time" class="form-label">Good Time</label>
                                <input type="text" class="form-control" id="good_time" name="good_time"
                                    placeholder="Enter Good Time">
                            </div>
                            <!-- Bad Time -->
                            <div class="col-md-6 mb-3">
                                <label for="bad_time" class="form-label">Bad Time</label>
                                <input type="text" class="form-control" id="bad_time" name="bad_time"
                                    placeholder="Enter Bad Time">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="yoga" class="form-label">Yoga</label>
                                <input type="text" class="form-control" id="yoga" name="yoga"
                                    placeholder="Enter Yoga">
                            </div>
                        </div>
                        <!-- Description -->
                        <div class="mb-3">
                            <label for="eventDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="eventDescription" name="description" rows="2"></textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success me-2">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
    
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                dateClick: function(info) {
                    // Set the selected date in the hidden input and header
                    document.getElementById('eventDate').value = info.dateStr;
                    document.getElementById('selectedDate').textContent = info.dateStr;
    
                    // Reset form fields for new event
                    resetFormFields();
    
                    // Show the modal for new event
                    var addEventModal = new bootstrap.Modal(document.getElementById('addEventModal'));
                    addEventModal.show();
                },
                eventClick: function(info) {
                    // Set the modal to edit mode and populate fields with clicked event data
                    document.getElementById('eventDate').value = info.event.startStr; // Set the date
                    document.getElementById('selectedDate').textContent = info.event.startStr; // Display the date
                    document.getElementById('language').value = info.event.extendedProps.language; // Set language
                    document.getElementById('event_name').value = info.event.title; // Set event name
                    document.getElementById('tithi').value = info.event.extendedProps.tithi; // Set tithi
                    document.getElementById('nakshatra').value = info.event.extendedProps.nakshatra; // Set nakshatra
                    document.getElementById('yoga').value = info.event.extendedProps.yoga; // Set yoga
                    document.getElementById('sun_set').value = info.event.extendedProps.sun_set; // Set sun set time
                    document.getElementById('sun_rise').value = info.event.extendedProps.sun_rise; // Set sun rise time
                    document.getElementById('good_time').value = info.event.extendedProps.good_time; // Set good time
                    document.getElementById('bad_time').value = info.event.extendedProps.bad_time; // Set bad time
                    document.getElementById('eventDescription').value = info.event.extendedProps.description; // Set description
    
                    // Change form action to update the event
                    document.getElementById('addEventModal').querySelector('form').action = "/admin/update-panji/" + info.event.id;
    
                    // Show the modal
                    var addEventModal = new bootstrap.Modal(document.getElementById('addEventModal'));
                    addEventModal.show();
                },
                events: [
                    @foreach($events as $event)
                        {
                            id: '{{ $event->id }}',
                            title: '{{ $event->event_name }}',
                            start: '{{ $event->date }}',
                            description: '{{ $event->description }}',
                            language: '{{ $event->language }}',
                            tithi: '{{ $event->tithi }}',
                            nakshatra: '{{ $event->nakshatra }}',
                            yoga: '{{ $event->yoga }}',
                            sun_set: '{{ $event->sun_set }}',
                            sun_rise: '{{ $event->sun_rise }}',
                            good_time: '{{ $event->good_time }}',
                            bad_time: '{{ $event->bad_time }}',
                            backgroundColor: '#28a745',
                            borderColor: '#28a745'
                        },
                    @endforeach
                ]
            });
    
            calendar.render();
    
            // Reset form fields for new event
            function resetFormFields() {
                document.getElementById('language').value = '';
                document.getElementById('event_name').value = '';
                document.getElementById('tithi').value = '';
                document.getElementById('nakshatra').value = '';
                document.getElementById('yoga').value = '';
                document.getElementById('sun_set').value = '';
                document.getElementById('sun_rise').value = '';
                document.getElementById('good_time').value = '';
                document.getElementById('bad_time').value = '';
                document.getElementById('eventDescription').value = '';
            }
    
            // Handle form submission
            document.getElementById('eventForm').addEventListener('submit', function(e) {
                e.preventDefault();
    
                // Collect form data
                var eventDate = document.getElementById('eventDate').value;
                var language = document.getElementById('language').value;
                var eventName = document.getElementById('event_name').value;
                var description = document.getElementById('eventDescription').value;
    
                // Add event to calendar
                calendar.addEvent({
                    title: eventName + ' (' + language + ')',
                    start: eventDate,
                    description: description,
                    backgroundColor: '#28a745', // Green background for the saved event
                    borderColor: '#28a745'
                });
    
                // Reset the form and hide the modal
                this.reset();
                var addEventModal = bootstrap.Modal.getInstance(document.getElementById('addEventModal'));
                addEventModal.hide();
            });
        });
    </script>
    
    
@endsection
