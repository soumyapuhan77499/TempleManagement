@extends('templeuser.layouts.app')

    @section('styles')
	<meta name="csrf-token" content="{{ csrf_token() }}">

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
						<span class="main-content-title mg-b-0 mg-b-lg-1">SOCIAL MEDIA</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page">SocialMedia</li>
							</ol>
						</div>
					</div>
					<!-- /breadcrumb -->
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
							<!-- row  -->
							<div class="row">
								<div class="col-12 col-sm-12">
									<div class="card">
										{{-- <div class="card-header">
											<h4 class="card-title">Temple About</h4>
										</div> --}}
										<div class="card-body pt-0 pt-4">
											<form action="{{ route('temple.social-media.update') }}" method="POST" enctype="multipart/form-data">
												@csrf
												@method('PUT')
											
											
												<!-- Social Media URLs -->
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="temple_yt_url">YouTube URL</label>
															<input type="text" placeholder="Enter YouTube URL" class="form-control" id="temple_yt_url" name="temple_yt_url" value="{{ old('temple_yt_url', $templeSocialMedia->temple_yt_url ?? '') }}">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="temple_ig_url">Instagram URL</label>
															<input type="text" placeholder="Enter Instagram URL" class="form-control" id="temple_ig_url" name="temple_ig_url" value="{{ old('temple_ig_url', $templeSocialMedia->temple_ig_url ?? '') }}">
														</div>
													</div>
												</div>
											
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="temple_fb_url">Facebook URL</label>
															<input type="text" placeholder="Enter Facebook URL" class="form-control" id="temple_fb_url" name="temple_fb_url" value="{{ old('temple_fb_url', $templeSocialMedia->temple_fb_url ?? '') }}">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="temple_x_url">Twitter URL</label>
															<input type="text" placeholder="Enter Twitter URL" class="form-control" id="temple_x_url" name="temple_x_url" value="{{ old('temple_x_url', $templeSocialMedia->temple_x_url ?? '') }}">
														</div>
													</div>
												</div>
											
												<button type="submit" class="btn btn-primary">Submit</button>
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
			function previewFiles(inputId, previewContainerId) {
				const input = document.getElementById(inputId);
				const previewContainer = document.getElementById(previewContainerId);
				
				previewContainer.innerHTML = ''; // Clear previous previews
			
				const files = input.files;
				if (files.length === 0) return;
			
				for (let i = 0; i < files.length; i++) {
					const file = files[i];
					const reader = new FileReader();
			
					reader.onload = function(e) {
						const fileUrl = e.target.result;
						const fileType = file.type;
			
						let element;
						if (fileType.startsWith('image/')) {
							element = document.createElement('img');
							element.src = fileUrl;
							element.style.width = '150px';
							element.style.margin = '5px';
						} else if (fileType.startsWith('video/')) {
							element = document.createElement('video');
							element.src = fileUrl;
							element.controls = true;
							element.style.width = '300px';
							element.style.margin = '5px';
						}
			
						if (element) {
							previewContainer.appendChild(element);
						}
					};
			
					reader.readAsDataURL(file);
				}
			}
		</script>
		<script>
			function removeMedia(filePath, mediaType, index) {
					if (confirm('Are you sure you want to remove this ' + mediaType + '?')) {
						// Send an AJAX request to the server to delete the media
						// You can implement the backend route and controller to handle this request
						$.ajax({
							url: '{{ route("remove.media") }}', // Correctly referencing Laravel route
							method: 'POST',
							data: {
								_token: '{{ csrf_token() }}',
								filePath: filePath,
								mediaType: mediaType,
								index: index
							},
							success: function(response) {
								if (response.success) {
									alert(mediaType + ' removed successfully.');
									location.reload(); // Optionally reload the page to update the UI
								} else {
									alert('Failed to remove ' + mediaType + '.');
								}
							},
							error: function(xhr, status, error) {
								console.log(xhr.responseText); // Log the full error to the console
								alert('Error while removing ' + mediaType + '.');
							}
						});

					}
				}

		</script>
			
    @endsection
