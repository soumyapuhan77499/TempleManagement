@extends('templeuser.layouts.app')

@section('styles')
<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">MANAGE SPECIAL RITUAL</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Temple</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ritual</li>
            </ol>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="table-responsive export-table">
                        <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">SL NO.</th>
                                    <th class="border-bottom-0">SPECIAL RITUAL NAME</th>
                                    <th class="border-bottom-0">DATE</th>
                                    <th class="border-bottom-0">TIME</th>
                                    <th class="border-bottom-0">IMAGE</th>
                                    <th class="border-bottom-0">VIDEO</th>
                                    <th class="border-bottom-0">DESCRIPTION</th>
                                    <th class="border-bottom-0">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($special_rituals as $index => $special_ritual)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $special_ritual->spcl_ritual_name }}</td>
                                        <td>{{ $special_ritual->spcl_ritual_date }}</td>
                                        <td>{{ $special_ritual->spcl_ritual_time }}</td>
                                        <td>{{ $special_ritual->spcl_ritual_period }}</td>
                                        <td>
                                            @if ($special_ritual->spcl_ritual_image)
                                                <a href="{{ asset($special_ritual->spcl_ritual_image) }}" target="_blank" class="btn btn-primary btn-sm">View Image</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($special_ritual->spcl_ritual_video)
                                                <a href="{{ asset($special_ritual->spcl_ritual_video) }}" target="_blank" class="btn btn-primary btn-sm">View Video</a>
                                            @endif
                                        </td>
                                        <td>{{ $special_ritual->description }}</td>
                                        <td>
                                            <form action="{{ route('delete.yearly-ritual', $special_ritual->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-md btn-danger"><i class="fa fa-trash"></i></button>
                                                <a href="{{ route('edit.yearly-ritual', $special_ritual->id) }}" class="btn btn-md btn-primary"><i class="fa fa-edit"></i></a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var successAlert = document.getElementById('successAlert');
                if (successAlert) {
                    var bootstrapAlert = new bootstrap.Alert(successAlert);
                    bootstrapAlert.close();
                }
            }, 4000); // 4000 milliseconds = 4 seconds
        });
    </script>
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
@endsection
