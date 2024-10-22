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
						  <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Committee Members</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Tables</a></li>
								<li class="breadcrumb-item active" aria-current="page">Manage Committee Members</li>
							</ol>
						</div>
					</div>
					<!-- /breadcrumb -->

						{{-- @if(session()->has('success'))
						<div class="alert alert-success" id="Message">
							{{ session()->get('success') }}
						</div>
						@endif
					
						@if ($errors->has('danger'))
							<div class="alert alert-danger" id="Message">
								{{ $errors->first('danger') }}
							</div>
						@endif --}}

						<!-- Row -->
						<div class="row row-sm">
							<div class="col-lg-12">
								<div class="card custom-card overflow-hidden">
									@if($committeedetails)
										<div class="">
											<div class="row">
												<div class="col-md-4">
													<div class="trust-section-card trust-start-date-card">
														<i class="fas fa-calendar-alt trust-section-icon"></i><br>
														<span class="trust-section-title">Committee Starting Date</span>
														<p style="font-size: 16px;line-height: 35px;font-family: 'Courier New', monospace;font-weight: bold;">{{ \Carbon\Carbon::parse($committeedetails->committee_creation_date)->format('F d, Y') }}</p>

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
														<p style="font-size: 16px;line-height: 35px;font-family: 'Courier New', monospace;font-weight: bold;">{{ $totalDays }}</p>
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
								<div class="card custom-card overflow-hidden">
									<div class="card-body">
										
										<div class="table-responsive  export-table">
                                            <table class="table table-bordered text-nowrap key-buttons border-bottom">
                                                <thead>
                                                    <tr>
                                                        <th class="border-bottom-0">#</th> <!-- Index column -->
                                                        <th class="border-bottom-0">Name</th>
                                                        <th class="border-bottom-0">Temple Designation</th>
                                                        <th class="border-bottom-0">Position</th>
                                                        <th class="border-bottom-0">Status</th>

                                                        <th class="border-bottom-0">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($committeemembers as $index => $committeemember)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td class="tb-col">
                                                            <div class="media-group">
                                                                <div class="media media-md media-middle media-circle">
                                                                    <img src="{{ asset('storage/' .$committeemember->member_photo) }}" alt="user" style="width: 50px; height: 50px;"> <!-- Adjust image size -->
                                                                </div>
                                                                <div class="media-text" style="color: blue">
                                                                    <a style="color: blue" href="#" class="title">{{ $committeemember->member_name }}</a> <!-- Corrected to member_name -->
                                                                    <span class="small text">{{ $committeemember->member_contact_no }}</span> <!-- Assuming contact_number exists -->
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ $committeemember->temple_designation }}</td> <!-- Assuming member_designation exists -->
                                                        <td>{{ $committeemember->hierarchy_position }}</td> 
														<td>{{ $committeemember->status }}</td><!-- Assuming about_member exists -->
														<td>
															<a href="{{route('templeuser.editcommitteeMember',$committeemember->id)}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
															<button type="button" class="btn btn-danger" onclick="confirmDelete({{ $committeemember->id }})">
																<i class="fa fa-trash"></i>
															</button>
														</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

											<form id="deactivate-form" action="{{ route('templeuser.deactivateCommitteeMembers') }}" method="POST">
												@csrf
												<button type="button" class="btn btn-primary" onclick="confirmDeactivation()">End Of Committee Cycle</button>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- End Row -->
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Action</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status">Select Action</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="deleted">Delete</option>
                            <option value="suspended">Suspend</option>
                            <option value="deactivate">Deactivate</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason</label>
                        <textarea name="reason" id="reason" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

    @endsection

    @section('scripts')
<script>
	function confirmDelete(memberId) {
    // Set the form action dynamically based on member ID
    var formAction = "{{ route('templeuser.deletecommitteeMember', ':id') }}";
    formAction = formAction.replace(':id', memberId);
    document.getElementById('deleteForm').action = formAction;

    // Open the modal
    $('#deleteModal').modal('show');
}

</script>
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
