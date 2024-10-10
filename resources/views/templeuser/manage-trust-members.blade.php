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
							<div class="col-lg-12">
								<div class="card custom-card overflow-hidden">
									<div class="card-body">
										
										<div class="table-responsive  export-table">
                                            <table class="table table-bordered text-nowrap key-buttons border-bottom">
                                                <thead>
                                                    <tr>
                                                        <th class="border-bottom-0">#</th> <!-- Index column -->
                                                        <th class="border-bottom-0">Name</th>
                                                        <th class="border-bottom-0">Designation</th>
                                                        <th class="border-bottom-0">About</th>
                                                        <th class="border-bottom-0">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($trustmembers as $index => $trustmember)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td class="tb-col">
                                                            <div class="media-group">
                                                                <div class="media media-md media-middle media-circle">
                                                                    <img src="{{ asset('storage/' .$trustmember->member_photo) }}" alt="user" style="width: 50px; height: 50px;"> <!-- Adjust image size -->
                                                                </div>
                                                                <div class="media-text" style="color: blue">
                                                                    <a style="color: blue" href="#" class="title">{{ $trustmember->member_name }}</a> <!-- Corrected to member_name -->
                                                                    <span class="small text">{{ $trustmember->member_contact_no }}</span> <!-- Assuming contact_number exists -->
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ $trustmember->member_designation }}</td> <!-- Assuming member_designation exists -->
                                                        <td>{{ $trustmember->about_member }}</td> <!-- Assuming about_member exists -->
                                                        <td>
                                                            <!-- Actions (edit/delete buttons, etc.) can be added here -->
                                                            <a href="{{ route('templeuser.editTrustMember', $trustmember->id) }}" class="btn btn-warning">Edit</a>

															<form id="delete-form-{{ $trustmember->id }}" action="{{ route('templeuser.deleteTrustMember', $trustmember->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $trustmember->id }})"><i class="fa fa-trash"></i></button>
                                                            </form>

                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

											<button class="btn btn-primary">Deactive</button>
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
