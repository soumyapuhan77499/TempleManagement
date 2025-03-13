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
            <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Parking</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <a href="{{ url('templeuser/add-parking') }}" class="breadcrumb-item tx-15 btn btn-warning">Add Parking</a>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Parking</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->


    @if (session('success'))
        <div id = 'Message' class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('danger'))
        <div id = 'Message' class="alert alert-danger">
            {{ session('danger') }}
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
                                    <th class="border-bottom-0">SlNo</th>
                                    <th class="border-bottom-0">Vehicle Type</th>
                                    <th class="border-bottom-0">Pass Type</th>
                                    <th class="border-bottom-0">Area Type</th>
                                    <th class="border-bottom-0">Management</th>
                                    <th class="border-bottom-0">Parking Name</th>
                                    <th class="border-bottom-0">Availability</th>
                                    <th class="border-bottom-0">Map URL</th>
                                    <th class="border-bottom-0">Photo</th>
                                    <th class="border-bottom-0">Address</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parkings as $parking)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <!-- Vehicle Type as Badges -->
                                        <td>
                                            @foreach (json_decode($parking->vehicle_type, true) as $vehicle)
                                                <span class="badge bg-primary">{{ $vehicle }}</span>
                                            @endforeach
                                        </td>

                                        <!-- Pass Type as Badges -->
                                        <td>
                                            @foreach (json_decode($parking->pass_type, true) as $pass)
                                                <span class="badge bg-success">{{ $pass }}</span>
                                            @endforeach
                                        </td>

                                        <!-- Area Type as Badges -->
                                        <td>
                                            @foreach (json_decode($parking->area_type, true) as $area)
                                                <span class="badge bg-warning text-dark">{{ $area }}</span>
                                            @endforeach
                                        </td>

                                        <!-- Parking Management as Badges -->
                                        <td>
                                            @foreach (json_decode($parking->parking_management, true) as $management)
                                                <span class="badge bg-info">{{ $management }}</span>
                                            @endforeach
                                        </td>
                                        <td>{{ $parking->parking_name }}</td>
                                        <td>{{ $parking->parking_availability }}</td>
                                        <td>{{ $parking->map_url }}</td>
                                        <td>
                                            <a href="{{ asset($parking->parking_photo) }}" target="_blank"
                                                class="btn btn-primary btn-sm">View Photo</a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#addressModal{{ $parking->id }}">
                                                View Address
                                            </button>
                                        </td>

                                        <td style="color:#B7070A; font-size: 15px">
                                            <a class="cursor-pointer btn btn-success btn-sm"
                                                href="{{ url('templeuser/edit-parking/' . $parking->id) }}"><i
                                                    class="fa fa-edit"></i></a> |
                                            <a class="cursor-pointer btn btn-danger btn-sm"
                                                href="{{ url('admin/delete-parking/' . $parking->id) }}"><i
                                                    class="fa fa-trash"></i></a>
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
    @foreach ($parkings as $parking)
        <div class="modal fade" id="addressModal{{ $parking->id }}" tabindex="-1"
            aria-labelledby="addressModalLabel{{ $parking->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addressModalLabel{{ $parking->id }}">Parking Address Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>City/Village:</strong> {{ $parking->city_village }}</p>
                        <p><strong>Landmark:</strong> {{ $parking->landmark }}</p>
                        <p><strong>Pincode:</strong> {{ $parking->pincode }}</p>
                        <p><strong>District:</strong> {{ $parking->district }}</p>
                        <p><strong>State:</strong> {{ $parking->state }}</p>
                        <p><strong>Country:</strong> {{ $parking->country }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

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
    <script>
        setTimeout(function() {
            document.getElementById('Message').style.display = 'none';
        }, 3000);
    </script>
@endsection
