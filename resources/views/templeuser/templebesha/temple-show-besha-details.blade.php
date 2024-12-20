@extends('templeuser.layouts.app')

@section('content')
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <a href="{{ route('templeuser.showbesha') }}" class="btn btn-info text-white">BACK</a>

        <span class="main-content-title mg-b-0 mg-b-lg-1">Besha Details</span>
    </div>
    <div class="justify-content-center mt-2">
        <ol class="breadcrumb d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item active tx-15" aria-current="page">BESHA DETAILS</li>
        </ol>
    </div>
</div>
<div class="row">
    @forelse($beshas as $besha)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ $besha->besha_name }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Date:</strong>
                        </div>
                        <div class="col-6">
                            {{ $besha->date }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Estimated Time:</strong>
                        </div>
                        <div class="col-6">
                            {{ $besha->estimated_time }} minutes
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Time Period:</strong>
                        </div>
                        <div class="col-6">
                            {{ $besha->time_period }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Total Time:</strong>
                        </div>
                        <div class="col-6">
                            {{ $besha->total_time }} minutes
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Dress Color:</strong>
                        </div>
                        <div class="col-6">
                            {{ $besha->dress_color }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Special Day:</strong>
                        </div>
                        <div class="col-6">
                            {{ $besha->special_day }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Description:</strong>
                        </div>
                        <div class="col-6">
                            {{ $besha->description }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Items:</strong>
                        </div>
                        <div class="col-6">
                            @php
                                // Assuming 'items' column contains comma-separated values
                                $items = explode(',', $besha->items); // Convert string to array
                            @endphp
                            {{ implode(', ', $items) }} <!-- Join items array with commas -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Photos:</strong>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#viewImagesModal-{{ $besha->id }}">
                                <i class="fas fa-eye"></i> View Images
                            </button>
                            <div class="modal fade" id="viewImagesModal-{{ $besha->id }}" tabindex="-1" aria-labelledby="viewImagesModalLabel-{{ $besha->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Images for Besha: {{ $besha->besha_name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @php
                                                $photos = explode(',', $besha->photos); // Convert string to array
                                            @endphp

                                            @if (count($photos) > 0)
                                                <div class="row">
                                                    @foreach ($photos as $photo)
                                                        <div class="col-4 mb-2">
                                                            <img src="{{ asset('storage/' . $photo) }}" class="img-fluid" alt="Besha Image">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p>No images available for this Besha.</p>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <p>No Besha details found for this date.</p>
        </div>
    @endforelse
</div>


@endsection

@section('styles')
<style>
    .card-body {
        line-height: 1.6; /* Increased line height for better readability */
    }

    .row.mb-3 {
        margin-bottom: 1.5rem !important; /* Adds margin-bottom to each row for spacing */
    }

    .card-title {
        line-height: 1.5; /* Increased line height for title */
    }

    .btn-secondary {
        font-size: 0.9rem; /* Slightly smaller button text */
    }

    .modal-body img {
        border-radius: 5px; /* Adding some radius to the images for a smoother look */
    }
</style>
@endsection
