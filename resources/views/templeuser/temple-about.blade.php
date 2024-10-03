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

					


				
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
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
					<!-- row  -->
					<div class="row">
						<div class="col-12 col-sm-12 mt-4">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Temple About</h4>
								</div>
								<div class="card-body pt-0 example1-table">
									<form action="{{ route('temple_about_details.update', $temple->temple_id ?? '') }}" method="POST" enctype="multipart/form-data">
										@csrf
										@method('PUT')
									
										<!-- Temple About Field -->
										<div class="form-group">
											<label for="temple_about">Temple About</label>
											<textarea name="temple_about" class="form-control" id="temple_about" cols="30" rows="5">{{ old('temple_about', $temple->temple_about ?? '') }}</textarea>
										</div>
									
										<!-- Temple History Field -->
										<div class="form-group">
											<label for="temple_history">Temple History</label>
											<textarea name="temple_history" class="form-control" id="temple_history" cols="30" rows="5">{{ old('temple_history', $temple->temple_history ?? '') }}</textarea>
										</div>
									
										<!-- Endowment Checkbox and Fields -->
										<div class="form-check">
											<input type="checkbox" class="form-check-input" id="endowment_checkbox" name="endowment" value="endowment" {{ $temple && $temple->endowment ? 'checked' : '' }}>
											<label class="form-check-label" for="endowment_checkbox">Endowment</label>
										</div>
									
										<div id="endowment_fields" class="mt-2" style="display: {{ $temple && $temple->endowment ? 'block' : 'none' }};">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="endowment_register_no">Endowment Register No.</label>
														<input type="text" class="form-control" id="endowment_register_no" name="endowment_register_no" value="{{ old('endowment_register_no', $temple->endowment_register_no ?? '') }}">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="endowment_document">Upload Endowment Document</label>
														<input type="file" class="form-control" id="endowment_document" name="endowment_document">
														@if($temple && $temple->endowment_document)
														<div class="mt-2">
															<label>Current Endowment Document:</label>
															<div>
																<!-- View Image Button -->
																<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#imageModal">
																	View Image
																</button>
															</div>
														</div>
									
														<!-- Modal for Viewing the Image -->
														<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
															<div class="modal-dialog modal-dialog-centered">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="imageModalLabel">Endowment Document</h5>
																		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
																	</div>
																	<div class="modal-body text-center">
																		<img src="{{ asset('storage/' . $temple->endowment_document) }}" alt="Endowment Document" style="max-width: 100%; height: auto; border-radius: 5px;">
																	</div>
																</div>
															</div>
														</div>
														@else
														<p>No Endowment Document available.</p>
														@endif
													</div>
												</div>
											</div>
										</div>
									
										<!-- Trust Checkbox and Fields -->
										<div class="form-check">
											<input type="checkbox" class="form-check-input" id="trust_checkbox" name="trust" value="trust" {{ $temple && $temple->trust ? 'checked' : '' }}>
											<label class="form-check-label" for="trust_checkbox">Trust</label>
										</div>
									
										<div id="trust_fields" class="mt-2" style="display: {{ $temple && $temple->trust ? 'block' : 'none' }};">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="trust_register_no">Trust Register No.</label>
														<input type="text" class="form-control" id="trust_register_no" name="trust_register_no" value="{{ old('trust_register_no', $temple->trust_register_no ?? '') }}">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="trust_document">Upload Trust Document</label>
														<input type="file" class="form-control" id="trust_document" name="trust_document">
														@if($temple && $temple->trust_document)
														<div class="mt-2">
															<label>Current Trust Document:</label>
															<div>
																<!-- View Image Button -->
																<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#trustDocumentModal">
																	View Image
																</button>
															</div>
														</div>
									
														<!-- Modal for Viewing the Trust Document -->
														<div class="modal fade" id="trustDocumentModal" tabindex="-1" aria-labelledby="trustDocumentModalLabel" aria-hidden="true">
															<div class="modal-dialog modal-dialog-centered">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="trustDocumentModalLabel">Trust Document</h5>
																		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
																	</div>
																	<div class="modal-body text-center">
																		<img src="{{ asset('storage/' . $temple->trust_document) }}" alt="Trust Document" style="max-width: 100%; height: auto; border-radius: 5px;">
																	</div>
																</div>
															</div>
														</div>
														@else
														<p>No Trust Document available.</p>
														@endif
													</div>
												</div>
											</div>
										</div>
									
										<button type="submit" class="btn btn-primary">Submit</button>
									
										<!-- Display message if no details are available -->
										@if (!$temple)
											<div class="alert alert-warning mt-3">No details available for this temple.</div>
										@endif
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
		<!-- TinyMCE Script -->
		<script src="{{asset('tinymce/tinymce.min.js')}}" referrerpolicy="origin"></script>

		<script>
			tinymce.init({
				selector: '#temple_about,#temple_history,#content',
				height: 300,
			plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap emoticons',
			menubar: 'file edit view insert format tools table help',
			toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
		toolbar_sticky: false,
		image_advtab: true,
			external_filemanager_path:"filemanager/",
		filemanager_title:"Filemanager" ,
		external_plugins: { "filemanager" : "../filemanager/plugin.min.js"},
		content_css: [
			'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
			'//www.tiny.cloud/css/codepen.min.css'
		],
		extended_valid_elements: 'span[class=]',
		importcss_append: false,

		});

		</script>
		<script>
			// tinymce.init({
			// 	selector: 'textarea',
			// 	plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
			// 	toolbar_mode: 'floating',
			// });

			// Display additional fields based on checkbox selection
			document.addEventListener("DOMContentLoaded", function() {
    const endowmentCheckbox = document.getElementById('endowment_checkbox');
    const trustCheckbox = document.getElementById('trust_checkbox');
    
    const endowmentFields = document.getElementById('endowment_fields');
    const trustFields = document.getElementById('trust_fields');
    
    // Toggle endowment fields
    endowmentCheckbox.addEventListener('change', function() {
        endowmentFields.style.display = this.checked ? 'block' : 'none';
    });

    // Toggle trust fields
    trustCheckbox.addEventListener('change', function() {
        trustFields.style.display = this.checked ? 'block' : 'none';
    });

    // Set initial visibility based on whether checkboxes are checked
    if (endowmentCheckbox.checked) {
        endowmentFields.style.display = 'block';
    }
    
    if (trustCheckbox.checked) {
        trustFields.style.display = 'block';
    }
});

		</script>

    @endsection
