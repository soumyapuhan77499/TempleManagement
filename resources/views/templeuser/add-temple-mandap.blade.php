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
											<form method="POST" enctype="multipart/form-data"  action="{{ route('templemandap.storeMandap') }}" >
												@csrf
												{{-- <div class="row">
													<div class="col-md-12">
														<!-- Checkbox for Mandap -->
														<div class="form-group">
															<input type="checkbox" id="has_mandap" name="has_mandap" onclick="toggleMandapSection()">
															<label for="has_mandap">Does your temple have a mandap?</label>
														</div>
													</div>
												</div> --}}
											
												<!-- Mandap Section - Hidden initially -->
												<div id="mandap_section">
													<div class="row">
														<div class="col-md-12">
															
															<div id="mandap_fields">
																<div class="mandap-field-group">
																	<div class="form-group">
																		<label for="mandap_name">Mandap Name <span style="color:red">*</span></label>
																		<input type="text" class="form-control" name="mandap_name" placeholder="Mandap Name" required>
																	</div>
																	<div class="form-group">
																		<label for="mandap_description">Mandap Description</label>
																		<textarea class="form-control" name="mandap_description" placeholder="Mandap Description"></textarea>
																	</div>
																	<div class="form-group">
																		<label for="booking_type">Booking Type <span style="color:red">*</span></label>
																		<select name="booking_type" class="form-control booking-type" onchange="toggleEventNameField(this)">
																			<option value="day-basis">Day Basis</option>
																			<option value="event-basis">Event Basis</option>
																		</select>
																	</div>
																		<!-- Event Name Field - Hidden initially -->
																	<div class="form-group event-name-section" style="display:none;">
																		<label for="event_name">Event Name</label>
																		<input type="text" class="form-control" name="event_name" placeholder="Event Name">
																	</div>
																	<!-- Price Per Day Field -->
																	<div class="form-group">
																		<label for="price_per_day">Price <span style="color:red">*</span></label>
																		<input type="number" class="form-control" name="price_per_day" placeholder="Price Per Day" required>
																	</div>
																
																</div>
															</div>
															<!-- Button to Add More Mandap Fields -->
															<button type="submit" class="btn btn-primary mt-3">Submit</button>
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


// Function to toggle the Mandap section
function toggleMandapSection() {
    var mandapSection = document.getElementById("mandap_section");
    mandapSection.style.display = document.getElementById("has_mandap").checked ? "block" : "none";
}

// Function to add more Mandap fields dynamically
function addMandapFields() {
    var mandapFields = document.getElementById("mandap_fields");
    var newMandap = `
        <div class="mandap-field-group">
            <div class="form-group">
                <label for="mandap_name">Mandap Name</label>
                <input type="text" class="form-control" name="mandap_name[]" placeholder="Mandap Name">
            </div>
            <div class="form-group">
                <label for="mandap_description">Mandap Description</label>
                <textarea class="form-control" name="mandap_description[]" placeholder="Mandap Description"></textarea>
            </div>
            <div class="form-group">
                <label for="booking_type">Booking Type</label>
                <select name="booking_type[]" class="form-control booking-type" onchange="toggleEventNameField(this)">
                    <option value="day-basis">Day Basis</option>
                    <option value="event-basis">Event Basis</option>
                </select>
            </div>
            <!-- Price Per Day Field -->
            <div class="form-group">
                <label for="price_per_day">Price</label>
                <input type="number" class="form-control" name="price_per_day[]" placeholder="Price Per Day">
            </div>
            <!-- Event Name Field - Hidden initially -->
            <div class="form-group event-name-section" style="display:none;">
                <label for="event_name">Event Name</label>
                <input type="text" class="form-control" name="event_name[]" placeholder="Event Name">
            </div>
            <button type="button" class="btn btn-danger remove-mandap" onclick="removeMandapField(this)">Remove</button>
        </div>
    `;
    mandapFields.insertAdjacentHTML("beforeend", newMandap);
}

// Function to toggle Event Name field based on booking type selection
function toggleEventNameField(selectElement) {
    var eventNameField = selectElement.closest('.mandap-field-group').querySelector('.event-name-section');
    if (selectElement.value === "event-basis") {
        eventNameField.style.display = "block";
    } else {
        eventNameField.style.display = "none";
    }
}

// Function to remove Mandap field group
function removeMandapField(element) {
    element.closest('.mandap-field-group').remove();
}



			</script>
    @endsection
