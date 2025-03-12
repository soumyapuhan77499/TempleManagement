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
            <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Commute</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <a href="{{ url('templeuser/add-commute') }}" class="breadcrumb-item tx-15 btn btn-warning">Add Commute</a>
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
                                    <th>Commute Type</th>
                                    <th>Name</th>
                                    <th>Photo</th>
                                    <th>Google Map Link</th>
                                    <th>Address</th>
                                    <th>Distance From</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($commutes as $index => $commute)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $commute->commute_type }}</td>
                                        <td>{{ $commute->name }}</td>
                                        <td>
                                            @if ($commute->photo)
                                                @php
                                                    $photos = json_decode($commute->photo, true);
                                                @endphp
                                                @if (is_array($photos) && count($photos) > 0)
                                                    <!-- Button to Open Modal -->
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#imageModal{{ $commute->id }}">
                                                        View Image
                                                    </button>

                                                    <!-- Image Modal -->
                                                    <div class="modal fade" id="imageModal{{ $commute->id }}"
                                                        tabindex="-1" aria-labelledby="imageModalLabel{{ $commute->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="imageModalLabel{{ $commute->id }}">
                                                                        Commute Images</h5>
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
                                            <a href="{{ $commute->google_map_link }}" target="_blank"
                                                class="btn btn-info btn-sm">View Map</a>
                                        </td>
                                        <td>
                                            <!-- Button to Open Address Modal -->
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#addressModal{{ $commute->id }}">
                                                View Address
                                            </button>

                                            <!-- Address Modal -->
                                            <div class="modal fade" id="addressModal{{ $commute->id }}" tabindex="-1"
                                                aria-labelledby="addressModalLabel{{ $commute->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="addressModalLabel{{ $commute->id }}">Commute
                                                                Address</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <p><strong>City/Village:</strong> {{ $commute->city_village }}
                                                            </p>
                                                            <p><strong>Landmark:</strong> {{ $commute->landmark }}</p>
                                                            <p><strong>Pincode:</strong> {{ $commute->pincode }}</p>
                                                            <p><strong>District:</strong> {{ $commute->district }}</p>
                                                            <p><strong>State:</strong> {{ $commute->state }}</p>
                                                            <p><strong>Country:</strong> {{ $commute->country }}</p>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $commute->distance_from_temple }}</td>
                                        <td>{{ $commute->description }}</td>

                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $commute->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>|
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-confirm"
                                                data-id="{{ $commute->id }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $commute->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel{{ $commute->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Commute</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('updateCommute', $commute->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="commute_type">Commute Type</label>
                                                                <select class="form-control" name="commute_type">
                                                                    <option value="airport"
                                                                        {{ $commute->commute_type == 'airport' ? 'selected' : '' }}>
                                                                        Airport</option>
                                                                    <option value="bus"
                                                                        {{ $commute->commute_type == 'bus' ? 'selected' : '' }}>
                                                                        Bus</option>
                                                                    <option value="railway"
                                                                        {{ $commute->commute_type == 'railway' ? 'selected' : '' }}>
                                                                        Railway</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="name">Name of Commute</label>
                                                                <input type="text" class="form-control" name="name"
                                                                    value="{{ $commute->name }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="photo">Photo (Upload New)</label>
                                                                <input type="file" class="form-control" name="photo[]"
                                                                    multiple>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="google_map_link">Google Map Link</label>
                                                                <input type="url" class="form-control"
                                                                    name="google_map_link"
                                                                    value="{{ $commute->google_map_link }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="distance">Distance from Temple</label>
                                                                <input type="text" class="form-control"
                                                                    name="distance"
                                                                    value="{{ $commute->distance_from_temple }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="city_village">City/Village</label>
                                                                <input type="text" class="form-control"
                                                                    name="city_village"
                                                                    value="{{ $commute->city_village }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="landmark">Landmark</label>
                                                                <input type="text" class="form-control"
                                                                    name="landmark" value="{{ $commute->landmark }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="pincode">Pincode</label>
                                                                <input type="text" class="form-control" name="pincode"
                                                                    value="{{ $commute->pincode }}">
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label for="description">Description</label>
                                                                <textarea class="form-control" name="description">{{ $commute->description }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
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
