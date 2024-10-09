@extends('superadmin.layouts.app')


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
						  <span class="main-content-title mg-b-0 mg-b-lg-1">Temple Requests</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Tables</a></li>
								<li class="breadcrumb-item active" aria-current="page">Temple Requests</li>
							</ol>
						</div>
					</div>
					<!-- /breadcrumb -->

						<!-- Row -->
						<div class="row row-sm">
							<div class="col-lg-12">
								<div class="card custom-card overflow-hidden">
									<div class="card-body">
										<div>
											<h6 class="main-content-label mb-1">Approval Process</h6>
										</div>
										@if (session()->has('success'))
										<div class="alert alert-success" id="Message">
											{{ session()->get('success') }}
										</div>
										@endif

										@if ($errors->has('danger'))
										<div class="alert alert-danger" id="Message">
											{{ $errors->first('danger') }}
										</div>
										@endif
										<div class="table-responsive  export-table">
											<table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
												<thead>
													<tr>
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">Temple ID</th>
														<th class="border-bottom-0">Temple details</th>
														<th class="border-bottom-0">Details</th>
														<th class="border-bottom-0">Status</th>
														<th class="border-bottom-0">Action</th>
													</tr>
												</thead>
												<tbody>
													@foreach($templeusers as $index => $templeuser)
													<tr>
														<td>{{ $index + 1 }}</td>
														<td>{{ $templeuser->temple_id }}</td>
														<td>{{ $templeuser->temple_name }}</br>
															Temple Trust Name :{{ $templeuser->temple_trust_name }}</br>
															Trust Contact Number :{{ $templeuser->trust_contact_no }}</td>
														<td>
															Contact No.: {{ $templeuser->mobile_no }}</br>
															Creator Name: {{ $templeuser->user_name }}</br>
															Address: {{ $templeuser->temple_address }}
														</td>
														<td><a class="btn btn-primary">{{ $templeuser->temple_status }}</a></td>
														<td>
															<a href="tel:{{ $templeuser->mobile_no }}" class="btn btn-primary">Call</a>
															
															<!-- Hold button - update status to "hold" -->
															<form action="{{ route('updateTempleStatus', ['id' => $templeuser->id, 'status' => 'hold']) }}" method="POST" style="display:inline;">
																@csrf
																<button type="submit" class="btn btn-warning">Hold</button>
															</form>
											
															<!-- Approve button - update status to "approved" -->
															<form action="{{ route('updateTempleStatus', ['id' => $templeuser->id, 'status' => 'approved']) }}" method="POST" style="display:inline;">
																@csrf
																<button type="submit" class="btn btn-success">Approve</button>
															</form>
											
															<!-- Reject button - update status to "rejected" -->
															<form action="{{ route('updateTempleStatus', ['id' => $templeuser->id, 'status' => 'rejected']) }}" method="POST" style="display:inline;">
																@csrf
																<button type="submit" class="btn btn-danger">Reject</button>
															</form>
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

    @endsection
