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
						<span class="main-content-title mg-b-0 mg-b-lg-1">Temple Photos/Videos</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page">Temple Photos/Videos</li>
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
											<form action="{{ route('temple.updatePhotosvideos') }}" method="POST" enctype="multipart/form-data">
												@csrf
												@method('PUT')
											
												<!-- Temple Images Field -->
												<div class="form-group">
													<label for="temple_images">Temple Images</label>
													<input type="file" class="form-control" id="temple_images" name="temple_images[]" multiple onchange="previewFiles('temple_images', 'imagePreview')">
													
													<!-- Existing Image Previews -->
													<div id="imagePreview" class="mt-2">
														@if(isset($templeSocialMedia->temple_images))
															@foreach($templeSocialMedia->temple_images as $key => $image)
															<div class="image-wrapper" style="position: relative; display: inline-block; margin: 5px;">
																<img src="{{ asset('storage/' . $image) }}" style="width: 150px; border-radius: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" alt="Temple Image">
																<button type="button" class="remove-btn" onclick="removeMedia('{{ $image }}', 'image', {{ $key }})" style="position: absolute; top: 5px; right: 5px; background: red; color: white; border: none; border-radius: 50%; cursor: pointer;">&times;</button>
															</div>
															@endforeach
														@endif
													</div>
												</div>

												<!-- Temple Videos Field -->
												<div class="form-group">
													<label for="temple_videos">Temple Videos</label>
													<input type="file" class="form-control" id="temple_videos" name="temple_videos[]" multiple onchange="previewFiles('temple_videos', 'videoPreview')">
													
													<!-- Existing Video Previews -->
													<div id="videoPreview" class="mt-2">
														@if(isset($templeSocialMedia->temple_videos))
															@foreach($templeSocialMedia->temple_videos as $key => $video)
															<div class="video-wrapper" style="position: relative; display: inline-block; margin: 5px;">
																<video src="{{ asset('storage/' . $video) }}" controls style="width: 300px; border-radius: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"></video>
																<button type="button" class="remove-btn" onclick="removeMedia('{{ $video }}', 'video', {{ $key }})" style="position: absolute; top: 5px; right: 5px; background: red; color: white; border: none; border-radius: 50%; cursor: pointer;">&times;</button>
															</div>
															@endforeach
														@endif
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
