@extends('templeuser.layouts.app')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet" />
<style>
    #calendar2 {
        width: 100%;
        height: auto;
        min-height: 400px;
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);

    }
    .event-count-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #0004ff; /* Circle background color */
        color: #fff; /* Text color */
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, 10%);
        z-index: 999;
    }
    
    .fc-toolbar {
        background: linear-gradient(90deg, #4CAF50, #03A9F4);
        color: #fff;
        padding: 10px;
        border-radius: 5px;
    }
    .fc-button {
        background: #ee3030 !important;
        color: #fff !important;
        border: none !important;
        text-transform: uppercase;
    }
    .fc-button:hover {
        background: #0288D1 !important;
    }
    .fc-daygrid-day {
        background-color: #f9f9f9;
    }
    .fc-event {
        background: linear-gradient(90deg, #ff5722, #FFC107);
        color: #fff !important;
        border-radius: 5px;
        border: none;
    }
    .today-besha {
    background: linear-gradient(to bottom, #ffffff, #f7f7f7);
    border-radius: 10px;
    padding: 20px;
    margin-top: 85px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border: 2px solid #03A9F4;
}

.today-title {
    font-family: 'Roboto', sans-serif;
    font-weight: bold;
    letter-spacing: 2px;
    color: #03A9F4;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.divider {
    height: 3px;
    background: linear-gradient(90deg, #4CAF50, #03A9F4);
    border: none;
    border-radius: 2px;
    margin: 10px 0;
}

.no-besha {
    font-family: 'Roboto', sans-serif;
    font-size: 14px;
    font-weight: bold;
    color: #FF5722;
    padding: 10px 0;
}

.besha-item {
    background: rgba(3, 169, 244, 0.1);
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 8px;
    border-left: 5px solid #03A9F4;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.besha-item:hover {
    background: rgba(3, 169, 244, 0.2);
    border-left-color: #4CAF50;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.besha-title {
    font-weight: bold;
    font-size: 16px;
    color: #333;
    margin-bottom: 5px;
    text-transform: capitalize;
}

.besha-details {
    font-size: 14px;
    color: #555;
    line-height: 1.5;
}

.besha-details i {
    color: #4CAF50;
    margin-right: 5px;
    font-size: 14px;
}

</style>
@endsection

@section('content')
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <span class="main-content-title mg-b-0 mg-b-lg-1">SHOW BESHA</span>
    </div>
    <div class="justify-content-center mt-2">
        <ol class="breadcrumb d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item active tx-15" aria-current="page">BESHA</li>
        </ol>
    </div>
</div>

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

<div class="pd-b-0 main-content-calendar pt-0">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Calendar View</h3>
                </div>
                <div class="card-body">
                    <div id="calendar2"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class=" shadow-lg">
                <div class=" today-besha">
                    <div class="text-center">
                        <h4 class="today-title">TODAY'S BESHA LIST</h4>
                    </div>
                    <hr class="divider">
                    @if ($todayBeshaList->isEmpty())
                        <p class="text-center no-besha">No Besha available for today.</p>
                    @else
                        @foreach ($todayBeshaList as $besha)
                            <div class="besha-item">
                                <div class="besha-title">{{ $besha->besha_name }}</div>
                                <div class="besha-details">
                                    <span><i class="fas fa-clock"></i> Estimated Time:</span> {{ $besha->estimated_time }}<br>
                                    <span><i class="fas fa-hourglass-half"></i> Duration:</span> {{ $besha->total_time }}
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script>
    $(document).ready(function() {
     console.log('Initializing FullCalendar...'); // Debugging log
 
     // Pass events from controller to JS
     var events = @json($events); 
 
     // Prepare events and group them by date
     var eventCounts = {};
 
     // Loop through events to count the number of events on each date
     events.forEach(function(event) {
         var eventDate = moment(event.start).format('YYYY-MM-DD'); // Format the start date to 'YYYY-MM-DD'
         eventCounts[eventDate] = eventCounts[eventDate] ? eventCounts[eventDate] + 1 : 1;
     });
 
     $('#calendar2').fullCalendar({
         header: {
             left: 'prev,next today',
             center: 'title',
             right: 'month,agendaWeek,agendaDay'
         },
         defaultView: 'month',
         editable: false,
         events: events,
         eventColor: 'transparent', // Event customization
         eventRender: function(event, element) {
             var eventDate = moment(event.start).format('YYYY-MM-DD'); // Get the formatted event date
 
             // Check if there are multiple events on the same day
             if (eventCounts[eventDate]) {
                 // Add a rounded circle with the count of events
                 var count = eventCounts[eventDate];
                 var circle = $('<div class="event-count-circle"></div>').text(count);
                 element.empty(); // Empty the event element
                 element.append(circle); // Append the circle to the event element, no title
             }
         },
         eventClick: function(event) {
             var eventDate = moment(event.start).format('YYYY-MM-DD'); // Get the event date when the circle is clicked
             
             // Redirect to a new page to show the Besha details with the clicked date
             window.location.href = '/templeuser/temple-besha-details/' + eventDate; // Adjust this URL as needed
         }
     });
 
     console.log('FullCalendar initialized successfully.'); // Debugging log
 
     setTimeout(function() {
         $('#Message').fadeOut('slow');
     }, 3000);
 });
 </script>
 
@endsection
