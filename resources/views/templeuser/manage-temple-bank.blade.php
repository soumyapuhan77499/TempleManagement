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
						  <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Bank</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Tables</a></li>
								<li class="breadcrumb-item active" aria-current="page">Manage Bank</li>
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
											{{-- <h6 class="main-content-label mb-1">Manage Festivals</h6> --}}
										</div>
										<div class="table-responsive  export-table">
                                            <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                                                <thead>
                                                    <tr>
                                                        <th class="border-bottom-0">#</th> <!-- Index column -->
                                                        <th class="border-bottom-0">Bank Name</th>
                                                        <th class="border-bottom-0">Branch Name</th>
                                                        <th class="border-bottom-0">Account Number</th>
                                                        <th class="border-bottom-0">Ifsc Code</th>
                                                        <th class="border-bottom-0">Name</th>
                                                        <th class="border-bottom-0">Upi</th>
                                                        <th class="border-bottom-0">Action</th>
                                                    </tr>
                                                </thead>
												<tbody>
                                                    @if (!empty($bankdata) && $bankdata->count() > 0)
                                                    @foreach ($bankdata as $index => $bank)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $bank->bank_name }}</td>
                                                            <td>{{ $bank->branch_name }}</td>
                                                            <td>{{ $bank->account_no }}</td>
                                                            <td>{{ $bank->ifsc_code }}</td>
                                                            <td>{{ $bank->acc_holder_name }}</td>
                                                            <td>{{ $bank->upi_id }}</td>
                                                            <td>
                                                                <a href="{{ route('templeuser.editbank', $bank->id) }}" class="btn btn-warning">Edit</a>
                                                                <form id="delete-form-{{ $bank->id }}" action="{{ route('templeuser.deletebank', $bank->id) }}" method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $bank->id }})"><i class="fa fa-trash"></i></button>
                                                                </form>                                                                
                                                                
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="8" class="text-center">No bank details found.</td>
                                                    </tr>
                                                @endif
                                                
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