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
						<span class="main-content-title mg-b-0 mg-b-lg-1">Add Temple Devotee</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page">Add Temple Devotee</li>
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
											<div class="form-wrapper">
												<div class="form-container">
													<form method="POST" action="{{ route('templedevotees.storedevotees') }}" enctype="multipart/form-data">
														@csrf
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="name">Name <span style="color:red">*</span></label>
																	<input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="phone_number">Phone Number <span style="color:red">*</span></label>
																	<input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter Phone Number" required>
																</div>
															</div>
														</div>
													
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="dob">DOB <span style="color:red">*</span></label>
																	<input type="date" class="form-control" id="dob" name="dob" required>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="photo">Photo <span style="color:red">*</span></label>
																	<input type="file" class="form-control" id="photo" name="photo" required>
																</div>
															</div>
														</div>
													
														<div class="row">
															<div class="col-md-4">
																<div class="form-group">
																	<label for="gotra">Gotra <span style="color:red">*</span></label>
																	<input type="text" class="form-control" id="gotra" name="gotra" placeholder="Enter Gotra" required>
																</div>
															</div>
															<div class="col-md-4">
																<div class="form-group">
																	<label for="rashi">Rashi (Zodiac Sign) <span style="color:red">*</span></label>
																	<input type="text" class="form-control" id="rashi" name="rashi" placeholder="Enter Zodiac Sign" required>
																</div>
															</div>
															<div class="col-md-4">
																<div class="form-group">
																	<label for="rashi">Nakshatra </label>
																	<input type="text" class="form-control" id="nakshatra" name="nakshatra" placeholder="Enter Nakshatra">
																</div>
															</div>
														</div>
													
														<div class="form-group">
															<label for="anniversary_date">Anniversary Date</label>
															<input type="date" class="form-control" id="anniversary_date" name="anniversary_date">
														</div>
													
														<div class="form-group">
															<label for="address">Address <span style="color:red">*</span></label>
															<textarea name="address" class="form-control" id="address" placeholder="Enter Address" required></textarea>
														</div>
													
														<button type="submit" class="btn btn-primary">Submit</button>
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
	
			
    @endsection
