@extends('templeuser.layouts.app')

@section('styles')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

@endsection

@section('content')
<div class="row mt-4">
    <div class="col-lg-12 col-md-12">
        <div class="card overflow-hidden">
            <div class="card-header pb-0">
                <h2 class="card-title">MANAGE TEMPLE DARSHAN</h2>
            </div>
             <!-- row -->
             @foreach ($errors->all() as $error)
             <li>{{ $error }}</li>
         @endforeach
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
            <div class="card-body">
                <div class="panel-group1" id="accordion11" role="tablist">
                    @foreach ($weekDays as $index => $day)
                        <div class="card overflow-hidden">
                            <a class="accordion-toggle panel-heading1 collapsed" 
                               data-bs-toggle="collapse" 
                               data-bs-parent="#accordion11" 
                               href="#collapseDay{{ $index }}" 
                               aria-expanded="false" style="font-sie: 25px;font-weight: bold;color: black">
                               {{ $day }}
                            </a>
                            <div id="collapseDay{{ $index }}" 
                                 class="panel-collapse collapse" 
                                 role="tabpanel" 
                                 aria-expanded="false">
                                <div class="panel-body">
                                    <div class="row row-sm">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="custom-card main-content-body-profile">
                                                <div class="main-content-body tab-pane border-top-0" id="bank">
                                                    <!-- Check if there are rituals for this day -->
                                                    @if (isset($groupedDarshans[$day]) && $groupedDarshans[$day]->count() > 0)
                                                        <!-- Loop through each ritual for the current day -->
                                                        @foreach ($groupedDarshans[$day] as $darshanIndex => $darshan)

                                                        <form  id="delete-form-{{ $darshan->id }}"  action="{{ route('templeuser.deleteDarshan', $darshan->id) }}" method="POST"  style="display:inline;">
                                                            @csrf
                                                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $darshan->id }})"><i class="fa fa-trash"></i></button>
                                                        </form>

                                                        <form id="ritualUpdateForm{{ $darshan->id }}" action="{{ route('templeuser.updateDarshan') }}" method="POST" enctype="multipart/form-data" style="background-color: rgba(160, 213, 218, 0.2); padding: 15px">
                                                            @csrf
                                                            @method('POST')
                                                        
                                                            <input type="hidden" name="darshan_id[]" value="{{ $darshan->id }}">
                                                        
                                                            <div class="form-group-wrapper">
                                                                <div class="row">
                                                                    <!-- Darshan Name -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="darshan_name">Darshan Name</label>
                                                                            <input type="text" class="form-control" name="darshan_name[]" value="{{ $darshan->darshan_name }}">
                                                                        </div>
                                                                    </div>
                                                        
                                                                    <!-- Darshan Image -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="darshan_image">Darshan Image</label>
                                                                            <div class="d-flex align-items-center">
                                                                                <input type="file" class="form-control" name="darshan_image[]">
                                                                                @if (!empty($darshan->darshan_image))
                                                                                    <button type="button" class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#imageModal{{ $darshanIndex }}">
                                                                                        <i class="fas fa-eye"></i>
                                                                                    </button>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                        
                                                                    <!-- Darshan Start Time -->
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="darshan_start_time">Darshan Start Time</label>
                                                                            <div class="input-group">
                                                                                <input type="time" style="width: 60px" class="form-control" name="darshan_start_time[]" value="{{ date('H:i', strtotime($darshan->darshan_start_time)) }}">
                                                                                <select class="form-control" name="darshan_start_period[]">
                                                                                    <option value="AM" {{ $darshan->darshan_start_period == 'AM' ? 'selected' : '' }}>AM</option>
                                                                                    <option value="PM" {{ $darshan->darshan_start_period == 'PM' ? 'selected' : '' }}>PM</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                        
                                                                    <!-- Darshan End Time -->
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="darshan_end_time">Darshan End Time</label>
                                                                            <div class="input-group">
                                                                                <input type="time" style="width: 60px" class="form-control" name="darshan_end_time[]" value="{{ date('H:i', strtotime($darshan->darshan_end_time)) }}">
                                                                                <select class="form-control" name="darshan_end_period[]">
                                                                                    <option value="AM" {{ $darshan->darshan_end_period == 'AM' ? 'selected' : '' }}>AM</option>
                                                                                    <option value="PM" {{ $darshan->darshan_end_period == 'PM' ? 'selected' : '' }}>PM</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                        
                                                                    <!-- Darshan Duration -->
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="darshan_end_time">Darshan Duration</label>
                                                                            <div class="input-group">
                                                                                <input type="text" style="width: 60px" class="form-control" value="{{ $darshan->darshan_duration }}" disabled>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                        
                                                                    <!-- Description -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="description">Description</label>
                                                                            <textarea class="form-control" name="description[]" rows="1">{{ $darshan->description }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 mt-4">
                                                                        <button type="button" class="btn btn-success" onclick="document.getElementById('ritualUpdateForm{{ $darshan->id }}').submit();">
                                                                            Update
                                                                        </button>
                                                                    </div>
                                                                
                                                                </div>
                                                            </div>
                                                        </form>
                                                            <hr> 
                                                            <!-- Modal for Image -->
                                                            @if (!empty($darshan->darshan_image))
                                                                <div class="modal fade" id="imageModal{{ $darshanIndex }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $darshanIndex }}" aria-hidden="true">
                                                                    <div class="modal-dialog modal-md">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="imageModalLabel{{ $darshanIndex }}">Darshan Image</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body text-center">
                                                                                <img src="{{ asset($darshan->darshan_image) }}" alt="Darshan Image" class="img-fluid">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
            
                                                        @endforeach
                                                    @else
                                                        <p>No rituals added for {{ $day }}.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
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
    
@endsection

@section('scripts')
    <script>
        setTimeout(function() {
            document.getElementById('Message').style.display = 'none';
        }, 3000);
        setTimeout(function() {
            document.getElementById('Messages').style.display = 'none';
        }, 3000);
    </script>

        <!-- Bootstrap JS (including Popper) -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
                button.addEventListener('click', () => {
                    console.log('Modal button clicked for: ', button.getAttribute('data-bs-target'));
                });
            });
        </script>
    <!-- SweetAlert JS -->
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
