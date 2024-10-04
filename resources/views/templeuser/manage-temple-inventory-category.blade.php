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
                      <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Temple Inventory Category</span>
                    </div>
                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb d-flex justify-content-between align-items-center">
							<a class="btn ripple btn-primary me-3" data-bs-target="#modaldemo1" data-bs-toggle="modal" href="">Add Categoty</a>

                            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Temple Inventory Category</li>
                        </ol>
                    </div>
                </div>
                <!-- /breadcrumb -->

                   
                @if(session('success'))
                <div id = 'Message' class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('danger'))
                <div id = 'Message' class="alert alert-danger">
                    {{ session('danger') }}
                </div>
            @endif
                   <!-- Basic modal -->
                   <div class="modal fade" id="modaldemo1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">Add Category</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <form action="{{route('templeinventory.addCategory')}}" method="post">
                             @csrf

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="event_name">Inventory Category</label>
                                            <input type="text" class="form-control" id="inventory_categoy" name="inventory_categoy" placeholder="Enter Title">
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn ripple btn-primary" type="button">Save</button>
                                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                            </div>
                            </form>
                        </div>
                    </div>
                    </div>
                <!-- End Basic modal -->

                    <!-- Row -->
                    <div class="row row-sm">
                        <div class="col-lg-12">
                            <div class="card custom-card overflow-hidden">
                                <div class="card-body">
                                    <!-- <div>
                                        <h6 class="main-content-label mb-1">File export Datatables</h6>
                                        <p class="text-muted card-sub-title">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export:</p>
                                    </div> -->
                                  <!-- Display Categories in Table -->
                                    <div class="table-responsive export-table">
                                        <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                                            <thead>
                                                <tr>
                                                    <th>SlNo</th>
                                                    <th>Inventory Category</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($categories as $key => $category)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $category->inventory_categoy }}</td>
                                                    <td>
                                                        <!-- Edit Button -->
                                                        <a class="btn ripple btn-primary me-3 edit-item" href="javascript:void(0);" data-id="{{ $category->id }}" data-category="{{ $category->inventory_categoy }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <!-- Deactivate Button -->
                                                        <form action="{{ url('templeuser/deleteCategory/' . $category->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">  <i class="fa fa-trash" aria-hidden="true"></i></button>
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

                  <!-- update the items modal -->
                <!-- Edit Modal -->
                <div class="modal fade" id="editModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Inventory Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="editForm" action="" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="itemId" name="id">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="editInventoryCategory">Inventory Category</label>
                                        <input type="text" class="form-control" id="editInventoryCategory" name="inventory_categoy" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>

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
    

    <script>
        $(document).ready(function() {
            $('.edit-item').on('click', function() {
                var itemId = $(this).data('id');
                var inventoryCategory = $(this).data('category'); // Use 'data-category' as defined in the button
    
                // Set the values in the form fields
                $('#itemId').val(itemId);
                $('#editInventoryCategory').val(inventoryCategory); // Set the category name to the input
    
                // Show the modal
                $('#editModal').modal('show');
            });
        });
    </script>
    
    <script>
        $(document).ready(function() {
            $('.edit-item').on('click', function() {
                var itemId = $(this).data('id');
                var inventoryCategory = $(this).data('category');
    
                // Set the values in the form fields
                $('#itemId').val(itemId);
                $('#editInventoryCategory').val(inventoryCategory);
    
                // Set the form action to the update route, dynamically inserting the ID
                var actionUrl = '/templeuser/updateCategory/' + itemId;
                $('#editForm').attr('action', actionUrl);
    
                // Show the modal
                $('#editModal').modal('show');
            });
        });
    </script>
    
@endsection
