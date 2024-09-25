@extends('templeuser.layouts.app')

    @section('styles')

		<!-- INTERNAL Select2 css -->
		<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />

		<!-- INTERNAL Data table css -->
		<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.css')}}" rel="stylesheet" />
		<link href="{{asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css')}}"  rel="stylesheet">
		<link href="{{asset('assets/plugins/datatable/responsive.bootstrap5.css')}}" rel="stylesheet" />

    @endsection

    @section('content')

					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div class="left-content">
						<span class="main-content-title mg-b-0 mg-b-lg-1">Add Temple Mandap</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page">Add Temple Mandap</li>
							</ol>
						</div>
					</div>
					<!-- /breadcrumb -->
							@if(session()->has('success'))
							<div class="alert alert-success" id="Message">
								{{ session()->get('success') }}
							</div>
							@endif
						
							@if ($errors->has('danger'))
								<div class="alert alert-danger" id="Message">
									{{ $errors->first('danger') }}
								</div>
							@endif
							
							<!-- row  -->
							<div class="row">
								<div class="col-12 col-sm-12">
									<div class="card">
										{{-- <div class="card-header">
											<h4 class="card-title">Temple About</h4>
										</div> --}}
										<div class="card-body pt-0 pt-4">
                                            <form method="POST" enctype="multipart/form-data" action="{{ route('templemandap.update', $mandap->id) }}">
                                                @csrf
                                                @method('PUT') <!-- Use the PUT method for updating resources -->
                                            
                                                <!-- Mandap Section -->
                                                <div id="mandap_section">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div id="mandap_fields">
                                                                <div class="mandap-field-group">
                                                                    <!-- Mandap Name -->
                                                                    <div class="form-group">
                                                                        <label for="mandap_name">Mandap Name <span style="color:red">*</span></label>
                                                                        <input type="text" class="form-control" name="mandap_name" value="{{ old('mandap_name', $mandap->mandap_name) }}" placeholder="Mandap Name" required>
                                                                    </div>
                                            
                                                                    <!-- Mandap Description -->
                                                                    <div class="form-group">
                                                                        <label for="mandap_description">Mandap Description</label>
                                                                        <textarea class="form-control" name="mandap_description" placeholder="Mandap Description">{{ old('mandap_description', $mandap->mandap_description) }}</textarea>
                                                                    </div>
                                            
                                                                    <!-- Booking Type -->
                                                                    <div class="form-group">
                                                                        <label for="booking_type">Booking Type <span style="color:red">*</span></label>
                                                                        <select name="booking_type" class="form-control booking-type" onchange="toggleEventNameField(this)">
                                                                            <option value="day-basis" {{ $mandap->booking_type == 'day-basis' ? 'selected' : '' }}>Day Basis</option>
                                                                            <option value="event-basis" {{ $mandap->booking_type == 'event-basis' ? 'selected' : '' }}>Event Basis</option>
                                                                        </select>
                                                                    </div>
                                            
                                                                    <!-- Event Name Field (shown only if event-basis is selected) -->
                                                                    <div class="form-group event-name-section" style="{{ $mandap->booking_type == 'event-basis' ? '' : 'display:none;' }}">
                                                                        <label for="event_name">Event Name</label>
                                                                        <input type="text" class="form-control" name="event_name" value="{{ old('event_name', $mandap->event_name) }}" placeholder="Event Name">
                                                                    </div>
                                            
                                                                    <!-- Price Per Day -->
                                                                    <div class="form-group">
                                                                        <label for="price_per_day">Price <span style="color:red">*</span></label>
                                                                        <input type="number" class="form-control" name="price_per_day" value="{{ old('price_per_day', $mandap->price_per_day) }}" placeholder="Price Per Day" required>
                                                                    </div>
                                            
                                                                    <!-- Submit Button -->
                                                                    <button type="submit" class="btn btn-primary mt-3">Update Mandap</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            
										</div>
									</div>
								</div>
							</div>
							<!-- /row closed -->


    @endsection

    @section('scripts')

		<!-- Internal Chart.Bundle js-->
		<script src="{{asset('assets/plugins/chartjs/Chart.bundle.min.js')}}"></script>

		<!-- Moment js -->
		<script src="{{asset('assets/plugins/raphael/raphael.min.js')}}"></script>

		<!-- INTERNAL Apexchart js -->
		<script src="{{asset('assets/js/apexcharts.js')}}"></script>

		<!--Internal Sparkline js -->
		<script src="{{asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>

		<!--Internal  index js -->
		<script src="{{asset('assets/js/index.js')}}"></script>

        <!-- Chart-circle js -->
		<script src="{{asset('assets/js/chart-circle.js')}}"></script>

		<!-- Internal Data tables -->
		<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>

		<!-- INTERNAL Select2 js -->
		<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
		<script src="{{asset('assets/js/select2.js')}}"></script>
	
			<script>


// Function to toggle Event Name field based on booking type selection
function toggleEventNameField(selectElement) {
    var eventNameField = selectElement.closest('.mandap-field-group').querySelector('.event-name-section');
    if (selectElement.value === "event-basis") {
        eventNameField.style.display = "block";
    } else {
        eventNameField.style.display = "none";
    }
}





			</script>
    @endsection
