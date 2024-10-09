@extends('superadmin.layouts.app')


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
                      <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Temple Title</span>
                    </div>
                    <div class="justify-content-center mt-2">
                        <ol class="breadcrumb d-flex justify-content-between align-items-center">
							<a class="btn ripple btn-primary me-3" data-bs-target="#addTitleModal" data-bs-toggle="modal" href="">Add Title</a>

                            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Temple Title</li>
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
                <div class="modal fade" id="addTitleModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">Add Title</h6>
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('templetitle.addTitle') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn ripple btn-primary">Save</button>
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
                                <div class="table-responsive">
                                    <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
                                                <th>SlNo</th>
                                                <th>Title</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($templetitles as $key => $templetitle)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $templetitle->title }}</td>
                                                <td>
                                                    <a class="btn ripple btn-primary me-3 edit-title" href="javascript:void(0);" data-id="{{ $templetitle->id }}" data-title="{{ $templetitle->title }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $templetitle->id }}" action="{{ route('templetitle.deleteTitle', $templetitle->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $templetitle->id }})"><i class="fa fa-trash"></i></button>
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

                <!-- Edit Modal -->
                <div class="modal fade" id="editTitleModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="editForm" action="" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="editItemId" name="id">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="editTitle">Title</label>
                                        <input type="text" class="form-control" id="editTitle" name="title" required>
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
            $('.edit-title').on('click', function() {
                var itemId = $(this).data('id');
                var title = $(this).data('title');
                $('#editItemId').val(itemId);
                $('#editTitle').val(title);
    
                var actionUrl = '/superadmin/updateTitle/' + itemId;
                $('#editForm').attr('action', actionUrl);
    
                $('#editTitleModal').modal('show');
            });
        });
    </script>
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
