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
            <span class="main-content-title mg-b-0 mg-b-lg-1">MANAGE ACCOMODATION</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <a href="{{ url('templeuser/add-accomodation') }}" class="breadcrumb-item tx-15 btn btn-warning">Add Accomodation</a>
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
                                    <th>Name</th>
                                    <th>Photo</th>
                                    <th>Map Link</th>
                                    <th>Type</th>
                                    <th>Food Type</th>
                                    <th>Contact No</th>
                                    <th>WhatsApp No</th>
                                    <th>Email</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Opening Time</th>
                                    <th>Closing Time</th>
                                    <th>Address</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accomodations as $index => $accomodation)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $accomodation->name }}</td>

                                        {{-- Display multiple photos correctly --}}
                                        <td>
                                            @if ($accomodation->photo)
                                                @php
                                                    $photos = json_decode($accomodation->photo, true);
                                                @endphp
                                                @if (is_array($photos) && count($photos) > 0)
                                                    <!-- Button to Open Modal -->
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#imageModal{{ $accomodation->id }}">
                                                        View Images
                                                    </button>

                                                    <!-- Image Modal -->
                                                    <div class="modal fade" id="imageModal{{ $accomodation->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="imageModalLabel{{ $accomodation->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="imageModalLabel{{ $accomodation->id }}">
                                                                        Accomodation Images</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    @foreach ($photos as $photo)
                                                                        <img src="{{ asset($photo) }}" alt="Photo"
                                                                            class="img-fluid rounded m-2"
                                                                            style="width: 100px; height: 100px;">
                                                                    @endforeach
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    No Image
                                                @endif
                                            @else
                                                No Image
                                            @endif
                                        </td>

                                        <td>
                                            <a class="btn btn-info btn-sm" href="{{ $accomodation->google_map_link }}"
                                                target="_blank">View Map</a>
                                        </td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $accomodation->accomodation_type)) }}</td>
                                        <td>{{ $accomodation->food_type }}</td>
                                        <td>{{ $accomodation->contact_no }}</td>
                                        <td>{{ $accomodation->whatsapp_no }}</td>
                                        <td>{{ $accomodation->email }}</td>
                                        <td>{{ $accomodation->check_in_time ? date('h:i A', strtotime($accomodation->check_in_time)) : 'N/A' }}
                                        </td>
                                        <td>{{ $accomodation->check_out_time ? date('h:i A', strtotime($accomodation->check_out_time)) : 'N/A' }}
                                        </td>
                                        <td>{{ $accomodation->opening_time ? date('h:i A', strtotime($accomodation->opening_time)) : 'N/A' }}
                                        </td>
                                         <td>{{ $accomodation->closing_time ? date('h:i A', strtotime($accomodation->closing_time)) : 'N/A' }}
                                        </td>
                                        <td>
                                            <!-- Button to Open Address Modal -->
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#addressModal{{ $accomodation->id }}">
                                                View Address
                                            </button>

                                            <!-- Address Modal -->
                                            <div class="modal fade" id="addressModal{{ $accomodation->id }}" tabindex="-1"
                                                aria-labelledby="addressModalLabel{{ $accomodation->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="addressModalLabel{{ $accomodation->id }}">Accommodation
                                                                Address</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ $accomodation->address }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <!-- Button to Open Description Modal -->
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#descriptionModal{{ $accomodation->id }}">
                                                View Description
                                            </button>

                                            <!-- Description Modal -->
                                            <div class="modal fade" id="descriptionModal{{ $accomodation->id }}"
                                                tabindex="-1"
                                                aria-labelledby="descriptionModalLabel{{ $accomodation->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="descriptionModalLabel{{ $accomodation->id }}">
                                                                Accommodation Description</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ $accomodation->description }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>


                                        {{-- Action Buttons --}}
                                        <td>
                                            <a class="btn btn-success btn-sm"
                                                href="{{ url('templeuser/edit-accomodation/' . $accomodation->id) }}">
                                                <i class="fa fa-edit"></i>
                                            </a> |
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-confirm"
                                                data-id="{{ $accomodation->id }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
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
<!-- Add Bootstrap JS and jQuery if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- INTERNAL Select2 js -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.body.addEventListener('click', function(event) {
                if (event.target.closest('.delete-confirm')) {
                    let accomodationId = event.target.closest('.delete-confirm').getAttribute('data-id');

                    Swal.fire({
                        title: "Are you sure?",
                        text: "This will mark the Accomodation as deleted but won't permanently remove it.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href =
                                `/templeuser/delete-accomodation/${accomodationId}`;
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
