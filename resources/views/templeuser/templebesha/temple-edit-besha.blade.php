@extends('templeuser.layouts.app')

@section('styles')
    <!-- Internal Select2 CSS -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">ADD besha</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <li class="breadcrumb-item tx-15"><a href="{{route('templeuser.managebesha')}}"
                        class="btn btn-warning text-dark">Manage besha</a></li>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active tx-15" aria-current="page">ADD besha</li>
            </ol>
        </div>
    </div>
    <!-- End Breadcrumb -->

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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

    <div class="row">
        <div class="col-lg-12 col-md-">
            <div class="card custom-card">
                <div class="card-body">
                    <form action="{{ route('templeuser.besha.update', $besha->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="besha_name">Besha Name</label>
                                    <input type="text" class="form-control" id="besha_name" name="besha_name" value="{{ $besha->besha_name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="items">Items</label>
                                    <select class="form-control select2" id="items" name="items[]" multiple="multiple">
                                        @foreach($items as $item)
                                            <option value="{{ $item->item_name }}" 
                                                {{ in_array($item->item_name, explode(',', $besha->items) ?? []) ? 'selected' : '' }}>
                                                {{ $item->item_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    
                                </div>
                            </div>
                        </div>
                
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description">{{ $besha->description }}</textarea>
                                </div>
                            </div>
                        </div>
                
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estimated_time">Estimated Time of this Besha</label>
                                    <div class="input-group">
                                        <input type="time" class="form-control" name="estimated_time" value="{{ $besha->estimated_time }}" required>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="total_time">Total time taken for this Besha</label>
                                    <input type="text" class="form-control" id="total_time" name="total_time" value="{{ $besha->total_time }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" value="{{ $besha->date }}">
                                </div>
                            </div>
                        </div>
                
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="weekly_day">Weekly Day</label>
                                    <select class="form-control" id="weekly_day" name="weekly_day" onchange="updateColorSelection()">
                                        <option value="">Select Days...</option>
                                        @foreach($dressColors as $dressColor)
                                            <option value="{{ $dressColor->day_name }}" {{ $besha->weekly_day == $dressColor->day_name ? 'selected' : '' }}>
                                                {{ $dressColor->day_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="color">Color</label>
                                    <select class="form-control" id="color" name="dress_color">
                                        <option value="{{ $besha->dress_color }}" selected>{{ $besha->dress_color }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-center">
                                <div class="form-group mb-0">
                                    <label for="special_day" class="d-block">Special Besha</label>
                                    <input type="checkbox" id="special_day" name="special_day" onchange="toggleDateField()" style="width: 20px; height: 20px;" {{ $besha->special_day ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="photos">Photos of Besha or Dress</label>
                                    <input id="photos" class="form-control" type="file" name="photos[]" accept="image/jpeg, image/png" multiple>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Display Existing Images -->
                        <div class="row mt-3">
                            @if(!empty($besha->photos))
                                @php
                                    $existingPhotos = explode(',', $besha->photos);
                                @endphp
                                @foreach($existingPhotos as $photo)
                                <div class="col-md-3 position-relative mb-3" id="photo-{{ md5($photo) }}">
                                    <img src="{{ asset('storage/'.$photo) }}" alt="Besha Photo" class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 start-100 translate-middle"
                                        onclick="removeImage('{{ $photo }}', '{{ md5($photo) }}')">
                                        &times;
                                    </button>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        
                        <!-- Hidden Input to Keep Track of Images to Remove -->
                        <input type="hidden" name="removed_photos" id="removed_photos">
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group" style="padding-top: 27px">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
{{-- sweet alert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Update the color selection when a day is selected
    function updateColorSelection() {
        var selectedDay = document.getElementById("weekly_day").value;
        var colorSelect = document.getElementById("color");

        // Clear existing color options
        colorSelect.innerHTML = '';

        // Check if a day is selected
        if (selectedDay) {
            // Loop through the dress colors to match the selected day
            @foreach($dressColors as $dressColor)
                if (selectedDay === "{{ $dressColor->day_name }}") {
                    var option = document.createElement("option");
                    option.value = "{{ $dressColor->color }}";
                    option.text = "{{ $dressColor->color }}";
                    colorSelect.appendChild(option);
                }
            @endforeach
        }
    }
</script>
<script>
    // Function to Remove an Image
    function removeImage(photoPath, elementId) {
        // Add the photo to the list of removed photos
        const removedPhotosInput = document.getElementById('removed_photos');
        let removedPhotos = removedPhotosInput.value ? removedPhotosInput.value.split(',') : [];
        removedPhotos.push(photoPath);
        removedPhotosInput.value = removedPhotos.join(',');

        // Remove the photo preview
        document.getElementById('photo-' + elementId).remove();
    }
</script>
@endsection
