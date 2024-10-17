@extends('templeuser.layouts.app')

@section('styles')
<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />

@endsection

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">MANAGE SPECIAL RITUAL</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Temple</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ritual</li>
            </ol>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="table-responsive export-table">
                        <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">SL NO.</th>
                                    <th class="border-bottom-0">SPECIAL RITUAL NAME</th>
                                    <th class="border-bottom-0">DATE</th>
                                    <th class="border-bottom-0">TIME</th>
                                    <th class="border-bottom-0">IMAGE</th>
                                    <th class="border-bottom-0">VIDEO</th>
                                    <th class="border-bottom-0">DESCRIPTION</th>
                                    <th class="border-bottom-0">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($special_rituals as $index => $special_ritual)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $special_ritual->spcl_ritual_name }}</td>
                                        <td>{{ $special_ritual->spcl_ritual_date }}</td>
                                        <td>{{ $special_ritual->spcl_ritual_time }}</td>
                                        <td>{{ $special_ritual->spcl_ritual_period }}</td>
                                        <td>
                                            @if ($special_ritual->spcl_ritual_image)
                                                <button type="button" class="btn btn-primary btn-sm" onclick="showMediaModal('{{ asset($special_ritual->spcl_ritual_image) }}', 'image')">View Image</button>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($special_ritual->spcl_ritual_video)
                                                <button type="button" class="btn btn-primary btn-sm" onclick="showMediaModal('{{ asset($special_ritual->spcl_ritual_video) }}', 'video')">View Video</button>
                                            @endif
                                        </td>
                                        <td>{{ $special_ritual->description }}</td>
                                        <td>
                                            <form id="delete-form-{{ $special_ritual->id }}" action="{{ route('delete.yearly-ritual', $special_ritual->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $special_ritual->id }})"><i class="fa fa-trash"></i></button>
                                                <a href="{{ route('edit.yearly-ritual', $special_ritual->id) }}" class="btn btn-md btn-success"><i class="fa fa-edit"></i></a>
                                            </form>
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
    
    <!-- Media Modal -->
    <div class="modal fade" id="mediaModal" tabindex="-1" aria-labelledby="mediaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediaModalLabel">Special Ritual Media</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <!-- Image element -->
                    <img id="ritualImage" src="" alt="Ritual Image" class="img-fluid" style="display:none;">
                    <!-- Video element -->
                    <video id="ritualVideo" class="img-fluid" controls style="display:none;">
                        <source id="ritualVideoSource" src="" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var successAlert = document.getElementById('successAlert');
                if (successAlert) {
                    var bootstrapAlert = new bootstrap.Alert(successAlert);
                    bootstrapAlert.close();
                }
            }, 4000); // 4000 milliseconds = 4 seconds
        });
    </script>
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

<script>
    function showMediaModal(mediaUrl, mediaType) {
        // Hide both image and video initially
        document.getElementById('ritualImage').style.display = 'none';
        document.getElementById('ritualVideo').style.display = 'none';

        if (mediaType === 'image') {
            // If it's an image, set the source and display the image
            document.getElementById('ritualImage').src = mediaUrl;
            document.getElementById('ritualImage').style.display = 'block';
        } else if (mediaType === 'video') {
            // If it's a video, set the source and display the video
            document.getElementById('ritualVideoSource').src = mediaUrl;
            document.getElementById('ritualVideo').load(); // Reload the video source
            document.getElementById('ritualVideo').style.display = 'block';
        }

        // Show the modal
        var modal = new bootstrap.Modal(document.getElementById('mediaModal'));
        modal.show();
    }
</script>

@endsection
