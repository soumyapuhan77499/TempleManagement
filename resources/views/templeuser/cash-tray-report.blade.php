@extends('templeuser.layouts.app')

@section('styles')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sumoselect/sumoselect.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">
@endsection

@section('content')
    <!-- breadcrumb -->

    <!-- row  -->
    <div class="row">
        <div class="col-12 col-sm-12 mt-4">
            <div class="card">
                <div class="card-body pt-0 pt-4">
                   
                      
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-12 col-sm-12">
                                        <div class="card">
                                            <div class="card-body pt-0">
                                                <div style="background-color: #FFBD5A; padding: 20px; text-align: center;">
                                                    <h1 style="font-family: 'Georgia', serif; font-weight: bold; color: #333;">CASH TRAY</h1>
                                                </div>
                                              
                            
                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="d-flex justify-content-between align-items-center w-100">
                                                                <h3 class="mb-0">{{ $collection->hundi_name }}</h3>
                                                                <p class="mb-0">Date: {{ \Carbon\Carbon::parse($collection->hundi_open_date)->format('Y-m-d') }}</p>
                                                            </div>
                                                        </div>
                                                        
                                                        
                            
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th style="background-color: #4EC2F0;">Cash Type</th>
                                                                    <th style="background-color: #4EC2F0;">No of Cash</th>
                                                                    <th style="background-color: #4EC2F0;">Total Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($collection->transactions as $transaction)
                                                                    <tr>
                                                                        <td>₹{{ number_format($transaction->cash_type, 2) }}</td>
                                                                        <td>{{ $transaction->no_of_cash }}</td>
                                                                        <td>₹{{ number_format($transaction->total_amount, 2) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th colspan="2">Grand Total</th>
                                                                    <th>₹{{ number_format($totalCollection, 2) }}</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
   
@endsection
