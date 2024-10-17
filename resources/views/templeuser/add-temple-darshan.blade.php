@extends('templeuser.layouts.app')

@section('styles')
@endsection

@section('content')
<div class="row mt-4">
    <div class="col-lg-12 col-md-12">   
        <div class="card overflow-hidden">
            <div class="card-header pb-0">
                <h2 class="card-title">ADD TEMPLE DARSHAN</h2>
            </div>
  <!-- Display validation errors -->
  @if ($errors->any())
  <div class="alert alert-danger" id="Message">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif

<!-- Display success message -->
@if (session()->has('success'))
  <div class="alert alert-success" id="Message">
      {{ session()->get('success') }}
  </div>
@endif

<!-- Display error message -->
@if (session()->has('danger'))
  <div class="alert alert-danger" id="Message">
      {{ session()->get('danger') }}
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
                               aria-expanded="false" style="font-size: 15px; color: black">
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

                                                   <form action="{{ route('templeuser.savetempledarshan') }}" method="post" enctype="multipart/form-data" id="darshan-form"  style="background-color: rgba(160, 213, 218, 0.2); padding: 15px">
                                                     @csrf
                                                        <div id="form-container">
                                                            <div class="form-group-wrapper">
                                                                <div class="row">
                                                                    <input type="hidden" name="day_name[]" value="{{ $day }}" class="day_name">
                                                                    
                                                                    <!-- Darshan Name -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="darshan_name">Darshan Name</label>
                                                                            <input type="text" class="form-control" name="darshan_name[]" placeholder="Enter Darshan Name" required>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <!-- Darshan Start Time -->
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="darshan_start_time">Darshan Start Time</label>
                                                                            <div class="input-group">
                                                                                <input type="time" class="form-control" name="darshan_start_time[]" required>
                                                                                <select class="form-control" name="darshan_start_period[]">
                                                                                    <option value="AM">AM</option>
                                                                                    <option value="PM">PM</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Darshan End Time -->
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="darshan_end_time">Darshan End Time</label>
                                                                            <div class="input-group">
                                                                                <input type="time" class="form-control" name="darshan_end_time[]" required>
                                                                                <select class="form-control" name="darshan_end_period[]">
                                                                                    <option value="AM">AM</option>
                                                                                    <option value="PM">PM</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Darshan Image -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="darshan_image">Darshan Image</label>
                                                                            <input type="file" class="form-control" name="darshan_image[]" accept="image/*" required>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Description -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="description">Description</label>
                                                                            <textarea class="form-control" name="description[]" rows="1" placeholder="Enter description"></textarea>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Remove Button -->
                                                                    <div class="text-center col-md-12">
                                                                        <button type="button" class="btn btn-danger remove-darshan-btn" style="display:none;">Remove Darshan</button>
                                                                    </div>
                                                                    <hr>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Add and Submit Buttons -->
                                                        <div class="text-center col-md-12">
                                                            <button type="submit" class="btn btn-primary">Save Darshan</button>
                                                            <button type="button" class="btn btn-success add-darshan-btn" style="font-size: 16px">+</button>
                                                        </div>
                                                    </form>

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
        document.addEventListener('DOMContentLoaded', function() {
            // Event delegation to handle clicks on 'Add Darshan' buttons inside any accordion
            document.querySelectorAll('.panel-group1').forEach(function(panelGroup) {
                panelGroup.addEventListener('click', function(e) {
                    // Add Darshan button click event
                    if (e.target && e.target.classList.contains('add-darshan-btn')) {
                        let panelBody = e.target.closest('.panel-body');
                        let formContainer = panelBody.querySelector('#form-container');
                        let newFormGroup = formContainer.querySelector('.form-group-wrapper').cloneNode(true);

                        // Reset the cloned form values
                        newFormGroup.querySelectorAll('input, textarea').forEach(function(input) {
                            if (input.type !== 'file') {
                                input.value = '';
                            }
                        });

                        // Set the hidden day_name input to the corresponding day
                        newFormGroup.querySelector('.day_name').value = panelBody.querySelector('.day_name').value;

                        formContainer.appendChild(newFormGroup);

                        // Show remove button for newly added forms
                        newFormGroup.querySelector('.remove-darshan-btn').style.display = 'inline-block';
                    }

                    // Remove Darshan button click event
                    if (e.target && e.target.classList.contains('remove-darshan-btn')) {
                        e.target.closest('.form-group-wrapper').remove();
                    }
                });
            });

            // Initially hide the first remove button (since the first form should not be removable)
            document.querySelectorAll('.form-group-wrapper').forEach(function(wrapper) {
                if (wrapper !== wrapper.parentElement.firstElementChild) {
                    wrapper.querySelector('.remove-darshan-btn').style.display = 'inline-block';
                } else {
                    wrapper.querySelector('.remove-darshan-btn').style.display = 'none';
                }
            });
        });
    </script>
@endsection
