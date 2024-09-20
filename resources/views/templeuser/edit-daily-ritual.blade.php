@extends('templeuser.layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">EDIT DAILY RITUAL</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Temple</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Ritual</li>
            </ol>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
            <div class="custom-card main-content-body-profile">
                <div class="main-content-body tab-pane border-top-0" id="bank">
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

                    <form action="{{ url('templeuser/updatetempleritual/' . $ritual->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="day_name">Day Name</label>
                                                <select class="form-control" name="day_name" id="day_name">
                                                    <option value="">Select days of the week..</option>
                                                    <option value="Sunday" {{ $ritual->ritual_day_name == 'Sunday' ? 'selected' : '' }}>SUNDAY</option>
                                                    <option value="Monday" {{ $ritual->ritual_day_name == 'Monday' ? 'selected' : '' }}>MONDAY</option>
                                                    <option value="Tuesday" {{ $ritual->ritual_day_name == 'Tuesday' ? 'selected' : '' }}>TUESDAY</option>
                                                    <option value="Wednesday" {{ $ritual->ritual_day_name == 'Wednesday' ? 'selected' : '' }}>WEDNESDAY</option>
                                                    <option value="Thursday" {{ $ritual->ritual_day_name == 'Thursday' ? 'selected' : '' }}>THURSDAY</option>
                                                    <option value="Friday" {{ $ritual->ritual_day_name == 'Friday' ? 'selected' : '' }}>FRIDAY</option>
                                                    <option value="Saturday" {{ $ritual->ritual_day_name == 'Saturday' ? 'selected' : '' }}>SATURDAY</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="ritual_name">Ritual Name</label>
                                                    <input type="text" class="form-control" name="ritual_name" value="{{ $ritual->ritual_name }}" id="ritual_name" placeholder="Enter Ritual Name">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="ritual_date">Ritual Date</label>
                                                    <input type="date" class="form-control" name="ritual_date" value="{{ $ritual->ritual_date }}" id="ritual_date" placeholder="Enter Ritual Date">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ritual_start_time">Ritual Start Time</label>
                                                    <div class="input-group">
                                                        <input type="time" class="form-control" name="ritual_start_time" value="{{ $ritual->ritual_start_time }}" id="ritual_start_time" placeholder="Enter Ritual Start Time">
                                                        <select class="form-control" name="ritual_start_period" id="ritual_start_period">
                                                            <option value="AM" {{ $ritual->ritual_start_period == 'AM' ? 'selected' : '' }}>AM</option>
                                                            <option value="PM" {{ $ritual->ritual_start_period == 'PM' ? 'selected' : '' }}>PM</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ritual_end_time">Ritual End Time</label>
                                                    <div class="input-group">
                                                        <input type="time" class="form-control" name="ritual_end_time" value="{{ $ritual->ritual_end_time }}" id="ritual_end_time" placeholder="Enter Ritual End Time">
                                                        <select class="form-control" name="ritual_end_period" id="ritual_end_period">
                                                            <option value="AM" {{ $ritual->ritual_end_period == 'AM' ? 'selected' : '' }}>AM</option>
                                                            <option value="PM" {{ $ritual->ritual_end_period == 'PM' ? 'selected' : '' }}>PM</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ritual_image">Ritual Image</label>
                                                    <input type="file" class="form-control" name="ritual_image" id="ritual_image">
                                                    @if($ritual->ritual_image)
                                                        <a href="{{ asset($ritual->ritual_image) }}" target="_blank">
                                                            <button type="button" class="btn btn-info">View Image</button>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                           
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ritual_video">Ritual Video</label>
                                                    <input type="file" class="form-control" name="ritual_video" id="ritual_video">
                                                    @if($ritual->ritual_video)
                                                        <a href="{{ asset( $ritual->ritual_video) }}" target="_blank">
                                                            <button type="button" class="btn btn-info">View Video</button>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                            

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control" name="description" id="description" placeholder="Enter description here..." rows="4">{{ $ritual->description }}</textarea>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="text-center col-md-12">
                                            <button type="submit" class="btn btn-primary" style="width: 150px;">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        setTimeout(function() {
            var message = document.getElementById('Message');
            if (message) {
                message.style.display = 'none';
            }
        }, 3000);
    </script>
@endsection





@extends('templeuser.layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">DAILY RITUAL</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Temple</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ritual</li>
            </ol>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
            <div class="custom-card main-content-body-profile">
                <div class="main-content-body tab-pane border-top-0" id="bank">
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
                    <form action="{{ url('templeuser/savetempleritual') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{-- @method('PUT') --}}
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="day_name">Day Name</label>
                                                <select class="form-control" name="day_name" id="day_name">
                                                    <option value="">Select days of the week..</option>
                                                    <option value="Sunday">SUNDAY</option>
                                                    <option value="Monday">MONDAY</option>
                                                    <option value="Tuesday">TUESDAY</option>
                                                    <option value="Wednesday">WEDNESDAY</option>
                                                    <option value="Thursday">THURSDAY</option>
                                                    <option value="Friday">FRIDAY</option>
                                                    <option value="Saturday">SATURDAY</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="ritual_name">Ritual Name</label>
                                                    <input type="text" class="form-control" name="ritual_name"
                                                        value=" " id="ritual_name" placeholder="Enter Ritual Name">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="ritual_date">Ritual Date</label>
                                                    <input type="date" class="form-control" name="ritual_date"
                                                        value=" " id="ritual_date" placeholder="Enter Ritual Date">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ritual_start_time">Ritual Start Time</label>
                                                    <div class="input-group">
                                                        <input type="time" class="form-control" name="ritual_start_time" id="ritual_start_time" placeholder="Enter Ritual Start Time">
                                                        <select class="form-control" name="ritual_start_period" id="ritual_start_period">
                                                            <option value="AM">AM</option>
                                                            <option value="PM">PM</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ritual_end_time">Ritual End Time</label>
                                                    <div class="input-group">
                                                        <input type="time" class="form-control" name="ritual_end_time" id="ritual_end_time" placeholder="Enter Ritual End Time">
                                                        <select class="form-control" name="ritual_end_period" id="ritual_end_period">
                                                            <option value="AM">AM</option>
                                                            <option value="PM">PM</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ritual_image">Ritual Image</label>
                                                    <input type="file" class="form-control" name="ritual_image" id="ritual_name">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ritual_image">Ritual Video</label>
                                                    <input type="file" class="form-control" name="ritual_video" id="ritual_video">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control" name="description" id="description" placeholder="Enter description here..." rows="4"></textarea>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="text-center col-md-12">
                                            <button type="submit" class="btn btn-primary"
                                                style="width: 150px;">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
@endsection

