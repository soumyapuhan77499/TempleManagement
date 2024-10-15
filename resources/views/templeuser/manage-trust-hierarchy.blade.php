@extends('templeuser.layouts.app')

    @section('styles')

		<!-- Data table css -->
		<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.css')}}" rel="stylesheet" />
		<link href="{{asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css')}}"  rel="stylesheet">
		<link href="{{asset('assets/plugins/datatable/responsive.bootstrap5.css')}}" rel="stylesheet" />

		<!-- INTERNAL Select2 css -->
		<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
		<style>
			/* Unique styles for the trust member section */
			.trust-section-title {
				font-weight: bold;
				font-size: 18px;
				transition: color 0.3s ease;
			}
		
			.trust-section-card {
				border-radius: 10px;
				padding: 20px;
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
						  <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Hierarchy</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Tables</a></li>
								<li class="breadcrumb-item active" aria-current="page">Manage Hierarchy</li>
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

						<!-- Row -->
						<div class="row row-sm">
							<div class="col-lg-12">
								<div class="card custom-card overflow-hidden">
									<div class="card-body">
										<div class="row">
											<div class="col-md-4">
												<div class="trust-section-card trust-start-date-card">
													<i class="fas fa-calendar-alt trust-section-icon"></i>
													<span class="trust-section-title">Trust Starting Date</span>
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
								<div class="card custom-card overflow-hidden">
									<div class="card-body">
										
										<div class="table-responsive  export-table">
                                            <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                                                <thead>
                                                    <tr>
                                                        <th class="border-bottom-0">#</th> <!-- Index column -->
                                                        <th class="border-bottom-0">Name</th>
                                                        <th class="border-bottom-0">Temple Designation</th>
                                                        <th class="border-bottom-0">Hierarchy Position(Order)</th>
                                                        <th class="border-bottom-0">Action</th>
                                                    </tr>
                                                </thead>
												<tbody>
													@foreach ($trustmembers as $index => $trustmember)
													<tr>
														<td>{{ $index + 1 }}</td>
														<td class="tb-col">
															<div class="media-group">
																<div class="media media-md media-middle media-circle">
																	<img src="{{ asset('storage/' . $trustmember->member_photo) }}" alt="user" style="width: 50px; height: 50px;">
																</div>
																<div class="media-text" style="color: blue">
																	<a style="color: blue" href="#" class="title">{{ $trustmember->member_name }}</a>
																	<span class="small text">{{ $trustmember->member_contact_no }}</span>
																</div>
															</div>
														</td>
														<td>{{ $trustmember->temple_designation }}</td>
														<td>
															<form action="{{ route('templeuser.saveHierarchyPosition', $trustmember->id) }}" method="POST">
																@csrf
																<input type="number" class="form-control" name="hierarchy_position" value="{{ $trustmember->hierarchy_position }}">
														</td>
														<td>
															<button type="submit" class="btn btn-primary">Save</button>
															</form> <!-- Move the form closing tag here -->
														</td>
													</tr>
													@endforeach
												</tbody>
												
                                            </table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- End Row -->

    @endsection

    @section('scripts')

		<!-- Internal Data tables -->
		<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/js/buttons.bootstrap5.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/pdfmake/pdfmake.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/pdfmake/vfs_fonts.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>
		<script src="{{asset('assets/js/table-data.js')}}"></script>

		<!-- INTERNAL Select2 js -->
		<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>

		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

		<script>
			// Function to confirm delete
			function confirmDelete(id) {
				Swal.fire({
					title: 'Are you sure?',
					text: "You won't be able to revert this!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						// Submit the form after confirmation
						document.getElementById('delete-form-' + id).submit();
					}
				});
			}
		
			// Hide the alert message after a few seconds
			setTimeout(() => {
				var messageElement = document.getElementById('Message');
				if (messageElement) {
					messageElement.style.display = 'none';
				}
			}, 3000);
		</script>
		<script>
			@if(session('success'))
			Swal.fire({
				title: 'Success!',
				text: "{{ session('success') }}",
				icon: 'success',
				confirmButtonText: 'OK'
			});
			@endif
		</script>
 <script>
	function updateTime() {
		var now = new Date();
		var hours = now.getHours().toString().padStart(2, '0');
		var minutes = now.getMinutes().toString().padStart(2, '0');
		var seconds = now.getSeconds().toString().padStart(2, '0');
		var formattedTime = hours + ':' + minutes + ':' + seconds;
		document.getElementById('liveTime').innerText = formattedTime;
	}

	setInterval(updateTime, 1000); // Update every second
	updateTime(); // Initial call to set the time immediately
</script>
    @endsection
