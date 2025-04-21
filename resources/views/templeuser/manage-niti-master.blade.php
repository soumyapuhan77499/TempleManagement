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
            <span class="main-content-title mg-b-0 mg-b-lg-1">Manage Niti</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <a href="{{ url('admin/add-niti') }}" class="breadcrumb-item tx-15 btn btn-warning">Add Niti</a>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Niti</li>
            </ol>
        </div>
    </div>

    @if (session('success'))
        <div id="Message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('danger'))
        <div id="Message" class="alert alert-danger">
            {{ session('danger') }}
        </div>
    @endif

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="table-responsive export-table">
                        <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">SlNo</th>
                                    <th class="border-bottom-0">Language</th>
                                    <th class="border-bottom-0">Niti Name</th>
                                    <th class="border-bottom-0">Time</th>
                                    <th class="border-bottom-0">Type</th>
                                    <th class="border-bottom-0">Niti About</th>
                                    <th class="border-bottom-0">Details</th>
                                    <th class="border-bottom-0">Sebayat</th>
                                    <th class="border-bottom-0">Steps</th> <!-- New column for steps -->
                                    <th class="border-bottom-0">Items</th> <!-- New column for items -->
                                    <th class="border-bottom-0">Description</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($manage_niti_master as $niti)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $niti->language }}</td>
                                        <td>{{ $niti->niti_name }}</td>
                                        <td>{{ $niti->date_time }}</td>
                                        <td>{{ $niti->niti_type }}</td>
                                        <td>{{ $niti->niti_about }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info"
                                            data-bs-toggle="modal"
                                            data-bs-target="#nitiDetailModal"
                                            data-id="{{ $niti->id }}"
                                            data-name="{{ $niti->niti_name }}"
                                            data-subnitis='@json($niti->subNitis)'
                                            data-mahaprasad="{{ $niti->linkedMahaprasad->name ?? 'Not Linked' }}"
                                            data-darshan="{{ $niti->linkedDarshan->name ?? 'Not Linked' }}"
                                            data-description="{{ $niti->description }}">
                                        <i class="fa fa-eye"></i> View
                                    </button>
                                    
                                        </td>
                        
                                        <!-- Sebayat Modal Trigger -->
                                        <td>
                                            <a class="btn ripple btn-dark" style="color: white" data-bs-toggle="modal" data-bs-target="#sebayatModal{{ $niti->niti_id }}">VIEW</a>
                                        </td>
                        
                                        <!-- Steps Modal Trigger -->
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#stepsModal{{ $niti->id }}">
                                                VIEW
                                            </button>
                                        </td>
                        
                                        <!-- Items Modal Trigger -->
                                        <td>
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#itemsModal{{ $niti->id }}">
                                                VIEW
                                            </button>
                                        </td>
                        
                                        <td>{{ $niti->description }}</td>
                                        <td style="color:#B7070A; font-size: 15px;">
                                            <a class="btn btn-success cursor-pointer" href="{{ url('admin/edit-niti-master/' . $niti->niti_id) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form id="delete-form-{{ $niti->niti_id }}" action="{{ route('deletNitiMaster', $niti->niti_id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $niti->niti_id }})">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <!-- Sebayat Modal -->
                        @foreach ($manage_niti_master as $niti)
                            <div class="modal fade" id="sebayatModal{{ $niti->niti_id }}" tabindex="-1" role="dialog" aria-labelledby="modalTitle{{ $niti->niti_id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content modal-content-demo">
                                        <div class="modal-header">
                                            <h6 class="modal-title" id="modalTitle{{ $niti->niti_id }}">Sebayat List for {{ $niti->niti_name }}</h6>
                                            <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            @php
                                                // Split the names by comma if they are stored as a comma-separated string
                                                $sebayatList = explode(',', $niti->niti_sebayat);
                                            @endphp
                        
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="bg-info">Serial No.</th>
                                                        <th class="bg-info">Sebayat Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($sebayatList as $index => $name)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ trim($name) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn ripple btn-primary" type="button">Save changes</button>
                                            <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        <!-- Steps Modal -->
                        @foreach ($manage_niti_master as $niti)
                            <div class="modal fade" id="stepsModal{{ $niti->id }}" tabindex="-1" aria-labelledby="stepsModalLabel{{ $niti->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="stepsModalLabel{{ $niti->id }}">Steps</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if ($niti->steps->isNotEmpty())
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="bg-info">Serial No.</th>
                                                            <th class="bg-info">Step Name</th>
                                                            <th class="bg-info">Seba Name</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($niti->steps as $index => $step)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $step->step_name }}</td>
                                                                <td>{{ $step->seba_name }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <p>No steps available</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        <!-- Items Modal -->
                        @foreach ($manage_niti_master as $niti)
                            <div class="modal fade" id="itemsModal{{ $niti->id }}" tabindex="-1" aria-labelledby="itemsModalLabel{{ $niti->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="itemsModalLabel{{ $niti->id }}">Items</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if ($niti->niti_items->isNotEmpty())
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="bg-info">SlNo.</th>
                                                            <th class="bg-info">Item Name</th>
                                                            <th class="bg-info">Quantity</th>
                                                            <th class="bg-info">Unit</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($niti->niti_items as $index => $item)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $item->item_name }}</td>
                                                                <td>{{ $item->quantity }}</td>
                                                                <td>{{ $item->unit }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <p>No items available</p>
                                            @endif
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

    <!-- Modal -->
<div class="modal fade" id="nitiDetailModal" tabindex="-1" aria-labelledby="nitiDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="nitiDetailModalLabel">Niti Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h5><strong>Niti Name:</strong> <span id="modalNitiName"></span></h5>
  
          <hr>
          <h6><strong>Sub Nitis:</strong></h6>
          <ul id="modalSubNitis"></ul>
  
          <h6><strong>Linked Mahaprasad:</strong></h6>
          <p id="modalMahaprasad"></p>
  
          <h6><strong>Linked Darshan:</strong></h6>
          <p id="modalDarshan"></p>
  
          <h6><strong>Description:</strong></h6>
          <p id="modalDescription"></p>
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
    <script>
        const modal = document.getElementById('nitiDetailModal');
    
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
    
            const name = button.getAttribute('data-name');
            const mahaprasad = button.getAttribute('data-mahaprasad');
            const darshan = button.getAttribute('data-darshan');
            const description = button.getAttribute('data-description');
            const subNitis = JSON.parse(button.getAttribute('data-subnitis'));
    
            document.getElementById('modalNitiName').textContent = name;
            document.getElementById('modalMahaprasad').textContent = mahaprasad;
            document.getElementById('modalDarshan').textContent = darshan;
            document.getElementById('modalDescription').textContent = description;
    
            const subNitiList = document.getElementById('modalSubNitis');
            subNitiList.innerHTML = ''; // Clear existing
    
            if (subNitis.length > 0) {
                subNitis.forEach(sub => {
                    const li = document.createElement('li');
                    li.textContent = sub.sub_niti_name;
                    subNitiList.appendChild(li);
                });
            } else {
                const li = document.createElement('li');
                li.textContent = 'No sub nitis found.';
                subNitiList.appendChild(li);
            }
        });
    </script>
    
@endsection
