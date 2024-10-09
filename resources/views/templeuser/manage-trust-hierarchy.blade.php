@extends('templeuser.layouts.app')

    @section('styles')

		<!-- Data table css -->
		<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.css')}}" rel="stylesheet" />
		<link href="{{asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css')}}"  rel="stylesheet">
		<link href="{{asset('assets/plugins/datatable/responsive.bootstrap5.css')}}" rel="stylesheet" />

		<!-- INTERNAL Select2 css -->
		<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />

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
						<div class="card custom-card overflow-hidden">
							<div class="card-body">
								<form id="searchForm" method="GET" action="{{ route('search.member') }}">
									<div class="row">
										<div class="col-md-8">
											<input type="search" placeholder="Enter Trust Member Name..." name="member_name" 
												   class="form-control" id="member_name" required>
										</div>
									</div>
								</form>
								<div id="suggestions" class="mt-2"></div> <!-- Suggestions will appear here -->
							</div>
						</div>
						
						
						<div class="card custom-card overflow-hidden">
							<div class="card-body">
								<form action="{{ route('submit.order') }}" method="POST">
									@csrf
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label for="member_name">Member Name <span style="color:red">*</span></label>
												<input type="text" class="form-control" id="member_name" name="member_name" 
													   value="{{ old('member_name', $member->name ?? '') }}" placeholder="Enter member name" 
													   required readonly>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="temple_designation">Temple Designation <span style="color:red">*</span></label>
												<input type="text" class="form-control" id="temple_designation" name="temple_designation" 
													   value="{{ old('temple_designation', $member->designation ?? '') }}" 
													   placeholder="Enter designation" required readonly>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="order">Order <span style="color:red">*</span></label>
												<input type="number" class="form-control" id="order" name="order" 
													   value="{{ old('order') }}" placeholder="Enter Order" required>
											</div>
										</div>
										<div class="col-md-3">
											<button type="submit" class="btn btn-primary mt-4">Submit</button>
										</div>
									</div>
								</form>
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
			document.addEventListener('DOMContentLoaded', function () {
				const memberNameInput = document.getElementById('member_name');
				const suggestionsDiv = document.getElementById('suggestions');
		
				memberNameInput.addEventListener('input', function () {
					const query = this.value;
		
					if (query.length >= 2) { // Start searching after 2 characters
						fetch(`/search/members?member_name=${query}`)
							.then(response => response.json())
							.then(data => {
								suggestionsDiv.innerHTML = ''; // Clear previous suggestions
		
								if (data.length > 0) {
									data.forEach(member => {
										const suggestionItem = document.createElement('div');
										suggestionItem.classList.add('suggestion-item');
										suggestionItem.textContent = member.name;
										suggestionItem.onclick = function () {
											// Fill the form fields when a suggestion is clicked
											document.getElementById('member_name').value = member.name;
											document.getElementById('temple_designation').value = member.designation;
											suggestionsDiv.innerHTML = ''; // Clear suggestions
										};
										suggestionsDiv.appendChild(suggestionItem);
									});
								} else {
									suggestionsDiv.innerHTML = '<div>No members found</div>'; // No suggestions
								}
							})
							.catch(error => console.error('Error fetching suggestions:', error));
					} else {
						suggestionsDiv.innerHTML = ''; // Clear suggestions if input is less than 2 characters
					}
				});
			});
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
		
			// Hide the alert message after a few seconds
			setTimeout(() => {
				var messageElement = document.getElementById('Message');
				if (messageElement) {
					messageElement.style.display = 'none';
				}
			}, 3000);
		</script>

    @endsection
