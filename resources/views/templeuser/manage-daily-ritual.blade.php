@extends('templeuser.layouts.app')

@section('styles')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="row mt-4">
        <div class="col-lg-12 col-md-12">
            <div class="card overflow-hidden">
                <div class="card-header pb-0">
                    <h2 class="card-title">MANAGE DAILY RITUAL</h2>
                </div>

                <!-- Display errors and success messages -->
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
                                                        @if (isset($groupedRituals[$day]) && $groupedRituals[$day]->count() > 0)
                                                            <!-- Loop through each ritual for the current day -->
                                                            @foreach ($groupedRituals[$day] as $ritualIndex => $ritual)
                                                                <form id="ritualUpdateForm{{ $ritual->id }}" action="{{ route('templeuser.updateRituals') }}" method="POST" enctype="multipart/form-data" style="background-color: rgba(160, 213, 218, 0.2); padding: 15px">
                                                                    @csrf
                                                                    @method('POST')
                                                                    
                                                                    <input type="hidden" name="ritual_id[]" value="{{ $ritual->id }}">
                
                                                                    <div class="form-group-wrapper">
                                                                        <div class="row">
                                                                            <!-- Ritual Name -->
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label for="ritual_name">Ritual Name</label>
                                                                                    <input type="text" class="form-control" name="ritual_name[]" value="{{ $ritual->ritual_name }}">
                                                                                </div>
                                                                            </div>
                
                                                                            <!-- Ritual Image -->
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label for="ritual_image">Ritual Image</label>
                                                                                    <div class="d-flex align-items-center">
                                                                                        <input type="file" class="form-control" name="ritual_image[]">
                                                                                        @if (!empty($ritual->ritual_image))
                                                                                            <button type="button" class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#imageModal{{ $ritualIndex }}">
                                                                                                <i class="fas fa-eye"></i>
                                                                                            </button>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                
                                                                            <!-- Ritual Video -->
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label for="ritual_video">Ritual Video</label>
                                                                                    <div class="d-flex align-items-center">
                                                                                        <input type="file" class="form-control" name="ritual_video[]">
                                                                                        @if (!empty($ritual->ritual_video))
                                                                                            <button type="button" class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#videoModal{{ $ritualIndex }}">
                                                                                                <i class="fas fa-eye"></i>
                                                                                            </button>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                
                                                                            <!-- Ritual Start Time -->
                                                                            <div class="col-md-2">
                                                                                <div class="form-group">
                                                                                    <label for="ritual_start_time">Ritual Start Time</label>
                                                                                    <div class="input-group">
                                                                                        <input type="time" style="width: 60px" class="form-control" name="ritual_start_time[]" value="{{ date('H:i', strtotime($ritual->ritual_start_time)) }}">
                                                                                        <select class="form-control" name="ritual_start_period[]">
                                                                                            <option value="AM" {{ $ritual->ritual_start_period == 'AM' ? 'selected' : '' }}>AM</option>
                                                                                            <option value="PM" {{ $ritual->ritual_start_period == 'PM' ? 'selected' : '' }}>PM</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                
                                                                            <!-- Ritual End Time -->
                                                                            <div class="col-md-2">
                                                                                <div class="form-group">
                                                                                    <label for="ritual_end_time">Ritual End Time</label>
                                                                                    <div class="input-group">
                                                                                        <input type="time" style="width: 60px" class="form-control" name="ritual_end_time[]" value="{{ date('H:i', strtotime($ritual->ritual_end_time)) }}">
                                                                                        <select class="form-control" name="ritual_end_period[]">
                                                                                            <option value="AM" {{ $ritual->ritual_end_period == 'AM' ? 'selected' : '' }}>AM</option>
                                                                                            <option value="PM" {{ $ritual->ritual_end_period == 'PM' ? 'selected' : '' }}>PM</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="form-group">
                                                                                    <label for="ritual_end_time">Ritual Duration</label>
                                                                                    <div class="input-group">
                                                                                        <input type="text" style="width: 60px" class="form-control"  value="{{  $ritual->ritual_duration }}" disabled>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                
                                                                            <!-- Description -->
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label for="description">Description</label>
                                                                                    <textarea class="form-control" name="description[]" rows="1">{{ $ritual->description }}</textarea>
                                                                                </div>
                                                                            </div>
                
                                                                            <!-- Update and Delete Buttons -->
                                                                            <div class="text-center col-md-2 mt-4">
                                                                                <!-- Update Ritual -->
                                                                                <button type="button" class="btn btn-success" onclick="document.getElementById('ritualUpdateForm{{ $ritual->id }}').submit();">
                                                                                    Update
                                                                                </button>
                
                                                                                <!-- Delete Ritual -->
                                                                                <form action="{{ route('templeuser.deleteRitual', $ritual->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this ritual?');" style="display:inline;">
                                                                                    @csrf
                                                                                    <button type="submit" class="btn btn-danger">
                                                                                        <i class="fa fa-trash"></i>
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                                <hr>
                                                                <!-- Modal for Image -->
                                                                @if (!empty($ritual->ritual_image))
                                                                    <div class="modal fade" id="imageModal{{ $ritualIndex }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $ritualIndex }}" aria-hidden="true">
                                                                        <div class="modal-dialog modal-md">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="imageModalLabel{{ $ritualIndex }}">Ritual Image</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body text-center">
                                                                                    <img src="{{ asset($ritual->ritual_image) }}" alt="Ritual Image" class="img-fluid">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                
                                                                <!-- Modal for Video -->
                                                                @if (!empty($ritual->ritual_video))
                                                                    <div class="modal fade" id="videoModal{{ $ritualIndex }}" tabindex="-1" aria-labelledby="videoModalLabel{{ $ritualIndex }}" aria-hidden="true">
                                                                        <div class="modal-dialog modal-md">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="videoModalLabel{{ $ritualIndex }}">Ritual Video</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body text-center">
                                                                                    <video controls class="img-fluid">
                                                                                        <source src="{{ asset($ritual->ritual_video) }}" type="video/mp4">
                                                                                        Your browser does not support the video tag.
                                                                                    </video>
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
@endsection
