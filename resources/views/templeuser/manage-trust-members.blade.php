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
						  <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Trust Members</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Tables</a></li>
								<li class="breadcrumb-item active" aria-current="page">Manage Trust Members</li>
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
							@foreach($trustmembers as $member)
								<div class="col-xl-3 col-md-6 col-lg-6 col-sm-6">
									<div class="card">
										<div class="card-body">
											<div class="plan-card text-center">
												<!-- Member Photo -->
												<span class="avatar-sm">
													<img src="{{ $member->member_photo ? asset('storage/' . $member->member_photo) : 'https://spruko.com/demo/nowa/dist/assets/images/faces/5.jpg' }}" alt="img" class="rounded-circle">
												</span>
												
												<!-- Member Name -->
												<h6 class="text-dark text-uppercase mt-2">{{ $member->member_name }}</h6>
						
												<!-- Member Designation -->
												<h5 class="mb-2">{{ $member->temple_designation	 }}</h5>
						
												<!-- Status Badge -->
												<span class="badge badge-success">{{ $member->status }}</span>
						
												<!-- Edit and Delete Buttons -->
												<div class="mt-3">
													<a href="{{ route('templeuser.editTrustMember', $member->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
													<form id="delete-form-{{ $member->id }}" action="{{ route('templeuser.deleteTrustMember', $member->id) }}" method="POST" style="display:inline-block;">
														@csrf
														@method('DELETE')
														<button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $member->id }}')">
															<i class="fa fa-trash"></i>
														</button>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							@endforeach
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
			function confirmDelete(memberId) {
				Swal.fire({
					title: 'Are you sure?',
					text: "Do you really want to delete this member?",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						// Submit the form after confirmation
						document.getElementById('delete-form-' + memberId).submit();
					}
				});
			}
			</script>
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
			function confirmDeactivation() {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will deactivate all trust members!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, deactivate!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form after confirmation
                document.getElementById('deactivate-form').submit();
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
