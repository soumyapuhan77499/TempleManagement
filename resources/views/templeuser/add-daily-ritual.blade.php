@extends('templeuser.layouts.app')

@section('styles')
@endsection

@section('content')
<div class="row mt-4">
    <div class="col-lg-12 col-md-12">
        <div class="card overflow-hidden">
            <div class="card-header pb-0">
                <h2 class="card-title">ADD DAILY RITUAL</h2>
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
                               aria-expanded="false" style="font-sie: 25px;font-weight: bold;color: black;background-color: rgb(196, 231, 251)">
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
                                                    <form action="{{ url('templeuser/savetempleritual') }}" method="post" enctype="multipart/form-data" id="ritual-form"  style="background-color: rgba(21, 225, 244, 0.2);  padding: 15px;">
                                                        @csrf
                                                        <div id="form-container">
                                                            <div class="form-group-wrapper">
                                                                <div class="row">
                                                                    <input type="hidden" name="day_name[]" value="{{ $day }}" class="day_name">
                                                                    <!-- Ritual Name -->
                                                                       <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="ritual_name">Ritual Name</label>
                                                                            <input type="text" class="form-control" name="ritual_name[]" placeholder="Enter Ritual Name">
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <!-- Ritual Start Time -->
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="ritual_start_time">Ritual Start Time</label>
                                                                            <div class="input-group">
                                                                                <input type="time" class="form-control" name="ritual_start_time[]">
                                                                                <select class="form-control" name="ritual_start_period[]">
                                                                                    <option value="AM">AM</option>
                                                                                    <option value="PM">PM</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                
                                                                    <!-- Ritual End Time -->
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="ritual_end_time">Ritual End Time</label>
                                                                            <div class="input-group">
                                                                                <input type="time" class="form-control" name="ritual_end_time[]">
                                                                                <select class="form-control" name="ritual_end_period[]">
                                                                                    <option value="AM">AM</option>
                                                                                    <option value="PM">PM</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                
                                                                    <!-- Ritual Image -->
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="ritual_image">Ritual Image</label>
                                                                            <input type="file" class="form-control" name="ritual_image[]">
                                                                        </div>
                                                                    </div>
                                                
                                                                    <!-- Ritual Video -->
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="ritual_video">Ritual Video</label>
                                                                            <input type="file" class="form-control" name="ritual_video[]">
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
                                                                        <button type="button" class="btn btn-danger remove-ritual-btn">Remove Ritual</button>
                                                                    </div>
                                                
                                                                    <hr>
                                                                </div>
                                                            </div>
                                                        </div>
                                                
                                                        <!-- Add and Submit Buttons -->
                                                        <div class="text-center col-md-12">
                                                            <button type="submit" class="btn btn-primary">Save Rituals</button>
                                                            <button type="button" class="btn btn-success add-ritual-btn" style="font-size: 16px">+</button>
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
        setTimeout(function() {
            document.getElementById('Message').style.display = 'none';
        }, 3000);
        setTimeout(function() {
            document.getElementById('Messages').style.display = 'none';
        }, 3000);
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Event delegation to handle clicks on 'Add Ritual' buttons inside any accordion
        document.querySelectorAll('.panel-group1').forEach(function(panelGroup) {
            panelGroup.addEventListener('click', function(e) {
                // Add Ritual button click event
                if (e.target && e.target.classList.contains('add-ritual-btn')) {
                    let panelBody = e.target.closest('.panel-body');
                    let formContainer = panelBody.querySelector('#form-container');
                    let newFormGroup = formContainer.querySelector('.form-group-wrapper').cloneNode(true);

                    // Reset the cloned form values
                    newFormGroup.querySelectorAll('input, textarea').forEach(function(input) {
                        input.value = '';
                    });

                    // Set the hidden day_name input to the corresponding day
                    let dayValue = panelBody.querySelector('.day_name').value;
                    newFormGroup.querySelector('.day_name').value = dayValue;

                    formContainer.appendChild(newFormGroup);

                    // Show remove button for newly added forms
                    newFormGroup.querySelector('.remove-ritual-btn').style.display = 'inline-block';
                }

                // Remove Ritual button click event
                if (e.target && e.target.classList.contains('remove-ritual-btn')) {
                    e.target.closest('.form-group-wrapper').remove();
                }
            });
        });

        // Initially hide the first remove button (since the first form should not be removable)
        document.querySelectorAll('.form-group-wrapper').forEach(function(wrapper) {
            wrapper.querySelector('.remove-ritual-btn').style.display = 'none';
        });
    });
</script>
@endsection