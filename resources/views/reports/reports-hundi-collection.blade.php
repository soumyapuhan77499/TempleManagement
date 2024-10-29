@extends('templeuser.layouts.app')

@section('styles')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sumoselect/sumoselect.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <style> 
        .text-center h3 {
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            color: #333;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
            display: inline-block;
            text-align: center;
            width: 100%;
        }
        </style>
        
@endsection

@section('content')
    <!-- breadcrumb -->

    <!-- row  -->
    <div class="row">
        <div class="col-12 col-sm-12 mt-4">
            <div class="card">
                <div class="card-body pt-0 pt-4">
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

                    <form id="hundiCollectionForm" method="POST" action="{{ route('templeuser.searchHundiCollection') }}">
                        @csrf
                        <div style="background-color: #FFBD5A; padding: 20px; text-align: center;">
                            <!-- Aligning and changing the font style of the H1 tag -->
                            <h1 style="font-family: 'Georgia', serif; font-weight: bold; color: #333;">HUNDI COLLECTION
                                REPORTS</h1>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="hundi_name">
                                        Hundi Name
                                    </label>
                                    <div class="d-flex align-items-center">
                                        <!-- Hundi Name Select Field -->
                                        <select class="form-control me-2" id="hundi_name" name="hundi_name" required>
                                            <option value="All">All</option>
                                            @foreach ($hundi_names as $hundi)
                                                <option value="{{ $hundi->hundi_name }}">{{ $hundi->hundi_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="from_date">From Date</label>
                                    <input type="date" class="form-control" id="from_date" name="from_date" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="to_date">To Date </label>
                                    <input type="date" class="form-control" id="to_date" name="to_date" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="mt-4 col-md-12 text-center">
                                        <button type="button" id="submitButton" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="col-md-12 text-center mt-4">
                        @if(isset($fromDate) || isset($toDate))
                            <h3 style="font-family: 'Arial', sans-serif; font-weight: bold; color: #090808;">
                                Hundi Collection Report 
                                @if($hundiName && $hundiName != 'All')
                                    for {{ $hundiName }}
                                @else
                                    for All Hundis
                                @endif
                                @if($fromDate && $toDate)
                                    from {{ $fromDate }} to {{ $toDate }}
                                @elseif($fromDate)
                                    from {{ $fromDate }}
                                @elseif($toDate)
                                    until {{ $toDate }}
                                @endif
                            </h3>
                        @endif
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            @if (isset($groupedCollections))
                            @foreach($groupedCollections as $hundiName => $hundiCollections)
                                <h4>{{ $hundiName }}</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="background-color: #4EC2F0;">Date</th>
                                            <th style="background-color: #4EC2F0;">Opened By</th>
                                            <th style="background-color: #4EC2F0;">Present Member</th>
                                            <th style="background-color: #4EC2F0;">Total Collection</th>
                                            <th style="background-color: #4EC2F0;">Cash Tray</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($hundiCollections->isNotEmpty())
                                            @foreach($hundiCollections as $collection)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($collection->hundi_open_date)->format('Y-m-d') }}</td>
                                                    <td>{{ $collection->opened_by }}</td>
                                                    <td>{{ $collection->present_member }}</td>
                                                    <td>{{ number_format($collection->total_collection, 2) }}</td>
                                                    <td>
                                                        <a href="{{ route('templeuser.collectionCashTray',  $collection->id) }}" class="btn btn-warning">Show</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <th colspan="3" class="text-right" style="font-weight: bold;">Grand Total for {{ $hundiName }}</th>
                                                <th style="font-size: 20px; font-weight: bold;">
                                                    {{ number_format($hundiCollections->sum('total_collection'), 2) }}
                                                </th>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">No data found for {{ $hundiName }}.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            @endforeach
                        @else
                            
                        @endif
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <!--Internal  Form-elements js-->
    <script src="{{ asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>
    <script src="{{ asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>

    <script>
        document.getElementById('submitButton').addEventListener('click', function() {
            document.getElementById('hundiCollectionForm').submit();
        });
    </script>

@endsection
