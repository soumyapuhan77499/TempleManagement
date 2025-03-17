@extends('templeuser.layouts.app')

@section('styles')
    <!-- INTERNAL Select2 css -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <!-- INTERNAL Data table css -->
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Add Festival</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Festival</li>
            </ol>
        </div>
    </div>

    <!-- row  -->
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">

                <div class="card-body pt-0 pt-4">
                    <form method="POST" action="{{ route('templefestival.storeFestival') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="festival_name">Festival Name <span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="festival_name" name="festival_name"
                                        placeholder="Enter Festival Name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="start_date">Start Date <span style="color:red">*</span></label>
                                    <input type="date" class="form-control" id="start_date" name="start_date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="festival_photos">Festival Photos</label>
                                    <input type="file" class="form-control" id="festival_photos" name="festival_photos[]"
                                        multiple>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="live_url">Live URL</label>
                                    <input type="url" class="form-control" id="live_url" name="live_url"
                                        placeholder="Enter Live URL">
                                </div>
                            </div>

                            <div class="col-12">
								<div class="row">
									<h4>Sub Festivals</h4>
									<button type="button" class="btn btn-secondary btn-sm" id="add-sub-festival">Add</button>
								</div>
                               

                                <div id="sub-festivals">
                                    <div class="sub-festival">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="sub_festival_name">Sub Festival Name</label>
                                                    <input type="text" class="form-control" name="sub_festival_name[]"
                                                        placeholder="Enter Sub Festival Name">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="sub_festival_date">Date</label>
                                                    <input type="date" class="form-control" name="sub_festival_date[]">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="sub_festival_photo">Photo</label>
                                                    <input type="file" class="form-control" name="sub_festival_photo[]">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="sub_festival_time">Time</label>
                                                    <input type="time" class="form-control" name="sub_festival_time[]">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="festival_descp">Festival Description <span style="color:red">*</span></label>
                            <textarea name="festival_descp" class="form-control" id="festival_descp" placeholder="Enter Festival Description"
                                required></textarea>
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
    <script>
        document.getElementById('add-sub-festival').addEventListener('click', function() {
            var subFestivalTemplate = `
        <div class="sub-festival">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="sub_festival_name">Sub Festival Name</label>
                        <input type="text" class="form-control" name="sub_festival_name[]" placeholder="Enter Sub Festival Name">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="sub_festival_date">Date</label>
                        <input type="date" class="form-control" name="sub_festival_date[]">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="sub_festival_photo">Photo</label>
                        <input type="file" class="form-control" name="sub_festival_photo[]">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="sub_festival_time">Time</label>
                        <input type="time" class="form-control" name="sub_festival_time[]">
                    </div>
                </div>
				<div class="col-md-1">
					<button type="button" class="btn btn-danger remove-sub-festival btn-sm" style="margin-top:30px;">Remove</button>
                </div>

            </div>
        </div>
    `;
            document.getElementById('sub-festivals').insertAdjacentHTML('beforeend', subFestivalTemplate);
        });

        // Event delegation to remove a sub-festival section
        document.getElementById('sub-festivals').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-sub-festival')) {
                e.target.closest('.sub-festival').remove();
            }
        });
    </script>

	
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@if (session('success'))
	<script>
		Swal.fire({
			icon: 'success',
			title: 'Success!',
			text: "{{ session('success') }}",
		});
	</script>
@endif

@if (session('error'))
	<script>
		Swal.fire({
			icon: 'error',
			title: 'Oops...',
			text: "{{ session('error') }}",
		});
	</script>
@endif

@if ($errors->any())
	<script>
		let errorMessages = `<ul style='text-align: left;'>`;
		@foreach ($errors->all() as $error)
			errorMessages += `<li>{{ $error }}</li>`;
		@endforeach
		errorMessages += `</ul>`;

		Swal.fire({
			icon: 'error',
			title: 'Validation Errors',
			html: errorMessages, // Use 'html' instead of 'text' for multiple errors
		});
	</script>
@endif
@endsection
