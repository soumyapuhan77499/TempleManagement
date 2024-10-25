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
						  <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Prasads</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Tables</a></li>
								<li class="breadcrumb-item active" aria-current="page">Manage Prasads</li>
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
										
										<div class="table-responsive  export-table">
                                            <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                                                <thead>
													<tr>
														<th>Temple ID</th>

														<th>Temple Prasad ID</th>
														<th>Prasad Start Time</th>
														<th>Prasad End Time</th>
														<th>Prasad Full Price</th>
														<th>Online Order</th>
														<th>Prasad Items</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													@foreach($templePrasads as $templePrasad)
														<tr>
															<td>{{ $templePrasad->temple_id }}</td>

															<td>{{ $templePrasad->temple_prasad_id }}</td>
															<td>{{ $templePrasad->prasad_start_time }} {{ $templePrasad->prasad_start_period }}</td>
															<td>{{ $templePrasad->prasad_end_time }} {{ $templePrasad->prasad_end_period }}</td>
															<td>{{ $templePrasad->full_prasad_price }}</td>

															<td>{{ $templePrasad->online_order ? 'Yes' : 'No' }}</td>
															<td>
																<ul>
																	@foreach($templePrasad->prasadItems as $item)
																		<li>{{ $item->prasad_name }} - ₹{{ $item->prasad_price }}</li>
																	@endforeach
																</ul>
															</td>
															<td>
																<a href="{{ route('templeprasad.edit', $templePrasad->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
																<form action="{{ route('templeprasad.destroy', $templePrasad->id) }}" method="POST" style="display:inline;">
																	@csrf
																	@method('DELETE')
																	<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></button>
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
    @endsection
