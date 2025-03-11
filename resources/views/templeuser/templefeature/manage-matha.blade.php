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
            <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Matha</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <a href="{{ url('templeuser/add-matha') }}" class="breadcrumb-item tx-15 btn btn-warning">Add Matha</a>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Matha</li>
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
                                    <th>SlNo</th>
                                    <th>Name</th>
                                    <th>Endowment</th>
                                    <th>Photo</th>
                                    <th>Description</th>
                                    <th>Address</th>
                                    <th>Relation With Temple</th>
                                    <th>Mahanta Name</th>
                                    <th>Estd Date</th>
                                    <th>Estd By</th>
                                    <th>Availability</th>
                                    <th>Map Link</th>
                                    <th>Contact No</th>
                                    <th>WhatsApp No</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mathas as $index => $matha)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $matha->matha_name }}</td>
                                        <td>{{ ucfirst($matha->endowment) }}</td>
                                        <td>
                                            @php
                                                $photos = json_decode($matha->photo, true);
                                            @endphp
                                            @if (!empty($photos))
                                                <!-- Button to Open Modal -->
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#mathaImagesModal{{ $matha->id }}">
                                                    View
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="mathaImagesModal{{ $matha->id }}"
                                                    tabindex="-1" aria-labelledby="mathaImagesModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Matha Images</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                @foreach ($photos as $photo)
                                                                    <img src="{{ asset($photo) }}" alt="Matha Photo"
                                                                        class="img-fluid m-2"
                                                                        style="max-width: 100px; cursor: pointer;"
                                                                        onclick="showFullImage('{{ asset($photo) }}')">
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#descModal{{ $matha->id }}">View</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#addressModal{{ $matha->id }}">View</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#relationModal{{ $matha->id }}">View</button>
                                        </td>

                                        <td>{{ $matha->mahanta_name ?? 'N/A' }}</td>
                                        <td>{{ date('d-m-Y', strtotime($matha->established_date)) }}</td>
                                        <td>{{ $matha->established_by }}</td>
                                        
                                        <td>{{ ucfirst($matha->availability) }}</td>
                                        <td><a href="{{ $matha->google_map_link }}" target="_blank">View Map</a></td>
                                        <td>{{ $matha->contact_no }}</td>
                                        <td>{{ $matha->whatsapp_no }}</td>
                                        <td>{{ $matha->email_id }}</td>
                                        
                                        <td>
                                            <a class="btn btn-success btn-sm"
                                                href="{{ url('templeuser/edit-matha/' . $matha->id) }}">
                                                <i class="fa fa-edit"></i>
                                            </a> |
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-confirm" data-id="{{ $matha->id }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Description Modal -->
                                    <div class="modal fade" id="descModal{{ $matha->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lg"> <!-- Added modal-lg for a large modal -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Matha Description</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ $matha->description }}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <!-- Added close button in footer -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Address Modal -->
                                    <div class="modal fade" id="addressModal{{ $matha->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lg"> <!-- Added modal-lg for a large modal -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Matha Address</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>City/Village:</strong> {{ $matha->city_village }}</p>
                                                    <p><strong>Landmark:</strong> {{ $matha->landmark }}</p>
                                                    <p><strong>Pincode:</strong> {{ $matha->pincode }}</p>
                                                    <p><strong>District:</strong> {{ $matha->district }}</p>
                                                    <p><strong>State:</strong> {{ $matha->state }}</p>
                                                    <p><strong>Country:</strong> {{ $matha->country }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <!-- Added close button in footer -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="relationModal{{ $matha->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lg"> <!-- Added modal-lg for a large modal -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Temple Relation With Matha</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ $matha->relation_with_temple }}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <!-- Added close button in footer -->
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
        document.addEventListener("DOMContentLoaded", function () {
            document.body.addEventListener('click', function (event) {
                if (event.target.closest('.delete-confirm')) {
                    let mathaId = event.target.closest('.delete-confirm').getAttribute('data-id');
    
                    Swal.fire({
                        title: "Are you sure?",
                        text: "This will mark the Matha as deleted but won't permanently remove it.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `/templeuser/delete-matha/${mathaId}`;
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

  

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: "{{ session('success') }}",
    });
</script>
@endif

@if(session('error'))
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
