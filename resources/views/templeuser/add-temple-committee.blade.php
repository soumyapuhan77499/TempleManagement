@extends('templeuser.layouts.app')

    @section('styles')

		<!-- INTERNAL Select2 css -->
		<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />

		<!-- INTERNAL Data table css -->
		<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.css')}}" rel="stylesheet" />
		<link href="{{asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css')}}"  rel="stylesheet">
		<link href="{{asset('assets/plugins/datatable/responsive.bootstrap5.css')}}" rel="stylesheet" />
		<style>
			/* Unique styles for the trust member section */
			.trust-section-title {
				font-weight: bold;
				font-size: 18px;
				transition: color 0.3s ease;
			}
		
			.trust-section-card {
				border-radius: 10px;
				padding: 20px 20px 8px 20px;
				margin: 10px;
				text-align: center;
				transition: transform 0.3s ease, box-shadow 0.3s ease;
				box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
			}
			.trust-section-card:hover {
				transform: scale(1.05);
				box-shadow: 0 6px 30px rgba(0, 0, 0, 0.15);
			}
		
			.trust-start-date-card {
				background-color: #d1ecf1; /* Light gray */
			}
		
			.live-today-date-card {
				background-color: #d1ecf1; /* Light blue */
			}
		
			.total-days-card {
				background-color: #d1ecf1; /* Light green */
			}
		
			.trust-section-icon {
				font-size: 30px;
				margin-bottom: 10px;
				color: #007bff;
			}
		
			.trust-section-h4 {
				font-size: 24px;
				margin-top: 10px;
				transition: transform 0.3s ease;
			}
		
			.trust-section-h4:hover {
				transform: scale(1.1);
			}
		</style>
    @endsection

    @section('content')

					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div class="left-content">
						<span class="main-content-title mg-b-0 mg-b-lg-1">Committee Details</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page">Committee Details</li>
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
							<div class="row">
								<div class="col-12 col-sm-12">
									<div class="card">
										<div class="card-body pt-0 pt-4">
												
											<form method="POST" enctype="multipart/form-data" action="{{ route('templeuser.savecommittee') }}">
												@csrf
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="committee_creation_date">Committee Creation Date <span style="color:red">*</span></label>
															<input type="date" class="form-control" id="committee_creation_date" name="committee_creation_date" required>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="financial_period">Financial Period <span style="color:red">*</span></label>
															<select name="financial_period" class="form-control" required>
																<option selected disabled>Choose One</option>
																<option value="2024-2025">2024-2025</option>
																<option value="2025-2026">2025-2026</option>
																<option value="2026-2027">2026-2027</option>
																<option value="2027-2028">2027-2028</option>
															</select>
														</div>
													</div>
												</div>
												<button type="submit" class="btn btn-primary">Add Committee</button>
											</form>
											
										</div>
									</div>
									<div class="card-header">
										<h4 class="card-title">Ongoing Committee Details</h4>
									</div>
									<div class="card custom-card overflow-hidden">
										@if($committeedetails)
											<div class="">
												<div class="row">
													<div class="col-md-4">
														<div class="trust-section-card trust-start-date-card">
															<i class="fas fa-calendar-alt trust-section-icon"></i><br>
															<span class="trust-section-title">Committee Starting Date</span>
															<h4 class="trust-section-h4">{{ $committeedetails->committee_creation_date }}</h4>
														</div>
													</div>
													<div class="col-md-4">
														<div class="trust-section-card live-today-date-card">
															<i class="fas fa-clock trust-section-icon"></i><br>
															<span class="trust-section-title">Today's Date</span>
															{{-- <h4 id="live-today-date" class="trust-section-h4"></h4> --}}
															<p style="font-size: 16px;line-height: 35px;font-family: 'Courier New', monospace;font-weight: bold;"
															id="currentDateTime"></p> <!-- Live Date -->
														</div>
													</div>
													<div class="col-md-4">
														<div class="trust-section-card total-days-card">
															<i class="fas fa-hourglass-half trust-section-icon"></i><br>
															<span class="trust-section-title">Total Days</span>
															<h4 class="trust-section-h4">{{ $totalDays }}</h4>
														</div>
													</div>
												</div>
											</div>
										@else
											<div class="text-center py-4">
												<h5 class="text-danger">No committee started</h5>
											</div>
										@endif
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
			// Function to get the current date and time
			function updateDateTime() {
				const now = new Date();
				const options = {
					year: 'numeric',
					month: 'long',
					day: 'numeric'
				};
				const formattedDate = now.toLocaleDateString('en-US', options);
				const formattedTime = now.toLocaleTimeString('en-US', {
					hour: 'numeric',
					minute: 'numeric',
					second: 'numeric',
					hour12: true
				});
	
				// Update the content of the 'currentDateTime' element
				document.getElementById('currentDateTime').textContent =formattedDate + ' ' + formattedTime;
			}
	
			// Update the time every second
			setInterval(updateDateTime, 1000);
	
			// Initial call to display the time immediately on page load
			updateDateTime();
		</script>
		<script>
			function previewFiles(inputId, previewContainerId) {
				const input = document.getElementById(inputId);
				const previewContainer = document.getElementById(previewContainerId);
				
				previewContainer.innerHTML = ''; // Clear previous previews
			
				const files = input.files;
				if (files.length === 0) return;
			
				for (let i = 0; i < files.length; i++) {
					const file = files[i];
					const reader = new FileReader();
			
					reader.onload = function(e) {
						const fileUrl = e.target.result;
						const fileType = file.type;
			
						let element;
						if (fileType.startsWith('image/')) {
							element = document.createElement('img');
							element.src = fileUrl;
							element.style.width = '150px';
							element.style.margin = '5px';
						} else if (fileType.startsWith('video/')) {
							element = document.createElement('video');
							element.src = fileUrl;
							element.controls = true;
							element.style.width = '300px';
							element.style.margin = '5px';
						}
			
						if (element) {
							previewContainer.appendChild(element);
						}
					};
			
					reader.readAsDataURL(file);
				}
			}
		</script>
		  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

		@if(session('error'))
		<script>
			Swal.fire({
				icon: 'error',
				title: 'Error',
				text: '{{ session('error') }}',
			});
		</script>
		@endif

		@if(session('success'))
		<script>
			Swal.fire({
				icon: 'success',
				title: 'Success',
				text: '{{ session('success') }}',
			});
		</script>
		@endif
			
    @endsection
