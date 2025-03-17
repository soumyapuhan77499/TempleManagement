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
            <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Festivals</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Festivals</li>
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

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div>
                        <h6 class="main-content-label mb-1">Manage Festivals</h6>
                    </div>
                    <div class="table-responsive  export-table">
                        <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Festival Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Photo</th>
                                    <th>Live URL</th>
                                    <th>Sub Festival</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($festivals as $index => $festival)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $festival->festival_name }}</td>
                                        <td>{{ $festival->start_date }}</td>
                                        <td>{{ $festival->end_date }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#photoModal{{ $festival->id }}">
                                                View Photos
                                            </button>
                                        </td>
                                        <td><a href="{{ $festival->live_url }}" class="btn btn-success btn-sm" target="_blank">Live Link</a></td>
                                        <td>
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#subFestivalModal{{ $festival->id }}">
                                                View Sub Festivals
                                            </button>
                                        </td>
                                        <td>{{ Str::limit($festival->festival_descp, 50) }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm">Edit</button>
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>

                                    <!-- Festival Photos Modal -->
                                    <div class="modal fade" id="photoModal{{ $festival->id }}" tabindex="-1"
                                        aria-labelledby="photoModalLabel{{ $festival->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Festival Photos -
                                                        {{ $festival->festival_name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        @php
                                                            $photos = json_decode($festival->photo, true);
                                                        @endphp
                                                        @if (!empty($photos))
                                                            @foreach ($photos as $photo)
                                                                <div class="col-md-4 mb-3">
                                                                    <img src="{{ asset($photo) }}"
                                                                        class="img-fluid rounded" alt="Festival Photo">
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <p>No photos available.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Sub-Festival Modal -->
                                    <!-- Sub-Festival Modal -->
                                    <div class="modal fade" id="subFestivalModal{{ $festival->id }}" tabindex="-1"
                                        aria-labelledby="subFestivalModalLabel{{ $festival->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Sub-Festival Details -
                                                        {{ $festival->festival_name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if ($festival->subFestivals->count() > 0)
                                                        <div class="row">
                                                            @foreach ($festival->subFestivals as $subFestival)
                                                                <div class="col-md-6">
                                                                    <div class="card mb-3 shadow-sm">
                                                                        <div class="card-body">
                                                                            <h6 class="card-title">
                                                                                <strong>{{ $subFestival->sub_festival_name }}</strong>
                                                                            </h6>
                                                                            <p class="card-text">
                                                                                <small><b>Date:</b>
                                                                                    {{ $subFestival->sub_festival_date }}</small><br>
                                                                                <small><b>Time:</b>
                                                                                    {{ $subFestival->sub_festival_time }}</small>
                                                                            </p>

                                                                            <!-- Display Sub-Festival Photo -->
                                                                            @if ($subFestival->sub_festival_photo)
                                                                                <div class="text-center">
                                                                                    <img src="{{ asset($subFestival->sub_festival_photo) }}"
                                                                                        class="img-fluid rounded shadow-sm"
                                                                                        alt="Sub-Festival Photo"
                                                                                        style="max-width: 100%; height: 180px; object-fit: cover;">
                                                                                </div>
                                                                            @else
                                                                                <p class="text-muted">No photo available.
                                                                                </p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <p class="text-muted">No sub-festivals available.</p>
                                                    @endif
                                                </div>
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
