@extends('templeuser.layouts.app')

@section('styles')
    <!-- Data table css -->
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}" rel="stylesheet" />

    <!-- INTERNAL Select2 css -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Emergency</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <a href="{{ url('templeuser/add-emergency') }}" class="breadcrumb-item tx-15 btn btn-warning">Add Emergency</a>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="table-responsive  export-table">
                        <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                            <thead>
                                <tr>
                                    <th>SlNo</th>
                                    <th>Emergency Type</th>
                                    <th>Contact No</th>
                                    <th>Google Map Link</th>
                                    <th>Address</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($emergencys as $index => $emergency)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $emergency->type }}</td>
                                        <td>{{ $emergency->contact_no }}</td>
                                        <td>
                                            <a href="{{ $emergency->google_map_link }}" target="_blank" class="btn btn-info btn-sm">View Map</a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#addressModal{{ $emergency->id }}">
                                                View Address
                                            </button>
                                            <div class="modal fade" id="addressModal{{ $emergency->id }}" tabindex="-1" aria-labelledby="addressModalLabel{{ $emergency->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Commute Address</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>City/Village:</strong> {{ $emergency->city_village }}</p>
                                                            <p><strong>Landmark:</strong> {{ $emergency->landmark }}</p>
                                                            <p><strong>Pincode:</strong> {{ $emergency->pincode }}</p>
                                                            <p><strong>District:</strong> {{ $emergency->district }}</p>
                                                            <p><strong>State:</strong> {{ $emergency->state }}</p>
                                                            <p><strong>Country:</strong> {{ $emergency->country }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $emergency->description }}</td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $emergency->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            |
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-confirm" data-id="{{ $emergency->id }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="editModal{{ $emergency->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $emergency->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Emergency</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('updateEmergency', $emergency->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="emergency_type">Emergency Type</label>
                                                                <select class="form-control" name="emergency_type">
                                                                    <option value="police" {{ $emergency->type == 'police' ? 'selected' : '' }}>Police</option>
                                                                    <option value="ambulance" {{ $emergency->type == 'ambulance' ? 'selected' : '' }}>Ambulance</option>
                                                                    <option value="fire" {{ $emergency->type == 'fire' ? 'selected' : '' }}>Fire</option>
                                                                    <option value="hospital" {{ $emergency->type == 'hospital' ? 'selected' : '' }}>Hospital</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="contact_no">Contact No</label>
                                                                <input type="text" class="form-control" name="contact_no" value="{{ $emergency->contact_no }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="google_map_link">Google Map Link</label>
                                                                <input type="text" class="form-control" name="google_map_link" value="{{ $emergency->google_map_link }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="landmark">Landmark</label>
                                                                <input type="text" class="form-control" name="landmark" value="{{ $emergency->landmark }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="pincode">Pincode</label>
                                                                <input type="text" class="form-control" name="pincode" value="{{ $emergency->pincode }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="city_village">City/Village</label>
                                                                <input type="text" class="form-control" name="city_village" value="{{ $emergency->city_village }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="district">District</label>
                                                                <input type="text" class="form-control" name="district" value="{{ $emergency->district }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="state">State</label>
                                                                <input type="text" class="form-control" name="state" value="{{ $emergency->state }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="country">Country</label>
                                                                <input type="text" class="form-control" name="country" value="{{ $emergency->country }}">
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label for="description">Description</label>
                                                                <textarea class="form-control" name="description">{{ $emergency->description }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/table-data.js') }}"></script>

    <!-- INTERNAL Select2 js -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.body.addEventListener('click', function(event) {
                if (event.target.closest('.delete-confirm')) {
                    let commuteId = event.target.closest('.delete-confirm').getAttribute('data-id');

                    Swal.fire({
                        title: "Are you sure?",
                        text: "This will mark the Commute as deleted but won't permanently remove it.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `/templeuser/delete-commute/${commuteId}`;
                        }
                    });
                }
            });
        });
    </script>


    <script>
        function showFullImage(imageSrc) {
            Swal.fire({
                imageUrl: imageSrc,
                imageAlt: 'Matha Photo',
                showCloseButton: true,
                showConfirmButton: false,
            });
        }
    </script>



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
            let errorMessages = "";
            @foreach ($errors->all() as $error)
                errorMessages += "{{ $error }}\n";
            @endforeach
            Swal.fire({
                icon: 'error',
                title: 'Validation Errors',
                text: errorMessages,
            });
        </script>
    @endif
@endsection
