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
                      <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Item</span>
                    </div>
                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb d-flex justify-content-between align-items-center">
                            <li class="breadcrumb-item tx-15"><a href="{{ route('templeuser.additem') }}" class="btn btn-info text-white">Add Item</a></li>

                            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Item</li>
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
                                                    <th>ID</th>
                                                    <th>Item Name</th>
                                                    <th>Description</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($items as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->item_name }}</td>
                                                    <td>{{ $item->description }}</td>
                                                    <td>
                                                        <a href="{{ route('templeuser.edititem', $item->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                                        <form action="{{ route('templeuser.deleteitem', $item->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
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
