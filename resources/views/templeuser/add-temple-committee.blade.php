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

									<div class="card custom-card overflow-hidden">
										<div class="card-body">
											<div class="row">
												<div class="col-md-4">
													<div class="trust-section-card trust-start-date-card">
														<i class="fas fa-calendar-alt trust-section-icon"></i>
														<span class="trust-section-title">Commitee Starting Date</span>
														<h4 class="trust-section-h4">{{ $trustdetails->trust_start_date }}</h4>
													</div>
												</div>
												<div class="col-md-4">
													<div class="trust-section-card live-today-date-card">
														<i class="fas fa-clock trust-section-icon"></i>
														<span class="trust-section-title">Today Date</span>
														<h4 id="live-today-date" class="trust-section-h4">{{ \Carbon\Carbon::today()->format('Y-m-d') }}</h4>  <h3 style="text-shadow: 3px 3px 10px rgba(0,0,0,0.4);color: #B7070A;font-family: 'Trebuchet MS', sans-serif; font-size: 20px;"
														id="liveTime"></h3> <!-- Live Date -->
													</div>
												</div>
												<div class="col-md-4">
													<div class="trust-section-card total-days-card">
														<i class="fas fa-hourglass-half trust-section-icon"></i>
														<span class="trust-section-title">Total Days</span>
														<h4 class="trust-section-h4">{{ $totalDays }}</h4>
													</div>
												</div>
											</div>
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
