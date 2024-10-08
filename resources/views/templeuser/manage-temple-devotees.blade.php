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
						  <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Festivals</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<a href="{{route('templedevotees.adddevotees')}}" class="breadcrumb-item tx-15 btn btn-warning">Add Devotees</a>
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Tables</a></li>
								<li class="breadcrumb-item active" aria-current="page">Manage Festivals</li>
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
										<div>
											<h6 class="main-content-label mb-1">Manage Festivals</h6>
										</div>
										<div class="table-responsive  export-table">
                                            <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                                                <thead>
                                                    <tr>
                                                        <th class="border-bottom-0">#</th> <!-- Index column -->
                                                        <th class="border-bottom-0">Name</th>
                                                        <th class="border-bottom-0">photo</th>
                                                        <th class="border-bottom-0">Phone </th>
														<th class="border-bottom-0">DOB </th>
														<th class="border-bottom-0">Address </th>
														<th class="border-bottom-0">Rashi & Gotra</th>
                                                        <th class="border-bottom-0">Action</th>
                                                    </tr>
                                                </thead>
												<tbody>
													@foreach($devotees as $index => $devotee)
													<tr>
														<td>{{ $index + 1 }}</td>
														<td class="tb-col">
                                                            <div class="media-group">
                                                                <div class="media media-md media-middle media-circle">
                                                                    <img src="{{ asset('storage/' .$devotee->photo) }}" alt="user" style="width: 50px; height: 50px;"> <!-- Adjust image size -->
                                                                </div>
                                                                <div class="media-text" style="color: blue">
                                                                    <a style="color: blue" href="#" class="title">{{ $devotee->name }}</a> <!-- Corrected to member_name -->
                                                                    <span class="small text">{{ $devotee->phone_number }}</span> <!-- Assuming contact_number exists -->
                                                                </div>
                                                            </div>
                                                        </td>
														
														<td>{{ $devotee->dob }}</td>
														<td>{{ $devotee->gotra }}</td>
														<td>{{ $devotee->rashi }}</td>
														<td>{{ $devotee->anniversary_date ?? 'N/A' }}</td>
														<td>{{ $devotee->address }}</td>
														<td>
															<!-- You can add Edit/Delete functionality here -->
															<a href="{{ route('templedevotees.edit', $devotee->id) }}" class="btn btn-primary">Edit</a>
															<form action="{{ route('templedevotees.destroy', $devotee->id) }}" method="POST" style="display:inline-block;">
																@csrf
																@method('DELETE')
																<button type="submit" class="btn btn-danger">Delete</button>
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
