@extends('templeuser.layouts.app')


@section('styles')

    <!-- Data table css -->
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css')}}"  rel="stylesheet">
    <link href="{{asset('assets/plugins/datatable/responsive.bootstrap5.css')}}" rel="stylesheet" />

    <!-- INTERNAL Select2 css -->
    <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />

@endsection

@section('content')

                <!-- breadcrumb -->
                <div class="breadcrumb-header justify-content-between">
                    <div class="left-content">
                      <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Besha</span>
                    </div>
                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb d-flex justify-content-between align-items-center">
                            <li class="breadcrumb-item tx-15"><a href="{{ route('templeuser.addbesha') }}" class="btn btn-info text-white">Add Besha</a></li>

                            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Besha</li>
                        </ol>
                    </div>
                </div>
              
                    <!-- Row -->
                    <div class="row row-sm">
                        <div class="col-lg-12">
                            <div class="card custom-card overflow-hidden">
                                <div class="card-body">
                                    <!-- <div>
                                        <h6 class="main-content-label mb-1">File export Datatables</h6>
                                        <p class="text-muted card-sub-title">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export:</p>
                                    </div> -->
                                    <div class="table-responsive  export-table">
                                        <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                                            <thead>
                                                <tr>
                                                    <th class="border-bottom-0">Sl No</th>
                                                    <th class="border-bottom-0">Besha Name</th>
                                                    <th class="border-bottom-0">Items</th>
                                                    <th class="border-bottom-0">Estimated Time</th>
                                                    <th class="border-bottom-0">Total Time</th>
                                                    <th class="border-bottom-0">Date</th>
                                                    <th class="border-bottom-0">Weekly Day</th>
                                                    <th class="border-bottom-0">Color</th>
                                                    <th class="border-bottom-0">View Images</th> <!-- New column -->
                                                    {{-- <th class="border-bottom-0">Special Day</th> --}}
                                                    <th class="border-bottom-0">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($temple_beshas as $index => $besha)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $besha->besha_name }}</td>
                                                        <td>
                                                           {{ $besha->items }}
                                                        </td>
                                                        <td>{{ $besha->estimated_time }} {{ $besha->time_period }}</td>
                                                        <td>{{ $besha->total_time }}</td>
                                                        <td>{{ $besha->date }}</td>
                                                        <td>{{ $besha->weekly_day }}</td>
                                                        <td>{{ $besha->dress_color }}</td>
                                                        {{-- <td>{{ $besha->special_day }}</td> --}}
                                                        <td>
                                                            <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#viewImagesModal-{{ $besha->id }}">
                                                                <i class="fas fa-eye"></i> View Images
                                                            </button>
                                                            
                                                            
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('templeuser.besha.edit', $besha->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                                            <a href="{{ route('templeuser.besha.delete', $besha->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Besha?')"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>

                                                   <!-- Test Button -->

                                                @endforeach
                                            </tbody>
                                        </table>
                                        @foreach ($temple_beshas as $besha)
                                            <!-- Modal -->
                                            <div class="modal fade" id="viewImagesModal-{{ $besha->id }}" tabindex="-1" aria-labelledby="viewImagesModalLabel-{{ $besha->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Images for Besha: {{ $besha->besha_name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @php
                                                                $photos = explode(',', $besha->photos); // Convert string to array
                                                            @endphp

                                                            @if (count($photos) > 0)
                                                                <div class="row">
                                                                    @foreach ($photos as $photo)
                                                                        <div class="col-4">
                                                                            <img src="{{ asset('storage/' . $photo) }}" class="img-fluid" alt="Besha Image">
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <p>No images available for this Besha.</p>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Row -->

@endsection

@section('scripts')

    <!-- Internal Data tables -->
    <script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/buttons.bootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/js/table-data.js')}}"></script>

    <!-- INTERNAL Select2 js -->
    <script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
    <script>
        setTimeout(function(){
            document.getElementById('Message').style.display = 'none';
        }, 3000);
    </script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('error'))
<script>
	Swal.fire({
		icon: 'error',
		title: 'Error',
		text: '{{ session('error') }}',
	});
</script>
@endif

@if(session('success'))
<script>
	Swal.fire({
		icon: 'success',
		title: 'Success',
		text: '{{ session('success') }}',
	});
</script>
@endif
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to undo this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the delete form
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

@endsection
