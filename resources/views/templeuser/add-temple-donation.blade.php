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
						<span class="main-content-title mg-b-0 mg-b-lg-1">Add Donation</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page">Add Donation</li>
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
							  <!-- Display validation errors -->
							@if ($errors->any())
							<div class="alert alert-danger" id="Message">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
							@endif
							<!-- row  -->
							<div class="row mt-4">
								<div class="col-lg-12 col-md-12">
									<div class="card overflow-hidden">
										<div class="card-header pb-0">
											<h2 class="card-title">ADD DONATIONS</h2>
										</div>
										<!-- Card Body -->
										<div class="card-body">
											<div class="panel-group1" id="accordion11" role="tablist">
												<!-- Accordion for Sunday -->
												<div class="card overflow-hidden">
													<a class="accordion-toggle panel-heading1 collapsed" 
													   data-bs-toggle="collapse" 
													   data-bs-parent="#accordion11" 
													   href="#collapseDay0" 
													   aria-expanded="false" 
													   style="font-size: 25px; font-weight: bold; color: black; background-color: rgb(196, 231, 251)">
														Cash Donations
													</a>
													<div id="collapseDay0" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
														<div class="panel-body">
															<div class="row row-sm">
																<div class="col-lg-12 col-md-12">
																	<div class="custom-card main-content-body-profile">
																		<div class="main-content-body tab-pane border-top-0" id="bank">
																			<!-- Ritual Form -->
																			<form action="{{route('templedonation.storeCashDonation')}}" method="post" enctype="multipart/form-data" id="ritual-form" style="background-color: rgba(21, 225, 244, 0.2); padding: 15px;">
																				@csrf
																				<div id="form-container">
																					<div class="form-group-wrapper">
																						<div class="row">
																							
							
																							<!-- Donated By -->
																							<div class="col-md-4">
																								<div class="form-group">
																									<label for="donated_by">Donated By</label>
																									<input type="text" class="form-control" name="donated_by" placeholder="Enter your name">
																								</div>
																							</div>
							
																							<!-- Amount -->
																							<div class="col-md-4">
																								<div class="form-group">
																									<label for="amount">Amount</label>
																									<input type="number" class="form-control" name="donation_amount" placeholder="Enter amount" min="1">
																								</div>
																							</div>
							
																							<!-- Date & Time -->
																							<div class="col-md-4">
																								<div class="form-group">
																									<label for="donation_date_time">Date & Time</label>
																									<div class="input-group">
																										<input type="datetime-local" class="form-control" name="donation_date_time">
																									</div>
																								</div>
																							</div>
							
																							<!-- Phone Number -->
																							<div class="col-md-4">
																								<div class="form-group">
																									<label for="phone_number">Phone Number</label>
																									<input type="tel" class="form-control" name="phone_number" placeholder="Enter phone number" pattern="[0-9]{10}">
																								</div>
																							</div>
							
																							<!-- Address -->
																							<div class="col-md-4">
																								<div class="form-group">
																									<label for="address">Address</label>
																									<input type="text" class="form-control" name="address" placeholder="Enter your address">
																								</div>
																							</div>

																							<div class="col-md-4">
																								<div class="form-group">
																									<label for="address">Pan Card</label>
																									<input type="text" class="form-control" name="pan_card" placeholder="Enter your Pan Card">
																								</div>
																							</div>
																	
																						</div>
																					</div>
																				</div>
																				<!-- Add and Submit Buttons -->
																				<div class="text-center col-md-12">
																					<button type="submit" class="btn btn-primary">Save Donations</button>
																				</div>
																			</form>
																			<!-- End of Ritual Form -->
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!-- End of Accordion for Sunday -->
											</div>
											<div class="panel-group1" id="accordion12" role="tablist">
												<!-- Accordion for Sunday -->
												<div class="card overflow-hidden">
													<a class="accordion-toggle panel-heading1 collapsed" 
													   data-bs-toggle="collapse" 
													   data-bs-parent="#accordion12" 
													   href="#collapseDay1" 
													   aria-expanded="false" 
													   style="font-size: 25px; font-weight: bold; color: black; background-color: rgb(196, 231, 251)">
														Online Donations ( Cheque / UPI)
													</a>
													<div id="collapseDay1" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
														<div class="panel-body">
															<div class="row row-sm">
																<div class="col-lg-12 col-md-12">
																	<div class="custom-card main-content-body-profile">
																		<div class="main-content-body tab-pane border-top-0" id="bank">
																			<!-- Ritual Form -->
																			<form action="{{route('templedonation.storeonlineDonation')}}" method="post" enctype="multipart/form-data" id="ritual-form" style="background-color: rgba(21, 225, 244, 0.2); padding: 15px;">
																				 @csrf  
																				<div id="form-container">
																					<div class="form-group-wrapper">
																						<div class="row">
																							
							
																							<!-- Donated By -->
																							<div class="col-md-4">
																								<div class="form-group">
																									<label for="donated_by">Donated By</label>
																									<input type="text" class="form-control" name="donated_by" placeholder="Enter your name">
																								</div>
																							</div>
							
																							<!-- Amount -->
																							<div class="col-md-4">
																								<div class="form-group">
																									<label for="amount">Amount</label>
																									<input type="number" class="form-control" name="donation_amount" placeholder="Enter amount" min="1">
																								</div>
																							</div>
							
																							<!-- Date & Time -->
																							<div class="col-md-4">
																								<div class="form-group">
																									<label for="donation_date_time">Date & Time</label>
																									<div class="input-group">
																										<input type="datetime-local" class="form-control" name="donation_date_time">
																									</div>
																								</div>
																							</div>
							
																							<!-- Phone Number -->
																							<div class="col-md-4">
																								<div class="form-group">
																									<label for="phone_number">Phone Number</label>
																									<input type="tel" class="form-control" name="phone_number" placeholder="Enter phone number" pattern="[0-9]{10}">
																								</div>
																							</div>
							
																							<!-- Address -->
																							<div class="col-md-4">
																								<div class="form-group">
																									<label for="address">Address</label>
																									<input type="text" class="form-control" name="address" placeholder="Enter your address">
																								</div>
																							</div>
																							<div class="form-group col-md-4">
																								<label for="payment_mode">Payment Mode <span style="color:red">*</span></label>
																								<select name="payment_mode" class="form-control" id="payment_mode" onchange="togglePaymentIdField()" required>
																									
																									<option value="UPI">UPI</option>
																									<option value="IMPS">IMPS</option>
																									<option value="CHEQUE">CHEQUE</option>
																								</select>
																							</div>
																							<div class="form-group col-md-4" id="payment_id_field">
																								<label for="payment_number" id="payment_id_label">Payment Number <span style="color:red">*</span></label>
																								<input type="text" class="form-control" name="payment_number" id="payment_id" placeholder="" required>
																							</div>
																	
																						</div>
																					</div>
																				</div>
																				<!-- Add and Submit Buttons -->
																				<div class="text-center col-md-12">
																					<button type="submit" class="btn btn-primary">Save Donations</button>
																				</div>
																			</form>
																			<!-- End of Ritual Form -->
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!-- End of Accordion for Sunday -->
											</div>
											<div class="panel-group1" id="accordion13" role="tablist">
												<!-- Accordion for Sunday -->
												<div class="card overflow-hidden">
													<a class="accordion-toggle panel-heading1 collapsed" 
													   data-bs-toggle="collapse" 
													   data-bs-parent="#accordion13" 
													   href="#collapseDay2" 
													   aria-expanded="false" 
													   style="font-size: 25px; font-weight: bold; color: black; background-color: rgb(196, 231, 251)">
														Item Donations 
													</a>
													<div id="collapseDay2" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
														<div class="panel-body">
															<div class="row row-sm">
																<div class="col-lg-12 col-md-12">
																	<div class="custom-card main-content-body-profile">
																		<div class="main-content-body tab-pane border-top-0" id="bank">
																			<!-- Ritual Form -->
																			<form action="{{route('templedonation.storeitemDonation')}}" method="post" enctype="multipart/form-data" id="ritual-form" style="background-color: rgba(21, 225, 244, 0.2); padding: 15px;">
																				   @csrf
																				<div id="form-container">
																					<div class="form-group-wrapper">
																						<div class="row">
																							
							
																							<!-- Donated By -->
																							<div class="col-md-4">
																								<div class="form-group">
																									<label for="donated_by">Donated By</label>
																									<input type="text" class="form-control" name="donated_by" placeholder="Enter your name">
																								</div>
																							</div>
							
																							<!-- Amount -->
																							<div class="col-md-4">
																								<div class="form-group">
																									<label for="amount">Item Name</label>
																									<input type="text" class="form-control" name="item_name" placeholder="Enter Item Name">
																								</div>
																							</div>
																							<div class="col-md-4">
																								<div class="form-group">
																									<label for="address">Quantity</label>
																									<input type="text" class="form-control" name="quantity" placeholder="Enter your Quantity">
																								</div>
																							</div>
																							<!-- Date & Time -->
																							<div class="col-md-4">
																								<div class="form-group">
																									<label for="donation_date_time">Date & Time</label>
																									<div class="input-group">
																										<input type="datetime-local" class="form-control" name="donation_date_time">
																									</div>
																								</div>
																							</div>
							
																							<!-- Phone Number -->
																							<div class="col-md-4">
																								<div class="form-group">
																									<label for="phone_number">Phone Number</label>
																									<input type="tel" class="form-control" name="phone_number" placeholder="Enter phone number" pattern="[0-9]{10}">
																								</div>
																							</div>
							
																							<!-- Address -->
																							<div class="col-md-4">
																								<div class="form-group">
																									<label for="address">Address</label>
																									<input type="text" class="form-control" name="address" placeholder="Enter your address">
																								</div>
																							</div>

																						

																							<div class="col-md-4">
																								<div class="form-group">
																									<label for="address">Item Image</label>
																									<input type="file" class="form-control" name="item_image">
																								</div>
																							</div>
																	
																						</div>
																					</div>
																				</div>
																				<!-- Add and Submit Buttons -->
																				<div class="text-center col-md-12">
																					<button type="submit" class="btn btn-primary">Save Donations</button>
																				</div>
																			</form>
																			<!-- End of Ritual Form -->
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!-- End of Accordion for Sunday -->
											</div>
										</div>
										<!-- End of Card Body -->
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
			function togglePaymentIdField() {
				var paymentMode = document.getElementById("payment_mode").value;
				var paymentIdField = document.getElementById("payment_id_field");
				var paymentIdLabel = document.getElementById("payment_id_label");
				var paymentIdInput = document.getElementById("payment_id");
			
				if (paymentMode === "CASH") {
					// Hide the payment_id field if CASH is selected
					paymentIdField.style.display = "none";
					paymentIdInput.removeAttribute('required');  // Remove required attribute
				} else {
					// Show the payment_id field if any other mode is selected
					paymentIdField.style.display = "block";
					paymentIdInput.setAttribute('required', true);  // Add required attribute
			
					// Modify the label and placeholder based on the selected payment mode
					if (paymentMode === "UPI") {
						paymentIdLabel.innerHTML = "Transaction ID <span style='color:red'>*</span>";
						paymentIdInput.placeholder = "Enter UPI Transaction ID";
					} else if (paymentMode === "IMPS") {
						paymentIdLabel.innerHTML = "IMPS Transaction Number <span style='color:red'>*</span>";
						paymentIdInput.placeholder = "Enter IMPS Transaction Number";
					} else if (paymentMode === "CHEQUE") {
						paymentIdLabel.innerHTML = "Cheque Number <span style='color:red'>*</span>";
						paymentIdInput.placeholder = "Enter Cheque Number";
					}
				}
			}
			
			// Call the function on page load to ensure correct behavior
			document.addEventListener("DOMContentLoaded", function() {
				togglePaymentIdField(); // Ensure the field state is set based on the default value
			});
			</script>
    @endsection
