@extends('templeuser.layouts.app')

@section('styles')
    <!-- Data table css -->
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}" rel="stylesheet" />

    <!-- INTERNAL Select2 css -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

@endsection

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Temple Expenditure</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Expenditure</li>
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
                        {{-- <h6 class="main-content-label mb-1">Manage Festivals</h6> --}}
                    </div>
                    <div class="table-responsive export-table">
                        <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">Voucher No</th>
                                    <th class="border-bottom-0">Person Name</th>
                                    <th class="border-bottom-0">Date</th>
                                    <th class="border-bottom-0">Amount</th>
                                    <th class="border-bottom-0">Category</th>
                                    <th class="border-bottom-0">Invoice Print</th>
                                    <th class="border-bottom-0">View</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($templeExpenditure as $index => $expenditure)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $expenditure->voucher_number }}</td>
                                        <td>{{ $expenditure->person_name }}</td>
                                        <td>{{ $expenditure->payment_date }}</td>
                                        <td>{{ $expenditure->amount }}</td>
                                        <td>{{ $expenditure->category }}</td>
                                        <td>
                                            <a href="{{ route('templeuser.printInvoice', $expenditure->id) }}"
                                               class="btn btn-primary">Print</a>
                                        </td>
                                        <td>
                                            <!-- View button triggers the modal -->
                                            <button class="btn btn-info" data-toggle="modal"
                                                    data-target="#viewModal{{ $expenditure->id }}">View</button>
                                        </td>
                                        <td>
                                            <a href="{{ route('templeuser.editexpenditure', $expenditure->id) }}"
                                               class="btn btn-warning">Edit</a>
    
                                               <form id="delete-form-{{ $expenditure->id }}" action="{{ route('templeuser.deleteexpenditure', $expenditure->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $expenditure->id }})">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                            
                                        </td>
                                    </tr>
    
                                    <!-- Modal for viewing extra data -->
                                    <div class="modal fade" id="viewModal{{ $expenditure->id }}" tabindex="-1" role="dialog"
                                         aria-labelledby="viewModalLabel{{ $expenditure->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewModalLabel{{ $expenditure->id }}">Expenditure Details</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Voucher Number:</strong> {{ $expenditure->voucher_number }}</p>
                                                    <p><strong>Payment Date:</strong> {{ $expenditure->payment_date }}</p>
                                                    <p><strong>Amount:</strong> {{ $expenditure->amount }}</p>
                                                    <p><strong>Person Name:</strong> {{ $expenditure->person_name }}</p>
                                                    <p><strong>Category:</strong> {{ $expenditure->category }}</p>
                                                    <p><strong>Category Type:</strong> {{ $expenditure->category_type }}</p>
                                                    <p><strong>Payment Mode:</strong> {{ $expenditure->payment_mode }}</p>
                                                    <p><strong>Payment Number:</strong> {{ $expenditure->payment_number }}</p>
                                                    <p><strong>Payment Done By:</strong> {{ $expenditure->payment_done_by }}</p>
                                                    <p><strong>Description:</strong> {{ $expenditure->payment_description }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


    <!-- INTERNAL Select2 js -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
