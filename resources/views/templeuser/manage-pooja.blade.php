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
						  <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Pooja</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Tables</a></li>
								<li class="breadcrumb-item active" aria-current="page">Manage Pooja</li>
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
                                                        <th class="border-bottom-0">#</th> <!-- Index column -->
                                                        <th class="border-bottom-0">Pooja Name</th>
                                                        <th class="border-bottom-0">Price</th>
                                                        <th class="border-bottom-0">Pooja Image</th>
                                                        <th class="border-bottom-0">Pooja Description</th>
                                                        <th class="border-bottom-0">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($poojaList as $index => $pooja)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td> <!-- Display index -->
                                                        <td>{{ $pooja->pooja_name }}</td> <!-- Display pooja name -->
                                                        <td>₹ {{sprintf('%.2f', $pooja->pooja_price )}}</td> <!-- Display pooja price -->
                                                        <td>
                                                            @if($pooja->pooja_image)
                                                            <!-- View Image Button -->
                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#poojaImageModal{{ $pooja->id }}">
                                                                View Image
                                                            </button>
                                                            @else
                                                            <span>No Image</span>
                                                            @endif
                                                        </td>
                                                        
                                                        <!-- Modal for Viewing the Pooja Image -->
                                                        @if($pooja->pooja_image)
                                                        <div class="modal fade" id="poojaImageModal{{ $pooja->id }}" tabindex="-1" aria-labelledby="poojaImageModalLabel{{ $pooja->id }}" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="poojaImageModalLabel{{ $pooja->id }}">Pooja Image</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body text-center">
                                                                        <!-- Displaying the Pooja Image -->
                                                                        <img src="{{ asset('storage/' . $pooja->pooja_image) }}" alt="Pooja Image" style="max-width: 100%; height: auto; border-radius: 5px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        
                                                        <td>{{ $pooja->pooja_descp }}</td> <!-- Display pooja description -->
                                                        <td>
                                                            <!-- Edit button -->
                                                            <a href="{{ route('templepooja.editpooja', $pooja->id) }}" class="btn btn-warning">Edit</a>
                                         
                                                            <form id="delete-form-{{ $pooja->id }}" action="{{ route('templepooja.destroypooja', $pooja->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $pooja->id }})"><i class="fa fa-trash"></i></button>
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
