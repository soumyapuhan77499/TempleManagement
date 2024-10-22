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
						<span class="main-content-title mg-b-0 mg-b-lg-1">Commitee Details</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page">Commitee Memeber</li>
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
											<form method="POST" enctype="multipart/form-data" action="{{ route('templeuser.storecommitteeMember') }}" id="committeeForm">
												@csrf
												@method('POST')
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="committee_creation_date">Committee Creation Date <span style="color:red">*</span></label>
															<input type="date" class="form-control" id="committee_creation_date" name="committee_creation_date" 
																value="{{ old('committee_creation_date', $committeedetails->committee_creation_date ?? '') }}" readonly>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="financial_period">Financial Period <span style="color:red">*</span></label>
															<input type="text" class="form-control" id="financial_period" name="financial_period" 
																value="{{ old('financial_period', $committeedetails->financial_period ?? '') }}" readonly>
														</div>
													</div>
													<div class="col-md-6" style="display: none">
														<div class="form-group">
															<label for="committee_id">Committee ID <span style="color:red">*</span></label>
															<input type="text" class="form-control" id="committee_id" name="committee_id" 
																value="{{ old('committee_id', $committeedetails->committee_id ?? '') }}" readonly>
														</div>
													</div>
												</div>
												<div class="card">
													<div class="card-header">
														<h4 class="card-title">Create Managing Committee</h4>
													</div>
													<div class="card-body pt-0">
														<div class="row">
															<!-- Member Name -->
															<div class="col-md-6">
																<div class="form-group">
																	<label for="member_name">Member Name <span style="color:red">*</span></label>
																	<input type="text" class="form-control" id="member_name" name="member_name" value="{{ old('member_name') }}" required>
																</div>
															</div>
															<!-- DOB -->
															<div class="col-md-6">
																<div class="form-group">
																	<label for="dob">DOB <span style="color:red">*</span></label>
																	<input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob') }}" required>
																</div>
															</div>
														</div>
														<div class="row">
															<!-- Member Designation -->
															<div class="col-md-6">
																<div class="form-group">
																	<label for="member_designation">Profession <span style="color:red">*</span></label>
																	<input type="text" class="form-control" id="member_designation" name="member_designation" value="{{ old('member_designation') }}" required>
																</div>
															</div>
															<!-- Temple Designation -->
															<div class="col-md-6">
																<div class="form-group">
																	<label for="temple_designation">Temple Designation <span style="color:red">*</span></label>
																	<input type="text" class="form-control" id="temple_designation" name="temple_designation" value="{{ old('temple_designation') }}" required>
																</div>
															</div>
														</div>
														<div class="row">
															<!-- Contact Number -->
															<div class="col-md-4">
																<div class="form-group">
																	<label for="member_contact_no">Contact Number <span style="color:red">*</span></label>
																	<input type="text" class="form-control" id="member_contact_no" name="member_contact_no" value="{{ old('member_contact_no') }}" required pattern="\d{10}" title="Must be 10 digits">
																</div>
															</div>
															<!-- WhatsApp Number -->
															<div class="col-md-4">
																<div class="form-group">
																	<label for="whatsapp_number">WhatsApp Number <span style="color:red">*</span></label>
																	<input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number') }}" required pattern="\d{10}" title="Must be 10 digits">
																</div>
															</div>
															<!-- Email -->
															<div class="col-md-4">
																<div class="form-group">
																	<label for="email">Email Id</label>
																	<input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
																</div>
															</div>
														</div>
														<div class="row">
															<!-- About Member -->
															<div class="col-md-12">
																<div class="form-group">
																	<label for="about_member">About </label>
																	<textarea name="about_member" class="form-control" id="about_member" cols="30" rows="3">{{ old('about_member') }}</textarea>
																</div>
															</div>
														</div>
														<div class="row mt-2">
															<!-- Member Photo -->
															<div class="col-md-12">
																<div class="form-group">
																	<label for="member_photo">Member Photo <span style="color:red">*</span></label>
																	<input type="file" class="form-control" id="member_photo" name="member_photo" required>
																</div>
															</div>
														</div>
														<button type="submit" class="btn btn-primary mt-3">Submit</button>
													</form>
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
			<script>
				document.getElementById('committeeForm').addEventListener('submit', function (event) {
					let committeeId = document.getElementById('committee_id').value;
					let committeeCreationDate = document.getElementById('committee_creation_date').value;
					let financialPeriod = document.getElementById('financial_period').value;
			
					if (!committeeId || !committeeCreationDate || !financialPeriod) {
						event.preventDefault();
						Swal.fire({
							icon: 'warning',
							title: 'Committee Information Missing',
							text: 'Still committee is not created',
						});
					}
				});
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
	