@extends('templeuser.layouts.app')

@section('styles')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Edit Festival</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Festival</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-body pt-0 pt-4">
                    <form method="POST" action="{{ route('templefestival.updateFestival', $festival->id) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="festival_name">Festival Name <span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="festival_name" name="festival_name"
                                        value="{{ old('festival_name', $festival->festival_name) }}"
                                        placeholder="Enter Festival Name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="start_date">Start Date <span style="color:red">*</span></label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="{{ old('start_date', $festival->start_date) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="{{ old('end_date', $festival->end_date) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="festival_photos">Festival Photos</label>
                                    <input type="file" class="form-control" id="festival_photos" name="festival_photos[]"
                                        multiple>
                                    @if ($festival->photo)
                                        @foreach (json_decode($festival->photo) as $index => $photo)
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                data-bs-target="#photoModal{{ $index }}">
                                                View
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="photoModal{{ $index }}" tabindex="-1"
                                                aria-labelledby="photoModalLabel{{ $index }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="photoModalLabel{{ $index }}">Festival Photo</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset($photo) }}" class="img-fluid"
                                                                alt="Festival Photo">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="live_url">Live URL</label>
                                    <input type="url" class="form-control" id="live_url" name="live_url"
                                        value="{{ old('live_url', $festival->live_url) }}" placeholder="Enter Live URL">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <h4>Sub Festivals</h4>
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        id="add-sub-festival">Add</button>
                                </div>

                                <div id="sub-festivals">
                                    @foreach ($festival->subFestivals as $index => $sub)
                                        <div class="sub-festival">
                                            <div class="row">
                                                <input type="hidden" name="sub_festival_ids[]"
                                                    value="{{ $sub->id }}">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Sub Festival Name</label>
                                                        <input type="text" class="form-control"
                                                            name="sub_festival_name[]"
                                                            value="{{ $sub->sub_festival_name }}"
                                                            placeholder="Enter Sub Festival Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Date</label>
                                                        <input type="date" class="form-control"
                                                            name="sub_festival_date[]"
                                                            value="{{ $sub->sub_festival_date }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Photo</label>
                                                        <input type="file" class="form-control"
                                                            name="sub_festival_photo[]">
                                                        @if ($sub->sub_festival_photo)
                                                            <button type="button" class="btn btn-sm btn-info"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#subPhotoModal{{ $sub->id }}">
                                                                View
                                                            </button>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="subPhotoModal{{ $sub->id }}"
                                                                tabindex="-1"
                                                                aria-labelledby="subPhotoModalLabel{{ $sub->id }}"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="subPhotoModalLabel{{ $sub->id }}">
                                                                                Sub Festival Photo</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body text-center">
                                                                            <img src="{{ asset($sub->sub_festival_photo) }}"
                                                                                class="img-fluid"
                                                                                alt="Sub-Festival Photo">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Time</label>
                                                        <input type="time" class="form-control"
                                                            name="sub_festival_time[]"
                                                            value="{{ $sub->sub_festival_time }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="festival_descp">Festival Description <span style="color:red">*</span></label>
                            <textarea name="festival_descp" class="form-control" id="festival_descp" required>{{ old('festival_descp', $festival->description) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('add-sub-festival').addEventListener('click', function() {
            var subFestivalTemplate = `
        <div class="sub-festival">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="sub_festival_name">Sub Festival Name</label>
                        <input type="text" class="form-control" name="sub_festival_name[]" placeholder="Enter Sub Festival Name">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="sub_festival_date">Date</label>
                        <input type="date" class="form-control" name="sub_festival_date[]">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="sub_festival_photo">Photo</label>
                        <input type="file" class="form-control" name="sub_festival_photo[]">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="sub_festival_time">Time</label>
                        <input type="time" class="form-control" name="sub_festival_time[]">
                    </div>
                </div>
				<div class="col-md-1">
					<button type="button" class="btn btn-danger remove-sub-festival btn-sm" style="margin-top:30px;">Remove</button>
                </div>

            </div>
        </div>
    `;
            document.getElementById('sub-festivals').insertAdjacentHTML('beforeend', subFestivalTemplate);
        });

        // Event delegation to remove a sub-festival section
        document.getElementById('sub-festivals').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-sub-festival')) {
                e.target.closest('.sub-festival').remove();
            }
        });
    </script>
@endsection
