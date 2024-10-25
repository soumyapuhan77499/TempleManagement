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
						<span class="main-content-title mg-b-0 mg-b-lg-1">Add Prasad Details</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page">Add Prasad Details</li>
							</ol>
						</div>
					</div>
					<!-- /breadcrumb -->
					@if ($errors->any())
					<div class="alert alert-danger">
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
										{{-- <div class="card-header">
											<h4 class="card-title">Temple About</h4>
										</div> --}}
										<div class="card-body pt-0 pt-4">
											<form action="{{ route('templeprasad.store') }}" method="POST">
												@csrf
												<div class="row">
													<div class="col-md-3">
														<div class="form-group">
															<label for="prasad_start_time">Prasad Start Time</label>
															<div class="input-group">
																<input type="time" class="form-control" name="prasad_start_time" required>
																<select class="form-control" name="prasad_start_period">
																	<option value="AM">AM</option>
																	<option value="PM">PM</option>
																</select>
															</div>
														</div>
													</div>
											
													<div class="col-md-3">
														<div class="form-group">
															<label for="prasad_end_time">Prasad End Time</label>
															<div class="input-group">
																<input type="time" class="form-control" name="prasad_end_time" required>
																<select class="form-control" name="prasad_end_period">
																	<option value="AM">AM</option>
																	<option value="PM">PM</option>
																</select>
															</div>
														</div>
													</div>

													<div class="col-md-4">
														<div class="form-group">
															<label for="full_prasad_price">Full Prasad Price <span style="color:red">*</span></label>
															<input type="text" class="form-control" id="full_prasad_price" name="full_prasad_price" placeholder="Enter Full Prasad Price" required>
														</div>
													</div>
												</div>
											
												<div class="row">
													<div class="col-md-6">
														<input type="checkbox" name="online_order" id="onlineOrderCheckbox"> Do your Temple Provide Online Order
													</div>
												</div>
											
												<div class="row mt-2 prasad-details" id="prasadDetailsForm" style="display:none;">
													<div class="col-md-12">
														<div id="prasadFieldsContainer">
															<div class="row">
																<div class="col-md-3">
																	<div class="form-group">
																		<label for="prasad_name">Prasad Name <span style="color:red">*</span></label>
																		<input type="text" class="form-control" id="prasad_name" name="prasad_name[]" placeholder="Enter Prasad Name" required>
																	</div>
																</div>
																<div class="col-md-3">
																	<div class="form-group">
																		<label for="prasad_price">Prasad Price <span style="color:red">*</span></label>
																		<input type="text" class="form-control" id="prasad_price" name="prasad_price[]" placeholder="Enter Prasad Price" required>
																	</div>
																</div>
															</div>
														</div>
														<button type="button" class="btn btn-primary mt-1" id="addMorePrasad">Add More</button>
													</div>
												</div>
											
												<div class="row">
													<div class="col-md-6">
														<input type="checkbox" name="pre_order" class="mt-1"> Do your Temple Provide Pre Order
													</div>
												</div>
												
												<div class="row">
													<div class="col-md-6">
														<input type="checkbox" name="offline_order" class="mt-1"> Do your Temple Provide Offline Order
													</div>
												</div>
											
												<button type="submit" class="btn btn-primary mt-2">Submit</button>
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
			document.getElementById('onlineOrderCheckbox').addEventListener('change', function() {
				var prasadDetailsForm = document.getElementById('prasadDetailsForm');
				if (this.checked) {
					prasadDetailsForm.style.display = 'block'; // Show the form
				} else {
					prasadDetailsForm.style.display = 'none'; // Hide the form
				}
			});
		
			let fieldCounter = 0;

function addPrasadFields() {
	fieldCounter++;
	const prasadFieldsContainer = document.getElementById('prasadFieldsContainer');

	const newFieldRow = document.createElement('div');
	newFieldRow.classList.add('row', 'mt-2');
	newFieldRow.setAttribute('id', `prasadRow_${fieldCounter}`);

	newFieldRow.innerHTML = `
		<div class="col-md-3">
			<div class="form-group">
				<label for="prasad_name_${fieldCounter}">Prasad Name <span style="color:red">*</span></label>
				<input type="text" class="form-control" id="prasad_name_${fieldCounter}" name="prasad_name[]" placeholder="Enter Prasad Name" required>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="prasad_price_${fieldCounter}">Prasad Price <span style="color:red">*</span></label>
				<input type="text" class="form-control" id="prasad_price_${fieldCounter}" name="prasad_price[]" placeholder="Enter Prasad Price" required>
			</div>
		</div>
		<div class="col-md-2">
			<button type="button" class="btn btn-danger mt-4 removePrasadField" data-id="${fieldCounter}">Remove</button>
		</div>
	`;

	prasadFieldsContainer.appendChild(newFieldRow);

	document.querySelector(`#prasadRow_${fieldCounter} .removePrasadField`).addEventListener('click', function() {
		const rowId = this.getAttribute('data-id');
		document.getElementById(`prasadRow_${rowId}`).remove();
	});
}

document.getElementById('addMorePrasad').addEventListener('click', function() {
	addPrasadFields();
});

document.getElementById('onlineOrderCheckbox').addEventListener('change', function() {
	document.getElementById('prasadDetailsForm').style.display = this.checked ? 'block' : 'none';
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
