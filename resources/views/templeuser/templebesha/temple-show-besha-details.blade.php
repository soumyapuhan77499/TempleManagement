@extends('templeuser.layouts.app')

@section('styles')
    <style>
        .card {
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
            border-radius: 10px;
        }

        .card:hover {
            transform: scale(1.03);
        }

        .card-header {
            border-bottom: 2px solid #f1f1f1;
        }

        .breadcrumb-header {
            padding: 20px 15px;
            background-color: #f7f9fc;
            border-radius: 8px;
        }

        .breadcrumb li {
            font-size: 14px;
        }

        .modal-content {
            border-radius: 10px;
        }

        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
            transform: translate(0, -25%);
        }

        .modal.show .modal-dialog {
            transform: translate(0, 0);
        }
    </style>
@endsection

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <a href="{{ route('templeuser.showbesha') }}" class="btn btn-info text-white">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <h2 class="main-content-title mg-b-0 mg-b-lg-1">Besha Details</h2>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);"><i class="fas fa-home"></i> Dashboard</a></li>
                <li class="breadcrumb-item active tx-15" aria-current="page"><i class="fas fa-info-circle"></i> Besha
                    Details</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Special Besha Section -->
            <h3 class="text-center mb-4"><i class="fas fa-star"></i> Special Besha</h3>
            <div class="row">
                @forelse($beshas as $besha)
                    @if ($besha->special_day === 'yes')
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="card-title"><i class="fas fa-gem"></i> {{ $besha->besha_name }}</h5>
                                </div>
                                <div class="card-body">
                                    <p><i class="fas fa-calendar-alt"></i> <strong>Date:</strong> {{ $besha->date }}</p>
                                    <p><i class="fas fa-clock"></i> <strong>Estimated Time:</strong>
                                        {{ $besha->estimated_time }} minutes</p>
                                    <p><i class="fas fa-hourglass-half"></i> <strong>Total Time:</strong>
                                        {{ $besha->total_time }} minutes</p>
                                    <p><i class="fas fa-palette"></i> <strong>Dress Color:</strong>
                                        {{ $besha->dress_color }}</p>
                                    <p><i class="fas fa-box"></i> <strong>Items:</strong> {{ $besha->items }}</p>

                                    <p><i class="fas fa-book"></i> <strong>Booking Stauts:</strong> </p>

                                    <p><i class="fas fa-align-left"></i> <strong>Description:</strong>
                                        {{ $besha->description }}</p>

                                    <!-- Photos Modal -->
                                    <button class="btn btn-sm btn-secondary" data-bs-toggle="modal"
                                        data-bs-target="#viewImagesModal-{{ $besha->id }}">
                                        <i class="fas fa-eye"></i> View Images
                                    </button>

                                    <!-- Book Now Modal -->
                                    <button class="btn btn-sm btn-info book-now-btn" data-besha-id="{{ $besha->id }}">
                                        <i class="fas fa-book"></i>
                                        Book Now
                                    </button>

                                </div>
                            </div>
                        </div>

                        <!-- View Images Modal -->
                        <div class="modal fade" id="viewImagesModal-{{ $besha->id }}" tabindex="-1"
                            aria-labelledby="viewImagesModalLabel-{{ $besha->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="fas fa-images"></i> Images for Besha:
                                            {{ $besha->besha_name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @php
                                            $photos = explode(',', $besha->photos);
                                        @endphp
                                        @if (count($photos) > 0 && $besha->photos !== '')
                                            <div class="row">
                                                @foreach ($photos as $photo)
                                                    <div class="col-md-4 mb-3">
                                                        <img src="{{ asset('storage/' . $photo) }}"
                                                            class="img-fluid rounded" alt="Besha Image">
                                                    </div>
                                                @enforeach
                                            </div>
                                        @else
                                            <p class="no-data">No images available for this Besha.</p>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="bookBeshaModal-{{ $besha->id }}" tabindex="-1"
                            aria-labelledby="bookBeshaModalLabel-{{ $besha->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="fas fa-book"></i> Book Besha:
                                            {{ $besha->besha_name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('templeuser.bookbesha', $besha->id) }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="userName-{{ $besha->id }}" class="form-label">User
                                                            Name</label>
                                                        <input type="text" class="form-control"
                                                            id="userName-{{ $besha->id }}" name="user_name" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="gotra-{{ $besha->id }}"
                                                            class="form-label">Gotra</label>
                                                        <input type="text" class="form-control"
                                                            id="gotra-{{ $besha->id }}" name="gotra" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="mobile-{{ $besha->id }}"
                                                            class="form-label">Mobile</label>
                                                        <input type="text" class="form-control"
                                                            id="mobile-{{ $besha->id }}" name="mobile" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="paymentType-{{ $besha->id }}"
                                                            class="form-label">Payment
                                                            Type</label>
                                                        <select class="form-control" id="paymentType-{{ $besha->id }}"
                                                            name="payment_type" required>
                                                            <option value="credit_card">Credit Card</option>
                                                            <option value="debit_card">Debit Card</option>
                                                            <option value="net_banking">Net Banking</option>
                                                            <option value="upi">UPI</option>
                                                            <option value="cash">Cash</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="paymentAmount-{{ $besha->id }}" class="form-label">Payment
                                                    Amount</label>
                                                <input type="text" class="form-control"
                                                    id="paymentAmount-{{ $besha->id }}" name="payment_amount"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="paidBy-{{ $besha->id }}" class="form-label">Paid By</label>
                                                <input type="text" class="form-control" id="paidBy-{{ $besha->id }}" name="paid_by" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="address-{{ $besha->id }}"
                                                    class="form-label">Address</label>
                                                <textarea class="form-control" id="address-{{ $besha->id }}" name="address" rows="3" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description-{{ $besha->id }}"
                                                    class="form-label">Description</label>
                                                <textarea class="form-control" id="description-{{ $besha->id }}" name="description" rows="3"></textarea>
                                            </div>

                                            <button class="btn btn-sm btn-info book-now-btn"
                                                data-besha-id="{{ $besha->id }}"
                                                @if ($besha->is_booked) disabled @endif>
                                                <i class="fas fa-book"></i>
                                                @if ($besha->is_booked)
                                                    Booked
                                                @else
                                                    Book Now
                                                @endif
                                            </button>
                                            
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <p class="no-data">No Special Besha available for this day.</p>
                @endforelse
            </div>

            <!-- Normal Besha Section -->
            <h3 class="text-center my-4"><i class="fas fa-leaf"></i> Normal Besha</h3>
            <div class="row">
                @forelse($beshas as $besha)
                    @if ($besha->special_day !== 'yes')
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="card-title"><i class="fas fa-feather"></i> {{ $besha->besha_name }}</h5>
                                </div>
                                <div class="card-body">
                                    <p><i class="fas fa-calendar-day"></i> <strong>Day Name:</strong>
                                        {{ $besha->weekly_day }}</p>
                                    <p><i class="fas fa-clock"></i> <strong>Estimated Time:</strong>
                                        {{ $besha->estimated_time }} minutes</p>
                                    <p><i class="fas fa-hourglass-half"></i> <strong>Total Time:</strong>
                                        {{ $besha->total_time }} minutes</p>
                                    <p><i class="fas fa-palette"></i> <strong>Dress Color:</strong>
                                        {{ $besha->dress_color }}</p>
                                    <p><i class="fas fa-box"></i> <strong>Items:</strong> {{ $besha->items }}</p>
                                    <p><i class="fas fa-align-left"></i> <strong>Description:</strong>
                                        {{ $besha->description }}</p>

                                    <!-- Photos Modal -->
                                    <button class="btn btn-sm btn-secondary" data-bs-toggle="modal"
                                        data-bs-target="#viewImagesModal-{{ $besha->id }}">
                                        <i class="fas fa-eye"></i> View Images
                                    </button>
                                    <div class="modal fade" id="viewImagesModal-{{ $besha->id }}" tabindex="-1"
                                        aria-labelledby="viewImagesModalLabel-{{ $besha->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"><i class="fas fa-images"></i> Images for
                                                        Besha:
                                                        {{ $besha->besha_name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @php
                                                        $photos = explode(',', $besha->photos);
                                                    @endphp
                                                    @if (count($photos) > 0 && $besha->photos !== '')
                                                        <div class="row">
                                                            @foreach ($photos as $photo)
                                                                <div class="col-md-4 mb-3">
                                                                    <img src="{{ asset('storage/' . $photo) }}"
                                                                        class="img-fluid rounded" alt="Besha Image">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <p class="no-data">No images available for this Besha.</p>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <p class="no-data">No Normal Besha available for this day.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const bookNowButtons = document.querySelectorAll(".book-now-btn");

            bookNowButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const beshaId = this.getAttribute("data-besha-id");
                    const modalId = `#bookBeshaModal-${beshaId}`;

                    // Trigger the modal
                    const modal = new bootstrap.Modal(document.querySelector(modalId));
                    modal.show();
                });
            });


        });
    </script>
@endsection
