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
            <span class="main-content-title mg-b-0 mg-b-lg-1">Add Banner Image</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Banner Image</li>
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
    <!-- row  -->
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">

                <div class="card-body pt-0 pt-4">

                    <form method="POST" enctype="multipart/form-data" action="{{ route('templebanner.storeBanner') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="banner_image">Banner Image</label>
                                    <input type="file" class="form-control" id="banner_image" name="banner_image" >
                                       
                                    <small class="form-text text-red">
                                        For web banner image, the size is 1900x600 and for app banner image, the size is
                                        1000x400.
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="banner_type">Type<span style="color:red">*</span></label>
                                    <select name="banner_type" id="banner_type" class="form-control">
                                        <option value="web">Web</option>
                                        <option value="app">App</option>
                                        <option value="sub">Sub banner</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- New video upload field -->
                        <div class="form-group">
                            <label for="banner_video">Banner Video (optional)</label>
                            <input type="file" class="form-control" id="banner_video" name="banner_video"
                                accept="video/*">
                            <small class="form-text text-muted">Only .mp4, .mov, etc. Max size ~50MB.</small>
                        </div>

                        <div class="form-group">
                            <label for="banner_descp">Description</label>
                            <textarea name="banner_descp" class="form-control" id="banner_descp"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const bannerType = document.getElementById('banner_type');
            const bannerHelp = document.getElementById('bannerHelp');

            function updateBannerHelpText(value) {
                if (value === 'web') {
                    bannerHelp.innerText = 'For web banner image, the size is 1900x600.';
                } else if (value === 'app') {
                    bannerHelp.innerText = 'For app banner image, the size is 1000x400.';
                } else if (value === 'sub') {
                    bannerHelp.innerText = 'For sub banner image, the size is 800x300.'; // Example size
                } else {
                    bannerHelp.innerText = '';
                }
            }

            bannerType.addEventListener('change', function() {
                updateBannerHelpText(this.value);
            });

            // Initial set
            updateBannerHelpText(bannerType.value);
        });
    </script>
@endsection
