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
                    <form id="eventForm" action="{{ route('templeuser.savePanji') }}" method="POST">

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
                                <input type="text" class="form-control" id="event_name" name="event_name"
                                    placeholder="Enter Event Name">
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
                            <div class="col-md-6 mb-3">
                                <label for="pakshya" class="form-label">Pakshya</label>
                                <input type="text" class="form-control" id="pakshya" name="pakshya"
                                    placeholder="Enter Pakshya">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="karana" class="form-label">Karana</label>
                                <input type="text" class="form-control" id="karana" name="karana"
                                    placeholder="Enter Karana">
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
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            dateClick: function (info) {
                resetFormFields();
                document.getElementById('eventDate').value = info.dateStr;
                document.getElementById('selectedDate').textContent = info.dateStr;
                document.getElementById('eventForm').action = "{{ route('templeuser.savePanji') }}";
                removeMethodField();

                const modal = new bootstrap.Modal(document.getElementById('addEventModal'));
                modal.show();
            },
            eventClick: function (info) {
                const event = info.event;
                const props = event.extendedProps;

                document.getElementById('eventDate').value = event.startStr;
                document.getElementById('selectedDate').textContent = event.startStr;
                document.getElementById('language').value = props.language || '';
                document.getElementById('event_name').value = props.event_name || event.title || '';
                document.getElementById('tithi').value = props.tithi || '';
                document.getElementById('nakshatra').value = props.nakshatra || '';
                document.getElementById('yoga').value = props.yoga || '';
                document.getElementById('pakshya').value = props.pakshya || '';
                document.getElementById('karana').value = props.karana || '';
                document.getElementById('sun_set').value = props.sun_set || '';
                document.getElementById('sun_rise').value = props.sun_rise || '';
                document.getElementById('good_time').value = props.good_time || '';
                document.getElementById('bad_time').value = props.bad_time || '';
                document.getElementById('eventDescription').value = props.description || '';

                document.getElementById('eventForm').action = `/admin/update-panji/${event.id}`;
                setMethodField(); // Set method override for Laravel PUT

                const modal = new bootstrap.Modal(document.getElementById('addEventModal'));
                modal.show();
            },
            events: [
                @foreach($events as $event)
                    {!! json_encode([
                        'id' => $event->id,
                        'title' => $event->event_name,
                        'start' => $event->date,
                        'description' => $event->description,
                        'language' => $event->language,
                        'event_name' => $event->event_name,
                        'tithi' => $event->tithi,
                        'nakshatra' => $event->nakshatra,
                        'yoga' => $event->yoga,
                        'pakshya' => $event->pakshya,
                        'karana' => $event->karana,
                        'sun_set' => $event->sun_set,
                        'sun_rise' => $event->sun_rise,
                        'good_time' => $event->good_time,
                        'bad_time' => $event->bad_time,
                        'backgroundColor' => '#28a745',
                        'borderColor' => '#28a745',
                    ]) !!},
                @endforeach
            ]
        });

        calendar.render();

        function resetFormFields() {
            const ids = ['language', 'event_name', 'tithi', 'nakshatra', 'yoga', 'pakshya', 'karana', 'sun_set', 'sun_rise', 'good_time', 'bad_time', 'eventDescription'];
            ids.forEach(id => document.getElementById(id).value = '');
        }

        function setMethodField() {
            if (!document.getElementById('_method')) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = '_method';
                input.value = 'PUT';
                input.id = '_method';
                document.getElementById('eventForm').appendChild(input);
            }
        }

        function removeMethodField() {
            const input = document.getElementById('_method');
            if (input) input.remove();
        }

        const form = document.getElementById('eventForm');
        if (form) {
            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                const formData = new FormData(this);
                const actionUrl = this.action;
                const isUpdate = actionUrl.includes('/update-panji/');
                const csrfToken = document.querySelector('input[name="_token"]').value;

                try {
                    const response = await fetch(actionUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    });

                    if (!response.ok) throw new Error('Network error');

                    // Hide modal
                    bootstrap.Modal.getInstance(document.getElementById('addEventModal')).hide();

                    // Refresh calendar (optionally: refetchEvents from server)
                    const date = formData.get('date');
                    const language = formData.get('language');
                    const title = formData.get('event_name') + ' (' + language + ')';

                    if (isUpdate) {
                        const id = actionUrl.split('/').pop();
                        const event = calendar.getEventById(id);
                        if (event) {
                            event.setProp('title', title);
                            event.setStart(date);
                        }
                    } else {
                        calendar.addEvent({
                            title: title,
                            start: date,
                            backgroundColor: '#28a745',
                            borderColor: '#28a745'
                        });
                    }

                    this.reset();
                    removeMethodField();
                } catch (err) {
                    console.error(err);
                    alert('Failed to save event.');
                }
            });
        }
    });
    
</script>

@endsection