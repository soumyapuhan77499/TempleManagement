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
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Darshan</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <a href="{{ route('templeuser.darshanManagement') }}" class="breadcrumb-item tx-15 btn btn-warning">Add
                    Darshan</a>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
            </ol>
        </div>
    </div>

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="table-responsive export-table">
                        <table id="file-datatable" class="table table-bordered table-striped text-nowrap border-bottom">
                            <thead class="table-light">
                                <tr>
                                    <th>Sl No</th>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Duration</th>
                                    <th>Description</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($darshans as $darshan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ ucfirst($darshan->darshan_type) }}</td>
                                        <td>{{ $darshan->darshan_name }}</td>
                                        <td>{{ $darshan->date ? \Carbon\Carbon::parse($darshan->date)->format('jS M, Y') : 'N/A' }}
                                        </td>
                                        <td>{{ $darshan->start_time ? \Carbon\Carbon::parse($darshan->start_time)->format('h:i A') : 'N/A' }}
                                        </td>
                                        <td>{{ $darshan->end_time ? \Carbon\Carbon::parse($darshan->end_time)->format('h:i A') : 'N/A' }}
                                        </td>
                                        <td>{{ $darshan->duration ?? 'N/A' }}</td>
                                        <td>{{ $darshan->description }}</td>
                                        <td class="text-center">
                                            <!-- Edit Button -->
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#editDarshanModal{{ $darshan->id }}">
                                                Edit
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="editDarshanModal{{ $darshan->id }}" tabindex="-1"
                                                aria-labelledby="editDarshanModalLabel{{ $darshan->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <form method="POST"
                                                        action="{{ route('templeuser.updateDarshanManagement', $darshan->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Darshan</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label">Darshan Name</label>
                                                                    <input type="text" class="form-control"
                                                                        name="darshan_name"
                                                                        value="{{ $darshan->darshan_name }}" required>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label">Darshan Type</label>
                                                                    <select class="form-control" name="darshan_type"
                                                                        required>
                                                                        <option value="normal"
                                                                            {{ $darshan->darshan_type == 'normal' ? 'selected' : '' }}>
                                                                            Normal</option>
                                                                        <option value="special"
                                                                            {{ $darshan->darshan_type == 'special' ? 'selected' : '' }}>
                                                                            Special</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label">Date</label>
                                                                    <input type="date" class="form-control"
                                                                        name="date" value="{{ $darshan->date }}">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label">Start Time</label>
                                                                    <input type="time" class="form-control"
                                                                        name="start_time"
                                                                        value="{{ $darshan->start_time }}">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label">End Time</label>
                                                                    <input type="time" class="form-control"
                                                                        name="end_time" value="{{ $darshan->end_time }}">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label">Duration</label>
                                                                    <input type="text" class="form-control"
                                                                        name="duration" value="{{ $darshan->duration }}">
                                                                </div>
                                                                <div class="col-12 mb-3">
                                                                    <label class="form-label">Description</label>
                                                                    <textarea class="form-control" name="description">{{ $darshan->description }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success">Update
                                                                    Darshan</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">No darshan entries found.</td>
                                    </tr>
                                @endforelse
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
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>

    <script>
        // Hide success/error message after 3 seconds
        setTimeout(function() {
            document.getElementById('Message').style.display = 'none';
        }, 3000);
    </script>
    
@endsection
