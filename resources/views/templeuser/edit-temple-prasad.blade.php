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
						<span class="main-content-title mg-b-0 mg-b-lg-1">Edit Prasad Details</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page">Edit Prasad Details</li>
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
											<form action="{{ route('templeprasad.update', $templePrasad->id) }}" method="POST">
												@csrf
												@method('PUT')
												<div class="row">
													<div class="col-md-3">
														<label>Prasad Start Time</label>
														<div class="input-group">
															<input type="time" class="form-control" name="prasad_start_time" value="{{ $templePrasad->prasad_start_time }}" required>
															<select class="form-control" name="prasad_start_period">
																<option value="AM" {{ $templePrasad->prasad_start_period == 'AM' ? 'selected' : '' }}>AM</option>
																<option value="PM" {{ $templePrasad->prasad_start_period == 'PM' ? 'selected' : '' }}>PM</option>
															</select>
														</div>
													</div>
										
													<div class="col-md-3">
														<label>Prasad End Time</label>
														<div class="input-group">
															<input type="time" class="form-control" name="prasad_end_time" value="{{ $templePrasad->prasad_end_time }}" required>
															<select class="form-control" name="prasad_end_period">
																<option value="AM" {{ $templePrasad->prasad_end_period == 'AM' ? 'selected' : '' }}>AM</option>
																<option value="PM" {{ $templePrasad->prasad_end_period == 'PM' ? 'selected' : '' }}>PM</option>
															</select>
														</div>
													</div>
										
													<div class="col-md-4">
														<label>Full Prasad Price <span style="color:red">*</span></label>
														<input type="text" class="form-control" name="full_prasad_price" value="{{ $templePrasad->full_prasad_price }}" required>
													</div>
												</div>
										
												<div class="row mt-3" id="prasadFieldsContainer">
													@foreach($templePrasad->prasadItems as $item)
													<div class="row mt-2 prasad-row" id="prasadRow_{{ $loop->index }}">
														<div class="col-md-3">
															<label>Prasad Name <span style="color:red">*</span></label>
															<input type="text" class="form-control" name="prasad_name[]" value="{{ $item->prasad_name }}" required>
														</div>
														<div class="col-md-3">
															<label>Prasad Price <span style="color:red">*</span></label>
															<input type="text" class="form-control" name="prasad_price[]" value="{{ $item->prasad_price }}" required>
														</div>
														<div class="col-md-2">
															<button type="button" class="btn btn-danger mt-4 removePrasadField" onclick="removePrasadField({{ $loop->index }})">Remove</button>
														</div>
													</div>
													@endforeach
												</div>
										
												<button type="button" class="btn btn-primary mt-2" id="addMorePrasad">Add More</button>

												<div class="row">
													<div class="col-md-6">
														<input type="checkbox" name="pre_order" class="mt-1" 
															{{ $templePrasad->pre_order ? 'checked' : '' }}> Do your Temple Provide Pre Order
													</div>
												</div>
										
												<div class="row mt-2">
													<div class="col-md-6">
														<input type="checkbox" name="offline_order" class="mt-1" 
															{{ $templePrasad->offline_order ? 'checked' : '' }}> Do your Temple Provide Offline Order
													</div>
												</div>
												<button type="submit" class="btn btn-success mt-2">Update</button>
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
			let fieldCounter = {{ count($templePrasad->prasadItems) }};
			
			document.getElementById('addMorePrasad').addEventListener('click', function() {
				addPrasadFields();
			});
			
			function addPrasadFields() {
				const container = document.getElementById('prasadFieldsContainer');
				const row = document.createElement('div');
				row.classList.add('row', 'mt-2', 'prasad-row');
				row.setAttribute('id', `prasadRow_${fieldCounter}`);
			
				row.innerHTML = `
					<div class="col-md-3">
						<label>Prasad Name <span style="color:red">*</span></label>
						<input type="text" class="form-control" name="prasad_name[]" required>
					</div>
					<div class="col-md-3">
						<label>Prasad Price <span style="color:red">*</span></label>
						<input type="text" class="form-control" name="prasad_price[]" required>
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-danger mt-4 removePrasadField" onclick="removePrasadField(${fieldCounter})">Remove</button>
					</div>
				`;
				container.appendChild(row);
				fieldCounter++;
			}
			
			function removePrasadField(index) {
				document.getElementById(`prasadRow_${index}`).remove();
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
