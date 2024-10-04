@extends('templeuser.layouts.app')

    @section('styles')

		<!-- INTERNAL Select2 css -->
		<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />

		<!-- INTERNAL Data table css -->
		
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
        font-size: 14px; /* Adjust font size as needed */
        color: #fff; /* Adjust text color as needed */
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
					<!-- row -->
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-4">
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 col-xs-12">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-xl-9 col-lg-7 col-md-6 col-sm-12">
												<div class="text-justified align-items-center">
													<h3 class="text-dark font-weight-semibold mb-2 mt-0">
														Hi, Welcome Back 
														<span class="text-primary">
															{{ Auth::guard('temples')->user()->temple_name }}!
														</span>
													</h3>
													
													<p class="text-dark tx-14 mb-3 lh-3"> You have used the 85% of free plan storage. Please upgrade your plan to get unlimited storage.</p>
													<button class="btn btn-primary shadow">Upgrade Now</button>
												</div>
											</div>
											<div class="col-xl-3 col-lg-5 col-md-6 col-sm-12 d-flex align-items-center justify-content-center">
												<div class="chart-circle float-md-end mt-4 mt-md-0" data-value="0.85" data-thickness="8" data-color=""><canvas width="100" height="100"></canvas>
													<div class="chart-circle-value circle-style"><div class="tx-18 font-weight-semibold">85%</div></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						
						</div>
					</div>
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<div class="row">
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
									<div class="row">
											<div class="text-center pt-4">
												
												<h4 style="font-family: fantasy;letter-spacing: 2px">POOJA CALENDAR</h4>
											</div>
											<div id="calendar"></div>
										</div>
								</div>
								
							</div>
						</div>
					</div>
					<!-- row closed -->

					  <!-- Modal -->
					  <div class="modal fade" id="ritualModal" tabindex="-1" role="dialog" aria-labelledby="ritualModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="ritualModalLabel">Special Rituals</h5>
									<!-- Updated close button for Bootstrap 5 -->
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<ul id="ritualList"></ul>
								</div>
								<div class="modal-footer">
									<!-- Updated button for Bootstrap 5 -->
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
					

    @endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<!-- Bootstrap JS -->

<!-- Correct Bootstrap 5 JS Bundle with Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


<script>
    // Ensure the asset base URL is correct. This is the full URL to your 'public' directory.
    var assetBaseUrl = "{{ asset('') }}"; // Outputs something like 'http://yourdomain.com/' or 'http://localhost/'

    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var rituals = @json($specialRituals);

        // Create events array by iterating over rituals and grouping by date
        var events = rituals.reduce(function (acc, ritual) {
            var date = ritual.spcl_ritual_date;
            if (!acc[date]) {
                acc[date] = [];
            }
            acc[date].push({
                name: ritual.spcl_ritual_name,
                tithi: ritual.spcl_ritual_tithi,
                time: ritual.spcl_ritual_time + ' ' + ritual.spcl_ritual_period,
                image: ritual.spcl_ritual_image // Assuming this holds the relative image path
            });
            return acc;
        }, {});

        // Map to eventArray for FullCalendar
        var eventArray = Object.keys(events).map(function (date) {
            return {
                title: events[date].length + ' Special Rituals',
                start: date,
                extendedProps: {
                    rituals: events[date]
                }
            };
        });

        // Initialize the FullCalendar
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: eventArray,
            eventClick: function (info) {
                var rituals = info.event.extendedProps.rituals;
                var modal = new bootstrap.Modal(document.getElementById('ritualModal'));
                var ritualList = document.getElementById('ritualList');
                ritualList.innerHTML = '';

                // Populate modal with ritual details
                rituals.forEach(function (ritual) {
                    var listItem = document.createElement('li');
                    listItem.innerHTML = `
                        <strong>Ritual Name:</strong> ${ritual.name}<br>
                        <strong>Tithi:</strong> ${ritual.tithi}<br>
                        <strong>Time:</strong> ${ritual.time}<br><br>
                        <img src="${assetBaseUrl}${ritual.image}" style="width: 100px; height: 100px; object-fit: cover;" alt="${ritual.name}">
                    `;
                    ritualList.appendChild(listItem);
                });

                modal.show();
            },
            eventDidMount: function (info) {
                var el = info.el.querySelector('.fc-event-title');
                if (el) {
                    el.style.fontSize = '14px';
                    el.style.color = '#fff';
                }
            }
        });
        calendar.render();
    });
</script>


 @endsection
