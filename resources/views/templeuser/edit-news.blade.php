@extends('templeuser.layouts.app')

@section('styles')
    <!-- INTERNAL Select2 css -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />

    <!-- INTERNAL Data table css -->
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}" rel="stylesheet" />
@endsection

@section('content')

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Edit News</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit News</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->
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
    <!-- row  -->
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                {{-- <div class="card-header">
											<h4 class="card-title">Temple About</h4>
										</div> --}}
                <div class="card-body pt-0 pt-4">
                    <form method="POST" action="{{ route('templenews.updateNews', $news->id) }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="notice_name">Notice Name <span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="notice_name" name="notice_name"
                                        value="{{ $news->notice_name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="notice_date">Notice Date <span style="color:red">*</span></label>
                                    <input type="date" class="form-control" id="notice_date" name="notice_date"
                                        value="{{ $news->notice_date }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notice_descp">Notice Description <span style="color:red">*</span></label>
                            <textarea name="notice_descp" class="form-control" id="notice_descp" required>{{ $news->notice_descp }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>



                </div>
            </div>
        </div>
    </div>
    <!-- /row closed -->


@endsection

@section('scripts')
    <!-- Internal Chart.Bundle js-->
    <script src="{{ asset('assets/plugins/chartjs/Chart.bundle.min.js') }}"></script>

    <!-- Moment js -->
    <script src="{{ asset('assets/plugins/raphael/raphael.min.js') }}"></script>

    <!-- INTERNAL Apexchart js -->
    <script src="{{ asset('assets/js/apexcharts.js') }}"></script>

    <!--Internal Sparkline js -->
    <script src="{{ asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

    <!--Internal  index js -->
    <script src="{{ asset('assets/js/index.js') }}"></script>

    <!-- Chart-circle js -->
    <script src="{{ asset('assets/js/chart-circle.js') }}"></script>

    <!-- Internal Data tables -->
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>

    <!-- INTERNAL Select2 js -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>
    <script>
        function previewFiles(inputId, previewContainerId) {
            const input = document.getElementById(inputId);
            const previewContainer = document.getElementById(previewContainerId);

            previewContainer.innerHTML = ''; // Clear previous previews

            const files = input.files;
            if (files.length === 0) return;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const fileUrl = e.target.result;
                    const fileType = file.type;

                    let element;
                    if (fileType.startsWith('image/')) {
                        element = document.createElement('img');
                        element.src = fileUrl;
                        element.style.width = '150px';
                        element.style.margin = '5px';
                    } else if (fileType.startsWith('video/')) {
                        element = document.createElement('video');
                        element.src = fileUrl;
                        element.controls = true;
                        element.style.width = '300px';
                        element.style.margin = '5px';
                    }

                    if (element) {
                        previewContainer.appendChild(element);
                    }
                };

                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
